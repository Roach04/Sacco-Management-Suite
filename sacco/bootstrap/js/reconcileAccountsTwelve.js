$('#reconcile-member-twelve').on('click', function(event) {

	event.preventDefault();

	//validate the form.
	var bankEstimateTwelve = $('#bankEstimateTwelve').val();

	if (bankEstimateTwelve == '') {

		$("#failure")
			.html("<div class='alert alert-warning alert-dismissible' role='alert'> Your Field is Empty <button id='clean' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
	}
	else {

		//get the cash
		var cash = $(this).attr('data-cash');

		//do the reconciliation
		var reconcile = cash - bankEstimateTwelve;
	
		//assign the above data to the view.
		$('#cash').html(cash.toLocaleString());

		$('#reconcile').html(reconcile.toLocaleString());
	}
});


$(document).ready(function() {

	console.log('Reconcile 12 Months Member Accounts Operational.');
});