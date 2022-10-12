<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 */
class Reports extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->Mod_session->check_session();

    }

    public function index()
    {

        $this->load->view('header');
        $this->load->view('navigation');
        $this->load->view('reports/reports-main');
        $this->load->view('footer');
    }

    public function icf_report_params()
    {
        $this->load->view('reports/icf-report-params');
    }

    public function icf_report_params_rev5()
    {
        $this->load->view('reports/icf-report-params-rev5');
    }

    public function sla_report_params()
    {
        $this->load->view('reports/sla-report-params');
    }

    public function sla_report_params_v2()
    {
        $this->load->view('reports/sla-report-params-v2');
    }

    public function generate_icf_summary($type, $from, $to)
    {
        $this->load->library('util');
        $this->load->model('Mod_icf');
        $data['util']       = $this->util;
        $data['summaryRs']  = $this->Mod_icf->generate_icf_summary($type, $from, $to);
        $data['summaryicf'] = $this->Mod_icf->summaryicf($type, $from, $to);
        $data['from']       = $from;
        $data['to']         = $to;
        //$this->load->view('reports/icf_summary', $data);
        require_once APPPATH . 'third_party/html2pdf/html2pdf.class.php'; // load the main class file (if you're not using autoloader)
        $html2pdf = new HTML2PDF('P', 'Letter', 'fr', true, 'UTF-8', array(1, 10, 0, 0));

        $html2pdf->WriteHTML($this->load->view('reports/icf_summary', $data, true));
        $varTime = md5(date('m/d/Y'));
        $html2pdf->Output('icf_report_' . $type . '_' . substr($varTime, 0, 10) . '.pdf');
    }

    public function ExportRawDataCSV()
    {
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->model('Mod_icf');
        $delimiter = ",";
        $newline   = "\r\n";
        $filename  = 'ICF_LEGAL_rawdata_' . hash_hmac('sha256', time(), 'toinkz') . ".csv";
        $dataSend  = $this->input->get();
        if (count($this->input->post()) > 0) {
            $dataSend = $this->input->post();
        }
        //$where  = $this->setup_param($dataSend);
        $result = $this->Mod_icf->get_icf_rawdata($dataSend);
        $data   = $this->dbutil->csv_from_result($result, $delimiter, $newline);
        //echo $data;
        echo force_download($filename, $data);
    }

    public function export_sla_to_csv($v = 1)
    {
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->model(array('Mod_icf', 'Mod_ticket'));
        $delimiter = ",";
        $newline   = "\r\n";
        $filename  = 'SLA_LEGAL_RAWDATA_' . substr(hash_hmac('sha256', time(), 'toinkz'), 0, 5) . ".csv";
        $dataSend  = $this->input->get();
        if (count($this->input->post()) > 0) {
            $dataSend = $this->input->post();
        }
        //$where  = $this->setup_param($dataSend);
        $result = [];
        if ($v == 1) {
            # code...
            $result = $this->Mod_ticket->generate_sla_report($dataSend);
        } else {
            $result = $this->Mod_ticket->generate_sla_report_v2($dataSend);            
        }
        //$result = $this->Mod_icf->get_icf_rawdata($dataSend);
        $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
        /*echo "<pre>";
        echo $data;*/
        echo force_download($filename, $data);
    }

}
