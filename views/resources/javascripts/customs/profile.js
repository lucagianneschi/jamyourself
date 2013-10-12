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
		 	var idBox = '';
			if(classbox == 'RecordReview' || classbox == 'EventReview'){
				idBox = '#social-'+classbox;
			}
			if(classbox == 'Album' || classbox == 'Record'){
				idBox = '#profile-'+classbox;
			}
			if(classbox == 'Image' || classbox == 'Post'){
				idBox = '#'+objectId;
			}
			
			if($(idBox+' .box-comment').hasClass('no-display')){
				$(idBox+' .box-comment').removeClass('no-display');
				$(idBox+' .box').addClass('box-commentSpace');
				
				callBox.objectId = 	objectId;					
				callBox.classBox = classbox;
				
				callBox.load('comment');
				
			}
			else{
				$(idBox+' .box-comment').addClass('no-display');
				$(idBox+' .box').removeClass('box-commentSpace');
			}
			
			//$(idBox+' .box').toggleClass('box-commentSpace');
	
			//$(idBox+' .box-comment').toggle(function(){});	
			
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


 
function slideReview(idBox) {
var rsi = $('#' + idBox).royalSlider({
		arrowsNav : false,
		arrowsNavAutoHide : false,
		navigateByClick: false,
		fadeinLoadedSlide : false,
		controlNavigationSpacing : 0,
		controlNavigation : 'none',
		imageScaleMode : 'none',
		imageAlignCenter : false,
		blockLoop : false,
		loop : false,
		numImagesToPreload : 6,
		transitionType : 'fade',
		keyboardNavEnabled : true,
		autoHeight: true,
		block : {
			delay : 400
		}
	}).data('royalSlider');
	return rsi;
}

function royalSlideNext(box){
	var rsi;
	switch(box) {
		case 'record':
		rsi = rsi_record;
		break;
		case 'event':
		rsi = rsi_event;
		break;
		case 'album':
		rsi = rsi_album;
		break;
		default:
		break;
	}
	rsi.next();
   	
  
}

function royalSlidePrev(box){
	var rsi;
	switch(box) {
		case 'record':
		rsi = rsi_record;
		break;
		case 'event':
		rsi = rsi_event;
		break;
		case 'album':
		rsi = rsi_album;
		break;
		case 'recordReview':
		rsi = rsi_recordReview;
		break;
		case 'eventReview':
		rsi = rsi_eventReview;
		break;
		default:
		break;
	}
	rsi.prev();
	
 }


// gestione button READ recordReview
var toggleTextRecordReview = function(_this,box){
	typeOpt = $(_this).text();	
	$('#'+box+' .textReview').toggle(function() {
		if(typeOpt == 'Read'){
			$(_this).text('Close');
			rsi_recordReview.updateSliderSize(true);
		}
		else{
			rsi_recordReview.updateSliderSize(false);
			$(_this).text('Read');	
		} 
	});	
	
}
// gestione button READ eventReview
var toggleTextEventReview = function(_this,box){
	typeOpt = $(_this).text();	
	$('#'+box+' .textReview').toggle(function() {
		if(typeOpt == 'Read'){
			$(_this).text('Close');
			rsi_eventReview.updateSliderSize(true);
		}
		else{
			rsi_eventReview.updateSliderSize(false);
			$(_this).text('Read');	
		} 
	});	
	
}
//lightbox photo
function lightBoxPhoto(classBox){
	$("."+classBox).colorbox({
			rel:'group',
			inline:true, 
			height: '650px',
			width: '100%',
			scrolling: true,
			onComplete: function(){
								
			 	
			}
		});
		
}

//visualizza la map del box information delle venue
function initialize(lat, lon) {	
	var latlng = new google.maps.LatLng(lat, lon);
	var mapOptions = {
		zoom : 12,
		center : latlng,
		disableDefaultUI: true,
		mapTypeId : google.maps.MapTypeId.ROADMAP		
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


function getDirectionMap(){
		
}

function openComment() {
	$('.box').slideToggle(600, 'swing', resizeScroll);
}


