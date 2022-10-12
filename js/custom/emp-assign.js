$(document).ready(function () {
	$("#emp-assign-reset").click(function(){
		$('#empAsssignEntry').attr('action', 'Employee_assign/addAssignedEmployee');
	});
	$(".edit-emp-assigned").click(function(){
		var id = $(this).data('id');
		$('#empAsssignEntry').attr('action', base_url + 'Employee_assign/updateAssignedEmployee/' + id);
		$.getJSON(base_url + "employee_assign/single_retrieve/" + id, function(data){

			$('#sEmployee').val(data.employeeId);
			$('#sEmployee').prop('readonly', true);
			$('#sAssign').val(data.assignment);
			$('#sBaseSite').val(data.baseSite);

			$('#sinactive').prop("checked", false);
			if (data.sinactive == '1') {
				$('#sinactive').prop("checked", true);
			} 

			var selectedService = data.defaultService.replace('[', '').replace(']', '').replace(/"/g, '');
			$(".sDefaultService").prop("checked", false);
			$.each(selectedService.split(","), function(i,e){
			    $("#sDefaultService-" + e ).prop("checked", true);
			});

			var selectedSite = data.siteid.replace('[', '').replace(']', '').replace(/"/g, '');
			$(".sSite").prop("checked", false);
			$.each(selectedSite.split(","), function(i,e){
			    $("#sSite-" + e.replace(' ', '-') ).prop("checked", true);
			});

			//$('.sSite').val(data.defaultService);
		});
		return false;
	});

	$('#empAsssignEntry').submit(function(e){
		$('.submit-empAssign').button('loading');
	});


	$('.remove-emp-assigned').click(function(){
		if (isConfirmCustom('Delete this record?')) {
			return true;
		} 
		return false;
	});
});
