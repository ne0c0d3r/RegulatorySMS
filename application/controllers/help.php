<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Help extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->Mod_session->check_session();
		$this->load->model(array('Mod_help', 'Mod_logs'));
	}

	public function index(){
		$data['helpData'] = $this->Mod_help->retrieve_help('count');
		$this->load->view('header');
		$this->load->view('navigation');
		$this->load->view('help/help-main.php', $data);
		$this->load->view('footer');
	}


	public function addNewHelp(){
		$return = $this->Mod_help->addNewHelp($this->input->post());
		if ($return) {
        	$this->session->set_flashdata(array('message' => 'New help added successfully', 'alerttype' => 'alert-success'));
	    } else {
        	$this->session->set_flashdata(array('message' => 'Error on adding help', 'alerttype' => 'alert-danger'));
    	}   
		redirect('help');
	}


	public function getHelpCount($search = ''){
		$result = $this->Mod_help->getHelpCount($search);
		return $result;
	}

	public function getHelpPerPage($offset, $limit, $search = ''){
		$data['helpData'] = $this->Mod_help->getHelpPerPage($offset, $limit, $search);		
		$this->load->view('help/help-list.php', $data);
	}

	public function remove_help($lsmshelpid) {
		$return = $this->Mod_help->remove_help($lsmshelpid);
		if ($return) {
			$this->Mod_logs->create_logs('Deleted help [help id #' . $lsmshelpid . ']');
			$this->session->set_flashdata(array('message' => 'Help deleted successfully', 'alerttype' => 'alert-success'));
	    } else {
        	$this->session->set_flashdata(array('message' => 'Error on deleting help', 'alerttype' => 'alert-danger'));
		}
		redirect('help');
	}
}