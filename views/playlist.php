<?php

session_start();

if(!isset($_SESSION['userId'])){
	header("location: home.php");

}

$userId = $_SESSION['userId'];

?>
<html>
<head>
<title>Playlist</title>



	

<body>

	<!-- nuova playlist -->
	<div id="newPlaylist" style="display:none">
		
	</div>
	
	<!-- 	Inclusione javascript -->
	<script type="text/javascript" src="./scripts/jquery-min.js"></script>
	<script type="text/javascript" src="./scripts/jquery.validate.js"></script>
	<script type="text/javascript" src="./scripts/playlist.js"></script>
</body>
</html>

		