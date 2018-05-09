$('#modal-savings').on('click', function(event) {

	event.preventDefault();

	//get data from our accounts page.
	var accountName = $(this).attr('data-accountName');
	var subAccountName = $(this).attr('data-subAccountName');

	console.log(accountName);

	console.log(subAccountName);

	//get the inputs from our form
	var credit = $('#credit').val();
	var debit  = $('#debit').val();
	var bills  = $('#bills').val();

	//validation.
	if (credit == '' && debit == '') {

		$("#failure")
			.html("<div class='alert alert-danger alert-dismissible' role='alert'> Your Field(s) are Empty. <button id='clean' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
	}
	else if(credit == ''){

		$("#failure")
			.html("<div class='alert alert-danger alert-dismissible' role='alert'> *Credit Field is Empty. <button id='clean' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
	}
	else if (debit == '') {

		$("#failure")
			.html("<div class='alert alert-danger alert-dismissible' role='alert'> *Debit Field is Empty. <button id='clean' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
	}
	else {

		$.ajax({

			url: "http://sacco.co.ke/sacco/savings",
			method: 'POST',
			data: {
				credit: credit,
				debit : debit,
				bills : bills,
				_token: token
			}
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
			setTimeout(function() {$('#savingsmodal').modal('hide');}, 20000);

			window.location.reload(true);
		});
	}
});



$(document).ready(function() {

	console.log('Savings Ready.');
});