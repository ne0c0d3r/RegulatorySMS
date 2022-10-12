<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Mod_status extends CI_Model{
	
	public function __construct(){
		parent::__construct();
	}

	public function getStatus(){
		$query = $this->db->query("select * from status");
		if ($query) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function single_retrieve($statusid) {
		$query = $this->db->query("select * from status where statusid = $statusid")->row();
		return $query;
	}

	public function validate_form($postdata){		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('txtStatus', 'Status', 'required');
		if ($this->form_validation->run() == FALSE){
			return false;
		} else {
			return true;
		}
	}

	public function execadd_status($postData){
		$status = $this->db->escape_str($postData['txtStatus']);
		$allowDelete = $this->db->escape_str($postData['allowDelete']);
		$query = $this->db->query("insert into status (statusid, status, allowDelete) values (NULL, '$status', '$allowDelete')");
		if ($query) {
			$this->Mod_logs->create_logs('Added new status ' . $status);
			return true;
		}
	}

	public function execupdate_status($postData, $statusid){
		$status = $this->db->escape_str($postData['txtStatus']);
		$allowDelete = $this->db->escape_str($postData['allowDelete']);
		$query = $this->db->query("update status set status = '$status', allowDelete = '$allowDelete' where statusid = $statusid");
		if ($query) {
			$this->Mod_logs->create_logs('Update status to ' . $status);
			return true;
		}
	}

	public function getLatestStatusLogs($ticketid){
		//$return = $this->db->query("select * from status_logs where ticketid = $ticketid order by statuslogsid desc limit 1")->row();
		$return = $this->db->query("select a.*, ifnull(pstatuslogsid,0) as pid, b.isExcludeCount 
									from status_logs a left join `status` b on b.statusid = a.statusid 
									where a.ticketid = $ticketid order by a.statuslogsid desc limit 1")->row();
		return $return;
	}

	public function getLatestStatusLogsExcluded($ticketid){
		//$return = $this->db->query("select * from status_logs where ticketid = $ticketid order by statuslogsid desc limit 1")->row();
		$return = $this->db->query("select a.*, ifnull(pstatuslogsid,0) as pid, b.isExcludeCount 
									from status_logs a left join `status` b on b.statusid = a.statusid 
									where a.ticketid = $ticketid and IFNULL(b.isExcludeCount,0) = 1 order by a.statuslogsid desc limit 1")->row();
		return $return;
	}

	
}