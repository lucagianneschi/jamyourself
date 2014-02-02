function access(usernameOrEmail, password, opType, userId) {
	var json_access = {};
	if (opType === 'login') {
		json_access.request = "login";
		json_access.usernameOrEmail = usernameOrEmail;
		json_access.password = password;
	} else if (opType === 'logout') {
		json_access.request = "logout";
	}

	$.ajax({
		type: "POST",
		url: "../controllers/request/accessRequest.php",
		data: json_access,
        beforeSend: function(){
        	
        }
	})
	.done(function(response, status, xhr) {
		message = $.parseJSON(xhr.responseText).status;
		code = xhr.status;
		console.log("Code: " + code + " | Message: " + message);
        if (opType === 'login') {
            location.href = 'views/stream.php';
        } else if (opType === 'logout') {
            location.href = 'stream.php';
        }
	})
	.fail(function(xhr) {
		message = $.parseJSON(xhr.responseText).status;
		code = xhr.status;
		console.log("Code: " + code + " | Message: " + message);
	});
}