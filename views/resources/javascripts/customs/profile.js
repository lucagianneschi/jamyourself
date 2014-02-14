$(document).ready(function() {

    /*
     * apertura e chiusura testo review album e eventi social
     */

    $('.viewEventReview a').toggle(function() {
	$('.textEventReview').removeClass('no-display');
	$('.viewEventReview a strong').text('Close');

    }, function() {
	$('.textEventReview').addClass('no-display');
	$('.viewEventReview a strong').text('Read');
    });

    $("#social_list_badge").touchCarousel({
	pagingNav: false,
	snapToItems: true,
	itemsPerMove: 1,
	scrollToLast: false,
	loopItems: false,
	scrollbar: false
    });
    /*
     $(".royalSlider").royalSlider({
     // options go here
     // as an example, enable keyboard arrows nav
     keyboardNavEnabled : true,
     startSlideId : 2,
     controlNavigation : 'none',
     
     });
     */
    cropText(null);




});

function prova() {
    $('#modalRelation').foundation('reveal', 'open');
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

	rsi_recordReview.updateSliderSize(true);
	rsi_eventReview.updateSliderSize(true);
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
	rsi_recordReview.updateSliderSize(true);
	rsi_eventReview.updateSliderSize(true);
	hcento();

    }
}

/*
 * Funzione per gestire i counters (love, comment, share e review)
 * 
 */
function setCounter(_this, id, classbox) {
    typeOpt = $(_this).text();
    switch (typeOpt) {
	/* si pu� eliminare perch� implementato dentro love.js, ma mantenuto per adesso per backup
	 case 'Love':
	 parent = $(_this).parent().parent();
	 objectLove = $(parent).find("a._unlove");
	 $(objectLove).toggleClass('orange grey');
	 var number_love = parseInt($(objectLove).text(), 10);
	 $(objectLove).text(number_love + 1);
	 $(objectLove).toggleClass('_love _unlove');
	 $(_this).text('Unlove');
	 break;
	 case 'Unlove':
	 parent = $(_this).parent().parent();
	 objectLove = $(parent).find("a._love");
	 $(objectLove).toggleClass('grey orange');
	 var number_love = parseInt($(objectLove).text(), 10);
	 $(objectLove).text(number_love - 1);
	 $(objectLove).toggleClass('_unlove _love');
	 $(_this).text('Love');
	 break;
	 */
	case 'Comment':
	    var idBox = '';
	    if (classbox == 'RecordReview' || classbox == 'EventReview') {
		idBox = '#social-' + classbox;
		classObject = 'Comment';
	    }
	    if (classbox == 'Record') {
		idBox = '#profile-' + classbox;
		classObject = 'Record';
	    }
	    if (classbox == 'Album') {
		idBox = '.profile-singleAlbum';
		classObject = 'Album'
	    }
	    if (classbox == 'Image' || classbox == 'Post') {
		idBox = '#' + id;
		if (classbox == 'Post')
		    classObject = 'Comment';
		else
		    classObject = 'Image';
	    }
	    console.log(idBox);
	    if ($(idBox + ' .box-comment').hasClass('no-display')) {
		$(idBox + ' .box-comment').removeClass('no-display');
		$(idBox + ' .box').addClass('box-commentSpace');
		console.log(id + ' ' + classbox);
		callBox.id = id;
		callBox.classObject = classObject;
		callBox.classBox = classbox;
		callBox.load('comment');

	    }
	    else {
		$(idBox + ' .box-comment').addClass('no-display');
		$(idBox + ' .box').removeClass('box-commentSpace');
		//$("#cboxLoadedContent").getNiceScroll().hide();
		$("#cboxLoadedContent").mCustomScrollbar("update");
		hcento();
	    }

	    //$(idBox+' .box').toggleClass('box-commentSpace');

	    //$(idBox+' .box-comment').toggle(function(){});	

	    break;
	default:
	    console.log(typeOpt);
    }

}

function slideAchievement() {
    $("#social_list_badge").touchCarousel({
	pagingNav: false,
	snapToItems: true,
	itemsPerMove: 1,
	scrollToLast: false,
	loopItems: false,
	scrollbar: false
    });
}



//funzione per gestire la visualizzazione dell'album
function recordSelectSingle(recordId, objectIdCurrentUser) {
    $("#record-list").fadeOut(100, function() {
	$('.' + recordId).fadeIn(100);
	addthis.init();
	addthis.toolbox(".addthis_toolbox");
	callBox.id = recordId;
	callBox.limit = 50;
	callBox.load('recordDetail');
    });
}
//nasconde foto singolo album e visualizza lista album
function recordSelectNext(recordId) {
    $('.' + recordId).fadeOut(100, function() {
	$('#record-list').fadeIn(100);
	//ricalcolare
	$('#profile-Record .box-comment').addClass('no-display');
	$('#profile-Record .box').removeClass('box-commentSpace');
	//$("#cboxLoadedContent").getNiceScroll().hide();
	$("#cboxLoadedContent").mCustomScrollbar("update");

	rsi_record.updateSliderSize(true);
    });
}



//visualizza foto di singolo album e nasconde lista album
function albumSelectSingle(id, num) {
    var limit = 12;
    var skip = 0;
    //effettua transizione se ci sono foto all'interno dell'album
    if (num > 0) {
	$("#albumSlide").fadeOut(100, function() {
	    $('#' + id).fadeIn(100);
	    if (!$('#' + id + ' .photo-colorbox-group').length) {
		callBox.id = id;
		callBox.limit = limit;
		callBox.skip = skip;
		callBox.numerDetail = num;
		callBox.load('albumDetail');
	    }
	});
    }

}
//nasconde foto singolo album e visualizza lista album
function albumSelectNext(id) {
    $('#' + id).fadeOut(100, function() {
	$('.profile-singleAlbum .box-comment').addClass('no-display');
	$('.profile-singleAlbum  .box').removeClass('box-commentSpace');
	$('#albumSlide').fadeIn(100);
	hcento();
	$("#cboxLoadedContent").mCustomScrollbar("update");
	callBox.load('album');
    });
}

//visuallizza il link other  #NON SERVE
function getOtherObject(dataPrec, num) {
    callBox.limit = 12;
    callBox.skip = 12;
    callBox.numerDetail = num;
    callBox.dataPrec = dataPrec;
    callBox.load('albumDetail');

}

function getScrollBar(boxId) {
    var scrollbar = $(boxId).mCustomScrollbar({
	updateOnContentResize: true,
	autoHideScrollbar: true,
	mouseWheel: true,
	scrollInertia: 100,
	advanced: {
	    autoScrollOnFocus: false
	}
    });
    return scrollbar;
}

function royalSlideNext(btn, box) {
    var rsi;
    switch (box) {
	case 'record':
	    rsi = rsi_record;
	    break;
	case 'event':
	    rsi = rsi_event;
	    break;
	case 'album':
	    rsi = rsi_album;
	    break;
	case 'EventReview':
	    rsi = rsi_eventReview;
	    break;
	case 'RecordReview':
	    rsi = rsi_recordReview;
	    break;
	default:
	    break;
    }
    if (box == 'EventReview' && !$('#social-' + box + ' .box-opinion').hasClass('no-display')) {
	$('#social-' + box + ' .box-opinion').addClass('no-display');
	$('#social-' + box + ' .box-opinion').prev().removeClass('box-commentSpace');

    }

    if (box == 'RecordReview' && !$('#social-' + box + ' .box-opinion').hasClass('no-display')) {
	$('#social-' + box + ' .box-opinion').addClass('no-display');
	$('#social-' + box + ' .box-opinion').prev().removeClass('box-commentSpace');

    }
    rsi.next();

    $(btn).parent().prev().children().removeClass('slide-button-prev-disabled');
    if (rsi.numSlides == rsi.currSlideId + 1) {
	$(btn).addClass('slide-button-next-disabled');
    } else {
	$(btn).removeClass('slide-button-next-disabled');
    }

    cropText('#social-' + box + ' .cropText');
}

function royalSlidePrev(btn, box) {
    var rsi;
    switch (box) {
	case 'record':
	    rsi = rsi_record;
	    break;
	case 'event':
	    rsi = rsi_event;
	    break;
	case 'album':
	    rsi = rsi_album;
	    break;
	case 'RecordReview':
	    rsi = rsi_recordReview;
	    break;
	case 'EventReview':
	    rsi = rsi_eventReview;
	    break;
	default:
	    break;
    }

    if (box == 'EventReview' && !$('#social-' + box + ' .box-opinion').hasClass('no-display')) {
	$('#social-' + box + ' .box-opinion').addClass('no-display');
	$('#social-' + box + ' .box-opinion').prev().removeClass('box-commentSpace');
    }

    if (box == 'RecordReview' && !$('#social-' + box + ' .box-opinion').hasClass('no-display')) {
	$('#social-' + box + ' .box-opinion').addClass('no-display');
	$('#social-' + box + ' .box-opinion').prev().removeClass('box-commentSpace');
    }
    rsi.prev();
    $(btn).parent().next().children().removeClass('slide-button-next-disabled');
    if (rsi.currSlideId == 0) {
	$(btn).addClass('slide-button-prev-disabled');
    } else {
	$(btn).removeClass('slide-button-prev-disabled');
    }


    cropText('#social-' + box + ' .cropText');


}


// gestione button READ recordReview
var toggleTextRecordReview = function(_this, box) {
    typeOpt = $(_this).text();
    $('#' + box + ' .textReview').slideToggle(300, function() {
	if (typeOpt == 'Read') {
	    $(_this).text('Close');
	    if (rsi_recordReview)
		rsi_recordReview.updateSliderSize(true);
	}
	else {
	    if (rsi_recordReview)
		rsi_recordReview.updateSliderSize(false);
	    $(_this).text('Read');
	}
    });

}
// gestione button READ eventReview
var toggleTextEventReview = function(_this, box) {
    typeOpt = $(_this).text();
    $('#' + box + ' .textReview').slideToggle(300, function() {
	if (typeOpt == 'Read') {
	    $(_this).text('Close');
	    if (rsi_eventReview)
		rsi_eventReview.updateSliderSize(true);
	}
	else {
	    if (rsi_eventReview)
		rsi_eventReview.updateSliderSize(false);
	    $(_this).text('Read');
	}
    });

}


//lightbox photo
function lightBoxPhoto(classBox) {

    $("." + classBox).colorbox({
	rel: 'group',
	inline: true,
	scalePhotos: true,
	width: '70%',
	fixed: true,
	scrolling: true,
	onComplete: function() {
	    if (!$('#cboxLoadedContent box-comment').hasClass('no-display')) {
		$('#cboxLoadedContent .box-comment').addClass('no-display');
		$('#cboxLoadedContent .box').removeClass('box-commentSpace');
		$("#cboxLoadedContent").mCustomScrollbar("update");
	    }
	    //posiziona la foto al centro su una base di altezza pari a 450px
	    var height = parseInt($('#cboxLoadedContent img').height());
	    if (height < 450) {
		divisione = ~~(height / 2);
		altezza = Math.abs(225 - divisione);
		$('#cboxLoadedContent img').css({'margin-top': altezza + 'px'});
	    }
	    getScrollBar("#cboxLoadedContent");
	    document.getElementById('cboxNext').setAttribute("onclick", "nextLightBox()");
	    document.getElementById('cboxPrevious').setAttribute("onclick", "prevLightBox()");
	    $("#cboxNext").unbind("click");
	    $("#cboxPrevious").unbind("click");

	},
	onClosed: function() {
	    $("#cboxLoadedContent").mCustomScrollbar("destroy");
	}
    });

}

function nextLightBox() {
    $('#cboxLoadedContent .box-comment').addClass('no-display');
    $('#cboxLoadedContent .box').removeClass('box-commentSpace');
    $("#cboxLoadedContent").mCustomScrollbar("update");
    $.colorbox.next();
}

function prevLightBox() {
    $('#cboxLoadedContent .box-comment').addClass('no-display');
    $('#cboxLoadedContent .box').removeClass('box-commentSpace');
    $("#cboxLoadedContent").mCustomScrollbar("update");
    $.colorbox.prev();
}

//visualizza la map del box information delle venue
var mapProfile;
function initialize(lat, lon) {
    var latlng = new google.maps.LatLng(lat, lon);
    var mapOptions = {
	zoom: 12,
	center: latlng,
	disableDefaultUI: true,
	mapTypeId: google.maps.MapTypeId.ROADMAP
    }

    mapProfile = new google.maps.Map(document.getElementById('map_venue'), mapOptions);
    var marker = new google.maps.Marker({
	position: latlng,
	map: mapProfile
    });
}

function viewMap(lat, lon) {
    if (mapProfile) {
	google.maps.visualRefresh = true;
    }
    else {
	google.maps.event.addDomListener(window, 'load', initialize(lat, lon));
    }
}



function getDirectionMap() {

}

function openComment() {
    $('.box').slideToggle(600, 'swing', resizeScroll);
}

/*
 * lancia lo spinner del profile
 */
function goSpinnerBox(id, box) {
    $(id).load('content/profile/box/box-spinner.php', {
	'box': box
    }, function() {
	success:{
	    spinner();
	    hcento();
	}
    });
}

function cropText(box) {

    if (box == null)
	box = '.cropText';

    $(box).each(function(index, element) {

	if ($(this).text().length > 170 && !$(this).children().hasClass('viewText')) {

	    textCrop = $(this).text().substr(0, 170);

	    textCrop = textCrop + '... ';

	    $(this).text(textCrop);

	    $(this).next().removeClass('no-display');

	    $(this).next().appendTo(this);

	    $(this).next().addClass('no-display');

	}


    });


}


/*
 * funzione per le stelline del rating
 */
$('.auto-submit-star').rating({callback: function(value, link) {
	alert(value);
    }});

