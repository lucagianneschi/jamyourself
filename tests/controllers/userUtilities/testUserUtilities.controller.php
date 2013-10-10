<!DOCTYPE html>
<html>
  <head>
	<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
	<script type="text/javascript">
	  function userUtilities(objectId, opType) {

		var json_userUtilities = {};

		if (opType == 'passReset') {
		    json_love.request = "passwordReset";
		} else if(opType == 'link') {
		    json_love.request = "linkSocialAccount";
		} else{
			json_love.request = "unLinkSocialAccount";
		}
		json_userUtilities.objectId = objectId;

		$.ajax({
		  type: "POST",
		  url: "../../../controllers/request/userutilitiesRequest.php",
		  data: json_delete,
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
	<meta name="description" content="Test cancellazione istanze di classe" />
  </head>
  <body>
	Operazioni dell'utente<br />
	<br />
	<button type="button" onclick="userUtilities('Activity', 'passReset')">Richiesta reset password per lucagianneschi</button>
	&nbsp;
	<button type="button" onclick="userUtilities('Activity', 'link')">Link Social Account per lucagianneschi</button>
	&nbsp;<hr>
	<button type="button" onclick="userUtilities('Album', 'unlink')">UnLink Social Account per lucagianneschi</button>
	&nbsp;
	<hr>
  </body>
</html>