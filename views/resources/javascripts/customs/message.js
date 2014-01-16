$(document).ready(function() {
	
	//lancia l'autocomplete	per caricare gli user nel campo to
	//autoComplete(".box-message input#to");
  
	autoComplete('.box-message input#to');
	
  
});	

function removeSendMessage(){
	$('#sendMessage').addClass('no-display');
}

function addSendMessage(){
	$('#sendMessage').removeClass('no-display');
}

function btSendMessage(toUser){
	
//	var array = getFeaturingList('to');
//	console.log(array);
	console.log("Selected value is: "+$("#to").select2("val"));
	if( $(".select2-container").is(':visible')) { 
		//to:
		if($("#to").select2("val") != ''){
			//user okkk
			var objectId = $("#to").select2("val");
			sendMessage(objectId, $('#textNewMessage').val(), null);
		}
		else{
			//user no ok
			console.log('Utente non valido');
			 $('.select2-chosen').focus();  
		}
	}
	else{
		//valido toUser
		sendMessage(toUser,  $('#textMessage').val(), null);
	}
	
/*	if (toUser == "" && ) {
                     
     }
     else{
     	
     }
     */	
}

/*
 * 
 */ 
function autoComplete(box) {
    try {
        //inizializza le info in sessione
        sendRequest("uploadAlbum", "getFeaturingJSON", {"force": true}, null, true);
        $(box).select2({
            multiple: false,
            minimumInputLength: 1,
            width: "100%",
            ajax: {
                url: "../controllers/request/messageRequest.php?request=getFeaturingJSON",
                dataType: 'json',
                data: function(term) {                    
                    return {
                        term: term
                    };
                },
                results: function(data) {
                	console.log(data);
                    return {
                        results: data
                    };
                }
            }
        });
    } catch (err) {
        window.console.log("initFeaturing | An error occurred - message : " + err.message);
    }
}

/*
 * elimina i box utente
 */									
function deleteMsg(id) {
	$('.box-membre#'+id).slideToggle();
}

/*
 * visualizza la chat dell'utente passato come parametro
 */
function showMsg(id) {
	$('.box-membre').removeClass('active');
	
	$('.box-membre#'+id).addClass('active');
	$('.box-membre#'+id+'>.unread').hide();
	
	if(!$('#newmessage').is(':visible')){
		$('#newmessage').delay(1000).slideToggle();
	} 
	
//	$('#chat').delay(500).slideToggle();
	
	loadBoxMessages(id,5,0);
	var nome = $('.box-membre#'+id+'to').text();
	$("#to").val('To: ' + nome);
	$("#to").prop('readonly', true);	
	
	
}
/*
 * visualizza il box per invio nuovo messaggio
 */
function showNewMsg() {	
	$('.box-membre').removeClass('active');	
	$('#newmessage').delay(500).slideToggle();	
	
	loadBoxMessages('newmessage',5,0);
	autoComplete('#box-messageSingle input#to');
	$("#to").prop('readonly', false);
	$("#to").val('');
	$("#to").prop('placeholder', 'To:');
	firstChat = 2;
}


function sendMessage(toUser, message, title) {
    var json_message = {};
    json_message.toUser = toUser;
    json_message.message = message;
    json_message.title = title;
    json_message.request = 'message';

    $.ajax({
        type: "POST",
        url: "../controllers/request/messageRequest.php",
        data: json_message,
        beforeSend: function() {
            //aggiungere il caricamento del bottone
        }
    })//ADATTARE AL MESSAGE
            .done(function(message, status, xhr) {
              	loadBoxMessages(toUser,5,0)
                code = xhr.status;
                console.log("Code: " + code + " | Message: " + message);
            })
            .fail(function(xhr) {
                //mostra errore
                message = $.parseJSON(xhr.responseText).status;
                code = xhr.status;
                console.log("Code: " + code + " | Message: " + message);
            });
}

function readMessage(activityId) {
    var json_message = {};
    json_message.activityId = activityId;
    $.ajax({
        type: "POST",
        url: "../controllers/request/messageRequest.php",
        data: json_message
    }) //ADATTARE AL MESSAGE
            .done(function(message, status, xhr) {
               
                code = xhr.status;
                console.log("Code: " + code + " | Message: " + message);
            })
            .fail(function(xhr) {
                //mostra errore
                message = $.parseJSON(xhr.responseText).status;
                code = xhr.status;
                console.log("Code: " + code + " | Message: " + message);
            });
}