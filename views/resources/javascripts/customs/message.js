$(document).ready(function() {

	if ($("#user").length > 0 && $("#limit").length > 0 && $("#skip").length > 0) {
		loadBoxMessages($("#user").val(), $("#limit").val(), $("#skip").val());
	}

});

/*
 * permette di visualizzare più utenti nella lista degli utenti - PER ORA NON E' GESTITA - RIMANDATA.
 */
/*
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
 } */

/*
 * visualizza la lista dei messaggi relativi al user
 */
function loadBoxMessages(user, limit, skip) {
	try {
		$.ajax({
			type : "POST",
			data : {
				user : user,
				limit : limit,
				skip : skip
			},
			url : "./content/message/box-messages.php",
			beforeSend : function(xhr) {
				if (user != 'newmessage' && skip == 0) {
					$('#msgUser').slideUp({
						complete : function() {
							goSpinner('#spinner');
						}
					});
				} else if (skip != 0) {
					goSpinner('#spinner');
				}
			}
		}).done(function(message, status, xhr) {
			stopSpinner('#spinner');
			if (skip == 0) {
				$("#msgUser").html(message);
				$('#msgUser').slideDown();
			} else {
				$('.otherMessage').addClass('no-display');
				$(message).prependTo("#msgUser");
			}
			getFeaturing('#to');
			console.log('SUCCESS: box-message ' + user);

		}).fail(function(xhr) {
			console.log("Error: " + $.parseJSON(xhr));
		});
	} catch (err) {
		window.console.error("loadBoxMessages | An error occurred - message : " + err.message);
	}

}

function btSendNewMessage(box, toUser, toUserType) {
	try {
		var user = (toUser == 'newmessage') ? $("#to").select2('data').id : toUser;
		var type = 'JAMMER';
		var message = $('#' + box + ' #textNewMessage').val();

		if (user != null && user != '' && type != null && type != '' && message != "") {
			sendMessage('#' + box, user, type, $('#' + box + ' #textNewMessage').val(), -1);
		} else {
			console.log('Insert to user or message');
		}

	} catch (err) {
		window.console.error("btSendNewMessage | An error occurred - message : " + err.message);
	}
}

function btSendMessage(box, toUser, toUserType) {

	try {
		var user = toUser;
		var type = $('.box-message #' + toUser + ' input[name="type"]').val();

		var messaggio = $('#' + box + ' #textNewMessage').val();
		if (user != null && user != '' && type != null && type != '' && messaggio != "") {
			var dataPrec = '';
			$('input[name="data"]').each(function(index) {
				dataPrec = $(this).val();
			});

			var arryDataPrec = dataPrec.split(" ");
			var preimpostata = new Date(arryDataPrec[2], arryDataPrec[1] - 1, arryDataPrec[0]);
			var oggi = new Date();

			if (arryDataPrec[0] != oggi.getDate() || (arryDataPrec[1] - 1) != oggi.getMonth() || arryDataPrec[2] != oggi.getFullYear()) {
				//data diversa: aggiungo data
				var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
				var data = oggi.getDate() + ' ' + monthNames[oggi.getMonth()] + ' ' + oggi.getFullYear();
				var dataImput = oggi.getDate() + ' ' + (oggi.getMonth() + 1) + ' ' + oggi.getFullYear();

				createData(data, dataImput);

			}
			var hour = oggi.getHours();
			var min = oggi.getMinutes();
			if (hour < 10)
				hour = '0' + hour;
			if (min < 10)
				min = '0' + min;
			var num = createMessage(messaggio, hour + ':' + min);
			sendMessage('#' + box, user, type, $('#' + box + ' #textNewMessage').val(), num);

		} else {
			console.log('Insert to user or message');
		}

	} catch (err) {
		window.console.error("btSendMessage | An error occurred - message : " + err.message);
	}

}

/*
 * html per la data
 */
function createData(data, dataImput) {
	var html = '<div class="row">' + '<div class="large-12 columns">' + '<div class="line-date"><small>' + data + '</small></div>' + '<input type="hidden" value="' + dataImput + '" name="data"/>' + '</div>' + '</div>';
	$(html).appendTo("#msgTmp");
	return html;
}

/*
 * html per il messaggio
 */
function createMessage(msg, time) {
	var num = Math.round(10000 * Math.random());
	var html = '<div class="row newMsg ' + num + '" >' + '<div class="large-8 large-offset-2 columns msg msg-mine">' + '<p>' + msg + '</p>' + '</div>' + '<div class="large-2 hide-for-small columns">' + '<div class="date-mine">' + '	<small>' + time + '</small>' + '</div>' + '</div>' + '</div>';
	$(html).appendTo("#msgTmp");
	return num;
}

function errorMesseage(num) {
	$('.' + num).removeClass('newMsg');
	$('.' + num).addClass('newMsgError');
	var time = $('.' + num + ' .date-mine small').html();
	$('.' + num + ' .date-mine small').html('ERROR - ' + time);
}

/*
 * elimina i box utente
 */
function deleteMsg(id) {

	deleteMessage(id);

}

/*
 * visualizza la chat dell'utente passato come parametro
 */
function showMsg(id) {
	$('#box-listMsg .box-membre').removeClass('active');

	$('#box-listMsg .box-membre#' + id).addClass('active');
	$('#box-listMsg .box-membre#' + id + '>.unread').hide();

	if (!$('#newmessage').is(':visible')) {
		$('#newmessage').delay(1000).slideToggle();
	}

	//	$('#chat').delay(500).slideToggle();

	loadBoxMessages(id, 5, 0);
	var nome = $('.box-membre#' + id + 'to').text();
	$("#to").val('To: ' + nome);
	$("#to").prop('readonly', true);

}

/*
 * visualizza il box per invio nuovo messaggio
 */
function showNewMsg() {
	$('#box-listMsg .box-membre').removeClass('active');
	$('#newmessage').delay(500).slideToggle();

	loadBoxMessages('newmessage', 5, 0);
	//	autoComplete('#box-messageSingle input#to');
	$("#to").prop('readonly', false);
	$("#to").val('');
	$("#to").prop('placeholder', 'To:');
	firstChat = 2;
}

function sendMessage(box, toUser, toUserType, message, num) {
	var json_message = {};
	json_message.toUser = toUser;
	json_message.toUserType = toUserType;
	json_message.message = message;
	json_message.request = 'message';

	$.ajax({
		type : "POST",
		url : "../controllers/request/messageRequest.php",
		data : json_message,
		beforeSend : function() {
			//aggiungere il caricamento del bottone
			if (num == -1) {
				$(box).slideUp({
					complete : function() {
						goSpinner('#spinner');
					}
				});
			}
			$(box + ' #textNewMessage').val('');
		}
	})//ADATTARE AL MESSAGE
	.done(function(message, status, xhr) {
		code = xhr.status;
		console.log("Code: " + code + " | Message: " + message);
		if (code == 200) {
			if (num == -1) {
				window.location.href = 'message.php?user=' + toUser;
			} else
				$('.' + num).removeClass('newMsg');
		}
		else{
			//#TODO se restituisce un codice diverso da 200 segnalare che c'è stato un errore all'utente
		}
	}).fail(function(xhr) {
		//mostra errore
		if (num == -1) {
			$('#newMsgUser').html('ERROR');
			$('#newMsgUser').slideDown({
				complete : function() {
					stopSpinner('#spinner');
				}
			});
		} else
			errorMesseage(num);
		message = $.parseJSON(xhr.responseText).status;
		code = xhr.status;
		console.log("Code: " + code + " | Message: " + message);
	});
}

function readMessage(activityId) {
	var json_message = {};
	json_message.id = activityId;
	json_message.request = 'read';
	$.ajax({
		type : "POST",
		url : "../controllers/request/messageRequest.php",
		data : json_message
	})//ADATTARE AL MESSAGE
	.done(function(message, status, xhr) {

		code = xhr.status;
		console.log("Code: " + code + " | Message: " + message);
	}).fail(function(xhr) {
		//mostra errore
		message = $.parseJSON(xhr.responseText).status;
		code = xhr.status;
		console.log("Code: " + code + " | Message: " + message);
	});
}

function deleteMessage(toUser) {
	var json_message = {};
	json_message.toUser = toUser;
	json_message.request = 'deleteConversation';
	$.ajax({
		type : "POST",
		url : "../controllers/request/messageRequest.php",
		data : json_message,
		beforeSend : function() {
			$('#box-listMsg .box-membre#' + toUser).css({
				'opacity' : '0.3',
				'pointer-events' : 'none'
			});
			//aggiungere il caricamento del bottone
		}
	}).done(function(message, status, xhr) {
		$('#box-listMsg .box-membre#' + toUser).slideToggle();
		showNewMsg();

		code = xhr.status;
		console.log("Code: " + code + " | Message: " + message);
	}).fail(function(xhr) {
		//mostra errore
		message = $.parseJSON(xhr.responseText).status;
		code = xhr.status;
		console.log("Code: " + code + " | Message: " + message);

	});
}
