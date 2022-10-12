						 <label><span class="glyphicon glyphicon-paperclip"></span> Attachment</label><br>
						 <input type="hidden" name="inputAttachRef" id="inputAttachRef"></input>
                          <?php if (count($reqAttachData) == 0) { ?>
                            <input type="file" class="form-control input-sm" name="attachField[]" id="attachField" class="attachField" multiple="multiple"></input>                          
                          <?php } ?>
                          <?php 
                            
                            foreach ($reqAttachData as $reqAttachList) { 
                              //echo $reqAttachList->servicesid; ?>
                              <span class="text-primary bold-text text-capital"><?php echo $reqAttachList->description ?> <sup>*</sup> </span>
                              <input type="hidden" name="nameInput[]" id="nameInput-<?php echo $reqAttachList->servicesAttachId ?>" value="<?php echo $reqAttachList->description ?>"></input>
                              <input type="file" class="form-control input-sm margin-bottom3" name="attachField[]" id="attachField-<?php echo $reqAttachList->servicesAttachId ?>" class="attachField" required multiple="multiple"></input>


                          <?php } ?>
                          <br>