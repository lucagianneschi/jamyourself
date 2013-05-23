
$().ready(function() {	
	
	var playlist = new array();
	
	playlist = getUserPlaylist();
	
});

function newPlaylist(userId){
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