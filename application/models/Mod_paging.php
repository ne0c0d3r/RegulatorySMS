<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Mod_paging extends CI_Model{
	
	public function __construct(){
		parent::__construct();
	}

	public function getTotalPage($count, $showRows){
		$numPage = floor($count/$showRows);
		if ($count >= $showRows) {
			$val = array('numPage' => $numPage, 'showRow' => $showRows);
			return $val;
		} else {
			$val = array('numPage' => 1, 'showRow' => $showRows);
			return $val;
		}
	}

}