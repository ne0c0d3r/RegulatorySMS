        <div class="modal fade question-data-entry" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header std-bg-color">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title"><span class="glyphicon glyphicon-plus"></span> Question</h5>
              </div>
              <?php echo form_open_multipart('icf/addNewQuestion', array('name' => 'questionEntry', 'id' => 'questionEntry')); ?>
                <div class="modal-body font8">
                  <label>Question</label>
                  <textarea class="form-control input-sm  " name="txtQuestion" id="txtQuestion" placeholder="Question" autocomplete="off" required autofocus></textarea>
                  <br>
                  <label style="margin-bottom: 20px !important">
                    &nbsp;<input type="checkbox" name="isActive" id="isActive" checked="checked"> Is Active?
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
                Questions
                <span class="fa fa-question pull-right"></span>
              </div>
              <div class="panel-body rmv-all-padding">
                <div class="col-md-12 col-xs-12 toolbar-control rmv-all-padding">
                  <div class="col-md-8 col-xs-12 rmv-all-padding">
                    <button class="btn btn-default btn-xs toolbar-btn" data-toggle="modal" data-target=".question-data-entry" id="newQuestionEntry"><span class="glyphicon glyphicon-file"></span> Create</button>
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
                  </div>
                </div>
              </div>
              <div class="table-wrapper">
                <div class="col-md-12 rmv-all-margin rmv-all-padding std-height border-bottom margin-bottom3">
                  <table class="table table-striped table-hover rmv-all-margin " id="table-employee" border="0">
                    <tr>
                      <th>Questions</th>
                      <th class=" text-center">Is Active?</th>
                      <th></th>
                    </tr>
                    <tbody id="table-assigment" class="table-body">
                      <?php 
                        if (count($qData) > 0) {
                          foreach ($qData as $qList) { ?>
                          <tr id="logs-tr-<?php echo $qList->question_id ?>">
                            <td class="std-row"><?php echo $qList->question ?></td>
                            <td class="std-row text-center">
                              <?php if ($qList->active == 1) {
                                echo "Yes";
                              } else { echo "No";} ?>
                            </td>
                            <td class="std-row width50 text-center">
                              <!-- <a href="<?php echo base_url() ?>resources/helpfiles/<?php //echo $qList->fileHashName ?>" data-helpid="<?php //echo $qList->lsmshelpid ?>" class="download-help" download> <span class="glyphicon glyphicon-edit"></span> </a> -->
                              <a href="<?php echo base_url() ?>icf/remove_question/<?php echo $qList->question_id ?>" class="text-danger remove-row"> <span class="glyphicon glyphicon-remove"></span> </a>
                            </td>
                          </tr>
                      <?php } 
                        } else { ?>
                          <tr>
                            <td colspan="7" class="text-center">No record</td>
                          </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>


              </div>
            </div>
          </div>

          
        </div>
        <!-- /#page-wrapper -->

