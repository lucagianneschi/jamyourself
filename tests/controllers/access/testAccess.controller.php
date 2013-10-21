<!DOCTYPE html>
<html>
    <head>
	<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
	<script type="text/javascript">
	    function access(usernameEmail, password, opType) {

		var json_access = {};
		if (opType == 'login') {
		    json_access.request = "login";
			json_access.usernameEmail = usernameEmail;
			json_access.password = password;	
		} else if (opType == 'logout'){
		    json_love.request = "logout";
			json_access.userId = userId;
		} else if (opType == 'socialLogin'){
			json_access.request = "socialLogin";
		}

		$.ajax({
		    type: "POST",
		    url: "../../../controllers/request/accessRequest.php",
		    data: json_access,
		    async: false,
		    "beforeSend": function(xhr) {
			xhr.setRequestHeader("X-AjaxRequest", "1");
		    },
		    success: function(data, status) {
			alert("[onLoad] [SUCCESS] Status: " + data);
			//console.log("[onLoad] [SUCCESS] Status: " + status + " " + data);
		    },
		    error: function(data, status) {
			alert("[onLoad] [ERROR] Status: " + data);
			//console.log("[onLoad] [ERROR] Status: " + status + " " + data);
		    }
		});
	    }
	</script>
	<title>Il titolo della pagina</title>
	<meta name="description" content="La descrizione della pagina" />
    </head>
    <body>
	Cliccando i bottoni si effettuano operazioni di login e logout<br />
	<br />
	<button type="button" onclick="access('lucagianneschi', 'luca131181', 'login')">Login lucagianneschi</button>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<button type="button" onclick="access('lucagianneschi', 'luca131181', 'logout')">Logout lucagianneschi</button>
	&nbsp;<hr>
	<button type="button" onclick="access('Ldf', '7fes1RyY77', 'login')">Login Ldf</button>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<button type="button" onclick="access('Ldf', '7fes1RyY77', 'logout')">Logout Ldf</button>
	&nbsp;<hr>
	<button type="button" onclick="access('xxxxxxxx', '12345678', 'sociaLogin')">SocialLogin</button>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    </body>
</html>