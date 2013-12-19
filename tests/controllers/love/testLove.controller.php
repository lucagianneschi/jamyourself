<!DOCTYPE html>
<html>
    <head>
	<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
	<script type="text/javascript">
	    function love(classType, objectId, opType) {

		var json_love = {};
		if (opType == 'increment') {
		    json_love.request = "incrementLove";
		} else {
		    json_love.request = "decrementLove";
		}
		json_love.classType = classType;
		json_love.objectId = objectId;

		$.ajax({
		    type: "POST",
		    url: "../../../controllers/request/loveRequest.php",
		    data: json_love,
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
	Cliccando i bottoni seguenti si incrementa e decrementa il campo loveCounter delle classi che possono aveve azioni di love e unlove. L'utente che esegue l'operazione e' di default "GuUAj83MGH"<br />
	<br />
	<button type="button" onclick="love('Album', 'cjqaTR1kQW', 'increment')">Increment Love Album cjqaTR1kQW</button>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<button type="button" onclick="love('Album', 'cjqaTR1kQW', 'decrement')">Decrement Love Album cjqaTR1kQW</button>
	&nbsp;<hr>
	<button type="button" onclick="love('Comment', 'rEJJMsGCTo', 'increment')">Increment Love Comment rEJJMsGCTo</button>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<button type="button" onclick="love('Comment', 'rEJJMsGCTo', 'decrement')">Decrement Love Comment rEJJMsGCTo</button>
	&nbsp;<hr>
	<button type="button" onclick="love('Event', 'OXi0VJUoao', 'increment')">Increment Love Event OXi0VJUoao</button>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<button type="button" onclick="love('Event', 'OXi0VJUoao', 'decrement')">Decrement Love Event OXi0VJUoao</button>
	&nbsp;<hr>
	<button type="button" onclick="love('Image', 'gdZowTbFRk', 'increment')">Increment Love Image gdZowTbFRk</button>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<button type="button" onclick="love('Image', 'gdZowTbFRk', 'decrement')">Decrement Love Image gdZowTbFRk</button>
	&nbsp;<hr>
	<button type="button" onclick="love('Record', 'Xbu7rDWqpj', 'increment')">Increment Love Record Xbu7rDWqpj</button>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<button type="button" onclick="love('Record', 'Xbu7rDWqpj', 'decrement')">Decrement Love Record Xbu7rDWqpj</button>
	&nbsp;<hr>
	<button type="button" onclick="love('Song', 'j0AM1J4YIR', 'increment')">Increment Love Song j0AM1J4YIR</button>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<button type="button" onclick="love('Song', 'j0AM1J4YIR', 'decrement')">Decrement Love Song j0AM1J4YIR</button>
	&nbsp;<hr>
	<button type="button" onclick="love('Video', 'ihcPvm6BIv', 'increment')">Increment Love Video ihcPvm6BIv</button>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<button type="button" onclick="love('Video', 'ihcPvm6BIv', 'decrement')">Decrement Love Video ihcPvm6BIv</button>
	<hr>
    </body>
</html>