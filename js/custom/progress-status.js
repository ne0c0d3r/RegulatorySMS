/**
* @author Resalat Haque
* @link http://www.w3bees.com
*/


$(document).ready(function() {
	/* variables */
	var status = $('.xastatus');
	var percent = $('.xpercent');
	var bar = $('.xprogressbar');
	var progress = $('.xprogress');
	
	progress.hide();

	/* submit form with ajax request */
	$('#changestatusEntry').ajaxForm({

		/* set data type json */
		dataType:  'json',

		/* reset before submitting */
		beforeSend: function() {
			/*alert(JSON.stringify(progress))*/
			$('#submit-new-stat').button('loading');
			if ($('#attachVal').val() != '') {
				progress.show();
				status.fadeOut();
				bar.width('0%');
				percent.html('0%');
			} 
		},

		/* progress bar call back*/
		uploadProgress: function(event, position, total, percentComplete) {
			/*alert(JSON.stringify(event))
			alert(position)
			alert(total)
			alert(percentComplete)*/
			var pVel = percentComplete + '%';
			bar.width(pVel);
			bar.attr('aria-valuenow', pVel);
			percent.html(pVel);
		},

		/* complete call back */
		complete: function(data) {
			/*alert(JSON.stringify(data))*/
			if (data.responseText == 'false') {
				$('#submit-new-stat').button('reset');
				$('.alert').empty();
				$('.alert').removeClass('alert-hide');
				$('.alert').addClass('alert-danger');
				$('.alert').append('Please fill-up required(with asterisk) fields or exceeded the file limitation.');
				$('#submit-ticket').button('reset');
			} else {
				location.reload();
			}
		}

	});
});