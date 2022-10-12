<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Mod_logs extends CI_Model{
	
	public function __construct(){
		parent::__construct();
	}

	//ticket attachment
	public function create_logs($description) {
		$ipaddress = $this->get_client_ip();
		$username = 'Failed Logged';
		if (isset($_SESSION['pis_domainName'])) {
			$username = $_SESSION['pis_domainName'];	
		}
		$computername = gethostbyaddr($ipaddress);

		$description = $this->db->escape_str($description);
		$this->db->query("insert into logs (logid, username, ipaddress, computerName, ldate, description) values 
			(NULL, '$username', '$ipaddress', '$computername', current_timestamp(), '$description')");
	}

	public function retrieve_logs($action = 'list'){
		if ($action == 'list') {
			$result = $this->db->query("select * from logs order by ldate desc")->result();
		} elseif ($action == 'count') {
			$result = $this->db->query("select count(*) cnt from logs")->row();
		}
		return $result;
	}

	public function getLogsCount($search = ''){
		//$query = $this->db->query("select count(*) cnt from logs where username like '%" . $search . "%' and logid like '%" . $search . "%'")->row();
		$query = $this->db->query("select count(*) cnt from logs 
				left join sms_users
					on trim(logs.username) = trim(sms_users.domainName)
			where logs.username like '%" . $search . "%' OR logs.logid like '%" . $search . "%' OR sms_users.lastName like '%" . $search . "%' 
				OR sms_users.firstName like '%" . $search . "%' OR sms_users.middleName like '%" . $search . "%' OR sms_users.plantSiteName like '%" . $search . "%' OR logs.description like '%" . $search . "%'")->row();
		if (count($query) > 0 ) {
			echo json_encode(array('return' => $query->cnt));
		} else {
			echo json_encode(array('return' => 0));
		}
	}

	public function getLogsPerPage($offset, $limit, $search){
		$query = $this->db->query("select logs.*, sms_users.lastName, sms_users.firstName, sms_users.middleName, sms_users.plantSiteName from logs 
				left join sms_users
					on logs.username = sms_users.domainName
			where logs.username like '%" . $search . "%' OR logs.logid like '%" . $search . "%' OR sms_users.lastName like '%" . $search . "%' 
				OR sms_users.firstName like '%" . $search . "%' OR sms_users.middleName like '%" . $search . "%' OR sms_users.plantSiteName like '%" . $search . "%' OR logs.description like '%" . $search . "%'
			order by logs.ldate desc limit $offset, $limit");
		if ($query) {
			return $query->result();
		} else {
			return false;
		}
	}


	private function get_client_ip() {
	    $ipaddress = '';
	    if (getenv('HTTP_CLIENT_IP'))
	        $ipaddress = getenv('HTTP_CLIENT_IP');
	    else if(getenv('HTTP_X_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	    else if(getenv('HTTP_X_FORWARDED'))
	        $ipaddress = getenv('HTTP_X_FORWARDED');
	    else if(getenv('HTTP_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_FORWARDED_FOR');
	    else if(getenv('HTTP_FORWARDED'))
	       $ipaddress = getenv('HTTP_FORWARDED');
	    else if(getenv('REMOTE_ADDR'))
	        $ipaddress = getenv('REMOTE_ADDR');
	    else
	        $ipaddress = 'UNKNOWN';
	    return $ipaddress;
	}
}