                    <?php foreach ($empData as $empList) { ?>
                      <tr id="tr-<?php echo $empList['employeeId'] ?>">
                        <td class="std-row"><?php echo $empList['plantSiteName']; ?></td>
                        <td class="std-row"><?php echo $empList['employeeId']; ?></td>
                        <td class="std-row"><?php echo $empList['lastName'] . ', ' . $empList['firstName'] . ' ' . $empList['middleName']; ?></td>
                        <td class="std-row"><?php echo $empList['gender']; ?></td>
                        <td class="std-row text-center"><?php echo $empList['departmentShortName']; ?></td>
                        <td class="std-row"><?php echo $empList['positionName']; ?></td>
                        <td class="std-row"><?php echo $empList['domainName']; ?></td>
                        <td class="std-row"><?php echo $empList['companyEmail']; ?></td>
                        <td class="std-row"><?php echo $empList['local']; ?></td>
                      </tr>
                    <?php } ?>