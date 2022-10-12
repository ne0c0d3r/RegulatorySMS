$(document).ready(function () {
	//service

	$("#tbl-service").delegate("tr td", "click", function(){
	    var rowid = $(this).closest("tr").attr('id');
	    var servicesid = $(this).closest("tr").data('id');
	    $("#loadEscalation").empty();
    	$('#loadEscalation').addClass('loading-state-box-1');
	    $("#loadEscalation").load(full_url + 'services/getWorkflow/' + servicesid, function(){
	    	$('#loadEscalation').removeClass('loading-state-box-1');
	    });
	    $("#loadRequiredAttach").load(full_url + 'services/getRequiredAttached/' + servicesid, function(){

	    });
	});

	$('#newService').click(function(){
		$('#serviceEntry').attr('action', 'services/add_service');
	});

/*	$('body').on('change', '#txtPosition', function(){
		var position = $(this).val();
		if (position == 'IS') {
			$.get('employee/')
		}
	});*/

	$('.remove_service').click(function(){
		if (isConfirmCustom('Delete this menu?')) {
			return true;
		} 
		return false;		
	});

	$('.edit_service').click(function(){
		var id = $(this).data('id');
		$('#serviceEntry').attr('action', 'services/update_service/' + id);		
		$.getJSON('services/single_retrieve/' + id + '/edit', function(data){
			var a = false;
			var b = false;
			if (data.isQuantityCanview == 1) { a = true; }
			if (data.isTypesOfCopyCanView == 1) { b = true; }
			$('#servicename').val(data.services);
			$('#description').val(data.description);
			$('#category').val(data.mcatid);
			$('#allowSpecifyQty').prop('checked', a);
			$('#viewTypesOfCopy').prop('checked', b);
			$("#active option[value='" + data.active + "']").prop("selected", true);
			console.log(data.active);
		});
		//return false;
	});

	$("#addFieldAttach").click(function(){
		$('addField').append('');
	})

});