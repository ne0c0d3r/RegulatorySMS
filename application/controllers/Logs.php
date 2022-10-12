<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Logs extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model(array('Mod_logs'));
	}

	public function index(){
		$data['logsData'] = $this->Mod_logs->retrieve_logs('count');
		$this->load->view('header');
		$this->load->view('navigation');
		$this->load->view('logs/logs-main.php', $data);
		$this->load->view('footer'); 
	}

	public function create_logs($description) {

		$this->Mod_logs->create_logs(urldecode($description));
	}

	public function getLogsCount($search = ''){
		$result = $this->Mod_logs->getLogsCount($search);
		return $result;
	}

	public function getLogsPerPage($offset, $limit, $search = ''){
		$data['logsData'] = $this->Mod_logs->getLogsPerPage($offset, $limit, $search);		
		$this->load->view('logs/logs-list.php', $data);
	}
}