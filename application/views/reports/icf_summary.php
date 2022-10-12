<style type="text/css">
    * {font-size: 8pt;}
    .form_title_container{margin-left: 140px;margin-top: 10px;padding: 15px;border: 5px solid black;text-align: center;-webkit-border-radius: 27px;-moz-border-radius: 27px;border-radius: 27px;width: 400px;}
    .form_title{font-size: 14pt;font-weight: bolder;}
    .form_version_container{margin-left: 140px;margin-top: 5px;}
    .form_version{margin-left: 110px;}
    .form_version tr td {padding: 2px;border: 1px solid black;}
    .form_row{border: 1px solid black;min-height: 50px;}
    .form_row_white{border: 1px solid black;min-height: 60px;}
    .form_body_container{height: 500px;/*background-color: red;*/border: 1px solid black;}
    .form-label{width: 130px;padding: 2px 0px 2px 3px;}
    .form-blank{width: 205px;padding: 2px 0px 2px 3px;}
    .form-big-blank{width: 310px;padding: 2px 0px 2px 3px;}
    .form-detail{width: 490px;border: 0px solid rgb(255,255,255);padding: 2px 0px 2px 3px;}
    .form-sm-detail{width: 242px;margin-left: 5px;border: 1px solid black;padding: 2px 0px 2px 3px;}
    .label-foot {font-size: 10pt;}
    .form-label-blank{width: 200px;border: 0px solid black;}
    .form-label-right{width: 200px;padding: 2px 0px 2px 3px;text-align: right;font-weight: bold;}
    .inline-label {width: 300px !important; font-weight: bold;}
    .italic {font-style: italic;}
    #department{text-align: center;}
    .underline{text-align: center;width: 255px;border-bottom:1px solid;}
    .text-center{text-align: center;}
    .field-value {width: 250px;padding: 2px 0px 2px 3px;font-weight: bold;}
    .text-right{text-align: right;}
    table tr.tbl-header td {font-weight: bold;}
    table tr.tbl-subsummary td {font-weight: bold;}
    table tr.tbl-header td, table tr.tbl-row td, table tr.tbl-subsummary td {padding: 2px 3px 2px 3px;}
</style>

<page style="font-size: 12px;font-family:arial;">

    <!-- logo Left -->
    <div style="width: 100%;font-size: 14px;font-family:arial;" class="page_header">
        <table id="main_tbl" border="0">
            <tr>
                <td>
                    <img src='<?php echo base_url(); ?>resources/images/GBP_black.png' style="width:200px;" />
                </td>
                <td>
                    <div class="form_title_container">
                        <span class="form_title">
                            Internal Customer Feedback Summary
                        </span>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                	<br><br>
               	</td>
            </tr>
        </table>
                <b></b>
                <table border="1" width="100%" cellpadding="0" cellspacing="0" style="border: 1px solid #ccc">
                    <tr class="tbl-header">
                        <td colspan="8">Period Covered: <?php echo $from ?> to <?php echo $to ?><br><br></td>
                    </tr>
                	<tr class="tbl-header" style="background-color: black;color: white">
                		<td class="text-center" style="width: 20px">#</td>
                		<td style="width: 20px">Ticket</td>
                		<td class="" style="width: 90px">Counsel</td>
                        <td class="" style="width: 80px">Requestor</td>
                        <td class="" style="width: 60px">Date Request</td>
                        <td class="" style="width: 60px">Services</td>
                        <td class="text-center" style="width: 30px">Score</td>
                		<td >Rating</td>
                	</tr>
                    <?php
                    $subservice = '.';
                    $subservice1 = '.';
                    $sumTotalScore = 0;
                    $sumPercentage = 0;
                    $subcounter = 0;

                    $counter = 0;
                    $numRows = count($summaryRs);
                    $service = '';
                    foreach ($summaryRs as $summaryList) {
                        $counter++;
                        if ($counter == 1) {
                            $service = $summaryList->service;
                        }
                        
                        $perVal = $util->formatNumber($summaryList->percentage, 2);
                        ?>

                        <?php

                            if ($service != $summaryList->service) {
                                
                                $service = $summaryList->service; ?>
                                <tr class="tbl-subsummary" style="background-color: #277e35;color: white">
                                    <td class="text-right" colspan="6">
                                        Average
                                    </td>
                                    <td class="text-center">    
                                        <?php echo $util->formatNumber($sumPercentage/$subcounter, 2); ?>%
                                    </td>
                                    <td>
                                        <?php echo $util->getRatings($util->formatNumber($sumPercentage/$subcounter, 2));?>
                                    </td>
                                </tr>
                                <?php 
                                $sumTotalScore = 0;
                                $sumPercentage = 0;
                                $subcounter = 0;
                             } ?>

                        <tr class="tbl-row">
                            <td class="text-center"><?php echo $counter; ?></td>
                            <td><?php echo $summaryList->ticketid ?></td>
                            <td class=""><?php echo $summaryList->support ?></td>
                            <td class=""><?php echo $summaryList->requestor ?></td>
                            <td class=""><?php echo $summaryList->dateofrequest ?></td>
                            <td class=""><?php echo $summaryList->service ?></td>
                            <td class="text-center"><?php echo $util->formatNumber($summaryList->percentage, 2) ?>%</td>
                            <td>
                                <?php echo $util->getRatings($perVal);?>
                            </td>
                        </tr>
                        <?php 
                        $sumTotalScore = $sumTotalScore + $summaryList->score; 
                        $sumPercentage = $sumPercentage + $summaryList->percentage;
                        $subcounter++;
                        if ($counter == $numRows) {
                            $service = $summaryList->service; ?>
                                <tr class="tbl-subsummary" style="background-color: #277e35;color: white">
                                    <td class="text-right" colspan="6">
                                        Average
                                    </td>
                                    <td class="text-center">
                                        <?php echo $util->formatNumber($sumPercentage/$subcounter, 2); ?>%
                                    </td>
                                    <td>
                                        <?php echo $util->getRatings($util->formatNumber($sumPercentage/$subcounter, 2));?>
                                    </td>
                                </tr>
                        <?php } ?>
                    <?php } ?>
                </table>


                <br>
                <table border="1" width="100%" cellpadding="0" cellspacing="0" style="border: 1px solid #ccc">
                    <tr class="tbl-header" style="background-color: black;color: white">
                        <td class="">Services</td>
                        <td class="text-center" style="width: 90px">Total Ticket</td>
                        <td class="text-center" style="width: 100px">Score</td>
                        <td >Rating</td>
                    </tr>
                    <?php
                    $xcounter = 0;
                    $xsum = 0;
                    foreach ($summaryicf as $list) { 
                        $xcounter++; 
                        $xsum = $xsum + $list->percentage ?>
                        <tr class="tbl-row">
                            <td class=""><?php echo $list->service ?></td>
                            <td class="text-center"><?php echo $list->ticketCount ?> </td>
                            <td class="text-center"><?php echo $util->formatNumber($list->percentage, 2) ?>%</td>
                            <td>
                                <?php echo $util->getRatings($list->percentage);?>
                            </td>
                        </tr>
                    <?php } ?>
                    <?php if ($xcounter == count($summaryicf) && count($summaryicf) > 0) { ?>
                        <tr class="tbl-row">
                            <td class="" colspan="2" style="background-color: black; color: white;text-align: center;font-weight: bodl">TOTAL AVERAGE</td>
                            <td class="text-center"><?php echo $util->formatNumber($xsum/count($summaryicf), 2) ?>%</td>
                            <td>
                                <?php echo $util->getRatings($list->percentage);?>
                            </td>
                        </tr>
                    <?php } ?>
                </table>



    </div>
    
    <!-- /logo Left -->
</page>

