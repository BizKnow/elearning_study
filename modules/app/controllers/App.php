<?php
class App extends MY_Controller{
    public function __construct(){
        parent::__construct();
    }
    function setting(){
        $this->view('setting');        
    }
    function live_notification(){
        $this->view('live-notification');
    }
}