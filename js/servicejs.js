$(document).ready(function () {
	//service

	$("#tbl-service").delegate("tr td", "click", function(){
    var rowid = $(this).closest("tr").attr('id');
    var servicesid = $(this).closest("tr").data('id');
    $("#loadEscalation").empty();
    $("#loadEscalation").append('Loading data...');
    $("#loadEscalation").load(base_url + 'services/getWorkflow/' + servicesid, function(){

    });
  });

	$('#newService').click(function(){
		$('#serviceEntry').attr('action', 'services/add_service');
	});

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
			$('#servicename').val(data.services);
			$('#description').val(data.description);
			$('#category').val(data.mcatid);
			
		});
		//return false;
	});

});