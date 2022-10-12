<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Department extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->Mod_session->check_session();
		$this->load->model('Mod_department');
	}

	public function index(){

		$data['deptData'] = $this->Mod_department->getDepartment();

		$this->load->view('header');
		$this->load->view('navigation');
		$this->load->view('department/department-main.php', $data);
		$this->load->view('footer');
	}

	public function getDepartmentPerPage($offset, $limit, $search = ''){
		$data['departmentData'] = $this->Mod_department->getdepartmentPerPage($offset, $limit, $search);
		$this->load->view('department/department-list.php', $data);
	}

	public function getDepartmentSearchCount($search = '') {
		$result = $this->Mod_department->getDepartmentSearchCount($search);
		return $result;
	}
}