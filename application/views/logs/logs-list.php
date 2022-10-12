                      <?php 
                        if (count($logsData) > 0) {
                          foreach ($logsData as $logsList) { ?>
                          <tr id="logs-tr-<?php echo $logsList->logid ?>">
                            <td class="std-row"><?php echo $logsList->logid ?></td>
                            <td class="std-row"><?php echo date_format(new DateTime($logsList->ldate), 'm/d/Y h:i D') ?></td>
                            <td class="std-row"><?php echo $logsList->username ?></td>
                            <td class="std-row"><?php echo $logsList->lastName . ', ' . $logsList->firstName . ' ' . $logsList->middleName ?></td>
                            <td class="std-row"><?php echo $logsList->plantSiteName ?></td>
                            <td class="std-row" title="<?php echo $logsList->description ?>"><?php echo substr($logsList->description, 0, 100) ?> <?php echo (strlen($logsList->description) > 100) ? '[...]' : '' ?></td>
                          </tr>                        
                        <?php } 
                        } else { ?>
                          <tr>
                            <td colspan="7" class="text-center">No record</td>
                          </tr>
                      <?php } ?>