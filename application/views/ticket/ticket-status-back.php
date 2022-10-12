					<?php if (count($statusData) > 0) { 
						foreach ($statusData as $statusList) { ?>
						  	<tr>
								<td class="bold-text"><?php echo $statusList->status ?></td>
								<!-- <td class="text-center"><?php echo $statusList->woseq ?></td> -->
								<td class=""><?php echo $util->getName($statusList->routedTo) ?></td>
								<td>
							  		<span class="text-muted pull-right"><?php echo date_format(new DateTime($statusList->statusdate), 'D m/d/Y h:i') ?></span>
									<?php echo $statusList->remarks ?>							  		
								</td>
						  	</tr>
						  	<?php $attachRs =  $modAttach->statusAttachment($statusList->statuslogsid); ?>
						  	<?php if (count($attachRs) > 0) { ?>
						  	<tr>
						  		<td class="rmv-border-top rmv-padding-top" colspan="3">
						  			<table>
						  				<tr>
									  		<td class="rmv-border-top rmv-all-padding width30 text-center"><span class="glyphicon glyphicon-paperclip"></span></td>
									  		<td class="rmv-border-top rmv-all-padding">
												<?php foreach ($attachRs as $attachList) { ?>
									  				<span class="label label-info font8 margin1 inline-flex">
									  					<a class="normal-font color-white text-danger" href="<?php echo base_url() ?>resources/uploads/<?php echo $attachList->fileHash ?>" target="_blank" ><?php echo $attachList->fileName ?></a>
									  				</span>
										  		<?php } ?>
									  		</td>
								  		</tr>
							  		</table>
						  		</td>
						  	</tr>
						  	<?php }  ?>
						<?php } 
					} else { ?>
						<tr>
							<td class="text-center" colspan="3">- - - <span class="glyphicon glyphicon-warning-sign"></span> Status Not Available - - -</td>
						</tr>
					<?php } ?>

