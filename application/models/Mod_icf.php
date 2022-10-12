<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Mod_icf extends CI_Model{
	
	public function __construct(){
		parent::__construct();
		
	}

	//ticket attachment
	public function getQuestions($isIcf = false, $rev = 4) {
		if ($isIcf) {
			$query = $this->db->query("select * from feedback_question where active = 1 and revision = $rev");
		} elseif($rev != null) {
			$query = $this->db->query("select * from feedback_question where revision = $rev");
		} else {
			$query = $this->db->query("select * from feedback_question");
		}
		if ($query) {
			return $query->result();
		} 
		return false;
	}

	public function retrieve_icf_byticket($ticketid)
    {
        $query = $this->db->query("select * from feedback_score where ticketid = $ticketid");
        if ($query) {
            return $query->result();
        }
        return false;
    }

	public function retrieve_form_data_byticket($ticketid)
    {
        $query = $this->db->query("select * from feedback_form where ticketid = $ticketid");
        if ($query) {
            return $query->row();
        }
        return false;
    }

	public function retrieve_form_data_byticket_rev5($ticketid)
    {
        $query = $this->db->query("select * from feedbackformnew where ticketid = $ticketid");
        if ($query) {
            return $query->row();
        }
        return false;
    }

	public function addNewQuestion($postData) {
		$question = $this->db->escape_str($postData['txtQuestion']);

		$isActiveVal = (isset($postData['isActive'])) ? 1 : 0;

		$return = $this->db->query("insert into feedback_question (question, active) values ('$question', '$isActiveVal')");
		return $return;
	}

	public function remove($qId){ 
		$return = $this->db->query("delete from feedback_question where question_id = $qId");
		return $return;
	}

	public function save_ratings($ticketid, $postData) {
		$this->load->library('util');
		//var_dump($postData);
		$user = $_SESSION['sms_userid'];


		$provider = $this->db->escape_str($postData['provider']);
		$customer = $this->db->escape_str($postData['customer']);
		$period = $this->db->escape_str($postData['period']);
		$overall_score = $this->db->escape_str($postData['overall_score']);
		$score_convert = $this->db->escape_str($postData['score_convert']);
		$service = $this->db->escape_str($postData['service']);
		$servicesid = $this->db->escape_str($postData['servicesid']);
		$delivery = (isset($postData['delivery'])) ? 1 : 0;
		$accuracy = (isset($postData['accuracy'])) ? 1 : 0;
		$failure = (isset($postData['failure'])) ? 1 : 0;
		$communication = (isset($postData['communication'])) ? 1 : 0;
		$others = $this->db->escape_str($postData['others']);
		$suggestions = $this->db->escape_str($postData['suggestions']);
		$respondent = $this->db->escape_str($postData['respondent']);
		$received = $this->db->escape_str($postData['received']);
		$res_date = $this->db->escape_str($postData['res_date']);
		$rec_date = $this->db->escape_str($postData['rec_date']);

		$countQ = count($this->getQuestions());

		

		$return = $this->db->query("insert into feedback_form 
				(ticketid, provider, customer, period_cover, 
					overall_score, score_convert, service, delivery, 
						accuracy, failure, communication, others,
							suggestion, respondent, received, rec_date, res_date) 
					values 
				('$ticketid', '$provider', '$customer', '$period', 
					'$overall_score', '$score_convert', '$service', '$delivery',
						'$accuracy', '$failure', '$communication', '$others',
							'$suggestions', '$respondent', '$received', '$res_date', '$rec_date'
				)");
		if ($return) {
			$return = $this->db->query("update ticket set statusid = 17 where ticketid = $ticketid");
			if ($return) {
				$return = $this->db->query("insert into status_logs (statuslogsid, servicesid, woseq, ticketid, changedby, routedTo, statusid, status, statusdate, remarks) values 
					(NULL, $servicesid, 0, $ticketid, '$user', '', 17, '" . $this->util->getStatusDefinition(17) . "', current_timestamp(), 'Ticket is Closed')");
				if($return) {
					for ($i=1; $i <= $countQ; $i++) { 
						$question = $postData['question' . $i];
						$question_id = $postData['qId' . $i];
						$score = $postData['score' . $i];
						$remarks = $postData['remarks' . $i];

						$return = $this->db->query("insert into feedback_score (fs_id, ticketid, question_id, question, score, remarks) values 
									(NULL, '$ticketid', $question_id, '$question', '$score', '$remarks')");
					}
				}
			}
		}

		return $return;
	}

	public function save_ratings_rev5($ticketid, $postData)
    {
        $this->load->library('util');
        //var_dump($postData);
        $user          = $_SESSION['sms_userid'];
        $subservice    = $this->db->escape_str($postData['txtsubservice']);
        $siterater     = $this->db->escape_str($postData['txtsiterater']);
        $deptrater     = $this->db->escape_str($postData['txtdeptrater']);
        $year          = $this->db->escape_str($postData['txtyear']);
        $frequency     = $this->db->escape_str($postData['txtfrequency']);
        $quarter       = $this->db->escape_str($postData['txtquarter']);
        $siteprovider  = $this->db->escape_str($postData['txtsiteprovider']);
        $deptprovider  = $this->db->escape_str($postData['txtdeptprovider']);
        $typeservice   = $this->db->escape_str($postData['txttypeservice']);
        $raterrequest  = $this->db->escape_str($postData['txtraterrequest']);
        $lvlagree      = $this->db->escape_str($postData['txtlvlagree']);
        $delivery      = (isset($postData['delivery'])) ? 1 : 0;
        $accuracy      = (isset($postData['accuracy'])) ? 1 : 0;
        $failure       = (isset($postData['failure'])) ? 1 : 0;
        $communication = (isset($postData['communication'])) ? 1 : 0;
        $others        = $this->db->escape_str($postData['others']);
        $suggestions   = $this->db->escape_str($postData['suggestions']);
        $groupcremarks = $this->db->escape_str($postData['groupcremarks']);
		$servicesid = $this->db->escape_str($postData['servicesid']);

        $countQ = count($postData['question_count']);

        $return = $this->db->query("insert into feedbackformnew (feedbackformid, ticketid, ratersite, raterdept, year,
                frequency, quarter, providersite, providerdept,
                typeofservice, servicerequested, servicelvlagreement, deliverytimeissue,
                dataaccuracy, failurerate, poorcommunication, others,
                othersuggestion, groupcremarks, datesubmitted)
                    values (NULL, $ticketid, '$siterater', '$deptrater', '$year',
                '$frequency', '$quarter', '$siteprovider', '$deptprovider',
                '$typeservice', '$raterrequest', '$lvlagree', '$delivery',
                '$accuracy', '$failure', '$communication', '$others',
                '$suggestions', '$groupcremarks', current_timestamp())");

        $return = true;
        if ($return) {
			$return = $this->db->query("update ticket set statusid = 17 where ticketid = $ticketid");
            if ($return) {
				$return = $this->db->query("insert into status_logs (statuslogsid, servicesid, woseq, ticketid, changedby, routedTo, statusid, status, statusdate, remarks) values 
					(NULL, $servicesid, 0, $ticketid, '$user', '', 17, '" . $this->util->getStatusDefinition(17) . "', current_timestamp(), 'Ticket is Closed')");
                if ($return) {
                    for ($i = 1; $i <= $countQ; $i++) {
                        $question    = $postData['question' . $i];
                        $question_id = $postData['qId' . $i];
                        $score       = $postData['score' . $i];
                        $remarks     = $this->db->escape_str($postData['remarks' . $i]);

                        $return = $this->db->query("insert into feedback_score (fs_id, ticketid, question_id, question, score, remarks) values
                                    (NULL, '$ticketid', $question_id, '$question', '$score', '$remarks')");
                    }
                }
            }
        }

        return $return;
    }

	public function generate_icf_summary($type, $from, $to){
		$fromdate = substr($from, 6, 10) . '-' . substr($from, 0, 5);
		$todate = substr($to, 6, 10) . '-' . substr($to, 0, 5);

		if ($type == 'All') {
			$icfType = "";
		} elseif ($type == 'OverallIcfOnly') {
			$icfType = "and b.subservice = ''";
		} else {
			$icfType = "and b.subservice = '$type'";
		}
		$query = $this->db->query("select 
				b.siteid,
				a.ticketid,
				(select concat(lastName, ', ', firstName, ' ', middleName) from sms_users where employeeId = b.assignedTo) support,
				(select concat(lastName, ', ', firstName, ' ', middleName) from sms_users where employeeId = b.requestor) requestor,
				b.dateofrequest,
				(select services from services where servicesid = b.servicesid) service,
				count(a.ticketid)*10 ceiling,
				sum(a.score) score,
				count(a.ticketid) ticketCount,
				c.suggestion,
				cast((sum(a.score)/(count(a.ticketid)*10))*100 as DECIMAL(7,2)) percentage
			from feedback_score a
				left join ticket b
					on a.ticketid = b.ticketid
				right join feedback_form c
					on a.ticketid = c.ticketid
				where DATE(b.dateofrequest) >= '$fromdate' and DATE(b.dateofrequest) <= '$todate'
			group by ticketid order by service");

/*		echo "select 
				b.siteid,
				a.ticketid,
				(select concat(lastName, ', ', firstName, ' ', middleName) from sms_users where employeeId = b.assignedTo) support,
				(select concat(lastName, ', ', firstName, ' ', middleName) from sms_users where employeeId = b.requestor) requestor,
				b.dateofrequest,
				(select services from services where servicesid = b.servicesid) service,
				count(a.ticketid)*10 ceiling,
				sum(a.score) score,
				count(a.ticketid) ticketCount,
				c.suggestion,
				cast((sum(a.score)/(count(a.ticketid)*10))*100 as DECIMAL(7,2)) percentage
			from feedback_score a
				left join ticket b
					on a.ticketid = b.ticketid
				right join feedback_form c
					on a.ticketid = c.ticketid
				where DATE(b.dateofrequest) >= '$fromdate' and DATE(b.dateofrequest) <= '$todate'
			group by ticketid order by service";*/

		/*$query = $this->db->query("select aa.*, (aa.totalScore/aa.ceilingScore)*100 percentage from (
				select a.question_id, b.question,
					sum(a.score) totalScore, 
					count(distinct a.ticketid) NoOftickets,
					count(distinct a.ticketid)*10 ceilingScore
				from feedback_score a
					left join feedback_question b
						on a.question_id = b.question_id
				where DATE(a.dateCreated) >= '$fromdate' and DATE(a.dateCreated) <= '$todate'
				group by a.question_id
			) aa");*/

	
		/*$query = $this->db->query("select aa.*, (aa.totalScore/aa.ceilingScore)*100 percentage from (
				select b.servicesid, c.services, b.subservice, a.question_id, b.question, 
					sum(a.score) totalScore, 
					count(distinct a.ticketid) NoOftickets,
					count(distinct a.ticketid)*10 ceilingScore
				from feedback_score a
					left join feedback_question b
						on a.question_id = b.question_id
					left join services c
						on b.servicesid = c.servicesid
				group by b.servicesid, b.subservice, a.question_id
			) aa");*/
		if ($query) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function summaryicf($type, $from, $to){
		$fromdate = substr($from, 6, 10) . '-' . substr($from, 0, 5);
		$todate = substr($to, 6, 10) . '-' . substr($to, 0, 5);

		$stmt = "select aa.service, count(aa.service) ticketCount, CAST(sum(aa.percentage)/count(aa.service) AS DECIMAL (7 , 2 )) percentage from
					(SELECT 
						b.siteid,
						a.ticketid,
						(SELECT 
								CONCAT(lastName,
											', ',
											firstName,
											' ',
											middleName)
							FROM
								sms_users
							WHERE
								employeeId = b.assignedTo) support,
						(SELECT 
								CONCAT(lastName,
											', ',
											firstName,
											' ',
											middleName)
							FROM
								sms_users
							WHERE
								employeeId = b.requestor) requestor,
						b.dateofrequest,
						(SELECT 
								services
							FROM
								services
							WHERE
								servicesid = b.servicesid) service,
						COUNT(a.ticketid) * 10 ceiling,
						SUM(a.score) score,
						COUNT(a.ticketid) ticketCount,
						c.suggestion,
						CAST((SUM(a.score) / (COUNT(a.ticketid) * 10)) * 100
							AS DECIMAL (7 , 2 )) percentage
					FROM
						feedback_score a
							LEFT JOIN
						ticket b ON a.ticketid = b.ticketid
							RIGHT JOIN
						feedback_form c ON a.ticketid = c.ticketid
					WHERE
						DATE(b.dateofrequest) >= '$fromdate'
							AND DATE(b.dateofrequest) <= '$todate'
					GROUP BY ticketid
					ORDER BY service) aa
				group by aa.service";
		$query = $this->db->query($stmt);

		/*$query = $this->db->query("select 
				(select services from services where servicesid = b.servicesid) service,
				count(a.ticketid)*10 ceiling,
				sum(a.score) score,
				count(distinct a.ticketid) ticketCount,
				cast((sum(a.score)/(count(a.ticketid)*10))*100 as decimal(7,2)) percentage
			from feedback_score a
				left join ticket b
					on a.ticketid = b.ticketid
				left join feedback_form c
					on a.ticketid = c.ticketid
				where DATE(b.dateofrequest) >= '$fromdate' and DATE(b.dateofrequest) <= '$todate'
			group by b.servicesid  order by service");*/

		if ($query) {
			return $query->result();
		} else {
			return false;
		}
	}

    public function get_icf_rawdata($postData){
        $from = $postData['txticffromdate'];
        $to = $postData['txticftodate'];

        $fromdate = substr($from, 6, 10) . '-' . substr($from, 0, 5);
        $todate = substr($to, 6, 10) . '-' . substr($to, 0, 5);


        $query = $this->db->query("select c.employeeName, b.siteid, c.departmentShortName, e.description serviceRequested, a.*, 
                d.others, d.othersuggestion, d.groupcremarks, d.datesubmitted from 
                (SELECT 
			        `zz`.`ticketid` AS `ticketid`,
			        `zz`.`question_id` AS `question_id`,
			        `zz`.`question` AS `question`,
			        `zz`.`vsatisfied` AS `verysatisfied`,
			        `zz`.`satisfied` AS `satisfied`,
			        `zz`.`dissatisfied` AS `dissatisfied`,
			        `zz`.`vdissatisfied` AS `verydissatisfied`,
			        `zz`.`NA` AS `NA`,
			        `zz`.`remarks` AS `remarks`
			    FROM
			        (SELECT DISTINCT
			            `z`.`ticketid` AS `ticketid`,
			                `z`.`question_id` AS `question_id`,
			                `z`.`question` AS `question`,
			                IF((IFNULL(`aa`.`vsatisfied`, 0) > 0), 1, 0) AS `vsatisfied`,
			                IF((IFNULL(`bb`.`satisfied`, 0) > 0), 1, 0) AS `satisfied`,
			                IF((IFNULL(`cc`.`dissatisfied`, 0) > 0), 1, 0) AS `dissatisfied`,
			                IF((IFNULL(`dd`.`vdissatisfied`, 0) > 0), 1, 0) AS `vdissatisfied`,
			                IF((IFNULL(`ee`.`NA`, 0) > 0), 1, 0) AS `NA`,
			                `z`.`remarks` AS `remarks`
			        FROM
			            (((((`sms`.`feedback_score` `z`
			        LEFT JOIN (SELECT 
			            `a`.`ticketid` AS `ticketid`,
			                `a`.`question_id` AS `question_id`,
			                `a`.`score` AS `vsatisfied`
			        FROM
			            `sms`.`feedback_score` `a`
			        WHERE
			            (`a`.`score` = 4)) `aa` ON (((`z`.`question_id` = `aa`.`question_id`)
			            AND (`z`.`ticketid` = `aa`.`ticketid`))))
			        LEFT JOIN (SELECT 
			            `a`.`ticketid` AS `ticketid`,
			                `a`.`question_id` AS `question_id`,
			                `a`.`score` AS `satisfied`
			        FROM
			            `sms`.`feedback_score` `a`
			        WHERE
			            (`a`.`score` = 3)) `bb` ON (((`z`.`question_id` = `bb`.`question_id`)
			            AND (`z`.`ticketid` = `bb`.`ticketid`))))
			        LEFT JOIN (SELECT 
			            `a`.`ticketid` AS `ticketid`,
			                `a`.`question_id` AS `question_id`,
			                `a`.`score` AS `dissatisfied`
			        FROM
			            `sms`.`feedback_score` `a`
			        WHERE
			            (`a`.`score` = 2)) `cc` ON (((`z`.`question_id` = `cc`.`question_id`)
			            AND (`z`.`ticketid` = `cc`.`ticketid`))))
			        LEFT JOIN (SELECT 
			            `a`.`ticketid` AS `ticketid`,
			                `a`.`question_id` AS `question_id`,
			                `a`.`score` AS `vdissatisfied`
			        FROM
			            `sms`.`feedback_score` `a`
			        WHERE
			            (`a`.`score` = 1)) `dd` ON (((`z`.`question_id` = `dd`.`question_id`)
			            AND (`z`.`ticketid` = `dd`.`ticketid`))))
			        LEFT JOIN (SELECT 
			            `a`.`ticketid` AS `ticketid`,
			                `a`.`question_id` AS `question_id`,
			                COUNT(`a`.`score`) AS `NA`
			        FROM
			            `sms`.`feedback_score` `a`
			        WHERE
			            (`a`.`score` = 0)
			        GROUP BY `a`.`ticketid` , `a`.`question_id`) `ee` ON (((`z`.`question_id` = `ee`.`question_id`)
			            AND (`z`.`ticketid` = `ee`.`ticketid`))))
			        ORDER BY `z`.`ticketid` , `z`.`question_id`) `zz`)

                a
                left join ticket b
                    on a.ticketid = b.ticketid
                left join sms_users_vw c
                    on b.requestor = c.employeeId
                right join feedbackformnew d
                    on a.ticketid = d.ticketid
                left join services e
                    on b.servicesid = e.servicesid
                where date(b.dateofrequest) >= '" . $fromdate . "' and date(b.dateofrequest) <= '" . $todate . "'

            ");

        return $query;
    }

}