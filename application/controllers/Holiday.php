<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Holiday extends CI_Controller{
  public function __construct(){
    parent::__construct();
    $this->Mod_session->check_session();
    $this->load->model(array('Mod_holiday', 'Mod_site',));

    
  }

  public function index(){

    $this->load->library('util');
    $data['util'] = $this->util;
    $data['siteData'] = $this->Mod_site->getSites();
    $data['holidayData'] = $this->Mod_holiday->getHoliday();    
    $this->load->view('header');
    $this->load->view('navigation');
    $this->load->view('holiday/holiday-main', $data);
    $this->load->view('footer');
  }

  public function single_retrieve($holidayid){
    $result = $this->Mod_holiday->single_retrieve($holidayid);
    echo json_encode($result);
  }

  public function getHolidayPerPage($offset, $limit, $search = ''){
    $data['holidayData'] = $this->Mod_holiday->getHolidayPerPage($offset, $limit, $search);
    $this->load->view('holiday/holiday-list.php', $data);
}

  public function add_holiday(){
    $postData = $this->input->post();    
     $isValid = true; 
     if ($isValid) {
       $isInsert = $this->Mod_holiday->execadd_holiday($postData);
       if ($isInsert) {
         redirect('holiday');
       }
     } else {
       echo "not valid";
     }
  }

  public function update_holiday($holidayid){
    $postData = $this->input->post();
    $isValid = true; //$this->Mod_holiday->validate_form($postData);
    if ($isValid) {
       $isUpdate = $this->Mod_holiday->execupdate_holiday($postData, $holidayid);
       if ($isUpdate) {
         redirect('holiday');
       }
     } else {
       echo "not valid";
     }
  }
}