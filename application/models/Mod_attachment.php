<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Mod_attachment extends CI_Model{
	
	public function __construct(){
		parent::__construct();
		
	}

	//ticket attachment
	public function ticketAttachment($ticketid) {
		$query = $this->db->query("select * from ticket_attachment where ticketid = $ticketid order by ticketAttacheId desc");
		if ($query) {
			return $query->result();
		} 
		return false;
	}

	public function removeAttachment($ticketAttacheId, $fileHash){

		//echo base_url('resources/uploads/' . $fileHash);
		//unlink(base_url('resources/uploads/' . $fileHash));
		//echo FCPATH . 'resources/uploads/' . $fileHash;
		$return = unlink(FCPATH . 'resources/uploads/' . $fileHash);
		if ($return) {
			$isDelete = $this->db->query("delete from ticket_attachment where ticketAttacheId = $ticketAttacheId");
			if ($isDelete) {
				return true;
			}
			return false;
		}
		return false;
		//unlink(base_url('resources/uploads/' . $fileHash));
	}


	//status atttachment
	public function statusAttachment($statuslogsid) {
		$query = $this->db->query("select * from status_logs_attachment where statuslogsid = $statuslogsid");
		if ($query) {
			return $query->result();
		} 
		return false;
	}

	public function getRequiredAttached($servicesid) {
		$query = $this->db->query("select * from services_attach where servicesid = $servicesid");
		if ($query) {
			return $query->result();
		} 
		return false;
	}

}