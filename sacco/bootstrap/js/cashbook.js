$(document).ready(function() {

	//when debit has a focus out, fill in the credit one field.
	$("#debit").focusout(function(){

        //get the input from debit.
		var debit = $('#debit').val();

		//output the input from debit into credit one.
		$('#creditOne').val(debit);
    });

	//when credit has a focus out, fill in the debit one field.	
	$('#credit').focusout(function() {

		//get the input from credit.
		var credit = $('#credit').val();

		//output the input from credit into debit one.
		$('#debitOne').val(credit);
	});

	console.log('Cashbook Operational.');
});