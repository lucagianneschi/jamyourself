<!DOCTYPE html>
<html>
    <head>
	<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
	<script type="text/javascript">
	    function userUtilities(objectId, opType, email,setting) {

		var json_userUtilities = {};

		if (opType === 'reset') {
		    json_userUtilities.request = "passwordReset";
		    json_userUtilities.email = email;
		} else if (opType === 'link') {
		    json_userUtilities.objectId = objectId;
		    json_userUtilities.request = "linkSocialAccount";
		} else if (opType === 'unlink') {
		    json_userUtilities.objectId = objectId;
		    json_userUtilities.request = "unLinkSocialAccount";
		} else {
		    
		    json_userUtilities.objectId = objectId;
		    json_userUtilities.request = "updateSetting";
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
	<button type="button" onclick="userUtilities('EKElKcMMRM', 'reset', 'lucagianneschi@hotmail.com',null)">Richiesta reset password per lucagianneschi</button>
	&nbsp;
	<button type="button" onclick="userUtilities('EKElKcMMRM', 'link', null,null)">Link Social Account per lucagianneschi</button>
	&nbsp;<hr>
	<button type="button" onclick="userUtilities('EKElKcMMRM', 'unlink', null,null)">UnLink Social Account per lucagianneschi</button>
	&nbsp;
	<button type="button" onclick="userUtilities('7fes1RyY77', 'reset', null,null)">Richiesta reset password per LDF</button>
	&nbsp;
	<button type="button" onclick="userUtilities('7fes1RyY77', 'link', null,null)">Link Social Account per LDF</button>
	&nbsp;<hr>
	<button type="button" onclick="userUtilities('7fes1RyY77', 'unlink', null,null)">UnLink Social Account per LDF</button>
	&nbsp;
	<hr>
    </body>
</html>