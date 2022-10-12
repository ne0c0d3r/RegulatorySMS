    <fieldset>
    <label>Attached file</label><br>
    <?php if (count($attachData) == 0) { echo "n/a"; } ?>
    <?php foreach ($attachData as $attachData) { ?>
      <span class='label label-info font8 margin1 inline-flex' id="attachfile-<?php echo $attachData->ticketAttacheId ?>"> 
      	<a href="<?php echo base_url() ?>resources/uploads/<?php echo $attachData->fileHash ?>" target="_black" class="color-white normal-font" >
      		<?php echo $attachData->fileName ?>
      	</a> 
      	&nbsp;&nbsp;<a href="#" data-ticketid="<?php echo $attachData->ticketId ?>" data-aId="<?php echo $attachData->ticketAttacheId ?>" data-fileHash="<?php echo $attachData->fileHash ?>" class="text-danger ticket-remove-attach"> <span class="glyphicon glyphicon-remove"></span></a>
      </span>
    <?php
    } ?>
    </fieldset>