$(document).ready(function () {

	$('#newRequestTypeEntry').click(function(){
		$('#requesttypeEntry').attr('action', 'requesttype/add_requesttype');
		$('#txtRequestType').val('');
		$('#inactive').prop("checked", false);
	});

	$('.edit_requesttype').click(function(){
		var id = $(this).data('id');
		$('#requesttypeEntry').attr('action', 'requesttype/update_requesttype/' + id);
		$.getJSON('requesttype/single_retrieve/' + id + '/edit', function(data){
			$('#txtRequestType').val(data.requesttype);
			$('#inactive').prop("checked", false);
			if (data.inactive == '1') {
				$('#inactive').prop("checked", true);
			} 
		});
	});
});