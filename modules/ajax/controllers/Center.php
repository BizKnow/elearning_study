<?php
class Center extends Ajax_Controller
{
    function update_password()
    {
        if ($this->validation('change_password') && !$this->isDemo()) {
            $this->db->update('centers', ['password' => sha1($this->post('password'))], [
                'id' => $this->post('center_id')
            ]);
            $this->response('status', true);
        }

    }
}