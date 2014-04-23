//---------------- VALIDAZIONE FOUNDATION abide  ----------------------------- 
//------ espressioni regolari -------------------------------
var exp_username = /^([a-zA-Z0-9\s\xE0\xE8\xE9\xF9\xF2\xEC\x27][!""#$%&'()*+,-./:;<=>?[\]^_`{|}~]{0,0})*([a-zA-Z0-9\xE0\xE8\xE9\xF9\xF2\xEC\x27][!""#$%&'()*+,-./:;<=>?[\]^_`{|}~]{0,0})$/;
var exp_mail = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+[\.]([a-z0-9-]+)*([a-z]{2,3})$/;
var exp_password = /(^[a-zA-Z0-9]{7,})+([a-zA-Z0-9])$/;
var exp_description = /^([a-zA-Z0-9\s\xE0\xE8\xE9\xF9\xF2\xEC\x27!#$%&'()*+,-./:;<=>?[\]^_`{|}~][""]{0,0})*([a-zA-Z0-9\xE0\xE8\xE9\xF9\xF2\xEC\x27!#$%&'()*+,-./:;<=>?[\]^_`{|}~\s][""]{0,0})$/;
var exp_url = /(https?|ftp|file|ssh):\/\/(((([a-zA-Z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-zA-Z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-zA-Z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-zA-Z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-zA-Z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-zA-Z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-zA-Z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-zA-Z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-zA-Z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-zA-Z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-zA-Z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-zA-Z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-zA-Z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?/;

//------------ variabili generiche --------------------
var max_genre_spotter = 10;
var max_genre = 5;

var json_signup_user = {};
var uploader = null;

var maxCheck = 0;
//-------------- variabili per jcrop ----------------------//
var type_user,
	input_x,
	input_y,
	input_w,
	input_h,
	jcrop_api,
	boundx,
	boundy,
	xsize,
	ysize,
	preview,
	tumbnail,
	tumbnail_pane,
	validation_recaptcha = false;

$(document).ready(function() {

    var utente;

    //SCELTA TIPO UTENTE
    utente = selectTypeUser();

    //controllo validazione campi
    validateFields()
    validateUsername();
    validatePassword();
    validateCharacters('spotter-firstname');
    validateCharacters('spotter-lastname');


    // ------------------------ GESTIONE BOTTONI NEXT E BACK ------------------------------
    //prima scheda
    step1Next();
    step1Back();

    //seconda scheda - spotter
    step2NextSpotter();
    step2BackSpotter();

    //terza scheda - spotter
    step3NextSpotter();
    step3BackSpotter();

    //seconda scheda - jammer
    step2NextJammer();
    step2BackJammer();

    //terza scheda - jammer
    step3NextJammer();
    step3BackJammer();

    //seconda scheda - venue
    step2NextVenue();
    step2BackVenue();

    //terza scheda - venue
    step3NextVenue();
    step3BackVenue();
    // ------------------------ FINE GESTIONE BOTTONE NEXT E BACK ------------------------------

    /*
     * Permette di gestire i bottoni social, a seconda dell'icona che viene cliccata 
     * viene visualizzato l'imput text corrispodente
     */
    $('.signup-social-button a').click(function() {
	try {
	    $('.signup-social-button a').removeClass('signup-icon-social-focus');
	    $('.signup-social-button a').addClass('signup-icon-social');

	    $(this).removeClass('signup-icon-social');
	    $(this).addClass('signup-icon-social-focus');
	    var element = this;
	    $('.signup-social div div').each(function(i, val) {
		$(val).addClass('no-display');

	    });
	    if ($(element).hasClass('_facebook-double')) {
		$('.facebook-label').removeClass('no-display');
	    }
	    if ($(element).hasClass('_twitter-double')) {
		$('.twitter-label').removeClass('no-display');
	    }
	    if ($(element).hasClass('_google-double')) {
		$('.google-label').removeClass('no-display');
	    }
	    if ($(element).hasClass('_youtube-double')) {
		$('.youtube-label').removeClass('no-display');
	    }
	    if ($(element).hasClass('_web-double')) {
		$('.web-label').removeClass('no-display');
	    }
	} catch (err) {
	    window.console.error("Event click .signup-social-button a | An error occurred - message : " + err.message);
	}
    });


    $('.uploadImage_save').click(function() {
	try {
	    tumbnail = $('#' + type_user + '_uploadImage_tumbnail');

	    tumbnail.attr('src', preview.attr('src'));

	    thmImage = new Image()

	    thmImage.src = preview.attr('src');

	    var realwidth, realheight;

	    thmImage.onload = function() {
		realwidth = this.width;
		realheight = this.height;


		thm_w = Math.round(realwidth / $('#' + input_w).val() * xsize);
		thm_h = Math.round(realheight / $('#' + input_h).val() * ysize);

		console.log(realwidth + ' ' + $('#' + input_w).val() + ' ' + xsize + ' ' + thm_w);
		console.log(realheight + ' ' + $('#' + input_h).val() + ' ' + ysize + ' ' + thm_h);

		tumbnail.css({
		    width: thm_w + 'px',
		    height: thm_h + 'px',
		    marginLeft: '-' + Math.round(thm_w * ($('#' + input_x).val() / realwidth)) + 'px',
		    marginTop: '-' + Math.round(thm_h * ($('#' + input_y).val() / realheight)) + 'px'
		});

	    }

	    json_crop = {
		x: $('#' + input_x).val(),
		y: $('#' + input_y).val(),
		h: $('#' + input_h).val(),
		w: $('#' + input_w).val(),
	    };

	    json_signup_user.crop = json_crop;

	    $('#' + type_user + '-uploadImage').foundation('reveal', 'close');

	} catch (err) {
	    window.console.error("Event click .uploadImage_save | An error occurred - message : " + err.message);
	}
    });

    //----------------------------------- FINE SIGNUP -----------------------------------

    //creo il recaptcha all'interno del div "signup01-captcha"
    showCaptcha();
});


/*
 * Gestione bottone tipologia utente (jammer, venue, spotter)
 */
function selectTypeUser() {
    var typeUser;
    try {
	$('#signup01 label').click(function() {
	    typeUser = $(this).attr('for');

	    //noscondo la prima scheda signup01
	    $('#signup01').hide('slide', {direction: "left"}, "slow");

	    //visualizzo i blocchi che indicano lo step
	    $('.signup-labelStep').css({"display": "block"});

	    //visualizzo le label degli step 
	    viewStep1();

	    //UTENTE ----------- SPOTTER -----------------
	    if (typeUser == "signup-typeUser-spotter") {
		json_signup_user.type = "SPOTTER";
		initGeocomplete("#spotter-city");
		$('#signup01-username-spotter').removeClass('no-display');
		$('#spotter-signup01-next').removeClass('no-display');
		$('#signup-fb1').removeClass('no-display');
		$('#signup-fb2').removeClass('no-display');

		$('.signup-no-spotter').addClass('no-display');

		$('#signup01-username-jammer').addClass('no-display');
		$('#signup01-username-venue').addClass('no-display');

		$('#jammer-signup01-next').addClass('no-display');
		$('#venue-signup01-next').addClass('no-display');

		setTimeout(function() {
		    $('#signup01-signup01').show('slide', {direction: "right"}, "slow");
		}, 600);

	    }
	    //UTENTE ----------- JAMMER -----------------
	    if (typeUser == "signup-typeUser-jammer") {
		json_signup_user.type = "JAMMER";
		initGeocomplete("#jammer-city");
		$('#signup01-username-jammer').removeClass('no-display');
		$('#jammer-signup01-next').removeClass('no-display');
		$('.signup-no-spotter').removeClass('no-display');

		$('#signup-fb1').addClass('no-display');
		$('#signup-fb2').addClass('no-display');
		$('#signup01-username-spotter').addClass('no-display');
		$('#signup01-username-venue').addClass('no-display');
		$('#spotter-signup01-next').addClass('no-display');
		$('#venue-signup01-next').addClass('no-display');
		setTimeout(function() {
		    $('#signup01-signup01').show('slide', {direction: "right"}, "slow");
		}, 600);

	    }
	    //UTENTE ----------- venue -----------------
	    if (typeUser == "signup-typeUser-venue") {
		json_signup_user.type = "VENUE";
		initGeocomplete("#venue-city");
		$('#signup01-username-venue').removeClass('no-display');
		$('#venue-signup01-next').removeClass('no-display');
		$('.signup-no-spotter').removeClass('no-display');

		$('#signup-fb1').addClass('no-display');
		$('#signup-fb2').addClass('no-display');
		$('#signup01-username-spotter').addClass('no-display');
		$('#signup01-username-jammer').addClass('no-display');
		$('#jammer-signup01-next').addClass('no-display');
		$('#spotter-signup01-next').addClass('no-display');
		setTimeout(function() {
		    $('#signup01-signup01').show('slide', {direction: "right"}, "slow");
		}, 600);
	    }
	    //attivo il plugin per l'upload
	    if (uploader == null) {
		initUploader(json_signup_user.type);
	    }

	    return typeUser;

	});
    } catch (err) {
	window.console.error("selectTypeUser | An error occurred - message : " + err.message);
    }
}

/*
 * validazione campi con plugin abide di foundation
 * trami espressioni regolari definite sopra
 */
function validateFields() {
    try {
	$(document).foundation('abide', {
	    live_validate: true,
	    focus_on_invalid: true,
	    timeout: 1000,
	    patterns: {
		username: exp_username,
		mail: exp_mail,
		password: exp_password,
		description: exp_description,
		url: exp_url
	    }
	});
    } catch (err) {
	window.console.error("validateFields | An error occurred - message : " + err.message);
    }

}

/*
 * validazione javascript campo username
 */
function validateUsername() {
    try {
	$('#signup01-username').blur(function() {
	    var text_error;
	    var label_error;
	    $.each($('.signup01-username-singup01 label'), function(key, value) {
		if (!$(value).hasClass('no-display')) {
		    var id = $(value).attr('id');
		    label_error = '#' + id + ' small.error';
		    text_error = $(label_error).html();
		}

	    });
	    var illegalChat = /^[!""#$%&'()*+,-./:;<=>?[\]^_`{|}~]/;
	    var exp = new RegExp(/(\s)$/);
	    var exp1 = new RegExp(illegalChat);
	    if ($('#signup01-username').val() == '') {
		//stringa vuota
		$(label_error).html(text_error);

	    }
	    else if (exp.test($('#signup01-username').val())) {
		$(label_error).html($('#signup01-signup01 #error_field1').val());
	    }
	    else if (!exp1.test($('#signup01-username').val())) {
		$(label_error).html($('#signup01-signup01 #error_field2').val() + ': ' + illegalChat);
	    }
	    else {
		$(label_error).html(text_error);
	    }

	});
    } catch (err) {
	window.console.error("validateUsername | An error occurred - message : " + err.message);
    }
}

/*
 * validazione javascript campo password
 */
function validatePassword() {
    try {
	$('#signup01-password').blur(function() {

	    var label_error = $('label[for="signup01-password"] .error');
	    var text_error = $(label_error).html();
	    var illegalChat = /^[!""#$%&'()*+,-./:;<=>?[\]^_`{|}~]/;
	    var exp1 = new RegExp(illegalChat);
	    if ($('#signup01-password').val().length < 8) {
		//stringa vuota
		$(label_error).html($('#signup01-signup01 #error_field3').val());

	    }
	    else if (!exp1.test($('#signup01-password').val())) {
		$(label_error).html($('#signup01-signup01 #error_field2').val() + ': ' + illegalChat);
	    }
	    else {
		$(label_error).html(text_error);
	    }

	});
    } catch (err) {
	window.console.error("validatePassword | An error occurred - message : " + err.message);
    }
}

/*
 * validazione javascript campo password
 */
function validateCharacters(field) {
    try {
	$('#' + field).blur(function() {
	    var label_error = $('label[for="' + field + '"] .error');
	    var text_error = $(label_error).html();
	    var illegalChat = /^[!""#$%&'()*+,-./:;<=>?[\]^_`{|}~]/;
	    var exp1 = new RegExp(illegalChat);
	    if (!exp1.test($('#' + field).val())) {
		$(label_error).html($('#signup01-signup01 #error_field2').val() + ': ' + illegalChat);
	    }
	});
    } catch (err) {
	window.console.error("validateCharacters | An error occurred - message : " + err.message);
    }
}

/*
 * validazione javascript campo url
 */
function validateUrl(field) {
    try {
	$('#' + field).blur(function() {
	    var str = $('#' + field).val();
	    if (str != '' && str.indexOf("http://") < 0) {
		$('#' + field).val('http://' + str);
	    }
	});
    } catch (err) {
	window.console.error("validateUrl | An error occurred - message : " + err.message);
    }
}

/*
 * gestione visualizzazione step
 */
function viewStep1() {
    try {
	$('#signup-labelStep-step1').css({"background-color": "#FF7505"});
	$('#signup-labelStep-step1').css({"color": "#F3F3F3"});
	$('#signup-labelStep-step2').css({"background-color": "#C95600"});
	$('#signup-labelStep-step2').css({"color": "#D8D8D8"});
	$('#signup-labelStep-step3').css({"background-color": "#C95600"});
	$('#signup-labelStep-step3').css({"color": "#D8D8D8"});
    } catch (err) {
	window.console.error("viewStep1 | An error occurred - message : " + err.message);
    }

}
function viewStep2() {
    try {
	$('#signup-labelStep-step2').css({"background-color": "#FF7505"});
	$('#signup-labelStep-step2').css({"color": "#F3F3F3"});
	$('#signup-labelStep-step1').css({"background-color": "#C95600"});
	$('#signup-labelStep-step1').css({"color": "#D8D8D8"});
	$('#signup-labelStep-step3').css({"background-color": "#C95600"});
	$('#signup-labelStep-step3').css({"color": "#D8D8D8"});
    } catch (err) {
	window.console.error("viewStep2 | An error occurred - message : " + err.message);
    }

}
function viewStep3() {
    try {
	$('#signup-labelStep-step3').css({"background-color": "#FF7505"});
	$('#signup-labelStep-step3').css({"color": "#F3F3F3"});
	$('#signup-labelStep-step1').css({"background-color": "#C95600"});
	$('#signup-labelStep-step1').css({"color": "#D8D8D8"});
	$('#signup-labelStep-step2').css({"background-color": "#C95600"});
	$('#signup-labelStep-step2').css({"color": "#D8D8D8"});
    } catch (err) {
	window.console.error("viewStep3 | An error occurred - message : " + err.message);
    }

}

/*
 * gestione bottone next scheda step1
 * Permette di effettuare una verifica dei campi, se i campi non sono tutti validi con va allo step successivo
 * La verifica vera e propria dei campi viene fatta da fondation abide con le espressioni regolari (vedi sopra)
 */
function step1Next() {
    try {
	$('#signup01-signup01 .signup-button').click(function() {
	    var scheda_succ;
	    var validation_username = false;
	    var validation_mail = false;
	    var validation_password = false;
	    var validation_verifyPassword = false;

	    var id = $(this).attr('id');
	    if (id == "spotter-signup01-next") {
		type_user = "spotter";
		scheda_succ = '#spotter-signup02';
		maxCheck = 0;
	    }
	    if (id == "jammer-signup01-next") {
		type_user = "jammer";
		scheda_succ = '#jammer-signup02';
		maxCheck = 0;
	    }
	    if (id == "venue-signup01-next") {
		type_user = "venue";
		scheda_succ = '#venue-signup02';
		maxCheck = 0;
	    }

	    //validation username
	    var espressione = new RegExp(exp_username);

	    if (!espressione.test($('#signup01-username').val())) {

		var exp = new RegExp(/(\s)$/);
		if (exp.test($('#signup01-username').val()))
		    console.log('SPAZIO ALLA FINE');

		var exp = new RegExp(/^[!""#$%&'()*+,-./:;<=>?[\]^_`{|}~]/);
		if (!exp.test($('#signup01-username').val()))
		    console.log('CARETTERI SPECIALI');


		$('#signup01-username').focus();
		validation_username = false;
	    }
	    else {
		validation_username = true;
	    }

	    //validation mail
	    var espressione = new RegExp(exp_mail);
	    if (!espressione.test($('#signup01-mail').val())) {
		$('#signup01-mail').focus();
		validation_mail = false;
	    }
	    else {
		validation_mail = true;
	    }
	    //validation password
	    var espressione = new RegExp(exp_password);
	    if (!espressione.test($('#signup01-password').val())) {
		$('#signup01-password').focus();
		validation_password = false;
	    }
	    else {
		validation_password = true;
	    }
	    //verify password
	    if ($('#signup01-verifyPassword').val() == "" || !($('#signup01-password').val() == $('#signup01-verifyPassword').val())) {
		$('#signup01-verifyPassword').focus();
		$('.signup01-verifyPassword-signup01 small.error').css({'display': 'block'});
		validation_verifyPassword = false;
	    }
	    else {
		$('.signup01-verifyPassword-signup01 small.error').css({'display': 'none'});
		validation_verifyPassword = true;
	    }
	    validateCaptcha();
	    if (!validation_recaptcha) {
		$('#valid-captcha small.error').css({'display': 'block'});
	    }
	    else
		$('#valid-captcha small.error').css({'display': 'none'});
	    // va allo step successivo se tutti i campi sono validi
	    if (validation_username && validation_mail && validation_password && validation_verifyPassword && validation_recaptcha) {
		$('#signup01-signup01').hide('slide', {direction: "left"}, "slow");
		setTimeout(function() {
		    $(scheda_succ).show('slide', {direction: "right"}, "slow");
		}, 600);
		viewStep2();
		if (type_user == "jammer") {
		    $('#signup02-jammer-name-artist').text($('#signup01-username').val() + ", ");
		}
	    }
	    else {
		showCaptcha();
	    }

	});
    } catch (err) {
	window.console.error("step1Next | An error occurred - message : " + err.message);
    }
}

/*
 * gestione bottone back step1
 */
function step1Back() {
    try {
	$('#signup01-back').click(function() {
	    $('#signup01-signup01').hide('slide', {direction: "right"}, "slow");
	    setTimeout(function() {
		$('#signup01').show('slide', {direction: "left"}, "slow");
	    }, 600);
	    $('.signup-labelStep').css({"display": "none"});
	});
    } catch (err) {
	window.console.error("step1Back | An error occurred - message : " + err.message);
    }
}

/*
 * gestione bottone next di step2 - SPOTTER
 * verifica validazione campi presenti nella scheda
 */
function step2NextSpotter() {
    try {
	$('#spotter-signup02-next').click(function() {
	    var validation_city = false;
	    var validation_country = false;
	    var validation_genre = false;

	    //controllo se sono stati inseriti city e country
	    //validation county
	    var espressione = new RegExp(exp_description);
	    if (!espressione.test($('#spotter-city').val())) {
		$('#spotter-city').focus();
		validation_city = false;
	    }
	    else
		validation_city = true;

	    //validation county
	    var espressione = new RegExp(exp_username);
	    if (!espressione.test($('#spotter-country').val())) {
		$('#spotter-country').focus();
		validation_country = false;
	    }
	    else
		validation_country = true;

	    //controllo se almeno esiste un checked per genre    	    	 
	    if (!$(".signup-genre input[type='checkbox']").is(':checked')) {
		$(".label-signup-genre .error").css({'display': 'block'});
		validation_genre = false;
	    }
	    else {
		validation_genre = true;
		$(".label-signup-genre .error").css({'display': 'none'});
	    }

	    //vado avanti se genre city e county sono validati    	
	    if (validation_city && validation_country && validation_genre) {
		$('#spotter-signup02').hide('slide', {direction: "left"}, "slow");
		setTimeout(function() {
		    $('#spotter-signup03').show('slide', {direction: "right"}, "slow");
		}, 600);
		//il secondo blocco dello step sara' arancione gli altri arancione scuro
		viewStep3();
	    }
	    validateUrl('spotter-facebook');
	    validateUrl('spotter-twitter');
	    validateUrl('spotter-google');
	    validateUrl('spotter-youtube');
	    validateUrl('spotter-web');

	});
    } catch (err) {
	window.console.error("step2NextSpotter | An error occurred - message : " + err.message);
    }
}

/*
 * gestisce bottone back di step2 - spotter
 */
function step2BackSpotter() {
    try {
	$('#spotter-signup02-back').click(function() {
	    $('#spotter-signup02').hide('slide', {direction: "right"}, "slow");
	    setTimeout(function() {
		$('#signup01-signup01').show('slide', {direction: "left"}, "slow");
	    }, 600);
	    //il secondo blocco dello step sara' arancione gli altri arancione scuro
	    viewStep1();
	});
    } catch (err) {
	window.console.error("step2BackSpotter | An error occurred - message : " + err.message);
    }
}


/*
 * gestione bottone next di step3 - spotter
 * validazione campi della scheda
 */
function step3NextSpotter() {
    try {
	$('#spotter-signup03-next').click(function() {
	    var validation_description = false;

	    //validation description
	    var espressione = new RegExp(exp_description);
	    if (!espressione.test($('#spotter-description').val())) {
		$('#spotter-description').focus();
		validation_description = false;
	    }
	    else
		validation_description = true;

	    if (validation_description) {
		window.console.debug("chiamata signup da '#spotter-signup03-next'");
		signup();
	    }
	});
    } catch (err) {
	window.console.error("step3NextSpotter | An error occurred - message : " + err.message);
    }
}

/*
 * gestione bottone back di step3 - spotter
 */
function step3BackSpotter() {
    try {
	$('#spotter-signup03-back').click(function() {
	    $('#spotter-signup03').hide('slide', {direction: "right"}, "slow");
	    setTimeout(function() {
		$('#spotter-signup02').show('slide', {direction: "left"}, "slow");
	    }, 600);
	    //il secondo blocco dello step sara' arancione gli altri arancione scuro
	    viewStep2();
	});
	//funzione per la comparsa dei campi component in jammer signup02
	$('input[name="jammer-typeArtist"]').click(function() {
	    var id = $(this).attr('id');
	    if (id == "jammer-typeArtist-band") {
		$('#jammer-component-signup02').removeClass('no-display');
	    }
	    else
		$('#jammer-component-signup02').addClass('no-display');
	});
    } catch (err) {
	window.console.error("step3BackSpotter | An error occurred - message : " + err.message);
    }
}

/*
 * gestione bottone next step2 - jammer
 * validazione campi 
 */
function step2NextJammer() {
    try {
	$('#jammer-signup02-next').click(function() {
	    var validation_city = false;
	    var validation_country = false;
	    var validation_typeArtist = false;

	    //controllo se sono stati inseriti city e country
	    //validation county
	    var espressione = new RegExp(exp_description);
	    if (!espressione.test($('#jammer-city').val())) {
		$('#jammer-city').focus();
		validation_city = false;
	    }
	    else
		validation_city = true;

	    //validation county
	    var espressione = new RegExp(exp_username);
	    if (!espressione.test($('#jammer-country').val())) {
		$('#jammer-country').focus();
		validation_county = false;
	    }
	    else
		validation_county = true;

	    //controllo campo  jammer-typeArtist  	 
	    if (!$("input[name='jammer-typeArtist']").is(':checked')) {
		$("#jammer-typeArtist-label .error").css({'display': 'block'});
		validation_typeArtist = false;
	    }
	    else {
		validation_typeArtist = true;
		$("#jammer-typeArtist-label .error").css({'display': 'none'});
	    }


	    if (validation_county && validation_city && validation_typeArtist) {
		$('#jammer-signup02').hide('slide', {direction: "left"}, "slow");
		setTimeout(function() {
		    $('#jammer-signup03').show('slide', {direction: "right"}, "slow");
		}, 600);
		//il secondo blocco dello step sara' arancione gli altri arancione scuro
		viewStep3();
	    }
	    validateUrl('jammer-facebook');
	    validateUrl('jammer-twitter');
	    validateUrl('jammer-google');
	    validateUrl('jammer-youtube');
	    validateUrl('jammer-web');
	});
    } catch (err) {
	window.console.error("step2NextJammer | An error occurred - message : " + err.message);
    }
}

/*
 * gestione bottone back step2 - jammer
 */
function step2BackJammer() {
    try {
	$('#jammer-signup02-back').click(function() {
	    $('#jammer-signup02').hide('slide', {direction: "right"}, "slow");
	    setTimeout(function() {
		$('#signup01-signup01').show('slide', {direction: "left"}, "slow");
	    }, 600);
	    //il secondo blocco dello step sara' arancione gli altri arancione scuro
	    $('#signup-labelStep-step2').css({"background-color": "#C95600"});
	    $('#signup-labelStep-step2').css({"color": "#D8D8D8"});
	    $('#signup-labelStep-step1').css({"background-color": "#FF7505"});
	    $('#signup-labelStep-step1').css({"color": "#F3F3F3"});
	});
    } catch (err) {
	window.console.error("step2BackJammer | An error occurred - message : " + err.message);
    }
}
/*
 * gestione bottone next step3 - jammer
 */
function step3NextJammer() {
    try {
	$('#jammer-signup03-next').click(function() {
	    var validation_genre = false;
	    var validation_description = false;
	    //validation county
	    var espressione = new RegExp(exp_description);
	    if (!espressione.test($('#jammer-description').val())) {
		$('#jammer-description').focus();
		validation_description = false;
	    }
	    else
		validation_description = true;

	    //controllo se almeno esiste un checked per genre    	    	 
	    if (!$("#jammer-signup03 .signup-genre input[type='checkbox']").is(':checked')) {
		$("#jammer-signup03 .label-signup-genre .error").css({'display': 'block'});
		validation_genre = false;
	    }
	    else {
		validation_genre = true;
	    }

	    //vado avanti se genre city e county sono validati    	
	    if (validation_description && validation_genre) {
		window.console.debug("chiamata signup da '#jammer-signup03-next'");
		signup();
	    }
	});
    } catch (err) {
	window.console.error("step3NextJammer | An error occurred - message : " + err.message);
    }
}
/*
 * gestione bottone back step3 - jammer
 */
function step3BackJammer() {
    try {
	$('#jammer-signup03-back').click(function() {
	    $('#jammer-signup03').hide('slide', {direction: "right"}, "slow");
	    setTimeout(function() {
		$('#jammer-signup02').show('slide', {direction: "left"}, "slow");
	    }, 600);
	    //il secondo blocco dello step sara' arancione gli altri arancione scuro
	    viewStep2();
	});
    } catch (err) {
	window.console.error("step3BackJammer | An error occurred - message : " + err.message);
    }
}

/*
 * gestione bottone next step2 - venue
 */
function step2NextVenue() {
    try {
	$('#venue-signup02-next').click(function() {
	    var validation_county = false;
	    var validation_city = false;
	    var validation_zipcode = false;
	    var number = false;
	    var validation_number = false;
	    //validation county
	    var espressione = new RegExp(exp_username);
	    if (!espressione.test($('#venue-country').val())) {
		$('#venue-country').focus();
		validation_country = false;
	    }
	    else
		validation_country = true;
	    var espressione = new RegExp(exp_description);
	    if (!espressione.test($('#venue-city').val())) {
		$('#venue-city').focus();
		validation_city = false;
	    }
	    else
		validation_city = true;
	    var espressione = new RegExp(exp_username);
	    if (!espressione.test($('#venue-province').val())) {
		$('#venue-province').focus();
		validation_zipcode = false;
	    }
	    else
		validation_zipcode = true;

	    if (!espressione.test($('#venue-adress').val())) {
		$('#venue-adress').focus();
		validation_adress = false;
	    }
	    else
		validation_adress = true;

	    if (!espressione.test($('#venue-number').val())) {
		$('#venue-number').focus();
		validation_number = false;
	    }
	    else
		validation_number = true;

	    //vado avanti se genre city e county sono validati    	
	    if (validation_country && validation_city && validation_zipcode && validation_adress && validation_number) {
		$('#venue-signup02').hide('slide', {direction: "left"}, "slow");
		setTimeout(function() {
		    $('#venue-signup03').show('slide', {direction: "right"}, "slow");
		}, 600);
		//il secondo blocco dello step sara' arancione gli altri arancione scuro
		viewStep3();
	    }
	    validateUrl('venue-facebook');
	    validateUrl('venue-twitter');
	    validateUrl('venue-google');
	    validateUrl('venue-youtube');
	    validateUrl('venue-web');
	});
    } catch (err) {
	window.console.error("step2NextVenue | An error occurred - message : " + err.message);
    }
}

/*
 * gestione bottone back step2 - venue
 */
function step2BackVenue() {
    try {
	$('#venue-signup02-back').click(function() {
	    $('#venue-signup02').hide('slide', {direction: "right"}, "slow");
	    setTimeout(function() {
		$('#signup01-signup01').show('slide', {direction: "left"}, "slow");
	    }, 600);
	    //il secondo blocco dello step sara' arancione gli altri arancione scuro
	    viewStep1();
	});
    } catch (err) {
	window.console.error("step2BackVenue | An error occurred - message : " + err.message);
    }
}

/*
 * gestione bottone next step3 - venue
 */
function step3NextVenue() {
    try {
	$('#venue-signup03-next').click(function() {
	    var validation_genre = false;
	    var validation_description = false;
	    //validation county
	    var espressione = new RegExp(exp_description);
	    if (!espressione.test($('#venue-description').val())) {
		$('#venue-description').focus();
		validation_description = false;
	    }
	    else
		validation_description = true;

	    //controllo se almeno esiste un checked per genre    	    	 
	    if (!$("#venue-signup03 .signup-genre input[type='checkbox']").is(':checked')) {
		$("#venue-signup03 .label-signup-genre .error").css({'display': 'block'});
		validation_genre = false;
	    }
	    else {
		validation_genre = true;
	    }

	    //vado avanti se genre city e county sono validati    	
	    if (validation_description && validation_genre) {
		window.console.debug("chiamata signup da '#venue-signup03-next'");
		signup();
	    }
	});
    } catch (err) {
	window.console.error("step3NextVenue | An error occurred - message : " + err.message);
    }

}

/*
 * gestione bottone back step3 - venue
 */
function step3BackVenue() {
    try {
	$('#venue-signup03-back').click(function() {
	    $('#venue-signup03').hide('slide', {direction: "right"}, "slow");
	    setTimeout(function() {
		$('#venue-signup02').show('slide', {direction: "left"}, "slow");
	    }, 600);
	    //il secondo blocco dello step sara' arancione gli altri arancione scuro
	    viewStep2();
	});
    } catch (err) {
	window.console.error("step3BackVenue | An error occurred - message : " + err.message);
    }
}

/*
 * auomenta i campi per i componenti della band
 */
var numComponent = 3;
function addComponent() {
    try {

	text = '<div class="row jammer-componentName' + numComponent + '-singup02"> <div  class="small-12 columns"> <input type="text" name="jammer-componentName' + numComponent + '" id="jammer-componentName' + numComponent + '" pattern="username" maxlength="50"/>	<label for="jammer-componentName' + numComponent + '" >Name<small class="error"> Please enter a valid Name</small></label> </div> </div>';
	$('#addComponentName').append(text);

	text = '<div class="row jammer-componentInstrument' + numComponent + '-singup02"> <div  class="small-12 columns"> <select id="jammer_componentInstrument' + numComponent + '" ></select>	<label for="jammer-componentInstrument' + numComponent + '" >Instrument<small class="error"> Please enter a valid Instrument</small></label> </div> </div>';
	$('#addComponentInstrument').append(text);

	option = $("#jammer_componentInstrument1 option").clone();

	jQuery.each(option, function(i, val) {
	    jQuery(val).attr("id", "jammer-componentInstrument" + numComponent);
	    jQuery(val).attr("name", "jammer-componentInstrument" + numComponent);
	    $(val).appendTo('#jammer_componentInstrument' + numComponent);
	});
	numComponent = numComponent + 1;
    } catch (err) {
	window.console.error("addComponent | An error occurred - message : " + err.message);
    }
}

/**
 * Da chiamare al momento dell'esecuzione effettiva 
 * della registrazione (onClick "complete")
 * 
 */
function signup() {
    //recupero i valori del form
    getFormValues();
    //invio la richiesta al server
    window.console.log("signup - Sending user => " + JSON.stringify(json_signup_user));
    sendRequest("signup", "signup", json_signup_user, signupCallback, false);
}


/**
 * Verifica se l'email inserita dall'utente esiste gia'
 */
function checkEmailExists() {
    var json_email = {};
    json_email.request = "checkEmailExists";
    json_email.email = $("#signup01-mail").val(); //recupero il valore della email o lo passo come parametro

    console.log("[checkEmailExists] email :" + $("#signup01-mail").val());
    $.ajax({
	type: "POST",
	url: "../controllers/request/signupRequest.php",
	data: json_email,
	async: true, //mettiamo asincrone se no si blocca la pagina...
	"beforeSend": function(xhr) {
	    xhr.setRequestHeader("X-AjaxRequest", "1");
	},
	success: function(data, status) {
	    //la mail non esiste => e' valida
	},
	error: function(data, status) {
	    console.log("[checkEmailExists] errore.data : " + JSON.stringify(data));
	    console.log("[checkEmailExists] errore.status : " + status);
	}
    });
}

/**
 * Verifica se lo username inserito dall'utente esiste gia'
 */
function checkUsernameExists() {
    var json_username = {};
    json_username.request = "checkUsernameExists";
    json_username.username = $("#signup01-username").val(); //recupero il valore della email o lo passo come parametro
    console.log("[checkUsernameExists] username :" + $("#signup01-username").val());
    $.ajax({
	type: "POST",
	url: "../controllers/request/signupRequest.php",
	data: json_username,
	async: true, //mettiamo asincrone se no si blocca la pagina...
	"beforeSend": function(xhr) {
	    xhr.setRequestHeader("X-AjaxRequest", "1");
	},
	success: function(data, status) {
	    //lo username non esiste => e' valido
	},
	error: function(data, status) {
	    console.log("[checkUsernameExists] errore.data : " + JSON.stringify(data));
	    console.log("[checkUsernameExists] errore.status : " + status);
	}
    });
}


/**
 * Mostra il captcha nel div "signup01-captcha"
 * @returns {undefined}
 */
function showCaptcha() {
    var publickey = "6LfMnNcSAAAAABls9QS4oPvL86A0RzstkhSFWKud"; //CHIAVE PUBBLICA PER IL RECAPTCHA
    var captchaDiv = "signup01-captcha"; //div in cui va scritto il 
    var theme = "red"; //esiste anche "red", "white", "clean","blackglass"
    Recaptcha.create(publickey, captchaDiv, {
	theme: theme,
	callback: Recaptcha.focus_response_field});
}

/**
 * Valida il codice inserito nel captcha
 * via ajax. 
 * La chiamata ajax restituisce "success" in caso di successo
 * @returns {undefined}
 */
function validateCaptcha() {
    var json_captcha = {};

    json_captcha.request = "recaptcha";
    //variabile captcha challenge_field
    json_captcha.responseField = $("input#recaptcha_response_field").val();
    //variabile captcha response_field
    json_captcha.challengeField = $("input#recaptcha_challenge_field").val();

    console.log("[validateCaptcha] recaptcha_response_field => " + json_captcha.responseField);
    console.log("[validateCaptcha] challengeField => " + json_captcha.challengeField);
//    
    //********  chiamata Ajax allo script di controllo dell'inserimento corretto del captcha
    $.ajax({
	type: "POST",
	url: "../controllers/request/signupRequest.php",
	data: json_captcha,
	async: false,
	success: function(data, status) {
	    //captcha corretto
	    validation_recaptcha = true;
	},
	error: function(data, status) {
	    console.log("[validateCaptcha] errore.data : " + JSON.stringify(data));
	    console.log("[validateCaptcha] errore.status : " + status);
	    validation_recaptcha = false;
	}
    });
}

function getFormValues() {

    //----------- json d'iscrizione -----------------------
    //step 0 (configurazione browser-utente
    //@todo: completare language e localTime
    json_signup_user.language = navigator.language || navigator.userLanguage;

    json_signup_user.localTime = ((new Date()).getTimezoneOffset());
    //step 1   
    json_signup_user.username = $('#signup01-username').val();
    json_signup_user.email = $('#signup01-mail').val();
    json_signup_user.password = $('#signup01-password').val();
    json_signup_user.verifyPassword = $('#signup01-verifyPassword').val();

    switch (json_signup_user.type) {
	case "SPOTTER" :
	    //step 2
	    json_signup_user.firstname = $('#spotter-firstname').val();
	    json_signup_user.lastname = $('#spotter-lastname').val();
//            json_signup_user.country = $('#spotter-country').val();
//            json_signup_user.city = $('#spotter-city').val();
	    json_signup_user.genre = getSelectedGenre();
	    //step 3
	    json_signup_user.description = $('#spotter-description').val();
	    json_signup_user.sex = $('input[name=spotter-sex]:checked').val();
	    //birthday
	    json_signup_user.birthday = {"day": 01, "month": 01, "year": 1970};
	    if ($('#spotter-birth-day').val().length > 0 && $('#spotter-birth-day').val() != "- Day -") {
		json_signup_user.birthday.day = $('#spotter-birth-day').val();
	    }
	    if ($('#spotter-birth-month').val().length > 0 && $('#spotter-birth-month').val() != "- Month -") {
		json_signup_user.birthday.month = $('#spotter-birth-month').val();
	    }
	    if ($('#spotter-birth-year').val().length > 0 && $('#spotter-birth-year').val() != "- Year -") {
		json_signup_user.birthday.year = $('#spotter-birth-year').val();
	    }

	    json_signup_user.facebook = $('#spotter-facebook').val();
	    json_signup_user.twitter = $('#spotter-twitter').val();
	    json_signup_user.google = $('#spotter-google').val();
	    json_signup_user.youtube = $('#spotter-youtube').val();
	    json_signup_user.web = $('#spotter-web').val();
	    break;
	case "JAMMER" :
	    //step 2            
	    json_signup_user.jammerType = $('input[name=jammer-typeArtist]:checked').val();
//            json_signup_user.country = $('#jammer-country').val();
//            json_signup_user.city = $('#jammer-city').val();
	    if (json_signup_user.jammerType === "band") {
		json_signup_user.members = getBandComponents();
	    }
	    //step 3
	    json_signup_user.genre = getSelectedGenre();
	    json_signup_user.description = $('#jammer-description').val();
	    json_signup_user.facebook = $('#jammer-facebook').val();
	    json_signup_user.twitter = $('#jammer-twitter').val();
	    json_signup_user.google = $('#jammer-google').val();
	    json_signup_user.youtube = $('#jammer-youtube').val();
	    json_signup_user.web = $('#jammer-web').val();
	    break;
	case "VENUE" :
	    //step 2            
//            json_signup_user.country = $('#venue-country').val();
//            json_signup_user.city = $('#venue-city').val();
//            json_signup_user.province = $('#venue-province').val();
//            json_signup_user.address = $('#venue-adress').val();
//            json_signup_user.number = $('#venue-number').val();

	    //step3            
	    json_signup_user.description = $('#venue-description').val();
	    json_signup_user.genre = getSelectedGenre();
	    json_signup_user.facebook = $('#venue-facebook').val();
	    json_signup_user.twitter = $('#venue-twitter').val();
	    json_signup_user.google = $('#venue-google').val();
	    json_signup_user.youtube = $('#venue-youtube').val();
	    json_signup_user.web = $('#venue-web').val();
	    break;
    }
}

function getBandComponents() {
    var components = new Array();
    var currComponent = 1;
    var componentName = $("#jammer-componentName" + currComponent).val();
    var componentInstrument = $("#jammer_componentInstrument" + currComponent).val();

    while (componentName !== undefined && componentName !== null && componentName.length > 0 && currComponent < 10) {
	var component = {};

	component.name = componentName;

	if (componentInstrument !== null && componentInstrument !== undefined && componentInstrument.length > 0) {
	    component.instrument = componentInstrument;
	} else
	    component.instrument = null;

	components.push(component);

	currComponent++;

	//aggiornamento per il while
	componentName = $("#jammer-componentName" + currComponent).val();
	componentInstrument = $("#jammer_componentInstrument" + currComponent).val();
    }

    if (components.length > 0)
	return components;
    else
	return null;


}

function getSelectedGenre() {
    var genre = new Array();
    $('.signup-genre :checked').each(function() {
	genre.push($(this).val());
    });
    if (genre.length > 0)
	return genre;
    else
	return null;
}

function signupCallback(data, status, xhr) {
    if (status === "success") {
	$('#' + json_signup_user.type.toLowerCase() + '-signup03').hide('slide', {direction: "left"}, "slow");
	$('#signup-ok').show('slide', {direction: "right"}, "slow");
	alert(data.status);
    } else {
        data = JSON.parse(data.responseText)
	alert(data.status);
    }
}

//----------------------------------- IMAGE CROP ----------------------------------


//userType = "spotter"/"jammer"/"venue"
//img è creato con img = new Image e definiti i campi img.src, img.width e img.height
function onUploadedImage(userType, img) {

    preview = $('#' + userType + '_uploadImage_preview');
    tumbnail = $('#' + userType + '_uploadImage_tumbnail');
    tumbnail_pane = $('#' + userType + '_uploadImage_tumbnail-pane');

    id_tumbnail = tumbnail.attr('id');
    id_preview = preview.attr('id');

    //creo l'html per la preview dell'immagine

    input_x = userType + '_x';
    input_y = userType + '_y';
    input_w = userType + '_w';
    input_h = userType + '_h';

    var html_uploadImage_preview_box = "";
    html_uploadImage_preview_box += '<img src="' + img.src + '" id="' + id_preview + '" width="' + img.width + 'px" height="' + img.height + 'px" "/>';
    html_uploadImage_preview_box += '<input type="hidden" id="' + input_x + '" name="' + input_x + '" value="0"/>';
    html_uploadImage_preview_box += '<input type="hidden" id="' + input_y + '" name="' + input_y + '" value="0"/>';
    html_uploadImage_preview_box += '<input type="hidden" id="' + input_w + '" name="' + input_w + '" value="100"/>';
    html_uploadImage_preview_box += '<input type="hidden" id="' + input_h + '" name="' + input_h + '" value="100"/>';

    //mostra a video la preview dell'immagine:
    $('#' + userType + '_uploadImage_preview_box').html(html_uploadImage_preview_box);
    preview = $('#' + userType + '_uploadImage_preview');


    //creo l'html per la preview del thumbnail (l'immagine finale dopo il jcrop?)
    var html_tumbnail_pane = '';
    html_tumbnail_pane += '<img src="" id="' + id_tumbnail + '" height="50" width="50"/>';

//mostra a video la preview del thumbnail 
    $("#" + id_tumbnail).html(html_tumbnail_pane);
    tumbnail = $('#' + id_tumbnail);

//mostro a video l'immagine 
    $('#' + userType + '_uploadImage_save').removeClass('no-display');

    //attivo il plugin jcrop (non funzionante per ora)
    initJcrop(img, preview);
}

function updatePreview(c) {
    $('#' + input_x).val(c.x);
    $('#' + input_y).val(c.y);
    $('#' + input_w).val(c.w);
    $('#' + input_h).val(c.h);

}

function  initJcrop(img, preview) {

    var imgWidth = img.width;
    var imgHeight = img.height;

    //se jcrop è gia' stato attivato in precedenza lo disattivo
    if (jcrop_api) {
	jcrop_api.destroy();
	jcrop_api.setOptions({allowSelect: !!this.checked});
	jcrop_api.focus();
	//tumbnail.remove();
    }
    xsize = tumbnail_pane.width(),
	    ysize = tumbnail_pane.height();

    $(preview).Jcrop({
	onChange: updatePreview,
	onSelect: updatePreview,
	aspectRatio: xsize / ysize,
    }, function() {
	var bounds = this.getBounds();
	boundx = bounds[0];
	boundy = bounds[1];
	jcrop_api = this;
	jcrop_api.setImage(img.src);
	jcrop_api.setOptions({
	    boxWidth: img.width,
	    boxHeight: img.height
	});
	jcrop_api.animateTo([0, 0, 100, 100]);
    });


}

//----------------------------------- IMAGE UPLOAD ----------------------------------

function initUploader(userType) {

//    window.console.log("initUploader - params : userType => " + userType);
//inizializzazione dei parametri
    var containerId = "";
    var selectButtonId = "";
    var progressbar = "";
    var url = "../controllers/request/uploadRequest.php";
    var runtime = 'html4';
    var multi_selection = false;
    var maxFileSize = "10mb";

    switch (userType) {
	case  "SPOTTER" :
	    containerId = "spotter_container";
	    selectButtonId = "spotter_uploadImage_file_label";
	    progressbar = '#progressbarSpotter';
	    break;
	case  "VENUE" :
	    containerId = "venue_container";
	    selectButtonId = "venue_uploadImage_file_label";
	    progressbar = '#progressbarVenue';
	    break;
	case  "JAMMER" :
	    containerId = "jammer_container";
	    selectButtonId = "jammer_uploadImage_file_label";
	    progressbar = '#progressbarJammer';
	    break;
    }

//creo l'oggetto uploader (l'ho dichiarato ad inizio js in modo che sia globale)
    uploader = new plupload.Uploader({
	runtimes: runtime, //runtime di upload
	browse_button: selectButtonId, //id del pulsante di selezione file
	container: containerId, //id del div per l'upload
	max_file_size: maxFileSize, //dimensione max dei file da caricare
	multi_selection: multi_selection, //forza un file alla volta per upload
//        chunk_size : '100kb',
	url: url,
	filters: [
	    {title: "Image files", extensions: "jpg,gif,png"}, //lista file accettati
	],
	multipart_params: {"request": "uploadImage"}, //parametri passati in POST
    });

    uploader.bind('Init', function(up, params) {
//        window.console.log("initUploader - EVENT: Ini");
    });

//inizializo l'uploader
//    window.console.log("initUploader - eseguo uploader.init()");
    uploader.init();

//evento: file aggiunto
    uploader.bind('FilesAdded', function(up, files) {
	//avvio subito l'upload
//        window.console.log("initUploader - EVENT: FilesAdded - parametri: files => " + JSON.stringify(files));
//        window.console.log("initUploader - eseguo uploader.start()");
	uploader.start();
    });

//evento: cambiamento percentuale di caricamento
    uploader.bind('UploadProgress', function(up, file) {
//        window.console.log("initUploader - EVENT: UploadProgress - parametri: file => " + JSON.stringify(file));
	var progressBarValue = up.total.percent;
	$(progressbar).fadeIn().progressbar({
	    value: progressBarValue
	});
	$(progressbar + ' .ui-progressbar-value').html('<span class="progressTooltip">' + up.total.percent + '%</span>');
    });

//evento: errore
    uploader.bind('Error', function(up, err) {
//        window.console.log("initUploader - EVENT: Error - parametri: err => " + JSON.stringify(err));
	alert("Error occurred");
	up.refresh();
    });

//evento: upload terminato
    uploader.bind('FileUploaded', function(up, file, response) {

//        window.console.log("initUploader - EVENT: FileUploaded - parametri: err => " + JSON.stringify(file) + " - response => " + JSON.stringify(response));

	console.log(response.response);
	var obj = JSON.parse(response.response);
	//aggiorno nel json l'immagine del profilo (mi basta il nome del file in cache)
	json_signup_user.image = obj.src;

	//qua ora va attivato il jcrop
	var img = new Image();
	img.src = "../cache/" + obj.src;
	img.width = obj.width;
	img.height = obj.height;
	onUploadedImage(json_signup_user.type.toLowerCase(), img);
    });
}


function initGeocomplete(id) {
    try {
	$(id).geocomplete()
		.bind("geocode:result", function(event, result) {
	    json_signup_user.city = prepareLocationObj(result);
	})
		.bind("geocode:error", function(event, status) {
	    json_signup_user.city = null;

	})
		.bind("geocode:multiple", function(event, results) {
	    json_signup_user.city = prepareLocationObj(results[0]);
	});

    } catch (err) {
	console.log("initGeocomplete | An error occurred - message : " + err.message);
    }

}
/*
 * verifica numero max di checkbox
 */

function checkmax(elemento, max) {
    if (elemento.checked) {
	if ((maxCheck + 1) == max)
	    maxCheck += 1;
	else if ((maxCheck) + 1 > max)
	    elemento.checked = false;
	else
	    maxCheck += 1;
    }
    else {
	maxCheck -= 1;
    }
}