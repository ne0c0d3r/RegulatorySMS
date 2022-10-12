<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Dashboard extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->Mod_session->check_session();
	}


	public function index(){
		$this->load->view('header');
		$this->load->view('navigation');
		$this->load->view('dashboard');
		$this->load->view('footer');

	}

	public function getstats(){
		$this->load->database();
		$result = $this->db->query("select * from (
			select date(dateofrequest) date, count(ticketid) value from ticket group by date(dateofrequest) order by date(dateofrequest) desc limit 30
			) a order by date asc")->result();
		echo json_encode($result);
	}

	public function getServicesCount(){
		$this->load->database();
		$result = $this->db->query("select b.services AS label, count(a.servicesid) value from ticket a
				left join services b
					on a.servicesid = b.servicesid
			group by b.services")->result();
		echo json_encode($result);
	}

	public function getTicketPerCounsel(){
		
		$this->load->database();
		$criteria = "";

		//Added 20220811 
		$pis = $this->load->database('pis', true); 
		$query = $pis->query("select GROUP_CONCAT(CONCAT('''', employeeId, '''' ) separator ',') as sepList 
							 from employee 
							 where LOWER(status) in ('inactive','Resigned')")->row();
		if ($query) {
			$criteria = " and employeeId not in(". $query->sepList .")";
		}		
		
		$result = $this->db->query("select b.lastName as label, count(a.ticketid) value from ticket a
				left join sms_users b
					on a.assignedTo = b.employeeId
				left join status c
					on a.statusid = c.statusid
				left join employee_assign d 
					on a.assignedto = d.employeeId
			where c.status != 'Close' and ifnull(d.inactive, 0)=0 
			group by b.lastName")->result();
		echo json_encode($result);
	}

	public function getTicketStatusGroup(){
		$this->load->database();
		$result = $this->db->query("select aa.statuslabel, sum(aa.value) value from 
			(select 
				b.status,
				(case 
					when b.status = 'New' then
						'1'
					when b.status = 'Accepted' then
						'5'
					when b.status = 'Returned' then
						'7'
					when b.status = 'Close' then
						'6'
					when b.status = 'Cancel' then
						'8'
					when b.status = 'Completed' then
						'4'
					when b.status = 'Acknowledged' then
						'2'
					else
						'3'
				end) statusSeq, 
				(case 
					when b.status = 'New' then
						b.status
					when b.status = 'Accepted' then
						b.status
					when b.status = 'Returned' then
						b.status
					when b.status = 'Close' then
						b.status
					when b.status = 'Cancel' then
						b.status
					when b.status = 'Completed' then
						b.status
					when b.status = 'Acknowledged' then
						b.status
					else
						'In Progress'
				end) statuslabel, 
				count(a.ticketid) value 
			from ticket a
				left join status b
					on a.statusid = b.statusid
			group by b.status) aa
		group by aa.statuslabel
		order by aa.statusSeq")->result();
		echo json_encode($result);
	}

	public function process() {
	    //$data = $this->input->get();
	    //$start = $this->input->get('start');
	    //echo json_encode($start);
	  }

	public function ticketGroupBySite(){
		$start = $this->input->get('start');
		$end = $this->input->get('end');
		$limit = "";
		$criteria = " where dateofrequest between '". $start . "' and '" . $end . "' ";
		if (strlen($start) === 0 && strlen($end) === 0)
		{
			$limit = " LIMIT 30 ";
			$criteria = "";
		}
		//echo $start . $end;
		//echo json_encode($criteria);
		$result = $this->db->query("SELECT
					    aaa.date ,
					    SUM(aaa.A) A ,
					    SUM(aaa.B) B ,
					    SUM(aaa.C) C ,
					    SUM(aaa.D) D
					FROM
					    (
					        SELECT
					            DATE ,
					            CASE
					                WHEN aa.siteid IN(
					                    'PPC' ,
					                    'PEDC' ,
					                    'GBH'
					                )
					                THEN aa.value
					                ELSE 0
					            END A ,
					            CASE
					                WHEN aa.siteid IN(
					                    'CEDC' ,
					                    'TPC'
					                )
					                THEN aa.value
					                ELSE 0
					            END B ,
					            CASE
					                WHEN aa.siteid IN('GBPC')
					                THEN aa.value
					                ELSE 0
					            END C ,
					            CASE
					                WHEN aa.siteid NOT IN(
					                    'GBPC' ,
					                    'PEDC' ,
					                    'PPC' ,
					                    'GBH' ,
					                    'CEDC' ,
					                    'TPC'
					                )
					                THEN aa.value
					                ELSE 0
					            END D
					        FROM
					            (
					                SELECT
					                    siteid ,
					                    DATE(dateofrequest) DATE ,
					                    COUNT(ticketid) VALUE
					                FROM
					                    ticket" . $criteria ."
					                GROUP BY
					                    siteid ,
					                    DATE(dateofrequest)
					                ORDER BY
					                    DATE(dateofrequest) DESC ". $limit . "
					            ) aa
					    ) aaa
					GROUP BY
    			aaa.date")->result();
		echo json_encode($result);
	}

}

