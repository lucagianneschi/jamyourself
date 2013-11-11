function access(usernameOrEmail, password, opType, userId) {
	var json_access = {};
	if (opType === 'login') {
		json_access.request = "login";
		json_access.usernameOrEmail = usernameOrEmail;
		json_access.password = password;
	} else if (opType === 'logout') {
		json_access.request = "logout";
	} else {
		json_access.request = "socialLogin";
		json_access.usernameOrEmail = usernameOrEmail;
		json_access.password = password;
	}

	$.ajax({
		type: "POST",
		url: "../controllers/request/accessRequest.php",
		data: json_access
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