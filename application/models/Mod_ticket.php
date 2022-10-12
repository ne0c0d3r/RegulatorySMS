<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 */
class Mod_ticket extends CI_Model
{

    public $addParamPaging, $addParamOnLoad;

    public function __construct()
    {
        parent::__construct();
        if ($_SESSION['sms_userlvl'] == 'Dispatcher') {
            $this->addParamPaging = '';
            $this->addParamOnLoad = '';
        } elseif ($_SESSION['sms_userlvl'] == 'Administrator') {
            $this->addParamPaging = '';
            $this->addParamOnLoad = '';
        } else {
            $this->addParamPaging = " AND (ticket.requestor = '" . $this->session->userdata('sms_userid') . "' OR ticket.support = '" . $this->session->userdata('sms_userid') . "' OR ticket.assignedTo = '" . $this->session->userdata('sms_userid') . "')";
            $this->addParamOnLoad = " WHERE (ticket.requestor = '" . $this->session->userdata('sms_userid') . "' OR ticket.support = '" . $this->session->userdata('sms_userid') . "' OR ticket.assignedTo = '" . $this->session->userdata('sms_userid') . "')";
        }
    }

    public function single_retrieve($ticketid)
    {
        $query = $this->db->query("select ticket.*, services.services from ticket left join services on ticket.servicesid = services.servicesid where ticket.ticketid = $ticketid")->row();
        return $query;
    }

    public function validate_form($postData)
    {
        $this->load->library('form_validation');
        //$this->form_validation->set_rules('sCategory', 'Category name', 'required');
        $this->form_validation->set_rules('sService', 'Service', 'required');
        $this->form_validation->set_rules('sSite', 'Site', 'required');
        $this->form_validation->set_rules('sSupport', 'Support', 'required');
        $this->form_validation->set_rules('sPriority', 'Priority', 'required');
        $this->form_validation->set_rules('tSubject', 'Subject', 'required');
        $this->form_validation->set_rules('tMessage', 'Message', 'required');

        if ($this->form_validation->run() == false) {
            return false;
        } else {
            return true;
        }
    }

    public function validate_escalationForm($postData)
    {
        $this->load->library('form_validation');
        //$this->form_validation->set_rules('sCategory', 'Category name', 'required');
        $this->form_validation->set_rules('txtTicketId', 'Ticket Id ', 'required');
        $this->form_validation->set_rules('txtServiceid', 'Service Id', 'required');
        $this->form_validation->set_rules('newStatus', 'Status ', 'required');
        $this->form_validation->set_rules('routeTo', 'Route to ', 'required');

        if ($this->form_validation->run() == false) {
            return false;
        } else {
            return true;
        }
    }

    public function getTicket($type = 'list')
    {
        if ($this->addParamOnLoad != '') {
            $statusParam = " and statusid != 17";
        } else {
            $statusParam = " where statusid != 17";
        }

        if ($type == 'list') {
            $query = $this->db->query("select * from ticket " . $this->addParamOnLoad . " $statusParam order by ticketid desc")->result();
        } else if ($type == 'count') {
            $query = $this->db->query("select count(*) cnt from ticket " . $this->addParamOnLoad . " $statusParam")->row();
        }
        if ($query) {
            return $query;
        } else {
            return false;
        }
    }

    public function getTicketSearchCount($search)
    {
        $statusParam = '';
        $search      = urldecode($search);
        if ($search != '') {
            //$statusParam = " OR status.status like '" . $search . "'";
            //$statusParam = " status.status like '"  . $search . "' or ";
        } else {
            $statusParam = " status.status != 'Returned' and ";
        }
        $queryStr = "select count(*) cnt from ticket ticket
					left join sms_users employee
						on ticket.requestor = employee.employeeId
					left join services services
						on ticket.servicesid = services.servicesid
					left join status
						on ticket.statusid = status.statusid
					where $statusParam (ticket.ticketid like '%" . $search . "%' OR ticket.siteid like '%" . $search . "%'
						 OR employee.firstName like '%" . $search . "%' OR employee.lastName like '%" . $search . "%' OR employee.middleName like '%" . $search . "%'
						 OR services.services like '%" . $search . "%' OR status.status like '%" . $search . "%' OR ticket.subject like '%" . $search . "%')" . $this->addParamPaging;

        $query = $this->db->query($queryStr)->row();
        if (count($query) > 0) {
            echo json_encode(array('return' => $query->cnt));
        } else {
            echo json_encode(array('return' => 0));
        }
    }

    public function getTicketSearchCountOnLoad($search)
    {
        $statusParam = '';
        $search      = urldecode($search);
        if ($search == '') {
            $statusParam = " status.status != 'Close' and ";
        }
        $queryStr = "select count(*) cnt from ticket ticket
					left join sms_users employee
						on ticket.requestor = employee.employeeId
					left join services services
						on ticket.servicesid = services.servicesid
					left join status
						on ticket.statusid = status.statusid
					where $statusParam (ticket.ticketid like '%" . $search . "%' OR ticket.siteid like '%" . $search . "%'
						 OR employee.firstName like '%" . $search . "%' OR employee.lastName like '%" . $search . "%' OR employee.middleName like '%" . $search . "%'
						 OR services.services like '%" . $search . "%' OR status.status like '%" . $search . "%' OR ticket.subject like '%" . $search . "%')" . $this->addParamPaging;

        $query = $this->db->query($queryStr);
        if (count($query) > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function getTicketSearchCountCompletedOnLoad()
        {
            $statusParam = '';
            $search      = ''; 
            if ($search == '') {
                $statusParam = " (status.status like '%comp%' OR status.status like '%accept%')";
            }
            $queryStr = "select count(*) cnt from ticket ticket
                           left join status
                            on ticket.statusid = status.statusid
                        where ticket.requestor = '" . $this->session->userdata('sms_userid') . "' AND $statusParam" ;

                           //  return $queryStr;

        

            $query = $this->db->query($queryStr);
            if (count($query) > 0) {
                return $query->row();
            } else {
                return false;
            }
             
        }

    public function getTicketPerPage($offset, $limit, $search)
    {
        //$search = str_replace('-space-', ' ', $search);
        $search      = urldecode($search);
        $statusParam = '';
        if ($search != '') {
            //$statusParam = " OR status.status like '" . $search . "'";
            //$statusParam = " status.status like '"  . $search . "' or ";
        } else {
            $statusParam = " status.status != 'Close' and ";
        }

        $queryStr = "select ticket.*, employee.firstName, employee.lastName, employee.middleName, employee.departmentShortName, concat(left(support.firstName, 1), support.lastName) lastAssigned from ticket ticket
					left join sms_users employee
						on ticket.requestor = employee.employeeId
					left join services services
						on ticket.servicesid = services.servicesid
					left join status
						on ticket.statusid = status.statusid
					left join sms_users support
						on ticket.support = support.employeeId
					where $statusParam (ticket.ticketid like '%" . $search . "%' OR ticket.siteid like '%" . $search . "%'
						 OR employee.firstName like '%" . $search . "%' OR employee.lastName like '%" . $search . "%' OR employee.middleName like '%" . $search . "%'
						 OR services.services like '%" . $search . "%' OR status.status like '%" . $search . "%' OR ticket.subject like '%" . $search . "%')" . $this->addParamPaging . " order by ticketid desc limit $offset, $limit";

        //echo $queryStr;
        //$query = $this->db->query("select * from ticket where ticketid like '%" . $search . "%' OR siteid like '%" . $search . "%' order by ticketid desc limit $offset, $limit ");

        $query = $this->db->query($queryStr);
        if ($query) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function execadd_ticket($postData)
    {
        $this->load->library('util');
        $this->load->model(array('Mod_upload', 'Mod_workflow', 'Mod_email'));
        $servicesid = $this->db->escape_str($postData['sService']);
        $site       = $this->db->escape_str($postData['sSite']);
        $support    = $this->db->escape_str($postData['sSupport']);
        $priority   = $this->db->escape_str($postData['sPriority']);
        $subject    = $this->db->escape_str($postData['tSubject']);
        $message    = $this->db->escape_str($postData['tMessage']);
        

        //$escalation = $this->Mod_workflow->firstEscalation($servicesid);
        $escalation = $this->Mod_workflow->firstEscalationV2($servicesid, $this->session->userdata('sms_userlvl'));

        if($this->session->userdata('sms_userlvl') == "Administrator" || $this->session->userdata('sms_userlvl') == "Counsel") 
        {
            $requestor  = $this->db->escape_str($postData['sEmployee']);
            $requesttype = $this->db->escape_str($postData['sRequestType']);
            $assignTo =  $this->db->escape_str($postData['sEmployee']);
            $changedby = $support;
        }
        else
        {
            $requestor  = $this->session->userdata('sms_userid');
            $requesttype = "0"; 
            $assignTo =  $support;
            $changedby = $requestor;
        }

        $counselSite = $this->counselBaseSite($support);
        $qty           = (isset($postData['txtQty'])) ? $postData['txtQty'] : 0;
        $newRequest    = (isset($postData['newRequest'])) ? 1 : 0;
        $originalCopy  = (isset($postData['originalCopy'])) ? 1 : 0;
        $certifiedTrue = (isset($postData['certifiedTrue'])) ? 1 : 0;
        $photoCopy     = (isset($postData['photoCopy'])) ? 1 : 0;

        //$attachField = $postData['attachField'];

/*        var_dump($isUploaded);
echo $this->session->userdata('sms_userid');*/
        // if($isconfirmation == 0)
        // {
        //    $assignTo =  $this->db->escape_str($postData['tMessage']);
        // }
        // else
        // {
        //     $assignTo =  $this->db->escape_str($postData['tMessage']);
        // }


        $query = $this->db->query("insert into ticket (ticketid, servicesid, requestor, support, assignedTo, dateofrequest, subject, message, priority, statusid, woseq, siteid,
				qty, originalCopy, certifiedTrue, photoCopy, requesttypeid, counselBaseSite) values
			(NULL, $servicesid, '$requestor', '$assignTo', '$support', if(TIME(current_timestamp()) >= '17:00:00', CONCAT(DATE(DATE_ADD(current_timestamp(), INTERVAL 1 DAY)), ' ', '00:00:00'), current_timestamp()), '$subject', '$message', '$priority', $escalation->statusref, $escalation->woseq, '$site',
				$qty, $originalCopy, $certifiedTrue, $photoCopy, $requesttype, '$counselSite')");
        if ($query) {
            $ticketid   = $this->latestTicketNo($requestor);
            $dateofrequest = $this->getDateOfRequest($ticketid);
            $insertStat = $this->db->query("insert into status_logs (statuslogsid, servicesid, woseq, ticketid, changedby, routedTo, statusid, status, statusdate, remarks) 
                                            values(NULL, $servicesid, $escalation->woseq, $ticketid, '$changedby', '$assignTo', " . $escalation->statusref . ", '" . $this->util->getStatusDefinition($escalation->statusref) . "', current_timestamp(), '" . $escalation->subject . "');");

            if ($insertStat) {
                if ($dateofrequest >= date("Y-m-d 17:00:00"))
                {
                    $this->db->query("insert into status_logs (statuslogsid, servicesid, woseq, ticketid, changedby, routedTo, statusid, status, statusdate, remarks) 
                    values(NULL, $servicesid, $escalation->woseq, $ticketid, '$changedby', '$assignTo', " . $escalation->statusref . ", '" . $this->util->getStatusDefinition($escalation->statusref) . "', '$dateofrequest', 'System Update');");
                }
                $isUploaded = $this->Mod_upload->do_upload($postData);
                $this->Mod_logs->create_logs('Created new ticket #' . $ticketid);
                $this->Mod_email->send_email_notification($ticketid);
                return true;
            }
            return false;
        }
        return false;
    }

    public function execupdate_ticket($postData, $ticketid)
    {
        $this->session->set_userdata('ticketid', $ticketid);
        $this->load->library('util');
        $this->load->model(array('Mod_upload', 'Mod_workflow', 'Mod_email'));
        $servicesid = $this->db->escape_str($postData['sService']);
        $site       = $this->db->escape_str($postData['sSite']);
        $support    = $this->db->escape_str($postData['sSupport']);
        $priority   = $this->db->escape_str($postData['sPriority']);
        $subject    = $this->db->escape_str($postData['tSubject']);
        $message    = $this->db->escape_str($postData['tMessage']);
        
        if($this->session->userdata('sms_userlvl') == "Administrator" || $this->session->userdata('sms_userlvl') == "Counsel") 
        {
            $requestor  = $this->db->escape_str($postData['sEmployee']);
            $requesttype = $this->db->escape_str($postData['sRequestType']);    
        }
        else
        {
            $requestor  = $this->session->userdata('sms_userid');
            $requesttype = "1";    
        }
        
        $counselSite   = $this->counselBaseSite($support);
        $qty           = (isset($postData['txtQty'])) ? $postData['txtQty'] : 0;
        $newRequest    = (isset($postData['newRequest'])) ? 1 : 0;
        $originalCopy  = (isset($postData['originalCopy'])) ? 1 : 0;
        $certifiedTrue = (isset($postData['certifiedTrue'])) ? 1 : 0;
        $photoCopy     = (isset($postData['photoCopy'])) ? 1 : 0;

/*        var_dump($isUploaded);
echo $this->session->userdata('sms_userid');*/
        $query = $this->db->query("update ticket set servicesid = $servicesid, requestor = '$requestor', support = '$support',
			assignedTo = '$support', subject = '$subject', message = '$message', priority = '$priority', siteid = '$site', qty = $qty,
				originalCopy = $originalCopy, certifiedTrue = $certifiedTrue, photoCopy = $photoCopy, requesttypeid= $requesttype, counselBaseSite='$counselSite'
			where ticketid = $ticketid");

/*        $query = $this->db->query("insert into ticket (ticketid, servicesid, requestor, support, assignedTo, dateofrequest, subject, message, priority, statusid, woseq, siteid) values
(NULL, $servicesid, '$requestor', '$support', '$support', current_timestamp(), '$subject', '$message', '$priority', 19, 1, '$site')");*/
        if ($query) {
            $this->db->query("update status_logs set routedTo = '$support' where ticketid = $ticketid and status = 'New' ");
            $this->Mod_logs->create_logs('Did some changes to ticket #' . $ticketid);
            $isUploaded = $this->Mod_upload->do_upload($postData);
            $this->Mod_email->send_email_notification($ticketid);
            if ($isUploaded) {
                return true;
            }
        }
        return false;
    }

    public function cancel_ticket($ticketid)
    {
        $this->load->library('util');
        $statusid = $this->util->getStatusId('Cancel');
        //echo $statusid->statusid;
        if ($statusid) {
            $return = $this->db->query("update ticket set statusid = $statusid->statusid where ticketid = $ticketid");
            if ($return) {
                $this->Mod_logs->create_logs('Cancelled ticket #' . $ticketid);
                $insertStat = $this->db->query("insert into status_logs (statuslogsid, servicesid, woseq, ticketid, changedby, routedTo, statusid, status, statusdate, remarks)
						select NULL, servicesid, woseq, ticketid, changedby, routedTo, $statusid->statusid, 'Cancel', current_timestamp(), 'Ticket cancelled'
					from status_logs where ticketid = $ticketid and status = 'New'");
                return $insertStat;
            }
            return false;
        }
        return false;
    }

    public function escalateStatus($postData)
    {
        $this->load->library('util');
        $this->load->model(array('Mod_workflow', 'Mod_upload', 'Mod_email'));
        $ticketid   = $this->db->escape_str($postData['txtTicketId']);
        $servicesid = $this->db->escape_str($postData['txtServiceid']);
        $newStatus  = $this->db->escape_str($postData['newStatus']);
        $tRemarks   = $this->db->escape_str($postData['tRemarks']);
        $routeTo    = $this->db->escape_str($postData['routeTo']);
        $escalation = $this->Mod_workflow->escalation($servicesid, $newStatus);
        $user       = $this->session->userdata('sms_userid');
/*        $isUploaded = $this->Mod_upload->do_upload($postData, 'statusAttach');
return $isUploaded;*/

/*
echo "update ticket set
support = (case when " . $escalation->positionCode . " = 'Requestor' then requestor
when " . $escalation->positionCode . " = 'Counsel' then assignedTo else  end)
where ticketid = $ticketid";
 */

        $isUpdated        = $this->db->query("update ticket set statusid = $newStatus, woseq = " . $escalation->woseq . ", support = '" . $routeTo . "' where ticketid = $ticketid");
        $statusDefinition = $this->util->getStatusDefinition($escalation->statusref);
        if ($isUpdated) {
            if ($statusDefinition == 'New') {
                $strRemarks = $escalation->subject;
            } else {
                $strRemarks = $tRemarks;
            }

            $previousStatus = $this->latestStatusData($ticketid);

            $insertStat = $this->db->query("insert into status_logs (statuslogsid, servicesid, woseq, ticketid, changedby, routedTo, statusid, status, statusdate, remarks) 
                                            values (NULL, $servicesid, $escalation->woseq, $ticketid, '$user', '$routeTo', " . $escalation->statusref . ", '" . $this->util->getStatusDefinition($escalation->statusref) . "', current_timestamp(), '$strRemarks')");
            if ($insertStat) {
                $this->Mod_email->send_email_notification($ticketid);
                $this->Mod_logs->create_logs('Updated ticket #' . $ticketid . ' status to ' . $statusDefinition . ' from ' . $this->util->getStatusDefinition($previousStatus->statusid));
                $isUploaded = $this->Mod_upload->do_upload($postData, 'statusAttach');
                if ($isUploaded) {
                    return true;
                }

                return false;
            }
            return false;
        }
        return false;

    }

    private function latestTicketNo($requestor)
    {
        $query = $this->db->query("select max(ticketid) max_id from ticket where requestor = '$requestor'")->row();
        return $query->max_id;
    }

    private function getDateOfRequest($ticketid)
    {
        $query = $this->db->query("select dateofrequest from ticket where ticketid = $ticketid")->row();
        return $query->dateofrequest;
    }

    private function counselBaseSite($counsel)
    {
        $query = $this->db->query("select baseSite from employee_assign where employeeId='$counsel' and `assignment` = 'Counsel'")->row();
        return $query->baseSite;
    }

    private function latestStatusLogId($ticketid)
    {
        $query = $this->db->query("select statuslogsid from status_logs where ticketid = $ticketid order by statusdate desc limit 1")->row();
        return $query->statuslogsid;
    }

    private function latestStatusData($ticketid)
    {
        $query = $this->db->query("select * from status_logs where ticketid = $ticketid order by statusdate desc limit 1")->row();
        return $query;
    }

    public function addInsertAttachFile($filename, $hashname, $module, $refData)
    {
        $filename      = $this->db->escape_str($filename);
        $hashname      = $this->db->escape_str($hashname);
        $userid        = $this->session->userdata('sms_userid');
        $ticketid_sess = $this->session->userdata('ticketid');
        //print_r($refData);

        switch ($module) {
            case 'ticketAttach':
                $ticketid = $this->latestTicketNo($this->session->userdata('sms_userid'));
                if (isset($ticketid_sess)) {
                    $ticketid = $ticketid_sess;
                }
                $attachInsert = $this->db->query("insert into ticket_attachment (ticketAttacheId, ticketid, fileName, fileHash, description, transdate, userid) values
					(NULL, $ticketid, '" . $filename . "', '" . $hashname . "', '', current_timestamp(), '$userid')");
                break;
            case 'statusAttach':
                $statuslogsid = $this->Mod_ticket->latestStatusLogId($refData['txtTicketId']);
                $attachInsert = $this->db->query("insert into status_logs_attachment (statusAttacheId, statuslogsid, fileName, fileHash, description, transdate, userid) values
					(NULL, $statuslogsid, '" . $filename . "', '" . $hashname . "', '', current_timestamp(), '$userid')");
                break;
        }

        if ($attachInsert) {
            $this->Mod_logs->create_logs('Added attachment to ticket #' . $ticketid_sess . ' with file name ' . $hashname);
            return true;
        }
    }


    public function required_stat_retrieve($servicesid, $statusid){
        $query = $this->db->query("select * from workflow where servicesid = $servicesid and statusref= $statusid")->row();
        return $query;  
    }


    public function ticketDetail($ticketid)
    {
        $query = $this->db->query("select * from ticket where ticketid = $ticketid")->row();
        return $query;
    }

    public function ticketStatus($ticketid)
    {
        //$query = $this->db->query("select * from status_logs where ticketid = $ticketid order by statusdate desc")->result();

        $query = $this->db->query("select *, ifnull(TIMESTAMPDIFF(minute, startdate, statusdate), 0) diffInMinute from
			(select a.*,
				ifnull((select statusdate from status_logs
				where ticketid = a.ticketid and statusdate < a.statusdate
				order by statusdate desc limit 1), '') as startdate
					from status_logs a
					order by statusdate) slogs
				where ticketid = $ticketid
				order by ticketid, statusdate desc")->result();
        return $query;
    }

    public function assign_ticket($postData)
    {
        $this->load->library('util');
        $this->load->model('Mod_email');
        $ticketid = $postData['txtticketid'];
        $assignTo = $postData['assignTo'];
        $user     = $this->session->userdata('sms_userid');

        $ticketData = $this->db->query("select * from ticket where ticketid = $ticketid")->row();
        if (count($ticketData) > 0) {
            $isUpdated = $this->db->query("update ticket set assignedTo = '$assignTo', support = '$assignTo' where ticketid = $ticketid");
            if ($isUpdated) {

                $statusData = $this->Mod_status->getLatestStatusLogsExcluded($ticketData->statusid);
                if ($statusData->isExcludeCount == 1 && $statusData->pid == 0) {
                    $pstatuslogsid = $statusData->statuslogsid;
                }
                else { 
                    $pstatuslogsid = 0; 
                }

                // deepcode ignore Sqli: <please specify a reason of ignoring this>
                $insertStat = $this->db->query("insert into status_logs (statuslogsid, servicesid, woseq, ticketid, changedby, routedTo, statusid, status, statusdate, remarks) values
                (NULL, $ticketData->servicesid, $ticketData->woseq, $ticketid, '$user', '$assignTo', " . $ticketData->statusid . ", '" . $this->util->getStatusDefinition($ticketData->statusid) . "', current_timestamp(), 'Change of counsel')");

                if ($insertStat) {
                    $this->Mod_logs->create_logs('Ticket #' . $ticketid . ' assigned to ' . $this->util->getName($assignTo) . ' from ' . $this->util->getName($_SESSION['sms_userid']));
                    $return = $this->Mod_email->send_email_notification($ticketid);
                    return true;
                }
                return false;
            }
            return false;
        }
        return false;
    }

    public function getTicketStatistics()
    {
        $result = $this->getStats();
        return $result;
    }

    public function getStats($resulttype = 'normal')
    {
        $sms_userid = $_SESSION['sms_userid'];
        $result     = $this->db->query("select a.rec,
					COALESCE(
				        sum(case
				     	when remarks = 'Created' then
				     		tcount
				    end), 0) as created,
					COALESCE(
				        sum(case
				     	when remarks = 'For Action' then
				     		tcount
				    end), 0) as forAction,
					COALESCE(
				        sum(case
				     	when remarks = 'Assigned' then
				     		tcount
				    end), 0) as assigned
				from (
				SELECT 1 as rec, COALESCE(count(*), 0) tcount, 'Created' remarks  FROM `ticket` where requestor = '$sms_userid'
				UNION
				SELECT 1 as rec, count(*) tcount, 'For Action' remarks  FROM `ticket` where support = '$sms_userid' and (statusid != 17 and statusid != 24 and statusid != 34)
				UNION
				SELECT 1 as rec, count(*) tcount, 'Assigned' remarks  FROM `ticket` where assignedTo = '$sms_userid' and (statusid != 24)
				) a
				group by a.rec")->row();
        return $result;
    }

    public function generate_sla_report($postData)
    {

        $from = $postData['txticffromdate'];
        $to   = $postData['txticftodate'];

        $fromdate = substr($from, 6, 10) . '-' . substr($from, 0, 5);
        $todate   = substr($to, 6, 10) . '-' . substr($to, 0, 5);

        $query = "select
				c.services 'Service',
			    a.ticketid 'Ticket #',
			    d.employeeName as 'Requestor',
			    d.departmentShortName as 'Department',
			    a.siteid 'Site',
			    a.dateofrequest 'Date Requested',
			    b.statusdate as 'Date Completed',
			    ifnull(TIMESTAMPDIFF(second, a.dateofrequest, b.statusdate), 0)/3600 as 'Time Utilized (Hrs)',
			    b.remarks as 'Remarks (Reject/Accept)',
			    e.prevstatus as 'Previous Status',
			    e.status as 'Current Status',
			    e.duration/3600 as 'Duration (Hrs)'
			from ticket a
				left join (select distinct * from status_logs aa where aa.statuslogsid = (select max(aaa.statuslogsid) from status_logs aaa where aaa.ticketid = aa.ticketid)) b
					on a.ticketid = b.ticketid
				left join services c
					on a.servicesid = c.servicesid
				left join sms_users_vw d
					on a.requestor = d.employeeId
				left join (select
								slogs.*,
								b.status prevstatus,
								ifnull(TIMESTAMPDIFF(second, startdate, statusdate), 0) duration
							from
								(select a.*,
									ifnull((select statusdate from status_logs where ticketid = a.ticketid and statusdate < a.statusdate order by statusdate desc limit 1), '') as startdate,
									ifnull((select statusid from status_logs where ticketid = a.ticketid and statusdate < a.statusdate order by statusdate desc limit 1), '') as stat
								from status_logs a
								order by statusdate) slogs
							left join status b
								on slogs.stat = b.statusid
							order by ticketid, statusdate desc) e
					on a.ticketid = e.ticketid
		where date(a.dateofrequest) >= '" . $fromdate . "' and date(a.dateofrequest) <= '" . $todate . "'
			";
        return $this->db->query($query);
    }

    public function generate_sla_report_v2_old($postData){

        $from = $postData['txticffromdate'];
        $to   = $postData['txticftodate'];

        $fromdate = substr($from, 6, 10) . '-' . substr($from, 0, 5);
        $todate   = substr($to, 6, 10) . '-' . substr($to, 0, 5);

      /*  $query = "select *, 
                        concat(TIMESTAMPDIFF(DAY, DateOfRequest, DateCompleted), ' Day/s ',
                            TIMESTAMPDIFF(HOUR, DateOfRequest, DateCompleted)-(TIMESTAMPDIFF(DAY, DateOfRequest, DateCompleted)*24), ' Hrs ',
                            (case 
                                when ((TIMESTAMPDIFF(DAY, DateOfRequest, DateCompleted)*24)+(TIMESTAMPDIFF(HOUR, DateOfRequest, DateCompleted)*60)) < 60 then 
                                    TIMESTAMPDIFF(MINUTE, DateOfRequest, DateCompleted)-((TIMESTAMPDIFF(DAY, DateOfRequest, DateCompleted)*24)+(TIMESTAMPDIFF(HOUR, DateOfRequest, DateCompleted)*60))
                                else 
                                    0
                            end), ' Mins'
                            ) as 'Time Utilized'
                        from
                            (select  a.ticketid,
                                c.services 'Service Requested',         
                                d.employeeName as 'Requestor',
                                d.departmentShortName as 'Requestor Department',
                                b.status 'Status',
                                a.dateofrequest DateOfRequest,
                                (case 
                                    when b.status <> 'New' AND b.status <> 'Returned' 
                                        AND b.status <> 'Rework' AND b.status <> 'Acknowledged' 
                                        AND b.status <> 'Cancel' AND b.status <> 'Drafting by Counsel' 
                                        AND b.status <> 'Draft' AND b.status <> 'Denied' 
                                        AND b.status <> 'Denied' AND b.status <> 'Processing request' 
                                        AND b.status <> 'Start' AND b.status <> 'HOD Review'
                                        AND b.status <> 'For Discussion' AND b.status <> 'For Execution by Counsel'
                                        AND b.status <> 'For final opinion' then 
                                            (select min(aaa.statusdate) from status_logs aaa 
                                                where aaa.ticketid = a.ticketid and 
                                                    aaa.status in ('COMPLETED - For Discussion',
                                                    'COMPLETED - For Review of Requestor',
                                                    'COMPLETED - Final Contract',
                                                    'COMPLETED - For  Signature',
                                                    'COMPLETED - For Distribution',
                                                    'COMPLETED - Final Letter',
                                                    'COMPLETED - Final Document',
                                                    'COMPLETED - For Counter Party Signature',
                                                    'Completed'))
                                    else 
                                        ''
                                end) as DateCompleted,
                                f.remarks as 'Remarks'
                            from ticket a
                                left join (select distinct * 
                                    from status_logs aa 
                                    where aa.statuslogsid = (select max(aaa.statuslogsid) 
                                        from status_logs aaa 
                                        where aaa.ticketid = aa.ticketid)) b on a.ticketid = b.ticketid
                            left join services c on a.servicesid = c.servicesid
                                left join sms_users_vw d on a.requestor = d.employeeId
                                left join status_logs f on a.ticketid = f.ticketid and f.statuslogsid = (select max(statuslogsid) from status_logs where ticketid = f.ticketid)
                                left join sms_users_vw f1 on f.changedby = f1.employeeId
                                left join sms_users_vw f2 on f.routedTo = f2.employeeId) AA
                    where date(AA.dateofrequest) >= '" . $fromdate . "' and date(AA.dateofrequest) <= '" . $todate . "'";
         */
         
           /* new script updated by RJA - 10/27/2020 1:05 PM */    
/*
           $query = "select *, 
                            concat( ABS(5 * (DATEDIFF(DateOfRequest, DateCompleted) DIV 7) + (CASE WHEN DateCompleted < DateOfRequest 
                            THEN -1 * MID('0123455401234434012332340122123401101234000123450', 7 * WEEKDAY(DateCompleted) + WEEKDAY(DateOfRequest) + 1, 1)
                                                                                                   ELSE MID('0123455401234434012332340122123401101234000123450', 7 * WEEKDAY(DateOfRequest) + WEEKDAY(DateCompleted) + 1, 1)
                                                                                              END)), ' Day/s ',
                            TIMESTAMPDIFF(HOUR, DateOfRequest, DateCompleted)-(TIMESTAMPDIFF(DAY, DateOfRequest, DateCompleted)*24), ' Hrs ',
                            (case 
                                when ((TIMESTAMPDIFF(DAY, DateOfRequest, DateCompleted)*24)+(TIMESTAMPDIFF(HOUR, DateOfRequest, DateCompleted)*60)) < 60 then 
                                    TIMESTAMPDIFF(MINUTE, DateOfRequest, DateCompleted)-((TIMESTAMPDIFF(DAY, DateOfRequest, DateCompleted)*24)+(TIMESTAMPDIFF(HOUR, DateOfRequest, DateCompleted)*60))
                                else 
                                    0
                            end), ' Mins'
                            ) as 'Time Utilized'
                        from
                            (select  a.ticketid,
                                c.services 'Service Requested',         
                                d.employeeName as 'Requestor',
                                d.departmentShortName as 'Requestor Department',
                                b.status 'Status',
                                a.dateofrequest DateOfRequest,
                                (case 
                                    when b.status <> 'New' AND b.status <> 'Returned' 
                                        AND b.status <> 'Rework' AND b.status <> 'Acknowledged' 
                                        AND b.status <> 'Cancel' AND b.status <> 'Drafting by Counsel' 
                                        AND b.status <> 'Draft' AND b.status <> 'Denied' 
                                        AND b.status <> 'Denied' AND b.status <> 'Processing request' 
                                        AND b.status <> 'Start' AND b.status <> 'HOD Review'
                                        AND b.status <> 'For Discussion' AND b.status <> 'For Execution by Counsel'
                                        AND b.status <> 'For final opinion' then 
                                            (select min(aaa.statusdate) from status_logs aaa 
                                                where aaa.ticketid = a.ticketid and 
                                                    aaa.status in ('COMPLETED - For Discussion',
                                                    'COMPLETED - For Review of Requestor',
                                                    'COMPLETED - Final Contract',
                                                    'COMPLETED - For  Signature',
                                                    'COMPLETED - For Distribution',
                                                    'COMPLETED - Final Letter',
                                                    'COMPLETED - Final Document',
                                                    'COMPLETED - For Counter Party Signature',
                                                    'Completed'))
                                    else 
                                        ''
                                end) as DateCompleted,
                                f.remarks as 'Remarks'
                            from ticket a
                                left join (select distinct * 
                                    from status_logs aa 
                                    where aa.statuslogsid = (select max(aaa.statuslogsid) 
                                        from status_logs aaa 
                                        where aaa.ticketid = aa.ticketid)) b on a.ticketid = b.ticketid
                            left join services c on a.servicesid = c.servicesid
                                left join sms_users_vw d on a.requestor = d.employeeId
                                left join status_logs f on a.ticketid = f.ticketid and f.statuslogsid = (select max(statuslogsid) from status_logs where ticketid = f.ticketid)
                                left join sms_users_vw f1 on f.changedby = f1.employeeId
                                left join sms_users_vw f2 on f.routedTo = f2.employeeId) AA
                    where date(AA.dateofrequest) >= '" . $fromdate . "' and date(AA.dateofrequest) <= '" . $todate . "'";
			*/

      /* new script updated by RJA - 12/07/2020 4:32 PM */


		$query = "select *, 
                            concat(diffdate(DateCompleted, DateOfRequest), ' Day/s ',
                            TIMESTAMPDIFF(HOUR, DateOfRequest, DateCompleted)-(TIMESTAMPDIFF(DAY, DateOfRequest, DateCompleted)*24), ' Hrs ',
                            (case 
                                when ((TIMESTAMPDIFF(DAY, DateOfRequest, DateCompleted)*24)+(TIMESTAMPDIFF(HOUR, DateOfRequest, DateCompleted)*60)) < 60 then 
                                    TIMESTAMPDIFF(MINUTE, DateOfRequest, DateCompleted)-((TIMESTAMPDIFF(DAY, DateOfRequest, DateCompleted)*24)+(TIMESTAMPDIFF(HOUR, DateOfRequest, DateCompleted)*60))
                                else 
                                    0
                            end), ' Mins'
                            ) as 'Time Utilized'
                        from
                            (select  a.ticketid,
                                c.services 'Service Requested',         
                                d.employeeName as 'Requestor',
                                d.departmentShortName as 'Requestor Department',
                                b.status 'Status',
                                a.dateofrequest DateOfRequest,
                                (case 
                                    when b.status <> 'New' AND b.status <> 'Returned' 
                                        AND b.status <> 'Rework' AND b.status <> 'Acknowledged' 
                                        AND b.status <> 'Cancel' AND b.status <> 'Drafting by Counsel' 
                                        AND b.status <> 'Draft' AND b.status <> 'Denied' 
                                        AND b.status <> 'Denied' AND b.status <> 'Processing request' 
                                        AND b.status <> 'Start' AND b.status <> 'HOD Review'
                                        AND b.status <> 'For Discussion' AND b.status <> 'For Execution by Counsel'
                                        AND b.status <> 'For final opinion' then 
                                            (select min(aaa.statusdate) from status_logs aaa 
                                                where aaa.ticketid = a.ticketid and 
                                                    aaa.status in ('COMPLETED - For Discussion',
                                                    'COMPLETED - For Review of Requestor',
                                                    'COMPLETED - Final Contract',
                                                    'COMPLETED - For  Signature',
                                                    'COMPLETED - For Distribution',
                                                    'COMPLETED - Final Letter',
                                                    'COMPLETED - Final Document',
                                                    'COMPLETED - For Counter Party Signature',
                                                    'Completed'))
                                    else 
                                        ''
                                end) as DateCompleted,
                                f.remarks as 'Remarks'
                            from ticket a
                                left join (select distinct * 
                                    from status_logs aa 
                                    where aa.statuslogsid = (select max(aaa.statuslogsid) 
                                        from status_logs aaa 
                                        where aaa.ticketid = aa.ticketid)) b on a.ticketid = b.ticketid
                            left join services c on a.servicesid = c.servicesid
                                left join sms_users_vw d on a.requestor = d.employeeId
                                left join status_logs f on a.ticketid = f.ticketid and f.statuslogsid = (select max(statuslogsid) from status_logs where ticketid = f.ticketid)
                                left join sms_users_vw f1 on f.changedby = f1.employeeId
                                left join sms_users_vw f2 on f.routedTo = f2.employeeId) AA
                    where date(AA.dateofrequest) >= '" . $fromdate . "' and date(AA.dateofrequest) <= '" . $todate . "'";



        return $this->db->query($query);
        
    }

    public function generate_sla_report_v2($postData){

        $from = $postData['txticffromdate'];
        $to   = $postData['txticftodate'];

        $fromdate = substr($from, 6, 10) . '-' . substr($from, 0, 5);
        $todate   = substr($to, 6, 10) . '-' . substr($to, 0, 5);

		$query = "select *, diffdate_v2(acknowledgeDate, DateCompleted, baseSite, ticketid) as 'Time Utilized V2'
                        from
                            (select  a.ticketid,
                                c.services 'Service Requested',         
                                d.employeeName as 'Requestor',
                                d.departmentShortName as 'Requestor Department',
                                b.status 'Status',
                                a.dateofrequest DateOfRequest, f3.acknowledgeDate,
                                (case 
                                    when b.status <> 'New' AND b.status <> 'Returned' 
                                        AND b.status <> 'Rework' AND b.status <> 'Acknowledged' 
                                        AND b.status <> 'Cancel' AND b.status <> 'Drafting by Counsel' 
                                        AND b.status <> 'Draft' AND b.status <> 'Denied' 
                                        AND b.status <> 'Denied' AND b.status <> 'Processing request' 
                                        AND b.status <> 'Start' AND b.status <> 'HOD Review'
                                        AND b.status <> 'For Discussion' AND b.status <> 'For Execution by Counsel'
                                        AND b.status <> 'For final opinion' then 
                                            (select min(aaa.statusdate) from status_logs aaa 
                                                where aaa.ticketid = a.ticketid and 
                                                    aaa.status in ('COMPLETED - For Discussion',
                                                    'COMPLETED - For Review of Requestor',
                                                    'COMPLETED - Final Contract',
                                                    'COMPLETED - For  Signature',
                                                    'COMPLETED - For Distribution',
                                                    'COMPLETED - Final Letter',
                                                    'COMPLETED - Final Document',
                                                    'COMPLETED - For Counter Party Signature',
                                                    'Completed'))
                                    else 
                                        NULL
                                end) as DateCompleted,
                                f.remarks as 'Remarks', g.baseSite
                            from ticket a
                                left join (select employeeId, baseSite from employee_assign where `assignment` = 'counsel' group by employeeId) g on g.employeeID = a.assignedTo 
                                left join (select distinct * 
                                    from status_logs aa 
                                    where aa.statuslogsid = (select max(aaa.statuslogsid) 
                                        from status_logs aaa 
                                        where aaa.ticketid = aa.ticketid)) b on a.ticketid = b.ticketid
                            left join services c on a.servicesid = c.servicesid
                                left join sms_users_vw d on a.requestor = d.employeeId
                                left join status_logs f on a.ticketid = f.ticketid and f.statuslogsid = (select max(statuslogsid) from status_logs where ticketid = f.ticketid)
                                left join sms_users_vw f1 on f.changedby = f1.employeeId
                                left join sms_users_vw f2 on f.routedTo = f2.employeeId
                                left join (select status_logs.ticketid, min(status_logs.statusdate) as acknowledgeDate
                                            from status_logs 
                                            left join status on status.statusid = status_logs.statusid
                                            left join ticket on ticket.ticketid = status_logs.ticketid 
                                            where ifnull(status.isSLAStart, 0) = 1 and ticket.dateofrequest between '". $fromdate ."' and '". $todate ."'
                                            group by status_logs.ticketid) f3 on f3.ticketid = a.ticketid
                                ) AA
                    where date(AA.dateofrequest) >= '" . $fromdate . "' and date(AA.dateofrequest) <= '" . $todate . "'";



        return $this->db->query($query);
        
    }
}

