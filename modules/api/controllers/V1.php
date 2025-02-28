<?php
class V1 extends Api_Controller
{
    private $select;
    function __construct()
    {
        /*
        verify referral code with token or course_id
        withdrawal request with token or fields
        withdrawal request list(s) with token

        */
        parent::__construct();
        $this->response = ['status' => false];
        $this->select = [
            'courses' => [
                'id',
                'course_name',
                'fees as amount',
                "CONCAT(duration, ' ', duration_type) AS duration",
                'referral_amount',
                'cashback_amount',
                'mrp',
                'image',
                "CONCAT('" . base_url('assets/file/') . "',image) as course_image",
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
    function withdrawal_request()
    {
        if ($this->isPost()) {
            $this->form_validation->set_rules('amount', 'Withdrawal Amount', 'required');
            if ($this->validation()) {
                $amountLimit = ES('withdrawal_amount_limit', 0);
                $amount = $this->post('amount');
                try {
                    $studentId = $this->student_id();
                    $bank = $this->db->where('student_id', $studentId)->get('student_banks')->num_rows();
                    if (!$bank)
                        throw new Exception('Please Update your KYC..');
                    $studentWallet = $this->student_model->get_student_via_id($studentId)->row('wallet') ?? 0;
                    if (!$studentWallet)
                        throw new Exception('you have no money in your wallet');
                    if ($studentWallet < $amount)
                        throw new Exception("You have only $studentWallet rupees in your wallet.");
                    if ($amountLimit <= $amount) {
                        // $this->response('error',"$amountLimit,$amount");
                        $student = $this->student_model->get_student_via_id($studentId)->row();
                        $data = [
                            'student_id' => $studentId,
                            'amount' => $amount
                        ];
                        $this->db->insert('withdrawal_requests', $data);
                        $this->set_data([
                            'STUDENT_NAME' => $student->student_name,
                            'MOBILE_NUMBER' => $student->contact_number,
                            'AMOUNT' => $amount,
                            'DATE' => date('d-m-Y'),
                            'ADMIN_LINK' => base_url('student/withdrawal-request/' . $this->token->encode(['id' => $this->db->insert_id()]))
                        ]);
                        $this->do_email('Rainboweduzone.fzd@gmail.com', 'Withdrawal Request', $this->template('email/withdrawal-request'));
                        $this->response('status', true);
                    } else
                        throw new Exception("You cannot withdraw less than Rs $amountLimit.");
                } catch (Exception $e) {
                    $this->response('message', $e->getMessage());
                }
            }
        }
    }
    function withdrawal_request_list()
    {
        if ($this->isPost()) {
            try {
                $student_id = $this->student_id();
                $list = $this->db->where('student_id', $student_id)->order_by('updatetime', 'DESC')->get('withdrawal_requests');
                $data = [];
                foreach ($list->result() as $row) {
                    $status = 'pending';
                    $payment_id = null;
                    $reason = null;
                    if ($row->status == '1') {
                        $status = 'accept';
                        $payment_id = $row->payment_id;
                    } else if ($row->status == '2') {
                        $status = 'reject';
                        $reason = $row->reason;
                    }
                    $data[] = [
                        'date' => date('d-m-Y', strtotime($row->timestamp)),
                        'order_id' => 'ORD' . strtotime($row->timestamp),
                        'amount' => $row->amount,
                        'update_time' => ($row->timestamp != $row->updatetime) ? date('d-m-Y', strtotime($row->updatetime)) : 'Pending..',
                        'status' => $status,
                        'payment_id' => $payment_id,
                        'reason' => $reason
                    ];
                }
                $this->response('status', true);
                $this->response('count', $list->num_rows());
                $this->response('data', $data);
            } catch (Exception $e) {
                $this->response('message', $e->getMessage());
            }
        }
    }
    private function get_referral_code($course_id, $student_id)
    {
        $chk = $this->db->where([
            'course_id' => $course_id,
            'student_id' => $student_id,
            'status' => 1
        ])->get('student_referral_code');
        if ($chk->num_rows())
            return $chk->row('code');
        return encode_ids($course_id, $student_id);
    }
    function verify_referral_code()
    {
        if ($this->isPost()) {
            try {
                $student_id = $this->student_id();
                $referral_code = $this->input->post('referral_code');
                $course_id = $this->post('course_id');
                // $check = $this->db->
                $check = $this->db->where([
                    'course_id' => $course_id,
                    'code' => $referral_code,
                    'status' => 1
                ])->where('student_id!=', $student_id)->get('student_referral_code');
                if ($check->num_rows()) {
                    $row = $check->row();
                    $this->response([
                        'status' => true,
                        'course_id' => $course_id,
                        'referral_id' => $row->student_id,
                        'referral_user' => $this->db->where('id', $row->student_id)->get('students')->row('name'),
                        'cashback_amount' => $this->db->select('cashback_amount')->where('id', $course_id)->get('course')->row('cashback_amount')
                    ]);
                } else {
                    $decode = decode_ids($referral_code);
                    if ($decode) {
                        $de_course_id = $decode[0];
                        $de_student_id = $decode[1];
                        if ($course_id != $de_course_id or $de_student_id == $student_id)
                            throw new Exception('Referral code invalid.');
                        $this->response([
                            'status' => true,
                            'course_id' => $de_course_id,
                            'referral_id' => $de_student_id,
                            'referral_user' => $this->db->where('id', $de_student_id)->get('students')->row('name'),
                            'cashback_amount' => $this->db->select('cashback_amount')->where('id', $de_course_id)->get('course')->row('cashback_amount')
                        ]);
                    } else
                        throw new Exception('Referral code invalid.');
                }
            } catch (Exception $e) {
                $this->response('message', $e->getMessage());
            }
        }
    }
    function razorpay()
    {
        $this->response('status', defined('RAZORPAY_KEY_ID') && defined('RAZORPAY_KEY_SECRET'));
        if (defined('RAZORPAY_KEY_ID'))
            $this->response('RAZORPAY_KEY_ID', RAZORPAY_KEY_ID);
        if (defined('RAZORPAY_KEY_SECRET'))
            $this->response('RAZORPAY_KEY_SECRET', RAZORPAY_KEY_SECRET);
    }
    function razorpay_order()
    {
        $this->load->module('razorpay');
        $order_id = $this->post('order_id');
        $this->response('orders', $this->razorpay->fetchOrder($order_id));
    }
    function razorpay_create_order()
    {
        if ($this->isPost()) {
            try {
                $student_id = $this->student_id();
                $course_id = $this->post('course_id');
                $get = $this->db->get_where('course', ['id' => $course_id]);
                if (!$get->num_rows())
                    throw new Exception('Invalid course id');
                $row = $get->row();
                $amount = $row->fees;
                $currency = 'INR';
                $this->load->module('razorpay');
                $razordata = [
                    'amount' => $amount * 100,
                    'receipt' => uniqid('RAINBOW'),
                    'currency' => 'INR',
                    'notes' => [
                        'student_id' => $student_id,
                        'course_id' => $course_id
                    ]
                ];
                $order = $this->razorpay->create_order($razordata, 'all');
                $this->response('status', true);
                $this->response('message', 'Successfully.');
                $this->response('order_id', $order['id']);
                $this->response('orders_data', $razordata);
                // $this->response('orders', $order);
                $this->response('keys', [
                    'key' => RAZORPAY_KEY_ID,
                    'secret' => RAZORPAY_KEY_SECRET
                ]);

            } catch (Exception $e) {
                $this->response('message', $e->getMessage());
            }
        }
    }
    function update_student_details()
    {
        if ($this->isPost()) {
            $student_id = $this->student_id();
            $name = $this->post('name');
            $this->db->where('id', $student_id);
            $this->db->update('students', ['name' => $name]);
            $this->response('status', true);
            $this->response('message', 'Student name updated successfully.');
        }
    }
    function update_student_profile()
    {
        if ($this->isPost()) {
            $student_id = $this->student_id();
            if (!empty($_FILES['image']['name'])) {
                $config['upload_path'] = './upload/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['max_size'] = 2048; // 2MB तक की फ़ाइल
                $config['file_name'] = time() . '_' . $_FILES['image']['name'];

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {
                    $uploadData = $this->upload->data();
                    $fileURL = base_url('uploads/' . $uploadData['file_name']);
                    $this->db->where('id', $student_id);
                    $this->db->update('students', ['image' => $uploadData['file_name']]);
                    $response = [
                        'status' => true,
                        'message' => 'Image uploaded successfully',
                        'file_url' => $fileURL
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'message' => $this->upload->display_errors()
                    ];
                }
            } else {
                $response = [
                    'status' => false,
                    'message' => 'No file uploaded'
                ];
            }
            $this->response($response);
        }

    }
    function wallet_record()
    {
        if ($this->isPost()) {
            try {
                $student_id = $this->student_id();
                $get = $this->db->select("FROM_UNIXTIME(sc.starttime) as course_start_time,
                ra.type,
                ra.amount as purchase_amount,
                sc.enrollment_no,
                sc.referral_id,
                sc.course_id,
                CASE 
                    WHEN ra.type = 'cashback' THEN 'You' 
                    ELSE s.name 
                END as name,
                CASE 
                    WHEN ra.type = 'cashback' THEN '' 
                    ELSE s.contact_number 
                END as contact_number")
                    ->from('refferal_amount as ra')
                    ->join('student_courses as sc', 'sc.id = ra.parent_id AND sc.status = 1')
                    ->join('students as s', 's.id = sc.student_id')
                    ->where("(sc.referral_id = $student_id AND ra.type = 'referral') OR (sc.student_id = $student_id AND ra.type = 'cashback' )")
                    ->order_by('sc.starttime', 'DESC')
                    ->get();
                if (!$get->num_rows())
                    throw new Exception('Record not found...');
                $this->response('status', true);
                $this->response('data', $get->result_array());
                $this->response('count', $get->num_rows());
            } catch (Exception $e) {
                $this->response('message', $e->getMessage());
            }
        }
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
                        $row['referral_code'] = $this->get_referral_code($row['id'], $student_id);
                        $getVideos = $this->db
                            ->select("sm.material_id,sm.idDemo as isDemo,sm.title,sm.description,sm.file as youtube_url")
                            ->where('sm.idDemo', 1)
                            ->where('sm.course_id', $row['id'])
                            ->order_by('sm.seq', 'ASC')
                            ->order_by('sm.material_id', 'ASC')
                            ->get('study_material as sm');
                        $row['demo_videos'] = [];
                        $row['is_subscribe'] = $this->db->where([
                            'student_id' => $student_id,
                            'course_id' => $row['id'],
                            'status' => 1
                        ])->get('student_courses')->num_rows() ? 1 : 0;
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
                $this->db->insert('student_courses', [
                    'student_id' => $student_id,
                    'course_id' => $course_id,
                    'enrollment_no' => $enrollment_no,
                    'starttime' => time(),
                    'referral_id' => $referral_id,
                    'added_via' => 'app',
                    'payment_id' => $this->post('payment_id'),
                    'status' => $this->post('payment_status'),
                    'amount' => $this->post('amount')
                ]);
                $lastId = $this->db->insert_id();
                // $query = $this->db->last_query();
                if ($referral_id && $this->post('payment_status')) {
                    $amount = $this->db->select('referral_amount')->where('id', $course_id)->get('course')->row('referral_amount');
                    $this->db->insert('refferal_amount', [
                        'parent_id' => $lastId,
                        'amount' => $amount
                    ]);
                    $this->increase_refer_amount($referral_id, $amount);
                    $amount = $this->db->select('cashback_amount')->where('id', $course_id)->get('course')->row('cashback_amount');
                    $this->db->insert('refferal_amount', [
                        'parent_id' => $lastId,
                        'amount' => $amount,
                        'type' => 'cashback'
                    ]);
                    $this->increase_refer_amount($student_id, $amount);
                }
                $this->response('enrollment_no', $enrollment_no);
                $this->response('message', 'Student course added successfully.');
                $this->response('status', true);
            }
        }
    }
    function live_notification()
    {
        if ($this->isGet()) {
            try {
                // $student_id = $this->student_id();
                $get = $this->db->select('title,description,url,starttime,endtime')->order_by('id', 'DESC')->get('live_notification');
                if ($get->num_rows()) {
                    $this->response([
                        'status' => true,
                        'message' => 'Live notification found.',
                        'data' => $get->result_array(),
                        'count' => $get->num_rows()
                    ]);
                } else
                    throw new Exception('Live notifications are not found.');
            } catch (Exception $e) {
                $this->response('message', $e->getMessage());
            }
        }
    }
    function whatsapp_no()
    {
        if ($this->isGet()) {
            $whatsapp = ES('recorded_video_send_on', 0);
            if ($whatsapp) {
                $this->response([
                    'status' => true,
                    'whatsapp_no' => $whatsapp
                ]);
            } else
                $this->response('message', 'Whatsapp no is not found..');
        }
    }
    function pages()
    {
        if ($this->isGet()) {
            // $get = $this->db->where('isMenu',1)->get('his_pages');
            try {
                $this->db->select('hp.page_name,hp.link as slug,hpc.content as html')
                    ->from('his_pages as hp')
                    ->join('his_page_content as hpc', 'hpc.page_id = hp.id AND hp.isMenu = 0 AND hp.status = 1');
                $message = 'Pages data not found.';
                if ($this->uri->segment(4, 0)) {
                    $this->db->where('hp.link', $this->uri->segment(4, 0));
                    $message = $this->uri->segment(4, 0) . ' page is not found';
                }
                $get = $this->db->order_by('hp.id', 'DESC')->get();
                if ($get->num_rows()) {
                    $this->response([
                        'status' => true,
                        'data' => $get->result_array()
                    ]);
                } else {
                    throw new Exception($message);
                }
            } catch (Exception $e) {
                $this->response('message', $e->getMessage());
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
                            WHEN type = 'whatsapp' THEN CONCAT('wa.me/91',value)
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
                                    c.mrp,
                                    c.course_name,
                                    c.fees as course_amount,
                                    c.cashback_amount,
                                    CONCAT(duration, ' ', duration_type) AS course_duration,
                                    c.image,
                                    CONCAT('" . base_url('assets/file/') . "',c.image) as course_image,
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
                $data = [];
                foreach ($get->result_array() as $row) {
                    $row['referral_code'] = $this->get_referral_code($row['course_id'], $id);
                    $data[] = $row;
                }
                $this->response('data', $data);
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
                    $this->db->order_by('sm.seq', 'ASC');
                    $this->db->order_by('sm.material_id', 'ASC');
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
                                    c.mrp,
                                    c.referral_amount,
                                    c.cashback_amount,
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
                            ->order_by('sm.seq', 'ASC')
                            ->order_by('sm.material_id', 'ASC')
                            ->get('study_material as sm');
                        $row['demo_videos'] = [];
                        $row['referral_code'] = $this->get_referral_code($row['course_id'], $studentId);
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
    function get_firebase_token()
    {
        if ($this->isPost()) {
            try {
                $mobile = $this->post('mobile');
                $get = $this->db->where('contact_number', $mobile)->get('students');
                if (!$get->num_rows())
                    throw new Exception('This Mobile number not exists..');
                $this->response('status', true);
                $this->response('firebase_token', $get->row('firebase_token'));
            } catch (Exception $e) {
                $this->response('message', $e->getMessage());
                $this->response('firebase_token', null);
            }
        }
    }
    function bank_kyc()
    {
        if ($this->isPost()) {
            try {
                $student_id = $this->student_id();
                $bank_name = $this->post('bank_name');
                $account_number = $this->post('account_number');
                $bank_ifsc = $this->post('bank_ifsc');
                $holder_name = $this->post('holder_name');
                $upi = $this->post("upi");
                $data = [
                    'bank_name' => $bank_name,
                    'account_number' => $account_number,
                    'ifsc_code' => $bank_ifsc,
                    'holder_name' => $holder_name,
                    'upi' => $upi
                ];
                $bank = $this->db->where('student_id', $student_id)->get('student_banks');
                if ($bank->num_rows()) {
                    throw new Exception('You can update your bank details only once.');
                } else {
                    $this->db->insert('student_banks', $data);
                    $this->response('status', true);
                    $this->response('message', 'Bank details updated successfully..');
                }
            } catch (Exception $e) {
                $this->response('message', $e->getMessage());
            }
        }
    }
    function update_firebase_token()
    {
        if ($this->isPost()) {
            try {
                $mobile = $this->post('mobile');
                $firebaseToken = $this->post('firebase_token');
                $get = $this->db->where('contact_number', $mobile)->get('students');
                if (!$get->num_rows())
                    throw new Exception('This Mobile number not exists..');
                $this->response('status', true);
                $this->db->where('id', $get->row('id'))->update('students', [
                    'firebase_token' => $firebaseToken
                ]);
                $this->response('firebase_token', $firebaseToken);
                $this->response('message', 'Token Updated Successfully..');
            } catch (Exception $e) {
                $this->response('message', $e->getMessage());
            }
        }
    }
    function get_student()
    {
        if ($this->isPost()) {
            try {
                $id = $this->student_id();
                if ($id) {
                    $student = $this->db->select([
                        'id as student_id',
                        'name',
                        "CONCAT('" . base_url('assets/file/') . "',image) as profile",
                        'contact_number as mobile',
                        'email',
                        'firebase_token',
                        'wallet'
                    ])->get_where('students', ['id' => $id]);
                    $bank = $this->db->select('
                        bank_name,
                        account_number,
                        ifsc_code,
                        holder_name,
                        upi
                    ')->where('student_id', $id)->get('student_banks');

                    $this->response('status', true);
                    $this->response('student', $student->row());
                    if ($bank->num_rows()) {
                        $this->response('bank', $bank->result_array());
                    } else {
                        $this->response('bank', [
                            'bank_name' => null,
                            'account_number' => null,
                            'ifsc_code' => null,
                            'holder_name' => null,
                            'upi' => null,
                        ]);
                    }
                } else
                    $this->response('message', 'Missing parameters.');
            } catch (Exception $e) {
                $this->response('message', $e->getMessage());
            }
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
                    'admission_type' => 'Online',
                    'firebase_token' => $this->post('firebase_token')
                ];
                $this->db->insert('students', $data);
                $student_id = $this->db->insert_id();
                $this->set_data([
                    'STUDENT_PROFILE_LINK' => base_url('student/profile/' . $student_id),
                    'STUDENT_NAME' => $data['name'],
                    'STUDENT_EMAIL' => $data['email'],
                    'STUDENT_PHONE' => $data['contact_number']
                ]);
                $this->do_email('rainbowstudentdata@gmail.com', 'New Student Registration', $this->template('email/student-register'));
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
    function login_token()
    {
        if ($this->isPost()) {
            $this->form_validation->set_rules('mobile', 'Mobile', 'required');
            if ($this->validation()) {
                $mobileNo = $this->post('mobile');
                $get = $this->student_model->get_student_mobile($mobileNo);
                if ($get->num_rows()) {
                    $row = $get->row();
                    $token = $this->generate_token($row->student_id);

                    $this->response('details', [
                        'name' => $row->student_name,
                        'email' => $row->email,
                        'mobile' => $row->contact_number,
                    ]);
                    $this->response('token', $token);
                    $this->response('status', true);
                } else
                    $this->response('message', 'Mobile no not found.');
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