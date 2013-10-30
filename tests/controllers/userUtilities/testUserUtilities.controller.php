<!DOCTYPE html>
<html>
    <head>
	<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
	<script type="text/javascript">
	    function userUtilities(objectId, opType, email, setting,sessionToken) {

		var json_userUtilities = {};

		if (opType === 'reset') {
		    json_userUtilities.request = "passwordReset";
		    json_userUtilities.email = email;
		    json_userUtilities.objectId = objectId;
		    json_userUtilities.setting = setting;
		} else if (opType === 'link') {
		    json_userUtilities.request = "linkSocialAccount";
		    json_userUtilities.email = email;
		    json_userUtilities.objectId = objectId;
		    json_userUtilities.sessionToken = sessionToken;
		} else if (opType === 'unlink') {
		    json_userUtilities.email = email;
		    json_userUtilities.objectId = objectId;
		    json_userUtilities.setting = setting;
		    json_userUtilities.request = "unLinkSocialAccount";
		} else {
		    json_userUtilities.request = "updateSetting";
		    json_userUtilities.email = email;
		    json_userUtilities.objectId = objectId;
		    json_userUtilities.setting = setting;
		}

		$.ajax({
		    type: "POST",
		    url: "../../../controllers/request/userUtilitiesRequest.php",
		    data: json_userUtilities,
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
	<title>Test Operazioni dell'utente</title>
	<meta name="description" content="Test Operazioni dell'utente" />
    </head>
    <body>
	Operazioni dell'utente<br />
	<br />
	<button type="button" onclick="userUtilities('EKElKcMMRM', 'reset', 'luca.gianneschi@gmail.com', 1,pippo)">Richiesta reset password per lucagianneschi</button>
	&nbsp;
	<button type="button" onclick="userUtilities('EKElKcMMRM', 'link', 'luca.gianneschi@gmail.com', 1,pippo)">Link Social Account per lucagianneschi</button>
	&nbsp;<hr>
	<button type="button" onclick="userUtilities('EKElKcMMRM', 'unlink', 'luca.gianneschi@gmail.com', 1,pippo)">UnLink Social Account per lucagianneschi</button>
	&nbsp;
	<button type="button" onclick="userUtilities('7fes1RyY77', 'reset', 'alessandrog@jamyourself.com', 2,pippo)">Richiesta reset password per LDF</button>
	&nbsp;
	<button type="button" onclick="userUtilities('7fes1RyY77', 'link', 'luca.gianneschi@gmail.com', 1,pippo)">Link Social Account per LDF</button>
	&nbsp;<hr>
	<button type="button" onclick="userUtilities('7fes1RyY77', 'unlink', 'luca.gianneschi@gmail.com', 1,pippo)">UnLink Social Account per LDF</button>
	&nbsp;
	<hr>
    </body>
</html>