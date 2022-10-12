$(document).ready(function () {

	$('body').on('click', '.edit-question', function(){
		var questionid = $(this).data('questionid');
		//alert(questionid)
		$.getJSON('icf/single_retrieve/' + questionid, function(data){
			$('#questionEntry').attr('action', 'icf/update_question/' + questionid);
			$('#txtQuestion').val(data.question);
			if (data.isActive == '1') {
				$('#isActive').prop('checked', true);
			} else {
				$('#isActive').prop('checked', false);
			}
			$('#txtservice').val(data.servicesid);
			$('#txtsubservice').val(data.subservice);
		});
	});

	$('body').on('click', '.init_question_form', function(){
		question_init();
	});

	$('body').on('click', '#generateIcf', function(){
		var type = $('#txticftype').val();
		var fromDate = $('#txticffromdate').val();
		var toDate = $('#txticftodate').val();
		window.open(full_url + 'reports/generate_icf_summary/' + type + '/' + fromDate.replace(/\//g , "-") + '/' + toDate.replace(/\//g , "-")); 
	});

	$('body').on('click', '#icf-report-params', function(){
		$('#report-panel').load('reports/icf_report_params', function(){

		});
	});
	$('body').on('click', '#icf-report-params-rev5', function(){
		$('#report-panel').load('reports/icf_report_params_rev5', function(){

		});
	});
	$('body').on('click', '#sla-report-params', function(){
		$('#report-panel').load('reports/sla_report_params', function(){

		});
	});

});

function question_init(){
	$('#questionEntry').attr('action', 'icf/addNewQuestion/');
	$('#txtQuestion').val('');
	$('#isActive').removeAttr('checked');
	$('#txtservice').val(0);
	$('#txtsubservice').val('');
}