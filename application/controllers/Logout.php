<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Logout extends CI_Controller {

    public function __construct(){
        parent::__construct();

    }

    public function index(){
        echo 'logout';
        $this->load->library('session');
        $this->load->model('Mod_logs');
        $this->Mod_logs->create_logs('Logged out');
        $this->session->sess_destroy();
/*      $this->session->unset_userdata('sms_name');
        $this->session->set_userdata('sms_logged_in', false);*/
        redirect('login');
    }

}
