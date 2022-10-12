<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Status extends CI_Controller{
  public function __construct(){
    parent::__construct();
    $this->Mod_session->check_session();
    $this->load->model('Mod_status');
  }

  public function index(){

    $data['statusData'] = $this->Mod_status->getStatus();

    $this->load->view('header');
    $this->load->view('navigation');
    $this->load->view('status/status', $data);
    $this->load->view('footer');
  }

  public function single_retrieve($statusid){
    $result = $this->Mod_status->single_retrieve($statusid);
    echo json_encode($result);
  }

  public function add_status(){
    $postData = $this->input->post();
    $isValid = $this->Mod_status->validate_form($postData);
    if ($isValid) {
      $isInsert = $this->Mod_status->execadd_status($postData);
      if ($isInsert) {
        redirect('status');
      }
    } else {
      echo "not valid";
    }
  }

  public function update_status($statusid){
    $postData = $this->input->post();
    $isValid = $this->Mod_status->validate_form($postData);
    if ($isValid) {
      $isUpdate = $this->Mod_status->execupdate_status($postData, $statusid);
      if ($isUpdate) {
        redirect('status');
      }
    } else {
      echo "not valid";
    }
  }

  public function remove_status($statusid){
    $query = $this->db->query("delete from status where statusid = $statusid");
    if ($query) {
      $this->Mod_logs->create_logs('Deleted status #' . $statusid);
      redirect('status');
    } else {
      return false;
    }
  }

  public function change_ticket_status(){
    
  }
}