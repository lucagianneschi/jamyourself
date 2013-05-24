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
<head>
<script type="text/javascript">
var userId = "<?php echo $userId?>";
</script>
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
<body>
	
	<div id="error" class='error'></div>
	<div id="message" class='message'></div>
	
	<!-- Buttons -->
	
	<!-- nuova playlist -->
	<div id="newPlaylist-button">
		<button id="new-playlist-button" onclick="javascript:newPlaylist()">Crea Nuova Playlist</button>
	</div>
	
	<div id="userPlaylist-button">
		<button id="new-playlist-button" onclick="javascript:showUserPlaylists()">Visualizza le mie playlist</button>
	</div>
	
	<!-- div -->
	<!-- lista playlist utente -->
	<div id="your-playlists">
	
	</div>
	
	<div id="show-playlist">
	</div>
	
	
	<!-- 	Inclusione javascript -->

	<script type="text/javascript" src="./scripts/jquery-min.js"></script>
	<script type="text/javascript" src="./scripts/jquery.validate.js"></script>
	<script type="text/javascript" src="./scripts/playlist.js"></script>
</body>
</html>

		