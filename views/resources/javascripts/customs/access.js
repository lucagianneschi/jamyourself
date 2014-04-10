function access(usernameOrEmail, password, opType, userId) {
	try {
		var json_access = {};
		if (opType === 'login') {
			json_access.request = "login";
			json_access.usernameOrEmail = usernameOrEmail;
			json_access.password = password;
		} else if (opType === 'logout') {
			json_access.request = "logout";
		}

		$.ajax({
			type : "POST",
			url : "../../../controllers/request/accessRequest.php",
			data : json_access,
			beforeSend : function() {
				$('#login').val('');
				$('#login').addClass('comment-btn-loader');
			}
		}).done(function(response, status, xhr) {
			//TODO
            //message = $.parseJSON(xhr.responseText).status;
            //code = xhr.status;
            //console.log("Code: " + code + " | Message: " + message);
            console.log(xhr);
			if (opType === 'login') {
				location.href = 'views/stream.php';
			} else if (opType === 'logout') {
				location.href = '../index.php';
			}
		}).fail(function(xhr) {
			$('#login').val('Error');
			$('#login').removeClass('comment-btn-loader');
			//#TODO
            //message = $.parseJSON(xhr.responseText).status;
            //code = xhr.status;
            //console.log("Code: " + code + " | Message: " + message);
            console.log(xhr);
		});
	} catch(err) {
		window.console.error("access | An error occurred - message : " + err.message);
	}

}