$('#calculate-loan').on('click', function(event) {

	event.preventDefault();

	//grab data from our view.
	var loan = $('#loan').val();

	var rate = $('#rate').val();

	var duration = $('#duration').val();

	//validation.
	if(loan == '' && rate == '' && duration == '') {

		$('#failure')
		.html("<div class='alert alert-danger alert-dismissible' role='alert'> Your Field(s) are Empty. <button id='clean' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
	}
	else if (loan == '') {

		$('#failureLoan')
		.html("<div class='alert alert-danger alert-dismissible' role='alert'> Your Principal Loan Field is Empty. <button id='clean' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
	}
	else if (rate == '') {

		$('#failureRate')
		.html("<div class='alert alert-danger alert-dismissible' role='alert'> Your Interest Rate Field is Empty. <button id='clean' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
	}
	else if (duration == '') {

		$('#failureDuration')
		.html("<div class='alert alert-danger alert-dismissible' role='alert'> Your Loan Duration Field is Empty. <button id='clean' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
	}
	else {

		//calculate the interest.
		var totalInterest = loan * rate;

		//calculate the amount
		var totalAmount   = (+totalInterest) + (+loan);

		//loan Duration
		var totalDuration = duration;

		//assign the data to our views.
		$('#loanCalc').html(loan.toLocaleString());

		$('#amountCalc').html(totalAmount.toLocaleString());

		$('#interestCalc').html(totalInterest.toLocaleString());

		$('#durationCalc').html(totalDuration + ' Months');

		//assign results to the table.
		$('#tbduration').html(duration);

		$('#tbinterest').html(totalInterest);

		$('#tbloan').html(loan);

		$('#tbTotalAmount').html((+totalInterest) + (+loan));

		$('#tbTotalPayment').html(loan);
	}
});


$(document).ready(function() {

	console.log('Loan Calculator Operational.');
});