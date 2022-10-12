                    <table class="table table-default rmv-all-margin" border="0">
                      <tr>
                        <th class="width150">Status</th>
                        <!-- <th class="width20 text-center">SEQ</th> -->
                        <th>Remarks</th>
                      </tr>
                      <tbody>
						<?php if (count($statusData) > 0) { 
							$days = 0;
							foreach ($statusData as $statusList) { 
								$total = $statusList->diffInMinute;
								$days = str_pad(floor($total/1440), 2, 0, STR_PAD_LEFT);
								$hours = str_pad(floor(($total-($days*1440))/60), 2, 0, STR_PAD_LEFT);
								$minutes = str_pad($total-(($days*1440)+($hours*60)), 2, 0, STR_PAD_LEFT);
								?>
							  	<tr>
									<td class="bold-text"><?php echo $statusList->status ?></td>
									<!-- <td class="text-center"><?php echo $statusList->woseq ?></td> -->
									<!-- <td class=""><?php echo $util->getName($statusList->routedTo) ?></td> -->
									<td>
								  		<span class="text-muted pull-right"><?php echo date_format(new DateTime($statusList->statusdate), 'D m/d/Y H:i') ?></span>
								  		
										<?php echo $statusList->remarks ?><br> 
										

									</td>
							  	</tr>

							  	<tr>
							  		<td class="rmv-border-top rmv-padding-top">
								  			<span class="text-danger glyphicon glyphicon-time"></span> <?php echo $days . "d:" . $hours . "h:" . $minutes . 'm' ?>
								  	</td>
							  		<td class="rmv-border-top rmv-padding-top">
										<label class="width100"><b class="text-primary">Assigned to:</b></label> <?php echo $util->getName($statusList->routedTo) ?> <br> 
										<label class="width100"><b class="text-danger">Initiator:</b></label> <?php echo $util->getName($statusList->changedby) ?>
							  		</td>
							  	</tr>
							  	<?php
							  	$isOk = false;
				  				if ($_SESSION['sms_userid'] == $statusList->routedTo || $_SESSION['sms_userid'] == $statusList->changedby/* || $_SESSION['sms_userid'] == $ticketData->requestor*/) {
				  					$isOk = true;
				  				} elseif ($_SESSION['sms_userlvl'] == 'Counsel' || $_SESSION['sms_userlvl'] == 'Dispatcher') {
				  					$isOk = true;
				  				}?>
				  				<?php if ($isOk) { ?>
							  		<?php $attachRs =  $modAttach->statusAttachment($statusList->statuslogsid); ?>
								  	<?php if (count($attachRs) > 0) { ?>
								  	<tr>
								  		<td class="rmv-border-top rmv-padding-top" colspan="2">
								  			<table>
								  				<tr>
											  		<td class="rmv-border-top rmv-all-padding width30 text-center"><span class="glyphicon glyphicon-paperclip"></span></td>
											  		<td class="rmv-border-top rmv-all-padding">
														<?php foreach ($attachRs as $attachList) { ?>
										  				<?php
															$head = array_change_key_case(get_headers(base_url() . "resources/uploads/" . $attachList->fileHash, TRUE));
															$filesize = $head['content-length'];
															//var_dump($head);
															$filesize = number_format((float)$filesize/1048576, 2, '.', '');
											  				?>
											  				<span class="label label-info font8 margin1 inline-flex">
											  					<a class="normal-font color-white text-danger" href="<?php echo base_url() ?>resources/uploads/<?php echo $attachList->fileHash ?>" target="_blank" ><?php echo '<b style="color:blue">' . $filesize . 'MB</b> ' . $attachList->fileName ?></a>
											  				</span>
												  		<?php } ?>
											  		</td>
										  		</tr>
									  		</table>
								  		</td>
								  	</tr>
								  	<?php }  ?>
								<?php }  ?>
							<?php } 
						} else { ?>
							<tr>
								<td class="text-center" colspan="3">- - - <span class="text-danger glyphicon glyphicon-warning-sign"></span> Status Not Available - - -</td>
							</tr>
						<?php } ?>

                      </tbody>
                    </table>