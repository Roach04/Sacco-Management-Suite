$( function() {
    var availableTags = [
        "ActionScript",
        "AppleScript",
        "Asp",
        "BASIC",
        "C",
        "C++",
        "Clojure",
        "COBOL",
        "ColdFusion",
        "Erlang",
        "Fortran",
        "Groovy",
        "Haskell",
        "Java",
        "JavaScript",
        "Lisp",
        "Perl",
        "PHP",
        "Python",
        "Ruby",
        "Scala",
        "Scheme"
    ];

    $.ajax({

        url: 'http://sacco.co.ke/search/json',
        method: 'GET',
        success: function( msg ) {

            //get the response
            var response = msg['response'];

            $( "#searchText" ).autocomplete({

                source: response 
            });

            console.log(response);
        }
    });    
} );

$(document).ready(function() {

    console.log('Search Operational.');
});