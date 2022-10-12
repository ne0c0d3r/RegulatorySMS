<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Mod_workflow extends CI_Model{
	
	public function __construct(){
		parent::__construct();
		$this->load->library('util');
	}


	public function single_retrieve($woid){
		$query = $this->db->query("select * from workflow where woid = $woid")->row();
		return $query;	
	}

	public function validate_form($postData){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('txtServicename', 'Service name', 'required');
		$this->form_validation->set_rules('txtServiceid', 'Service id', 'required');
		$this->form_validation->set_rules('txtSequence', 'Service', 'required');
		$this->form_validation->set_rules('txtSubject', 'Title', 'required');
		$this->form_validation->set_rules('txtPosition', 'Position', 'required');
		$this->form_validation->set_rules('selectStatus', 'Status', 'required');
		$this->form_validation->set_rules('statusList[]', 'Status selection', 'trim|required');
		$this->form_validation->set_rules('isRemarksRequired', 'Remarks Required', 'required');
		
		if ($this->form_validation->run() == FALSE){
			return false;
		} else {
			return true;
		}
	}

	public function execadd_workflow($postData){
		
		$service = $this->db->escape_str($postData['txtServicename']);
		$servicesid = $this->db->escape_str($postData['txtServiceid']);
		$sequence = $this->Mod_workflow->gen_workflowseq($servicesid);
		$subject = $this->db->escape_str($postData['txtSubject']);
		$position = $postData['txtPosition'];
		$statusRef = $this->db->escape_str($postData['selectStatus']);
		$statusList = json_encode($postData['statusList']);
		$query = $this->db->query("insert into workflow (woid, servicesid, woseq, subject, positionCode, statusref, selectionStatus) values 
			(NULL, $servicesid, $sequence, '$subject', '$position', $statusRef, '$statusList')");
		
		if ($query) {
			$this->Mod_logs->create_logs('Added workflow sequence #' . $sequence . ' with subject ' . $subject . ' to service ' . $this->util->getServiceDefintion($servicesid));
			return true;
		}
	}

	public function workflowOptionStatus($servicesid, $woseq){
		$query = $this->db->query("select * from workflow where servicesid = $servicesid and woseq = $woseq")->row();
		return $query;
	}

	public function workflowTagPosition($servicesid, $statusref, $ticketid){
	    $this->load->library('util');
		$woPositionrs = false;
		$query = $this->db->query("select * from workflow where servicesid = $servicesid and statusref = $statusref")->row();
		//var_dump($query);
		if (count($query) > 0) {
			switch ($query->positionCode) {
				case 'Requestor':
					// get requestor id and detail
					$woPositionrs = $this->db->query("select sms_users.* 
					from ticket 
					left join sms_users on ticket.requestor = sms_users.employeeId
							where ticketid = $ticketid")->result();
					break;
				case 'Counsel':
					// get support id and detail
					/*$woPositionrs = $this->db->query("select sms_users.* from ticket 
						left join sms_users 
							on ticket.assignedTo = sms_users.employeeId
							where ticketid = $ticketid")->result();*/

					$woPositionrs = $this->db->query("select sms_users.*
													from ticket 
													left join sms_users on ticket.assignedTo = sms_users.employeeId
													where ticketid = $ticketid
													UNION
													select sms_users.*
													from sms_users 
													right join employee_assign on sms_users.employeeId = employee_assign.employeeId 
													where employee_assign.assignment = 'Counsel' and ifnull(inactive, 0) = 0")->result();
					break;
				case 'IS':
					//get head of the dept reference to requestor's department
					$ticketData = $this->db->query("select sms_users.* from ticket 
						left join sms_users 
							on ticket.requestor = sms_users.employeeId
							where ticketid = $ticketid")->row();
					//var_dump($ticketData);

					$headData = $this->util->getDeptSupperior($ticketData->employeeId);
					$ISempId = '';
					foreach ($headData as $headList) {
						$counter = 1;

						if ($counter == 1) {
							$ISempId = "'" . $headList->employeeId . "'";
						} else {
							$ISempId += ",'" . $headList->employeeId . "'";
						}
					}
					if (!empty($ISempId)) {
						$woPositionrs = $this->db->query("select sms_users.* from sms_users 
								where employeeId in (" . $ISempId . ")")->result();
					}
					break;
				default:
					//get positionCode from workflow and get detail from sms_users reference to positionCode
					$empInPosition = $this->util->getEmpByPosition($query->positionCode);
					//var_dump($empInPosition);
					$empId = '';
					foreach ($empInPosition as $empInPositionList) {
						$counter = 1;
						if ($counter == 1) {
							$empId = "'" . $empInPositionList->employeeId . "'";
						} else {
							$empId += ",'" . $empInPositionList->employeeId . "'";
						}
					}
					$woPositionrs = $this->db->query("select sms_users.* from sms_users 
							where employeeId in (" . $empId . ")")->result();					
					break;
			}
			return $woPositionrs;
		}
		

	}

	public function gen_workflowseq($servicesid){
		$query = $this->db->query("select * from workflow where servicesid = $servicesid")->result_array();
		return count($query)+1;		
	}

	public function get_isRequiredRemarks($servicesid){
		$query = $this->db->query("select isRemarksRequired from workflow where servicesid = $servicesid")->row();
		return $query;	
	}


	public function execupdate_workflow($postData, $woid){
		$sequence = $this->db->escape_str($postData['txtSequence']);
		$service = $this->db->escape_str($postData['txtServicename']);
		$servicesid = $this->db->escape_str($postData['txtServiceid']);
		$subject = $this->db->escape_str($postData['txtSubject']);
		$position = $postData['txtPosition'];
		$statusRef = $this->db->escape_str($postData['selectStatus']);
		$statusList = json_encode($postData['statusList']);
		$isRemarksRequired = $this->db->escape_str($postData['isRemarksRequired']);

		$query = $this->db->query("update workflow set woseq = $sequence, servicesid = $servicesid, subject = '$subject', positionCode = '$position', statusref = $statusRef, selectionStatus = '$statusList', isRemarksRequired = '$isRemarksRequired' where woid = $woid");
		if ($query) {
			$this->Mod_logs->create_logs('Updated workflow workflow #' . $woid . ' with subject ' . $subject . ' for service ' . $this->util->getServiceDefintion($servicesid));
			return true;
		}
	}

	public function remove_workflow($woid){
		$query = $this->db->query("delete from workflow where woid = $woid");
		if ($query) {
			$this->Mod_logs->create_logs('Deleted workflow #' . $woid);
		}
		return $query;
	}

	public function firstEscalation($servicesid){
		$query = $this->db->query("select * from workflow where servicesid = $servicesid order by woseq limit 1")->row();
		return $query;
	}

	public function firstEscalationV2($servicesid, $userlevel)
	{
		if ($userlevel == "Administrator" || $userlevel == "Counsel" || $userlevel == "Dispatcher ")
		{
			$query = $this->db->query("select * from workflow where servicesid = $servicesid order by woseq limit 1")->row();
		}
		else
		{
			$query = $this->db->query("select * from workflow where servicesid = $servicesid and woseq > 0 order by woseq limit 1")->row();
		}
		return $query;
	}

	public function escalation($servicesid, $statusref){
		$query = $this->db->query("select * from workflow where servicesid = $servicesid and statusref = $statusref")->row();
		return $query;
	}
}
