					<?php if (count($detailData) > 0) { ?>
						<table class="table table-default rmv-all-margin" border="0">

							<tr>
								<td class="width70 ticket-right"><label>Ticket #</label></td>
								<td class="width100"><?php echo $detailData->ticketid ?></td>
								<td class="width50"><label>Support</label></td>
								<td>
									<a href="<?php echo base_url() ?>employee/?userid=<?php echo $detailData->assignedTo ?>" class="text-danger" title="View User Detail"><span class="glyphicon glyphicon-user"></span> 
									<?php 
										$empdata = $util->getEmployeeDetail($detailData->assignedTo);
										if (count($empdata) > 0) {
		                                	echo $empdata->lastName . ', ' . $empdata->firstName . ' ' . $empdata->middleName;
										}
									?>
									</a>
								</td>
							</tr>
							<tr>
								<td class=" text-right"><label>Subject</label></td>
								<td colspan="3"><?php echo $detailData->subject ?></td>
							</tr>
							<tr style="height: 70px !important">
								<td class="rmv-border-top rmv-padding-top text-right"><label>Message</label></td>
								<td class="rmv-border-top rmv-padding-top" colspan="3">
									<?php if ($detailData->requestor == $this->session->userdata('sms_userid') || $detailData->support == $this->session->userdata('sms_userid') || $detailData->assignedTo == $this->session->userdata('sms_userid') || $this->session->userdata('sms_userlvl') == 'Dispatcher' ) { ?>
										<?php echo nl2br($detailData->message) ?>
									<?php } else { ?>
										<i> Content is available only to requestor and assigned support. </i>
									<?php }?>
								</td>
							</tr>
							<tr style="">
								<td class="rmv-border-top rmv-padding-top text-right"><label>Quantity</label></td>
								<td class="rmv-border-top rmv-padding-top" colspan="3">
									<span class="badge normal-font font8"><?php echo $detailData->qty ?></span> &nbsp;&nbsp; | &nbsp;&nbsp;
									<!-- <label>Copy</label> -->
									<span class="glyphicon glyphicon-duplicate"></span> &nbsp;&nbsp;
									<?php if (($detailData->originalCopy+$detailData->originalCopy+$detailData->originalCopy) == 0) {
										echo '<span class="badge normal-font font8">n/a</span>';
									} ?>
									
									<?php echo ($detailData->originalCopy == 1)? '<span class="badge normal-font font8"> *Original Copy </span>':''  ?>
									<?php echo ($detailData->certifiedTrue == 1)? '<span class="badge normal-font font8"> *Certified True </span>':''  ?>
									<?php echo ($detailData->photoCopy == 1)? '<span class="badge normal-font font8"> *Photo Copy </span>':''  ?> 
									
								</td>
							</tr>

							<tr>
								<td class="text-right"><span class="glyphicon glyphicon-paperclip"></span></td>
								<td class="" colspan="3">
								<?php if (count($attachData) > 0) { ?>
						  			<?php foreach ($attachData as $attachList) { ?>
						  				<?php
											$head = array_change_key_case(get_headers(base_url() . "resources/uploads/" . $attachList->fileHash, TRUE));
											$filesize = $head['content-length'];
											//var_dump($head);
											$filesize = number_format((float)$filesize/1048576, 2, '.', '');

						  				?>
						  				<span class="label label-success font9 margin1 inline-flex normal-font">
						  					<a class="color-white font8" href="<?php echo base_url() ?>resources/uploads/<?php echo $attachList->fileHash ?>" target="_blank" >
						  						<?php echo '<b style="color:blue">' . $filesize . 'MB</b> ' . substr($attachList->fileName, 0, 50)  ?><?php echo (strlen($attachList->fileName) > 50) ? ' [...]' : '' ?> 
						  					</a>
						  					<!---<a href="" class="color-white"><span class="glyphicon glyphicon-remove"></span></a> -->
						  				</span>
						  			<?php } ?>
						  		<?php } else { ?> 
						  			n/a
						  		<?php } ?>
								</td>

							</tr>
					  		
						</table>
					<?php } ?>

			       