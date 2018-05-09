$('.check').find('.modal-update-edit').on('click', function(event) {

	event.preventDefault();

	//get the data from our page.
	var id	    = $(this).attr('data-id');
	var credit  = $(this).attr('data-credit');
	var debit   = $(this).attr('data-debit');
	var account = $(this).attr('data-account');

	//populate the data to our modal.
	$('#id').val(id);
	$('#credit').val(credit);
	$('#debit').val(debit);
	$('#account').val(account);

	console.log('Edit Updates working...');

	console.log(id);
	console.log(credit);
	console.log(debit);
	console.log(account);
});

$('#modal-savings-update').on('click', function(event) {

	//get the data in general.
	/*var id = $('#id').val();
	var credit = $('#credit').val();
	var debit  = $('#debit').val();*/

	//use ajax to pass on the data to laravel.
	$.ajax({

		url: 'http://sacco.co.ke/sacco/savings/updates',
		method: 'POST',
		data: {
			id     : $('#id').val(),
			credit : $('#credit').val(),
			debit  : $('#debit').val(),
			account: $('#account').val(),
			_token : token,
		},
	})
	.done(function(msg) {

		//get the response.
		var response = msg['response'];

		//get the failure.
		var failed = msg['failure'];

		if (response) {

			$("#money-success")
				.html("<div class='alert alert-success alert-dismissible' role='alert'>" +response+ "<button id='clean' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
		}
		else{

			$("#money-failure")
				.html("<div class='alert alert-danger alert-dismissible' role='alert'>" +failed+ "<button id='clean' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
		}

		//Dismiss the modal.
		setTimeout(function() {$('#savingsupdatemodal').modal('hide');}, 20000);

		window.location.reload(true);

		/*var auto_refresh = setInterval(

			function() {
				$('$products').load('<?php echo url('admin/products'); ?>').fadeIn('slow');
			}, 100);*/
	});
});

$(document).ready(function() {

	console.log('Savings Update Ready.');
});

