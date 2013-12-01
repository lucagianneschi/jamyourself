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
		data: json_access
	})
	.done(function(message, status, xhr) {
		//status = success
		code = xhr.status;
		console.log("Code: " + code + " | Message: " + message);
                
                //redirect per il login
                if($("#from").val()!=undefined){
                    var url = $("#from").val();
                    console.log("reloading prev page: " + url);
                    $(location).attr('href',url);
                }
	})
	.fail(function(xhr) {
		message = $.parseJSON(xhr.responseText).status;
		code = xhr.status;
		console.log("Code: " + code + " | Message: " + message);
	});
}