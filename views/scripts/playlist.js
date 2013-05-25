$().ready(function() {

	hideMessage();
	hideError();
	console.log("UserId :" + userId);
	// playlist = getUserPlaylists();
	
	
	
	//riempo il div delle canzoni di test
	var listaCanzoniTest = new Array(
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
	
	var text="";
	$.each(listaCanzoniTest, function(key, value) {
		id = value;
		text += "<div id='testsont-" + id
				+ "'><a href='javascript:choosePlaylistFor(\"" + userId + "\",\"" + id + "\")'>"
				+ id + "</a></div>";
	});
	
	$("#test-song-list").html(text);
	

});


/**
 * 
 * @param userId
 */
function newPlaylist(userId) {
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

/**
 * 
 */


function getUserPlaylists(userId) {
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
		async : false,
		error : function(data) {
			showError("Errore di rete");
		}
	});
	
	data = risp['responseText'];
	
	//decodifico
	json = JSON.parse(data);
	
	if (json.error != null) {
		showError(json.error);
		return null;
	}
	else{
		showMessage(json.message);
		return json.data;
	}

}


function showUserPlaylists(userId) {
	hideMessage();
	hideError();
	var playlistArray = null;
	var text = "<i>Le mie playlist</i>";
	
	hideMessage();
	hideError();
	
	//avviso l'utente sul caricamento
	$("#your-playlists").html("Loading...");
	
	//carico le playlist dell'utente
	playlistArray = getUserPlaylists(userId);

	//mostro le playlist dell'utente nel div
	if (playlistArray != null) {
		$.each(playlistArray, function(key, value) {
			json = JSON.parse(value);
			title = json.title;
			id = json.id;
			text += "<div id='playlist_" + id
					+ "'><a href='javascript:showPlaylist(\"" + id + "\")'>"
					+ json.title + "</a></div>";
		});
		//scrivo nel div
		$("#your-playlists").html(text);
		
	} else {
		//in caso di errore
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

	// jquery per recuperare la playlist

	risp = $.ajax({
		type : "POST",
		url : "../controllers/playlistController.php",
		data : request,
		dataType : "json",
		async : false,
		error : function(data) {
			showError("Errore di rete");
		}
	});
	
	data = risp['responseText'];
	
	//decodifico
	json = JSON.parse(data);
	
	if (json.error != null) {
		showError(json.error);
		return null;
	}
	else{
		showMessage(json.message);
		//json.data è un oggetto->devo parsarlo
		return JSON.parse(json.data);
	}

}

function showPlaylist(playlistId) {
	hideMessage();
	hideError();
	var text = "";
	
	// pulisco il div di destinazione
	$("#show-playlist").html("Loading...");

	playlist = getPlaylist(playlistId);

	if (playlist != null) {
		text += "<div id='title-playlist'><i>" + playlist.name + "</i></div>";
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

function choosePlaylistFor(userId,songId){
	hideMessage();
	hideError();
	var text="<i>Seleziona una playlist su cui aggiungere la canzone</i>";
	$("#test-song-playlist").html("Loading....");
	
	playlistArray = getUserPlaylists(userId);

	//mostro le playlist dell'utente nel div
	if (playlistArray != null) {
		$.each(playlistArray, function(key, value) {
			json = JSON.parse(value);
			title = json.title;
			id = json.id;
			text += "<div id='playlist_" + id
					+ "'><a href='javascript:addSongToPlaylist(\"" + id + "\",\"" + songId + "\",\"" + userId + "\")'>"
					+ json.title + "</a></div>";
		});
		//scrivo nel div
		$("#test-song-playlist").html(text);
		
	} else {
		//in caso di errore
		showError("Nessuna playlist trovata");
	}
	
}

function addSongToPlaylist(playlistId,songId,userId){
	hideMessage();
	hideError();	
	
	var data = null;
	var request = null;
	data = {};

	data['playlistId'] = playlistId;
	data['songId'] = songId;
	data['userId'] = userId;
	
	json = JSON.stringify(data);

	// preparo la richiesta
	request = {};
	request['action'] = "addSongToPlaylist";
	request['data'] = json;

	// jquery per recuperare la playlist

	risp = $.ajax({
		type : "POST",
		url : "../controllers/playlistController.php",
		data : request,
		dataType : "json",
		async : false,
		error : function(data) {
			showError("Errore di rete");
		}
	});
	
	data = risp['responseText'];	
	console.debug(data);
	
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