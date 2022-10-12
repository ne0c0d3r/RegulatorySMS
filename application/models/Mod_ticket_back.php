<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Mod_ticket extends CI_Model{
	
	public $addParamPaging, $addParamOnLoad;

	public function __construct(){
		parent::__construct();
		if ($_SESSION['sms_userlvl'] == 'Dispatcher') {
			$this->addParamPaging = '';
			$this->addParamOnLoad = '';
		} elseif ($_SESSION['sms_userlvl'] == 'Administrator') {
			$this->addParamPaging = '';
			$this->addParamOnLoad = '';
		} else {
			$this->addParamPaging = " AND (ticket.requestor = '" . $this->session->userdata('sms_userid') . "' OR ticket.support = '" . $this->session->userdata('sms_userid') . "' OR ticket.assignedTo = '" . $this->session->userdata('sms_userid') . "')";			
			$this->addParamOnLoad = " WHERE (ticket.requestor = '" . $this->session->userdata('sms_userid') . "' OR ticket.support = '" . $this->session->userdata('sms_userid') . "' OR ticket.assignedTo = '" . $this->session->userdata('sms_userid') . "')";			
		}
	}

	public function single_retrieve($ticketid){
		$query = $this->db->query("select * from ticket where ticketid = $ticketid")->row();
		return $query;
	}

	public function validate_form($postData){
		$this->load->library('form_validation');
		//$this->form_validation->set_rules('sCategory', 'Category name', 'required');
		$this->form_validation->set_rules('sService', 'Service', 'required');
		$this->form_validation->set_rules('sSite', 'Site', 'required');
		$this->form_validation->set_rules('sSupport', 'Support', 'required');
		$this->form_validation->set_rules('sPriority', 'Priority', 'required');
		$this->form_validation->set_rules('tSubject', 'Subject', 'required');
		$this->form_validation->set_rules('tMessage', 'Message', 'required');

		if ($this->form_validation->run() == FALSE){
			return false;
		} else {
			return true;
		}
	}

	public function validate_escalationForm($postData){
		$this->load->library('form_validation');
		//$this->form_validation->set_rules('sCategory', 'Category name', 'required');
		$this->form_validation->set_rules('txtTicketId', 'Ticket Id ', 'required');
		$this->form_validation->set_rules('txtServiceid', 'Service Id', 'required');
		$this->form_validation->set_rules('newStatus', 'Status ', 'required');
		$this->form_validation->set_rules('routeTo', 'Route to ', 'required');

		if ($this->form_validation->run() == FALSE){
			return false;
		} else {
			return true;
		}
	}


	public function getTicket($type = 'list'){
		if ($this->addParamOnLoad != '') {
			$statusParam = " and statusid != 17";
		} else {
			$statusParam = " where statusid != 17";
		}

		if ($type == 'list') {
			$query = $this->db->query("select * from ticket " . $this->addParamOnLoad . " $statusParam order by ticketid desc")->result();
		} else if ($type == 'count'){
			$query = $this->db->query("select count(*) cnt from ticket " . $this->addParamOnLoad . " $statusParam")->row();
		}
		if ($query) {
			return $query;
		} else {
			return false;
		}
	}

	public function getTicketSearchCount($search){
		$statusParam = '';
		$search = urldecode($search);
		if ($search != '') {
			//$statusParam = " OR status.status like '" . $search . "'";
			$statusParam = " status.status like '"  . $search . "' or ";
		} else { 
			$statusParam = " status.status != 'Close' and ";
		}
		$queryStr = "select count(*) cnt from ticket ticket
					left join sms_users employee
						on ticket.requestor = employee.employeeId
					left join services services
						on ticket.servicesid = services.servicesid
					left join status 
						on ticket.statusid = status.statusid
					where $statusParam (ticket.ticketid like '%" . $search . "%' OR ticket.siteid like '%" . $search . "%'
						 OR employee.firstName like '%" . $search . "%' OR employee.lastName like '%" . $search . "%' OR employee.middleName like '%" . $search . "%'
						 OR services.services like '%" . $search . "%' OR status.status like '%" . $search . "%' OR ticket.subject like '%" . $search . "%')" . $this->addParamPaging;

		$query = $this->db->query($queryStr)->row();
		if (count($query) > 0 ) {
			echo json_encode(array('return' => $query->cnt));
		} else {
			echo json_encode(array('return' => 0));
		}
	}

	public function getTicketPerPage($offset, $limit, $search){
		//$search = str_replace('-space-', ' ', $search);
		$search = urldecode($search);
		$statusParam = '';
		if ($search != '') {
			//$statusParam = " OR status.status like '" . $search . "'";
			$statusParam = " status.status like '"  . $search . "' or ";
		} else { 
			$statusParam = " status.status != 'Close' and ";
		}

		$queryStr = "select ticket.*, employee.firstName, employee.lastName, employee.middleName, employee.departmentShortName from ticket ticket
					left join sms_users employee
						on ticket.requestor = employee.employeeId
					left join services services
						on ticket.servicesid = services.servicesid
					left join status 
						on ticket.statusid = status.statusid
					where $statusParam (ticket.ticketid like '%" . $search . "%' OR ticket.siteid like '%" . $search . "%'
						 OR employee.firstName like '%" . $search . "%' OR employee.lastName like '%" . $search . "%' OR employee.middleName like '%" . $search . "%'
						 OR services.services like '%" . $search . "%' OR ticket.subject like '%" . $search . "%') " . $this->addParamPaging . " order by ticketid desc limit $offset, $limit";

		echo $queryStr;
		//$query = $this->db->query("select * from ticket where ticketid like '%" . $search . "%' OR siteid like '%" . $search . "%' order by ticketid desc limit $offset, $limit ");

		$query = $this->db->query($queryStr);
		if ($query) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function execadd_ticket($postData){
		$this->load->library('util');
		$this->load->model(array('Mod_upload', 'Mod_workflow', 'Mod_email'));

		$return = $this->Mod_email->send_email_notification(1165);
/*		$servicesid = html_escape($postData['sService']);
		$site = html_escape($postData['sSite']);
		$support = html_escape($postData['sSupport']);
		$priority = html_escape($postData['sPriority']);
		$subject = html_escape($postData['tSubject']);
		$message = html_escape($postData['tMessage']);
		$requestor = $this->session->userdata('sms_userid');

		$qty = (isset($postData['txtQty'])) ? $postData['txtQty'] : 0;
		$newRequest = (isset($postData['newRequest'])) ? 1 : 0;
		$originalCopy = (isset($postData['originalCopy'])) ? 1 : 0;
		$certifiedTrue = (isset($postData['certifiedTrue'])) ? 1 : 0;
		$photoCopy = (isset($postData['photoCopy'])) ? 1 : 0;
		$query = $this->db->query("insert into ticket (ticketid, servicesid, requestor, support, assignedTo, dateofrequest, subject, message, priority, statusid, woseq, siteid, 
				qty, originalCopy, certifiedTrue, photoCopy) values 
			(NULL, $servicesid, '$requestor', '$support', '$support', current_timestamp(), '$subject', '$message', '$priority', 19, 1, '$site', 
				$qty, $originalCopy, $certifiedTrue, $photoCopy)");
		if ($query) {
			$ticketid = $this->latestTicketNo($requestor);
			$escalation = $this->Mod_workflow->firstEscalation($servicesid);
																	
			$insertStat = $this->db->query("insert into status_logs (statuslogsid, servicesid, woseq, ticketid, changedby, routedTo, statusid, status, statusdate, remarks) values 
				(NULL, $servicesid, $escalation->woseq, $ticketid, '$requestor', '$support', ". $escalation->statusref . ", '" . $this->util->getStatusDefinition($escalation->statusref) . "', current_timestamp(), '" . $escalation->subject . "')");
			if ($insertStat) {
				$isUploaded = $this->Mod_upload->do_upload($postData);
				if ($isUploaded) {
					$this->Mod_logs->create_logs('Created new ticket #' . $ticketid );
					$return = $this->Mod_email->send_email_notification($ticketid);
					//$return = $this->Mod_email->test_email();
					return $return;
				}
				return false;
			}
			return false;
		}
		return false;*/

	}


	public function execupdate_ticket($postData, $ticketid){
		$this->session->set_userdata('ticketid', $ticketid);
		$this->load->library('util');
		$this->load->model(array('Mod_upload', 'Mod_workflow'));
		$servicesid = html_escape($postData['sService']);
		$site = html_escape($postData['sSite']);
		$support = html_escape($postData['sSupport']);
		$priority = html_escape($postData['sPriority']);
		$subject = html_escape($postData['tSubject']);
		$message = html_escape($postData['tMessage']);
		$requestor = $this->session->userdata('sms_userid');
		//$attachField = $postData['attachField'];		


		$qty = (isset($postData['txtQty'])) ? $postData['txtQty'] : 0;
		$newRequest = (isset($postData['newRequest'])) ? 1 : 0;
		$originalCopy = (isset($postData['originalCopy'])) ? 1 : 0;
		$certifiedTrue = (isset($postData['certifiedTrue'])) ? 1 : 0;
		$photoCopy = (isset($postData['photoCopy'])) ? 1 : 0;

/*		var_dump($isUploaded);
		echo $this->session->userdata('sms_userid');*/
		$query = $this->db->query("update ticket set servicesid = $servicesid, requestor = '$requestor', support = '$support', 
			assignedTo = '$support', subject = '$subject', message = '$message', priority = '$priority', siteid = '$site', qty = $qty,
				originalCopy = $originalCopy, certifiedTrue = $certifiedTrue, photoCopy = $photoCopy 
			where ticketid = $ticketid");
/*		$query = $this->db->query("insert into ticket (ticketid, servicesid, requestor, support, assignedTo, dateofrequest, subject, message, priority, statusid, woseq, siteid) values 
			(NULL, $servicesid, '$requestor', '$support', '$support', current_timestamp(), '$subject', '$message', '$priority', 19, 1, '$site')");*/
		if ($query) {
			$this->Mod_logs->create_logs('Did some changes to ticket #' . $ticketid);
			$isUploaded = $this->Mod_upload->do_upload($postData);
			if ($isUploaded) {
				return true;
			}
		}
		return false;
	}

	public function cancel_ticket($ticketid){
		$this->load->library('util');
		$statusid = $this->util->getStatusId('Cancel');
		//echo $statusid->statusid;
		if ($statusid) {
			$return = $this->db->query("update ticket set statusid = $statusid->statusid where ticketid = $ticketid");
			if ($return) {
				$this->Mod_logs->create_logs('Cancelled ticket #' . $ticketid);
				$insertStat = $this->db->query("insert into status_logs (statuslogsid, servicesid, woseq, ticketid, changedby, routedTo, statusid, status, statusdate, remarks)
						select NULL, servicesid, woseq, ticketid, changedby, routedTo, $statusid->statusid, 'Cancel', current_timestamp(), 'Ticket cancelled'
					from status_logs where ticketid = $ticketid and status = 'New'");
				return $insertStat;
			}
			return false;
		}
		return false;
	}

	public function escalateStatus($postData){
		$this->load->library('util');
		$this->load->model(array('Mod_workflow', 'Mod_upload', 'Mod_email'));
		$ticketid = html_escape($postData['txtTicketId']);
		$servicesid = html_escape($postData['txtServiceid']);
		$newStatus = html_escape($postData['newStatus']);
		$tRemarks = html_escape($postData['tRemarks']);
		$routeTo = html_escape($postData['routeTo']);
		$escalation = $this->Mod_workflow->escalation($servicesid, $newStatus);
		$user = $this->session->userdata('sms_userid');
/*		$isUploaded = $this->Mod_upload->do_upload($postData, 'statusAttach');
		return $isUploaded;*/

/*
echo "update ticket set
    support = (case when " . $escalation->positionCode . " = 'Requestor' then requestor 
    		   when " . $escalation->positionCode . " = 'Counsel' then assignedTo else  end)
where ticketid = $ticketid";
*/

		$isUpdated =  $this->db->query("update ticket set statusid = $newStatus, woseq = " . $escalation->woseq . ", support = '" . $routeTo . "' where ticketid = $ticketid");
		$statusDefinition = $this->util->getStatusDefinition($escalation->statusref);
		if ($isUpdated) {
			if ($statusDefinition == 'New') {
				$strRemarks = $escalation->subject;
			} else {
				$strRemarks = $tRemarks;
			}

			$previousStatus = $this->latestStatusData($ticketid);

			$insertStat = $this->db->query("insert into status_logs (statuslogsid, servicesid, woseq, ticketid, changedby, routedTo, statusid, status, statusdate, remarks) values 
				(NULL, $servicesid, $escalation->woseq, $ticketid, '$user', '$routeTo', ". $escalation->statusref . ", '" . $this->util->getStatusDefinition($escalation->statusref) . "', current_timestamp(), '$strRemarks')");
			if ($insertStat) {
			    $this->Mod_logs->create_logs('Updated ticket #' . $ticketid . ' status to ' . $statusDefinition . ' from ' . $this->util->getStatusDefinition($previousStatus->statusid));
				$isUploaded = $this->Mod_upload->do_upload($postData, 'statusAttach');
				if ($isUploaded) {
					$return = $this->Mod_email->send_email_notification($ticketid);
					return true;
				}
				return false;
			}
			return false;			
		}
		return false;

	}

	private function latestTicketNo($requestor){
		$query = $this->db->query("select max(ticketid) max_id from ticket where requestor = '$requestor'")->row();
		return $query->max_id;
	}

	private function latestStatusLogId($ticketid){
		$query = $this->db->query("select statuslogsid from status_logs where ticketid = $ticketid order by statusdate desc limit 1")->row();
		return $query->statuslogsid;
	}

	private function latestStatusData($ticketid){
		$query = $this->db->query("select * from status_logs where ticketid = $ticketid order by statusdate desc limit 1")->row();
		return $query;
	}

	public function addInsertAttachFile($filename, $hashname, $module, $refData){
		$filename = html_escape($filename);
		$hashname = html_escape($hashname);
		$userid = $this->session->userdata('sms_userid');
		$ticketid_sess = $this->session->userdata('ticketid');
		//print_r($refData);

		switch ($module) {
			case 'ticketAttach':
				$ticketid = $this->latestTicketNo($this->session->userdata('sms_userid'));
				if (isset($ticketid_sess)) {
					$ticketid = $ticketid_sess;
				}
				$attachInsert = $this->db->query("insert into ticket_attachment (ticketAttacheId, ticketid, fileName, fileHash, description, transdate, userid) values 
					(NULL, $ticketid, '" . $filename . "', '" . $hashname . "', '', current_timestamp(), '$userid')");				
				break;
			case 'statusAttach':
				$statuslogsid = $this->Mod_ticket->latestStatusLogId($refData['txtTicketId']);
				$attachInsert = $this->db->query("insert into status_logs_attachment (statusAttacheId, statuslogsid, fileName, fileHash, description, transdate, userid) values 
					(NULL, $statuslogsid, '" . $filename . "', '" . $hashname . "', '', current_timestamp(), '$userid')");				
				break;
		}

		if ($attachInsert) {
			$this->Mod_logs->create_logs('Added attachment to ticket #' . $ticketid_sess . ' with file name ' . $hashname);
			return true;
		}
	}

	public function ticketDetail($ticketid) {
		$query = $this->db->query("select * from ticket where ticketid = $ticketid")->row();
		return $query;
	}

	public function ticketStatus($ticketid) {
		//$query = $this->db->query("select * from status_logs where ticketid = $ticketid order by statusdate desc")->result();

		$query = $this->db->query("select *, ifnull(TIMESTAMPDIFF(minute, startdate, statusdate), 0) diffInMinute from 
			(select a.*,
				ifnull((select statusdate from status_logs 
				where ticketid = a.ticketid and statusdate < a.statusdate 
				order by statusdate desc limit 1), '') as startdate
					from status_logs a
					order by statusdate) slogs
				where ticketid = $ticketid
				order by ticketid, statusdate desc")->result();
		return $query;
	}

	public function assign_ticket($postData){
		$this->load->library('util');
		$this->load->model('Mod_email');
		$ticketid = $postData['txtticketid'];
		$assignTo = $postData['assignTo'];
		$user = $this->session->userdata('sms_userid');

		$ticketData = $this->db->query("select * from ticket where ticketid = $ticketid")->row();
		if (count($ticketData) > 0) {
			$isUpdated = $this->db->query("update ticket set assignedTo = '$assignTo', support = '$assignTo' where ticketid = $ticketid");
			if ($isUpdated) {
				$insertStat = $this->db->query("insert into status_logs (statuslogsid, servicesid, woseq, ticketid, changedby, routedTo, statusid, status, statusdate, remarks) values 
					(NULL, $ticketData->servicesid, $ticketData->woseq, $ticketid, '$user', '$assignTo', ". $ticketData->statusid . ", '" . $this->util->getStatusDefinition($ticketData->statusid) . "', current_timestamp(), 'Change of counsel')");
				if ($insertStat) {
					$this->Mod_logs->create_logs('Ticket #' . $ticketid . ' assigned to ' . $this->util->getName($assignTo) . ' from ' . $this->util->getName($_SESSION['sms_userid']));
					$return = $this->Mod_email->send_email_notification($ticketid);
					return true;
				}
				return false;
			}
			return false;
		}
		return false;
	}


	public function getTicketStatistics(){		
		$result = $this->getStats();
		return $result;
	}

	public function getStats($resulttype = 'normal') {
		$sms_userid = $_SESSION['sms_userid'];
		$result = $this->db->query("select a.rec,
					COALESCE(
				        sum(case 
				     	when remarks = 'Created' then 
				     		tcount
				    end), 0) as created,
					COALESCE(
				        sum(case 
				     	when remarks = 'For Action' then 
				     		tcount
				    end), 0) as forAction,
					COALESCE(
				        sum(case 
				     	when remarks = 'Assigned' then 
				     		tcount
				    end), 0) as assigned 
				from (
				SELECT 1 as rec, COALESCE(count(*), 0) tcount, 'Created' remarks  FROM `ticket` where requestor = '$sms_userid'
				UNION
				SELECT 1 as rec, count(*) tcount, 'For Action' remarks  FROM `ticket` where support = '$sms_userid' and (statusid != 17 and statusid != 24)
				UNION
				SELECT 1 as rec, count(*) tcount, 'Assigned' remarks  FROM `ticket` where assignedTo = '$sms_userid' and (statusid != 24)
				) a
				group by a.rec")->row();
		return $result;			

	}
}