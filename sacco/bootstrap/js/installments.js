$('.tbuddy').find('#modal-loan-install').on('click', function(event) {

	event.preventDefault();

	//get the data from out page into the modal.
	var fname   = $(this).attr('data-fname');
	var lname   = $(this).attr('data-lname');
	var id      = $(this).attr('data-id');
	var account = $(this).attr('data-account');

	//get the value of the above data.
	$('#fname').html(fname);
	$('#lname').html(lname);

	console.log(fname);
	console.log(lname);

	console.log('Installments Opeeerational');

	//populate the input fields.
	$('#id').val(id);

	//if you want to get its value,
	var id = $('#id').val();

	/*
	** Ajax.
	*/
	$('#modal-installment-save').on('click', function() {

		//validation.
		var installment = $('#installment').val();
		var bank		= $('#bank').val();

		if (installment == '' && bank == '') {

			$('#failure')
			.html("<div class='alert alert-danger alert-dismissible' role='alert'> Your Field(s) Are Empty. <button id='clean' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
		}
		else if (installment == '') {

			$('#failure')
			.html("<div class='alert alert-danger alert-dismissible' role='alert'> Your Installment Field is Empty. <button id='clean' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
		}
		else if (bank == '') {

			$('#failure')
			.html("<div class='alert alert-danger alert-dismissible' role='alert'> Your Bank Field is Empty. <button id='clean' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
		}
		else {

			$.ajax({

				url: 'http://sacco.co.ke/member/maturity/store',
				method: 'POST',
				data: {
					installment: installment,
					bank 	   : bank,	
					id         : id,
					_token	   : token
				}
			}).done(function(msg) {

				//get the error.
				var error = msg['error'];

				//get the success.
				var response = msg['response'];

				//get the failure.
				var failure  = msg['failure'];

				if (response) {

					$("#installment-success")
						.html("<div class='alert alert-success alert-dismissible' role='alert'>" +response+ "<button id='clean' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
				}
				else if (failure) {

					$("#installment-failure")
						.html("<div class='alert alert-danger alert-dismissible' role='alert'>" +failure+ "<button id='clean' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
				}
				else if (error) {

					$("#installment-failure")
						.html("<div class='alert alert-danger alert-dismissible' role='alert'>" +error+ "<button id='clean' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
				}

				console.log(response);

				//Dismiss the modal.
				setTimeout(function() {$('#installmentsmodal').modal('hide');}, 60000);

				window.location.reload(true);
			});
		}
	});

	

	console.log('Operational...');

	console.log(fname);
	console.log(lname);

	console.log(id);
	console.log(account);
});


$(document).ready(function() {

	console.log('Installments Operational');
});