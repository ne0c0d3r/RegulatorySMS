    <div class="modal fade requesttype-data-entry" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header std-bg-color">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title"><span class="glyphicon glyphicon-plus"></span> Request Type</h5>
              </div>
              <?php echo form_open('requesttype/add_requesttype', array('name' => 'requesttypeEntry', 'id' => 'requesttypeEntry')); ?>
                <div class="modal-body font8">
                  <label>Request Type</label>
                  <input type="text" class="form-control input-sm" name="txtRequestType" id="txtRequestType" autocomplete="off" required></input>
                  <br>
                  <label style="margin-bottom: 20px !important">
                    &nbsp;<input type="checkbox" name="inactive" id="inactive"> Inactive?
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
                List of Request Type
                <span class="glyphicon glyphicon-stats pull-right"></span>
              </div>
              <div class="panel-body rmv-all-padding">
                <div class="col-md-12 toolbar-control">
                  <button class="btn btn-default btn-xs toolbar-btn" data-toggle="modal" data-target=".requesttype-data-entry" id="newRequestTypeEntry"><span class="glyphicon glyphicon-plus"></span> Add</button>
                </div>
              </div>
              <div class="table-wrapper">
                <div class="col-md-12 rmv-all-margin rmv-all-padding">
                  <table class="table table-striped table-hover rmv-all-margin">
                    <tr>
                      <th>Code</th>
                      <th>Request Type</th>
                      <th class="text-center">Inactive</th>
                      <th class="text-right">Action</th>
                    </tr>
                    <tbody>
                    <?php
                      if (count($requesttypeData) > 0) {
                        foreach ($requesttypeData as $requesttypeList) { ?>
                        <tr id="tr-<?php echo $requesttypeList['requesttypeid'] ?>">
                          <td class="std-row"><?php echo $requesttypeList['requesttypeid']; ?></td>
                          <td class="std-row"><?php echo $requesttypeList['requesttype']; ?></td>
                          <td class="std-row text-center"><?php echo ($requesttypeList['inactive'] == '1') ? 'Yes' : 'No' ; ?></td>
                          <td class="std-row text-right">
                            <a href="#" class="edit_requesttype text-warning" alt="Edit" data-toggle="modal" data-target=".requesttype-data-entry" data-id="<?php echo $requesttypeList['requesttypeid'] ?>"><span class="glyphicon glyphicon-edit"></span></a>
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

