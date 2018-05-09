setInterval(function(){

    //get the loan id.
    var id = $('#vice').val();
   
    $.ajax({
        url   : "http://sacco.co.ke/show/loans/"+id,
        method: 'GET',
        success: function( response ) {

            console.log('Refresh Grace Period After Every 1 Seconds.');
        }
    });

},600000);

$(document).ready(function() {

	console.log('Active Loans Operational.');
});