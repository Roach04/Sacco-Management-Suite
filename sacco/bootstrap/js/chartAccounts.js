$('.chartbody').find('#chartAccounts').on('click', function(event) {

	event.preventDefault();

	//get the id from our route.
	var id = $(this).attr('data-id');

	//assign the id
	$('#id').val(id);

	$('#modal-chart-accounts').on('click', function() {

		//validation.
		var id             = $('#id').val();
		var subAccountName = $('#subAccountName').val();
		var category       = $('#category').val();
		var description    = $('#description').val();
		var money          = $('#money').val();
		var bankAccNumber  = $('#bankAccNumber').val();

		if (subAccountName == '' && category == '' && description == '' && money == '' && bankAccNumber == '') {

			$("#failure")
			.html("<div class='alert alert-danger alert-dismissible' role='alert'> Your Fields Are Empty. <button id='clean' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
		}
		else if (subAccountName == '') {

			$("#failure")
			.html("<div class='alert alert-danger alert-dismissible' role='alert'> Your Sub Account Name Field is Empty. <button id='clean' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
		}
		else if (category == '') {

			$("#failure")
			.html("<div class='alert alert-danger alert-dismissible' role='alert'> Your Category Field is Empty. <button id='clean' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
		}
		else if (description == '') {

			$("#failure")
			.html("<div class='alert alert-danger alert-dismissible' role='alert'> Your Description Field is Empty. <button id='clean' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
		}
		else if (bankAccNumber == '') {

			$("#failure")
			.html("<div class='alert alert-danger alert-dismissible' role='alert'> Your Bank Account Number Field is Empty. <button id='clean' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
		}
		else if (money == '') {

			$("#failure")
			.html("<div class='alert alert-danger alert-dismissible' role='alert'> Your Total Balance Field is Empty. <button id='clean' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
		}
		else {

			$.ajax({

				url   : "http://sacco.co.ke/sacco/chart/account/sub/store",
				method: 'POST',
				data  : { 
					
					id            : id,
					subAccountName: subAccountName,
					category      : category,
					description   : description,
					money         : money,
					bankAccNumber : bankAccNumber,
					_token        : token
				},
			}).done(function(msg) {

				//get a good response.
				var response = msg['response'];

				//grab an error.
				var error    = msg['error'];

				if (response) {

					$("#chart-success")
						.html("<div class='alert alert-success alert-dismissible' role='alert'>" +response+ "<button id='clean' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
				}
				else if (failure) {

					$("#chart-error")
						.html("<div class='alert alert-danger alert-dismissible' role='alert'>" +failure+ "<button id='clean' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
				}
				else if (error) {

					$("#chart-error")
						.html("<div class='alert alert-danger alert-dismissible' role='alert'>" +error+ "<button id='clean' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
				}

				console.log(response);

				//Dismiss the modal.
				setTimeout(function() {$('#chartAccountsModal').modal('hide');}, 60000);

				window.location.reload(true);
			});
		}		
	});
});


$(document).ready(function () {

	console.log('Chart Of Accounts Operation.');
});