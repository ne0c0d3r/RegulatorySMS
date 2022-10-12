<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Mod_session extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

/*	public function validate_user_credentials($empid){
		$pis = $this->load->database("pis", true);
		$query = $pis->query("select * from employee where employeeId = '$empid'")->row();
		if ($query) {
			return $query;
		} else {
			return false;
		}
	}*/

	public function create_sms_session($ref){
		$this->load->library('util');
		$pis = $this->load->database("pis", true);
		$query = $pis->query("select * from employee where domainName = '$ref'")->row();
		if (count($query) > 0) {
			$userdatas = array(
					'sms_userid' => $query->employeeId,
					'sms_gender' => $query->gender,
					'sms_userlvl' => $this->util->assignedTask($query->employeeId),
			        'sms_name'  => $query->lastName . ', ' . $query->firstName . ' ' . $query->middleName,
			        'pis_domainName' => $ref,
			        'sms_logged_in' => TRUE
			);
			$this->session->set_userdata($userdatas);
			return true;
		}
		return false;		
	}

	public function check_session(){
	    if ( ! $this->session->userdata('sms_logged_in'))
	    { 
	    	$this->session->set_flashdata(array('message' => 'You are not authorized. Please sign-in.', 'alerttype' => 'alert-danger'));
            redirect('login');
	    }
	}

	public function change_userlvl_session($level){
		$newdata = array('sms_userlvl'  => $level);
		$this->session->set_userdata($newdata);
	}

}