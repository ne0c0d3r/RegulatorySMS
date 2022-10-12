$(document).ready(function () 
{
	//auto refresh
	$('#ticketStatistics').load(full_url + 'ticket/ticketStatistics', function(){});
	updateForAction();

	$.getJSON(full_url +'ticket/sms_complete_loadCount/', function(data)
	{

		//disable if it has Complete Ticket for review
		console.log(data);
		if (data > 0) {$('#newTicketEntry').prop('disabled', true);} else {$('#newTicketEntry').prop('disabled', false);}
     });


	setInterval(function (){
		updateForAction();
    	var searchStr = $('.txtSearchBar').val();        
        var recordLimit = $('.pagination-table').data('limit');
        var module = $('.pagination-table').data('module');
        $('#ticket-monitor').empty();
        $.getJSON(full_url + 'ticket/getTicketSearchCount/' + decodeURIComponent(searchStr), function(e){
             $('#ticket-monitor').append('<ul id="" class="pagination-table pagination-sm rmv-all-margin font8" data-count="' + e.return + '" data-module="ticket" data-limit="' + recordLimit + '"></ul>');
             $('#ticketStatistics').load(full_url + 'ticket/ticketStatistics', function(){});
            loadPagination();
        });

        $.getJSON(full_url + 'ticket/sms_complete_loadCount/', function(data){
        	//disable if it has Complete Ticket for review
			if (data > 0) {$('#newTicketEntry').prop('disabled', true);}else {$('#newTicketEntry').prop('disabled', false);}
        });
	}, 1800000); //refreshed in 1minute --> Updated by Jason from 1 minute to 30 minutes

	$("#table-ticket").delegate("tr td", "click", function(){
		initializeForm();
	    var id = $(this).closest("tr").attr('id');
	    var ticketid = $(this).closest("tr").data('id');
	    var woseq = $(this).closest("tr").data('woseq');
	    var servicesid = $('#' + id + ' ' + '.servicesid-row').data('servicesid');
	    var status = $('#' + id + ' ' + '.record-status').text();
	    var isAssigned = $(this).closest("tr").data('isassigned');
	    //alert(status)

	    $('#txtticketid').val(ticketid);

	   	addHighlight(id);

	    $(".detailPanel").empty();
	    //$(".detailPanel").append('Loading data...').fadeIn(500);
	    $('#ticketDetail').addClass('loading-state-box');
		$('#ticketStatus').addClass('loading-state-box');

	    $("#ticketDetail").load(full_url + 'ticket/ticketDetail/' + ticketid, function(){	    	
	    	$('#ticketDetail').removeClass('loading-state-box');
	    	$("#changeStatusBody").empty();
	    	$("#changeStatusBody").addClass('loading-state');
	    	$("#changeStatusBody").load(full_url + 'ticket/changeStatForm/' + servicesid + '/' + woseq + '/' + ticketid, function(){
	    		$("#changeStatusBody").removeClass('loading-state');
	    	}).fadeIn();
	    	$('#txtTicketId').val(ticketid);
    	});

	    $("#ticketStatus").load(full_url + 'ticket/ticketStatus/' + ticketid, function(){
			$('#ticketStatus').removeClass('loading-state-box');
    	});

	    $.get('login/user_session/sms_userlvl', function(data){
	    	//alert(data)
	    	if (data == 'Dispatcher' && status == 'New') {
	    		$('#assignTo').removeAttr('disabled');
	    		$('#assignUser').removeAttr('disabled');
	    	} else {
		    	if (isAssigned == true) {
		    		$('#assignTo').removeAttr('disabled');
		    		$('#assignUser').removeAttr('disabled');
		    	} else {
		    		$('#assignTo').attr('disabled', true);
		    		$('#assignUser').attr('disabled', true);
		    	}	    		
	    	}
	    });

  	});

	$('body').on('click', '#newTicketEntry', function(){
		$.getJSON(full_url +'ticket/sms_complete_loadCount/', function(data){
			//disable if it has Complete Ticket for review
			console.log(data);
			if (data > 0) 
			{
				$('#newTicketEntry').prop('disabled', true);
				$('.ticket-data-entry').modal('hide');
			}
			else 
			{
				$('#newTicketEntry').prop('disabled', false);initializeForm();
			}
     	});

		 $.get('login/user_session/sms_userid', function(data){
			$('#sEmployee').val(data);
		 });
	 
		 $.get('login/user_session/sms_userlvl', function(data){

			 if(data == 'User')
			 {
				 $('#sRequestType').attr('disabled', true);
				 $('#sEmployee').attr('disabled', true);
			 }
			 else
			 {
				 $('#sRequestType').removeAttr('disabled');
				 $('#sEmployee').removeAttr('disabled');
			 }
			 
		 });

		// $.get('email/sendMail/8613', function(data){
		// 	console.log(data);
		//  });

	});

	$('body').on('click', '.ticket-change-status', function(){
		initializeForm();
	});

	$('body').on('click', '.ticket-edit', function(){
		$("div.modal-body").loading({
            stoppable:false
        });
		initializeForm();
		//$('#sService').attr('readonly', true);
		//$('#sSite').attr('disabled', true);

		$.get('login/user_session/sms_userlvl', function(data){
			if(data == 'User')
			{
				$('#sRequestType').attr('disabled', true);
				$('#sEmployee').attr('disabled', true);
			}
			else
			{
				$('#sRequestType').attr('disabled', true);
				$('#sEmployee').attr('disabled', true);
			} 
		});
	
		var id = $(this).closest("tr").data('id');
		$("#ticketEntry").attr('action', 'ticket/update_ticket/' + id);
		$.getJSON(base_url + 'ticket/single_retrieve/' + id, function(data){
			
			$('#sService').val(data.servicesid);
			$('#sSite').val(data.siteid);
			$('#sEmployee').val(data.requestor);
			$('#sRequestType').val(data.requesttypeid);
			setSupport(true, data.assignedTo);

			$("#sSupport option").prop("selected", false);
			$("#sSupport option[value='" + data.assignedTo + "']").attr("selected", "selected");
			
			$('#sPriority').val(data.priority);
			$('#tSubject').val(data.subject);
			$('#tMessage').val(data.message);

			$("#txtQty").val(data.qty)

			var a = false, b = false, c = false;

			if (data.originalCopy == 1) { a = true; }
			if (data.certifiedTrue == 1) { b = true; }
			if (data.photoCopy == 1) { c = true; }

			//alert(data.photoCopy)

			$('#originalCopy').prop('checked', a);
			$('#certifiedTrue').prop('checked', b);
			$('#photoCopy').prop('checked', c);

			$('#attachmentList').load('ticket/getTicketAttachment/' + id);
			$("div.modal-body").loading('stop');
		});
	});

	$('body').on('click', '.ticket-cancel', function(){
		if (isConfirmCustom('Cancel this ticket?')) {
			var trid = $(this).closest("tr").attr('id');
			var id = $(this).closest("tr").data('id');
			$.get(base_url + 'ticket/cancel_ticket/' + id, function(){
	            $('.paging-wrapper').empty();
	            $.getJSON(full_url + 'ticket/getTicketSearchCount/', function(e){
	                 $('.paging-wrapper').append('<ul id="" class="pagination-table pagination-sm rmv-all-margin font8" data-count="' + e.return + '" data-module="ticket" data-limit="10"></ul>');
	                loadPagination();
	            });

			});
		}
		return false;
	});

	$('body').on('click', '.ticket-remove-attach', function(){
		if (isConfirmCustom('Delete this menu?')) {
			var attachId = $(this).data('aid');
			var fileHash = $(this).data('filehash');
			var ticketid = $(this).data('ticketid');
			/*alert(attachId)
			alert(fileHash)*/

			$.get(base_url + 'ticket/removeAttachment/' + attachId + '/' + fileHash, function(){
				//$('#attachmentList').load('ticket/getTicketAttachment/' + ticketid);
				//alert('asdf')
				$('#attachfile-' + attachId).remove().fadeOut().delay(1000);
				initializeView();
			});
		} 
		return false;
	});

  	$('body').on('change', '#newStatus', function(){
  		var status = $(this).val();
  		$('#route-wrapper').empty();
  		if (status != '') {
	  		var statusText = $("#newStatus option:selected").text();

	  		var servicesid = $('#txtServiceid').val();
	  		var ticketid = $('#txtTicketId').val();
	  		
	  		$('#route-wrapper').addClass('loading-state');
	  		$('#route-wrapper').load('Workflow/workflowTagPosition/' + servicesid + '/' + status + '/' + ticketid, function(){
	  			$('#route-wrapper').removeClass('loading-state');
	  		});
  		} else {
			$('#route-wrapper').addClass('loading-state');
			alert('empty');
			$('#route-wrapper').removeClass('loading-state');
  		}

  		var statusid = $('#newStatus').val();

  		$.getJSON('ticket/get_required_data_remarks/' + servicesid + '/' + statusid, function(data){
			//var selected = data.selectionStatus.replace('[', '').replace(']', '').replace(/"/g, '');
			//var strlen = leng(selected);
			//console.log(selected);
			//console.log('service id:' + servicesid + 'statusid: ' + statusid);
			//console.log(data.isRemarksRequired);
			//$('#txtServiceid').val(data.servicesid);
			//$('#tRemarks').val($('#newStatus').val());

				if (data.isRemarksRequired == "1")
				{
					$("#tRemarks").prop('required',true);
					$("#tRemarksLabel").html("<span style='color:red'>*Remarks</span>");
				}
				else
				{
					$("#tRemarks").prop('required',false);	
					$("#tRemarksLabel").html("<span style='color:black'>Remarks</span>");
				}
			});
  	});

	$('body').on('change', '#sService', function(){
		setSupport();
		var servicesid = $(this).val();
		//alert(servicesid);

		$('#sSite').focus();
		$(this).focus();
	});

	$('body').on('change', '#sSite', function(){
		setSupport();
		$('#sSupport').focus();
		$(this).focus();
	});

	/*$('#ticketEntry').submit(function(e){
		$('#submit-ticket').button('loading');
	});*/

	$('#changestatusEntry').submit(function(e){
		$('#submit-new-stat').button('loading');
	});

	$('#attachField').change(function(){
		$('#inputAttachRef').val($(this).val());
	});

	$('body').on('change', '.attachInput', function(){
		$('#attachVal').val($(this).val());
	});

	$('body').on('click', '.popup-modal', function(){
		var ticketid = $(this).data('ticketid');

		$.getJSON(full_url + 'icf/validate_icf/' + ticketid, function(data){
			if (data.return == 'rev4') {
				$('#icf-form-load').load(full_url + 'icf/feedback_form/' + ticketid, function(){
					$("#icfEntry").attr('action', 'icf/submit_ratings/' + ticketid);			
				});
			} else if (data.return == 'rev5' || data.return == 'NONE') {
				$('#icf-form-load').load(full_url + 'icf/feedback_form_rev5/' + ticketid, function(){
					$("#icfEntry").attr('action', 'icf/submit_ratings_rev5/' + ticketid);			
				});
			}
		});

		//window.history.pushState("", "feedback form", full_url + 'icf/feedback_form/' + ticketid);
	});

	$('body').on('click', '.popup-modal-dismiss', function (e) {
		e.preventDefault();
		//window.history.pushState("", "feedback form", full_url);
		$('#icf-form-load').empty();
		$.magnificPopup.close();
	});

	$('body').on('click', '.copyTypes', function(){
		var isTrue = $("#originalCopy").prop('checked');
		if ($("#originalCopy").prop('checked') == true || $("#certifiedTrue").prop('checked') == true || $("#photoCopy").prop('checked') == true) {
			$("#attachArea").empty();
		} else {
			var servicesid = $('#sService').val();
			//$("#attachArea").show();
			//attachOption(servicesid);
			setSupport();
		}

	});

	$('body').on('change', '#viewAsUser', function(){
		var val = $(this).val();
		$.getJSON(full_url + 'login/switchUser/' + val, function(data){
			location.reload();
		});
	});

});

function attachOption(servicesid) {
	if ($('#sService').val() != '') {
		$("#attachArea").empty();
		$('#attachArea').addClass('loading-state-box');
		$("#attachArea").load(full_url + 'ticket/getRequiredAttach/' + servicesid, function(){
			$('#attachArea').removeClass('loading-state-box');
		});
	} else {
		$("#attachArea").empty();
		$("#attachArea").append('<label><span class="glyphicon glyphicon-paperclip"></span> Attachment</label><input type="hidden" name="inputAttachRef" id="inputAttachRef"></input><input type="file" class="form-control input-sm" name="attachField[]" id="attachField" class="attachField" multiple="multiple"></input>');
	}
}

function optionEnable(servicesid) {
	if ($('#sService').val() != '') {
		$.getJSON(full_url + 'services/single_retrieve/' + servicesid, function(data){
			if(data.isQuantityCanview == 1){
				$('#txtQty').prop('disabled', false);
			} else {
				$('#txtQty').prop('disabled', true);
			}
			if(data.isTypesOfCopyCanView == 1){
				$('.copyTypes').prop('disabled', false);
			} else {
				$('.copyTypes').prop('disabled', true);
			}
	//			alert(data.isTypesOfCopyCanView)			
		});
	}
}

function setSupport(edit = false, selected = ''){
	$('#sSupport').empty();
	var servicesid = $('#sService').val();
	var siteid = $('#sSite').val();
	if (servicesid != '' && siteid != '') {
		$.get(full_url + 'Employee_assign/getMatchCounsel/' + servicesid + '/' + siteid + '/' + selected, function(data){
			$('#sSupport').append(data);
			if (edit == false) {attachOption(servicesid);}			
			optionEnable(servicesid);
		});
	} else {
		if (edit == false) {attachOption(servicesid);}	
		optionEnable(servicesid);
	}
}

function updateForAction() {
	$.getJSON(full_url + 'ticket/getStats/array', function(e){
		$('#forActionCount').text(e.forAction);
	});
}

function initializeForm(){
	$("#ticketEntry").attr('action', 'ticket/create_ticket');

	$('#sService').val('');
	$('#sService').attr('readonly', false);
	$('#sSite').val('');
	$('#sSite').attr('disabled', false);
	$('#sEmployee').val('');
	$('#sRequestType').val('');
	setSupport();

	$("#sSupport option").prop("selected", false);
	$(".copyTypes").prop('disabled');

	$('#sPriority').val('1');
	$('#tSubject').val('');
	$('#tMessage').val('');
	//alert();
	$('#inputAttachRef').val('');
	$('input[id=attachField]').val('');
	$('#attachmentList').empty();
	$('input[id=attachInput]').val('');
	$('#attachVal').val('');
}

function initializeView(){
	$("#ticketDetail").empty();
	$("#ticketDetail").append("<div class='panel-body text-center'>- - - Select ticket - - -</div>");
	
	$("#ticketStatus").empty();
	$("#ticketStatus").append("<div class='panel-body text-center'>- - - Select ticket - - -</div>");
}


