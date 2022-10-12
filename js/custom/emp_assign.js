$(document).ready(function () {

	$('body').on('mouseover', '[data-toggle="tooltip"]', function(){
		$(this).tooltip();
	});

	$('.submit-btn').click(function(){
		var btn = $(this);
		btn.button('loading');
	});


	

	//$('body').on('click', '.table tr td', function(){
	$(".table").delegate("tr td", "click", function(){
	    var id = $(this).closest("tr").attr('id');
	   	addHighlight(id)
  	});

	//menu
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
