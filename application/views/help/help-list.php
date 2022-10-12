                      <?php 
                        if (count($helpData) > 0) {
                          foreach ($helpData as $helpList) { ?>
                          <tr id="logs-tr-<?php echo $helpList->lsmshelpid ?>">
                            <td class="std-row"><?php echo $helpList->description ?></td>
                            <td class="std-row"><?php echo $helpList->fileName ?></td>
                            <td class="std-row width150" ><?php echo date_format(new DateTime($helpList->dateadded), 'm/d/Y h:i A') ?></td>
                            <td class="std-row width50 text-center">
                              <?php if($_SESSION['sms_userlvl'] == 'Administrator'){ ?>
                              <a href="<?php echo base_url() ?>resources/helpfiles/<?php echo $helpList->fileHashName ?>" data-helpid="<?php echo $helpList->lsmshelpid ?>" class="download-help" download> <span class="glyphicon glyphicon-download-alt"></span> </a>
                              <a href="<?php echo base_url() ?>help/remove_help/<?php echo $helpList->lsmshelpid ?>" class="text-danger remove-help"> <span class="glyphicon glyphicon-remove"></span> </a>
                              <?php } ?>
                            </td>
                          </tr>
                      <?php } 
                        } else { ?>
                          <tr>
                            <td colspan="7" class="text-center">No record</td>
                          </tr>
                      <?php } ?>