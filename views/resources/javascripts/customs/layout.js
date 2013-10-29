
$(document).ready(function() {
	
	
	hcento();
	
	if($('.switch').is(':visible')){
		switch_stat = 1;
		jamswitch();
	}
	
	//$("#profile").niceScroll({cursorcolor:"#222",cursorborder:"none",zindex:3,horizrailenabled: "false",cursorwidth:8,cursoropacitymax:0.4});
	//$("#social").niceScroll({cursorcolor:"#CCC",cursorborder:"none",zindex:3,horizrailenabled: "false",cursorwidth:8,cursoropacitymax:0.4});
	
	$("#scroll-profile").mCustomScrollbar({
		updateOnContentResize: true,
		autoHideScrollbar:false,
		mouseWheel: true,
		scrollInertia:150,
		advanced:{
			autoScrollOnFocus: false
		}
	});
	$("#scroll-social").mCustomScrollbar({
		updateOnContentResize: true,
		autoHideScrollbar:false,
		mouseWheel: true,
		scrollInertia:150,
		advanced:{
			autoScrollOnFocus: false
		}
	});
		
	//permette di modifica il background del body in base al file php caricato in index
	var children = $(".body-content").children();
	if(children.hasClass('bg-grey-dark')){
		$("body").addClass("bg-grey-dark");
	}
	else{
		$("body").addClass("bg-double");
	}
	

	
	
	
});
/* RESIZE */
$(window).resize(function(){	
	hcento();
	if($('.switch').is(':visible')){
		jamswitch();
	}
	else{
		$('#social').show();
		$('#profile').show();
	}
});

// hcento() imposta le altezze rispetto alla viewport	
function hcento() {
	var h = $(window).height();
	var hr = h - 80;
	var hrhero = h - 300;
	$('.hcento').css('height', hr);
	$('.hcento-hero').css('height', hrhero); 
	$("#scroll-profile").mCustomScrollbar("update");
	$("#scroll-social").mCustomScrollbar("update");
}

//Show header
function headerShow() {
	
 	$('#header-hide').slideToggle('slow', function() {
 	//$("#profile").getNiceScroll().resize();
 	//$("#social").getNiceScroll().resize();
 	$("#scroll-profile").mCustomScrollbar("update");
	$("#scroll-social").mCustomScrollbar("update");
    // Animation complete.
  		$('#header-hide').height();
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





// scroll
function getScroll(name) {
	$(name).getNiceScroll().doScrollPos(0,580,1500);
}

function resizeScroll() {
	//$('#profile').getNiceScroll().resize();
	//$('#social').getNiceScroll().resize();
	$("#scroll-profile").mCustomScrollbar("update");
	$("#scroll-social").mCustomScrollbar("update");
}

function scrollto(id) {
	$('html,body').animate({
		scrollTop: $('#'+id).offset().top - 50 
	}, 'slow');
};








