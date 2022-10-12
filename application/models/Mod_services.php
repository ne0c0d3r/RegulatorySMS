<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Mod_services extends CI_Model{
	
	public function __construct(){
		parent::__construct();
	}

	public function getServices(){
		$query = $this->db->query("select * from services order by active desc, services");
		if ($query) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	public function getWorkflow($servicesid){
		$query = $this->db->query("select * from workflow where servicesid = $servicesid order by woseq");
		if ($query) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	public function single_retrieve($servicesid){
		$query = $this->db->query("select * from services where servicesid = $servicesid")->row();
		return $query;	
	}

	public function validate_form($postData){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('txtServicename', 'Module name', 'required');
		$this->form_validation->set_rules('txtDescription', 'Description', 'required');
		//$this->form_validation->set_rules('txtCategory', 'Category', 'required');
		if ($this->form_validation->run() == FALSE){
			return false;
		} else {
			return true;
		}
	}

	public function execadd_service($postData){
		$service = $this->db->escape_str($postData['txtServicename']);
		$description = $this->db->escape_str($postData['txtDescription']);
		$allowSpecifyQty = (isset($postData['allowSpecifyQty'])) ? 1 : 0;
		$viewTypesOfCopy = (isset($postData['viewTypesOfCopy'])) ? 1 : 0;
		$viewTypesOfCopy = (isset($postData['viewTypesOfCopy'])) ? 1 : 0;
		$active = $this->db->escape_str($postData['active']);

		$category = $postData['txtCategory'];
		$query = $this->db->query("insert into services (servicesid, services, description, mcatid, isQuantityCanview, isTypesOfCopyCanView, active) values 
			(NULL, '$service', '$description', '$category', $allowSpecifyQty, $viewTypesOfCopy, $active)");
		if ($query) {
			$this->Mod_logs->create_logs('Created new service ' . $service . ' with description ' . $description);
			return true;
		}
	}

	public function execupdate_service($postData, $servicesid){
		$service = $this->db->escape_str($postData['txtServicename']);
		$description = $this->db->escape_str($postData['txtDescription']);
		$allowSpecifyQty = (isset($postData['allowSpecifyQty'])) ? 1 : 0;
		$viewTypesOfCopy = (isset($postData['viewTypesOfCopy'])) ? 1 : 0;
		$category = $postData['txtCategory'];		
		$active = $this->db->escape_str($postData['active']);
		$query = $this->db->query("update services set services = '$service', description = '$description', mcatid = '$category', 
			isQuantityCanview = $allowSpecifyQty, isTypesOfCopyCanView = $viewTypesOfCopy, active = $active where servicesid = $servicesid");
		if ($query) {
			$this->Mod_logs->create_logs('Updated service to ' . $service . ' with description ' . $description);
			return true;
		}
	}

	public function remove_service($servicesid){
		$this->load->library('util');
		$serviceName = $this->util->getServiceDefintion($servicesid);
		$query = $this->db->query("delete from services where servicesid = $servicesid");
		if ($query) {
			$this->Mod_logs->create_logs('Deleted service ' . $serviceName);
		}
		return $query;
	}

	public function add_req_attach($servicesid, $postData) {
		$reqDesc = $this->db->escape_str($postData['txtAttachDesc']);
		if ($reqDesc != '') {
			$return = $this->db->query("insert into services_attach (servicesAttachId, servicesid, description) values (NULL, '$servicesid', '$reqDesc')");
			return $return;			
		}
		return false;

	}
}