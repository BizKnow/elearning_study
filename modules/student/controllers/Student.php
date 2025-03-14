<?php
class Student extends MY_Controller
{
    function index()
    {
        if ($this->student_model->isStudent())
            $this->student_view('index', ['isValid' => true]);
        else
            redirect('student/dashboard');
    }
    function wallet()
    {
        $this->student_view('wallet', ['isValid' => true]);
    }
    function withdrawal_request()
    {        
        if ($this->uri->segment(3, 0)) {
            $this->ki_theme->breadcrumb_action_html(
                $this->ki_theme->set_class('btn btn-primary')->add_action('List All Request(s)', ('student/withdrawal-request'))
            );
        }
        $this->view('withdrawal-request', ['isValid' => true]);
    }
    function withdrawal_amount()
    {
        $this->student_view('withdrawal-amount', ['isValid' => true]);
    }
    function purchase_combo()
    {
        $this->access_method();
        try {
            $token = $this->uri->segment(3, 0);
            $this->token->decode($token);
            $this->student_view('purchase-combo', $this->token->data());
        } catch (Exception $e) {
            $this->student_view('purchase-combo', [
                'error' => $e->getMessage(),
            ]);
        }
    }
    function refer_to_earn()
    {
        $this->access_method();
        $this->student_view('refer-to-earn');
    }
    function dashboard()
    {
        // redirect('student/profile');
        $this->student_view('index', ['isValid' => true]);

        // $this->student_view('profile');
    }
    function help()
    {
        $this->student_view('help', ['isValid' => true]);
    }
    function sign_out()
    {
        $this->session->unset_userdata('student_login');
        $this->session->unset_userdata('student_id');
        redirect('student');
    }
    
    function pending_list()
    {
        $this->view('all', ['title' => 'Pending']);
    }

    function approve_list()
    {
        $this->view('all', ['title' => 'Approved']);
    }
    function cancel_list()
    {
        $this->view('all', ['title' => 'Cancel']);
    }
    function search()
    {
        $this->view('search');
    }
    function admission()
    {
        $this->set_data('roll_no', $this->gen_roll_no());
        // $this->ki_theme->get_wallet_amount('student_admission_fees');
        $this->view('admission');
    }
    function online_admission()
    {
        $this->view('online-admission');
    }
    function all()
    {
        $this->view('all');
    }
    function assign_course()
    {
        $this->view('assign-course');
    }
    function profile($stdId = 0, $tab = 'overview')
    {
        $tabs = [
            'overview' => ['title' => 'Account Overview', 'icon' => array('user', 2), 'url' => ''],
            'setting' => ['title' => 'Update', 'icon' => array('pencil', 3), 'url' => 'setting'],
            'bank' => ['title' => 'Bank Details (KYC)', 'icon' => array('bank', 3), 'url' => 'bank'],
            // 'fee-record' => ['title' => 'Account Fees Record', 'icon' => array('two-credit-cart', 3), 'url' => 'fee-record'],
            'change-password' => ['title' => 'Account Change Password', 'icon' => array('key', 2), 'url' => 'change-password']
        ];
        if (is_numeric($stdId) and $stdId) {
            if ($this->student_model->isAdmin()) {
                $tabs['other'] = [
                    'title' => 'Referral Code',
                    'icon' => array('gift', 2),
                    'url' => 'referral-code'
                ];
            }
            $get = $this->student_model->get_student_via_id($stdId);
            if ($get->num_rows()) {
                if (isset($tabs[$tab]))
                    $this->ki_theme->set_breadcrumb($tabs[$tab]);
                // pre($get->row_array(),true);
                $this->set_data($get->row_array());
                $this->set_data('student_details', $get->row_array());
                // pre($this->public_data,true);
                $this->view('profile', ['isValid' => true, 'tabs' => $tabs, 'tab' => $tab, 'current_link' => base_url('student/profile/' . $stdId), 'student_id' => $stdId]);

            }
        } else {
            if ($this->student_model->isStudent()) {
                $tab = $this->uri->segment(3, 'overview');
                $stdId = $this->student_model->studentId();
                $get = $this->student_model->get_student_via_id($stdId);
                // unset($tabs['setting']);
                if ($get->num_rows()) {
                    $this->ki_theme->set_breadcrumb($tabs[$tab]);
                    $this->set_data($get->row_array());
                    $this->set_data('student_details', $get->row_array());
                    $this->set_data('isStudent', true);
                    // exit($tab);
                    // $this->student_view($tab,['isValid' => true,'isStudent' => true]);
                    $this->student_view('../profile', ['isValid' => true, 'tabs' => $tabs, 'tab' => $tab, 'current_link' => base_url('student/profile'), 'student_id' => $stdId]);
                }
            } else
                $this->student_view('index');
        }
    }

    function manage_study_material()
    {
        $this->view(__FUNCTION__);
    }
    // test area
    function loginId()
    {
        return 2;
    }
    function test()
    {
        //    $this->load->view('firebase');
        // $this->ki_theme->set_default_vars('max_upload_size',10485760);
        // echo $this->ki_theme->default_vars('max_upload_size') / 1024;
        // echo $this->student_model->study_materials()->num_rows();
        // $where = ['course_id' => 11, 'isDeleted' => 0];
        // $subjects = $this->student_model->course_subject($where);
        // echo $subjects->num_rows();
        $record = $this->exam_model->get_shuffled_questions(1, 10);
        pre($record);
    }
    // this is only for referral code
    function coupons()
    {
        $this->view(__FUNCTION__);
    }
    function passout_student_list()
    {
        $this->view('passout-student-list');
    }
    function get_id_card()
    {
        $this->view('get-id-card');
    }
    function list_by_center()
    {
        $this->view('list-by-center');
    }
    function list_by_session()
    {
        $this->view('list-by-session');
    }
    function course_study_material()
    {
        if ($view = $this->uri->segment(3, 0)) {
            // echo $view;
            try {
                $this->token->decode($view);
                // pre($this->token->data(),true);
                $this->student_view('course-study-material', [
                    'isValid' => true,
                    'course_id' => $this->token->data('course_id'),
                    'student_id' => $this->token->data('student_id'),
                    'file_type' => $this->token->data('file_type'),
                ]);
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
    }
    function study_material()
    {
        if ($view = $this->uri->segment(3, 0)) {
            try {
                // throw new Exception('HELLO');
                $this->token->decode($view);
                $id = ($this->token->data('id'));
                $student_id = ($this->token->data('student_id'));
                if ($student_id == $this->session->userdata('student_id')) {
                    $get = $this->db->where(['material_id' => $id])->get('study_material');

                    if (!$get->num_rows())
                        throw new Exception('Material Not Found..');
                    // echo $this->token->expiredOn();
                    $row = $get->row();
                    if ($row->file_type == 'file') {
                        $file = $row->file;
                        $this->load->view('panel/study', ['url' => base_url('assets/student-study/' . $file)]);
                    } else if ($row->file_type == 'youtube') {
                        if ($videoId = getYouTubeId($row->file)) {
                            // echo $videoId;
                            $this->load->view('panel/youtube-study', ['id' => $videoId, 'title' => $row->title]);

                        } else
                            throw new Exception('Invalid File..');
                    } else
                        throw new Exception('Something went wrong.');
                } else
                    throw new Exception('This link not available..');

            } catch (Exception $e) {
                echo $e->getMessage();
            }
        } else
            $this->student_view('study-material', ['isValid' => true]);
    }
}
?>