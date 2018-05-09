$('#reconcile-coop-one').on('click', function(event) {

	event.preventDefault();

	//get the summations of the credit.
	var coopOneMonth = $(this).attr('data-coop');

	//get the value from the select input.
	var selectInput = 3;

	//validate the form.
	var bankEstimate = $('#bankEstimate').val();

	if (bankEstimate == '') {

		$("#failure")
			.html("<div class='alert alert-warning alert-dismissible' role='alert'> Your Field is Empty <button id='clean' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
	}
	else {

		//to reconcile the coop account with the bank, we need to subtract the summations from the bank
		//ie bankEstimate from our coopOneMonth ie one month of our coop account in the system.
		var reconcile = coopOneMonth - bankEstimate;
	

		//assign the above data to the view.
		/*$('#sumcredit').html(sumcredit);

		$('#sumdebit').html(sumdebit);*/

		$('#estimate').val(bankEstimate);

		/*$('#amount').html(amount.toLocaleString());*/

		$('#reconcile').html(reconcile.toLocaleString());
	}
});



$(document).ready(function() {

	console.log('Coop One Month Reconciliation Operational.');
});