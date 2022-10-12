$(document).ready(function () {

	$('.modal').modal({backdrop: 'static', keyboard: false, show: false});

	$('.modal').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget) // Button that triggered the modal
		var recipient = button.data('whatever') // Extract info from data-* attributes
		// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
		// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
		var modal = $(this)
		
		modal.find('.title-text').text(recipient)
		
	})



	//setInterval(function (){ location.reload();	}, 900000); // the whole page will refresh on the 15th minute to avoid memory dump

	setInterval(function (){ location.reload();	}, 1800000); // the whole page will refresh on the 30th minute to avoid memory dump

	$('body').on('mouseover', '[data-toggle="tooltip"]', function(){
		$(this).tooltip();
	});

	$('body').on('click', '.submit-btn', function(){
		var btn = $(this);
		btn.button('loading');
	});

	//$('body').on('click', '.table tr td', function(){
	$(".table").delegate("tr td", "click", function(){
	    var id = $(this).closest("tr").attr('id');
	   	addHighlight(id)
  	});

	//menu

	$('body').on('click', '.remove-row', function(){
		if (isConfirmCustom('Are you sure you want to remove?')) {
			return true;
		} 
		return false;
	});

	$('.removeMenu').click(function(){
		if (isConfirmCustom('Delete this menu?')) {
			return true;
		} 
		return false;
	});

	$('#newMenu').click(function(){
		$('#ModuleName').val('');
		$('#description').val('');
		$('#link').val('');
		$('#logo').val('');
		$('#menuEntry').attr('action', 'menu/addMenu');
	});

	$('.editMenu').click(function(){
		var id = $(this).data('id');
		$('#menuEntry').attr('action', 'menu/update_action/' + id);
		$.getJSON('menu/single_retrieve/' + id + '/edit', function(data){
			$('#ModuleName').val(data.modulename);
			$('#description').val(data.longDescription);
			$('#link').val(data.link);
			$('#logo').val(data.logofilename);
			
		});
	});	
	
	$('.alert').fadeOut(10000);
});

function addHighlight(id) {
	$(".highlight").removeClass('highlight');
	$("#" + id).addClass('highlight');
}


function isConfirmCustom(str){
	var x = confirm(str)
    if(x)
    {
        return true;
    }
    return false;
}


document.write("<script src='"+ base_url + "js/custom/servicejs.js'></script>");
document.write("<script src='"+ base_url + "js/custom/statusjs.js'></script>");
document.write("<script src='"+ base_url + "js/custom/workflowjs.js'></script>");
document.write("<script src='"+ base_url + "js/custom/custom-paging.js'></script>");
document.write("<script src='"+ base_url + "js/custom/progress-script.js'></script>");
document.write("<script src='"+ base_url + "js/custom/ticketjs.js'></script>");
document.write("<script src='"+ base_url + "js/custom/emp-assign.js'></script>");
document.write("<script src='"+ base_url + "js/custom/helpjs.js'></script>");
document.write("<script src='"+ base_url + "js/custom/progress-status.js'></script>");
document.write("<script src='"+ base_url + "js/custom/icf.js'></script>");
document.write("<script src='"+ base_url + "js/custom/requesttype.js'></script>");
document.write("<script src='"+ base_url + "js/custom/holiday.js'></script>");
document.write("<script src='"+ base_url + "js/custom/servicejs.js'></script>");
