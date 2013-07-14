$(document).ready(function() {
    //inizializzazione
    onLoad();
    
});

function signup(){
    //recupero tutti i campi che l'utente
    //ha inizializzato nel form
    var newUser = getFormFieldValues();    
    
     var json_signup = {};
    json_signup.rquest = "signup";
    json_signup.newUser = newUser;

    $.ajax({
        type: "POST",
        url: "../controllers/signupRequest.php",
        data: json_signup,
        async: false,
        "beforeSend": function(xhr) {
            xhr.setRequestHeader("X-AjaxRequest", "1");
        },
        success: function(data, status) {
            console.log("[onLoad] [SUCCESS] Status: " + status);
        },
        error: function(data, status) {
            console.log("[onLoad] [ERROR] Status: " + status);
        }
    });     
    
}

function getFormFieldValues(){
    
}