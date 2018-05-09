$('.edit-moneys').on('click', function(event) {

	event.preventDefault();

	//get the data from our members route => editmodal space and assign variables to the same.
	var fname   = $(this).attr('data-fname');

	var lname   = $(this).attr('data-lname');

	var id   	= $(this).attr('data-id');

	var member  = $(this).attr('data-member');

	console.log(fname);

	console.log(lname);


	$("#fname").html(fname);

	$("#lname").html(lname);


	//submit the changes to laravel.
	$("#modal-money").on('click', function() {

		//get the values of our inputs.
		var mony = $("#money").val();
		var bank = $("#bank").val();

		console.log(bank);

		//form validations.
		if(mony == ''){

			$("#failure")
				.html("<div class='alert alert-danger alert-dismissible' role='alert'> Your Deposit Field is Empty. <button id='clean' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
		}
		else{

			console.log(mony);
			console.log(bank);

			$.ajax({
				method:'POST', 
				url: "http://sacco.co.ke/member/account/moneys/"+id,
				data:{
					id:id, 
					money:mony,
					bank :bank,
					_token: token
				}
			})
			.done(function(msg) {

				var response = msg['response'];

				var failed = msg['Fail'];

				if(response) {

					$("#money-success")
					.html("<div class='alert alert-success alert-dismissible' role='alert'>" +response+ "<button id='clean' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
				}
				else if(failed){

					$("#money-failure")
					.html("<div class='alert alert-danger alert-dismissible' role='alert'>" +failed+ "<button id='clean' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
				}

				//Dismiss the modal.
				setTimeout(function() {$('#editmodal').modal('hide');}, 30000);

				window.location.reload(true);
			});
		}
	});
});

$(document).ready(function() {

	console.log('Member Account Credit Operational.');
});