
					<?php 
					if (count($ticketData) > 0) {
						foreach ($ticketData as $ticketList) { 
							 $ticketHasAttachment = count($mod_attachment->ticketAttachment($ticketList->ticketid));
						?>
						<tr class="<?php echo ($util->getStatusDefinition($ticketList->statusid) == 'Cancel')? 'strikeout' : '' ?> <?php echo ($util->getStatusDefinition($ticketList->statusid) == 'Accepted')? 'higlight-emp' : '' ?>" id="tr-ticket-<?php echo $ticketList->ticketid ?>" data-id="<?php echo $ticketList->ticketid ?>" data-woseq="<?php echo $ticketList->woseq ?>" data-isAssigned="<?php echo ($ticketList->support == $_SESSION['sms_userid']) ? 'true' : 'false' ?>">
							<td class="std-row  text-center <?php echo ($ticketList->support == $_SESSION['sms_userid'] && $util->getStatusDefinition($ticketList->statusid) != 'Cancel' && $util->getStatusDefinition($ticketList->statusid) != 'Close') ? 'isForMyAction' : '' ?>"><?php echo $ticketList->ticketid ?></td>
							<td class="std-row"><?php echo $ticketList->siteid ?></td>
							<td class="std-row cell-no-wrap">
								<a href="<?php echo base_url() ?>employee/?userid=<?php echo $ticketList->requestor ?>" class="" title="View User Detail"><span class="fa fa-user-circle-o"></span></a> 
								<?php 
	                               echo ' ' . $ticketList->lastName . ', ' . $ticketList->firstName . ' ' . $ticketList->middleName;
								?>
							</td>
							<td class="std-row"><?php echo $ticketList->departmentShortName ?></td>
							<td class="std-row cell-no-wrap" title="<?php echo $ticketList->subject ?>">
								<?php if ($ticketHasAttachment > 0) { ?>
									<span class="text-warning glyphicon glyphicon-paperclip font7"></span>
								<?php } ?>
								<?php echo substr($ticketList->subject, 0, 35)  ?><?php echo (strlen($ticketList->subject) > 35) ? ' [...]' : '' ?>  </td>
							<td class="std-row cell-no-wrap">
								<?php echo $ticketList->lastAssigned ?>
							</td>
							<td class="std-row"><?php echo date_format(new DateTime($ticketList->dateofrequest), 'm/d/Y H:ia') ?></td>
							<td class="std-row servicesid-row cell-no-wrap" data-servicesid="<?php echo $ticketList->servicesid ?>"><?php echo $util->getServiceDefintion($ticketList->servicesid) ?></td>
							<td class="std-row font8 bold-text">
								<?php if ($ticketList->priority == 1) { ?>
									<span class="neutral-level">Low</span>
								<?php } else if ($ticketList->priority == 2){ ?>
									<span class="medium-level">Medium</span>									
								<?php } else if ($ticketList->priority == 3){ ?>
									<span class="high-level">High</span>
								<?php }	?>
							</td>
							<td class="std-row cell-no-wrap record-status" data-status="<?php echo $util->getStatusDefinition($ticketList->statusid) ?>"><?php echo $util->getStatusDefinition($ticketList->statusid) ?></td>
							<td class="std-row text-right">
								<!-- <a class="simple-ajax-popup-align-top" href="<?php echo base_url() ?>icf">Load</a>
								<a class="popup-modal" href="#icf-form-modal">Open modal</a> -->
								<?php if ($util->getStatusDefinition($ticketList->statusid) != 'Close') { ?>									
								<span class=""> <!-- row-option -->
									<?php if ($ticketList->support == $_SESSION['sms_userid'] && $util->getStatusDefinition($ticketList->statusid) == 'Accepted') {  ?>
										<a href="#icf-form-modal" data-ticketid=<?php echo $ticketList->ticketid ?> target="_blank" class="bold-text text-primary bold-text popup-modal"><i class="fa fa-calendar-check-o"></i> </a>
									<?php } ?>
									<?php if ($ticketList->support == $_SESSION['sms_userid'] && ($util->getStatusDefinition($ticketList->statusid) != 'Cancel' && $util->getStatusDefinition($ticketList->statusid) != 'Returned' && $util->getStatusDefinition($ticketList->statusid) != 'Accepted')) { 
										//echo $util->getStatusDefinition($ticketList->statusid);
											if (date("Y-m-d 17:00:00") >= $ticketList->dateofrequest) { ?>
												<a href="#" class="text-primary ticket-change-status" id="ticket-change-status-<?php echo $ticketList->ticketid ?>" data-toggle="modal" data-target=".change-status-entry" title="Change Status"><span class="glyphicon glyphicon-stats"></span></a>
											<?php }
											else
											{ ?>
												<a href="#" class="text-primary ticket-change-status" data-toggle="modal" title="Ticket created beyond 5:00PM will be considered for the next day."><span class="glyphicon glyphicon-exclamation-sign"></span></a>
												
										<?php }
										} ?>
									<?php if ($ticketList->requestor == $_SESSION['sms_userid'] && $util->getStatusDefinition($ticketList->statusid) == 'New' ) { ?>
										<a href="#" class="text-success ticket-edit" id="ticket-edit-<?php echo $ticketList->ticketid ?>" data-toggle="modal" data-target=".ticket-data-entry" title="Edit" data-whatever="Edit Ticket"><span class="glyphicon glyphicon-edit"></span></a>
										<a href="#" class="text-danger ticket-cancel" id="ticket-cancel-<?php echo $ticketList->ticketid ?>" title="Cancel"><span class="glyphicon glyphicon glyphicon-remove"></span></a>
									<?php } ?>
								</span>

								<?php } else if (($ticketList->support == $_SESSION['sms_userid'] && ($util->getStatusDefinition($ticketList->statusid) == 'Accepted' || $util->getStatusDefinition($ticketList->statusid) == 'Close')) || $this->session->userdata('sms_userlvl') == 'Administrator') { ?>
									<a href="#icf-form-modal" data-ticketid=<?php echo $ticketList->ticketid ?> target="_blank" class="bold-text text-primary bold-text popup-modal"><i class="fa fa-check-circle"></i> </a>
								<?php } ?>
							</td>
						</tr>
						<?php } ?>
					<?php } else { ?>
						<tr>
							<td colspan="10" class="text-center">No record</td>
						</tr>
					<?php } ?>


<script type="text/javascript">
	$('.simple-ajax-popup-align-top').magnificPopup({
		type: 'ajax',
		alignTop: true,
		overflowY: 'scroll' // as we know that popup content is tall we set scroll overflow by default to avoid jump
	});
	$('.popup-modal').magnificPopup({
		type: 'inline',
		preloader: false,
		focus: '#username',
		modal: true
	});
</script>