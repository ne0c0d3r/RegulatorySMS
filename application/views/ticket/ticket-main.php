        <!-- modal for change status -->
        <div class="modal fade change-status-entry" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
          <div class="modal-dialog ">
            <div class="modal-content">
              <div class="modal-header std-bg-color">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title"><span class="glyphicon glyphicon-stats"></span> <span class="title-text">Change Status</span></h5>
              </div>
              <?php echo form_open_multipart('ticket/escalateStatus/', array('name' => 'changestatusEntry', 'id' => 'changestatusEntry')); ?>
                <div class="modal-body font8">
                  <div id="changeStatusBody" class="loading-state"></div>
                  <br>
                  <label name="tRemarksLabel" id="tRemarksLabel">Remarks</label>
                  <textarea class="form-control input-sm font8" name="tRemarks" id="tRemarks" required></textarea>
                  <br>
                  <label>Attachment <i>(Multi-select)</i></label>
                  <input type="file" class="form-control input-sm attachInput" name="attachField[]" id="attachInput" multiple="multiple"></input>

                  <input type="hidden" name="attachVal" id="attachVal" class="attachVal"></input>
                  <br>
                  <div class="xastatus"></div>
                  <div class="progress xprogress">
                    <div class="progress-bar progress-bar-success progress-bar-striped xprogressbar" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                      <div class="xpercent">0%</div > Complete
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default btn-xs" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>
                  <button type="submit" class="btn btn-primary btn-xs" id="submit-new-stat"><span class="fa fa-share-square-o"></span> Route</button>
                </div>
              </form>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div>

        <!-- modal for new ticket -->
        <div class="modal fade ticket-data-entry" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
          <div class="modal-dialog modal-md">
            <div class="modal-content">
              <div class="modal-header std-bg-color">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title"><span class="glyphicon glyphicon-file"></span> <span class="title-text">Ticket</span> </h5>
              </div>
              <?php echo form_open_multipart('ticket/create_ticket', array('name' => 'ticketEntry', 'id' => 'ticketEntry')); ?>
                <div class="modal-body font8 col-md-12">
                  <div class="alert padding5 text-center alert-hide font9" role="alert"></div>
                  <table class="col-md-5" border="0">
<!--                     <tr>
                      <td>
                        <label>Category</label>
                        <select class="form-control input-sm" name="sCategory" id="sCategory">
                          <option value="">- - - select category - - - </option>
                        </select>
                        <br />
                      </td>
                    </tr> -->
                    <tr>
                      <td>
                        <label>Services *</label>
                        <select class="form-control input-sm" name="sService" id="sService" required autofocus>
                          <option value=""></option>
                          <?php 
                            foreach ($servData as $servList) { ?>
                              <?php if ($servList['active'] == 1) { ?>
                                <option value="<?php echo $servList['servicesid'] ?>"><?php echo $servList['services'] ?></option>
                              <?php } ?>
                           <?php }?>
                        </select>
                        <br />
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <label>Request Type</label>
                        <select class="form-control input-sm" name="sRequestType" id="sRequestType">
                          <option value=""></option>
                          <?php foreach ($requesttypeData as $requesttypeList) { ?>
                              <?php if ($requesttypeList['inactive'] == 0) { ?>
                                <option value="<?php echo $requesttypeList['requesttypeid'] ?>">
                                  <?php echo $requesttypeList['requesttype'] ?>
                                </option>
                              <?php } ?>
                           <?php }?>
                        </select>
                        <br />
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <label>Site *</label>
                        <select class="form-control input-sm" name="sSite" id="sSite" required>
                          <option value=""></option>
                          <?php 
                            foreach ($siteData as $siteList) { ?>
                              <option value="<?php echo $siteList['companyShortName'] ?>"><?php echo '(' . $siteList['companyShortName'] . ') ' . $siteList['companyName'] ?></option>
                           <?php }?>
                        </select>
                        <br />
                      </td>
                    </tr>
                  </table>

                  <table class="col-md-5 col-md-offset-1" border="0">
                  <tr>
                      <td>
                        <label>Employee Name *</label>
                        
                        <select class="form-control input-sm" name="sEmployee" id="sEmployee" required>
                          <option value=""></option>
                          <?php 
                            foreach ($empData as $empList) { ?>
                              <option value="<?php echo $empList->employeeId ?>">
                                <?php echo $empList->lastName . ', ' . $empList->firstName . ' ' . $empList->middleName; ?>
                              </option>
                           <?php }?>
                        </select>
                        <br>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <label>Regulatory Counsel *</label>
                        <select class="form-control input-sm" name="sSupport" id="sSupport" required>
                          <option value=""></option>
<!--                           <?php foreach ($assignData as $assignList) { ?>
                            <option value="<?php echo $assignList->employeeId ?>">
                              <?php 
                                $empdata = $util->getEmployeeDetail($assignList->employeeId);
                                echo $empdata->lastName . ', ' . $empdata->firstName . ' ' . $empdata->middleName;
                              ?>
                            </option>
                          <?php } ?> -->
                        </select>
                        <br>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <label>Priority</label>
                        <select class="form-control input-sm" name="sPriority" id="sPriority">
                          <option value="1">Low</option>
                          <option value="2">Medium</option>
                          <option value="3">High</option>
                        </select>
                        <br>
                      </td>
                    </tr>
                  </table>

                  <table class="col-xs-12 col-md-12" border="0">
                    <tr>
                      <td>
                        <label>Subject *</label>
                        <input type="text" class="form-control input-sm" name="tSubject" id="tSubject" autocomplete="off" required=""></input>
                        <br />
                      </td>
                    </tr>

                    <tr>
                      <td>
                        <div class="col-md-7 rmv-all-padding">
                          <label>Message *</label>
                          <textarea rows="8" class="form-control font8" name="tMessage" id="tMessage" autocomplete="off" required></textarea>
                          <br />
                        </div>
                        <div class="col-md-5">
                          <div class="col-md-12 rmv-all-padding">
                            <div id="quantityEntry" class="">
                              <label>Quantity</label>
                              <input type="number" class="form-control input-sm col-md-2" name="txtQty" id="txtQty" autocomplete="off" disabled required value="1"></input>
                            </div>
                          </div>
                          <div class="col-md-12 rmv-all-padding"><br>
                            <div id="typesOfCopy" class="">
                              <label class="col-md-12 col-xs-12 rmv-all-padding"><input type="checkbox" name="originalCopy" id="originalCopy" class="copyTypes" disabled></input> Original Copy</label>
                              <label class="col-md-12 col-xs-12 rmv-all-padding"><input type="checkbox" name="certifiedTrue" id="certifiedTrue" class="copyTypes" disabled></input> Certified True</label>
                              <label class="col-md-12 col-xs-12 rmv-all-padding"><input type="checkbox" name="photoCopy" id="photoCopy" class="copyTypes" disabled></input> Photocopy</label>
                            </div>
                          </div>                        
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div id="attachArea">
                          <label><span class="glyphicon glyphicon-paperclip"></span> Attachment</label>
                          <input type="hidden" name="inputAttachRef" id="inputAttachRef"></input>
                          <input type="file" class="form-control input-sm" name="attachField[]" id="attachField" class="attachField" multiple="multiple" max="1"></input>                                                   
                        </div>
                        <div id="attachmentList">

                        </div>
                      </td>
                    </tr>
                    
                    <tr>
                      <td>
                        <br>
                            <div class="astatus"></div>
                            <div class="progress">
                              <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                <div class="percent">Uploading 0%</div > Complete
                              </div>
                            </div>
                      </td>
                    </tr>

                  </table>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default btn-xs" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>
                  <button type="submit" class="btn btn-primary btn-xs" id="submit-ticket"><span class="glyphicon glyphicon-ok"></span> Save</button>
                </div>
              </form>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div>

        <?php 
          $message = $this->session->flashdata('message');
          $alerttype = $this->session->flashdata('alerttype');
        ?>

        <div id="page-wrapper" style="min-height: 582px;">
          <div class="row" >
            
            <div class="alert-wrapper col-md-12 col-xs-12 ">
              <div class="col-md-offset-5 col-xs-offset-3">
                <div class="col-md"></div>
                <div class="alert <?php echo $alerttype ?> text-center <?php echo (isset($message)) ? '' : 'alert-hide' ?> padding5 font8 col-md-4 " style="margin: 0 auto;">
                  <button type="button" class="close font10" data-dismiss="alert">&times;</button>
                  <?php echo $message ?>
                </div>
              </div>
            </div>

          <?php 
            $searchticket = '';
            if (isset($_GET['searchticket'])) {
              $searchticket = $_GET['searchticket'];
            }
          ?>

            <div class="panel panel-success font8">
              <div class="panel-heading">
                Tickets
                <span class="glyphicon glyphicon-inbox pull-right"></span>
              </div>
              <div class="panel-body rmv-all-padding">
                <div class="col-md-12 col-xs-12 toolbar-control rmv-all-padding">
                  
                  <div class="col-md-6 col-xs-12 rmv-all-padding">
                    <button class="btn btn-default btn-xs toolbar-btn" data-toggle="modal" data-target=".ticket-data-entry" id="newTicketEntry" data-whatever="New Ticket"><span class="glyphicon glyphicon-file"></span> Create</button>
                    <a href="<?php echo base_url() ?>" class="btn btn-default btn-xs toolbar-btn" ><span class="glyphicon glyphicon-refresh"></span> Refresh</a>
                  </div>
                  <div class="col-sm-12 col-xs-12 rmv-all-padding to-show">
                    &nbsp;
                  </div>
                  <div class="col-md-3 col-xs-12 rmv-all-padding rmv-all-margin">
                    <?php 
                    if ($_SESSION['sms_userlvl'] != 'User') {
                      echo form_open('ticket/assign_ticket/') ?>
                        <div class="input-group ">
                          <input type="hidden" name="txtticketid" id="txtticketid"></input>
                          <select class="form-control toolbar-text  font9" name="assignTo" id="assignTo" required disabled>
                          <option value="">Assign to</option>
                          <?php foreach ($assignData as $assignList) { ?>
                            <option value="<?php echo $assignList->employeeId ?>">
                              <?php 
                                $empdata = $util->getEmployeeDetail($assignList->employeeId);
                                echo $empdata->lastName . ', ' . $empdata->firstName . ' ' . $empdata->middleName;
                              ?>
                            </option>
                          <?php } ?>
                          </select>
                          <span class="input-group-addon font8 rmv-all-padding"  id="basic-addon2">
                            <button class="btn btn-default btn-xs toolbar-btn-group" id="assignUser" disabled><span class="glyphicon glyphicon-play-circle text-primary"></span></button>
                          </span>
                        </div>
                      </form>
                    <?php } ?>
                  </div>
                  <div class="col-md-1 col-xs-12 rmv-all-padding">
                    &nbsp;
                  </div>
                  <div class="col-md-2 col-xs-12 rmv-all-padding">
                    <div class="input-group ">
                      <span class="input-group-addon font8 padding3"><span class="glyphicon glyphicon-search"></span></span>
                      <input class="form-control toolbar-text font8  txtSearchBar" name="txtSearch" id="txtSearch" placeholder="Search" value="<?php echo $searchticket ?>"></input>
                    </div>
                  </div>

                </div>
              </div>

              <div id="icf-form-modal" class="white-popup-block mfp-hide">
                
                <div id="icf-form-load"> <span class="loading-state"></span> </div>
              </div>

              <div class="panel-body rmv-all-padding">
                <div class="col-md-12 rmv-all-margin rmv-all-padding std-height border-bottom margin-bottom3" style="overflow-y: hidden;">
                  <table class="table table-striped table-hover rmv-all-margin" id="table-ticket" border="0" style="table-layout:fixed;">
                    <tr>
                      <th class="width40 text-center">Ticket#</th>
                      <th class="width30">Site</th>
                      <th class="width130">Requestor</th>
                      <th class="width30">Dept</th>
                      <th class="width150">Subject</th>
                      <th class="width40">Assigned</th>
                      <th class="width85">Date Requested</th>
                      <th class="width100">Request Type</th>
                      
                      <th class="width40">Priority</th>
                      <th class="width80">Status</th>
                      <th class="width50">&nbsp;</th>
                    </tr>
                    <tbody id="table-ticket-list" class="table-body">

                    </tbody>
                  </table>

                </div>
                <div class="text-left paging-wrapper" id="ticket-monitor">
                  <ul id="" class="pagination-table pagination-sm rmv-all-margin font8" data-count="<?php echo $ticketCount->cnt; ?>" data-module="ticket" data-limit="10"></ul>
                </div>
              </div>
            </div>
          </div>

          <div class="row" id="row-detail-bottom">
            <div class="col-xs-12 col-md-5 rmv-all-padding">
              <div class="panel panel-info font8">
                <div class="panel-heading">
                  Details
                  <span class="glyphicon glyphicon-list-alt pull-right"></span>
                </div>
                <div class="panel-detail-view">
                  <div id="ticketDetail" class="detailPanel">
                    <div class="panel-body text-center">
                      - - - Select ticket - - - 
                    </div>
                  </div>
                </div>
              </div>              
            </div>

            <div class="col-xs-12 col-md-6 col-md-offset-1 rmv-all-padding">
              <div class="panel panel-danger font8">
                <div class="panel-heading">
                  Status
                  <span class="glyphicon glyphicon-stats pull-right"></span>
                </div>
                <div class="panel-detail-view">
                  <div id="ticketStatus" class="detailPanel">
                    <div class="panel-body text-center">
                      <center>
                      - - - Select ticket - - - 
                      </center>
                    </div>
                  </div>
                </div>
              </div>              
            </div>

          </div>

          
        </div>
        <!-- /#page-wrapper -->


