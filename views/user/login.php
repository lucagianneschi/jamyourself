<?php
session_start();
?>
<html>
<head>
<title>Login</title>

	<style type="text/css">

	.error { color: red; }

	.message { color: green; }
	
	#formlogin label.error {
		margin-left: 10px;
		width: auto;
		display: inline;
		color: red;
	}
	</style>

</head>
<body>
	<div id="error" class='error'></div>
	<div id="message" class='message'></div>

	<form id="formlogin" action=javascript:login()>
	<p>
	<label for="username">Username</label>
	<input id="username" name="username" type="text" >
	</p>
	<p>
	<label for ="password">Password</label>
	<input id="password" name="password" type="password" >
	</p>

	<p>
	<input id="loginButton" name="loginButton" type="submit" value="login">
	</p>
	</form>
	
<!-- 	Inclusione javascript -->
<script type="text/javascript" src="../scripts/jquery-min.js"></script>
<script type="text/javascript" src="../scripts/jquery.validate.js"></script>
<script type="text/javascript" src="../scripts/login.js"></script>

</body>
</html>
