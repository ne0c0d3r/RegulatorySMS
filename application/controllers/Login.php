<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $this->load->view('header');
        $this->load->view('login-page');
        $this->load->view('footer');
    }

    public function authenticate() {
        //var_dump($this->input->post('username'));
        $username = $this->input->post('username');
        $this->load->model(array('Mod_session', 'mod_login', 'Mod_logs', 'Mod_syncEmpData'));
        $a = $this->mod_login->authenticate($this->input->post());

        if ($a) {
            echo "creating session..";
            //$this->Mod_session->create_sms_session('rgambol');
            //$this->Mod_session->create_sms_session('ragnes');
            //$this->Mod_session->create_sms_session('kcbtadique');
            //$this->Mod_session->create_sms_session('rtpalele');
            //$this->Mod_session->create_sms_session('ua5483y');
            //$this->Mod_session->create_sms_session('jspedreso');
            //$this->Mod_session->create_sms_session('jjjoplo');
            //echo $this->Mod_session->create_sms_session('inchua');
            //echo $this->Mod_session->create_sms_session('damadrin');
            
            
            echo $this->Mod_session->create_sms_session($username);
            echo "creating logs..";
            echo $this->Mod_logs->create_logs('Logged in');
            //print_r($this->session->userdata);
            echo $this->Mod_syncEmpData->syncThisEmployee();
            if ($this->session->userdata('sms_userlvl') == 'Administrator' || $this->session->userdata('sms_userlvl') == 'Dispatcher' || $this->session->userdata('sms_userlvl') == 'Counsel') {
                redirect(base_url() . 'dashboard');
            } else {
                redirect(base_url());
            }
        } 
        $this->Mod_logs->create_logs('Failed log in with username ' . $username);
        $this->session->set_flashdata(array('message' => 'Invalid credential', 'alerttype' => 'alert-danger'));
        redirect('login');
    }

    public function switchLevel($level){
        $this->load->model('Mod_session');
        $this->Mod_session->change_userlvl_session($level);
        
        redirect(base_url());
    }

    public function switchUser($userid){
        $this->load->model('Mod_session');
        $this->Mod_session->create_sms_session($userid);
        echo "true";
    }

    public function user_session($value){
        echo $this->session->userdata($value);
    }
}
