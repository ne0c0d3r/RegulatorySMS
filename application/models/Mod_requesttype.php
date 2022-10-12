<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Mod_requesttype extends CI_Model{
	
	public function __construct(){
		parent::__construct();
	}

	public function getRequesttype(){
		$query = $this->db->query("select requesttypeid, requesttype, ifnull(inactive,0) as inactive from requesttype order by requesttype");
		if ($query) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	public function single_retrieve($requesttypeid){
		$query = $this->db->query("select * from requesttype where requesttypeid = $requesttypeid")->row();
		return $query;	
	}

	public function validate_form($postdata){		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('txtRequestType', 'requesttype', 'required');
		if ($this->form_validation->run() == FALSE){
			return false;
		} else {
			return true;
		}
	}

	public function execadd_requesttype($postData){
		$requesttype = $this->db->escape_str($postData['txtRequestType']);
		$inactive = $this->db->escape_str($postData['inactive']);
		$query = $this->db->query("insert into requesttype (requesttype, inactive) values ('$requesttype', '$inactive')");
		if ($query) {
			$this->Mod_logs->create_logs('Added new status ' . $requesttype);
			return true;
		}
	}

	public function execupdate_requesttype($postData, $requesttypeid){
		$requesttype = $this->db->escape_str($postData['txtRequestType']);
		$inactive = $this->db->escape_str($postData['inactive']);
		$query = $this->db->query("update requesttype set requesttype = '$requesttype', inactive = '$inactive' where requesttypeid = $requesttypeid");
		if ($query) {
			$this->Mod_logs->create_logs('Update status to ' . $requesttype);
			return true;
		}
	}
}