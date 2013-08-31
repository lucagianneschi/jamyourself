$(document).ready(function() {
	//--------- propriety element --------------
	//------------- LOVE ---------------------- 	
	$('.box-propriety a').click(function() {
		typeOpt = $(this).text();
		switch(typeOpt){
		case 'Love':
		  	parent = $(this).parent().parent();
			objectLove = $(parent).find("a._unlove");			
			$(objectLove).toggleClass('orange grey');
			var number_love = parseInt($(objectLove).text(),10);
			$(objectLove).text(number_love+1);
			$(objectLove).toggleClass('_love _unlove');
			$(this).text('Unlove');
		    break;
		case 'Unlove':		  	
			parent = $(this).parent().parent();
			objectLove = $(parent).find("a._love");				
			$(objectLove).toggleClass('grey orange');
			var number_love = parseInt($(objectLove).text(),10);
			$(objectLove).text(number_love-1);
			$(objectLove).toggleClass('_unlove _love');
			$(this).text('Love');
		    break;
		default:
		  console.log(typeOpt);
		}
			
		
	});
	
		
	
	$('#album-single ._back_page').click(function() {
	//	$('#album-list').show('slide', { direction: "left" }, "slow");		
		$('#album-single').hide('slide', { direction: "right" }, "slow");
		setTimeout(function() {
       		$('#album-list').show('slide', { direction: "left" }, "slow");     
      	}, 600 );
	});
	$('#albumcover-single ._back_page').click(function() {
		//$('#albumcover-list').show('slide', { direction: "left" }, "slow");
		$('#albumcover-single').hide('slide', { direction: "right" }, "slow");
		setTimeout(function() {
       		$('#albumcover-list').show('slide', { direction: "left" }, "slow");     
      	}, 600 );
	});
	
	$('.track').mouseover(function() {
		var track = '#'+$(this).attr('id');
		$(track+' .track-propriety').show();
	});
	
	$('.track').mouseout(function() {
		$('.track-propriety').hide();
	});
	
	$('#profile_map_venue').click(function () {
	 	if(!$(this).hasClass('active')){
	 		viewMap();
	 	}
	 	else{
	 		$('#map_venue').html("");
	 	}
	});
	
	/*
	 * apertura e chiusura testo review album e eventi social 
	 */
	$('.viewAlbumReview a').toggle(function(){		
		$('.textAlbumReview').removeClass('no-display');
		$('.viewAlbumReview a strong').text('Close');
		
	}, function () {  
		$('.textAlbumReview').addClass('no-display');
		$('.viewAlbumReview a strong').text('Read');
	});
	
	$('.viewEventReview a').toggle(function(){		
		$('.textEventReview').removeClass('no-display');
		$('.viewEventReview a strong').text('Close');
		
	}, function () {  
		$('.textEventReview').addClass('no-display');
		$('.viewEventReview a strong').text('Read');
	});
	
	$("#social_list_achievement").touchCarousel({			
				pagingNav: false,
				snapToItems: true,
				itemsPerMove: 1,				
				scrollToLast: false,
				loopItems: false,
				scrollbar: false	
			});
	

});

//funzione per gestire la visualizzazione dell'album
function albumSelect(album){	
	$('#album-list').hide('slide', { direction: "left" }, "slow");
	setTimeout(function() {
       $('#album-single').show('slide', { direction: "right" }, "slow");     
      }, 600 );
	
	
}

//funzione per gestire la visualizzazione della cover
function albumcover(albumcover){
	$('#albumcover-list').hide('slide', { direction: "left" }, "slow");
	setTimeout(function() {
       $('#albumcover-single').show('slide', { direction: "right" }, "slow");     
      }, 600 );
}

function photo(photo){
	
}

//visualizza la map del box information delle venue
function viewMap(){
	 var latlng = new google.maps.LatLng(44.645000,7.490000); // centro della mappa
     var myLatlng = new google.maps.LatLng(44.645000,7.490000); // segnapunto
     // definizione della mappa
     var myOptions = {
         zoom: 15,
         center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR}
     }
     mymap = new google.maps.Map(document.getElementById("map_venue"), myOptions);
     // definizione segnapunto
     var marker = new google.maps.Marker({
        position: myLatlng,
        map: mymap,
        title:"Nome Venue"
     });
}

function openComment(){
	$('.box').slideToggle(600, 'swing', resizeScroll);	
}