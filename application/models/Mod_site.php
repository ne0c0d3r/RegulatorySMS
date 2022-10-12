<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Mod_site extends CI_Model{
	
	public function __construct(){
		parent::__construct();
	}

	public function getSites(){
		$pis = $this->load->database("pis", true);
		$query = $pis->query("select * from company order by companyCode");
		if ($query) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	public function getSiteSearchCount($search){
		$pis = $this->load->database("pis", true);
		$query = $pis->query("select count(*) cnt from company where companyName like '%" . $search . "%'")->row();
		if (count($query) > 0 ) {
			echo json_encode(array('return' => $query->cnt));
		} else {
			echo json_encode(array('return' => 0));
		}
	}

	public function getSitePerPage($offset, $limit, $search){
		$pis = $this->load->database("pis", true);
		$query = $pis->query("select * from company where companyName like '%" . $search . "%' order by companyName limit $offset, $limit ");
		if ($query) {
			return $query->result();
		} else {
			return false;
		}
	}

}