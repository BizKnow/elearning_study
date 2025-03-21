<?php
// 9996763445
class Website extends Ajax_Controller
{
    function delete_ref()
    {
        $id = $this->input->post('id');
        if ($id) {
            $this->db->where('id', $id);
            $this->db->delete('student_referral_code');
            $this->response([
                'status' => true
            ]);
        }
    }
    function add_referral_code()
    {
        if ($post = $this->input->post()) {
            $this->form_validation->set_rules('code', 'Referral Code', 'required|is_unique[student_referral_code.code]');
            if ($this->validation()) {
                $this->db->insert('student_referral_code', $post);
                $this->response([
                    'status' => true
                ]);
            }
        }
    }
    function update_course_payment()
    {
        $post = $this->post();

        $razorpay_payment_id = $post['razorpay_payment_id'];
        $razorpay_order_id = $post['razorpay_order_id'];
        $razorpay_signature = $post['razorpay_signature'];
        $merchant_order_id = $post['merchant_order_id'];
        $this->load->module('razorpay');

        try {

            $get = $this->db->where(['starttime' => $merchant_order_id, 'status' => 1])->get('student_courses');
            if ($get->num_rows()) {
                throw new Exception('Payment has already been updated');
            }

            $verifyPayment = $this->razorpay->verifyPayment($razorpay_payment_id, $razorpay_order_id, $razorpay_signature);
            if ($verifyPayment) {
                $status = $this->razorpay->fetchOrderStatus($razorpay_order_id);
                if ($status) {
                    $this->db->where(['starttime' => $merchant_order_id])
                        ->update('student_courses', [
                            'status' => 1,
                            'payment_id' => $razorpay_payment_id
                        ]);
                    $this->response('status', true);
                }

            }
        } catch (Exception $e) {
            $this->response('status', false);
            $this->response('error', $e->getMessage());
        }
    }
    function student_course_payment()
    {
        $server_token = $this->session->userdata('referral_token');
        $token = $this->post('token');
        try {
            if ($server_token == $token) {
                $data = $this->ki_theme->referral_data($token);
                $referral_id = $data['referral_id'] ?? 0;
                $time = time();
                $razordata = [
                    'receipt' => uniqid('RAINBOW'),
                    'currency' => 'INR',
                    'notes' => [
                        'student_id' => $this->student_model->studentId(),
                        'token' => $token
                    ]
                ];
                $this->load->module('razorpay');
                // pre($data);
                if (isset($data['course_id'])) {
                    $check = $this->db->get_where('student_courses', [
                        'student_id' => $data['student_id'],
                        'course_id' => $data['course_id']
                    ]);
                    if ($check->num_rows() > 0) {
                        $row = $check->row();
                        if ($row->status == 1)
                            throw new Exception('This Course already Purchased');
                        $order_id = $row->order_id;
                        $razordata['amount'] = $row->amount * 100;
                        $time = $row->starttime;
                    } else {
                        $getCourse = $this->db->get_where('course', ['id' => $data['course_id']]);
                        if ($getCourse->num_rows() > 0) {
                            $course = $getCourse->row();
                            $razordata['amount'] = $course->fees * 100;
                            $order_id = $this->razorpay->create_order($razordata);
                            $this->db->insert('student_courses', [
                                'student_id' => $data['student_id'],
                                'course_id' => $course->id,
                                'starttime' => $time,
                                // 'status' => 1,
                                'order_id' => $order_id,
                                'enrollment_no' => $this->gen_roll_no(),
                                'added_via' => 'web',
                                'referral_id' => $data['referral_id'],
                                'amount' => $course->fees
                            ]);
                        } else
                            throw new Exception('Selected course not found..');
                    }
                    $student = $this->db->where('id', $data['student_id'])->get('students');
                    $myData = [
                        'key' => RAZORPAY_KEY_ID,
                        'amount' => $razordata['amount'] * 100,
                        'name' => ES('title'),
                        'description' => 'Computer Institute',
                        'image' => logo(),
                        'prefill' => [
                            'name' => $student->name,
                            'email' => $student->email,
                            'contact' => $student->contact_number
                        ],
                        'notes' => [
                            'merchant_order_id' => $time,
                            'student_id' => $this->student_model->studentId()
                        ],
                        'order_id' => $order_id
                    ];
                    $this->response('status', true);
                    $this->response('amount', $razordata['amount']);
                    $this->response('option', $myData);
                    $this->response('rdata', $razordata);
                }
            }

        } catch (Exception $e) {
            $this->response('error', $e->getMessage());
        }
    }
    function forgot_password()
    {
        // $this->load->model('user_model');
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
                $this->response('status', true);
                $this->response('message', 'New password sent to your email ' . mask_email($row->email) . '.');
            } else {
                $this->response('message', 'Failed to send email.');
                $this->response('error_details', $this->email->print_debugger());
            }

        } catch (Exception $e) {
            $this->response('message', $e->getMessage());
        }
    }
    function verify_login_otp()
    {
        $student_id = $this->post("student_id");
        $otp = $this->post("otp");
        try {
            if (empty(trim($student_id)))
                throw new Exception('Something went wrong.');
            if (empty(trim($otp)))
                throw new Exception('Please Enter a valid OTP');
            $chk = $this->db->where([
                'student_id' => $student_id,
                'otp' => $otp
            ])->get('login_otp');
            if ($chk->num_rows()) {
                $row = $chk->row();
                if ($row->expired or $row->time < time())
                    throw new Exception('OTP expired');
                $session_id = session_id();
                $this->db->where('id', $student_id)->update('students', ['session_id' => $session_id]);
                $this->session->set_userdata([
                    'student_id' => $student_id,
                    'student_login' => true,
                    'session_id' => $session_id
                ]);
                $this->response([
                    'status' => true,
                    'message' => 'Login Successfully..'
                ]);
            } else
                throw new Exception('Invalid OTP');
        } catch (Exception $e) {
            $this->response('message', $e->getMessage());
        }
    }
    function login_with_email_otp()
    {
        if ($this->validation('student_login_form')) {
            $mobile = $this->input->post('mobile');
            $password = $this->input->post('password');
            $check = $this->db->where('contact_number', $mobile)->get('students');
            if ($check->num_rows()) {
                $row = $check->row();
                $encryptPass = sha1($password);
                if ($encryptPass == $row->password) {
                    $otp = mt_rand(111111, 999999);
                    $this->set_data([
                        'USER' => $row->name,
                        'OTP' => $otp
                    ]);
                    $this->db->where('student_id', $row->id)->update('login_otp', ['expired' => 1]);
                    $this->db->insert('login_otp', [
                        'student_id' => $row->id,
                        'time' => time() + (60 * 2),
                        'otp' => $otp
                    ]);
                    $this->do_email($row->email, 'Login Verification', $this->template('email/login-otp'));
                    $this->response([
                        'status' => true,
                        'student_id' => $row->id,
                        'message' => 'Enter the OTP sent to your email ' . mask_email($row->email) . ', OTP is for 2 minutes only.',
                    ]);
                } else {
                    $this->response('message', 'Entered Wrong Password.');
                }
            } else {
                $this->response('message', 'This mobile number is not exists..');
            }
        }
    }
    function withdrawal_amount()
    {
        // $this->form_validation->set_rules('amount', 'Amount', 'required|integer');
        if ($this->validation('withdrawal_amount')) {
            $amountLimit = ES('withdrawal_amount_limit', 0);
            $amount = $this->post('amount');
            try {
                $studentId = $this->student_model->studentId();
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
                    $studentId = $this->student_model->studentId();
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
                $this->response('error', $e->getMessage());
            }
        }
    }
    function update_student_profile_image()
    {
        $this->_update_profile('students');
    }
    function upload_gallery_image()
    {
        $this->response('data', $_FILES);
    }
    public function fetch_attendance()
    {
        $roll_no = $this->post('roll_no'); // Assuming student is logged in
        $this->db->select('sa.date, sa.attendance_type_id as status,at.type as title')
            ->from('student_attendances sa')
            ->join('attendence_type as at', 'sa.attendance_type_id = at.id')
            ->where('sa.roll_no', $roll_no);
        $query = $this->db->get();
        $attendance = $query->result_array();

        $data = array();
        foreach ($attendance as $row) {
            $data[] = array(
                'title' => ucfirst($row['title']),
                'type' => $row['status'],
                'start' => $row['date'],
                'color' => $this->get_status_color($row['status']) // Optional color for status
            );
        }

        $this->response('data', $data);
    }

    // Optional function to assign different colors for attendance status
    private function get_status_color($status)
    {
        switch ($status) {
            case '1':
                return '#28a745'; // Green
            case '4':
                return '#dc3545'; // Red
            case '3':
                return '#ffc107'; // Yellow
            default:
                return '#007bff'; // Default Blue
        }
    }
    private function _update_profile($table)
    {
        $this->response($_FILES);
        if ($file = $this->file_up('file')) {
            $this->response('status', true);
            $this->response('file', base_url('upload/' . $file));
            $this->db->update($table, [
                'image' => $file
            ], [
                'id' => $this->post('id')
            ]);
        }
    }
    function study_material_link()
    {
        if ($this->student_model->isStudent()) {
            $data = $this->post();
            $this->response('status', true);
            $this->response('token', $this->token->withExpire('+30 minutes')->encode($data));
        } else
            $this->response('error', 'Unautherised Student.');
    }
    function update_center_profile_image()
    {
        $this->_update_profile('centers');
    }
    function update_center_profile()
    {
        // $this->response('data',$this->session->userdata());
        $this->db->update('centers', [
            'name' => $this->post('name'),
            'center_full_address' => $this->post('address'),
            'contact_number' => $this->post('phone'),
            'email' => $this->post('email'),
        ], [
            'id' => $this->session->userdata('admin_id')
        ]);
        $this->response('status', true);
    }
    function student_verification()
    {
        if ($this->validation('website_student_verification')) {
            $this->response($this->post());
            $roll_no = $this->post('roll_no');
            $dob = $this->post("dob");
            $status = 1;
            $get = $this->student_model->student_verification([
                'roll_no' => $roll_no,
                'dob' => date('d-m-Y', strtotime($dob)),
                'status' => $status
            ]);
            if ($get->num_rows()) {
                // $this->response("get_student",$get->num_rows());
                $this->response('status', true);
                $data = $get->row_array();
                $this->set_data($data);
                $this->set_data('contact_number', maskMobileNumber($data['contact_number']));

                $this->set_data('admission_status', $data['admission_status'] ? label($this->ki_theme->keen_icon('verify text-white') . ' Verified Student') : label('Un-verified Student', 'danger'));
                $this->set_data('student_profile', $data['image'] ? base_url('upload/' . $data['image']) : base_url('assets/media/student.png'));
                $this->response('html', $this->template('student-profile-card'));
            } else {
                $this->response('error', '<div class="alert alert-danger">Student Not Found.</div>');
            }
        }
    }
    function seach_study_center_list()
    {
        $where = [
            'status' => 1,
            'state_id' => $this->post('state_id'),
            'city_id' => $this->post('city_id')
        ];
        $get = $this->center_model->get_verified($where);
        if ($get->num_rows()) {
            $this->response('status', true);
            $this->set_data('list', $get->result_array());
            $this->response('html', $this->template('study-center-list'));
        }
    }
    function center_verification()
    {
        $get = $this->center_model->get_verified($this->post());
        if ($get->num_rows()) {
            $row = $get->row();
            if ($row->status) {
                $data = $get->row_array();

                $this->response('status', 'yes');
                $this->response('center_number', $row->center_number);

                $this->set_data('center_status', $data['status'] ? label($this->ki_theme->keen_icon('verify text-white') . ' Verified Center') : label('Un-verified Center', 'danger'));
                $this->set_data('owner_profile', $data['image'] ? base_url('upload/' . $data['image']) : base_url('assets/media/student.png'));
                // unset($data['status']);
                $this->set_data($data);
                $this->set_data('contact_number', maskMobileNumber($data['contact_number']));
                $this->set_data('email', maskEmail($data['email']));

                $this->response('html', $this->template('center-details'));
            } else
                $this->response('status', 'no');
        }
    }
    function student_result_verification()
    {
        if ($this->validation('website_student_verification')) {

            $this->response($this->post());
            $roll_no = $this->post('roll_no');
            $dob = $this->post("dob");
            $status = 1;
            $get = $this->student_model->student_result_verification([
                'roll_no' => $roll_no,
                'dob' => date('d-m-Y', strtotime($dob)),
                'status' => $status
            ]);
            if ($get->num_rows()) {
                // $this->response("get_student",$get->num_rows());
                $this->response('status', true);
                $this->response('ttl_record', $get->num_rows());
                if ($get->num_rows() == 1) {
                    $data = $get->row_array();
                    $this->set_data($data);
                    $this->set_data('duration_type', (humnize($data['duration'], $data['duration_type'])));
                    $this->response('html', $this->template('marksheet-view'));
                    $this->response('data', $data);
                } else {
                    $html = '<div class="col-md-3"></div>
                    <div class="col-md-6">
                        <h4>List Of Results</h4>
                        <table class="table table-bordered">
                            <tr>
                                <th>Result</th>
                                <th>View</th>
                            </tr>
                        ';
                    foreach ($get->result() as $row) {
                        $token = $this->token->withExpire()->encode([
                            'id' => $row->marksheet_id
                        ]);
                        $url = base_url('marksheet-verification/' . $token);
                        $html .= '<tr>
                                    <td><a href="' . $url . '" target="_blank">' . humnize_duration_with_ordinal($row->marksheet_duration, $row->duration_type) . ' Result</a></td>
                                    <td>
                                        <a href="' . $url . '" target="_blank" class="btn btn-primary btn-xs btn-sm">View Result</a>
                                    </td>
                        </tr>';
                    }
                    $html .= '</table>
                    </div>';
                    $this->response('html', $html);
                }
            } else {
                $this->response('error', '<div class="alert alert-danger">Marksheet Not Found.</div>');
            }
        }
    }
    function genrate_a_new_rollno()
    {
        $rollNo = $this->gen_roll_no($this->post('center_id'));
        if ($rollNo) {
            $this->response("status", true);
            $this->response('roll_no', $rollNo);
        }
        return $rollNo;
    }
    function get_center_courses()
    {
        $get = $this->center_model->get_assign_courses($this->post('center_id'));
        if ($get->num_rows()) {
            $this->response('courses', $get->result_array());
        }
    }
    function genrate_rollno_for_admission()
    {
        $this->genrate_a_new_rollno();
        $this->get_center_courses();
    }
    function student_admission()
    {
        if ($this->validation('student_admission')) {
            // $this->response('status', true);
            // $roll_no = $this->genrate_a_new_rollno();
            // $this->response('roll_no', $roll_no);
            // $this->response($this->post());
            $data = $this->post();
            $token = 0;
            if (isset($data['token'])) {
                $token = $data['token'];
                $this->session->set_userdata('referral_token', $token);
                unset($data['token']);
            }
            $data['status'] = 0;
            // $data['roll_no'] = $roll_no;
            $data['added_by'] = isset($data['added_by']) ? $data['added_by'] : 'web';
            $data['admission_type'] = isset($data['admission_type']) ? $data['admission_type'] : 'offline';
            /*
            // $data['type'] = 'center';
            unset($data['upload_docs']);
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
            $data['adhar_front'] = $this->file_up('adhar_card');
            // $data['adhar_back'] = $this->file_up('adhar_back');
            $data['image'] = $this->file_up('image');
            $data['upload_docs'] = json_encode($upload_docs_data);
            */
            $data['image'] = $this->file_up('image');
            $data['password'] = sha1($data['password']);
            $data['status'] = 1;
            $data['session_id'] = session_id();
            $chk = $this->db->insert('students', $data);
            $this->set_data($this->post());
            $this->do_email($this->post('email'), 'Registration Successful', $this->template('email/new-registration'));
            $this->response('status', $chk);
            $this->response('url', base_url('checkout'));
            $this->session->set_userdata([
                'student_login' => true,
                'student_id' => $this->db->insert_id(),
                'session_id' => $data['session_id']
            ]);
        }
    }
    function get_city($type = 'array')
    {
        $state_id = $this->input->post('state_id');
        $cities = $this->db->order_by('DISTRICT_NAME', 'ASC')->get_where('district', ['STATE_ID' => $state_id]);
        $returnCity = [];
        $options = '<option></option>';
        if ($cities->num_rows()) {
            $this->response('status', true);
            foreach ($cities->result() as $row) {
                $returnCity[$row->DISTRICT_ID] = $row->DISTRICT_NAME;
                $options .= '<option value="' . $row->DISTRICT_ID . '">' . $row->DISTRICT_NAME . '</option>';
            }
        }
        $this->response('html', $type == 'array' ? $returnCity : $options);
    }
    function test()
    {
        $this->response('ok', true);
    }

    function contact_us_action()
    {
        $this->response(
            'status',
            $this->db->insert('contact_us_action', $this->input->post())
        );

    }
    function enquiry_update_status()
    {
        $this->response(
            'status',
            $this->db->where('id', $this->post('id'))->update('contact_us_action', ['admin_message' => $this->post('value')])
        );
    }
    function update_bank()
    {
        $student_id = $this->input->post('student_id');
        $data = $this->post();
        $check = $this->db->where('student_id', $student_id)->get('student_banks');
        $this->response('status', true);
        if ($check->num_rows()) {
            $this->db->where('student_id', $student_id)->update('student_banks', $data);
        } else {
            $this->db->insert('student_banks', $data);
        }
    }
    function add_center()
    {
        if ($this->validation('add_center')) {
            $data = $this->post();
            $data['status'] = 0;
            $data['added_by'] = 'admin';
            $data['type'] = 'center';
            $email = $data['email_id'];
            unset($data['email_id']);
            $data['email'] = $email;
            $data['password'] = sha1($data['password']);
            ///upload docs
            $data['adhar'] = $this->file_up('adhar');
            // $data['adhar_back'] = $this->file_up('adhar_back');
            $data['image'] = $this->file_up('image');
            $data['agreement'] = $this->file_up('agreement');
            $data['address_proof'] = $this->file_up('address_proof');
            $data['signature'] = $this->file_up('signature');
            if (CHECK_PERMISSION('CENTRE_LOGO'))
                $data['logo'] = $this->file_up('logo');
            $data['isPending'] = 1;
            $this->db->insert('centers', $data);
            $this->response('status', true);
        }
    }

    function update_stuednt_basic_details()
    {
        $id = $this->post('student_id');
        $data = $this->post();
        unset($data['student_id']);
        $this->db->update('students', $data, ['id' => $id]);
        $this->response('status', true);
        $this->response('student_data', $this->post());
    }
    function student_login_form()
    {
        // sleep(5);
        $rollno = $this->post('mobile');
        $password = $this->post('password');
        if ($this->validation('student_login_form')) {

            $this->response($this->post());
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
                        $this->session->set_userdata([
                            'student_login' => true,
                            'student_id' => $row->student_id
                        ]);
                        $this->response('student_name', $row->student_name);
                        $this->response('status', true);
                    } else
                        $this->response('error', alert('Wrong Password.', 'danger'));
                } else {
                    $this->response('error', alert('Your Account is In-active. Please Contact Your Admin', 'danger'));
                }
            } else {
                $this->response('error', alert('Wrong Mobile Number or Password.', 'danger'));
            }
        }
    }

    function update_stuednt_password()
    {
        if ($this->validation('change_password')) {
            $this->db->update('students', ['password' => sha1($this->post('password'))], [
                'id' => $this->post('student_id')
            ]);
            $this->session->unset_userdata('student_login');
            $this->response('status', true);
        }
    }
    function admit_card()
    {
        if ($this->validation('roll_no')) {
            // $this->response($this->post());
            $get = $this->student_model->admit_card($this->post());
            if ($get->num_rows()) {
                $this->response('status', true);
                $this->response('url', base_url('admit-card/' . $this->encode($get->row('admit_card_id'))));
            } else
                $this->response('error', 'Admit Card not found..');
        }
    }
    function certificate()
    {
        if ($this->validation('roll_no')) {
            // $this->response($this->post());
            $get = $this->student_model->student_certificates($this->post());
            if ($get->num_rows()) {
                $this->response('status', true);
                $this->response('url', base_url('certificate/' . $this->encode($get->row('certiticate_id'))));
            } else
                $this->response('error', 'Certificate not found..');
        }
    }
    function update_student_batch_and_roll_no()
    {
        $get = $this->db
            ->where('id!=', $this->post('student_id'))
            ->where('roll_no', $this->post("roll_no"))
            ->get('students');
        if ($get->num_rows()) {
            $this->response('error', 'This Roll Number already exists.');
        } else {
            $data = [
                'roll_no' => $this->post('roll_no'),
                // 'batch_id' => $this->post('batch_id'),
                'course_id' => $this->post('course_id'),
                'admission_date' => $this->post('admission_date')
            ];
            if (isset($_POST['batch_id']))
                $data['batch_id'] = $this->post('batch_id');
            if (isset($_POST['session_id']))
                $data['session_id'] = $this->post('session_id');
            $this->db->where('id', $this->post('student_id'))
                ->update('students', $data);
            $this->response("status", true);
        }
    }
    function edit_fee_record()
    {
        $get = $this->db->where('id', $this->post('fee_id'))->get('student_fee_transactions');
        $data = $get->row_array();
        $data['type'] = ucwords(str_replace('_', ' ', $data['type']));
        $this->set_data($data);
        $this->response('html', $this->template('edit-fee-record'));
    }
    function delete_fee_record()
    {
        $this->response('status', $this->db->where('id', $this->post('fee_id'))->delete('student_fee_transactions'));
    }
    function update_fee_record()
    {
        $data = [
            'amount' => $this->post('amount'),
            'payable_amount' => $this->post('payable_amount'),
            'discount' => $this->post('discount'),
            'payment_type' => $this->post('payment_type'),
            'payment_date' => $this->post('payment_date'),
            'description' => $this->post('description')
        ];
        $this->db->where('id', $this->post('id'))->update('student_fee_transactions', $data);
        $this->response('status', true);
    }
    function print_fee_record()
    {
        $this->init_setting();
        $record = $this->student_model->get_fee_transcations($this->post());
        $this->set_data($record->row_array());
        $this->set_data('record', $record->result_array());
        $this->response('html', $this->template('print-fee-record'));
    }

    function list_paper()
    {
        $data = $this->exam_model->student_exam($this->post());
        $row = $data->row();
        $this->set_data($data->row_array());
        $this->set_data('questions', $this->exam_model->get_shuffled_questions($row->exam_id, $row->max_questions));
        $this->response([
            'title' => $row->exam_title,
            'content' => $this->template('list-papers-questions')
        ]);
    }
    function submit_exam()
    {
        $mydata = $this->post('submitList') ? $this->post('submitList') : [];
        $data = [
            'attempt_time' => time(),
            'percentage' => $this->post('percentage'),
            'data' => json_encode($mydata),
            'ttl_right_answers' => $this->post('ttl_right_answers')
        ];

        // $this->response($data);
        $this->db->where('id', $this->post('student_exam_id'))
            ->update('exam_students', $data);
        $this->response('status', 'OK');

    }

    function update_center_docs()
    {
        $this->db->where('id', $this->post('center_id'))
            ->update('centers', [
                $this->post('name') => $this->file_up('file')
            ]);
        // $this->response('query', $this->db->last_query());
        $this->response('status', true);
    }
    function update_student_docs()
    {
        $data = [];
        if ($this->post('name') == 'adhar_card') {
            $data['adhar_front'] = $this->file_up('file');
        } else {
            $get = $this->db->select('upload_docs')->where('id', $this->post('student_id'))->get('students');
            $uploads_docs = $get->row('upload_docs');
            $uploads_docs = $uploads_docs == NULL ? [] : json_decode($uploads_docs, true);
            $uploads_docs[$this->post('name')] = $this->file_up('file');
            $data['upload_docs'] = json_encode($uploads_docs);
        }
        // $this->response('data',$data);
        $this->db->where('id', $this->post('student_id'))->update('students', $data);
        $this->response('status', true);
    }
    function list_syllabus()
    {
        $this->response('data', $this->db->order_by('id', 'DESC')->get('syllabus')->result_array());
    }
    function verify_student_phone_for_reset_password()
    {
        $get = $this->student_model->get_student([
            'contact_number' => $this->post('phoneNumber')
        ]);
        if ($get->num_rows()) {
            $row = $get->row();
            $templates = $this->load->config('api/sms', true);
            // pre($templates);
            if (isset($templates['forgot_password'])) {
                $message = $templates['forgot_password']['content'];
                $otp = random_int(100000, 999999);
                $this->session->set_userdata('forgot_password_otp', $otp);
                $message = str_replace('{#var#}', $otp, $message);
                // echo $message;
                $this->load->module('api/whatsapp');
                $res = $this->whatsapp->send('91' . $row->contact_number, $message);
                $this->response(json_decode($res, true));
                // $this->response(['status' => 'success','otp' => $otp]);
            }
        }
    }
    function generate_new_password_link()
    {
        if ($this->session->has_userdata('forgot_password_otp')) {
            if ($this->post('otp') == $this->session->userdata('forgot_password_otp')) {
                $get = $this->student_model->get_student([
                    'contact_number' => $this->post('phoneNumber')
                ]);
                if ($get->num_rows()) {
                    $row = $get->row();
                    // $this->session->set_userdata('student_id',$row->id);
                    $this->session->unset_userdata('forgot_password_otp');
                    $this->load->library('common/token');
                    $this->response([
                        'status' => 'success',
                        'url' => base_url('student/create-new-password/' . $this->token->encode([
                            'student_id' => $row->student_id
                        ]))
                    ]);
                }
            }
        }
        // $this->response($this->session->userdata());
    }

    function verify_student_phone()
    {
        $get = $this->student_model->get_student([
            'contact_number' => $this->post('phoneNumber')
        ]);
        if ($get->num_rows()) {
            $row = $get->row();
            $templates = $this->load->config('api/sms', true);
            // pre($templates);
            if (isset($templates['login_with_otp'])) {
                $message = $templates['login_with_otp']['content'];
                $otp = random_int(100000, 999999);
                $this->session->set_userdata('login_otp', $otp);
                $message = str_replace('{#var#}', $otp, $message);
                // echo $message;
                $this->load->module('api/whatsapp');
                $res = $this->whatsapp->send('91' . $row->contact_number, $message);
                $this->response(json_decode($res, true));
                // $this->response(['status' => 'success']);
            }
        }
    }
    function delete_notification()
    {
        $this->response(
            'status',
            $this->db->where($this->post())->delete('manual_notifications')
        );
    }
    function send_notification()
    {
        $isCenter = $this->center_model->isCenter();
        $data = [
            'title' => $this->post('title'),
            'send_time' => time(),
            'notify_type' => $this->post('notify_type'),
            'content' => $_POST['message'],
            'receiver_id' => $this->post('receiver_id'),
            'receiver_user' => $this->post('type'),
            'sender_id' => $isCenter ? $this->center_model->loginId() : 0,
            'send_by' => $isCenter ? 'center' : 'admin'
        ];
        $this->response('status', $this->db->insert('manual_notifications', $data));
    }
    function view_notification()
    {
        $html = '';
        $get = $this->db->get_where('manual_notifications', ['id' => $this->post('id')]);
        if ($get->num_rows()) {
            $row = $get->row();
            if (($this->student_model->isStudent() && $row->receiver_user == 'student') or ($this->center_model->isCenter() && $row->receiver_user == 'center'))
                $this->db->set('seen', 'seen + 1', false)->where('id', $row->id)->update('manual_notifications');

            $html .= '<div class="card card-flush">
                        <div class="card-header">
                            <h3 class="card-title">' . $row->title . '</h3>
                        </div>
                        <div class="card-body">
                            ' . $row->content . '
                        </div>    
                        <div class="card-footer">
                            <div class="d-fl    ex flex-stack flex-wrap gap-2 py-5 ps-8 pe-5">
                                <div class="d-flex align-items-center me-3">
                                    
                                </div>
                                <div class="d-flex align-items-center text-primary">
                                    <i class="ki-duotone ki-time text-primary fs-3">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i> &nbsp;' . date('d-m-Y h:i A', $row->send_time) . '
                                </div>
                            </div>
                        </div>
            </div>';
            $this->response('status', true);
        } else
            $html .= alert('Something went wrong, can\'t view this message.', 'danger');
        $this->response('html', $html);
    }
    function factuly_update()
    {
        $this->db->where('id', $this->post('id'))
            ->update('content', [
                'field2' => $this->post('title'),
                'field4' => $this->post('link')
            ]);
        $this->response('status', true);
    }
}
?>