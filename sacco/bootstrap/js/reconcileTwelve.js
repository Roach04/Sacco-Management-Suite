$('#reconcile-sacco-twelve').on('click', function(event) {

	event.preventDefault();

	//get the summations of the credit.
	var sumcredit = $(this).attr('data-sumcredit');

	//get the summations of the debit.
	var sumdebit  = $(this).attr('data-sumdebit');

	//get the value from the select input.
	var selectInput = 12;

	//validate the form.
	var bankEstimate = $('#bankEstimate').val();
	
	if (bankEstimate == '') {

		$("#failure")
			.html("<div class='alert alert-warning alert-dismissible' role='alert'> Your Field is Empty <button id='clean' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
	}
	else {

		
		var amount    = sumcredit - sumdebit;

		var reconcile = amount - bankEstimate;
	

		//assign the above data to the view.
		$('#sumcredit').html(sumcredit);

		$('#sumdebit').html(sumdebit);

		$('#estimate').val(bankEstimate);

		$('#amount').html(amount.toLocaleString());

		$('#reconcile').html(reconcile.toLocaleString());
	}
});



$(document).ready(function() {

	console.log('Twelve Reconciliation Operational.');
});