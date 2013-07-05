$(document).ready(function() {
	
	hcento();
	
	if($('.switch').is(':visible')){
		switch_stat = 1;
		jamswitch();
	}
	$("#profile").niceScroll({cursorcolor:"#222",cursorborder:"none",zindex:3,horizrailenabled: "false",cursorwidth:8});
	$("#social").niceScroll({cursorcolor:"#CCC",cursorborder:"none",zindex:3,horizrailenabled: "false",cursorwidth:8});
	/*$("#profile").niceScroll({
		touchbehavior:false,
		cursorcolor:"#222",
		cursoropacitymax:0.4,
		cursorwidth:8,
		cursorborder:"none",
		cursorborderradius:"4px",
		background:"none",
		autohidemode:"false",
		horizrailenabled: "false",		
		zindex:3}).cursor.css({"background-image":"none"});
		console.log($("#profile").niceScroll());*/
	//$("#social").niceScroll({touchbehavior:false,cursorcolor:"#CCC",cursoropacitymax:0.4,cursorwidth:8,cursorborder:"none",cursorborderradius:"4px",background:"none",autohidemode:"false", zindex:3}).cursor.css({"background-image":"none"});	
	
	
	//permette di modifica il background del body in base al file php caricato in index
	var children = $(".body-content").children();
	if(children.hasClass('bg-grey-dark')){
		$("body").addClass("bg-grey-dark");
	}
	else{
		$("body").addClass("bg-double");
	}
	
	
	//--------- propriety element --------------
	//------------- LOVE ---------------------- 
	$('._love').click(function() {
		$(this).toggleClass('_love _unlove');
		$(this).toggleClass('orange grey');
		$(this).toggleClass(function() {
			var number_love = parseInt($(this).text(),10);
			  if ($(this).hasClass('_unlove')) {			  	
			  	// diminuisce
			   return $(this).text(number_love-1);
			  } else {
			  	
			  	//aumenta
			    return $(this).text(number_love+1);
			  }
		});
		
	});
	$('._unlove').click(function() {
		$(this).toggleClass('_unlove _love');
		$(this).toggleClass('grey orange');
		$(this).toggleClass(function() {
			var number_love = parseInt($(this).text(),10);
			  if ($(this).hasClass('_unlove')) {			  	
			  	// diminuisce
			   return $(this).text(number_love-1);
			  } else {
			  	
			  	//aumenta
			    return $(this).text(number_love+1);
			  }
		});
		
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
		console.log($(this).attr('id'));
		var track = '#'+$(this).attr('id');
		$(track+' .track-propriety').show();
	});
	
	$('.track').mouseout(function() {
		$('.track-propriety').hide();
	});
	
});
/* RESIZE */
$(window).resize(function(){	
	hcento();
	if($('.switch').is(':visible')){
		console.log("ok");
		jamswitch();
	}
	else{
		$('#social').show();
		$('#profile').show();
	}
});

//Show header
function headerShow() {
	
 	$('#header-hide').slideToggle('slow', function() {
 		$("#profile").getNiceScroll().resize();
 		$("#social").getNiceScroll().resize();
    // Animation complete.
  		console.log($('#header-hide').height());
  	});
	
}

//Show footer
function footerShow() {
	/*
 	$('#header-hide').slideToggle('slow', function() {
 		$("#profile").getNiceScroll().resize();
 		$("#social").getNiceScroll().resize();
    // Animation complete.
  		console.log($('#header-hide').height());
  	});*/
  	$('#footer-body').slideToggle(600, 'swing', resizeScroll);
	
}

//gestisce lo switch per la versione mobile (profile -> social, social->profile)
var switch_stat = 1;
function jamswitch() {
			
	if ( switch_stat == 1 ) {
		$('#profile').hide();
		$('#social').show();
		$('#social').css('backgroundColor', '#F3F3F3');
		switch_stat = 0;
	} else {
		$('#profile').show();
		$('#social').hide();
		$('#profile').css('backgroundColor', '#303030');
		switch_stat = 1;
	}
}

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

// hcento() imposta le altezze rispetto alla viewport	
function hcento() {
	var h = $(window).height();
	var hr = h - 45;
	var hrhero = h - 300;
	$('.hcento').css('height', hr);
	$('.hcento-hero').css('height', hrhero);              
}


// scroll
function getScroll(name) {
	$(name).getNiceScroll().doScrollPos(0,580,1500);
}

function resizeScroll() {
	$('#profile').getNiceScroll().resize();
	$('#social').getNiceScroll().resize();
}

function openComment(){
	$('.box').slideToggle(600, 'swing', resizeScroll);
	
}

