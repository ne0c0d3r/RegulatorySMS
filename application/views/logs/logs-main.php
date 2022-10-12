        <div id="page-wrapper" style="min-height: 582px;">
          <div class="row">
            <div class="panel panel-success font8">
              <div class="panel-heading">
                Logs
                <span class="glyphicon glyphicon-list-alt pull-right"></span>
              </div>
              <div class="panel-body rmv-all-padding">
                <div class="col-md-12 col-xs-12 toolbar-control rmv-all-padding">

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
                  <div class="col-md-8 col-xs-12 rmv-all-padding">
                  </div>
                </div>
              </div>
              <div class="table-wrapper">
                <div class="col-md-12 rmv-all-margin rmv-all-padding std-height border-bottom margin-bottom3">
                  <table class="table table-striped table-hover rmv-all-margin " id="table-employee" border="0">
                    <tr>
                      <th>Log ID</th>
                      <th>Log Date</th>
                      <th>Username</th>
                      <th>Name</th>
                      <th>Site ID</th>
                      <th>Description</th>

                    </tr>
                    <tbody id="table-assigment" class="table-body">
                      <?php //echo $logsData->cnt ?>
                    </tbody>
                  </table>
                </div>
                <div class="text-center paging-wrapper">
                  <ul id="" class="pagination-table pagination-sm rmv-all-margin font8" data-count="<?php echo $logsData->cnt ?>" data-module="logs" data-limit="20"></ul>
                </div>

              </div>
            </div>
          </div>

          
        </div>
        <!-- /#page-wrapper -->

