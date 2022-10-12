              <div class="panel-body" style="padding: 5px 2px">
                
                  <div class="col-md-12 rmv-all-padding">
                      <?php echo form_open('services/add_req_attach/' . $servicesid, array('name' => 'reqAttachDesc')); ?>
                      <div class="input-group">
                        <input type="text" class="form-control input-sm" name="txtAttachDesc" placeholder="Attachment description" autocomplete="off"></input>
                        <span class="input-group-btn">
                          <button type="submit" class="btn btn-info btn-sm" type="button"><span class="fa fa-plus"></span> Add</button>
                        </span>
                      </div>
                      <?php echo form_close() ?>
                  </div>                  
                <br>
                <br>
              </div>
              <div class="table-wrapper">
                <div class="col-md-12 rmv-all-margin rmv-all-padding">

                  <table class="table table-striped table-hover rmv-all-margin sub-table" border="0">
                    <tbody>
                    <?php 
                      if (count($reqAttachData) > 0) {
                        foreach ($reqAttachData as $reqAttachList) { ?>
                        <tr id="tr-req-attach-<?php echo $reqAttachList->servicesAttachId ?>" >
                          <td class="std-row">
                            <?php echo $reqAttachList->description; ?>
                            <a href="services/remove_req_attach/<?php echo $reqAttachList->servicesAttachId ?>" class="pull-right text-danger remove-row"><span class="glyphicon glyphicon-remove"></span></a>
                          </td>
                        </tr>
                      <?php } ?>
                    <?php } else { ?>
                      <tr>
                        <td class="std-row text-center"> - - - No record - - - </td>
                      </tr>
                    <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>