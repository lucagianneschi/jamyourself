$(document).ready(function() {
    //lanciare al caricamento del box review
    cropText();
});
/*
 * taglia il testo delle recensioni a 170 caratteri
 */
function cropText() {

    var numCharacters = $('.cropText').text().length;

    if (numCharacters > 170) {

	$(".cropText").each(function(index, element) {

	    textCrop = $(this).text().substr(0, 170);

	    textCrop = textCrop + '... ';

	    $(this).text(textCrop);

	    $(this).next().removedClass('no-display');

	    $(this).next().appendTo(this);

	});
    }
    else {
	$('.viewText').addClass('no-display');
    }


}

/*
 * Visualizza o nasconde il testo delle recensioni
 */
function toggleText(_this, box, text) {

    if ($(_this).text() == 'View All') {

	$('#' + box + ' .viewText').insertBefore('#' + box + ' .closeText');

	$('#' + box + ' .cropText').text(text);

	$('#' + box + ' .viewText').addClass('no-display');

	$('#' + box + ' .closeText').removeClass('no-display');

	hcento();
    }

    if ($(_this).text() == 'Close') {

	$('#' + box + ' .closeText').addClass('no-display');

	var text = $('#' + box + " .cropText");

	textCrop = text.text().substr(0, 170);

	textCrop = textCrop + '... ';

	text.text(textCrop);

	$('#' + box + ' .viewText').removeClass('no-display');

	$('#' + box + ' .viewText').appendTo(text);

	hcento();

    }
}

/*
 * Funzione per gestire i counters (love, comment, share e review)
 * 
 */
function setCounterMedia(_this, id, fromUserObjectId, classbox) {
    typeOpt = $(_this).text();

    switch (typeOpt) {
	case 'Comment':
	    var idBox = '';
	    if (classbox == 'RecordReview' || classbox == 'EventReview') {
		idBox = '#social-' + classbox + '-' + id;
		classObject = 'Comment';
	    }

	    if ($(idBox + ' .box-comment').hasClass('no-display')) {
		$(idBox + ' .box-comment').removeClass('no-display');
		$(idBox + ' .box').addClass('box-commentSpace');
		console.log('Comment ' + classbox + ' ' + id);
		callBoxMedia.id = id;
		callBoxMedia.fromUserObjectId = fromUserObjectId;
		callBoxMedia.classBox = classbox;
		callBoxMedia.load('commentReview');

	    }
	    else {
		$(idBox + ' .box-comment').addClass('no-display');
		$(idBox + ' .box').removeClass('box-commentSpace');
		//$("#cboxLoadedContent").getNiceScroll().hide();
		$("#cboxLoadedContent").mCustomScrollbar("update");
		hcento();
	    }

	    break;
	default:
	    console.log(typeOpt);
	    break;
    }

}
