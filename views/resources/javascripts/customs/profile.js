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

	$("#social_list_achievement").touchCarousel({
		pagingNav : false,
		snapToItems : true,
		itemsPerMove : 1,
		scrollToLast : false,
		loopItems : false,
		scrollbar : false
	});

	$(".royalSlider").royalSlider({
		// options go here
		// as an example, enable keyboard arrows nav
		keyboardNavEnabled : true,
		startSlideId : 2,
		controlNavigation : 'none',

	});
	 

});
/*
 * Funzione per gestire i counters (love, comment, shere e review)
 * 
 */
function setCounter(_this, objectId, classbox){	
	typeOpt = $(_this).text();
	switch(typeOpt) {
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
		case 'Comment':
			parent = $(_this).parent().parent().parent().parent().parent();
			box = $(_this).parent().parent().parent().parent();
			boxComment = $(parent).find('.box-comment');			
			if ($(boxComment).hasClass('no-display')) {
				$(box).css({
					'margin-bottom' : '0px'
				});
				$(boxComment).removeClass('no-display');
			} else {
				$(box).css({
					'margin-bottom' : '40px'
				});
				$(boxComment).addClass('no-display');
			}
			break;
		default:
			console.log(typeOpt);
	}
	
}

function slideAchievement(){	
	$("#social_list_achievement").touchCarousel({
		pagingNav : false,
		snapToItems : true,
		itemsPerMove : 1,
		scrollToLast : false,
		loopItems : false,
		scrollbar : false
	});
}

	

//funzione per gestire la visualizzazione dell'album
function recordSelectSingle(recordId) {
 	$( "#record-list" ).fadeOut( 100, function() {
    		$('.'+recordId).fadeIn( 100 );
	});
}
//nasconde foto singolo album e visualizza lista album
function recordSelectNext(recordId){		
	$('.'+recordId ).fadeOut( 100, function() {
    	$('#record-list').fadeIn( 100 );
	});	
}



//visualizza foto di singolo album e nasconde lista album
function albumSelectSingle(albumcover,num) {
	//effettua transizione se ci sono foto all'interno dell'album
	if(num>0) {		
		 $( "#albumSlide" ).fadeOut( 100, function() {
    		$('#'+albumcover ).fadeIn( 100 );
		});
	}
	
}
//nasconde foto singolo album e visualizza lista album
function albumSelectNext(recordId){		
	$('#'+recordId ).fadeOut( 100, function() {
    	$('#albumSlide').fadeIn( 100 );
	});	
}


 
// record review
var toggleText = function(_this){
	typeOpt = $(_this).text();
	parent = $(_this).parent().parent().parent().next();
	$(parent).toggle(function() {
		if(typeOpt == 'Read'){
			console.log($(_this).parent().parent().parent().parent().height());
			rsi.height = $(_this).parent().parent().parent().parent().height();
			$(_this).text('Close');
		} 
		else $(_this).text('Read');	
	});	
}

//lightbox photo
function lightBoxPhoto(classBox){
	$("."+classBox).colorbox({
			rel:'group',
			inline:true, 
			width: '600px',
			scrolling: true,
			onComplete: function(){
			 	$(this).niceScroll({cursorcolor:"#222",cursorborder:"none",zindex:3,horizrailenabled: "false",cursorwidth:8,cursoropacitymax:0.4});
			}
		});
		
}

//visualizza la map del box information delle venue
function initialize(lat, lon) {	
	var latlng = new google.maps.LatLng(lat, lon);
	var mapOptions = {
		zoom : 15,
		center : latlng
		//mapTypeId : google.maps.MapTypeId.ROADMAP		
	}
	
	var map = new google.maps.Map(document.getElementById('map_venue'), mapOptions);
	var marker = new google.maps.Marker({
		position : latlng,
		map : map
	});
	google.maps.event.trigger(map, 'resize');	
}

function viewMap(lat, lon){
	google.maps.event.addDomListener(window, 'load', initialize(lat, lon));
	
}

function removeMap(){
	//$("#map_venue").empty();
}
//google.maps.event.addDomListener(window, 'load', viewMap(lat, lon));

function getDirectionMap(){
		
}

function openComment() {
	$('.box').slideToggle(600, 'swing', resizeScroll);
}