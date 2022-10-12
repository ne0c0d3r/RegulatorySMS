                    <?php 
                      foreach ($positionData as $positionList) { ?>
                      <tr id="tr-<?php echo $positionList->positionCode ?>">
                        <td class="std-row"><?php echo $positionList->positionCode; ?></td>
                        <td class="std-row"><?php echo $positionList->positionName; ?></td>
                      </tr>
                    <?php } ?>