function newPlaylist(){
	
	userId="n1TXVlIqHw";	
	//preparo l'oggetto
	var json = {};
	json['userId'] = userId;

	
	//preparo la richiesta
	var request = {};
	request['action'] = "playlistCreate";
	request['param'] = json;
	
	
	//invio la richiesta
	risp = $.ajax({
		type : "POST",
		url : "../controllers/playlistController.php",
		data : request,
		dataType : json,
		async : false
	});
	
	
	//inizializzo la sessione
	console.log(risp['responseText']);
}