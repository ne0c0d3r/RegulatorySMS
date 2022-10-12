                    <?php foreach ($departmentData as $deptList) { ?>
                      <tr id="tr-<?php echo $deptList->departmentCode ?>">
                        <td class="std-row"><?php echo $deptList->departmentShortName; ?></td>
                        <td class="std-row"><?php echo $deptList->departmentName; ?></td>
                      </tr>
                    <?php } ?>