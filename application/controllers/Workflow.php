<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Workflow extends CI_Controller{

	public function __construct(){
    parent::__construct();
    $this->Mod_session->check_session();
    $this->load->model('Mod_workflow');
  }

	public function add_workflow(){
		$postData = $this->input->post();
		$isValid = $this->Mod_workflow->validate_form($postData);
		if ($isValid) {
			$isInsert = $this->Mod_workflow->execadd_workflow($postData);
			if ($isInsert) {
				echo json_encode(array('return' => true));
			} else {
				echo json_encode(array('return' => false));
			}
		} else {
			echo json_encode(array('return' => false));
		}
		/*echo $postData['txtServicename'];
		echo $postData['txtSequence'];
		echo $postData['txtSubject'];*/
//		echo $postData['statusList'];

	}

	public function workflowTagPosition($servicesid, $statusref, $ticketid){
		$data['assignEmpData'] = $this->Mod_workflow->workflowTagPosition($servicesid, $statusref, $ticketid);
		/*echo print_r($data['assignEmpData']);*/
		$data['statusDesc'] = $this->util->getStatusDefinition($statusref);
		$this->load->view('ticket/ticket-route-to', $data);
	}

	public function remove_workflow($woid){
		$return = $this->Mod_workflow->remove_workflow($woid);
		if ($return) {
			redirect('services');
		} else {
			echo 'error';
		}
	}

	public function single_retrieve($woid){
	    $result = $this->Mod_workflow->single_retrieve($woid);
	    echo json_encode($result);
	}

	public function update_workflow($woid){
	    $postData = $this->input->post();
	    $isValid = $this->Mod_workflow->validate_form($postData);
	    if($isValid) {
	      $isUpdate = $this->Mod_workflow->execupdate_workflow($postData, $woid);
	      if ($isUpdate) {
	        echo json_encode(array('return' => true));
	      }
	    } else {
	      echo json_encode(array('return' => false));
	    }   
  	}

}