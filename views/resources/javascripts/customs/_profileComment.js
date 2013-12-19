function sendComment(toUser, comment, objectId, classType, classBox) {
	var json_comment = {};
	json_comment.toUser = toUser;
	json_comment.comment = comment;
	json_comment.objectId = objectId;
	json_comment.classType = classType;
	json_comment.request = 'comment';
	
	var idBox = '';
	if(classBox == 'RecordReview' || classBox == 'EventReview'){
		idBox = '#social-'+classBox;		
	}
	if(classBox == 'Album' || classBox == 'Record'){
		idBox = '#profile-'+classBox;
	}
	if(classBox == 'Image' || classBox == 'Post' || classBox == 'Comment'){
		idBox = '#'+objectId;
	}
	
	$.ajax({
        type: "POST",
        url: "../../../controllers/request/commentRequest.php",
        data: json_comment,
        beforeSend: function(){
        	$(idBox+' .comment-button').addClass('comment-btn-loader');
        	$(idBox+' .comment-button').val('');
        }
    })
	.done(function(message, status, xhr) {
		$(idBox+' .comment-error').delay(500).hide();
		callBox.objectId = objectId;
		callBox.classBox = classBox;
		callBox.load('comment');
		code = xhr.status;
		console.log("Code: " + code + " | Message: " + message);
	})
	.fail(function(xhr) {
		//mostra errore
		$(idBox+' .comment-error').delay(500).show();
    	$(idBox+' .comment-button').removeClass('comment-btn-loader');
        $(idBox+' .comment-button').val('Comment');
		message = $.parseJSON(xhr.responseText).status;
		code = xhr.status;
		console.log("Code: " + code + " | Message: " + message);
	});
}