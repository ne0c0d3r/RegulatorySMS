<div class="modal fade holiday-data-entry" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header std-bg-color">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h5 class="modal-title"> Holiday</h5>
      </div>
      <?php echo form_open('holiday/add_holiday', array('name' => 'holidayEntry', 'id' => 'holidayEntry')); ?>
      <div class="modal-body font8">
        <label>Date</label>
        <input type="text" class="form-control input-sm" name="txtDate" id="txtDate" autocomplete="off" required></input>
        <br>
        <label>Description</label>
        <input type="text" class="form-control input-sm" name="txtDescription" id="txtDescription" autocomplete="off" required></input>
        <br>
        <label>Applicable Site/s</label><br />
        <select id="multiple" name="multiple[]" multiple="multiple" class="form-control">
          <?php
          foreach ($siteData as $siteList) { ?>
            <option value="<?php echo $siteList['companyShortName'] ?>"><?php echo '(' . $siteList['companyShortName'] . ') ' . $siteList['companyName'] ?></option>
          <?php } ?>
        </select>
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
        List of Holiday
        <span class="glyphicon glyphicon-stats pull-right"></span>
      </div>
      <div class="panel-body rmv-all-padding">
        <div class="col-md-12 toolbar-control">
          <button class="btn btn-default btn-xs toolbar-btn" data-toggle="modal" data-target=".holiday-data-entry" id="newHolidayEntry"><span class="glyphicon glyphicon-plus"></span> Add</button>
        </div>
      </div>
      <div class="table-wrapper">
        <div class="col-md-12 rmv-all-margin rmv-all-padding std-height border-bottom  margin-bottom3">
          <table class="table table-striped table-hover rmv-all-margin">
            <tr>
              <th>Code</th>
              <th>Date</th>
              <th>Description</th>
              <th>Sites</th>
              <th class="text-right">Action</th>
            </tr>
            <tbody id="table-department" class="table-body">

            </tbody>
          </table>
        </div>
        <div class="text-center paging-wrapper">
          <ul id="" class="pagination-table pagination-sm rmv-all-margin font8" data-count="<?php echo count($holidayData) ?>" data-module="holiday" data-limit="20"></ul>
        </div>

      </div>
    </div>
  </div>

  <div class="row" style="background-color: red !important">

  </div>

</div>


<!-- /#page-wrapper -->