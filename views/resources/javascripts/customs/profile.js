$(document).ready(function() {
	//--------- propriety element --------------
	//------------- LOVE ----------------------
	$('.box-propriety a').click(function() {
		typeOpt = $(this).text();
		switch(typeOpt) {
			case 'Love':
				parent = $(this).parent().parent();
				objectLove = $(parent).find("a._unlove");
				$(objectLove).toggleClass('orange grey');
				var number_love = parseInt($(objectLove).text(), 10);
				$(objectLove).text(number_love + 1);
				$(objectLove).toggleClass('_love _unlove');
				$(this).text('Unlove');
				break;
			case 'Unlove':
				parent = $(this).parent().parent();
				objectLove = $(parent).find("a._love");
				$(objectLove).toggleClass('grey orange');
				var number_love = parseInt($(objectLove).text(), 10);
				$(objectLove).text(number_love - 1);
				$(objectLove).toggleClass('_unlove _love');
				$(this).text('Love');
				break;
			case 'Comment':
				parent = $(this).parent().parent().parent().parent();

				if ($(parent.next()).hasClass('no-display')) {
					$(parent).css({
						'margin-bottom' : '0px'
					});
					$(parent.next()).removeClass('no-display');
				} else {
					$(parent).css({
						'margin-bottom' : '40px'
					});
					$(parent.next()).addClass('no-display');
				}
				break;
			default:
				console.log(typeOpt);
		}

	});

	$('#album-single ._back_page').click(function() {
		//	$('#album-list').show('slide', { direction: "left" }, "slow");
		$('#album-single').hide('slide', {
			direction : "right"
		}, "slow");
		setTimeout(function() {
			$('#album-list').show('slide', {
				direction : "left"
			}, "slow");
		}, 600);
	});
	$('#albumcover-single ._back_page').click(function() {
		//$('#albumcover-list').show('slide', { direction: "left" }, "slow");
		$('#albumcover-single').hide('slide', {
			direction : "right"
		}, "slow");
		setTimeout(function() {
			$('#albumcover-list').show('slide', {
				direction : "left"
			}, "slow");
		}, 600);
	});

	

	$('#profile_map_venue').click(function() {
		if (!$(this).hasClass('active')) {
			//viewMap();
		} else {
			$('#map_venue').html("");
		}
	});

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
function albumSelect(recordId) {
	$('#album-list').hide('slide', {
		direction : "left"
	}, "slow");
	setTimeout(function() {
		$('.'+recordId).show('slide', {
			direction : "right"
		}, "slow");
	}, 600);

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

function photo(photo) {

}
var rsi;
function slideReview(idBox) {
 rsi = $('#' + idBox).royalSlider({
		arrowsNav : false,
		arrowsNavAutoHide : false,
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
	
}

function royalSlideNext(_this,id){
	$(_this).click(function() {
   		rsi.next();
   		$('#'+id+' .indexBox').text(rsi.currSlideId+1);
  	});
}
function royalSlidePrev(_this,id){
  $(_this).click(function() {
    rsi.prev();
    $('#'+id+' .indexBox').text(rsi.currSlideId+1);  
    console.log(rsi);  
    console.log(rsi.height);
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
function viewMap(lat, lon) {
	/*var latlng = new google.maps.LatLng(lat, lon);
	 geoCode = new google.maps.Geocoder();
	 // segnapunto
	 // definizione della mappa
	 var myOptions = {
	 zoom : 15,
	 center : latlng,
	 mapTypeId : google.maps.MapTypeId.ROADMAP,
	 mapTypeControlOptions : {
	 style : google.maps.MapTypeControlStyle.HORIZONTAL_BAR
	 }
	 }
	 mymap = new google.maps.Map(document.getElementById("map_venue"), myOptions);
	 // definizione segnapunto
	 var marker = new google.maps.Marker({
	 position : latlng,
	 map : mymap
	 });
	 console.log(myOptions);
	 */
	geocoder = new google.maps.Geocoder();
	var latlng = new google.maps.LatLng(lat, lon);
	var mapOptions = {
		zoom : 15,
		center : latlng,
		mapTypeId : google.maps.MapTypeId.ROADMAP		
	}
	map = new google.maps.Map(document.getElementById('map_venue'), mapOptions);
	var marker = new google.maps.Marker({
		position : latlng,
		map : map
	});
	
}

function openComment() {
	$('.box').slideToggle(600, 'swing', resizeScroll);
}