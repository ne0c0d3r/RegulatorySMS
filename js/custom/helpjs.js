$(document).ready(function () {

	$('body').on('click', '.remove-help', function(){
		if (isConfirmCustom('Delete this help?')) {
			return true;
		} 
		return false;
	});

	$('body').on('click', '.download-help', function(){
		var helpid = $(this).data('helpid');
		alert(helpid)
		$.get(base_url + "logs/create_logs/Downloaded the attachment of helpid " + helpid, function(data){

		});
	});
});