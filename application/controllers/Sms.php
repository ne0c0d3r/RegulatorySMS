<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Sms extends CI_Controller{

    public function __construct(){
        parent::__construct();
        //$this->Mod_session->check_session();
        $this->session->unset_userdata('ticketid');
        if (isset($_GET[md5(date('mdy')) . md5('pis_ref')])) {
            $this->load->model('Mod_session');
            $refKey = $_GET[md5(date('mdy')) . md5('pis_ref')];
            $this->Mod_session->create_sms_session($refKey);
            redirect(base_url());
        }
    }
    
    public function index(){
        if (!$_SESSION['sms_logged_in']) {
            //redirect('http://172.22.11.153/portal/portal/restricted');
            redirect('login');
        }
        $this->session->set_userdata('thisIbaseUrl', base_url());
        $this->load->model(array('Mod_site','mod_services', 'Mod_ticket', 'Mod_employee', 'Mod_attachment', 'Mod_requesttype'));
        $this->load->library('util');
        $data['util'] = $this->util;

        $data['assignData'] = $this->Mod_employee->listOfAssignedEemployee();
        $data['empData'] = $this->Mod_employee->retrieveEmployee();
        $data['userData'] = $this->Mod_employee->getEmployee();
        $data['servData'] = $this->mod_services->getServices();
        $data['siteData'] = $this->Mod_site->getSites();
        $data['requesttypeData'] = $this->Mod_requesttype->getRequesttype();
        $data['ticketCount'] = $this->Mod_ticket->getTicketSearchCountOnLoad('');
        //$data['mod_attachment'] = $this->Mod_attachment;
    
        $this->load->view('header');
        $this->load->view('navigation', $data);
        $this->load->view('ticket/ticket-main', $data);
        $this->load->view('footer');
    }

    public function error404(){
        echo "You're not logged in";
    }
    
    public function phpinfo(){
        echo phpinfo();
    }

    public function updatePIS(){
        echo 'updating PIs';
        $this->load->model('mod_login');
        $this->mod_login->updatePIS();
    }

    public function testpage(){
if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ipreal =$_SERVER['HTTP_CLIENT_IP']; // share internet
  } elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ipreal =$_SERVER['HTTP_X_FORWARDED_FOR']; // pass from proxy
  } else {
    $ipreal =$_SERVER['REMOTE_ADDR'];
  }
  echo $ipreal ;

  echo  $_SERVER['REMOTE_ADDR'];

  echo gethostbyaddr($ipreal);
    }
}