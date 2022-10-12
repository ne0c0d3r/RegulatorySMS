<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_holiday extends CI_Model{
	
	public function __construct(){
		parent::__construct();
	}

    public function getHoliday(){
		$query = $this->db->query("select * from holiday order by year(`date`) desc, `date` asc");
		if ($query) {
			return $query->result_array();
		} else {
			return false;
		}
	}

    public function getHolidayPerPage($offset, $limit, $search){
		$query = $this->db->query("select * from holiday where description like '%" . $search . "%'  order by year(`date`) desc, `date` asc limit $offset, $limit ");
		if ($query) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function single_retrieve($holidayId){
		$query = $this->db->query("select * from holiday where holidayid = $holidayId")->row();
		return $query;	
	}

	public function execadd_holiday($postData){
		$date = $this->db->escape_str($postData['txtDate']);
		$description = $this->db->escape_str($postData['txtDescription']);
        //$sites = $this->db->escape_str(implode(",", $postData['multiple']));
		$sites = $this->db->escape_str(json_encode($postData['multiple']));
		$query = $this->db->query("insert into holiday(`date`, description, sites)
                                                values('$date', '$description', '$sites')");
		if ($query) {
			$this->Mod_logs->create_logs('Added new status ' . $description);
			return true;
		}
	}

	public function execupdate_holiday($postData, $holidayid){
		$date = $this->db->escape_str($postData['txtDate']);
		$description = $this->db->escape_str($postData['txtDescription']);
		$sites = $this->db->escape_str(json_encode($postData['multiple']));
		$query = $this->db->query("update holiday set `date` = '$date', description = '$description', sites = '$sites' where holidayid = $holidayid");
		if ($query) {
			$this->Mod_logs->create_logs('Update holiday code ' . $holidayid);
			return true;
		}
	}
}