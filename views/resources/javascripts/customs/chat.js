$(document).ready(function() {
	
	//lancia l'autocomplete	per caricare gli user nel campo to
	//autoComplete(".box-message input#to");
  
	autoComplete('.box-message input#to');


  
});	

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
                url: "../controllers/request/uploadAlbumRequest.php?request=getFeaturingJSON",
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
	$("#to").prop('readonly', false);
	$("#to").val('');
	$("#to").prop('placeholder', 'To:');
	firstChat = 2;
}