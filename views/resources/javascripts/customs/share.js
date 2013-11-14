var addthis_config = {
	"data_track_addressbar":true
};
var addthis_share = {
	url_transforms : {
		shorten: {
			twitter: 'bitly'
		}
	}, 
	shorteners : {
		bitly : {}
	}
}

/*
 * chiamata bottone share
 */

var delay = 1000;
		    
function hideMenu(box) {
    if (!$(box).data('in')) {
        $(box).fadeOut('fast');
    }
}
function share(_this,id,box){
	var idbox = '';
		
	if(box != 'profile-Image'){
		idbox = box;		
		var positionTop = $('#'+idbox+ ' .box').height();
		positionTop = positionTop + 40;
		var position = $(_this).position();
		positionLeft = position.left + 60; 
	 	$( '#'+idbox+ ' .hover_menu' ).css({'left':positionLeft}); 	
	 	$( '#'+idbox+ ' .hover_menu' ).css({'top':positionTop});
	
 	}
 	else{
 		idbox = id;
 		var position = $(_this).position();
		$( '#'+idbox+ ' .hover_menu' ).css({'top':-40}); 
		$( '#'+idbox+ ' .hover_menu' ).css({'left':-220}); 		
 	} 	
 	
	$( '#'+idbox+ ' .hover_menu' ).fadeIn('fast');
 	$( '#'+idbox+ ' .hover_menu' ).mouseleave(function() {
		$(this).data('in', false);
    	setTimeout(hideMenu('#'+idbox+ ' .hover_menu'), delay);
    });
    	
}
