<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Mod_email extends CI_Model {

    public $config;

    public function send_email_notification($ticketId) {
        $this->load->helper('url');

        $this->load->model(array('Mod_ticket', 'Mod_employee', 'Mod_status', 'Mod_services', 'Mod_attachment'));
        $ticketData = $this->Mod_ticket->single_retrieve($ticketId); //ticket detail
        $statusData = $this->Mod_status->single_retrieve($ticketData->statusid); //status definition
        $serviceData = $this->Mod_services->single_retrieve($ticketData->servicesid); //service detail
        
        $statuslogsData = $this->Mod_status->getLatestStatusLogs($ticketData->ticketid); //latest status logs 

        if ($statusData->status == 'New') {
        	$attachData = $this->Mod_attachment->ticketAttachment($ticketData->ticketid); //attachment detail
        } else {
        	$attachData = $this->Mod_attachment->statusAttachment($statuslogsData->statuslogsid);
        }

        $supportData = $this->Mod_employee->single_retrieve($ticketData->assignedTo); //assigned detail
        $currentsupportData = $this->Mod_employee->single_retrieve($ticketData->support); //cuurent support detail
        $initiatorData = $this->Mod_employee->single_retrieve($statuslogsData->changedby); //initiator detail

        $from = 'Admin.SMS@globalpower.com.ph';
        $assignedEmail = $supportData->companyEmail; //assigned detail
        $supportEmail = $initiatorData->companyEmail; //adding current suport email 
        $initiatorEmail = $initiatorData->companyEmail; //initiator email

        if ($supportEmail == $assignedEmail) {
            $to = $assignedEmail;
        } else {
            $to = $assignedEmail . ', ' . $supportEmail;
        }

        $requestorData = $this->Mod_employee->single_retrieve($ticketData->requestor); //requestor detail
        $cc = $requestorData->personalEmail;

        if ($ticketData->priority == 1) {
            $strPriority = 'Low';
        } else if ($ticketData->priority == 2) {
            $strPriority = 'Medium';
        } else if ($ticketData->priority == 3) {
            $strPriority = 'High';
        }

        $this->config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'mail.globalpower.com.ph',
            'smtp_port' => 25,
            'mailtype' => 'html',
            'wordwrap' => TRUE
        );
        
		$message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
				<title>Demystifying Email Design</title>
				<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
			</head>
			<body>
				<table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
					<tr>
						<td align="center" style="padding: 10px 0 0px 0;background-color: rgb(79,45,127);color: yellow; font-family: Arial, sans-serif; font-size: 15px;">
							Admin Service Management System v1<sup>Beta</sup><br>
							<table  style="color: #ffffff;font-family: Arial, sans-serif;font-size: 15px;" width="100%">
								<tr>
									<td style="padding: 10px">
										Ticket <br>
									 	#' . $ticketData->ticketid . '
									 </td>
									<td style="padding: 10px">
										Status <br>
									 	<span style="color: yellow;font-weight: bolder;">' . $statusData->status . '</span>
									 </td>
									<td style="padding: 10px">
										Date of Request <br>
									 	' . date_format(new DateTime($ticketData->dateofrequest), 'F d, Y h:iA ') . '
									 </td>
									<td style="padding: 10px">
										Priority <br>
									 	<span style="color: yellow;font-weight: bolder;">' . $strPriority . '</span>
									 </td>
								</tr>
							</table>

						</td>
					</tr>
					<tr>
						<td bgcolor="#092914" style="padding: 10px;color: #cccccc; font-family: Arial, sans-serif; font-size: 15px;font-weight: bolder;">
							Ticket Details
						</td>
					</tr>
					<tr>
						<td bgcolor="#ffffff" style="padding: 0px 30px 10px 30px;border: 1px outset #ccc">
							<table border="0" cellpadding="0" cellspacing="0" width="100%"  style="color: #153643; font-family: Arial, sans-serif; font-size: 12px;">
								<tr>
									<td width="30%" style="padding-top: 7px">
										Request type
									</td>
									<td style="padding-top: 7px">
										<b>' . $serviceData->services . '</b>
									</td>
								</tr>
								<tr>
									<td width="30%" style="padding-top: 7px">
										Requested by
									</td>
									<td style="padding-top: 7px">
										<b>' . $this->Mod_employee->getName($ticketData->requestor) . '</b>
									</td>
								</tr>
								<tr>
									<td width="30%" style="padding-top: 7px">
										Site & Department
									</td>
									<td style="padding-top: 7px">
										<b>' . $initiatorData->plantSiteName . ' - ' . $initiatorData->departmentShortName . '</b>
									</td>
								</tr>
								<tr>
									<td width="30%" style="padding-top: 7px">
										Support
										<br><br><br>
									</td>
									<td style="padding-top: 7px">
										<b>' . $this->Mod_employee->getName($ticketData->assignedTo) . '</b>
										<br><br><br>
									</td>
								</tr>
								<tr>
									<td width="30%" style="padding-top: 7px">
										Subject
									</td>
									<td style="padding-top: 7px">
										<b>' . $ticketData->subject . '</b>
									</td>
								</tr>
								<tr>
									<td width="30%" style="padding-top: 7px;vertical-align: top;">
										Message
									</td>
									<td style="padding-top: 7px">
										' . $ticketData->message . '
									</td>
								</tr>
								
								
							</table>
						</td>
					</tr>
					<tr>
						<td bgcolor="#092914" style="padding: 10px;color: #cccccc; font-family: Arial, sans-serif; font-size: 15px;font-weight: bolder;">
							Status detail
						</td>
					</tr>
					<tr>
						<td bgcolor="#ffffff" style="padding: 0px 30px 10px 30px;border: 1px outset #ccc">
							<table border="0" cellpadding="0" cellspacing="0" width="100%"  style="color: #153643; font-family: Arial, sans-serif; font-size: 12px;">
								<tr>
									<td width="30%" style="padding-top: 7px">
										Status <br>
									 	<span style="color: red;font-weight: bolder;">' . $statusData->status . '</span>
									</td>
									<td style="padding-top: 7px">
										Date of Request <br>
									 	' . date_format(new DateTime($statuslogsData->statusdate), 'F d, Y H:iA ') . '
									</td>
								</tr>
								<tr>
									<td width="30%" style="padding-top: 7px;vertical-align:top">
										Remarks
									</td>
									<td style="padding-top: 7px">
										' . $statuslogsData->remarks . '
									</td>
								</tr>
								<tr>
									<td width="30%" style="padding-top: 7px;vertical-align:top">
										
									</td>
									<td style="padding-top: 7px">
										<b><a href="' . $_SESSION['thisIbaseUrl'] . '?searchticket=' . $ticketData->ticketid . '" target="_blank" style="color:green">View more here</a></b>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td bgcolor="#092914" style="padding: 30px 30px 30px 30px;">
							
						</td>
					</tr>
				</table>
			</body>
			</html>';

        $this->load->library('email', $this->config);
        $this->email->set_newline( "\r\n" );
        $this->email->set_crlf( "\r\n" );
        $this->email->from($from);
        $this->email->to($to);
        $this->email->cc($cc);
        $this->email->subject('Ticket #' . $ticketData->ticketid . ': ' . $ticketData->subject);

        //loading of attachment on email
        foreach ($attachData as $attachList) {
            $this->email->attach('resources/uploads/' . $attachList->fileHash);
        }

        //echo $message;

        $this->email->message($message);
        $isSent = $this->email->send();
        if ($isSent) {
            return true;
        } else {
            return false;
        }
        //show_error($this->email->print_debugger());

        //return true;
    }

}
