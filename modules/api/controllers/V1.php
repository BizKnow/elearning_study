<?php
class V1 extends Api_Controller
{
    private $select;
    function __construct()
    {
        parent::__construct();
        $this->response = ['status' => false];
        $this->select = [
            'courses' => [
                'id',
                'course_name',
                'fees as amount',
                "CONCAT(duration, ' ', duration_type) AS duration",
                'referral_amount',
                'image',
                'description',
                "CASE 
                    WHEN duration_type = 'year' THEN duration * 365
                    WHEN duration_type = 'semester' THEN duration * 182
                    WHEN duration_type = 'month' THEN duration * 30
                    ELSE NULL
                END AS total_days"
            ]
        ];
    }
    private function select($type)
    {
        if (isset($this->select[$type])) {
            return $this->db->select($this->select[$type]);
        }
    }
    function get_students()
    {
        if ($this->isGet()) {
            $students = $this->db->get('students');
            $this->response('data', $students->result_array());
            $this->response('status', $students->num_rows() > 0);
            $this->response('count', $students->num_rows());
        }
    }
    function courses()
    {
        if ($this->isGet()) {
            try {
                $student_id = $this->student_id();
                $course = $this->select(__FUNCTION__)->get('course');
                if ($course->num_rows() > 0) {
                    $data = [];
                    foreach ($course->result_array() as $row) {
                        $getVideos = $this->db
                            ->select("sm.material_id,sm.idDemo as isDemo,sm.title,sm.description,sm.file as youtube_url")
                            ->where('sm.idDemo', 1)
                            ->where('sm.course_id', $row['id'])
                            ->get('study_material as sm');
                        $row['demo_videos'] = [];
                        if ($getVideos->num_rows()) {
                            $videData = [];
                            foreach ($getVideos->result_array() as $video) {
                                $video['videoId'] = getYouTubeId($video['youtube_url']);
                                $videData[] = $video;
                            }
                            $row['demo_videos'] = $videData;
                        }
                        $data[] = $row;
                    }

                    $this->response('data', $data);
                    $this->response('status', $course->num_rows() > 0);
                    $this->response('count', $course->num_rows());
                } else {
                    $this->response('message', 'Courses are not found.');
                }
            } catch (Exception $e) {
                $this->response('message', $e->getMessage());
            }
        }
    }
    function add_student_course()
    {
        if ($this->isPost()) {
            $student_id = $this->student_id();
            if ($this->validation(__FUNCTION__)) {
                $course_id = $this->post('course_id');
                $referral_id = $this->post('referral_id', 0);
                $enrollment_no = $this->gen_roll_no();
                $this->db->insert('students_courses', [
                    'student_id' => $student_id,
                    'course_id' => $course_id,
                    'enrollment_no' => $enrollment_no,
                    'referral_id' => $referral_id,
                    'added_via' => 'app',
                    'payment_id' => $this->post('payment_id'),
                    'status' => $this->post('payment_status'),
                    'amount' => $this->post('amount')
                ]);
                $lastId = $this->db->insert_id();
                if ($referral_id && $this->post('payment_status')) {
                    $amount = $this->db->select('referral_amount')->where('id', $course_id)->get('course')->row('referral_amount');
                    $this->db->insert('refferal_amount', [
                        'parent_id' => $lastId,
                        'amount' => $amount
                    ]);
                    $this->increase_refer_amount($referral_id, $amount);
                }
                $this->response('enrollment_no', $enrollment_no);
                $this->response('message', 'Student course added successfully.');
                $this->response('status', true);
            }
        }
    }
    function supports()
    {
        if ($this->isGet()) {
            try {
                $get = $this->db->select("title,value,type,CASE 
                            WHEN type = 'mobile' THEN CONCAT('tel:',value)
                            WHEN type = 'email' THEN CONCAT('mailto:',value)
                            ELSE value
                            END AS url")
                    ->get('supports');
                $this->response('data', $get->result_array());
                $this->response('status', $get->num_rows() > 0);
                $this->response('count', $get->num_rows());

            } catch (Exception $e) {
                $this->response('message', $e->getMessage());
            }
        }
    }
    function reset_password()
    {
        if ($this->isPost()) {
            if ($this->validation('reset_password')) {
                $mobile_or_email = $this->post('mobile_or_email');
                try {
                    $get = $this->db->where('email', $mobile_or_email)
                        ->or_where('contact_number', $mobile_or_email)
                        ->get('students');
                    if (!$get->num_rows())
                        throw new Exception("$mobile_or_email does not exists..");
                    $row = $get->row();
                    if (empty($row->email))
                        throw new Exception('Email does not exists on this account');
                    if (!isValidEmail($row->email))
                        throw new Exception($row->email . ' is not a valid email, please contact your administrator. ');
                    $pass = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 6);
                    $this->db->where('id', $row->id)->update('students', [
                        'password' => sha1($pass)
                    ]);
                    $this->set_data([
                        'NEW_PASSWORD' => $pass,
                        'USERNAME' => $row->name,
                        'APP_DOWNLOAD_URL' => 'https://play.google.com/store/apps/details?id=com.rainbow.eduzone',
                        'MOBILE_NUMBER' => $row->contact_number,
                        'LOGIN_URL' => 'https://appedu.rainboweduzone.com/student-login'
                    ]);
                    $html = $this->template('email/new-password');
                    $sent = $this->do_email($row->email, 'Password Reset', $html);
                    if ($sent) {
                        $this->response('message', 'New password sent to your email ' . mask_email($row->email) . '.');
                    } else {
                        $this->response('message', 'Failed to send email.');
                        $this->response('error_details', $this->email->print_debugger());
                    }

                } catch (Exception $e) {
                    $this->response('message', $e->getMessage());
                }
            }
        }
    }
    function increase_refer_amount($referral_id, $amount)
    {
        $this->db->set('wallet', 'wallet+' . $amount, FALSE)->where('id', $referral_id);
        $this->db->update('students');
    }
    function student_course()
    {
        if ($this->isPost()) {
            try {
                $course_id = $this->post('course_id');
                $id = $this->student_id();
                $this->db->select("c.id as course_id,
                                    c.course_name,
                                    c.fees as course_amount,
                                    CONCAT(duration, ' ', duration_type) AS course_duration,
                                    c.image as course_image,
                                    c.description as course_description,
                                    sc.enrollment_no,
                                    FROM_UNIXTIME(sc.starttime) as course_start_time,
                                    sc.status as purchase_status,
                                    CASE 
                                        WHEN c.duration_type = 'year' THEN duration * 365
                                        WHEN c.duration_type = 'semester' THEN duration * 182
                                        WHEN c.duration_type = 'month' THEN duration * 30
                                        ELSE NULL
                                    END AS total_days,
                                    CASE 
                                        WHEN c.duration_type = 'semester' THEN FROM_UNIXTIME(sc.starttime + (c.duration * 182 * 86400))
                                        WHEN c.duration_type = 'month' THEN FROM_UNIXTIME(sc.starttime + (c.duration * 30 * 86400))
                                        WHEN c.duration_type = 'year' THEN FROM_UNIXTIME(sc.starttime + (c.duration * 365 * 86400))
                                        ELSE FROM_UNIXTIME(sc.starttime)
                                    END AS course_end_time");
                $this->db->from('student_courses as sc');
                $this->db->join('course as c', 'c.id = sc.course_id');
                $this->db->where('sc.student_id', $id);
                if ($course_id) {
                    $this->db->where('sc.course_id', $course_id);
                }
                $get = $this->db->get();
                $this->response('data', $get->result_array());
                $this->response('status', $get->num_rows() > 0);
                $this->response('count', $get->num_rows());
            } catch (Exception $e) {
                $this->response('message', $e->getMessage());
            }
        }
    }
    function study_material()
    {
        if ($this->isPost()) {
            try {
                $studentId = $this->student_id();
                $course_id = $this->post('course_id');
                $materialId = $this->post('material_id', 0);
                $isDemo = $this->post('isDemo', 0);
                if ($course_id) {
                    $this->db->select('sm.material_id, sm.file,sm.file_type as type, sm.idDemo as isDemo,sm.title,sm.description');
                    $this->db->from('study_material as sm');
                    $this->db->join('student_courses as s', 's.course_id = sm.course_id');
                    $this->db->where('sm.course_id', $course_id);
                    $this->db->where('s.student_id', $studentId);
                    // $this->db->where('sm.idDemo', 0);
                    if ($this->post('type'))
                        $this->db->where('sm.file_type', $this->post('type'));
                    if ($materialId)
                        $this->db->where('sm.material_id', $this->post('material_id'));
                    if ($isDemo)
                        $this->db->where('sm.idDemo', $isDemo);
                    $get = $this->db->get();
                    // $this->response('data', $get->result_array());
                    $data = [];
                    if ($get->num_rows()) {
                        foreach ($get->result_array() as $study) {
                            if ($study['type'] == 'youtube') {
                                $study['videoId'] = getYouTubeId($study['file']);
                                $study['youtube_url'] = $study['file'];
                                unset($study['file']);
                            }
                            if ($study['type'] == 'file')
                                $study['url'] = base_url('assets/file/study-mat/' . $study['file']);
                            $data[] = $study;
                        }

                    }
                    $this->response('data', $data);

                } else
                    $this->response('message', 'Missing Course ID ..');
            } catch (Exception $e) {
                $this->response('message', $e->getMessage());
            }
        }

    }
    function non_purchase_course()
    {
        if ($this->isPost()) {
            try {
                $studentId = $this->student_id();
                $this->db->select("c.id as course_id,
                                    c.course_name,
                                    c.fees as course_amount,
                                    CONCAT(duration, ' ', duration_type) AS course_duration,
                                    CONCAT('" . base_url('assets/file/') . "',c.image) as course_image,
                                    c.description as course_description,
                                    CASE 
                                        WHEN c.duration_type = 'year' THEN duration * 365
                                        WHEN c.duration_type = 'semester' THEN duration * 182
                                        WHEN c.duration_type = 'month' THEN duration * 30
                                        ELSE NULL
                                    END AS total_days");
                $this->db->from('course as c');
                $this->db->join(
                    'student_courses as sc',
                    'sc.course_id = c.id and sc.status = 1 and sc.student_id = ' . $studentId,
                    'left'
                );
                $this->db->where('sc.course_id IS NULL');
                $get = $this->db->get();
                $data = [];
                if ($get->num_rows()) {
                    foreach ($get->result_array() as $row) {
                        $getVideos = $this->db
                            ->select("sm.material_id,sm.idDemo as isDemo,sm.title,sm.description,sm.file as youtube_url")
                            ->where('sm.idDemo', 1)
                            ->where('sm.course_id', $row['course_id'])
                            ->get('study_material as sm');
                        $row['demo_videos'] = [];
                        if ($getVideos->num_rows()) {
                            $videData = [];
                            foreach ($getVideos->result_array() as $video) {
                                $video['videoId'] = getYouTubeId($video['youtube_url']);
                                $videData[] = $video;
                            }
                            $row['demo_videos'] = $videData;
                        }
                        $data[] = $row;
                    }
                }
                $this->response('data', $data);
                $this->response('status', $get->num_rows() > 0);
                $this->response('count', $get->num_rows());
            } catch (Exception $e) {
                $this->response('message', $e->getMessage());
            }
        }
    }
    private function student_id()
    {
        $headers = $this->input->request_headers();//getallheaders();

        $received_token = isset($headers['Rainbowtoken']) ? $headers['Rainbowtoken'] : '';
        if ($received_token == '')
            throw new Exception('Missing Rainbowtoken');
        $stored_token = $this->db->where([
            'token' => $received_token,
            'expired' => 0
        ])->get('api_tokens'); // Replace with DB call if needed
        if ($stored_token->num_rows() > 0) {
            $this->db->set('uses', 'uses+1', FALSE)->where('api_id', $stored_token->row('api_id'))->update('api_tokens');
            return $stored_token->row('student_id');
        } else
            throw new Exception('Token Expired.');
    }
    function get_student()
    {
        try {
            $id = $this->student_id();
            if ($id) {
                $student = $this->db->select([
                    'id as student_id',
                    'name',
                    'father_name',
                    'contact_number as mobile',
                    'email'
                ])->get_where('students', ['id' => $id]);
                $this->response('status', true);
                $this->response('student', $student->row());
            } else
                $this->response('message', 'Missing parameters.');
        } catch (Exception $e) {
            $this->response('message', $e->getMessage());
        }
    }
    private function generate_token($student_id)
    {
        $token = bin2hex(random_bytes(32));
        $this->db->set('expired', 1)->where('student_id', $student_id)->update('api_tokens');
        $this->db->insert('api_tokens', [
            'student_id' => $student_id,
            'token' => $token
        ]);
        return $token;
    }
    function update_password()
    {
        if ($this->isPost()) {
            try {
                if ($this->validation('update_password')) {
                    $student_id = $this->student_id();
                    $password = $this->input->post('password');
                    $get = $this->db->select('name,email,contact_number as mobile')->where('id', $student_id)->get('students');
                    if ($get->num_rows() > 0) {
                        $this->db->where('id', $student_id)->update('students', [
                            'password' => sha1($password)
                        ]);
                        $this->response('token', $this->generate_token($student_id));
                        $this->response('status', true);
                        $this->response('details', $get->result_array());
                        $this->response('message', 'Password updated successfully.');
                    }
                }
            } catch (Exception $r) {
                $this->response('message', $r->getMessage());
            }
        }
    }
    function student_registration()
    {
        if ($this->isPost()) {
            if ($this->validation('student_registration')) {
                $data = [
                    'name' => $this->post('name'),
                    'email' => $this->post('email'),
                    'contact_number' => $this->post('mobile'),
                    'password' => sha1($this->post('password')),
                    'status' => 1,
                    'added_by' => 'APP',
                    'admission_type' => 'Online'
                ];
                $this->db->insert('students', $data);
                $student_id = $this->db->insert_id();
                $this->response('status', true);
                // $token = bin2hex(random_bytes(32));
                $token = $this->generate_token($student_id);
                unset($data['password']);
                $data['mobile'] = $data['contact_number'];
                unset($data['contact_number']);
                unset($data['status']);
                $this->response('token', $token);
                $this->response('details', $data);
                $this->response('message', 'Student Registration Successfully...');
            }
        }
    }
    function student_login()
    {
        if ($this->isPost()) {
            if ($this->validation('student_login')) {
                $rollno = $this->post('mobile');
                $password = $this->post('password');
                $get = $this->student_model->get_student_mobile($rollno);
                if ($get->num_rows()) {
                    $row = $get->row();
                    if ($row->student_profile_status) {
                        if (!($stdPassword = $row->password)) {
                            $name = $row->student_name;
                            $dobYear = date('Y', strtotime($row->dob));
                            $stdPassword = strtoupper(substr($name, 0, 2) . $dobYear);
                            $stdPassword = sha1($stdPassword);
                        }
                        if ($stdPassword == sha1($password)) {

                            $token = $this->generate_token($row->student_id);

                            $this->response('details', [
                                'name' => $row->student_name,
                                'email' => $row->email,
                                'mobile' => $row->contact_number,
                            ]);
                            $this->response('token', $token);
                            $this->response('status', true);
                        } else
                            $this->response('message', 'Wrong Password.');
                    } else {
                        $this->response('message', 'Student Account is In-active.');
                    }
                } else {
                    $this->response('message', 'Wrong Mobile Number or Password.');
                }
            }
        }
    }
}