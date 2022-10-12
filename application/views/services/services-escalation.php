              <div class="modal fade workflow-data-entry" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header std-bg-color">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h5 class="modal-title"><span class="glyphicon glyphicon-plus"></span> <span class="title-text">Escalation</span></h5>
                    </div>
                    <?php echo form_open('workflow/add_workflow', array('name' => 'workflowEntry', 'id' => 'workflowEntry')); ?>
                      <div class="modal-body font8">
                        <label>Service</label>
                        <input type="text" class="form-control input-sm " name="txtServicename" id="servicename" placeholder="Service name" value="<?php echo $serviceData->description ?>" autocomplete="off" readonly></input>
                        <input type="hidden" name="txtServiceid" id="txtServiceid" value="<?php echo $serviceData->servicesid ?>"></input>
                        <br />

                        <label>Sequence</label>
                        <input type="text" class="form-control input-sm text-center width100" name="txtSequence" id="txtSequence" placeholder="" value="<?php echo $seqData ?>" autocomplete="off" ></input>
                        <br />

                        <label>Escalation Title</label>
                        <input type="text" class="form-control input-sm " name="txtSubject" id="txtSubject" placeholder="Title" autocomplete="off" required></input>
                        <br />

                        <label>Position</label>
                        <!-- <input type="text" class="form-control input-sm " name="txtPosition" id="txtPosition" placeholder="POsition" autocomplete="off"></input> -->
                        <select class="form-control input-sm " name="txtPosition" id="txtPosition" required>
                          <option value=""></option>
                          <option value="Requestor">Requestor</option>
                          <option value="Counsel">Counsel</option>
                          <option value="IS">Immediate Supervisor</option>
                          <?php 
                            foreach ($positionData as $positionList) { ?>
                              <option value="<?php echo $positionList->positionName ?>"><?php echo $positionList->positionName ?></option>
                              
                           <?php }?>
                        </select>

                        <br />

                        <label>Status</label>
                        <select class="form-control input-sm" name="selectStatus" id="selectStatus" required>
                          <option value=""> - - - select status - - - </option>
                          <?php foreach ($statusData as $statusList) { ?>
                            <option value="<?php echo $statusList->statusid ?>"><?php echo $statusList->status ?></option>
                          <?php } ?>
                        </select>
                        <br />
         
                        <label>Remarks Field Required? </label>
                        <select class="form-control input-sm" name="isRemarksRequired" id="isRemarksRequired" required>
                          <option value=""> - - - select condition - - - </option>
                              <option value="0">No</option>
                              <option value="1">Yes</option>
                        </select>

                        <label>Status Option Selection (<i>Note: press and hold CTRL + Click status </i>)</label>
                        <select class="form-control span6 input-sm" multiple="multiple" data-placeholder="Choose a Category" tabindex="1" style="height: 150px !important" name="statusList[]" id="statusList" >
                          <?php foreach ($statusData as $statusList) { ?>
                            <option value="<?php echo $statusList->statusid ?>"><?php echo $statusList->status ?></option>
                          <?php } ?>
                       </select>

                
                        <br />


                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-xs btn-dimiss" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>
                        <button type="submit" class="btn btn-primary btn-xs" id="submit-wo" value="Save"><span class="glyphicon glyphicon-ok"></span> Save</button>
                      </div>
                    </form>
                  </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
              </div>

              <div class="panel-body rmv-all-padding">
                <div class="col-md-12 toolbar-control">
                  <button class="btn btn-default btn-xs toolbar-btn" data-toggle="modal" data-target=".workflow-data-entry" id="newWorkflow" data-whatever="New Escalation"><span class="glyphicon glyphicon-plus"></span> Add</button>
                </div>
              </div>
              <div class="table-wrapper">
                <div class="col-md-12 rmv-all-margin rmv-all-padding">

                  <table class="table table-striped table-hover rmv-all-margin sub-table" border="0">
                    <tr class="tr-row">
                      <!-- <th class="width50">Escalation ID</th> -->
                      <th class="text-center width50">Sequence</th>
                      <th class="width250">Status Reference</th>
                      <th class="width150">Position</th>
                      <th class="width250">Option Status</th>
                      <th class="width250">Definition</th>
                      <th class="width250">Remarks Required</th>
                      <th class="text-right width100">Action</th>
                    </tr>
                    <tbody>
                    <?php 
                      if (count($workflowData) > 0) {
                        foreach ($workflowData as $workflowList) { ?>
                        <tr id="tr-escalation-<?php echo $workflowList['woid'] ?>" >

                          <!-- <td class="std-row"><?php echo $workflowList['woid']; ?></td> -->
                          <td class="text-center std-row"><?php echo $workflowList['woseq']; ?></td>
                          <td class="std-row"><?php echo $util->getStatusDefinition($workflowList['statusref']); ?></td>
                          <td class="std-row"><?php echo $workflowList['positionCode'] ?></td>
                          <td class="std-row">
                            <?php 
                              $x['status'] = json_decode($workflowList['selectionStatus'], true);
                              $cnt = count($x['status'])-1;
                              for ($i=0; $i <= $cnt; $i++) { 
                                if ($i == 0) {
                                  echo $util->getStatusDefinition($x['status'][$i]);
                                } else {
                                  echo  ' / ' . $util->getStatusDefinition($x['status'][$i]);
                                }
                              }
                            ?>
                          </td>
                          <td class="std-row"><?php echo $workflowList['subject']; ?></td>
                          <td class="std-row"><?php echo $workflowList['isRemarksRequired'] ?></td>
                          
                          <td class="std-row text-right width50 action-panel">
                            <a href="#" class="edit_workflow text-warning" alt="Edit" data-toggle="modal" data-target=".workflow-data-entry" data-id="<?php echo $workflowList['woid'] ?>"><span class="glyphicon glyphicon-edit"></span></a>
                            <a href="#" alt="Remove" class="remove_workflow text-danger removeMenu" data-woid="<?php echo $workflowList['woid'] ?>"><span class="glyphicon glyphicon-remove"></span></a>
                            <!-- <button class="btn btn-warning btn-xs toolbar-btn font8"><span class="glyphicon glyphicon-edit"></span></button>
                            <button class="btn btn-danger btn-xs toolbar-btn font8"><span class="glyphicon glyphicon-remove"></span></button> -->
                          </td>
                        </tr>
                      <?php } ?>
                    <?php } else { ?>
                      <tr>
                        <td colspan="7" class="std-row text-center"> - - - No record for <?php echo $serviceData->description ?> - - - </td>
                      </tr>
                    <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
