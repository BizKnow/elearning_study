<?php
use chillerlan\QRCode\Data\Number;

defined('BASEPATH') or exit('No direct script access allowed');
class Site extends Site_Controller
{
    private $salt;
    private $marchantId;
    public function __construct()
    {
        parent::__construct();
        $this->salt = defined('PHONEPAY_SALT') ? PHONEPAY_SALT : '';
        $this->marchantId = defined('PHONEPAY_MID') ? PHONEPAY_MID : '';
        $this->load->library('common/PhonePe');
    }
    function register()
    {
        // echo 'YES';
        if ($this->student_model->isStudent()) {
            if (isset($_GET['token'])) {
                $this->session->set_userdata(array('referral_token' => $_GET['token']));
                try {
                    $token = $_GET['token'];
                    if ($token) {
                        $this->token->decode($token);
                        $data = $this->token->data();
                        if ($this->student_model->studentId() == $this->token->data('referral_id')) {
                            $this->render(alert('wrong', 'danger'), 'page');
                        } else
                            redirect('checkout');
                    }
                } catch (Exception $e) {
                }
            }
        } else {
            // echo 'YES';
            $this->render('register', [
                'page_name' => 'Student Registration'
            ]);
        }
    }
    function response()
    {
        $json_data = file_get_contents('php://input'); // Get JSON from request
        $response = json_decode($json_data, true);

        log_message('error', 'PhonePe Response: ' . print_r($response, true));

        if (!$response || !isset($response['data']['merchantTransactionId'])) {
            echo "Invalid response";
            return;
        }

        // Extract required fields
        $merchantTransactionId = $response['data']['merchantTransactionId'];  // ✅ Yeh database me search karenge
        $transactionId = $response['data']['transactionId'];  // ✅ Yeh store karenge
        $status = $response['data']['status'];
        $amount = $response['data']['amount'] / 100; // Convert paise to rupees
        $paymentTime = date('Y-m-d H:i:s', time()); // Current timestamp

        // Database me update karein
        $this->db->where('starttime', $merchantTransactionId); // ✅ Order/Transaction match karein
        $this->db->update('student_courses', [
            'payment_id' => $transactionId, // ✅ PhonePe ka Transaction ID store karein
            'status' => 1, // SUCCESS / FAILED / PENDING
        ]);
        $this->session->set_flashdata('success','Payment Done..');
        redirect('student');

        // pre($_POST);
        // if (isset($_GET['order_id'])) {
        //     $this->render('response', [
        //         'page_name' => 'Order Response'
        //     ]);
        // } else
        //     redirect(base_url());
    }
    function content($content)
    {
        $html = '<div class="container"><div class="row"><div class="col-md-12 p-4">' . $content . '</div></div></div>';
        //$this->
        $this->render($html, 'contnet');
    }
    function checkout()
    {
        if ($this->input->post()) {
            // pre($_POST);
            $token = $_POST['token'];
            $server_token = $this->session->userdata('referral_token');

            if ($server_token == $token) {
                $data = $this->ki_theme->referral_data($token);
                $referral_id = $data['referral_id'] ?? 0;
                $time = time();

                // pre($data);
                if (isset($data['combo_id'])) {
                    $check = $this->db->get_where('student_courses', [
                        'student_id' => $data['student_id'],
                        'combo_id' => $data['combo_id'],
                        'status' => 1
                    ]);
                    if ($check->num_rows() > 0) {
                        $this->set_data('page_name', 'This combo already Purchased');
                        $html = alert('This combo already Purchased..', 'danger');
                        $html .= '<center>' . $this->ki_theme->set_attribute('target', '_blank')->set_class('btn btn-primary')->add_action('<i class="fa fa-home"></i> Go to Dashboard', base_url('student')) . '</center>';

                        $this->content($html);
                    } else {
                        $list = $this->db->where('id', $data['combo_id'])->get('combo');
                        if ($list->num_rows() > 0) {
                            $combo = $list->row();
                            if ($referral_id) {
                                $this->db->set('wallet', 'wallet + ' . $combo->referral_amount, FALSE)->where('id', $referral_id)->update('students');
                            }
                            // pre($combo);
                            $courses = json_decode($combo->courses, true);
                            if (sizeof($courses) > 0) {
                                foreach ($courses as $course) {
                                    $getCourse = $this->db->get_where('course', ['id' => $course]);
                                    if ($getCourse->num_rows() > 0) {
                                        $course = $getCourse->row();
                                        $this->db->insert('student_courses', [
                                            'student_id' => $data['student_id'],
                                            'course_id' => $course->id,
                                            'starttime' => $time,
                                            // 'status' => 1,
                                            'enrollment_no' => $this->gen_roll_no(),
                                            'added_via' => 'web',
                                            'referral_id' => $data['referral_id'],
                                            'amount' => $data['amount'],
                                            'combo_id' => $combo->id
                                        ]);
                                    }
                                }
                            }
                        }
                        // redirect('response?order_id=' . $time);
                        // $this->redirect_to_payment($time);
                        redirect('site/payment/' . $time);

                    }
                } else if (isset($data['course_id'])) {
                    $check = $this->db->get_where('student_courses', [
                        'student_id' => $data['student_id'],
                        'course_id' => $data['course_id'],
                        'status' => 1
                    ]);
                    if ($check->num_rows() > 0) {
                        $this->set_data('page_name', 'This Course already Purchased');
                        $html = alert('This Course already Purchased..', 'danger');
                        $html .= '<center>' . $this->ki_theme->set_attribute('target', '_blank')->set_class('btn btn-primary')->add_action('<i class="fa fa-home"></i> Go to Dashboard', base_url('student')) . '</center>';

                        $this->content($html);
                    } else {
                        $getCourse = $this->db->get_where('course', ['id' => $data['course_id']]);
                        if ($getCourse->num_rows() > 0) {
                            $course = $getCourse->row();
                            // pre($course, true);
                            if ($referral_id) {
                                $this->db->set('wallet', 'wallet + ' . $course->referral_amount, FALSE)->where('id', $referral_id)->update('students');
                            }
                            $this->db->insert('student_courses', [
                                'student_id' => $data['student_id'],
                                'course_id' => $course->id,
                                'starttime' => $time,
                                // 'status' => 1,
                                'enrollment_no' => $this->gen_roll_no(),
                                'added_via' => 'web',
                                'referral_id' => $data['referral_id'],
                                'amount' => $course->fees
                            ]);
                            redirect('site/payment/' . $time);
                            // $this->redirect_to_payment($time);
                        }
                    }
                }
            }
        } else {
            $this->render('checkout', [
                'page_name' => 'Checkout'
            ]);
        }
    }
    function payment($time)
    {
        $client = new \GuzzleHttp\Client();
        $get = $this->db->select('s.*,sc.amount')
            ->from('students as s')
            ->join('student_courses as sc', 's.id = sc.student_id AND sc.starttime = ' . $time)
            ->get();

        // pre($row,true);
        try {
            if (!$get->num_rows())
                throw new Exception('Invalid Order id..');
            $row = $get->row();

            $amount = $row->amount * 100;
            $decodeJson = $this->phonepe->initiatePayment($time, $amount, base_url('response'), $row->contact_number, $row->id);
            // pre($decodeJson,true);
            if (isset($decodeJson['error'])) {
                $newTIme = time();
                $this->db->where('starttime', $time)->update('student_courses', ['starttime' => $newTIme]);
                redirect('site/payment/' . $newTIme);
            } else {
                // pre($decodeJson);
                if ($decodeJson['success']) {
                    $paymentUrl = $decodeJson['data']['instrumentResponse']['redirectInfo']['url'];
                    header("Location: " . $paymentUrl);
                }
            }
            /*
            $requestData = [
                'merchantId' => PHONEPAY_MID,// $this->marchantId,
                'merchantTransactionId' => $time,
                'amount' => $row->amount * 100,
                'merchantUserId' => $row->id,
                'redirectUrl' => base_url('response'),
                'callbackUrl' => base_url('response'),
                'paymentInstrument' => [
                    'type' => 'PAY_PAGE'
                ],
                'mobileNumber' => $row->contact_number
            ];
            // pre($requestData,true);

            $requestJson = json_encode($requestData);

            $base = base64_encode($requestJson);

            $hasValue = base64_encode($requestJson) . '/pg/v1/pay' . PHONEPAY_SALT;


            $hashRequest = hash('sha256', $hasValue);

            $hasFinalRequest = $hashRequest . "###1";
            // exit($hasFinalRequest);
            $mRequest['request'] = $base;
            // pre($mRequest,true);
            $response = $client->request('POST', 'https://api.phonepe.com/apis/hermes/pg/v1/pay', [

                'body' => json_encode($mRequest),
                'headers' => [
                    'Content-Type' => 'application/json',
                    'accept' => 'application/json',
                    'X-VERIFY' => $hasFinalRequest
                ]
            ]);

            $decodeJson = json_decode($response->getBody()->getContents());

            if ($decodeJson->success) {
                $paymentUrl = $decodeJson->data->instrumentResponse->redirectInfo->url;
                header("Location: " . $paymentUrl);
            } else {
                pre($decodeJson);
            }
            */
        } catch (Exception $r) {
            echo $r->getMessage();
        }
    }
    function checkStatus($orderId)
    {
        pre($this->phonepe->checkPaymentStatus($orderId));
    }
    function program()
    {
        $this->load->library('common/PhonePeAuth');
        pre($this->phonepeauth->getAuthToken());
    }
    public function index()
    {
        if ($this->isOK) {
            $this->render(
                'schema',
                $this->container()
            );
        } else
            $this->error_404();
    }
    function email()
    {
        $this->set_data([
            'name' => 'Ajay Kumar Arya',
            'mobile' => '456789'
        ]);
        echo $this->do_email('ajaykumararya963983@gmail.com', 'New Demo Checklist', $this->template('email/demo-query'));
    }

    function container()
    {
        $data = $this->pageData;
        $return = ['page_name' => $data['label'], 'content' => '', 'isPrimary' => (DefaultPage == $data['id'])];
        $pageSchema = $this->SiteModel->get_page_schema($data['id']);
        if ($pageSchema->num_rows()) {
            $html = '';
            foreach ($pageSchema->result() as $page) {
                switch ($page->event) {
                    case 'content':
                        $get = $this->SiteModel->page_content($page->page_id);
                        if ($get->num_rows()) {
                            if (file_exists(THEME_PATH . 'content.php'))
                                $html .= $this->parse('content', ['content' => $get->row('content')], true);
                            else
                                $html .= $get->row('content');
                        }
                        break;
                    case 'faculty_category':
                        if (file_exists(THEME_PATH . 'pages/' . $page->event . EXT))
                            $html .= $this->parse('pages/' . $page->event, [
                                'type' => $page->event_id
                            ], true);
                        break;
                    case 'page':
                        if (file_exists(THEME_PATH . 'pages/' . $page->event_id . EXT))
                            $html .= $this->parse('pages/' . $page->event_id, [
                                'type' => $page->event_id
                            ], true);
                        else if ($this->ki_theme->view_exists('cms', 'pages/' . $page->event_id)) {
                            $html .= $this->parse('cms/pages/' . $page->event_id, [], true);
                        } else {
                            if ($page->event_id == 'notice-board' && !$return['isPrimary']) { // this for theme3
                                $this->set_data('notice_board', true);
                            }
                        }
                        break;
                    case 'image_gallery':
                        if (file_exists(THEME_PATH . 'pages/' . $page->event . EXT)) {
                            $this->set_data('gallery', $this->db->get('gallery_images')->result_array());
                            $html .= $this->parse('pages/' . $page->event, [], true);
                        }
                        break;
                    case 'form':
                        if (!(CHECK_PERMISSION('CO_ORDINATE_SYSTEM') && $page->event_id == 'student_admission'))
                            $html .= $this->parse('form/' . $page->event_id, [], true);
                        break;
                }
            }
            // exit;
            $return['content'] = $html . "\n" . $this->parser->parse('default_content', $this->public_data, true);
        }
        return array_merge($this->public_data, $return);
    }
    function error_404()
    {
        $error_file = 'error_404';
        $this->set_data('title', 'Page Not Found');
        $this->set_data('page_name', '404');
        $file = (file_exists(THEME_PATH . $error_file . EXT)) ? '' : 'default_'; //error_404';
        $this->render("{$file}{$error_file}");
    }
    function page_view($content, $data = [])
    {
        $this->set_data($data);
        $this->render($content, 'content');
        // pre($this->public_data,true);
    }
    function marksheet_print()
    {
        $token = $this->uri->segment(2);
        try {
            $this->token->decode($token);
            $id = $this->token->data('id');
            $get = $this->student_model->marksheet(['id' => $id]);
            if (!$get->num_rows())
                throw new Exception('Not Found.');
            $data = $get->row_array();
            $this->set_data('page_name', $data['student_name'] . ' Marksheet');
            $this->set_data('marksheet_id', $data['result_id']);
            $this->set_data($data);
            $this->set_data('isPrimary', false);
            $this->load->module('document');
            $html = '<div class="container pt-3">' . $this->template('marksheet-view') . '</div>';
            // $this->render($html, 'content');
            $this->render(
                'schema',
                ['content' => $html]
            );
        } catch (Exception $e) {
            $this->error_404();
        }
    }
    function list_demo()
    {
        $get = $this->db->order_by('id', 'DESC')->get('demo_query');
        if ($get->num_rows()) {
            ?>
            <style>
                td,
                th {
                    padding: 8px;
                    font-size: 20px
                }
            </style>
            <table border="2">
                <tr>
                    <th>Time</th>
                    <th>Name</th>
                    <th>Mobile</th>
                </tr>
                <?php
                foreach ($get->result() as $row) {
                    echo '<tr>
                <td>' . date('d-m-Y h:i A', strtotime($row->timestamp)) . '</td>
                <td>' . $row->name . '</td>
                <td><a href="tel:' . $row->mobile . '">' . $row->mobile . '</a></td>
        </tr>';
                }

                ?>
            </table>
            <?php
        } else {
            echo 'Users not found...';
        }
    }
    function test()
    {
        // $get = $this->db->get_where('combo', ['id' => 2]);
        $id = 1;
        $this->db->from('student_courses as sc');
        $this->db->join('course as c', 'c.id = sc.course_id');
        $this->db->where('sc.student_id', $id);
        $get = $this->db->get();
        echo $get->num_rows() . '<br>';
        pre($get->result_array());
        echo $this->db->last_query();

        // echo $this->gen_roll_no();
        // try {
        //     $get = $this->student_model->show_remaining_days(3);

        //     pre($get);
        // } catch (Exception $e) {
        //     echo $e->getMessage();
        // }
        // echo ($this->ki_theme->isDiwali()) ? 'YES' : 'NO';
        // pre($this->ki_theme->get_festival());
        // pre(search_file(FCPATH . UPLOAD, '23322'));
        // $year = 2023;
        // $i = 1;
        // $N = 125;
        // do{
        //     print $N * $i.'<br>';
        //     $i++;
        // }
        // while($i <= 10);
        // // for($i = 1; $i <= 10; $i++){
        // //     echo $N * $i.'<br>';
        // // }
        // // while($i <= 10){ // 1 <= 10 // 2 <=10 // 11 <= 10
        // //     echo $N * $i.'<br>';
        // //     $i++;
        // // }
        // exit;
        // // echo chr(97); // ASCCII CODE
        // echo '<table border="1" style="width:10%">
        //     <tr>
        //         <th>ASCCI VALUE</th>
        //         <th>VALUE</th>
        //         </tr>
        // ';
        // for($i = 1; $i <= 126; $i++){
        //     echo '<tr>
        //             <td>'.$i.'</td>    
        //             <td>'.chr($i).'</td>    
        //     </tr>';
        // }
        // echo '</table>';
        // return 12;
        // for($a = 1; $a <= 26;$a++)
        //     echo '<h1 style="margin:0">'.chr($a).'</h1>';


        // $this->load->driver('cache', array('adapter' => 'file'));
        //   $cached_data = ['name' => 'ajay','name1' => 'fff'];
        // $this->cache->save('cache_key', $cached_data, 60);
        // $cached_data = $this->cache->get('cache_key');
        // foreach($this->cache->get_metadata('cache_key') as $key => $value){
        //     echo "$key = ".date('d-m-Y h:i A',$value).'<br>';
        // }
        // if ($cached_data === FALSE) {
        //     // Cache miss: Compute and cache the data
        //     $cached_data = ['name' => 'ajay'];
        //     $this->cache->save('cache_key', $cached_data, 60);
        // }
        // $this->cache->delete('cache_key');
        // pre( $cached_data);
        // $token['id'] = 1; //From here
        // $token['username'] = 'ajay';
        // $date = new DateTime();
        // $token['iat'] = $date->getTimestamp();
        // $token['exp'] = $date->getTimestamp() + 60 * 30;
        // $this->load->library('common/token');
        // echo $this->token->encode($token);


        // $templates = $this->load->config('api/sms',true);
        // // pre($templates);
        // if(isset($templates['login_with_otp'])){
        //     $message = $templates['login_with_otp']['content'];
        //     $message = str_replace('{#var#}',random_int(100000, 999999),$message);
        //     // echo $message;
        //     $this->load->module('api/whatsapp');
        //     $res = $this->whatsapp->send('918533898539',$message);
        //     pre($res);
        // }
        // $get = $this->student_model->get_student([
        //     'contact_number' => '8533898539'
        // ]);
        // if($get->num_rows()){
        //     pre($get->row());
        // }

        //    echo $this->gen_roll_no(5);
        // echo $this->center_model->wallet_history()->num_rows();
        // $test = $this->ki_theme->center_fix_fees();
        // pre($test);
/*
        $data = [];
        $list = $this->center_model->wallet_history();
        if ($list->num_rows()) {
            foreach ($list->result() as $row) {
                $tempData = [
                    'date' => $row->date,
                    'amount' => $row->amount,
                    'type' => $row->type,
                    'description' => $row->description,
                    'status' => $row->wallet_status,
                    'url' => 0
                ];
                if ($row->type_id) {
                    switch ($row->type) {
                        case 'admission':
                            $student = $this->student_model->get_all_student([
                                'id' => $row->type_id
                            ]);
                            $tempData['student_name'] = @$student[0]->student_name . ' ' . label('Admission');
                            $tempData['url'] = base_url('student/profile/'.$row->type_id);
                            break;
                        case 'marksheet':
                            $marksheet = $this->student_model->marksheet(['id' => $row->type_id]);
                            $student = '';
                            if ($marksheet->num_rows()) {
                                $drow = $marksheet->row();
                                $tempData['url'] = base_url('marksheet/'.$this->encode($row->type_id));

                                $student = $drow->student_name . ' ' . label(humnize_duration_with_ordinal($drow->marksheet_duration, $drow->duration_type) . ' Marksheet');
                            }
                            $tempData['student_name'] = $student;
                            break;
                        case 'certificate':
                            $student_certificates = $this->student_model->student_certificates([
                                'id' => $row->type_id
                            ]);
                            $tempData['url'] = base_url('certificate/'.$this->encode(($row->type_id)));
                            $tempData['student_name'] = $student_certificates->row('student_name') . ' ' . label('Certificate');
                            break;
                    }
                } else
                    $tempData['student_name'] = label(ucfirst(str_replace('_', ' ', $row->type)));

                $data[] = $tempData;
            }
        }
        pre($data);
        */
    }
}
