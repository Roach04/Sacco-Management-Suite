$('.journal-modal-update').on('click', function(event) {

	event.preventDefault();

	//get the data.
	var id 			 = $(this).attr('data-id');
	var details      = $(this).attr('data-details');
	var accountName  = $(this).attr('data-accountName');
	var actualFigure = $(this).attr('data-actualFigure');
	var overpay      = $(this).attr('data-overpay');
	var bank         = $(this).attr('data-bank');
	var duration     = $(this).attr('data-duration');

	//assign the above values into our modal.
	$('#id').val(id);
	$('#details').val(details);
	$('#accountName').val(accountName);
	$('#actualFigure').val(actualFigure);
	$('#overpay').val(overpay);
	$('#bank').html(bank);
	$('#duration').val(duration);


	$('#modal-journals-update').on('click', function() {

		//get the data to pass to ajax.
		var idmodal           = $('#id').val();
		var detailsmodal      = $('#details').val();
		var accountNamemodal  = $('#accountName').val();
		var actualFiguremodal = $('#actualFigure').val();
		var overpaymodal      = $('#overpay').val();
		var durationmodal     = $('#duration').val();

		$.ajax({

			url: 'http://sacco.co.ke/sacco/update/journal/'+id,
			method: 'POST',
			data  : {

				id          : idmodal,
				details     : detailsmodal,
				accountName : accountNamemodal,
				actualFigure: actualFiguremodal,
				overpay     : overpaymodal,
				duration    : durationmodal,
				_token      : token
			}
		})
		.done(function(msg) {

			//handle your respsonse
			var response = msg['response'];

			var failure  = msg['failure'];

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
			setTimeout(function() {$('#journalsupdatemodal').modal('hide');}, 500000);

			window.location.reload(true);
		});
	});

});

$(document).ready(function() {

	console.log('Journals Updates Operational.');
});