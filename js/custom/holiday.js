$(document).ready(function() {

  $('#newHolidayEntry').click(function(){
		$('#HolidayEntry').attr('action', 'holiday/add_holiday');
    $('#txtDate').val('');
    $('#txtDescription').val('');
    
    $('option', $('#multiple')).each(function(element) {
      $(this).removeAttr('selected').prop('selected', false);
    });
    $("#multiple").multiselect('refresh');

	});

    $('#multiple').multiselect({
      includeSelectAllOption: true,
      buttonWidth: '100%',
      maxHeight: 200
    });

    $('#txtDate').datetimepicker({
      format: 'YYYY-MM-DD'
    });

    $('body').on('click', '.edit_holiday', function(){
      let id = $(this).data('id');
      $('#holidayEntry').attr('action', 'holiday/update_holiday/' + id);
      $.getJSON('holiday/single_retrieve/' + id + '/edit', function(data){
        $('#txtDate').val(data.date);
        $('#txtDescription').val(data.description);
        let str = data.sites.replace(/"/g, '').replace('[', '').replace(']', '');
        let dataarray=str.split(",");
        $("#multiple").val(dataarray);
        $("#multiple").multiselect('refresh');
      });
    });
    
});