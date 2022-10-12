<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Site extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->Mod_session->check_session();
		$this->load->model('Mod_site');
	}

	public function index(){

		$data['siteData'] = $this->Mod_site->getSites();

		$this->load->view('header');
		$this->load->view('navigation');
		$this->load->view('site/site-main.php', $data);
		$this->load->view('footer');
	}

	public function getSitePerPage($offset, $limit, $search = ''){
		$data['siteData'] = $this->Mod_site->getSitePerPage($offset, $limit, $search);
		$this->load->view('site/site-list.php', $data);
	}

	public function getSiteSearchCount($search = '') {
		$result = $this->Mod_site->getSiteSearchCount($search);
		return $result;
	}

}