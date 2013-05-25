
$().ready(function() {	
	
	console.log("UserId :" + userId);
//	playlist = getUserPlaylists();
	
});

function newPlaylist(){
	//preparo l'oggetto
	var data ={};
	
	data['userId'] = userId;
	
	json = JSON.stringify(data);
	//preparo la richiesta
	var request = {};
	request['action'] = "playlistCreate";
	request['data'] = json;
		
	//invio la richiesta
	risp = $.ajax({
		type : "POST",
		url : "../controllers/playlistController.php",
		data : request,
		dataType : "text/json",
		async : false
	});
	
	json = risp['responseText'];
	window.console.log(json);
	
	//inizializzo la sessione
	risposta = JSON.parse(json);
	
	if(risposta.error!=null){
		showError(risposta.error);
	
	}
	else{
		showMessage(risposta.message);	
	}
	
	
}

function getUserPlaylists(){
	var data = null;
	var request = null;
	
	data={};
	
	data['userId'] = userId;
	
	json = JSON.stringify(data);
	
	console.log("ho spedito : " + json);
	
	//preparo la richiesta
	request = {};
	request['action'] = "getUserPlaylists";
	request['data'] = json;
		
	//invio la richiesta
	risp = $.ajax({
		type : "POST",
		url : "../controllers/playlistController.php",
		data : request,
		dataType : "text/json",
		async : false
	});	
	
	json = risp['responseText'];
	window.console.log(json);
	
	//inizializzo la sessione
	risposta = JSON.parse(json);
	
	if(risposta.error!=null){
		showError(risposta.error);
		return null;
	
	}
	else{
		showMessage(risposta.message);	
		
		//recupero i dati delle playlists da data
		data = JSON.parse(risposta.data);
		playlists = JSON.parse(data.playlists);
		return playlists;
	}
}

function showUserPlaylists(){
	var text = "";
	
	//pulisco il div di destinazione
	$("your-playlists").html("");
	
	//recupero le playlist dell'utente

	var playlists = getUserPlaylists();
	if(playlists){
		$.each( playlists, function( key, value ) {
//			text += "<div id='playlist_"+playlists.id+"'>" playlists.title+"</div><br>";  			
			});
		
		$("your-playlists").html(text);
	};
	
}

function showError(text){
	$("#error").html("<span>" + text + "</span>");
}

function hideError(){
	$("#error").html("");
}

function showMessage(text){
	$("#message").html("<span>" + text + "</span>");
}

function hideMessage(){
	$("#message").html("");
}