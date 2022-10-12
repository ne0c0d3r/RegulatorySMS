        <div id="page-wrapper" style="min-height: 582px;">
          <div class="row">
            <div class="panel panel-success font8">
              <div class="panel-heading">
                List of Sites
                <span class="glyphicon glyphicon-map-marker pull-right"></span>
              </div>
              <div class="col-md-12 toolbar-control">
                  <div class="input-group width200 pull-right">
                    <span class="input-group-addon font8 padding3" id="basic-addon2"><span class="glyphicon glyphicon-search"></span></span>
                    <input class="form-control toolbar-text font8 width200 txtSearchBar" name="txtSearch" id="txtSearch" placeholder="Search"></input>                    
                  </div>
              </div>
              <div class="panel-body rmv-all-padding">

              </div>
              <div class="table-wrapper">
                <div class="col-md-12 rmv-all-margin rmv-all-padding">
                  <table class="table table-striped table-hover rmv-all-margin">
                    <tr>
                      <th class="width250">Site ID</th>
                      <th>Description</th>
                    </tr>
                    <tbody id="table-site" class="table-body">

                    </tbody>
                  </table>
                </div>
                <div class="text-center paging-wrapper">
                  <ul id="" class="pagination-table pagination-sm rmv-all-margin font8" data-count="<?php echo count($siteData); ?>" data-module="site" data-limit="20"></ul>
                </div>
              </div>
            </div>
          </div>

          <div class="row" style="background-color: red !important">

          </div>
          
        </div>
        <!-- /#page-wrapper -->

