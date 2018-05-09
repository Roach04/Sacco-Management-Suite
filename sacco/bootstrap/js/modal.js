var id = 0;

var bodyElement = null;

$('.card-body').find('.client-avatar').find('.roles').on('click', function(event) {

	//ensure all html doms are taken care of.
	event.preventDefault();
	
	//get the id via its handler i.e. data-id
    var id    = $(this).attr('data-id');

    //get the username via its handler i.e. data-uname
    var uname = $(this).attr('data-uname');

    //get the job via its handler i.e. data-job
    var job   = $(this).attr('data-job');

    //get the role
    var roles   = $(this).attr('data-role');

    //get the user picture.
    var image = $(this).attr('data-image');

    //populate the form accordingly.
    $("#id").val(id);

    $("#username").val(uname);

    $("#jobTitle").val(job);

    $("#image").val(image);
	
	//display the modal when all fields are populated.
	$("#myModal").modal();


	/**
	** Commit the changes via ajax.
	**/
	$("#modal-save").on('click', function() {

		$.ajax({
			method: 'POST',
			url:url,
			data:{body: $("#roles").val(), id:$("#id").val(), _token:token}
		})
		.done(function(msg){

			var role = $("#roles").val();

			//get the user id.
			var userId = msg['userId'];

			//grab the role thats been changed.
			var chagRole = msg['result'];

			//get the feedback.
			var feedback = msg['feedback'];

			//get the success message from our controller and 
			//package it up nicely.
			$("#whitaker")
			.html("<div class='alert alert-success alert-dismissible' role='alert'>" +feedback+ "<button id='clean' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");

			//Dismiss the modal.
			setTimeout(function() {$('#myModal').modal('hide');}, 4000);

			window.location.reload(true);

		})
	});
});

$("#modal-toggle").on('click', function() {

	alert('working.');
	
	console.log('working well...');
});