                <?php
                  $counter = 0;
                ?>
                <table class="table table-striped">
                  <thead>
                    <th class="width60 text-center">#</th>
                    <th>Report name</th>
                  </thead>
                  <?php if ($travelRs) { 
                    $counter++; ?>
                    <tr>
                      <td class="text-center">
                        <?php echo $counter ?>
                      </td>
                      <td>
                        <a href="<?php echo base_url() ?>reports/print_form/Travel/<?php echo $refId ?>" target="_blank">Travel Authorization Form (TAF)</a>
                      </td>
                    </tr>                    
                  <?php } ?>

                  <?php if ($tripRs) { 
                    $counter++; ?>
                    <tr>
                      <td class="text-center">
                        <?php echo $counter ?>
                      </td>
                      <td>
                        <a href="<?php echo base_url() ?>reports/print_form/Trip/<?php echo $refId ?>" target="_blank">Trip Ticket Form</a>
                      </td>
                    </tr>
                  <?php } ?>

                  <?php if ($status == 'Close') { 
                    $counter++; ?>
                    <tr>
                      <td class="text-center">
                        <?php echo $counter ?>
                      </td>
                      <td>
                        <a href="<?php echo base_url() ?>icf/feedback_form/<?php echo $refId ?>" target="_blank">Internal Customer Feedback (ICF) </a>
                      </td>
                    </tr>
                  <?php } ?>
                  <?php if ($counter == 0) { ?>
                    <tr>
                      <td class="text-center" colspan="2">
                        No Available report
                      </td>
                    </tr>
                  <?php } ?>
                </table>