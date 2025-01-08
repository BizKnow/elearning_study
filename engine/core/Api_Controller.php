<?php
class Api_Controller extends Ajax_Controller
{
    public $method;
    public function __construct()
    {
        parent::__construct();
        $this->method = strtolower($this->input->server('REQUEST_METHOD'));
        $this->load->library('common/curl');
    }

    protected function isPost()
    {
        $yes = $this->method == 'post';
        if (!$yes)
            $this->response('message', 'Invalid Method.');
        return $yes;
    }
    protected function isGet()
    {
        $yes = $this->method == 'get';

        if (!$yes)
            $this->response('message', 'Invalid Method.');
        return $yes;
    }
    protected function isPut()
    {
        $yes = $this->method == 'put';

        if (!$yes)
            $this->response('message', 'Invalid Method.');
        return $yes;
    }
    protected function isDelete()
    {
        $yes = $this->method == 'delete';

        if (!$yes)
            $this->response('message', 'Invalid Method.');
        return $yes;
    }
}