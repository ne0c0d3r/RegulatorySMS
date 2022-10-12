<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Ticket extends CI_Controller{
  public function __construct(){
    parent::__construct();
    $this->Mod_session->check_session();
    $this->load->model(array('Mod_ticket', 'Mod_attachment', 'Mod_workflow', 'Mod_logs'));
  }

  public function single_retrieve($ticketid){
    $result = $this->Mod_ticket->single_retrieve($ticketid);
    echo json_encode($result);
  }

  public function getTicketPerPage($offset, $limit, $search = ''){
    $this->load->library('util');
    $data['util'] = $this->util;
    $data['ticketData'] = $this->Mod_ticket->getTicketPerPage($offset, $limit, $search);
    $data['mod_attachment'] = $this->Mod_attachment;
    $this->load->view('ticket/ticket-list.php', $data);
  }

  public function getTicketSearchCount($search = '') {
    $result = $this->Mod_ticket->getTicketSearchCount($search);
    return $result;
  }

  public function ticketDetail($ticketid){
    $this->load->library('util');
    $data['util'] = $this->util;
    $data['detailData'] = $this->Mod_ticket->ticketDetail($ticketid);    
    $data['attachData'] = $this->Mod_attachment->ticketAttachment($ticketid);   
    $this->load->view('ticket/ticket-detail', $data);
  }

  public function getTicketAttachment($ticketid){
    $data['attachData'] = $this->Mod_attachment->ticketAttachment($ticketid);
    $this->load->view('ticket/attachView', $data);
  }

  public function ticketStatus($ticketid){
    $this->load->library('util');
    $data['util'] = $this->util;
    $data['ticketData'] = $this->Mod_ticket->single_retrieve($ticketid);
    $data['modAttach'] = $this->Mod_attachment;
    $data['statusData'] = $this->Mod_ticket->ticketStatus($ticketid);
    $this->load->view('ticket/ticket-status', $data);
  }

  public function removeAttachment($ticketAttacheId, $fileHash){
    $return = $this->Mod_attachment->removeAttachment($ticketAttacheId, $fileHash);
    if ($return) {
      $this->Mod_logs->create_logs('Deleted attachment id ' . $ticketAttacheId . ' with file name ' . $fileHash);
    }
    echo $return;
    //echo 'true';
  }

 public function get_required_data_remarks($servicesid, $statusref){
   // $this->load->library('util');
   // $data['util'] = $this->util;
   // $data['workflowData'] = $this->Mod_workflow->workflowOptionStatus($servicesid, $woseq);
   // $data['ticketid'] = $ticketid;
   // $data['servicesid'] = $servicesid;
    $result = $this->Mod_ticket->required_stat_retrieve($servicesid, $statusref);
     echo json_encode($result);

    //$this->load->view('ticket/ticket-change-stat-form', $data);
  }

  public function changeStatForm($servicesid, $woseq, $ticketid){
    $this->load->library('util');
    $data['util'] = $this->util;
    $data['workflowData'] = $this->Mod_workflow->workflowOptionStatus($servicesid, $woseq);
    $data['ticketid'] = $ticketid;
    $data['servicesid'] = $servicesid;
    
    $this->load->view('ticket/ticket-change-stat-form', $data);
  }

  public function escalateStatus(){
    /*echo 'true';*/
    $postData = $this->input->post();
    
    $isValid = $this->Mod_ticket->validate_escalationForm($postData);
    if ($isValid) {
      $result = $this->Mod_ticket->escalateStatus($postData);
      if ($result) {
        $this->session->set_flashdata(array('message' => 'Status updated', 'alerttype' => 'alert-success'));
        echo "true";
      } else {
        $this->session->set_flashdata(array('message' => 'Error on updating status', 'alerttype' => 'alert-danger'));
        echo "false";
      }      
    } else {
      $this->session->set_flashdata(array('message' => 'Invalid entry', 'alerttype' => 'alert-warning'));
      echo "false";
    }
    //redirect(base_url());
  }

  public function create_ticket(){
    $postData = $this->input->post();
    $isValid = $this->Mod_ticket->validate_form($postData);
    if ($isValid) {
      $isInsert = $this->Mod_ticket->execadd_ticket($postData);
      if ($isInsert) {
        echo "true";
      }
    } else {
      echo 'false';
    }
  }

  public function update_ticket($ticketid){
    $postData = $this->input->post();

    $isValid = $this->Mod_ticket->validate_form($postData);
    if ($isValid) {
      $isupdate = $this->Mod_ticket->execupdate_ticket($postData, $ticketid);
      if ($isupdate) {
         $this->session->set_flashdata(array('message' => $ticketid .'Successfully updated', 'alerttype' => 'alert-success'));
        echo "true";
      }
    } else {
      $this->session->set_flashdata(array('message' => $ticketid . 'Failed to update', 'alerttype' => 'alert-danger'));
      echo 'false';
    }
  }

  public function cancel_ticket($ticketid){
    $return = $this->Mod_ticket->cancel_ticket($ticketid);
    echo $return;
  }

  public function assign_ticket(){
    $this->load->library('util');
    $data['util'] = $this->util;
    $postData = $this->input->post();
    $return = $this->Mod_ticket->assign_ticket($postData);
    if ($return) {
      $this->session->set_flashdata(array('message' => 'Ticket successfully assigned', 'alerttype' => 'alert-success'));
    } else {
      $this->session->set_flashdata(array('message' => 'Ticket not assigned', 'alerttype' => 'alert-danger'));
    }
    //echo $return;
    redirect('sms');
  }

  public function ticketStatistics(){
    $data['statsData'] = $this->Mod_ticket->getTicketStatistics();
    $this->load->view('ticket/ticket-statistics', $data);
  }

  public function getStats($resulttype = 'normal') {
    $return = $this->Mod_ticket->getStats($resulttype);    echo json_encode($return);
  }

  public function getRequiredAttach($servicesid) {
    $data['reqAttachData'] = $this->Mod_attachment->getRequiredAttached($servicesid);
    $this->load->view('ticket/ticket-attach', $data);
  }

  public function test_loadCount(){
    $res = $this->Mod_ticket->getTicketSearchCountOnLoad('');
    echo $res->cnt;
  }

  public function sms_complete_loadCount(){
    $res = $this->Mod_ticket->getTicketSearchCountCompletedOnLoad();
    //echo $res;
    echo $res->cnt;
  }

}
