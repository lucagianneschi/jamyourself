<html>
<head>
<title>Home</title>

<style type="text/css">
.error {
	color: red;
}

.message {
	color: green;
}

#formlogin label.error {
	margin-left: 10px;
	width: auto;
	display: inline;
	color: red;
}
</style>

</head>
<body>
	<!-- div di avviso  -->
	<div id="error" class='error'></div>
	<div id="message" class='message'></div>

        <div id="signupDiv">
            <h1>REGISTRAZIONE</h1>
   		<form id="formSignup" action=javascript:signup()>
			<p>
				<label for="username">Nuovo Username</label> <input id="username"
					name="username" type="text" onblur="javascript:checkUserExists();">
			</p>
			<p>
				<label for="password">Nuova Password</label> <input id="password"
					name="password" type="password">
			</p>

			<p>
				<input id="signupButton" name="signupButton" type="submit"
					value="signup">
			</p>
		</form>         
        </div>

	<!-- 	Inclusione javascript -->
	<script type="text/javascript" src="./scripts/jquery-min.js"></script>
	<script type="text/javascript" src="./scripts/jquery.validate.js"></script>
	<script type="text/javascript" src="./scripts/signup.js"></script>

</body>
</html>
