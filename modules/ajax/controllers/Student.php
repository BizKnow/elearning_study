<?php
class Student extends Ajax_Controller
{
    function edit_form()
    {
        $this->response('form', 'Welcome');
        $this->response('url', 'Welcome');
        $this->response('status', true);
    }
    function change_admission_status()
    {
        // $this->response($this->post());
        $stuent_id = $this->post('student_id');
        $status = $this->post('type');
        $this->student_model->update_admission_status($stuent_id, $status);
        $this->response('status', true);
    }
    function search_by_roll_no()
    {
        $this->load->library('parser');
        // $this->response('roll_no',$this->post('roll_no'));
        $get = $this->student_model->get_student_via_roll_no($this->post('roll_no'));
        if ($get->num_rows()) {
            $this->response('status', true);
            $data = $get->row_array();
            $this->set_data($data);
            $this->set_data('admission_status', $data['admission_status'] ? label($this->ki_theme->keen_icon('verify text-white') . ' Verified Student') : label('Un-verified Student', 'danger'));
            $this->set_data('student_profile', $data['image'] ? base_url('upload/' . $data['image']) : base_url('assets/media/student.png'));
            $this->response('html', $this->template('student-profile-card'));
        } else
            $this->response('html', 'Student Not Found.');
    }
    function get_via_id()
    {
        $this->load->library('parser');
        $get = $this->student_model->get_student_via_id($this->post('student_id'));
        if ($get->num_rows()) {
            $this->response('status', true);
            $data = $get->row_array();
            $this->set_data($data);
            $this->set_data('admission_status', $data['admission_status'] ? label($this->ki_theme->keen_icon('verify text-white') . ' Verified Student') : label('Un-verified Student', 'danger'));
            $this->set_data('student_profile', $data['image'] ? base_url('upload/' . $data['image']) : base_url('assets/media/student.png'));
            $this->response('html', $this->template('student-profile-card'));
        } else
            $this->response('html', 'Student Not Found.');
    }
    function add()
    {
        $owner_id = $this->get_data('owner_id');
        if ($walletSystem = ((CHECK_PERMISSION('WALLET_SYSTEM') && $this->center_model->isCenter()))) {
            $deduction_amount = $this->ki_theme->get_wallet_amount('student_admission_fees');
            $close_balance = $this->ki_theme->wallet_balance();
            if ($close_balance < 0) {
                $this->response('html', 'Your Wallet Balance is Low..' . $close_balance);
                exit;
            }
        } elseif ($walletSystem = (CHECK_PERMISSION('WALLET_SYSTEM_COURSE_WISE') && $this->center_model->isCenter())) {
            $deduction_amount = $this->center_model->get_assign_courses(
                $this->post('center_id'),
                ['course_id' => $this->post('course_id')]
            )->row('course_fee');
            $close_balance = $this->ki_theme->wallet_balance();
            $close_balance = $close_balance - $deduction_amount;
            if ($close_balance < 0 or $close_balance < 0) {
                $this->response('html', 'Wallet Balance is Low..');
                exit;
            }
        }
        $cordinateArray = [];
        if (CHECK_PERMISSION('CO_ORDINATE_SYSTEM') && $this->center_model->isCenter()) {
            $get = $this->center_model->get_assign_courses($owner_id, ['course_id' => $this->post('course_id')], 'center');
            if ($get->num_rows()) {
                $getROw = $get->row();
                $cordinateArray = [
                    'user_id' => $getROw->added_by_id,
                    'commission' => $getROw->commission,
                    'course_id' => $this->post('course_id'),
                    'center_id' => $owner_id,
                    'course_fee' => $getROw->course_fee,
                    'percentage' => $getROw->percentage
                ];
                $courseFees = $getROw->course_fee;
                $close_balance = $this->ki_theme->wallet_balance();
                $close_balance = $close_balance - $courseFees;
                if ($close_balance < 0) {
                    $this->response('html', 'Wallet Balance is Low..' . $courseFees);
                    exit;
                }
            } else {
                $this->response('html', 'Course not Found.');
                exit;
            }
        }

        $data = $this->post();
        if (isset($data['referral_id'])) {
            $referral_id = $data['referral_id'];
            unset($data['referral_id']);
        }

        $data['status'] = 0;
        $data['added_by'] = isset($data['added_by']) ? $data['added_by'] : 'admin';
        $data['admission_type'] = isset($data['admission_type']) ? $data['admission_type'] : 'offline';
        // $data['type'] = 'center';
        $email = $data['email_id'];
        unset($data['email_id'], $data['upload_docs']);
        $data['email'] = $email;
        $upload_docs_data = [];
        $upload_docs = $this->post('upload_docs');
        if (isset($upload_docs['title'])) {
            foreach ($upload_docs['title'] as $index => $file_index_name) {
                if (!empty($_FILES['upload_docs']['name']['file'][$index])) {
                    $file = $_FILES['upload_docs']; //['file'][$index];
                    if ($file['error']['file'][$index] == UPLOAD_ERR_OK) {
                        $encryptedFileName = substr(hash('sha256', uniqid(mt_rand(), true)), 0, 10) . '_' . basename($file['name']['file'][$index]);
                        // Build the full destination path, including the encrypted file name
                        $destination = UPLOAD . $encryptedFileName;
                        move_uploaded_file($file['tmp_name']['file'][$index], $destination);
                        $upload_docs_data[$file_index_name] = $encryptedFileName;
                    }
                }
            }
        }
        if (isset($_POST['session_id']))
            $data['session_id'] = $_POST['session_id'];
        $data['adhar_front'] = $this->file_up('adhar_card');
        // $data['adhar_back'] = $this->file_up('adhar_back');
        $data['image'] = $this->file_up('image');
        $data['upload_docs'] = json_encode($upload_docs_data);
        $data['status'] = true;
        $data['admission_status'] = true;
        if ($this->form_validation->run()) {
            $this->db->insert('students', $data);
            $student_id = $this->db->insert_id();
            if ($walletSystem) {
                $data = [
                    'center_id' => $this->center_model->loginId(),
                    'amount' => $deduction_amount,
                    'o_balance' => ($close_balance + $deduction_amount),
                    'c_balance' => $close_balance,
                    'type' => 'admission',
                    'description' => 'Student Addmission',
                    'type_id' => $student_id,
                    'added_by' => 'center',
                    'order_id' => strtolower(generateCouponCode(12)),
                    'status' => 1,
                    'wallet_status' => 'debit'
                ];
                $this->db->insert('wallet_transcations', $data);
                $this->response('res', $this->db->insert_id());
                $this->center_model->update_wallet($data['center_id'], $close_balance);
            }
            if (CHECK_PERMISSION('CO_ORDINATE_SYSTEM') && $this->center_model->isCenter()) {
                $cordinateArray['type_id'] = $student_id;
                $this->db->insert('commissions', $cordinateArray);
            }
            if (CHECK_PERMISSION('REFERRAL_ADMISSION') && $this->center_model->isAdmin() && isset($_POST['referral_id'])) {
                $this->db->insert('referral_coupons', [
                    'student_id' => $student_id,
                    'coupon_code' => generateCouponCode(),
                    'coupon_by' => $referral_id,
                    'amount' => 500
                ]);
            }
            $this->response(
                'status',
                true
            );
        } else
            $this->response('html', $this->errors());

    }
    function genrate_a_new_rollno()
    {
        $rollNo = $this->gen_roll_no($this->post('center_id'));
        if ($rollNo) {
            $this->response("status", true);
            $this->response('roll_no', $rollNo);
        }
    }
    function get_center_courses()
    {
        $get = $this->center_model->get_assign_courses($this->post('center_id'));
        if ($get->num_rows()) {
            $this->response('courses', $get->result_array());
        }
    }
    function genrate_a_new_rollno_with_center_courses()
    {
        $this->genrate_a_new_rollno();
        $this->get_center_courses();
    }
    function online_list()
    {
        // $list = $this->db->where('admission_type','online')->get('students');
        // $list = $this->db->select('s.roll_no,s.contact_number,s.name,s.email,c.course_name,s.id as student_id,c.duration,c.duration_type')
        //         ->from('students as s')
        //         ->join("course as c","s.course_id = c.id AND s.admission_type = 'online'")
        //         ->get();
        $this->response('data', $this->student_model->get_online_student());
    }
    function passout()
    {
        $this->response('data', $this->student_model->get_passout_student());
    }
    function list()
    {
        $list = $this->student_model->get_all_student($this->post());
        $this->response('data', $list);
    }
    function upload_study_material()
    {
        // $this->ki_theme->set_default_vars('max_upload_size', 10485760); // 10MB
        // if ($file = $this->file_up('file')) {
        //     $this->response('status', true);
        //     $data = $this->post();
        //     $data['file'] = $file;
        //     $data['upload_by'] = $this->student_model->login_type();
        //     $this->db->insert('study_material', $data);
        // }
        if ($post = $this->input->post()) {
            $data = [
                'file_type' => $post['file_type'],
                'course_id' => $post['course_id'],
                'title' => $post['title'],
                'description' => $post['description'],
                'material_id' => time()
            ];
            if ($post['file_type'] == 'file') {
                $this->chunkUpload('study-mat');
                $data['file'] = $this->post('_file_name');
                if (isset($data['_file_name']))
                    unset($data['_file_name']);
            } else {
                $data['file'] = $this->post('youtube_link');
                unset($data['youtube_link']);
            }
            $data['upload_by'] = $this->student_model->login_type();
            if (isset($data['file']) and !empty($data['file']))
                $this->response('status', $this->db->insert('study_material', $data));
        }
    }
    function filter_for_select()
    {
        $this->response($this->post());
        $query = $this->post('q') ? $this->post('q') : '';
        $results[] = array(
            'id' => '',
            'student_name' => 'No matching records found',
            'disabled' => true
        );
        $get = $this->student_model->search_student_for_select2(['search' => $query]);
        if ($get->num_rows())
            $results = $get->result_array();
        $this->response('results', $results);
    }
    function study_material_for_demo(){
        $this->db->where([
            'id' => $this->post("id"),
            'file_type' => 'youtube'
        ])->update('study_material',['idDemo' => $this->post('status')]);
        $this->response('status',true);
    }
    function list_study_material()
    {
        $this->response('data', $this->student_model->study_materials()->result_array());
    }
    function delete_study_material($id)
    {
        $this->response('status', $this->db->where('material_id', $id)->delete('study_material'));
    }
    function assign_course()
    {

        $this->response('html', $this->set_data($this->post())->template('assign-course'));
    }
    function do_assign_course()
    {
        if ($this->student_model->student_course($this->post())->num_rows()) {
            $this->response('error', 'This course already assigned, please refresh page and check it..');
        } else {

            $this->response(
                'status',
                $this->student_model->add_student_course([
                    'student_id' => $this->post('student_id'),
                    'course_id' => $this->post('course_id'),
                    'starttime' => time(),
                    'status' => 1,
                    'enrollment_no' => $this->gen_roll_no(),
                    'added_via' => 'admin'
                ])
            );
        }
    }
}
