/*
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

function signupFacebook() {
	FB.login(function(response) {
		if (response.authResponse) {
			console.log('Welcome!  Fetching your information.... ');
			console.log('===========>, ' + JSON.stringify(response));
			FB.api('/me', function(response) {
				console.log('Good to see you, ' + response.name + '.');
				//console.log('P====>, ' + JSON.stringify(response));
				
				var username = response.username;
				var email = response.email;
				var first_name = response.first_name;
				var last_name = response.last_name;
				var sex = response.gender;
				var birth = response.birthday;
				var desc = response.bio;
				var city = response.location.name;
				var img = 'https://graph.facebook.com/' + username + '/picture';
				
				console.log('username=' + username);
				console.log('email=' + email);
				console.log('first_name=' + first_name);
				console.log('last_name=' + last_name);
				console.log('sex=' + sex);
				console.log('birth=' + birth);
				console.log('desc=' + desc);
				console.log('city=' + city);
				console.log('img=' + img);
			});
			
			
		} else {
			console.log('User cancelled login or did not fully authorize.');
		}
	}, {scope: 'email, user_birthday, user_about_me, user_location'});
}
*/