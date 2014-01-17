$(document).ready(function() {
	
	//lancia l'autocomplete	per caricare gli user nel campo to
	//autoComplete(".box-message input#to");
  
	autoComplete('.box-message input#to');
	
	if($("#user").length > 0 && $("#limit").length > 0 && $("#skip").length > 0){
		loadBoxMessages($("#user").val(),$("#limit").val(), $("#skip").val());
	}
	
});

/*
 * permette di visualizzare più utenti nella lista degli utenti 
 */
function viewOtherListMsg(user, limit, skip) {
	$.ajax({
	    type: "POST",
	    data: {
			user: user,
			limit: limit,
			skip: skip
	    },
	    url: "./content/message/box-listUsers.php",
	    beforeSend: function(xhr) {
			if (user != 'newmessage') {
			    //$('#box-messageSingle').slideUp();
			}
	    }
	}).done(function(message, status, xhr) {
	    $('.box-other').addClass('no-display');
	    //$(message).appendTo("#box-listMsg");
	    	$("#box-listMsg").html(message);
	    //$('#box-messageSingle').slideDown();
	    console.log('SUCCESS: box-message ' + user);
	    if (user == 'newmessage') {
			//	autoComplete();
	    }
	}).fail(function(xhr) {
	    console.log("Error: " + $.parseJSON(xhr));
	});
}

/*
 * visualizza la lista dei messaggi relativi al user
 */
function loadBoxMessages(user, limit, skip) {
	try{
		$.ajax({
		    type: "POST",
		    data: {
				user: user,
				limit: limit,
				skip: skip
		    },
		    url: "./content/message/box-messages.php",
		    beforeSend: function(xhr) {
		    	goSpinner('#spinner');
				addSendMessage();
				disableSendMessage();
				if (user != 'newmessage' && skip == 0) {
				    $('#msgUser').slideUp();
				}
		    }
		}).done(function(message, status, xhr) {
			stopSpinner('#spinner');
		    if (skip == 0) {
				$("#msgUser").html(message);
				$('#msgUser').slideDown();
		    }
		    else {
				$('.otherMessage').addClass('no-display');
				$(message).prependTo("#msgUser");
		    }
		    console.log('SUCCESS: box-message ' + user);
		    if (user == 'newmessage') {
				autoComplete();
		    }
		    abledSendMessage();  
		}).fail(function(xhr) {
		    console.log("Error: " + $.parseJSON(xhr));
		});
	}catch(err){
		window.console.error("loadBoxMessages | An error occurred - message : " + err.message);
	}	
	
}	

function removeSendMessage(){
	$('#boxInvioMSG').addClass('no-display');
}

function addSendMessage(){
	$('#boxInvioMSG').removeClass('no-display');
}

function disableSendMessage(){
	$('#boxInvioMSG #textNewMessage').attr('disabled','');
	$('#boxInvioMSG input[type="button"]').attr('disabled','');
}


function abledSendMessage(){
	$('#boxInvioMSG #textNewMessage').removeAttr('disabled','');
	$('#boxInvioMSG input[type="button"]').removeAttr('disabled','');
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
	deleteMessage(id);
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

function deleteMessage(objectId){	
	var json_message = {};    
    json_message.objectId = objectId;
    json_message.request = 'deleteConversation';    
    $.ajax({
        type: "POST",
        url: "../controllers/request/messageRequest.php",
        data: json_message,
        beforeSend: function() {
            //aggiungere il caricamento del bottone
        }
    }).done(function(message, status, xhr) {
      	
        code = xhr.status;
        console.log("Code: " + code + " | Message: " + message);
    })
    .fail(function(xhr) {
        //mostra errore
  /*      message = $.parseJSON(xhr.responseText).status;
        code = xhr.status;
        console.log("Code: " + code + " | Message: " + message); */
       console.log(xhr.responseText);
    });
}
