$('#pdfMember').on('click', function(event) {

	event.preventDefault();

	//get the data.
	var fname = $(this).attr('data-fname');

	console.log(fname);

	$.ajax({

		url   : 'http://sacco.co.ke/tables',
		method: 'POST',
		data  : {fname:fname},

		console.log(fname);
	});
});


$(document).ready(function() {

	console.log('PDF Trials Operational.');
});