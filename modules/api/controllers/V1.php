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
        $headers = apache_request_headers();
        $received_token = isset($headers['Authorization']) ? $headers['Authorization'] : '';

        $stored_token = $this->session->userdata('token'); // Replace with DB call if needed

        if ($stored_token === $received_token) {
            return $this->session->userdata('student_id');
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
                            // $this->response('data', $row);
                            $token = bin2hex(random_bytes(32));
                            $this->session->set_userdata([
                                'token' => $token,
                                'student_id' => $row->student_id
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