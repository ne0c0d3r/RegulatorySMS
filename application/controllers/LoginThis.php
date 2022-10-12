<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Con_login
 *
 * @author MAJE
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct(){
        parent::__construct();

    }

    public function index(){
        if (isset($_SESSION['isloggedOnPortal'])) {
            redirect(base_url());
        }
        $this->load->view('header');
        $this->load->view('login-page');
        $this->load->view('footer');
    }

    public function authenticate() {
        $this->load->model('mod_login');
        $a = $this->mod_login->authenticate($this->input->post());
        if ($a) {
            redirect(base_url());
        } 
        $this->session->set_flashdata(array('message' => 'Invalid credetial', 'alerttype' => 'alert-danger'));
        redirect('login');
    }
    
     public function logout(){
         $this->load->library('session');
         $this->session->sess_destroy();
         redirect('login');
    }

}
