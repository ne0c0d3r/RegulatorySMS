	<style type="text/css">
		#feedback_wrapper{
			font-family : Verdana, Geneva, Arial, Helvetica, Sans-serif!important;
			height: 100%;
			width:100%;
			margin-left: 30px;
			overflow: auto
		}
		#print_area{
			font-family : Verdana, Geneva, Arial, Helvetica, Sans-serif!important;
			height: 100%;
			width: 80%;
			color: #000000;
			margin:30px auto;
			padding: 50px;
			top: 50px
		}

		@page {
			margin: 0px;
			padding: 0px;
		}
		@media print {

			#feedback_wrapper * {
				visibility: hidden !important; 
			}
			#feedback_wrapper #print_area * {
				visibility: visible !important;
				font-size: 5pt !important;
			}            
			#feedback_form .logo_wrapper{
				float:left !important;
				width: 150px !important;
				height: 100px !important;
				margin: auto !important;
			}

			#feedback_form .form_title_wrapper{
				float:left !important;
				width: 450px !important;
				height: 40px !important;
				border: 2px solid #000000 !important;
				border-radius: 30px !important;
				-moz-border-radius: 30px !important;
				-webkit-border-radius: 30px !important;
				margin-top:20px !important;
				margin-right: 40px !important;
			}
			#print_area{
				font-family : Verdana, Geneva, Arial, Helvetica, Sans-serif!important;
				height: 100%;
				width: 80%;
				color: #000000;
				margin:30px auto;
				padding: 0px;
				top: 0px
			}

			.action-button {
				visibility: hidden !important;
			}
		}
		fieldset {
			border: 0px !important;
			margin: 0px !important;
			padding: 0px !important;
		}
		input[type='radio'] {
		  
		  border:1px solid darkgray;
		  border-radius:50%;
		  outline:none;
		  /*box-shadow:0 0 5px 0px gray inset;*/
		}

		input[type='radio']:hover {
		  box-shadow:0 0 5px 0px orange inset;
		}

		input[type='radio']:before {
		  content:'';
		  display:block;
		  width:100%;
		  height:100%;
		  border-radius:50%;    
		}
		input[type='radio']:checked:before {
		  background:green;
		}
		.input-bg-transparent {
			background-color: white !important;
		}
	</style>

	<link href="<?php echo base_url() ?>css/icf-style-rev5.css" rel="stylesheet">
		<div id="feedback_wrapper put-border">

			<?php 
			if (count($feedbackScoreRs) <= 0 || empty($feedbackFormRs)) {
				echo form_open('icf/submit_ratings_rev5/', array('name' => 'icfEntry', 'id' => 'icfEntry')); } ?>
				<div id="print_area" style="background-color: white">
				<div class="widthfull text-right">
				<p class="text-bold text-danger action-button">
					<input type="hidden" name="txtsubservice" value="<?php echo $ticketData->services ?>">
					<?php
					$isDisabled = '';
					$delivery = '';
					$accuracy = '';
					$failure = '';
					$communication = '';
					$others = '';
					$suggestion = '';
					$specify = '';

					$groupcremarks = '';
					$frequency = '';
					$curquarter = '';
					if (count($feedbackScoreRs) <= 0 || empty($feedbackFormRs)) { 
                        if ($getToday->mm <= 3) {
                            $curquarter = '1ST QUARTER';
                        } elseif ($getToday->mm >= 4 && $getToday->mm <= 6) {
                            $curquarter = '2ND QUARTER';
                        } elseif ($getToday->mm >= 7 && $getToday->mm <= 9) {
                            $curquarter = '3RD QUARTER';
                        } elseif ($getToday->mm >= 10 && $getToday->mm <= 12) {
                            $curquarter = '4TH QUARTER';
                        }

                        ?>
						<button type="submit" class="btn btn-primary btn-xs" href="#" ><span class="glyphicon glyphicon-check"></span> Submit</button>
					<?php } else {

						$isDisabled = 'disabled';

						$delivery = ($feedbackFormRs->deliverytimeissue == 1)? 'checked': '';
						$accuracy = ($feedbackFormRs->dataaccuracy == 1)? 'checked': '';
						$failure = ($feedbackFormRs->failurerate == 1)? 'checked': '';
						$communication = ($feedbackFormRs->poorcommunication == 1)? 'checked': '';
						if ($feedbackFormRs->others != '') {
							$specify = 'checked';
						}
						$others = $feedbackFormRs->others;
						$suggestion = $feedbackFormRs->othersuggestion;
						$groupcremarks = $feedbackFormRs->groupcremarks;
						$frequency = $feedbackFormRs->frequency;
						$curquarter = $feedbackFormRs->quarter; ?>
						<a class="btn btn-primary btn-xs" href="<?php echo base_url() ?>icf/feedback_form_rev5/<?php echo $ticketData->ticketid ?>/0/" target="_blank" ><span class="glyphicon glyphicon-print"></span> Print</a>
					<?php } ?>
					<a class="popup-modal-dismiss btn btn-danger btn-xs" href="#" ><span class="glyphicon glyphicon-remove"></span> Close</a>
				</p>
				</div>
				<br>

					<div id="feedback_form" class="feedback_form_container">
						<div class="logo_wrapper">
							<div class="logo"></div>
						</div>
						<div class="form_title_wrapper">
							<div class="form_title_shape">
								<div class="form_title_text">INTERNAL CUSTOMER FEEDBACK (ICF)</div>
							</div>
							<div class="form_title_wrapper_table">
								<table>
									<tr>
										<td>FM-GBP-IMS-CS-001</td>
										<td>|</td>
										<td>REV. 05</td>
									</tr>
								</table>
							</div>
						</div>
						<div class="clear"></div>
						<br>
						<div class="">
							<h4>A. GENERAL INFORMATION</h4>
						</div>
						<div class="content_wrapper">
							<div class="content_header">
								<i><h5 class="text-bold text-danger">RATER: <span class="margin-left-135 text-underline"><u><?php echo $util->getName($requestorDetail->employeeId) ?></u></span>  </h5></i>
								<table class="header_tbl" border="0">
									<tr>
									   <td class="header_tbl_lbl">SITE (RATER)</td> 
									   <td>
											<input type="text" id="txtsiterater" class="input-no-border" name="txtsiterater" value="<?php echo $requestorDetail->siteGroupName ?>" <?php echo $isDisabled ?> readonly style="background-color: white !important;" >
									   </td>
									   <td class="header_tbl_lbl">DEPARTMENT</td>
									   <td>
											<input type="text" id="txtdeptrater" class="input-no-border" name="txtdeptrater" value="<?php echo $requestorDetail->departmentShortName ?>" <?php echo $isDisabled ?> readonly style="background-color: white !important;"></input>                                           
									   </td>
									</tr>
								</table>
								<i><h5 class="text-bold text-danger">SERVICE PROVIDER: <span class="margin-left-28"><u><?php echo $util->getName($assignedDetail->employeeId) ?></u></span></h5></i>
								<table class="header_tbl">
									<tr>
									   <td class="header_tbl_lbl">PERIOD COVERED</td> 
									   <td>
											<span class=""> Year</span> <input type="text" id="txtyear" class="input-no-border pull-right" name="txtyear" value="<?php echo $getToday->yy ?>" <?php echo $isDisabled ?> readonly style="background-color: white !important;">
									   </td>
									   <td class="header_tbl_lbl">FREQUENCY</td>
									   <td>
											<select id="txtfrequency" class="input-no-border" name="txtfrequency" readonly style="background-color: white !important;" <?php echo $isDisabled ?>>
												<option value="">Please select</option>
												<option value="DAILY" <?php echo ($frequency == 'DAILY') ? 'selected' : '' ?>>DAILY</option>
												<option value="WEEKLY" <?php echo ($frequency == 'WEEKLY') ? 'selected' : '' ?>>WEEKLY</option>
												<option value="MONTHLY" <?php echo ($frequency == 'MONTHLY') ? 'selected' : '' ?>>MONTHLY</option>
												<option value="QUARTERLY" <?php echo ($frequency == 'QUARTERLY') ? 'selected' : '' ?>>QUARTERLY</option>
												<option value="SEMESTRAL" <?php echo ($frequency == 'SEMESTRAL') ? 'selected' : '' ?>>SEMESTRAL</option>
												<option value="YEARLY" <?php echo ($frequency == 'YEARLY') ? 'selected' : '' ?>>YEARLY</option>
											</select>
									   </td>
									   <td class="header_tbl_lbl">QUARTER</td>
									   <td>
											<input type="text" id="txtquarter" class="input-no-border" name="txtquarter" value="<?php echo $curquarter ?>" <?php echo $isDisabled ?> readonly style="background-color: white !important;">
									   </td>
									</tr>
									<tr>
									   <td class="header_tbl_lbl">SITE (OF PROVIDER)</td> 
									   <td>
											<input type="text" id="txtsiteprovider" class="input-no-border" name="txtsiteprovider" value="<?php echo $assignedDetail->siteGroupName ?>" <?php echo $isDisabled ?> readonly style="background-color: white !important;">
									   </td>
									   <td class="header_tbl_lbl">DEPARTMENT</td>
									   <td colspan="3">
											<input type="text" id="txtdeptprovider" class="input-no-border" name="txtdeptprovider" value="<?php echo $assignedDetail->departmentShortName ?>" <?php echo $isDisabled ?> readonly style="background-color: white !important;">
									   </td>
									</tr>
									<tr>
									   <td colspan="2" class="header_tbl_lbl">TYPE OF SERVICE REQUESTED</td> 
									   <td colspan="4">
											<input type="text" class="widthfull input-no-border" id="txttypeservice" name="txttypeservice" value="GENERAL/COMMON SERVICES" <?php echo $isDisabled ?> readonly style="background-color: white !important;">
									   </td>
									</tr>
									<tr>
									   <td colspan="2" class="header_tbl_lbl">SERVICE REQUESTED BY THE RATER</td> 
									   <td colspan="4">
											<input type="text" id="servicesid" class="input-no-border" name="servicesid" value="<?php echo $ticketData->servicesid ?>" readonly style="background-color: white !important;">
											<input type="text" class="widthfull input-no-border" id="txtraterrequest" name="txtraterrequest" value="<?php echo $ticketData->services ?>" <?php echo $isDisabled ?> readonly style="background-color: white !important;">
									   </td>
									</tr>
									<tr>
									   <td colspan="2" class="header_tbl_lbl">SERVICE LEVEL AGREEMENT (WORKING DAYS)</td> 
									   <td colspan="4">
											<input type="text" class="widthfull input-no-border" id="txtlvlagree" name="txtlvlagree" value="N/A" <?php echo $isDisabled ?> readonly style="background-color: white !important;">
									   </td>
									</tr>
								</table>

								
							</div>
							<div class="">
								<h4>B. RATING</h4>
								<p>Based on your overall experience, please put (X) mark on the appropriate box.</p>
							</div>
							<div class="content_answr_sht">
								<table class="header_answr_sht_tbl" border="1" >
									<tr class="header_answr_sht_row">
										<th class="header">Quality of Service Rendered</th>
										<td class="header" >Very Satisfied</td>
										<td class="header" >Satisfied</td>  
										<td class="header" >Dissatisfied *</td>
										<td class="header" >Very Dissatisfied*</td>
										<td class="header" >N/A</td>
										<td class="remarks" >Remarks</td>
									</tr>
									<?php
										$start = 1;
										$overall = 0;
										$subService = '';
										foreach ($question_data as $question_list) {
											$counter = 0;
											
											?>    

											<tr class="header_answr_sht_row">
												<td class="row_header"><ol start="<?php echo $start; ?>"><li>
													<?php echo $question_list->question; ?>
													<input type="hidden" name="question_count[]">
												</li></ol></td>
												<?php
												$notes = '';
												if (count($feedbackScoreRs) > 0) {                                               

													$initScore = 0;
													$notes = '';
													$icfScoreRs = $util->getOverallScore($ticketData->ticketid, $question_list->question_id);
													if ($icfScoreRs) {
														$initScore = $icfScoreRs->score;
														$notes = $icfScoreRs->remarks;
													}
												} else {
													$initScore = 4;
												}


												for ($counter = 4; $counter != -1; $counter--) {
													$overall += ($counter == 4 ? $counter : 0);
													?>
													<td class="header">
														<input class="radio_btn" id="rdo<?php echo $start . $counter; ?>" type="radio" name="score<?php echo $start; ?>" data-seq=<?php echo $start ?> value="<?php echo $counter; ?>" <?php echo ($initScore == $counter ? 'checked' : '') ?> <?php echo $isDisabled ?>>
													</td>
												<?php } ?>
												<td class="header">
													<input type="hidden" name="question<?php echo $start; ?>" value="<?php echo $question_list->question; ?>">
													<input type="hidden" name="qId<?php echo $start; ?>" value="<?php echo $question_list->question_id; ?>">
													<input type="text" class="feedback_remarks" id="remarks<?php echo $start; ?>" name="remarks<?php echo $start; ?>" placeholder="Remarks" value="<?php echo $notes ?>" >
												</td>
											</tr>
											<?php
											$start++;
										}
								   
									?>
									<!-- <tr>
									<td class="header"><span>Overall Rating</span></td>
									<td colspan="5" class="header"><span id="overall"></span></td>
									<td colspan="" class="header"><span id="overall_equi"></span></td>
									</tr> -->
										<input type="hidden" id="overall_score" name="overall_score" value="100">
										<input type="hidden" id="score_convert" name="score_convert" value="Outstanding">
								</table>
							</div>
							<div class="clear"></div>
							<div class="">
								<h4>C. COMMENTS/FEEDBACK</h4>
							</div>
							<div class="suggestion_wrapper">
								<div class="suggestion_ins">
									* Please check appropriate box and provide explanation/reason(s) by citing instances (i.e., SLAs were not followed
									so we can properly address your concern(use additional sheets, if necessary).
								</div>

								<table class="suggestion_wrapper_tbl" >
									<tr>
										<td class="chck_inp"><input type="checkbox" class="groupc" name="delivery" <?php echo $delivery ?> <?php echo $isDisabled ?>></td>
										<td class="chck_lbl">DELIVERY TIME ISSUE</td>
										<td class="space_data"></td>
										<td class="chck_inp"><input type="checkbox" class="groupc" name="accuracy" <?php echo $accuracy ?> <?php echo $isDisabled ?>></td>
										<td class="chck_lbl">DATA ACCURACY</td>
										<td class="space_data"></td>
										<td class="chck_inp"><input type="checkbox" class="groupc" name="failure" <?php echo $failure ?> <?php echo $isDisabled ?>></td>
										<td class="chck_lbl">FAILURE RATE</td>
									</tr>
									<tr>
										<td class="chck_inp"><input type="checkbox" class="groupc" name="communication" <?php echo $communication ?> <?php echo $isDisabled ?>></td>
										<td class="chck_lbl">POOR COMMUNICATION</td>
										<td class="space_data"></td>
										<td class="chck_inp"><input type="checkbox" class="" id="specify" name="specify" <?php echo $specify ?> <?php echo $isDisabled ?>></td>
										<td class="chck_lbl">OTHERS (PLEASE SPECIFY)</td>
										<td colspan="3" class="specify">
										<input class="specify_input input-bg-transparent " type="text" id="specifyothers" name="others" placeholder="Others" value="<?php echo $others ?>" <?php echo $isDisabled ?>></td>
									</tr>
									<tr>
										<td colspan="8" class="suggestion_wrapper_tbl_sep">
											<textarea class="widthfull input-bg-transparent " id="groupcremarks" name="groupcremarks" placeholder="Remarks" <?php echo $isDisabled ?>><?php echo $groupcremarks ?></textarea>
										</td>
									</tr>
								</table>
								<div class="suggestion">
									Other Suggestions/Comments for Improvement:
								</div>
								<table class="suggestion_inp">
									<tr><td>
										<textarea id="suggestions" class="suggestion input-bg-transparent " type="text" name="suggestions" rows="5" placeholder="Suggestions" <?php echo $isDisabled ?>><?php echo $suggestion ?></textarea>
									</td></tr>                                   
								</table>
							</div>
							<br>
							<div class="text-center widthfull border-double">
								<span class="text-italic text-bold">
									Thank you for completing this Internal Customer Feedback. Kindly email your accomplished form to respective IMS team.
								</span>
							</div>
							<div class="clear"></div>
								
							</div>
						</div>
					</div>
				</div>
			</form>   
		</div>
		<script type="text/javascript">
			$(document).ready(function () {
				//$('input').attr('disabled', 'disabled');
				var max_char, fld_char, sugg1_char, sugg2_char, sugg3_char;
				max_char = 115;
				sugg1_char = 0;
				sugg2_char = 0;
				sugg3_char = 0;
				rdo_btn_cnt = 4;
				q_cnt = <?php echo count($question_data); ?>;

				$(".groupc").click(function() {
					var count = $('.groupc:checkbox:checked').length;
					if (count > 0) {
						$('#groupcremarks').attr('required', 'required');
					} else {
						$('#groupcremarks').removeAttr('required');
					}

				});
				$('#specify').click(function(){
					var isCheck = $('#specify:checkbox:checked').length;
					if (isCheck == 0) {
						$('#specifyothers').attr('required', 'required');
					} else {
						$('#specifyothers').removeAttr('required');
					}

				});
				$(".radio_btn").click(function() {
					var radioval = $(this).val();
					var seq = $(this).data('seq');

					if (radioval <= 2) {
						$('#remarks' + seq).attr('required', 'required');
					} else {
						$('#remarks' + seq).removeAttr('required');
					}

					scores = [];
					na = 0;
					subtotal = 0;
					qwe = "";
					for (x = 4; x > 0; x--) {
						scores[x] = 0;
					}
					for (a = 1; a <= q_cnt; a++) {
						cur_val = $("input[type='radio'][name='score" + a + "']:checked").val();
						scores[cur_val] += 1;
						if (parseInt(cur_val) === 0) {
							na += 1;
						}

					}
					for (x = scores.length - 1; x > 0; x--) {
						subtotal += ((scores[x] * x) / ((q_cnt - na) * (scores.length - 1)) * 100);
					}

					$("#overall").text(subtotal.toFixed(2) + "%");
					$("#overall_score").val(subtotal.toFixed(2) + "%");
					var overall = subtotal.toFixed(2);

					if (overall >= 92) {
						returnval = "Excellent";
					} else if (overall >= 84 && overall <= 91) {
						returnval = "Very Good";
					} else if (overall >= 76 && overall <= 83) {
						returnval = "Good";
					} else if (overall >= 70 && overall <= 75) {
						returnval = "Fair";
					} else if (overall < 70) {
						returnval = "Poor";
					} else {
						returnval = '';
					}
					$("#overall_equi").text(returnval);
					$("#score_convert").val(returnval);
				});


				$("#rdo14").click();
			});

		</script>
