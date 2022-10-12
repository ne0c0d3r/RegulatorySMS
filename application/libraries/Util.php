<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	/**
	* 
	*/
class Util extends CI_Model {
	function getServiceDefintion($servicesid){
		$query = $this->db->query("select * from services where servicesid = $servicesid")->row();
		if (count($query) > 0) {
			return $query->services;
		} else {
			return 'Undefined Service Id ' . $servicesid;
		}
	}

	function getStatusDefinition($statusid){
		//$CI =& get_instance();		
		$query = $this->db->query("select * from status where statusid = $statusid")->row();
		if ($query) {
			return $query->status;
		}
	}

	function getPositionName($positionCode){
		$pis = $this->load->database('pis', true); 
		if ($positionCode == 'Requestor' || $positionCode == 'Counsel' || $positionCode == 'IS') {
			return $positionCode;
		} else {
			$query = $pis->query("select * from position where positionCode = '$positionCode'")->row();
			if ($query) {
				return $query->positionName;
			} else {
				echo 'Undefined position';
			}			
		}
	}

	function getStatusId($status) {
		$query = $this->db->query("select * from status where status = '$status'");
		if ($query) {
			return $query->row();
		} else {
			return false;
		}
	}

	function getEmployeeDetail($employeeId){
		$pis = $this->load->database('pis', true); 
		$query = $pis->query("SELECT employee.*, department.departmentName FROM employee 
									left join department on employee.departmentShortName = department.departmentShortName
								where employee.employeeId = '$employeeId'")->row();
		if ($query) {
			return $query;
		} else {
			echo 'Undefined employee';
		}
	}

	function assignedTask($employeeId){
		$query = $this->db->query("select * from employee_assign where employeeId = '$employeeId' order by assignment")->row();
		if (count($query) > 0) {
			return $query->assignment;
		}
		return 'User';
	}

	function employeeOnPosition($positionCode){
		$query = $this->db->query("select * from sms_users where positionCode = $positionCode")->result();
		return $query;

	}

	function getDeptIS($departmentShortName){
		$pis = $this->load->database('pis', true);
		$query = $pis->query("select * from employee where departmentShortName = '$departmentShortName' and superior = 1")->result();
		return $query;
	}

	function getDeptSupperior($employeeCode){
		$pis = $this->load->database('pis', true);
		$query = $pis->query("select * from employee where employeeCode = (select superior from employee where employeeId = '$employeeCode')")->result();
		return $query;
	}

	function getEmpByPosition($positionCode){
		$pis = $this->load->database('pis', true);
		$query = $pis->query("select * from employee where positionName = '$positionCode'")->result();
		return $query;
	}

	function getName($employeeId){
		$query = $this->db->query("select firstName, lastName, middleName from sms_users where employeeId in ('$employeeId')")->row();
		if (count($query) > 0) {
			return $query->lastName . ', ' . $query->firstName . ' ' . $query->middleName;
		}
	}

	function getWorkflow($servicesid, $statusid) {
		$query = $this->db->query("select * from workflow where servicesid = $servicesid and statusref = $statusid")->row();
		if (count($query) > 0) {
			return $query;			
		} 
		return false;
	}

	//dates
	function datetime_std_format($p_date){
		$new_format = date_format(new DateTime($p_date), 'm/d/Y h:iA D');
		return $new_format;
	}

	function date_std_format($p_date){
		$new_format = date_format(new DateTime($p_date), 'm/d/Y');
		return $new_format;
	}

	function today_date(){
		$today_date = $this->db->query("select current_timestamp() today_date")->row();
		return $today_date->today_date;
	}

	function current_class($type){
		$class = $this->router->fetch_class();
		if ($type == 'js') {
			echo $class;
		}
		if ($type == 'php') {
			echo $class;
		}
	}

	public function formatNumber($number, $decimalPlaces){
		return number_format((float)$number, $decimalPlaces, '.', ',');
	}

	public function getRatings($overall){
		$returnval = '';
        if ($overall >= 92) {
            $returnval = "Outstanding";
        } elseif ($overall >= 84 && $overall < 92) {
            $returnval = "Very Good";
        } elseif ($overall >= 76 && $overall < 84) {
            $returnval = "Good";
        } elseif ($overall >= 71 && $overall < 76) {
            $returnval = "Fair";
        } elseif ($overall < 71) {
            $returnval = "NI";
        }
        return $returnval;
	}
	
	public function getOverallScore($ticketid, $questionid)
	{
		$scoreRs = $this->db->query("select * from feedback_score where ticketid = $ticketid and question_id = $questionid")->row();
		return $scoreRs;
	}

}