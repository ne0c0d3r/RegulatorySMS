$(document).ready(function () {

	$('#newStatusEntry').click(function(){
		$('#statusEntry').attr('action', 'status/add_status');
		$('#txtStatus').val('');
		$('#allowDelete').prop("checked", false);;
	});

	$('.edit_status').click(function(){
		var id = $(this).data('id');
		$('#statusEntry').attr('action', 'status/update_status/' + id);
		$.getJSON('status/single_retrieve/' + id + '/edit', function(data){
			$('#txtStatus').val(data.status);
			$('#allowDelete').prop("checked", false);
			if (data.allowDelete == 'on') {
				$('#allowDelete').prop("checked", true);
			} 
		});
		//return false;
	});

	$('.remove_status').click(function(){
		if (isConfirmCustom('Delete selected status?')) {
			return true;
		} 
		return false;		
	});
});