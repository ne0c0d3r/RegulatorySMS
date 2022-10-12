        <div id="page-wrapper" style="min-height: 582px;">
          <div class="row">
            <div class="panel panel-success font8">
              <div class="panel-heading">
                Reports
                <span class="fa fa-file-text pull-right"></span>
              </div>
              <div class="panel-body rmv-all-padding">
                  <table class="table table-default">
                    <tr>
                      <td>
                        <a href="#" id="icf-report-params" data-toggle="modal" data-target=".modal-report" data-whatever="Internal Customer Feedback Report">Internal Customer Feedback Report</a>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <a href="#" id="icf-report-params-rev5" data-toggle="modal" data-target=".modal-report" data-whatever="Internal Customer Feedback Reports Rev. 5">Internal Customer Feedback Report Rev. 5</a>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <a href="#" id="sla-report-params" data-toggle="modal" data-target=".modal-report" data-whatever="SLA Report">Service Level Agreement Report</a>
                      </td>
                    </tr>
                    <?php if ($this->session->userdata('sms_userlvl') != 'CorPlan') { ?>
                      <tr>
                        <td>
                          <a href="#" id="sla-report-params-v2" data-toggle="modal" data-target=".modal-report" data-whatever="SLA Report (New)">Service Level Agreement Report (New)</a>
                        </td>
                      </tr>                      
                    <?php } ?>
                  </table>
              </div>
            </div>
          </div>

          <div class="row" style="background-color: red !important">

          </div>
          
        </div>
        <!-- /#page-wrapper -->

