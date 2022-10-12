        <div class="modal fade service-data-entry" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header std-bg-color">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title"><span class="glyphicon glyphicon-file"></span> <span class="title-text">Service</span></h5>
              </div>
              <?php echo form_open('services/add_service', array('name' => 'serviceEntry', 'id' => 'serviceEntry')); ?>
                <div class="modal-body font8">
                  <label>Service</label>
                  <input type="text" class="form-control input-sm  " name="txtServicename" id="servicename" placeholder="Service name" autocomplete="off"></input>
                  <br />

                  <label>Description</label>
                  <textarea  class="form-control input-sm" name="txtDescription" id="description" placeholder="Description"></textarea>
                  <br />

                  <label>Category</label>
                  <select class="form-control input-sm" name="txtCategory" id="category">
                    <option value="">Not Available</option>
                  </select>
                  <br />

                  <label>Active</label>
                  <select class="form-control input-sm" name="active" id="active">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                  </select>
                  <br />

                  <label>Other Function</label><br>
                  <label><input type="checkbox" name="allowSpecifyQty" id="allowSpecifyQty"></input> Allow end-user to specify quantity</label><br>
                  <label><input type="checkbox" name="viewTypesOfCopy" id="viewTypesOfCopy"></input> Enable option for types of copy</label>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default btn-xs" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>
                  <button type="submit" class="btn btn-primary btn-xs submit-btn" value="Proceed" /><span class="glyphicon glyphicon-ok"></span> Save</button>
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
          <div class="row">

            <div class="alert-wrapper col-md-12 col-xs-12 ">
              <div class="col-md-offset-5 col-xs-offset-3">
                <div class="col-md"></div>
                <div class="alert <?php echo $alerttype ?> text-center <?php echo (isset($message)) ? '' : 'alert-hide' ?> padding5 font8 col-md-4 " style="margin: 0 auto;">
                  <button type="button" class="close font10" data-dismiss="alert">&times;</button>
                  <?php echo $message ?>
                </div>
              </div>
            </div>          
            <div class="panel panel-success font8 col-md-7 rmv-all-padding">
              <div class="panel-heading">
                List of Services
                <span class="glyphicon glyphicon-tasks pull-right"></span>
              </div>
              <div class="panel-body rmv-all-padding">
                <div class="col-md-12 toolbar-control">
                  <button class="btn btn-default btn-xs toolbar-btn" data-toggle="modal" data-target=".service-data-entry" id="newService" data-whatever="Create New Service"><span class="glyphicon glyphicon-file"></span> Create</button>
                  <a href="<?php echo base_url() ?>services" class="btn btn-default btn-xs toolbar-btn"><span class="glyphicon glyphicon-refresh"></span> Refresh</a>
                  <!-- <button class="btn btn-default btn-xs toolbar-btn pull-right"><span class="glyphicon glyphicon-search"></span></button> -->
                </div>
              </div>
              <div class="table-wrapper">
                <div class="col-md-12 rmv-all-margin rmv-all-padding">
                  <table class="table table-striped table-hover rmv-all-margin" id="tbl-service">
                    <tr class="tr-row">
                      <th class="width250">Services</th>
                      <th>Description</th>
                      <th class=" text-center">Specify Quantity</th>
                      <th class=" text-center">View Types of copy</th>
                      <th class=" text-center">Active</th>
                      <th class=" text-right">Action</th>
                    </tr>
                    <tbody>
                    <?php foreach ($servData as $servList) { ?>
                      <tr id="tr-services-<?php echo $servList['servicesid'] ?>" data-id="<?php echo $servList['servicesid'] ?>">
                        <td class="std-row"><?php echo $servList['services']; ?></td>
                        <td class="std-row"><?php echo $servList['description']; ?></td>
                        <td class="std-row text-center">
                          <?php if ($servList['isQuantityCanview'] == 1) {
                            echo "Yes";
                          } else { echo "No";} ?>
                        </td>
                        <td class="std-row text-center">
                          <?php if ($servList['isTypesOfCopyCanView'] == 1) {
                            echo "Yes";
                          } else { echo "No";} ?>
                        </td>
                        <td class="std-row text-center">
                          <?php if ($servList['active'] == 1) {
                            echo "Yes";
                          } else { echo "No";} ?>
                        </td>
                        <td class="std-row text-right width100 action-panel">
                          <a href="#" class="edit_service text-warning" alt="Edit" data-toggle="modal" data-target=".service-data-entry" data-id="<?php echo $servList['servicesid'] ?>"  data-whatever="Edit Service"><span class="glyphicon glyphicon-edit"></span></a>
                          <a href="<?php echo base_url() ?>services/remove_service/<?php echo $servList['servicesid'] ?>" alt="Remove" class="remove_service text-danger"><span class="glyphicon glyphicon-remove"></span></a>
                          <!-- <button class="btn btn-warning btn-xs toolbar-btn font8"><span class="glyphicon glyphicon-edit"></span></button>
                          <button class="btn btn-danger btn-xs toolbar-btn font8"><span class="glyphicon glyphicon-remove"></span></button> -->
                        </td>
                      </tr>
                    <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
<!--           </div>

          <div class="row"> -->
            <div class="panel panel-info font8 col-md-4 col-md-offset-1 rmv-all-padding">
              <div class="panel-heading">
                Required Attachment
                <span class="glyphicon glyphicon-paperclip pull-right"></span>
              </div>

              <div id="loadRequiredAttach">
                <div class="panel-body text-center">
                  - - - Select service - - - 
                  
                </div>
              </div>
            </div>

         

          </div>

          <div class="row">
            <div class="panel panel-info font8">
              <div class="panel-heading">
                Service Escalation
                <span class="glyphicon glyphicon-stats pull-right"></span>
              </div>
              <div id="loadEscalation">
                <div class="panel-body text-center">
                  - - - Select service - - - 
                  
                </div>
              </div>

            </div>
          </div>

          <div class="row" style="background-color: red !important">

          </div>
          
        </div>
        <!-- /#page-wrapper -->

