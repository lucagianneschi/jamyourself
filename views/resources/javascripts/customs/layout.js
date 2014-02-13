
$(document).ready(function() {

    var widthWindow = window.innerWidth;
    showOneProfile(widthWindow);
    hcento();
    /*
     if($('.switch').is(':visible')){
     switch_stat = 1;
     showSwich();
     }
     */
    //$("#profile").niceScroll({cursorcolor:"#222",cursorborder:"none",zindex:3,horizrailenabled: "false",cursorwidth:8,cursoropacitymax:0.4});
    //$("#social").niceScroll({cursorcolor:"#CCC",cursorborder:"none",zindex:3,horizrailenabled: "false",cursorwidth:8,cursoropacitymax:0.4});

    $("#scroll-profile").mCustomScrollbar({
	autoHideScrollbar: false,
	mouseWheel: true,
	scrollInertia: 100,
	advanced: {
	    autoScrollOnFocus: false,
	    updateOnContentResize: true,
	}
    });
    $("#scroll-social").mCustomScrollbar({
	autoHideScrollbar: false,
	mouseWheel: true,
	scrollInertia: 100,
	advanced: {
	    autoScrollOnFocus: false,
	    updateOnContentResize: true,
	}
    });

    //permette di modifica il background del body in base al file php caricato in index
    var children = $(".body-content").children();


    if (children.hasClass('bg-double')) {
	$("body").addClass("bg-double");
    }
    if (children.hasClass('bg-grey-dark')) {
	$("body").addClass("bg-grey-dark");
    }
    if (children.hasClass('bg-white')) {
	$("body").addClass("bg-white");
    }

});

/*
 * visualizza solo una parte del profile a seconda della dimensione dalla pagina
 */
function showOneProfile(width) {
    if (width < 889) {
	$('#header-box-switch').removeClass('no-display');
	$('#header-box-switch').addClass('small-5');
	$('#header-box-switch').removeClass('small-9');
	$('#header-box-switch').css({'margin-left': 0})
	$('#header-box-logo').addClass('no-display');
	$('#header-box-thum').addClass('no-display');
	$('#header-box-player').addClass('no-display');
	$('#header-box-menu').removeClass('large-5');
	$('#header-box-menu').addClass('large-1');
	$('#header-btn-search').attr("placeholder", "Cerca..");
	$('#header-btn-search').attr('style', 'width:150px !important');
	$('#header-box-search').removeClass('large-5');
	$('#header-box-search').addClass('large-6');
	$('#header-box-search').removeClass('no-display');
	if (width < 377) {
	    $('#header-box-search').addClass('no-display');
	    $('#header-box-switch').removeClass('small-5');
	    $('#header-box-switch').addClass('small-9');
	    $('#header-box-switch').css({'margin-left': 20})
	}
	showSwich();

    }

    else {
	if (width < 980) {
	    $('#header-btn-search').attr("placeholder", "Cerca..");
	    $('#header-btn-search').attr('style', 'width:150px !important');
	    $('#header-box-search').removeClass('large-5');
	    $('#header-box-search').addClass('large-6');
	}
	else {
	    $('#header-btn-search').attr("placeholder", "Cerca persone, musica o eventi");
	    $('#header-btn-search').attr('style', 'width:235px !important');
	}
	$('#header-box-switch').addClass('no-display');
	$('#header-box-logo').removeClass('no-display');
	$('#header-box-thum').removeClass('no-display');
	$('#header-box-player').removeClass('no-display');
	$('#header-box-menu').addClass('large-5');
	$('#header-box-menu').removeClass('large-1');
	$('#header-box-search').removeClass('large-6');
	$('#header-box-search').addClass('large-5');
	$('#header-box-search').removeClass('no-display');
	hideSwich();

    }
}

/* RESIZE */
$(window).resize(function() {
    showOneProfile(window.innerWidth);
});

// hcento() imposta le altezze rispetto alla viewport	
function hcento() {
    var h = $(window).height();
    var hr = h - 80;
    var hrhero = h - 300;
    $('.hcento').css('height', hr);
//	$('.hcento-hero').css('height', hrhero); 
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
	//$('#header-hide').height();
    });
    rsi_not.updateSliderSize(true);
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
function showSwich() {
    console.log('---------------------' + (switch_stat));
    if (switch_stat == 1) {
	$('#scroll-profile').show();
	$('#scroll-social').hide();
	$('#scroll-profile').addClass('bg-grey-dark');
	$('#scroll-profile').attr('style', 'width:100% !important;float: center !important');
	//$('#scroll-profile').attr('style', 'float: center !important');
	$('#profile').css({'float': 'center'});
	hcento();
    }
    else {
	$('#scroll-social').show();
	$('#scroll-profile').hide();
	$('#scroll-social').addClass('bg-white');
	$('#scroll-social').attr('style', 'width:100% !important;float: center !important');
	//	$('#scroll-social').attr('style', 'float: center !important');
	$('#social').css({'float': 'center'});
	hcento();
    }
}

function hideSwich() {
    $('#scroll-profile').show();
    $('#scroll-social').show();
    $('#scroll-profile').attr('style', 'width: 50%;float: left');
    $('#scroll-social').attr('style', 'width: 50%;float: right;');
    $('#profile').css({'float': 'right'});
    $('#social').css({'float': 'left'});
    hcento();
    switch_stat = 1;
}


function getSwich() {
    if (switch_stat == 1)
	switch_stat = 0;
    else
	switch_stat = 1;
    showSwich();

}




// scroll
function getScroll(name) {
    $(name).getNiceScroll().doScrollPos(0, 580, 1500);
}

function resizeScroll() {
    //$('#profile').getNiceScroll().resize();
    //$('#social').getNiceScroll().resize();
    $("#scroll-profile").mCustomScrollbar("update");
    $("#scroll-social").mCustomScrollbar("update");
}

function scrollto(id) {
    $('html,body').animate({
	scrollTop: $('#' + id).offset().top - 50
    }, 'slow');
}
;









