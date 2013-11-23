<!DOCTYPE html>
<html>
    <head>
	<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
	<script type="text/javascript">
	function sendRelation(toUser) {
		var json_relation = {};
		json_relation.toUser = toUser;
		json_relation.request = 'sendRelation';

		$.ajax({
		    type: "POST",
		    url: "../../../controllers/request/relationRequest.php",
		    data: json_relation,
		    beforeSend: function(xhr) {}
		})
		.done(function(message, status, xhr) {
			//status = success
			code = xhr.status;
			console.log("Code: " + code + " | Message: " + message);
		})
		.fail(function(xhr) {
			message = $.parseJSON(xhr.responseText).status;
			code = xhr.status;
			console.log("Code: " + code + " | Message: " + message);
		});
	}
	
	function declineRelation(objectId) {
		var json_relation = {};
		json_relation.objectId = objectId;
		json_relation.request = 'sendRelation';

		$.ajax({
		    type: "POST",
		    url: "../../../controllers/request/relationRequest.php",
		    data: json_relation,
		    beforeSend: function(xhr) {}
		})
		.done(function(message, status, xhr) {
			//status = success
			code = xhr.status;
			console.log("Code: " + code + " | Message: " + message);
		})
		.fail(function(xhr) {
			message = $.parseJSON(xhr.responseText).status;
			code = xhr.status;
			console.log("Code: " + code + " | Message: " + message);
		});
	}
	</script>
	<title>Pagina di test del controller delle relazioni</title>
	</head>
    <body>
	Cliccando i bottoni seguenti si inviano richieste di relazioni, si accettano richieste o si declinano richieste<br />
	<br />
	<button type="button" onclick="sendRelation('GuUAj83MGH')">Relazione currentUser -> SPOTTER (GuUAj83MGH)</button>
	<br />
	<input type="text" id="objectIdDaDeclinare" />
	<button type="button" onclick="declineRelation($.('#objectIdDaDeclinare').val())">Declina la Relazione</button>
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