function sendComment(toUser, comment, id, classType, classBox) {
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
	    .done(function(message, status, xhr) {
	//callBoxMedia.load('comment');
	callBoxMedia.id = id;
	callBoxMedia.fromUserObjectId = toUser;
	callBoxMedia.classBox = classBox;
	callBoxMedia.load('commentReview');
	code = xhr.status;
	console.log("Code: " + code + " | Message: " + message);
    })
	    .fail(function(xhr) {
	//TODO
	message = $.parseJSON(xhr.responseText).status;
	code = xhr.status;
	console.log("Code: " + code + " | Message: " + message);
    });
}