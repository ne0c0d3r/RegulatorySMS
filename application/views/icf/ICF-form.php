    <style type="text/css">
        #feedback_wrapper{
            font-family : Verdana, Geneva, Arial, Helvetica, Sans-serif!important;
            height: 100%;
            width:100%;
            margin-left: 30px;
            overflow:hidden;
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
    </style>
    <link href="<?php echo base_url() ?>css/icf-style.css" rel="stylesheet">
        <div id="feedback_wrapper put-border">
            <?php echo form_open('icf/submit_ratings/', array('name' => 'icfEntry', 'id' => 'icfEntry')) ?>
                <div id="print_area" style="background-color: white">
                <p class="pull-right margin3 text-bold text-danger">
                    <?php
                    var_dump($data['feedbackFormRs']);

                    $isDisabled = '';
                    $delivery = '';
                    $accuracy = '';
                    $failure = '';
                    $communication = '';
                    $others = '';
                    $suggestion = '';
                    $specify = '';

                    if (count($feedbackScoreRs) <= 0) { ?>
                        <button type="submit" class="btn btn-primary btn-xs" href="#" ><span class="glyphicon glyphicon-check"></span> Submit</button>
                    <?php } else {
                        $isDisabled = 'disabled';

                        $delivery = ($feedbackFormRs->delivery == 1)? 'checked': '';
                        $accuracy = ($feedbackFormRs->accuracy == 1)? 'checked': '';
                        $failure = ($feedbackFormRs->failure == 1)? 'checked': '';
                        $communication = ($feedbackFormRs->communication == 1)? 'checked': '';
                        if ($feedbackFormRs->others != '') {
                            $specify = 'checked';
                        }
                        $others = $feedbackFormRs->others;
                        $suggestion = $feedbackFormRs->suggestion;
                    }?>

                    <a class="popup-modal-dismiss btn btn-danger btn-xs" href="#" ><span class="glyphicon glyphicon-remove"></span> Close</a>
                </p>
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
                                        <td>FM-GBP-CPL-CS-001</td>
                                        <td>|</td>
                                        <td>REV. 00</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="clear"></div>
                        <div class="form_notice">
                            This form shall be accomplished semestrally and be submitted to the Document Custodian one week after end of semester.
                        </div>

                        <div class="content_wrapper">
                            <div class="content_header">
                                <table class="header_tbl">
                                    <tr>
                                        <td colspan="2" class="header_tbl_dept_title">PROVIDER</td>
                                        <td colspan="2" class="header_tbl_dept_title">CUSTOMER</td>
                                    </tr>
                                    <tr>
                                        <td class="header_tbl_lbl">Department/Unit:</td>
                                        <td class="space_data">
                                            <?php echo $assignedDetail->departmentName ?>
                                            <?php //var_dump($feedbackScoreRs); ?>
                                            <input type="hidden" name="provider" value="<?php echo $assignedDetail->departmentShortName ?>"></input>
                                        </td>
                                        <td class="header_tbl_lbl">Department/Unit:</td>
                                        <td class="space_data">
                                            <?php echo $requestorDetail->departmentName ?>
                                            <input type="hidden" name="customer" value="<?php echo $requestorDetail->departmentShortName ?>"></input>
                                        </td> 
                                    </tr>
                                    <tr>
                                        <td class="header_tbl_lbl">Period Covered:</td>
                                        <td colspan="3" class="space_data">
                                            <?php echo $util->datetime_std_format($startDate->startDate) ?> to <?php echo $util->datetime_std_format($endDate->endDate) ?>
                                            <input type="hidden" name="period" value="<?php echo $util->datetime_std_format($startDate->startDate) ?> to <?php echo $util->datetime_std_format($endDate->endDate) ?>"></input>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="header_tbl_lbl">Rendered Service:</td>
                                        <td colspan="3" class="space_data">
                                            <?php echo $util->getServiceDefintion($ticketData->servicesid) ?>
                                            <input type ="hidden" value="<?php echo $util->getServiceDefintion($ticketData->servicesid) ?>" name ="service">
                                            <input type ="hidden" value="<?php echo $ticketData->servicesid ?>" name ="servicesid">
                                        </td>
                                    </tr>
                                    <tr class="heder_tbl_ins">
                                        <td colspan="4">Based on your overall experience, please put (X) mark on the appropriate box.</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="content_answr_sht">
                                <table class="header_answr_sht_tbl" border="1" >
                                    <tr class="header_answr_sht_row">
                                        <th class="header" rowspan="2">Quality of Service Rendered</th>
                                        <td class="header" colspan="3">Very Satisfied</td>
                                        <td class="header" colspan="3">Satisfied</td>  
                                        <td class="header" colspan="4">Dissatisfied</td>
                                        <td class="header" rowspan="2">N/A</td>
                                        <td class="remarks" rowspan="2">Remarks</td>
                                    </tr>
                                    <tr class="header_answr_sht_row">
                                        <td class="header">10</td>
                                        <td class="header">9</td>
                                        <td class="header">8</td>
                                        <td class="header">7</td>
                                        <td class="header">6</td>
                                        <td class="header">5</td>
                                        <td class="header">4</td>
                                        <td class="header">3</td>
                                        <td class="header">2</td>
                                        <td class="header">1</td>
                                    </tr>
                                    <?php
                                        $start = 1;
                                        $overall = 0;
                                        foreach ($question_data as $question_list) {
                                            $counter = 0;
                                            ?>    
                                            <tr class="header_answr_sht_row">
                                                <td class="row_header"><ol start="<?php echo $start; ?>"><li><?php echo $question_list->question; ?></li></ol></td>
                                                <?php
                                                if (count($feedbackScoreRs) > 0) {                                               

                                                    $initScore = 0;
                                                    $notes = '';
                                                    $icfScoreRs = $util->getOverallScore($ticketData->ticketid, $question_list->question_id);
                                                    if ($icfScoreRs) {
                                                        $initScore = $icfScoreRs->score;
                                                        $notes = $icfScoreRs->remarks;
                                                    }
                                                } else {
                                                    $initScore = 10;
                                                }

                                                for ($counter = 10; $counter != -1; $counter--) {
                                                    $overall += ($counter == 10 ? $counter : 0)
                                                    ?>
                                                    <td class="header">
                                                        <input class="radio_btn" id="rdo<?php echo $start . $counter; ?>" type="radio" name="score<?php echo $start; ?>" value="<?php echo $counter; ?>" <?php echo ($counter == 10 ? 'checked' : '') ?> <?php echo ($initScore == $counter ? 'checked' : '') ?>  <?php echo $isDisabled ?>>
                                                    </td>
                                                <?php } ?>
                                                <td class="header">
                                                    <input type="hidden" name="question<?php echo $start; ?>" value="<?php echo $question_list->question; ?>">
                                                    <input type="hidden" name="qId<?php echo $start; ?>" value="<?php echo $question_list->question_id; ?>">
                                                    <input type="text" class="feedback_remarks" name="remarks<?php echo $start; ?>" placeholder="Remarks"  <?php echo $isDisabled ?>>
                                                </td>
                                            </tr>
                                            <?php
                                            $start++;
                                        }
                                   
                                    ?>
                                    <td class="header"><span>Overall Rating</span></td>
                                    <td colspan="8" class="header"><span id="overall"></span></td>
                                    <td colspan="4" class="header"><span id="overall_equi"></span></td>
                                        <input type="hidden" id="overall_score" name="overall_score" value="100">
                                        <input type="hidden" id="score_convert" name="score_convert" value="Outstanding">
                                    </tr>
                                </table>
                            </div>
                            <div class="clear"></div>
                            <div class="suggestion_wrapper">
                                <div class="suggestion_ins">
                                    * Please check appropriate box and provide explanation/reason(s) by citing instances (i.e., SLAs were not followed
                                    so we can properly address your concern(use additional sheets, if necessary).
                                </div>

                                <table class="suggestion_wrapper_tbl" >
                                    <tr>
                                        <td class="chck_inp"><input type="checkbox" name="delivery" <?php echo $delivery ?> <?php echo $isDisabled ?>></td>
                                        <td class="chck_lbl">DELIVERY TIME ISSUE</td>
                                        <td class="space_data"></td>
                                        <td class="chck_inp"><input type="checkbox" name="accuracy" <?php echo $accuracy ?> <?php echo $isDisabled ?>></td>
                                        <td class="chck_lbl">DATA ACCURACY</td>
                                        <td class="space_data"></td>
                                        <td class="chck_inp"><input type="checkbox" name="failure" <?php echo $failure ?> <?php echo $isDisabled ?>></td>
                                        <td class="chck_lbl">FAILURE RATE</td>
                                    </tr>
                                    <tr>
                                        <td class="chck_inp"><input type="checkbox" name="communication" <?php echo $communication ?> <?php echo $isDisabled ?>></td>
                                        <td class="chck_lbl">POOR COMMUNICATION</td>
                                        <td class="space_data"></td>
                                        <td class="chck_inp"><input type="checkbox" name="specify" <?php echo $specify ?> <?php echo $isDisabled ?>></td>
                                        <td class="chck_lbl">OTHERS (PLEASE SPECIFY)</td>
                                        <td colspan="3" class="specify">
                                        <input class="specify_input" type="text" name="others" placeholder="Others" value="<?php echo $others ?>" <?php echo $isDisabled ?>></td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" class="suggestion_wrapper_tbl_sep"></td>
                                    </tr>
                                </table>
                                <div class="suggestion">
                                    Other Suggestions/Comments for Improvement:
                                </div>
                                <table class="suggestion_inp">
                                    <tr><td>
                                        <textarea id="suggestions" class="suggestion" type="text" name="suggestions" rows="5" placeholder="Suggestions" <?php echo $isDisabled ?>><?php echo $suggestion ?></textarea>
                                    </td></tr>                                   
                                </table>
                            </div>
                            <div class="clear"></div>
                            <div class="signatories">
                                <div class="respondent_wrapper">
                                    <div class="respondent_text">Respondent:
                                        <table border="0">
                                            <tr>
                                                <td class="sign_names">
                                                    <input type="hidden" value="<?php echo $util->getName($ticketData->assignedTo) ?>" name="respondent">
                                                    <?php echo $util->getName($ticketData->requestor) ?>
                                                    
                                                </td>
                                                <td class="signature_sep"></td>
                                                <td class="respondent_date_inp">                                                    
                                                    <input class="rec_date" type="hidden" name="res_date" id="res_date" value="<?php echo $endDate->endDate ?>">
                                                    <?php echo $util->date_std_format($endDate->endDate) ?>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td class="respondent_signature">Signature over Printed Name</td>
                                                <td class="signature_sep"></td>
                                                <td class="respondent_date">Date</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="receive_wrapper">
                                    <div class="receive_text">Received by:
                                        <table border="0">
                                            <tr>
                                                <td class="sign_names">
                                                    <input type="hidden" value="<?php echo $util->getName($ticketData->requestor) ?>" name="received">
                                                    <?php echo $util->getName($ticketData->assignedTo) ?>
                                                </td>
                                                <td class="signature_sep"></td>

                                                <td class="respondent_date_inp">
                                                    <input class="rec_date" type="hidden" name="rec_date" id="rec_date" value="<?php echo $endDate->endDate ?>" >
                                                    <?php echo $util->date_std_format($util->today_date()) ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="receive_signature">Signature over Printed Name</td>
                                                <td class="signature_sep"></td>
                                                <td class="receive_date">Date</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>   
        </div>

<script type="text/javascript">

    $(document).ready(function () {
        var max_char, fld_char, sugg1_char, sugg2_char, sugg3_char;
        max_char = 115;
        sugg1_char = 0;
        sugg2_char = 0;
        sugg3_char = 0;
        rdo_btn_cnt = 10;
        q_cnt = <?php echo count($question_data); ?>;

        $(".radio_btn").click(function() {
            scores = [];
            na = 0;
            subtotal = 0;
            qwe = "";
            for (x = 10; x > 0; x--) {
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
                returnval = "Outstanding";
            } else if (overall >= 84 && overall <= 91) {
                returnval = "Very Good";
            } else if (overall >= 76 && overall <= 83) {
                returnval = "Good";
            } else if (overall >= 71 && overall <= 75) {
                returnval = "Fair";
            } else if (overall <= 70) {
                returnval = "NI";
            }
            $("#overall_equi").text(returnval);
            $("#score_convert").val(returnval);
        });


        $("#rdo110").click();
    });
</script>
