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

function addShare(toUser, classType, objectId) {
	var json_share = {};
	json_share.toUser = toUser;
	json_share.classType = classType;
	json_share.objectId = objectId;
	json_share.request = 'addShare';
	
	$.ajax({
        type: "POST",
        url: "../../../controllers/request/socialRequest.php",
        data: json_share
    })
	.done(function(message, status, xhr) {
		code = xhr.status;
		console.log("Code: " + code + " | Message: " + message);
	})
	.fail(function(xhr) {
		message = $.parseJSON(xhr.responseText).status;
		code = xhr.status;
		console.log("Code: " + code + " | Message: " + message);
	});
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
	var hover = '';
	switch(box){
		case 'profile-Image':
			idbox = id;
			hover = '#'+idbox+ ' .hover_menu';
			$( hover ).css({'top':-40}); 
			$( hover ).css({'left':-220});
		break;
		case 'profile-Record':
			idbox = box;		
			hover = '#'+idbox+ ' .hover_menu.hover_record';
		break;
		case 'Song':
			idbox = id;
			hover = '#'+idbox+ ' .hover_menu';
			$( hover ).css({'top':20}); 
			$( hover ).css({'left':80});	
		break;
		default:
			idbox = box;
			hover = '#'+idbox+ ' .hover_menu';		
			var positionTop = $('#'+idbox+ ' .box').height();
			positionTop = positionTop + 40;
			var position = $(_this).position();
			positionLeft = position.left + 60; 
		 	$( hover ).css({'left':positionLeft}); 	
		 	$( hover ).css({'top':positionTop});
		break;
	}
	/*	
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
 		 		
 	} 	
 	*/
	$( hover ).fadeIn('fast');
 	$( hover ).mouseleave(function() {
		$(this).data('in', false);
    	setTimeout(hideMenu(hover), delay);
    });
    	
}
