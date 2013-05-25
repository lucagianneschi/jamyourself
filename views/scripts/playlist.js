$().ready(function() {

	hideMessage();
	hideError();
	console.log("UserId :" + userId);
	// playlist = getUserPlaylists();

});

var listaCanzoniTest = array(
							"nBF3KVDGxZ",
							"68eX5oxAOe",
							"74AlhXh9PZ",
							"35Y35naEiK",
							"39HTHaZxew",
							"aSrReDuIW1",
							"0Ih7nd1rLX",
							"q1fVHDRD7V",
							"sE0ZfulSIa"
							);


function newPlaylist() {
	hideMessage();
	hideError();
	// preparo l'oggetto
	var data = {};

	data['userId'] = userId;

	json = JSON.stringify(data);
	// preparo la richiesta
	var request = {};
	request['action'] = "playlistCreate";
	request['data'] = json;

	// invio la richiesta
	risp = $.ajax({
		type : "POST",
		url : "../controllers/playlistController.php",
		data : request,
		dataType : "text/json",
		async : false
	});

	json = risp['responseText'];
	// window.console.log(json);

	// inizializzo la sessione
	risposta = JSON.parse(json);

	if (risposta.error != null) {
		showError(risposta.error);

	} else {
		showMessage(risposta.message);
	}

}

function getUserPlaylists() {
	hideMessage();
	hideError();
	var data = null;
	var request = null;
	data = {};

	data['userId'] = userId;

	json = JSON.stringify(data);

	// console.log("ho spedito : " + json);

	// preparo la richiesta
	request = {};
	request['action'] = "getUserPlaylists";
	request['data'] = json;

	// invio la richiesta
	risp = $.ajax({
		type : "POST",
		url : "../controllers/playlistController.php",
		data : request,
		dataType : "json",
		async : true,
		success : showUserPlaylists,
		error : function(data) {
			showError("Errore di rete");
		}
	});
}

function showUserPlaylists(data) {
	hideMessage();
	hideError();
	var text = "";
	// pulisco il div di destinazione
	$("#your-playlists").html("");

	if (data.error != null) {
		showError(data.error);
		return;
	}

	playlistArray = data.data;

	if (playlistArray != null) {
		$.each(playlistArray, function(key, value) {
			json = JSON.parse(value);
			title = json.title;
			id = json.id;
			text += "<div id='playlist_" + id
					+ "'><a href='javascript:getPlaylist(\"" + id + "\")'>"
					+ json.title + "</a></div>";
		});
		showMessage(data.message);
		$("#your-playlists").html(text);
	} else {
		showError("Nessuna playlist trovata");
	}

}

function getPlaylist(playlistId) {
	hideMessage();
	hideError();
	var data = null;
	var request = null;
	data = {};

	data['playlistId'] = playlistId;

	json = JSON.stringify(data);

	// preparo la richiesta
	request = {};
	request['action'] = "getPlaylist";
	request['data'] = json;

	$("#show-playlist").html("Loading...");

	// jquery per recuperare la playlist

	risp = $.ajax({
		type : "POST",
		url : "../controllers/playlistController.php",
		data : request,
		dataType : "json",
		async : true,
		success : showPlaylist,
		error : function(data) {
			showError("Errore di rete");
		}
	});

}

function showPlaylist(data) {
	hideMessage();
	hideError();
	var text = "";
	// pulisco il div di destinazione
	$("#show-playlist").html("");

	if (data.error != null) {
		showError(data.error);
		return;
	}

	playlist = JSON.parse(data.data);

	if (playlist != null) {
		text += "<div id='title-playlist'>" + playlist.name + "</div>";
		text += "<div id='playlist-songs'>";
		if (playlist.songs) {
			
			songList = playlist.songs;

			$.each(songList, function(key, value) {
				song = JSON.parse(value);
				title = song.title;
				id = song.id;
				text += "<div id='playlist_" + id + "'>" + json.title
						+ "</div>";
			});

		} else {
			text += "La tua playlist non contiene nessuna canzone";
		}
		text += "</div>";

	} else {
		showError("Nessuna playlist trovata");
	}
	
	$("#show-playlist").html(text);
}

function showError(text) {
	$("#error").html("<span>" + text + "</span>");
}

function hideError() {
	$("#error").html("");
}

function showMessage(text) {
	$("#message").html("<span>" + text + "</span>");
}

function hideMessage() {
	$("#message").html("");
}