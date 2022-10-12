<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Services extends CI_Controller{
  public function __construct(){
    parent::__construct();
    $this->Mod_session->check_session();
    $this->load->model('Mod_services');
  }

  public function index(){
/*    $pis = $this->load->database('pis', true);

    $pis->query('select * from company');*/
    $data['servData'] = $this->Mod_services->getServices();

    $this->load->view('header');
    $this->load->view('navigation');
    $this->load->view('services/services-main.php', $data);
    $this->load->view('footer');
  }

  public function remove_service($servicesid){
    $return = $this->Mod_services->remove_service($servicesid);
    if ($return) {
      redirect('services');
    }
  }

  public function single_retrieve($servicesid){
    $result = $this->Mod_services->single_retrieve($servicesid);
    echo json_encode($result);
  }

  public function getWorkflow($servicesid){
    $this->load->library('util');
    $data['util'] = $this->util;
    $this->load->model(array('Mod_status', 'Mod_workflow', 'Mod_position'));
    $data['serviceData'] = $this->Mod_services->single_retrieve($servicesid);
    $data['workflowData'] = $this->Mod_services->getWorkflow($servicesid);
    $data['statusData'] = $this->Mod_status->getStatus();
    $data['seqData'] = $this->Mod_workflow->gen_workflowseq($servicesid);
    $data['positionData'] = $this->Mod_position->getPosition();
    $data['isRemarksData'] = $this->Mod_workflow->get_isRequiredRemarks($servicesid); //added by Jason



    //print_r($data);

    $this->load->view('services/services-escalation', $data, false);
  }

  public function add_service(){
    $postData = $this->input->post();
    //var_dump($postData);
    
    $isValid = $this->Mod_services->validate_form($postData);
    if ($isValid) {
      $isInsert = $this->Mod_services->execadd_service($postData);
      if ($isInsert) {
        for ($i=0; $i < count($postData['txtAttachDesc']); $i++) { 
          echo $postData['txtAttachDesc'][$i];
        }
        redirect('services');
      }
    } else {
      echo "not valid";
    }

  }

  public function update_service($servicesid){
    $postData = $this->input->post();
    $isValid = $this->Mod_services->validate_form($postData);
    if($isValid) {
      $isUpdate = $this->Mod_services->execupdate_service($postData, $servicesid);
      if ($isUpdate) {
        redirect('services');
      }
    } else {
      echo "not valid";
    }   
  }

  public function getRequiredAttached($servicesid){
    $this->load->model(array('Mod_attachment'));
    $data['reqAttachData'] = $this->Mod_attachment->getRequiredAttached($servicesid);
    $data['servicesid'] = $servicesid;
    $this->load->view('services/services-req-attach', $data);
  }

  public function add_req_attach($servicesid) {
    $this->load->model('Mod_services');
    $postData = $this->input->post();
    $return = $this->Mod_services->add_req_attach($servicesid, $postData);
    if ($return) {
      $this->session->set_flashdata(array('message' => 'Successfully added', 'alerttype' => 'alert-success'));
    } else {
      $this->session->set_flashdata(array('message' => 'Error upon saving', 'alerttype' => 'alert-danger'));
    }
    redirect('services');
  }

  public function remove_req_attach($servicesAttachId) {
    $return = $this->db->query("delete from services_attach where servicesAttachId = $servicesAttachId");
    if ($return) {
      $this->session->set_flashdata(array('message' => 'Successfully removed', 'alerttype' => 'alert-success'));
    } else {
      $this->session->set_flashdata(array('message' => 'Error while removing', 'alerttype' => 'alert-danger'));
    }
    redirect('services');
    
  }
}
