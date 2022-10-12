        <div class="modal fade status-data-entry" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header std-bg-color">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title"><span class="glyphicon glyphicon-plus"></span> Status</h5>
              </div>
              <?php echo form_open('status/add_status', array('name' => 'statusEntry', 'id' => 'statusEntry')); ?>
                <div class="modal-body font8">
                  <label>New Status</label>
                  <input type="text" class="form-control input-sm  " name="txtStatus" id="txtStatus" placeholder="Status" autocomplete="off" required></input>
                  <br>
                  <label style="margin-bottom: 20px !important">
                    &nbsp;<input type="checkbox" name="allowDelete" id="allowDelete"> Allow Delete?
                  </label>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default btn-xs" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>
                  <button type="submit" class="btn btn-primary btn-xs submit-btn"><span class="glyphicon glyphicon-ok"></span> Save</button>
                </div>
              </form>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div>


        <div id="page-wrapper" style="min-height: 582px;">
          <div class="row">
            <div class="panel panel-success font8">
              <div class="panel-heading">
                List of Status
                <span class="glyphicon glyphicon-stats pull-right"></span>
              </div>
              <div class="panel-body rmv-all-padding">
                <div class="col-md-12 toolbar-control">
                  <button class="btn btn-default btn-xs toolbar-btn" data-toggle="modal" data-target=".status-data-entry" id="newStatusEntry"><span class="glyphicon glyphicon-plus"></span> Add</button>
                </div>
              </div>
              <div class="table-wrapper">
                <div class="col-md-12 rmv-all-margin rmv-all-padding">
                  <table class="table table-striped table-hover rmv-all-margin">
                    <tr>
                      <th>Code</th>
                      <th>Status</th>
                      <th class="text-center">Allow Delete?</th>
                      <th class="text-right">Action</th>
                    </tr>
                    <tbody>
                    <?php
                      if (count($statusData) > 0) {
                        foreach ($statusData as $statusList) { ?>
                        <tr id="tr-<?php echo $statusList->statusid ?>">
                          <td class="std-row"><?php echo $statusList->statusid; ?></td>
                          <td class="std-row"><?php echo $statusList->status; ?></td>
                          <td class="std-row text-center"><?php echo ($statusList->allowDelete == 'on') ? 'Yes' : 'No' ; ?></td>
                          <td class="std-row text-right">
                            <a href="#" class="edit_status text-warning" alt="Edit" data-toggle="modal" data-target=".status-data-entry" data-id="<?php echo $statusList->statusid ?>"><span class="glyphicon glyphicon-edit"></span></a>
                            <?php if ($statusList->allowDelete == 'on') { ?>
                              <a href="<?php echo base_url() ?>status/remove_status/<?php echo $statusList->statusid ?>" alt="Remove" class="remove_status text-danger"><span class="glyphicon glyphicon-remove"></span></a>
                            <?php } ?>
                          </td>
                        </tr>
                        <?php 
                        }
                    } else { ?>
                      <tr>
                        <td class="text-center"> - - - No records - - - </td>
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

