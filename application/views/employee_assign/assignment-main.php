        <div id="page-wrapper" style="min-height: 582px;">
          <div class="row">
            <?php 
              $message = $this->session->flashdata('message');
              $alerttype = $this->session->flashdata('alerttype');
            ?>
            

            <div class="col-xs-12 col-md-5 rmv-all-padding">
              <div class="panel panel-info font8">
                <div class="panel-heading">
                  Quick Add
                  <span class="glyphicon glyphicon-plus pull-right"></span>
                </div>
                <div class="panel-body detailPanel">
                  <?php echo form_open('Employee_assign/addAssignedEmployee', array('name' => 'empAsssignEntry', 'id' => 'empAsssignEntry')); ?>
                    <table class="col-xs-12 col-md-12" border="0">
                      <tr>
                        <td>
                          <label>Employee</label>
                          <select class="form-control input-sm" name="sEmployee" id="sEmployee" required>
                            <option value=""></option>
                            <?php foreach ($empData as $empList) { ?>
                              <option value="<?php echo $empList['employeeId'] ?>"><?php echo $empList['lastName'] . ', ' . $empList['firstName'] . ' ' . $empList['middleName'] ?></option>
                            <?php } ?>
                          </select>
                          <br>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <label>Assignment</label>
                          <select class="form-control input-sm col-md-12" name="sAssign" id="sAssign" required>
                            <option value="Counsel">Counsel</option>
                            <option value="Dispatcher">Dispatcher</option>
                            <?php if($_SESSION['sms_userlvl'] == 'Administrator'){ ?>
                              <option value="Administrator">Administrator</option>
                              <option value="CorPlan">Corporate Planning</option>
                            <?php } ?>
                          </select>
                          <hr width="100%">
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <label>Base Site</label>
                          <select class="form-control input-sm col-md-12" name="sBaseSite" id="sBaseSite" required>
                            <option value=""></option>
                            <?php foreach ($siteData as $siteList) { ?>
                              <option value="<?php echo $siteList['companyShortName'] ?>"><?php echo '(' . $siteList['companyShortName'] . ') ' . $siteList['companyName'] ?></option>
                            <?php }?>
                          </select>
                          <hr width="100%">
                        </td>
                      </tr>
                      <tr>
                        <td>
                        <label>
                          <input type="checkbox" name="sinactive" id="sinactive" value="true" />    
                              Inactive
                          </label>
                          <hr width="100%">
                        </td>
                      </tr>
                      <tr>
                        <td>

                          <label>Default Services</label> <br>
                          <?php foreach ($defServicesData as $defServicesList) { ?>
                            <?php if ($defServicesList['active'] == 1) { ?>
                              <label class="col-md-6 col-xs-12">
                                <input type="checkbox" name="sDefaultService[]" class="sDefaultService" id="sDefaultService-<?php echo $defServicesList['servicesid'] ?>" value="<?php echo $defServicesList['servicesid'] ?>" />
                                <?php echo $defServicesList['services'] ?>
                              </label>
                            <?php } ?>

                          <?php } ?>
                          <hr width="100%">
                        </td>
                      </tr>
                      <tr>
                        <td>

                          <label>Site</label> <br>
                          <?php foreach ($siteData as $siteList) { ?>
                            <label class="col-md-4 col-xs-6">
                              <input type="checkbox" name="sSite[]" class="sSite" id="sSite-<?php echo str_replace(' ', '-', $siteList['companyShortName'])  ?>" data- value="<?php echo $siteList['companyShortName'] ?>" />
                              <?php echo $siteList['companyShortName'] ?>
                            </label>
                          <?php } ?>
<!--                           <select class="form-control input-sm" name="sSite[]" id="sSite" multiple="multiple" style="height: 150px !important" required >
                            <?php foreach ($siteData as $siteList) { ?>
                              <option value="<?php echo $siteList['companyShortName'] ?>"><?php echo '(' . $siteList['companyShortName'] . ') ' . $siteList['companyName'] ?></option>
                            <?php } ?>
                          </select> -->
                          <br>
                        </td>
                      </tr>
                    </table>
                  <div class="col-md-12 col-xs-12 rmv-all-padding text-right">
                    <button type="reset" class="btn btn-default btn-xs" id="emp-assign-reset" >Clear</button>&nbsp;&nbsp;
                    <button type="submit" class="btn btn-primary btn-xs submit-empAssign"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Save</button>
                  </div>
                  </form>
                </div>

              </div>
                <div class="alert-wrapper col-md-12 col-xs-12 ">
                  <div class="col-md-offset-5 col-xs-offset-3">
                    <div class="col-md"></div>
                    <div class="alert <?php echo $alerttype ?> text-center <?php echo (isset($message)) ? '' : 'alert-hide' ?> padding5 font8 col-md-4 " style="margin: 0 auto;">
                      <button type="button" class="close font10" data-dismiss="alert">&times;</button>
                      <?php echo $message ?>
                    </div>
                  </div>
                </div>
<!--               <div class="alert <?php echo $alerttype ?> text-center <?php echo (isset($message)) ? '' : 'alert-hide' ?> padding5 font8" ><?php echo $message ?></div> -->
            </div>

            <div class="col-xs-12 col-md-6 col-md-offset-1 rmv-all-padding">
              <div class="panel panel-warning font8">
                <div class="panel-heading">
                  Assigned Employee
                  <span class="glyphicon glyphicon-tags pull-right"></span>
                </div>
                <div class="page-height-viewXX">
                  <table class="table table-default rmv-all-margin" border="0">
                    <tr>
                      <th class="width130">Employee</th>
                      <th class="width80">Assignment</th>
                      <th>Default Site</th>
                      <th class="width50">&nbsp;</th>
                    </tr>
                    <tbody class="detailPanel" id="ticketStatus">
                      <?php
                        //echo json_encode($assignEmpData);
                        foreach ($assignEmpData as $assignEmpList) { 
                        $empData = $util->getEmployeeDetail($assignEmpList->employeeId);
                        ?>
                        <tr id="tr-assign-<?php echo $assignEmpList->assignid ?>">
                          <td class="std-row">
                            <b>
                            <?php echo $empData->lastName . ', ' . $empData->firstName . ' ' . $empData->middleName;
                                  echo ("<br />");
                                  echo ("<label>Status: </label>&nbsp;");
                                  if ($assignEmpList->sinactive == "1") { echo "Inactive"; } else { echo "Active"; }
                            ?> <br>
                            
                            </b>
                          </td>
                          <td class="std-row">
                            <b class="text-info"><?php echo $assignEmpList->assignment ?> </b>
                            <br><br>
                            <span class="text-danger">Default Service</span> <br>
                            <?php   
                                /*echo $assignEmpList->defaultService;*/
                                $service['list'] = json_decode($assignEmpList->defaultService); 
                                $servCnt = count($service['list']);
                                for ($i=0; $i < $servCnt ; $i++) { 
                                  if ($i == 0) { 
                                    //echo $util->getServiceDefintion($service['list'][$i]); ?>
                                    <span class="label label-success font7 inline-flex normal-font"><?php echo $util->getServiceDefintion($service['list'][$i]); ?></span>
                                  <?php } else {
                                    //echo ' / ' . $util->getServiceDefintion($service['list'][$i]); ?>
                                    <span class="label label-success font7 inline-flex normal-font"><?php echo $util->getServiceDefintion($service['list'][$i]); ?></span>
                                  <?php
                                  }
                                }  
                            ?>

                          </td>
                          <td class="std-row width100">
                            <?php
                               $siteid['list'] = json_decode($assignEmpList->siteid, true);
                               $cnt = count($siteid['list']);
                               for ($i=0; $i < $cnt; $i++) { 
                                  if ($i == 0) { 
                                    //echo $siteid['list'][$i]; ?>
                                    <span class="label label-warning font7 inline-flex normal-font"><?php echo $siteid['list'][$i]; ?></span>
                                  <?php } else {
                                    //echo ' / ' . $siteid['list'][$i]; ?>
                                    <span class="label label-warning font7 inline-flex normal-font"><?php echo $siteid['list'][$i]; ?></span>
                                  <?php 
                                  }
                               }
                            ?>
                          </td>
                          <td class="std-row text-right">
                            <a href="#" class="text-warning edit-emp-assigned" data-toggle="tooltip" data-placement="left" title="Edit" data-id="<?php echo $assignEmpList->assignid ?>"><span class="glyphicon glyphicon-edit"></span></a>
                            <a href="<?php echo base_url() ?>Employee_assign/remove_assigned/<?php echo $assignEmpList->assignid ?>" class="text-danger remove-emp-assigned" data-toggle="tooltip" data-placement="left" title="Remove"><span class="glyphicon glyphicon-remove"></span></a>
                          </td>

                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>              
            </div>
            
          </div>

          <div class="row" style="background-color: red !important">

          </div>
          
        </div>
        <!-- /#page-wrapper -->

