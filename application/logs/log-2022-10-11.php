<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2022-10-11 03:38:57 --> Query error: Unknown column 'undefined' in 'where clause' - Invalid query: select ticket.*, services.services from ticket left join services on ticket.servicesid = services.servicesid where ticket.ticketid = undefined
ERROR - 2022-10-11 03:38:58 --> Severity: Error --> Call to a member function row() on a non-object C:\xampp\htdocs\regulatorysms\application\models\Mod_ticket.php 29
ERROR - 2022-10-11 03:38:58 --> Query error: Unknown column 'undefined' in 'where clause' - Invalid query: select * from ticket where ticketid = undefined
ERROR - 2022-10-11 03:38:58 --> Severity: Error --> Call to a member function row() on a non-object C:\xampp\htdocs\regulatorysms\application\models\Mod_ticket.php 469
ERROR - 2022-10-11 03:38:59 --> Query error: Unknown column 'undefined' in 'where clause' - Invalid query: select * from workflow where servicesid = undefined and woseq = undefined
ERROR - 2022-10-11 03:38:59 --> Severity: Error --> Call to a member function row() on a non-object C:\xampp\htdocs\regulatorysms\application\models\Mod_workflow.php 57
ERROR - 2022-10-11 07:19:28 --> Query error: Unknown column 'pstatuslogsid' in 'field list' - Invalid query: select a.*, ifnull(pstatuslogsid,0) as pid, b.isExcludeCount 
									from status_logs a left join `status` b on b.statusid = a.statusid 
									where a.ticketid = 1 order by a.statuslogsid desc limit 1
ERROR - 2022-10-11 07:19:28 --> Severity: Error --> Call to a member function row() on a non-object C:\xampp\htdocs\regulatorysms\application\models\Mod_status.php 61
ERROR - 2022-10-11 07:20:11 --> Query error: Unknown column 'pstatuslogsid' in 'field list' - Invalid query: select a.*, ifnull(pstatuslogsid,0) as pid, b.isExcludeCount 
									from status_logs a left join `status` b on b.statusid = a.statusid 
									where a.ticketid = 2 order by a.statuslogsid desc limit 1
ERROR - 2022-10-11 07:20:11 --> Severity: Error --> Call to a member function row() on a non-object C:\xampp\htdocs\regulatorysms\application\models\Mod_status.php 61
ERROR - 2022-10-11 10:16:18 --> 404 Page Not Found: Js/jquery.min.map
ERROR - 2022-10-11 10:18:04 --> 404 Page Not Found: Js/jquery.min.map
ERROR - 2022-10-11 10:18:10 --> 404 Page Not Found: Js/jquery.min.map
ERROR - 2022-10-11 10:19:53 --> 404 Page Not Found: Js/jquery.min.map
