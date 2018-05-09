Dropzone.options.addImages = {

	acceptedFiles:'image/*',
	success: function(file, response){

		//check the file status and respond appropriately.
		if(file.status == 'success'){

			handleDropzoneFileUpload.handleSuccess(response);
		}	
		else{

			handleDropzoneFileUpload.handleError(response);
		}
	}
};

//handle the action after file upload.
var handleDropzoneFileUpload = {

	handleError: function(response) {

		//log the response.
		console.log(response);
	},

	handleSuccess: function(response) {

		//log the response.
		//console.log(response);

		//window.location.replace("http://sacco.dev/system/accounts");

		//get the success message from our controller and 
		//package it up nicely.
		$("#success")
		.append('<p style="20px book antiqua; width:100%; margin-top:-20px; padding:30px; text-align:center" class="alert alert-success alert-dismissible" role="alert">' + response + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' + '</p>');
	}
};

$(document).ready(function() {

	console.log("Document is Ready");		
});