$('.member-account').on('click', function(event) {

	event.preventDefault();

	//get the data.
	var fname   = $(this).attr('data-fname');
	var sname   = $(this).attr('data-sname');
	var lname   = $(this).attr('data-lname');
	var type    = $(this).attr('data-type');
	var phone   = $(this).attr('data-phone');
	var idNo    = $(this).attr('data-idNo');
	var birth   = $(this).attr('data-birth');
	var box     = $(this).attr('data-box');
	var mail    = $(this).attr('data-mail');
	var county  = $(this).attr('data-county');
	var nation  = $(this).attr('data-nation');
	var created = $(this).attr('data-created');
	var updated = $(this).attr('data-updated');

	var id   	= $(this).attr('data-id');

	var fnameKin   = $(this).attr('data-fnameKin');
	var snameKin   = $(this).attr('data-snameKin');
	var lnameKin   = $(this).attr('data-lnameKin');
	var phoneKin   = $(this).attr('data-phoneKin');
	var idNoKin    = $(this).attr('data-idNoKin');
	var birthKin   = $(this).attr('data-birthKin');
	var relateKin  = $(this).attr('data-relateKin');
	var boxKin     = $(this).attr('data-boxKin');
	var mailKin    = $(this).attr('data-mailKin');
	var countyKin  = $(this).attr('data-countyKin');
	var nationKin  = $(this).attr('data-nationKin');

	//pass on the data to the modal.
	$("#firstname").html(fname);
	$("#lastname").html(lname);
	$("#createdAt").html(created);
	$("#updatedAt").html(updated);

	//Assign values to our modal.
	$("#first").val(fname);
	$("#sur").val(sname);
	$("#last").val(lname);
	$("#phone").val(phone);
	$("#idNo").val(idNo);
	$("#birth").val(birth);
	$("#type").val(type);
	$("#box").val(box);
	$("#mail").val(mail);
	$("#county").val(county);	
	$("#nation").val(nation);

	var firstnameKin    = $("#firstKin").val(fnameKin);
	var surnameKin      = $("#surKin").val(snameKin);
	var lastnameKin     = $("#lastKin").val(lnameKin);
	var phoneNumberKin  = $("#phoneKin").val(phoneKin);
	var idNumberKin     = $("#idNoKin").val(idNoKin);
	var dateOfBirthKin  = $("#birthKin").val(birthKin);
	var relationshipKin = $("#relateKin").val(relateKin);
	var poBoxKin        = $("#boxKin").val(boxKin);
	var emailAddressKin = $("#mailKin").val(mailKin);
	var countyKin       = $("#countyKin").val(countyKin);
	var nationalityKin  = $("#nationKin").val(nationKin);

	//get the values from the modal
	var firstname    = $("#first").val();
	var surname      = $("#sur").val();
	var lastname     = $("#last").val();
	var phoneNumber  = $("#phone").val();
	var idNumber     = $("#idNo").val();
	var dateOfBirth  = $("#birth").val();
	var accountType  = $("#type").val();
	var poBox 		 = $("#box").val();
	var emailAddress = $("#mail").val();
	var county       = $("#county").val();	
	var nationality  = $("#nation").val();

	var firstnameKin    = $("#firstKin").val();
	var surnameKin      = $("#surKin").val();
	var lastnameKin     = $("#lastKin").val();
	var phoneNumberKin  = $("#phoneKin").val();
	var idNumberKin     = $("#idNoKin").val();
	var dateOfBirthKin  = $("#birthKin").val();
	var relationshipKin = $("#relateKin").val();
	var poBoxKin        = $("#boxKin").val();
	var emailAddressKin = $("#mailKin").val();
	var countyKin       = $("#countyKin").val();
	var nationalityKin  = $("#nationKin").val();

	//get the value of the id.


	//ajax.
	$("#modal-member").on('click', function() {

		$.ajax({

			method: 'POST',
			url: "http://sacco.co.ke/member/account/update/"+id,
			data: {
				
				id 			 :id,
				firstname    :firstname,
				surname      :surname,
				lastname     :lastname,
				phoneNumber  :phoneNumber,
				idNumber     :idNumber,
				dateOfBirth  :dateOfBirth,
				accountType  :accountType,
				poBox 		 :poBox,
				emailAddress :emailAddress,
				county       :county,
				nationality  :nationality,
				firstnameKin    :firstnameKin,
				surnameKin      :surnameKin,
				lastnameKin     :lastnameKin,
				phoneNumberKin  :phoneNumberKin,
				idNumberKin     :idNumberKin,
				dateOfBirthKin  :dateOfBirthKin,
				relationshipKin :relationshipKin,
				poBoxKin 		:poBoxKin,
				emailAddressKin :emailAddressKin,
				countyKin       :countyKin,
				nationalityKin  :nationalityKin,
				_token			:token,
			},
		}).done(function(msg) {

			//console log the response.
			var feedback = msg['response'];

			//response error.
			var feebackError = msg['responseError'];

			var failed = msg['failure'];

			if(feedback) {

				$("#member-success")
				.html("<div style='text-align:center' class='alert alert-success alert-dismissible' role='alert'>" +feedback+ "<button id='clean' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
			}
			else if(feebackError){

				$("#member-failure")
				.html("<div style='text-align:center' class='alert alert-danger alert-dismissible' role='alert'>" +feebackError+ "<button id='clean' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
			}
			else if(failed){

				$("#member-failure")
				.html("<div style='text-align:center' class='alert alert-danger alert-dismissible' role='alert'>" +failed+ "<button id='clean' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
			}				

			//Dismiss the modal.
			/*setTimeout(function() {$('#memberaccount').modal('hide');}, 30000);

			window.location.reload(true);*/
		});

			console.log("Modal Member working...");
	});

	

	console.log('Member Account Operational.');

	console.log("Next of Kin Details.");
});

$(document).ready(function() {

	console.log("Member Account is Ready.");
});