window.fbAsyncInit = function() {
    // init the FB JS SDK
    FB.init({
	appId: '538367732924885',
	status: true,
	xfbml: true
    });

};

// Load the SDK asynchronously
(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {
	return;
    }
    js = d.createElement(s);
    js.id = id;
    js.src = "//connect.facebook.net/en_US/all.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

function userUtilities(id, opType, email, setting, sessionToken, socialNetworkType) {
    var json_userUtilities = {};

    if (opType === 'linkUser') {
	json_userUtilities.request = "linkUser";
	json_userUtilities.socialNetworkType = socialNetworkType;
	FB.login(function(response) {
	    if (response.authResponse) {
		json_userUtilities.userID = response.authResponse.userID;
		json_userUtilities.accessToken = response.authResponse.accessToken;
		json_userUtilities.expiresIn = response.authResponse.expiresIn;
		//DEBUG
		console.log('DEBUG=>' + JSON.stringify(response));
		doAjax(json_userUtilities);
	    } else {
		//DEBUG
		console.log('DEBUG=>User cancelled login or did not fully authorize.');
		return;
	    }
	});
    } else if (opType === 'unlinkUser') {
	json_userUtilities.request = "unlinkUser";
	json_userUtilities.socialNetworkType = socialNetworkType;
	doAjax(json_userUtilities);
    } else if (opType === 'loginUser') {
	json_userUtilities.request = "loginUser";
	json_userUtilities.socialNetworkType = socialNetworkType;
	FB.login(function(response) {
	    if (response.authResponse) {
		json_userUtilities.userID = response.authResponse.userID;
		json_userUtilities.accessToken = response.authResponse.accessToken;
		json_userUtilities.expiresIn = response.authResponse.expiresIn;
		//DEBUG
		console.log('DEBUG=>' + JSON.stringify(response));
		doAjax(json_userUtilities)
	    } else {
		//DEBUG
		console.log('DEBUG=>User cancelled login or did not fully authorize.');
		return;
	    }
	});
    }
}

function doAjax(json_userUtilities) {
    $.ajax({
	type: "POST",
	url: "../controllers/request/socialRequest.php",
	data: json_userUtilities
    })
	    .done(function(response, status, xhr) {
	message = $.parseJSON(xhr.responseText).status;
	code = xhr.status;
	console.log("Code: " + code + " | Message: " + message);
    })
	    .fail(function(xhr) {
	message = $.parseJSON(xhr.responseText).status;
	code = xhr.status;
	console.log("Code: " + code + " | Message: " + message);
    });
}