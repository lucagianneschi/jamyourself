<?php
session_start();

$userId=null;

if(isset($_POST['session'])){

	$userId = $_POST['session'];

	$_SESSION['userId'] = $userId;

}else if(isset($_POST['logout'])){
	
	session_destroy();
	
	$userId=null;
	
}
else if(isset($_SESSION['userId'])){

	$userId = $_SESSION['userId'];

}


?>
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

#formsignup label.error {
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
	<div id="login" style="display: none"></div>
	<div id="logout" style="display: none"></div>

	<?php 
	if($userId == null){
	?>
	<div id="formLoginDiv">
		<form id="formlogin" action=javascript:login()>
			<p>
				<label for="username">Username</label> <input id="username"
					name="username" type="text">
			</p>
			<p>
				<label for="password">Password</label> <input id="password"
					name="password" type="password">
			</p>

			<p>
				<input id="loginButton" name="loginButton" type="submit"
					value="login">
			</p>
		</form>

	</div>
	
	<?php 
	}
	else{
	?>
		<div id="formLogoutDiv">
		<form action=javascript:endSession()>
				<input id="logoutButton" name="logouButton" type="submit"
					value="logout">
		</form>

	</div>
	
	<div id="link">
	<a href="./playlist.php">Playlist </a>
	</div>
	<?php 
	}
	?>

	<!-- 	Inclusione javascript -->
	<script type="text/javascript" src="./scripts/jquery-min.js"></script>
	<script type="text/javascript" src="./scripts/jquery.validate.js"></script>
	<script type="text/javascript" src="./scripts/home.js"></script>

</body>
</html>
