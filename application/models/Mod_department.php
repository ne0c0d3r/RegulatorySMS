<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Mod_department extends CI_Model{
	
	public function __construct(){
		parent::__construct();
	}

	public function getDepartment(){
		$pis = $this->load->database("pis", true);
		$query = $pis->query("select * from department order by departmentShortName");
		if ($query) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	public function getDepartmentSearchCount($search){
		$pis = $this->load->database("pis", true);
		$query = $pis->query("select count(*) cnt from department where departmentName like '%" . $search . "%'")->row();
		if (count($query) > 0 ) {
			echo json_encode(array('return' => $query->cnt));
		} else {
			echo json_encode(array('return' => 0));
		}
	}

	public function getDepartmentPerPage($offset, $limit, $search){
		$pis = $this->load->database("pis", true);
		$query = $pis->query("select * from department where departmentName like '%" . $search . "%' order by departmentName limit $offset, $limit ");
		if ($query) {
			return $query->result();
		} else {
			return false;
		}
	}

}