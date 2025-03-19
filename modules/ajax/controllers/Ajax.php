<?php
class Ajax extends Ajax_Controller
{
    function add_notification()
    {
        if ($post = $this->input->post()) {
            $data = [
                'title' => $post['title'],
                'description' => $post['description'],
                'starttime' => strtotime($post['starttime']),
                'url' => $post['url'],
                'endtime' => strtotime($post['endtime'])
            ];
            $this->response('data',$data);
            $this->db->insert('live_notification', $data);
            $this->response('status', true);
        }
    }
    function live_notifications()
    {
        $this->response(
            array(
                'status' => true,
                'data' => $this->db->get('live_notification')->result_array()
            )
        );
    }
    function delete_live_notifications($id)
    {
        $this->db->where('id', $id)->delete('live_notification');
        $this->response('status', true);
    }
    function generate_link()
    {
        $allLinks = $this->ki_theme->project_config('open_links');
        if (isset($allLinks[$this->post('type')])) {
            $this->response('link', base_url($allLinks[$this->post('type')] . '/' . $this->encode($this->post('id'))));
            $this->response('status', true);
        }
        $this->response($this->post());
    }
    function deleted()
    {
        $this->response(
            'status',
            $this->db->where($this->post('field'), $this->post('field_value'))->update($this->post('table_name'), [
                'isDeleted' => 1
            ])
        );
    }
    function undeleted()
    {
        $this->response(
            'status',
            $this->db->where($this->post('field'), $this->post('field_value'))->update($this->post('table_name'), [
                'isDeleted' => 0
            ])
        );
    }
    function admin_login()
    {
        $email = $this->input->post('username');
        $password = sha1($this->input->post('password'));
        try {
            $table = $this->db->where('username', $email)->get('login');
            if ($table->num_rows()) {

                $row = $table->row();
                if (($row->status && $row->type == 'main')) {
                    if ($row->password == $password) {
                        $this->load->library('session');
                        $this->session->set_userdata([
                            'admin_login' => true,
                            'admin_type' => $row->type,
                            'admin_id' => $row->id
                        ]);
                        $this->response('status', 1);
                    } else
                        $this->response('error', alert('Sorry, the username or password is incorrect, please try again.', 'danger'));
                } else
                    $this->response('error', alert('Your Account is In-active. Please Contact Your Admin', 'danger'));
            } else
                throw new Exception(alert('Sorry, this username  is not found..', 'danger'));
        } catch (Exception $e) {
            $this->response('error', $e->getMessage());
        }
    }
    function delete_enquiry($id)
    {
        $this->response('status', $this->db->where('id', $id)->delete('contact_us_action'));
    }
    function upload_file()
    {
        if ($this->file_up('image'))
            $this->response('status', true);
    }

}