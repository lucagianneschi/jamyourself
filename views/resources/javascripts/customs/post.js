function sendPost(objectId, post) {
	var json_post = {};
	json_post.toUser = objectId;
	json_post.post = post;
	json_post.request = 'post';
	
	$.ajax({
        type: "POST",
        url: "../../../controllers/request/postRequest.php",
        data: json_post,
        beforeSend: function(){
        	$('#social-Post #button-post').addClass('post-button-send');
        	$('#social-Post #button-post').val('');
        }
    })
	.done(function(message, status, xhr) {
		$('#post-error').delay(500).hide();
    	callBox.load('post');
		code = xhr.status;
		console.log("Code: " + code + " | Message: " + message);
	})
	.fail(function(xhr) {
		$('#post-error').delay(500).show();
    	$('#social-Post #button-post').removeClass('post-button-send');
        $('#social-Post #button-post').val('Post');
		message = $.parseJSON(xhr.responseText).status;
		code = xhr.status;
		console.log("Code: " + code + " | Message: " + message);
	});
}