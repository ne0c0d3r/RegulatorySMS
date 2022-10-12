<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Attachment extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->Mod_session->check_session();
		$this->load->model(array('Mod_attachment'));
	}

	public function ticketAttachment($ticketid){
		$data['attachData'] = $this->Mod_attachment->ticketAttachment($ticketid);
		return $data;
	}

	public function openAttach($ticketid) {
		//$data['op']
	}
}