<!DOCTYPE html>
<html>
    <head>
	<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
	<script type="text/javascript">
	    function love(classType, objectId, opType) {

		var json_relation = {};

		json_relation.classType = classType;
		json_relation.objectId = objectId;

		$.ajax({
		    type: "POST",
		    url: "../controllers/request/relationRequest.php",
		    data: json_relation,
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
	<title>Pagina di test del controller delle relazioni</title>
	<meta name="description" content="La descrizione della pagina" />
    </head>
    <body>
	Cliccando i bottoni seguenti si inviano richieste di relazioni, si accettano richieste o si declinano richieste<br />
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
	<button type="button" onclick="love('Status', '4byv8FeP7S', 'increment')">Increment Love Status 4byv8FeP7S</button>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<button type="button" onclick="love('Status', '4byv8FeP7S', 'decrement')">Decrement Love Status 4byv8FeP7S</button>
	&nbsp;<hr>
	<button type="button" onclick="love('Video', 'ihcPvm6BIv', 'increment')">Increment Love Video ihcPvm6BIv</button>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<button type="button" onclick="love('Video', 'ihcPvm6BIv', 'decrement')">Decrement Love Video ihcPvm6BIv</button>
	<hr>
    </body>
</html>