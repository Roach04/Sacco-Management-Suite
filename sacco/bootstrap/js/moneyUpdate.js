$('.tea').find('.modal-money-update').on('click', function(event) {

	event.preventDefault();

	//get the data from our page.
	var id       = $(this).attr('data-id');

	var memberId = $(this).attr('data-memberId');

	var credit   = $(this).attr('data-credit');

	//populate the modal with the above data.
	$('#id').val(id);

	$('#memberId').val(memberId);

	$('#credit').val(credit);
});

/**
** Push the data into laravel.
**/
$('#money-update').on('click', function() {

	//pass in the above data into ajax.
	//get the data from our modal.
	var id       = $('#id').val();

	var credit   = $('#credit').val();

	var memberId = $('#memberId').val();

	$.ajax({

		url: 'http://sacco.co.ke/member/account/money/store',
		method: 'POST',
		data  : {
			id      : id,  
			memberId: memberId,
			credit  : credit,
			_token  : token,
		}

	}).done(function(msg) {

		//get the reponse from laravel.
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
	});
});

$(document).ready(function() {

	console.log('Money Updates Operational.');
});