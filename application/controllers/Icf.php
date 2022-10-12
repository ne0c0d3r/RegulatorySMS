<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 */
class Icf extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->Mod_session->check_session();
        $this->load->model(array('Mod_icf', 'Mod_ticket'));
    }

    public function index()
    {
        $data['qData'] = $this->Mod_icf->getQuestions(false, null);
        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('icf/icf-main', $data);
        $this->load->view('footer');
    }

    public function feedback_form($ticketid)
    {
        $this->load->library('util');
        $data['util'] = $this->util;

        $data['ticketData']      = $this->Mod_ticket->single_retrieve($ticketid);
        $data['assignedDetail']  = $this->util->getEmployeeDetail($data['ticketData']->assignedTo);
        $data['requestorDetail'] = $this->util->getEmployeeDetail($data['ticketData']->requestor);
        //$data['asdf']
        $data['startDate']     = $this->db->query("select min(statusdate) startDate from status_logs where ticketid = $ticketid")->row();
        $data['endDate']       = $this->db->query("select max(statusdate) endDate from status_logs where ticketid = $ticketid")->row();
        $data['question_data'] = $this->Mod_icf->getQuestions(false, 4);

        $data['feedbackScoreRs'] = $this->Mod_icf->retrieve_icf_byticket($ticketid);
        $data['feedbackFormRs'] = $this->Mod_icf->retrieve_form_data_byticket($ticketid);

        $this->load->view('icf/ICF-form', $data);
    }

    public function feedback_form_rev5($ticketid)
    {
        $this->load->library('util');
        $data['util'] = $this->util;

        $data['ticketData']      = $this->Mod_ticket->single_retrieve($ticketid);
        $data['assignedDetail']  = $this->util->getEmployeeDetail($data['ticketData']->assignedTo);
        $data['requestorDetail'] = $this->util->getEmployeeDetail($data['ticketData']->requestor);
        //$data['asdf']
        $data['startDate']     = $this->db->query("select min(statusdate) startDate from status_logs where ticketid = $ticketid")->row();
        $data['endDate']       = $this->db->query("select max(statusdate) endDate from status_logs where ticketid = $ticketid")->row();
        $data['getToday']      = $this->db->query("select current_timestamp() today, month(current_timestamp()) mm, day(current_timestamp()) dd, year(current_timestamp()) yy ")->row();
        $data['question_data'] = $this->Mod_icf->getQuestions(true, 5);

        $data['feedbackScoreRs'] = $this->Mod_icf->retrieve_icf_byticket($ticketid);
        $data['feedbackFormRs'] = $this->Mod_icf->retrieve_form_data_byticket_rev5($ticketid);

        $this->load->view('icf/ICF-form-Rev5', $data);
    }


    public function addNewQuestion()
    {
        $postData = $this->input->post();
        $return   = $this->Mod_icf->addNewQuestion($postData);
        if ($return) {
            $this->session->set_flashdata(array('message' => 'Successfully added', 'alerttype' => 'alert-success'));
        } else {
            $this->session->set_flashdata(array('message' => 'Error while adding', 'alerttype' => 'alert-danger'));
        }
        redirect(base_url() . 'icf');
    }

    public function remove_question($qId)
    {
        $return = $this->Mod_icf->remove($qId);
        if ($return) {
            $this->session->set_flashdata(array('message' => 'Successfully removed', 'alerttype' => 'alert-success'));
        } else {
            $this->session->set_flashdata(array('message' => 'Error while removing', 'alerttype' => 'alert-danger'));
        }
        redirect(base_url() . 'icf');
    }

    public function submit_ratings($ticketid)
    {
        $postData = $this->input->post();
        $return   = $this->Mod_icf->save_ratings($ticketid, $postData);
        if ($return) {
            $this->session->set_flashdata(array('message' => 'Successfully submitted', 'alerttype' => 'alert-success'));
        } else {
            $this->session->set_flashdata(array('message' => 'Failed to submit, kindly repeat the process', 'alerttype' => 'alert-danger'));
        }
        redirect(base_url());
    }

    public function submit_ratings_rev5($ticketid)
    {
        $postData = $this->input->post();
        $return   = $this->Mod_icf->save_ratings_rev5($ticketid, $postData);
        if ($return) {
            $this->session->set_flashdata(array('message' => 'Successfully submitted', 'alerttype' => 'alert-success'));
        } else {
            $this->session->set_flashdata(array('message' => 'Failed to submit, kindly repeat the process', 'alerttype' => 'alert-danger'));
        }
        redirect(base_url());
    }

    public function validate_icf($ticketid){
        $rev4 = $this->Mod_icf->retrieve_form_data_byticket($ticketid);
        $returnval = 'NONE';
        if (count($rev4) > 0) {
            $returnval = 'rev4';
        } else {
            $rev5 = $this->Mod_icf->retrieve_form_data_byticket_rev5($ticketid);            
            if (count($rev5) > 0) {
                $returnval = 'rev5';
            }
        }
        echo json_encode(array('return' => $returnval));
    }

}
