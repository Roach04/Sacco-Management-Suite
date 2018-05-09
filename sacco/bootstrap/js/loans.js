$('.client-info').find('.row').find('#create-loans').on('click', function(event) {

	event.preventDefault();

	//get the id from the loans page.
	var id = $(this).attr('data-id');

	//assign the id to the loans modal page.
	$('#id').val(id);

	/*
	** Modal Loans.
	*/
	$('.modal-footer').find('#modal-loans').on('click', function() {

		//get the data from our modal.
		var id 			       = $('#id').val();

		var loan               = $('#loan').val();

		var loanDuration       = $('#loanDuration').val();

		var guaranteeOne       = $('#guaranteeOne').val();

		var guaranteeTwo       = $('#guaranteeTwo').val();

		var guaranteeThree     = $('#guaranteeThree').val();

		var moneyOne           = $('#moneyOne').val();

		var moneyTwo           = $('#moneyTwo').val();

		var moneyThree         = $('#moneyThree').val();

		var modeOfPayment      = $('#modeOfPayment').val();

		var monthlyInstallment = $('#monthlyInstallment').val();		

		var loanEntity         = $('#loanEntity').val();

		var loanType           = $('#loanType').val();

		

		//validation.
		if (loan == '' && loanDuration == '' && guaranteeOne == '' && guaranteeTwo == '' && guaranteeThree == '' && moneyOne == '' && moneyTwo == '' && moneyThree == '' && modeOfPayment == '' && monthlyInstallment == '' && loanEntity == '' && loanType == '') {

			$('#failure')
			.html("<div class='alert alert-danger alert-dismissible' role='alert'> Your Field(s) are Empty. <button id='clean' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
		}
		else if (loan == '') {

			$('#failure')
			.html("<div class='alert alert-danger alert-dismissible' role='alert'> Loan Field is Empty. <button id='clean' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
		}
		else if (loanDuration == '') {

			$('#failure')
			.html("<div class='alert alert-danger alert-dismissible' role='alert'> Loan Duration Field is Empty. <button id='clean' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
		}
		else if (guaranteeOne == '') {

			$('#failure')
			.html("<div class='alert alert-danger alert-dismissible' role='alert'> Guarantee One Field is Empty. <button id='clean' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
		}
		else if (guaranteeTwo == '') {

			$('#failure')
			.html("<div class='alert alert-danger alert-dismissible' role='alert'> Guarantee Two Field is Empty. <button id='clean' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
		}
		else if (guaranteeThree == '') {

			$('#failure')
			.html("<div class='alert alert-danger alert-dismissible' role='alert'> Guarantee Three Field is Empty. <button id='clean' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
		}
		else if (moneyOne == '') {

			$('#failure')
			.html("<div class='alert alert-danger alert-dismissible' role='alert'> Money One Field is Empty. <button id='clean' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
		}
		else if (moneyTwo == '') {

			$('#failure')
			.html("<div class='alert alert-danger alert-dismissible' role='alert'> Money Two Field is Empty. <button id='clean' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
		}
		else if (moneyThree == '') {

			$('#failure')
			.html("<div class='alert alert-danger alert-dismissible' role='alert'> Money Three Field is Empty. <button id='clean' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
		}
		else if (modeOfPayment == '') {

			$('#failure')
			.html("<div class='alert alert-danger alert-dismissible' role='alert'> Mode Of Payment Field is Empty. <button id='clean' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
		}
		else if (monthlyInstallment == '') {

			$('#failure')
			.html("<div class='alert alert-danger alert-dismissible' role='alert'> Monthly Installment Field is Empty. <button id='clean' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
		}
		else if (loanEntity == '') {

			$('#failure')
			.html("<div class='alert alert-danger alert-dismissible' role='alert'> Loan Entity Field is Empty. <button id='clean' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
		}
		else if (loanType == '') {

			$('#failure')
			.html("<div class='alert alert-danger alert-dismissible' role='alert'> Loan Type Field is Empty. <button id='clean' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
		}
		else {

			//pass in the data above to laravel via ajax.
			$.ajax({

				url   : 'http://sacco.co.ke/member/loans/store',
				method: 'POST',
				data  : {
					id                 :id,
					loan               :loan,
					loanDuration       :loanDuration,
					guaranteeOne       :guaranteeOne,
					guaranteeTwo       :guaranteeTwo,
					guaranteeThree     :guaranteeThree,
					moneyOne           :moneyOne,
					moneyTwo           :moneyTwo,
					moneyThree         :moneyThree,
					modeOfPayment	   :modeOfPayment,
					monthlyInstallment :monthlyInstallment,
					loanEntity         :loanEntity,
					loanType           :loanType,
					_token             :token
				}
			})
			.done(function(msg) {

				var response = msg['response'];

				var failure  = msg['failure'];

				var error    = msg['error'];

				console.log(response);

				if (response) {

					$("#loan-success")
						.html("<div class='alert alert-success alert-dismissible' style='text-align:center' role='alert'>" +response+ "<button id='clean' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
				}
				else if(failure) {

					$("#loan-failure")
						.html("<div class='alert alert-danger alert-dismissible' role='alert'>" +failure+ "<button id='clean' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
				}
				else if(error) {

					$("#loan-failure")
						.html("<div class='alert alert-danger alert-dismissible' role='alert'>" +error+ "<button id='clean' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
				}

				//Dismiss the modal.
				setTimeout(function() {$('#loansmodal').modal('hide');}, 500000);

				window.location.reload(true);
			});
		}

		console.log('Modal Loans working...');
	});
});


$(document).ready(function() {

	console.log('Loans Operational.');
});