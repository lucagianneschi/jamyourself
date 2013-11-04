function sendComment(toUser, comment, objectId, classType) {
	var json_comment = {};
	json_comment.toUser = toUser;
	json_comment.comment = comment;
	json_comment.objectId = objectId;
	json_comment.classType = classType;
	json_comment.request = 'comment';
	
	$.ajax({
        type: "POST",
        url: "../../../controllers/request/commentRequest.php",
        data: json_comment,
        beforeSend: function(){
        	//aggiungere il caricamento del bottone
        }
    })
	.done(function(message, status, xhr) {
		//mostra comment
		code = xhr.status;
		console.log("Code: " + code + " | Message: " + message);
	})
	.fail(function(xhr) {
		//mostra errore
		message = $.parseJSON(xhr.responseText).status;
		code = xhr.status;
		console.log("Code: " + code + " | Message: " + message);
	});
}