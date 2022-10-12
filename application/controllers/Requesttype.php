<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Requesttype extends CI_Controller{
  public function __construct(){
    parent::__construct();
    $this->Mod_session->check_session();
    $this->load->model('Mod_requesttype');
  }

  public function index(){

    $data['requesttypeData'] = $this->Mod_requesttype->getRequesttype();    
    $this->load->view('header');
    $this->load->view('navigation');
    $this->load->view('requesttype/requesttype', $data);
    $this->load->view('footer');
  }

  public function single_retrieve($statusid){
    $result = $this->Mod_requesttype->single_retrieve($statusid);
    echo json_encode($result);
  }

  public function add_requesttype(){
    $postData = $this->input->post();
    $isValid = $this->Mod_requesttype->validate_form($postData);
    if ($isValid) {
      $isInsert = $this->Mod_requesttype->execadd_requesttype($postData);
      if ($isInsert) {
        redirect('requesttype');
      }
    } else {
      echo "not valid";
    }
  }

  public function update_requesttype($statusid){
    $postData = $this->input->post();
    $isValid = $this->Mod_requesttype->validate_form($postData);
    if ($isValid) {
      $isUpdate = $this->Mod_requesttype->execupdate_requesttype($postData, $statusid);
      if ($isUpdate) {
        redirect('requesttype');
      }
    } else {
      echo "not valid";
    }
  }
}