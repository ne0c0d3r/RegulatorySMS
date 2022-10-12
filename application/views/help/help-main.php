        <div class="modal fade help-data-entry" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header std-bg-color">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title"><span class="glyphicon glyphicon-plus"></span> Help</h5>
              </div>
              <?php echo form_open_multipart('help/addNewHelp', array('name' => 'helpEntry', 'id' => 'helpEntry')); ?>
                <div class="modal-body font8">
                  <label>Help Description</label>
                  <input type="text" class="form-control input-sm  " name="txtDesc" id="txtStatus" placeholder="Help Description" autocomplete="off" required></input>
                  <br>

                  <label>Attachment </label>
                  <input type="file" class="form-control input-sm" name="attachField" id="attachField" required></input>
                  <br>
                  <div id="attachmentList">
                    
                  </div>

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default btn-xs" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>
                  <button type="submit" class="btn btn-primary btn-xs submit-btn"><span class="glyphicon glyphicon-ok"></span> Save</button>
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

            <div class="panel panel-success font8">
              <div class="panel-heading">
                Help
                <span class="glyphicon glyphicon-question-sign pull-right"></span>
              </div>
              <div class="panel-body rmv-all-padding">
                <div class="col-md-12 col-xs-12 toolbar-control rmv-all-padding">
                  <div class="col-md-8 col-xs-12 rmv-all-padding">
                    <button class="btn btn-default btn-xs toolbar-btn" data-toggle="modal" data-target=".help-data-entry" id="newHelpEntry"><span class="glyphicon glyphicon-file"></span> Create</button>
                  </div>
                  <div class="col-sm-2 col-xs-12 rmv-all-padding to-show">
                    &nbsp;
                  </div>
                  <div class="col-md-4 col-xs-12 rmv-all-padding">
                    <?php
                      $useridFind = '';
                      if (isset($_GET['userid'])) {
                        $useridFind = $_GET['userid'];
                      } 
                    ?>
                    <div class="input-group ">
                      <span class="input-group-addon font8 padding3"><span class="glyphicon glyphicon-search"></span></span>
                      <input class="form-control toolbar-text font8  txtSearchBar" name="txtSearch" id="txtSearch" placeholder="Search logid, user, firstname, lastname, middlename" value="<?php echo $useridFind ?>"></input>
                    </div>
                  </div>
                </div>
              </div>
              <div class="table-wrapper">
                <div class="col-md-12 rmv-all-margin rmv-all-padding std-height border-bottom margin-bottom3">
                  <table class="table table-striped table-hover rmv-all-margin " id="table-employee" border="0">
                    <tr>
                      <th>Title</th>
                      <th>File Name</th>
                      <th>Date updated</th>
                      <th></th>
                    </tr>
                    <tbody id="table-assigment" class="table-body">
                      <?php //echo $logsData->cnt ?>
                    </tbody>
                  </table>
                </div>
                <div class="text-center paging-wrapper">
                  <ul id="" class="pagination-table pagination-sm rmv-all-margin font8" data-count="<?php echo $helpData->cnt ?>" data-module="help" data-limit="20"></ul>
                </div>

              </div>
            </div>
          </div>

          
        </div>
        <!-- /#page-wrapper -->

