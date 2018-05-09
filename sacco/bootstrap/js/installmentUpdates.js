$('#installationUpdating').on('click', function(event) {

	event.preventDefault();

	//get the data from the matured loans route.
	var id 				= $(this).attr('data-id');

	var installment 	= $(this).attr('data-installment');

	var bankAccountName = $(this).attr('data-bankAccountName');

	//assign the above data to our modal.
	$('#bankAccName').html(bankAccountName);

	$('#installment').val(installment);

	$('#id').val(id);

	$('#modal-installment-update').on('click', function() {

		//validate the input field.
		var installment = $('#installment').val();

		var id      = $('#id').val();

		if (installment == '') {

			$('#failure')
				.html("<div class='alert alert-danger alert-dismissible' role='alert'> Your Installment Field is Empty. <button id='clean' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
		}
		else {

			$.ajax({

				url   :'http://sacco.co.ke/installment/updates/store/'+id,
				method: 'POST',
				data  : { 
					
					installment: installment,
					id         : id,
					_token     : token
				}
			}).done(function(msg) {

				//get the keys.
				var response = msg['response'];

				var failure  = msg['failure'];

				var error    = msg['error'];

				//handle the feedback
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

				//Dismiss the modal.
				setTimeout(function() {$('#installmentupdatemodal').modal('hide');}, 30000);

				window.location.reload(true);
			});
		}
	});
});


$(document).ready(function() {

	console.log('Installment Updates Operational.');
});