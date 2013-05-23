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
	<div id="newPlaylist">
	<button id="new-playlist-button" onclick="javascript:newPlaylist()">Crea Nuova Playlist</button>
	</div>
	
	<!-- 	Inclusione javascript -->
	<script type="text/javascript" src="./scripts/jquery-min.js"></script>
	<script type="text/javascript" src="./scripts/jquery.validate.js"></script>
	<script type="text/javascript" src="./scripts/playlist.js"></script>
</body>
</html>

		