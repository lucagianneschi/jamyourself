<!DOCTYPE html>
<html>
    <head>
	<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
	<script type="text/javascript">
	    function readMessage(activityId) {

		var json_message = {};
		json_message.activityId = activityId;

		$.ajax({
		    type: "POST",
		    url: "../../../controllers/request/messageRequest.php",
		    data: json_message,
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
	Cliccando i seguenti bottoni, le activities create dall'invio di messaggi vengono smarcate come lette, così non sia ha più notifica pendente<br />
	<br />
	<button type="button" onclick="readMessage('cjqaTR1kQW')">Mark Message XXXXXXXXX as read (set read property to true)</button>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<button type="button" onclick="readMessage('cjqaTR1kQW')">Mark Message XXXXXXXXX as read (set read property to true)</button>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    </body>
</html>