<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Mod_help extends CI_Model{
	
	public function __construct(){
		parent::__construct();
	}

	public function retrieve_help($action = 'list'){
		if ($action == 'list') {
			$result = $this->db->query("select * from lsmshelp order by dateadded desc")->result();
		} elseif ($action == 'count') {
			$result = $this->db->query("select count(*) cnt from lsmshelp")->row();
		}
		return $result;
	}

	public function getHelpCount($search = ''){
		$query = $this->db->query("select count(*) cnt from lsmshelp")->row();
		if (count($query) > 0 ) {
			echo json_encode(array('return' => $query->cnt));
		} else {
			echo json_encode(array('return' => 0));
		}
	}

	public function getHelpPerPage($offset, $limit, $search){
		$query = $this->db->query("select lsmshelp.* from lsmshelp order by dateadded desc limit $offset, $limit");
		if ($query) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function addNewHelp($postData){
		$description = $this->db->escape_str($postData['txtDesc']);
		$username = $_SESSION['pis_domainName'];

		$fileName = $_FILES['attachField']['name'];
		$tmpName  = $_FILES['attachField']['tmp_name'];
		$fileSize = $_FILES['attachField']['size'];
		$fileType = $_FILES['attachField']['type'];
		$fp      = fopen($tmpName, 'r');
		$content = fread($fp, filesize($tmpName));
		$content = addslashes($content);
		fclose($fp);
		if(!get_magic_quotes_gpc())
		{
		    $fileName = addslashes($fileName);
		}

		$temp = explode(".", $_FILES["attachField"]["name"]);
		$hashFilename = round(microtime(true)) . md5($fileName) . '.' . end($temp);

		$uploaddir =  'resources/helpfiles/';
		$uploadfile = $uploaddir . $hashFilename;

		$isUploaded = move_uploaded_file($_FILES['attachField']['tmp_name'], $uploadfile);

		if ($isUploaded) {
			$return =  $this->db->query("insert into lsmshelp (lsmshelpid, description, fileName, fileHashName, owner, dateadded) values 
				(NULL, '$description', '$fileName', '$hashFilename', '" . $username . "', current_timestamp())");
			if ($return) {
				$this->Mod_logs->create_logs('Created new help [' . $description . ']');
			}
			return $return;
		}
		return false;
	}

	public function remove_help($lsmshelpid) {
		$helpData = $this->db->query("select * from lsmshelp where lsmshelpid = $lsmshelpid")->row();
		$fileRemoval = unlink(FCPATH . 'resources/helpfiles/' . $helpData->fileHashName);
		if ($fileRemoval) {
			$return = $this->db->query("delete from lsmshelp where lsmshelpid = $lsmshelpid");
			return $return;
		}
		return false;
	}
}