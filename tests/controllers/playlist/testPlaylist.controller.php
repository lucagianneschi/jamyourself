<!DOCTYPE html>
<html>
    <head>
	<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
	<script type="text/javascript">
	    function playlist(playlistId, songId, opType) {

		var json_playlist = {};
		if (opType == 'add') {
		    json_playlist.request = 'addSong';
		} else {
		    json_playlist.request = 'removeSong';
		}

		json_playlist.playlistId = playlistId;
		json_playlist.songId = songId;

		$.ajax({
		    type: "POST",
		    url: "../../../controllers/request/playlistRequest.php",
		    data: json_playlist,
		    async: false,
		    "beforeSend": function(xhr) {
			xhr.setRequestHeader("X-AjaxRequest", "1");
		    },
		    success: function(data, status) {
			alert("[onLoad] [SUCCESS] Status: " + data);
			//console.log("[onLoad] [SUCCESS] Status: " + status + " " + data);
		    },
		    error: function(data, status) {
			alert("[onLoad] [ERROR] Status: " + data);
			//console.log("[onLoad] [ERROR] Status: " + status + " " + data);
		    }
		});
	    }
	</script>
	<title>Test controller Playlist</title>
	<meta name="description" content="Test controller Playlist" />
    </head>
    <body>
	Cliccando i bottoni si aggiungono o tolgono canzoni prescelte sulla playlist di SPATAFORA<br />
	<br />
	<button type="button" onclick="playlist('EWlkBSXQJt', 'nBF3KVDGxZ', 'add')">AGGIUNGI Song nBF3KVDGxZ alla playslist di SPATAFORA cjqaTR1kQW</button>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<button type="button" onclick="playlist('EWlkBSXQJt', 'nBF3KVDGxZ', 'remove')">RIMUOVI Song nBF3KVDGxZ alla playslist di SPATAFORA cjqaTR1kQW</button>
	&nbsp;<hr>
	<button type="button" onclick="playlist('EWlkBSXQJt', 'MSJfcWb9Qk', 'add')">AGGIUNGI Song MSJfcWb9Qk alla playslist di SPATAFORA </button>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<button type="button" onclick="playlist('EWlkBSXQJt', 'MSJfcWb9Qk', 'remove')">RIMUOVI Song MSJfcWb9Qk alla playslist di SPATAFORA </button>
	&nbsp;<hr>
    </body>
</html>