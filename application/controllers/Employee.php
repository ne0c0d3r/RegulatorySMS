<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Employee extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->Mod_session->check_session();
		$this->load->model('Mod_employee');
	}

	public function index(){
		$data['empData'] = $this->Mod_employee->getEmployee();
		$this->load->view('header');
		$this->load->view('navigation');
		$this->load->view('employee/employee-main.php', $data);
		$this->load->view('footer');
	}

	public function getEmployeePerPage($offset, $limit, $search = ''){
		$data['empData'] = $this->Mod_employee->getEmployeePerPage($offset, $limit, $search);		
		$this->load->view('employee/employee-list.php', $data);
	}

	public function getEmployeeSearchCount($search = ''){
		$result = $this->Mod_employee->getEmployeeSearchCount($search);
    	return $result;
	}
}