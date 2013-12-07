$(document).ready(function() {
	
		
	autoComplete();
   
  
});	

/*
 * autocomplete 
 */

function autoComplete(){
	$("input#to").fcbkcomplete({
        json_url: "../controllers/request/uploadRecordRequest.php?request=getFeaturingJSON",
        addontab: true,
        width:"100%",
        addoncomma: false,
        firstselected: true,
        input_min_size: 0,
        height: 10,
        cache: true,
        maxshownitems: 10,
        newel: false,
        oncreate: function(){
        	$('.bit-input input').attr("placeholder", "To:");        	
        },
        onselect: function(){        	
       		$('.bit-input').addClass('no-display'); 			
        },
        onremove: function(){
        	$('.bit-input').removeClass('no-display');
        }
    });
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