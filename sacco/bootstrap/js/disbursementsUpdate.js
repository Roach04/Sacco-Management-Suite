$('#update-disbursements').on('click', function(event) {

	event.preventDefault();

	//get the data from the edit route.
	var id            = $(this).attr('data-id');
	var disburseMoney = $(this).attr('data-disburseMoney');
	var chequeNumber  = $(this).attr('data-chequeNumber');
	var bank          = $(this).attr('data-bank');
	var loanDuration  = $(this).attr('data-loanDuration');

	//assign the above info to our modal.
	$('#id').val(id);
	$('#disburseMoney').val(disburseMoney);
	$('#chequeNo').val(chequeNumber);
	$('#bank').html(bank);
	$('#duration').val(loanDuration);
	
	$('#modal-disbursements-update').on('click', function() {

		//get the data from our modal.
		var idmodal = $('#id').val();
		var disburseMoneymodal = $('#disburseMoney').val();
		var chequeNumbermodal  = $('#chequeNo').val();
		var loanDurationmodal  = $('#duration').val();

		$.ajax({

			url   : 'http://sacco.co.ke/loan/disbursement/' +id+ '/update',
			method: 'POST',
			data  : {

				id           : idmodal,
				disburseMoney: disburseMoneymodal,
				chequeNumber : chequeNumbermodal,
				loanDuration : loanDurationmodal,
				_token       : token
			},
		})
		.done(function(msg) {

			var response = msg['response'];

			var error    = msg['error'];

			var failed   = msg['failure'];

			console.log(response);

			if (response) {

				$("#disburse-success")
					.html("<div class='alert alert-success alert-dismissible' style='text-align:center' role='alert'>" +response+ "<button id='clean' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
			}
			else if (error) {

				$("#failure")
					.html("<div class='alert alert-warning alert-dismissible' style='text-align:center' role='alert'>" +error+ "<button id='clean' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
			}
			else if(failure) {

				$("#disburse-failure")
					.html("<div class='alert alert-danger alert-dismissible' style='text-align:center' role='alert'>" +failure+ "<button id='clean' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
			}

			//Dismiss the modal.
			setTimeout(function() {$('#disbursementsupdatemodal').modal('hide');}, 500000);

			window.location.reload(true);
		});
	});

});

$(document).ready(function() {

	console.log('Disbursements Updates Ready.');
});