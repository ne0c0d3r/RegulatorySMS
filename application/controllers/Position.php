<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Position extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->Mod_session->check_session();
		$this->load->model(array('Mod_position', 'Mod_paging'));
	}

	public function index(){

		$data['positionCount'] = $this->Mod_position->getPosition('count');

		$this->load->view('header');
		$this->load->view('navigation');
		$this->load->view('position/position-main.php', $data);
		$this->load->view('footer');
	}

	public function getPositionPerPage($offset, $limit, $search = ''){
		$data['positionData'] = $this->Mod_position->getPositionPerPage($offset, $limit, $search);
		$this->load->view('position/position-list.php', $data);
	}

	public function getPositionSearchCount($search = '') {
		$result = $this->Mod_position->getPositionSearchCount($search);
		return $result;
	}
}