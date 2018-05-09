setInterval(function(){

	//get the id.
	var id = $('#dashboard').val();

	var dem = "http://sacco.co.ke/loan/analysis/"+id+"/defaulters";
    
    $.ajax({

    	url   : "http://sacco.co.ke/loan/analysis/"+id+"/defaulters",
    	method: 'GET',
      	success: function( response ) {

        	console.log(dem);
      	}
    });

},60000);

$('#vice').ready(function() {

	console.log('Defaulters Operational.');
});