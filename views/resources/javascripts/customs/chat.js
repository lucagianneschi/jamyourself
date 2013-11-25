var firstChat = 1;
											
function deleteMsg(id) {
	$('#'+id).slideToggle();
}
function showMsg(id) {
	$('.box-membre').removeClass('active');
	$('#'+id).addClass('active');
	$('#'+id+'>.unread').hide();
	
	$('#chat').slideToggle();
	if (firstChat == 0) {
		$('#chat').delay(500).slideToggle();
	}
	if (firstChat == 1) {
		$('#newmessage').delay(1000).slideToggle();
	}
	firstChat = 0;
	var nome = $('#'+id+'to').text();
	$("#to").val('To: ' + nome);
	$("#to").prop('readonly', true);
}
function showNewMsg() {
	$('.box-membre').removeClass('active');
	$('#chat').slideToggle();
	$("#to").prop('readonly', false);
	$("#to").val('');
	$("#to").prop('placeholder', 'To:');
	firstChat = 2;
}