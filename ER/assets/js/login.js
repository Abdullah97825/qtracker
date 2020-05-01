$(document).ready(function() {

    //On click signup, hide login and show registration form
    $("#signup").click(function() {
        $("#first").slideUp("normal", function() {
            $("#second").slideDown("normal");
        });
    });

    //On click signup, hide registration and show login form
    $("#signin").click(function() {
        $("#second").slideUp("normal", function() {
            $("#first").slideDown("normal");
        });
    });


});