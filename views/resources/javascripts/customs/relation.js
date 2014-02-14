function sendRelation(toUser) {
    var json_relation = {};
    json_relation.toUser = toUser;
    json_relation.request = 'sendRelation';

    $.ajax({
	type: "POST",
	url: "../../../controllers/request/relationRequest.php",
	data: json_relation,
	beforeSend: function(xhr) {
	}
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

function declineRelation(id) {
    var json_relation = {};
    json_relation.id = id;
    json_relation.request = 'declineRelation';

    $.ajax({
	type: "POST",
	url: "../../../controllers/request/relationRequest.php",
	data: json_relation,
	beforeSend: function(xhr) {
	}
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

function acceptRelation(id, toUserId) {
    var json_relation = {};
    json_relation.id = id;
    json_relation.toUserId = toUserId;
    json_relation.request = 'acceptRelation';

    $.ajax({
	type: "POST",
	url: "../../../controllers/request/relationRequest.php",
	data: json_relation,
	beforeSend: function(xhr) {
	}
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

function removeRelation(id, toUserId) {
    var json_relation = {};
    json_relation.id = id;
    json_relation.toUserId = toUserId;
    json_relation.request = 'removeRelation';

    $.ajax({
	type: "POST",
	url: "../../../controllers/request/relationRequest.php",
	data: json_relation,
	beforeSend: function(xhr) {
	}
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