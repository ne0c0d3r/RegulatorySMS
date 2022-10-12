<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Mod_employee extends CI_Model{
	
	public function __construct(){
		parent::__construct();
		
	}

	public function single_retrieve($employeeId) {
		$pis = $this->load->database('pis', true);
		$query = $pis->query("select * from employee where employeeId = '$employeeId'")->row();
		return $query;
	}

	public function getEmployee($type='list'){
		$pis = $this->load->database("pis", true);
		if ($type == 'list') {
			$query = $pis->query("select * from employee order by lastName")->result_array();
		} else if ($type == 'count') {
			$query = $pis->query("select count(*) cnt from employee")->row();
		}
		if ($query) {
			return $query;
		} else {
			return false;
		}
	}

	public function retrieveEmployee(){
		$pis = $this->load->database("pis", true);
		$query = $pis->query("select * from employee order by lastName")->result();
		if ($query) {
			return $query;
		} else {
			return false;
		}
	}

	public function getEmployeePerPage($offset, $limit, $search){
		$pis = $this->load->database("pis", true);
		$query = $pis->query("select * from employee where 
				employeeId like '%" . $search . "%' OR firstName like '%" . $search . "%' OR lastName like '%" . $search . "%' OR middleName like '%" . $search . "%'
				OR middleName like '%" . $search . "%' OR gender like '%" . $search . "%' OR positionName like '%" . $search . "%'
				OR levelShortName like '%" . $search . "%' OR sectionName like '%" . $search . "%' OR departmentShortName like '%" . $search . "%'
				OR plantSiteName like '%" . $search . "%'
			order by lastName limit $offset, $limit ");
		if ($query) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	public function getEmployeeSearchCount($search){
		$pis = $this->load->database("pis", true);
		$query = $pis->query("select count(*) cnt from employee where 
				employeeId like '%" . $search . "%' OR firstName like '%" . $search . "%' OR lastName like '%" . $search . "%' 
				OR middleName like '%" . $search . "%' OR gender like '%" . $search . "%' OR positionName like '%" . $search . "%'
				OR levelShortName like '%" . $search . "%' OR sectionName like '%" . $search . "%' OR departmentShortName like '%" . $search . "%'
				OR plantSiteName like '%" . $search . "%'
			")->row();
		if (count($query) > 0 ) {
			echo json_encode(array('return' => $query->cnt));
		} else {
			echo json_encode(array('return' => 0));
		}
	}

	public function validateAssignData($postData){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('sEmployee', 'Employee', 'required');
		$this->form_validation->set_rules('sAssign', 'Assignment', 'required');
		$this->form_validation->set_rules('sSite[]', 'Site', 'required');
		$this->form_validation->set_rules('sDefaultService[]', 'Default Service ', 'required');

		$employeeId = $postData['sEmployee'];
		$assignment = $postData['sAssign'];
		$siteid = $postData['sSite'];

		$query = $this->db->query("select * from employee_assign where employeeId = '$employeeId' and assignment = '$assignment'")->result();
		if (count($query) <= 0) {
			if ($this->form_validation->run() == FALSE){
				return false;
			} else {
				return true;
			}			
		} else {
			return false;
		}
	}

	public function listOfAssignedEemployee(){

		$where = '';
		if($_SESSION['sms_userlvl'] == 'Dispatcher' || $_SESSION['sms_userlvl'] == 'Counsel'){
			$where = " where employee_assign.assignment in ('Dispatcher', 'Counsel') and sms_users.departmentShortName in ('LEA', 'LEG') ";
		} elseif ($_SESSION['sms_userlvl'] == 'Administrator') {
			$where = " where employee_assign.assignment in ('Dispatcher', 'Counsel', 'Administrator', 'CorPlan') ";
		}

		//$where = $where . " and ifnull(inactive, 0) = 0";

		$query = $this->db->query("select *, IFNULL(inactive, 0) as sinactive
		    from employee_assign 
			left join sms_users 
				on employee_assign.employeeId = sms_users.employeeId $where
			order by employee_assign.inactive, sms_users.lastName");
		if ($query) {
			return $query->result();
		}
		return false;
	}

	public function addAssignedEmployee($postData){
		$this->load->library('util');
		$this->load->model('Mod_syncEmpData');
		$employee = $this->db->escape_str($postData['sEmployee']);
		$assignment = $this->db->escape_str($postData['sAssign']);
		$site = json_encode($postData['sSite']);
		$defaultService = json_encode($postData['sDefaultService']);
		$baseSite = $this->db->escape_str($postData['sBaseSite']);

		$isInsert = $this->db->query("insert into employee_assign (employeeId, assignment, siteid, defaultService, baseSite) values ('$employee', '$assignment', '$site', '$defaultService', '$baseSite')");
		if ($isInsert) {
			$this->Mod_syncEmpData->syncThisEmployee($employee);
			$this->Mod_logs->create_logs('Added new employee assignment to ' . $this->util->getName($employee) . ' as ' . $assignment . ' to site ' . $site);
			return true;
		}
		return false;
	}

	public function updateAssignedEmployee($postData, $assignid){

		$this->load->library('util');
		$employee = $this->db->escape_str($postData['sEmployee']);
		$assignment = $this->db->escape_str($postData['sAssign']);
		$site = json_encode($postData['sSite']);
		$inactive = $this->db->escape_str($postData['sinactive']);
		$defaultService = json_encode($postData['sDefaultService']);
		$baseSite = $this->db->escape_str($postData['sBaseSite']);

		$isUpdate = $this->db->query("update employee_assign set employeeId = '$employee', assignment = '$assignment', siteid = '$site', defaultService = '$defaultService', inactive='$inactive', baseSite='$baseSite' where assignid = $assignid");
		if ($isUpdate) {
			$this->Mod_logs->create_logs('Updated employee assignment to ' . $this->util->getName($employee) . ' as ' . $assignment . ' to site ' . $site);
			return true;
		}
		return false;
	}

	public function remove_assigned($assignid){
		$query = $this->db->query("delete from employee_assign where assignid = $assignid");
		if ($query) {
			$this->Mod_logs->create_logs('Deleted employee assignment #' . $assignid);
		}
		return $query;
	}

	public function getMatchCounsel($servicesid, $siteid){
		$siteid = urldecode($siteid);
		$query = $this->db->query("select * from employee_assign where (assignment = 'Dispatcher' or assignment = 'Counsel') and ifnull(inactive,0) = 0 ");
		if ($query) {
			if (count($query->result())) {
				$empIdMatched = array();
				foreach ($query->result() as $assignedList) {
					$siteIsMatched = false;
					$serviceIsMatched = false;
					$site['list'] = json_decode($assignedList->siteid);
					$siteCnt = count($site['list']);
					for ($i=0; $i < $siteCnt; $i++) { 
						if ($site['list'][$i] == $siteid) {
							$siteIsMatched = true;
						}
					}

					$service['list'] = json_decode($assignedList->defaultService);
					$serviceCnt = count($service['list']);
					for ($i=0; $i < $serviceCnt; $i++) { 
						if ($service['list'][$i] == $servicesid) {
							$serviceIsMatched = true;
						}
					}

					if ($siteIsMatched == true && $serviceIsMatched == true) {
						$empIdMatched[] .= $assignedList->employeeId;
					}
					
				}
				return json_encode($empIdMatched);
				
			}
			return false;
		}
		return false;
	}

	public function single_retrieve_assigned($assignid){
		$query = $this->db->query("select *, IFNULL(inactive,0) sinactive from employee_assign where assignid = $assignid")->row();
		return $query;
	}

	public function getName($employeeId){
		$pis = $this->load->database('pis', true);
		$query = $pis->query("select firstName, lastName, middleName from employee where employeeId in ('$employeeId')")->row();
		if (count($query) > 0) {
			return $query->lastName . ', ' . $query->firstName . ' ' . $query->middleName;
		}
	}

}