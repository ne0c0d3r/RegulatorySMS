$(document).ready(function () {
	//service
	$('#newService').click(function(){
		$('#workflowEntry').attr('action', 'workflow/add_workflow');
	});

	$('#changestatusEntry').submit(function(e){
		$('#submit-new-stat').button('loading');
	});

	//$('.remove_workflow').click(function(){
	$('body').on('click', '.remove_workflow', function(){
		if (isConfirmCustom('Delete this menu?')) {
			var woid = $(this).data('woid');
			$.get(full_url + 'workflow/remove_workflow/' + woid, function(){
				$('#tr-escalation-' + woid).remove();
			});
		} 
		return false;		
	});

	$('body').on('click', '#submit-wo', function(){
		$('#workflowEntry').on("submit", function (e) {

			var url = $('#workflowEntry').attr('action');
			var servicesid = $('#txtServiceid').val();
		 	e.preventDefault();
		 	$("#submit-wo").button('loading');
			$("#loadEscalation").loading({
                stoppable:false
            });	
		    $.ajax({
		        url:url,
		        type:'post',
		        data:$('#workflowEntry').serialize(),
		        dataType: "json",
		        success:function(e){
		        	if (e.return) {
			        	$("#loadEscalation").load(full_url + 'services/getWorkflow/' + servicesid);
			        	$("#loadEscalation").loading('stop');
						$('.workflow-data-entry').modal('hide');
						$('.modal-backdrop').remove();
		        	} else {
		        		$("#submit-wo").button('reset');
		        	}
		        }
		    });
		    //return false;
    	});
	});

	$('body').on('click', '.edit_workflow', function(){
	//$('.edit_workflow').click(function(){
		var id = $(this).data('id');
		$('#workflowEntry').attr('action', 'workflow/update_workflow/' + id);
		$.getJSON('workflow/single_retrieve/' + id + '/edit', function(data){
			var selected = data.selectionStatus.replace('[', '').replace(']', '').replace(/"/g, '');

			//var strlen = leng(selected);
		//	console.log(selected);

			$('#txtServiceid').val(data.servicesid);
			$('#txtSequence').val(data.woseq);
			$('#txtSubject').val(data.subject);
			$('#txtPosition').val(data.positionCode);
			$('#selectStatus').val(data.statusref);
			//$('#statusList').val("'" + selected + "'");

			$("#statusList option").prop("selected", false);
			$.each(selected.split(","), function(i,e){
			    $("#statusList option[value='" + e + "']").prop("selected", true);
			});
			
//			console.log(data.isRemarksRequired);
			if (data.isRemarksRequired == 1)
			{$("#isRemarksRequired option[value='1']").prop("selected", true);}
			else
			{$("#isRemarksRequired option[value='0']").prop("selected", true);}

		});
		//return false;
	});

});
