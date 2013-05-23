
function login(){
	//recupero i valori
	var username = $("#username").val();
	var password = $("#password").val();
	
	console.log("Username : " + username);
	console.log("Password : " + password);
	
	//preparo il json
	var json = {};
	json['username'] = username;
	json['password'] = password;
	
	//invio la richiesta
	$risp = $.ajax({
		type : "POST",
		url : "../../controllers/user/loginController.php",
		data : json,
		dataType : json,
		async : false
	});

	//gestisco la risposta
	console.log("[login ] : RISPOSTA = "+$risp['responseText']);
	
	showMessage("Logged");
	
	var session = 0;
//	var risposta = $risp['responseText'];
	
	
	obj = JSON.parse($risp['responseText']);
	session = obj.userId;
	
	
	postHome(session);
	

}

function showError(text){
	$("#error").html("<span>" + text + "</span>");
}

function hideError(){
	$("#error").html("");
}

function showMessage(text){
	$("#message").html("<span>" + text + "</span>");
}

function hideMessage(){
	$("#message").html("");
}


function starSession(session){
	
	//creo un form fittizzio e passo session come post value
	$html = "<form action=''  name='login' method='post' style='display:none;'>";
	$html +="<input type='hidden' name='session' value='"+session+"'  />";
	$html +="</form>";	
	$('#login').html($html);
	
	//invio il form
	document.forms['login'].submit();

}

$().ready(function() {	
	
//	http://jquery.bassistance.de/validate/demo/
 
	// validate il form di login 
	$("#formlogin").validate({
		rules: {
			username: {
				required: true,
				minlength: 2
			},
			password: {
				required: true,
				minlength: 5
			},
		},
		messages: {
			username: {
				required: "Please enter a username",
				minlength: "Your username must consist of at least 2 characters"
			},
			password: {
				required: "Please provide a password",
				minlength: "Your password must be at least 5 characters long"
			},
		}
	});

});
