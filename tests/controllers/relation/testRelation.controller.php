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
		json_relation.request = 'declineRelation';

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
	
	function acceptRelation(objectId, toUserId) {
		var json_relation = {};
		json_relation.objectId = objectId;
		json_relation.toUserId = toUserId;
		json_relation.request = 'acceptRelation';

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
	
	function removeRelation(objectId, toUserId) {
		var json_relation = {};
		json_relation.objectId = objectId;
		json_relation.toUserId = toUserId;
		json_relation.request = 'removeRelation';

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
	<input type="text" id="objectIdRichiedi" placeholder="objectIdRichiedi"/>
	<button type="button" onclick="sendRelation($('#objectIdRichiedi').val())">Richiedi Relazione</button>
	<br />
	<input type="text" id="objectIdDaAccettare" placeholder="objectIdDaAccettare"/>
	<input type="text" id="toUserobjectIdDaAccettare" placeholder="toUserobjectIdDaAccettare"/>
	<button type="button" onclick="acceptRelation($('#objectIdDaAccettare').val(), $('#toUserobjectIdDaAccettare').val())">Accetta la Relazione</button>
	<br />
	<input type="text" id="objectIdDaDeclinare" placeholder="objectIdDaDeclinare"/>
	<button type="button" onclick="declineRelation($('#objectIdDaDeclinare').val())">Declina la Relazione</button>
	<br />
	<input type="text" id="objectIdDaCancellare" placeholder="objectIdDaCancellare"/>
	<input type="text" id="toUserobjectIdDaCancellare" placeholder="toUserobjectIdDaCancellare"/>
	<button type="button" onclick="removeRelation($('#objectIdDaCancellare').val(), $('#toUserobjectIdDaCancellare').val())">Cancella la Relazione</button>
    </body>
</html>