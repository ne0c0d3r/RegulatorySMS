                    <?php foreach ($siteData as $siteList) { ?>
                      <tr id="tr-<?php echo $siteList->companyCode ?>">
                        <td class="std-row"><?php echo $siteList->companyShortName; ?></td>
                        <td class="std-row"><?php echo $siteList->companyName; ?></td>
                      </tr>
                    <?php } ?>