										
function deleteMsg(id) {
	$('.box-membre#'+id).slideToggle();
}

function showMsg(id) {
	$('.box-membre').removeClass('active');
	
	$('.box-membre#'+id).addClass('active');
	$('.box-membre#'+id+'>.unread').hide();
	
	if(!$('#newmessage').is(':visible')){
		$('#newmessage').delay(1000).slideToggle();
	} 
	
//	$('#chat').delay(500).slideToggle();
	
	loadBoxMessages(id);
	var nome = $('.box-membre#'+id+'to').text();
	$("#to").val('To: ' + nome);
	$("#to").prop('readonly', true);	
	
	
}
function showNewMsg() {	
	$('.box-membre').removeClass('active');
	$('#newmessage').delay(500).slideToggle();	
	
	loadBoxMessages('newmessage');
	$("#to").prop('readonly', false);
	$("#to").val('');
	$("#to").prop('placeholder', 'To:');
	firstChat = 2;
}