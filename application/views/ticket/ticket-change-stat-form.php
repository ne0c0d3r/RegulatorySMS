				<input type="hidden" name="txtTicketId" id="txtTicketId" value="<?php echo $ticketid ?>"></input>
				<input type="hidden" name="txtServiceid" id="txtServiceid" value="<?php echo $servicesid ?>"></input>
				<div class="row">
					<div class="col-md-6">
						<label>Status</label>
						<select class="form-control input-sm col-md-12" name="newStatus" id="newStatus" required>
							<option value=""></option>
							<?php 
							if (count($workflowData) > 0) {
								//if ($workflowData->woseq > 0) {
									$x['status'] = json_decode($workflowData->selectionStatus, true);
									$cnt = count($x['status'])-1;
									for ($i=0; $i <= $cnt; $i++) { 
										$wodata = $util->getWorkflow($servicesid, $x['status'][$i]); 
										if ($wodata) {
											$positionCode = ' (' . $wodata->positionCode . ')';
										} else {
											$positionCode = '';
										}?>

										<option value="<?php echo $x['status'][$i] ?>">
										<?php echo $util->getStatusDefinition($x['status'][$i]) . $positionCode ; ?>
										</option>
									<?php } ?>
								<?php //} ?>
							<?php } else { ?>
							<?php } ?>
						</select>
					</div>
					<div class="col-md-6 " id="route-wrapper">
					</div>
				</div>

