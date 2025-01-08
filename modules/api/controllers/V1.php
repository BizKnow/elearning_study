<?php
class V1 extends Api_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->response = ['status' => false];
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
    function get_student()
    {
        if ($this->isPost()) {
            $id = $this->post();
            // $this->allow_destruct = false;
            if ($id) {
                $student = $this->db->get_where('students', $id);
                $this->response('status', true);
                $this->response('data', $student->row());
            } else
                $this->response('message', 'Missing parameters.');
        }
    }
    function student_login()
    {
        if ($this->isPost()) {
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
                        $this->response('data', $row);
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