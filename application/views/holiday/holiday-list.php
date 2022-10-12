<?php foreach ($holidayData as $holidayList) { ?>
    <tr id="tr-<?php echo $holidayList->holidayid ?>">
        <td class="std-row"><?php echo $holidayList->holidayid; ?></td>
        <td class="std-row"><?php echo $holidayList->date; ?></td>
        <td class="std-row"><?php echo $holidayList->description; ?></td>
        <td class="std-row"><?php echo str_replace(array('[',']', '"'), '', $holidayList->sites); ?></td>
        <td class="std-row text-right">
            <a href="#" class="edit_holiday" 
            alt="Edit" data-toggle="modal" 
            data-target=".holiday-data-entry" 
            data-id="<?php echo  $holidayList->holidayid; ?>">
                <span class="glyphicon glyphicon-edit"></span>
            </a>
        </td>
    </tr>
<?php } ?>