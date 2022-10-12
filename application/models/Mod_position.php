<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Mod_position extends CI_Model{
	
	public function __construct(){
		parent::__construct();
		
	}

	public function getPosition($type = 'list'){
		$pis = $this->load->database("pis", true);
		if ($type == 'list') {
			$query = $pis->query("select * from position order by positionName")->result();
		} else if ($type == 'count'){
			$query = $pis->query("select count(*) cnt from position")->row();
		}
		if ($query) {
			return $query;
		} else {
			return false;
		}
	}


	public function getPositionSearchCount($search){
		$pis = $this->load->database("pis", true);
		$query = $pis->query("select count(*) cnt from position where positionName like '%" . $search . "%'")->row();
		if (count($query) > 0 ) {
			echo json_encode(array('return' => $query->cnt));
		} else {
			echo json_encode(array('return' => 0));
		}
	}

	public function getPositionPerPage($offset, $limit, $search){
		$pis = $this->load->database("pis", true);
		$query = $pis->query("select * from position where positionName like '%" . $search . "%' order by positionName limit $offset, $limit ");
		if ($query) {
			return $query->result();
		} else {
			return false;
		}
	}

}