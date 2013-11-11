window.fbAsyncInit = function() {
	// init the FB JS SDK
	FB.init({
		appId      : '538367732924885',	// App ID from the app dashboard
		status     : true,				// Check Facebook Login status
		xfbml      : true				// Look for social plugins on the page
	});

	// Additional initialization code such as adding Event Listeners goes here
	
};

// Load the SDK asynchronously
(function(d, s, id){
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) {return;}
	js = d.createElement(s); js.id = id;
	js.src = "//connect.facebook.net/en_US/all.js";
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

function userUtilities(objectId, opType, email, setting, sessionToken, socialNetworkType) {
	var json_userUtilities = {};

	if (opType === 'linkUser') {
		json_userUtilities.request = "linkUser";
		json_userUtilities.socialNetworkType = socialNetworkType;
		FB.login(function(response) {
			if (response.authResponse) {
				json_userUtilities.userID = response.authResponse.userID;
				json_userUtilities.accessToken = response.authResponse.accessToken;
				json_userUtilities.expiresIn = response.authResponse.expiresIn;
				console.log('Welcome!  Fetching your information.... ');
				console.log('===========>, ' + JSON.stringify(response));
				doAjax(json_userUtilities)
			} else {
				console.log('User cancelled login or did not fully authorize.');
				return;
			}
		});
	} else if (opType === 'unlink') {
		//TODO
		json_userUtilities.email = email;
		json_userUtilities.objectId = objectId;
		json_userUtilities.setting = setting;
		json_userUtilities.request = "unLinkSocialAccount";
	} else if (opType === 'loginUser') {
		json_userUtilities.request = "loginUser";
		json_userUtilities.socialNetworkType = socialNetworkType;
		FB.login(function(response) {
			if (response.authResponse) {
				json_userUtilities.userID = response.authResponse.userID;
				json_userUtilities.accessToken = response.authResponse.accessToken;
				json_userUtilities.expiresIn = response.authResponse.expiresIn;
				console.log('Welcome!  Fetching your information.... ');
				console.log('===========>, ' + JSON.stringify(response));
				doAjax(json_userUtilities)
			} else {
				console.log('User cancelled login or did not fully authorize.');
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