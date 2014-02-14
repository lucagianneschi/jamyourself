function sendComment(toUser, comment, id, classType, box, limit, skip) {
    var json_comment = {};
    json_comment.toUser = toUser;
    json_comment.comment = comment;
    json_comment.id = id;
    json_comment.classType = classType;
    json_comment.request = 'comment';

    $.ajax({
	type: "POST",
	url: "../../../controllers/request/commentRequest.php",
	data: json_comment,
	beforeSend: function() {
	    //TODO
	}
    })
	    .done(function(response, status, xhr) {
	loadBoxComment(limit, skip);
	message = $.parseJSON(xhr.responseText).status;
	$('#commentCounter').html(message);
	code = xhr.status;
	console.log("Code: " + code + " | Message: " + message);
    })
	    .fail(function(xhr) {
	message = $.parseJSON(xhr.responseText).status;
	code = xhr.status;
	console.log("Code: " + code + " | Message: " + message);
    });
}