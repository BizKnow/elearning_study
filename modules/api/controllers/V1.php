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
                'course_name',
                'fees as amount',
                "CONCAT(duration, ' ', duration_type) AS duration",
                'referral_amount'
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
                    $this->response('data', $course->result_array());
                    $this->response('status', $course->num_rows() > 0);
                    $this->response('count', $course->num_rows());
                } else {
                    $this->response('error', 'Courses are not found.');
                }
            } catch (Exception $e) {
                $this->response('message', $e->getMessage());
            }
        }
    }
    function student_course()
    {
        if ($this->isPost()) {
            try {
                $id = $this->post('course_id');
                if ($id) {

                }
            } catch (Exception $e) {
                $this->response('message', $e->getMessage());
            }
        }
    }
    private function student_id()
    {
        $headers = $this->input->request_headers();//getallheaders();

        $received_token = isset($headers['Rainbowtoken']) ? $headers['Rainbowtoken'] : '';
        if($received_token == '')
            throw new Exception('Mission Rainbowtoken');
        $stored_token = $this->db->where([
            'token' => $received_token,
            'expired' => 0
        ])->get('api_tokens'); // Replace with DB call if needed
        if ($stored_token->num_rows() > 0) {
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
    function student_registration()
    {
        if ($this->isPost()) {
            if ($this->validation('student_registration')) {
                $data = [
                    'name' => $this->post('name'),
                    'email' => $this->post('email'),
                    'contact_number' => $this->post('mobile'),
                    'password' => sha1($this->post('password')),
                    'status' => 1
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
                            $this->response('error', 'Wrong Password.');
                    } else {
                        $this->response('error', 'Student Account is In-active.');
                    }
                } else {
                    $this->response('error', 'Wrong Mobile Number or Password.');
                }
            }
        }
    }
}