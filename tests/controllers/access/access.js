function access(usernameOrEmail, password, opType, userId) {

	var json_access = {};
	if (opType === 'login') {
		json_access.request = "login";
		json_access.usernameOrEmail = usernameOrEmail;
		json_access.password = password;
	} else if (opType === 'logout') {
		json_access.request = "logout";
		json_access.userId = userId;
	} else {
		json_access.request = "socialLogin";
		json_access.usernameOrEmail = usernameOrEmail;
		json_access.password = password;
	}

	$.ajax({
		type: "POST",
		url: "../../../controllers/request/accessRequest.php",
		data: json_access,
		async: false,
		"beforeSend": function(xhr) {
			xhr.setRequestHeader("X-AjaxRequest", "1");
		},
		success: function(data, status) {
			alert("[onLoad] [SUCCESS] Status: " + data);
			//console.log("[onLoad] [SUCCESS] Status: " + status + " " + data);
			location.href="http://www.socialmusicdiscovering.com/views/login.php";
		},
		error: function(data, status) {
			alert("[onLoad] [ERROR] Status: " + data);
			//console.log("[onLoad] [ERROR] Status: " + status + " " + data);
		}
	});
}