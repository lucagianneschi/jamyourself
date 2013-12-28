//---------------- VALIDAZIONE FOUNDATION abide  ----------------------------- 
//------ espressioni regolari -------------------------------
var exp_username = /^([a-zA-Z0-9\s\xE0\xE8\xE9\xF9\xF2\xEC\x27][!""#$%&'()*+,-./:;<=>?[\]^_`{|}~]{0,0})*([a-zA-Z0-9\xE0\xE8\xE9\xF9\xF2\xEC\x27][!""#$%&'()*+,-./:;<=>?[\]^_`{|}~]{0,0})$/;
var exp_mail = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+[\.]([a-z0-9-]+)*([a-z]{2,3})$/;
var exp_password = /(^[a-zA-Z0-9]{7,})+([a-zA-Z0-9])$/;
var exp_description = /^([a-zA-Z0-9\s\xE0\xE8\xE9\xF9\xF2\xEC\x27!#$%&'()*+,-./:;<=>?[\]^_`{|}~][""]{0,0})*([a-zA-Z0-9\xE0\xE8\xE9\xF9\xF2\xEC\x27!#$%&'()*+,-./:;<=>?[\]^_`{|}~][""]{0,0})$/;
var exp_url = /(https?|ftp|file|ssh):\/\/(((([a-zA-Z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-zA-Z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-zA-Z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-zA-Z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-zA-Z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-zA-Z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-zA-Z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-zA-Z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-zA-Z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-zA-Z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-zA-Z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-zA-Z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-zA-Z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?/;

//------------ variabili generiche --------------------
var max_genre_spotter = 10;
var max_genre = 5;

var json_signup_user = {};
var uploader = null;

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
        tumbnail_pane;

// plugin di fondation per validare i campi tramite espressioni regolari (vedi sopra)
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
//---------------- FINE MOD VALIDAZIONE FONDATIONE -----------------------------

$(document).ready(function() {

    var utente;
    var scheda_succ;
// ----------------------------- SCELTA TIPO UTENTE ----------------------	
    $('#signup01 label').click(function() {
        utente = $(this).attr('for');

        //noscondo la prima scheda signup01
        $('#signup01').hide('slide', {direction: "left"}, "slow");

        //visualizzo i blocchi che indicano lo step
        $('.signup-labelStep').css({"display": "block"});

        //visualizzo le label degli step 
        signupStep1();

        //UTENTE ----------- SPOTTER -----------------
        if (utente == "signup-typeUser-spotter") {
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
        if (utente == "signup-typeUser-jammer") {
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
        if (utente == "signup-typeUser-venue") {
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
    });



    // ------------------------ GESTIONE BOTTONI DI NEXT E BACK ------------------------------

    //-------------------------- PRIMA SCHEDA NEXT ---------------------------------------
    /*
     * Permette di effettuare una verifica dei campi, se i campi non sono tutti validi con va allo step successivo
     * La verifica vera e propria dei campi viene fatta da fondation abide con le espressioni regolari (vedi sopra)
     */
    $('#signup01-signup01 .signup-button').click(function() {
        type_user = "";
        scheda_succ = "";

        var validation_username = false;
        var validation_mail = false;
        var validation_password = false;
        var validation_verifyPassword = false;

        var id = $(this).attr('id');


        if (id == "spotter-signup01-next") {
            type_user = "spotter";
            scheda_succ = '#spotter-signup02';
            getTag('music', 'check', 'spotter', 'spotter-signup02', max_genre_spotter, null);
        }
        if (id == "jammer-signup01-next") {
            type_user = "jammer";
            scheda_succ = '#jammer-signup02';
            getTag('music', 'check', 'jammer', 'jammer-signup03', max_genre, null);
            getTag('instruments', 'select', 'jammer', 'jammer-signup02', null, 2);
        }
        if (id == "venue-signup01-next") {
            type_user = "venue";
            scheda_succ = '#venue-signup02';
            getTag('localType', 'check', 'venue', 'venue-signup03', max_genre, null);

        }

        //validation username
        var espressione = new RegExp(exp_username);
        if (!espressione.test($('#signup01-username').val())) {
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
        //console.log(validateCaptcha());

        // va allo step successivo se tutti i campi sono validi
        if (validation_username && validation_mail && validation_password && validation_verifyPassword) {
            $('#signup01-signup01').hide('slide', {direction: "left"}, "slow");
            setTimeout(function() {
                $(scheda_succ).show('slide', {direction: "right"}, "slow");
            }, 600);
            signupStep2();
            if (type_user == "jammer") {
                $('#signup02-jammer-name-artist').text($('#signup01-username').val() + ", ");
            }
        }

    });
    //----------------------- signup01-back ------------------
    $('#signup01-back').click(function() {
        $('#signup01-signup01').hide('slide', {direction: "right"}, "slow");
        setTimeout(function() {
            $('#signup01').show('slide', {direction: "left"}, "slow");
        }, 600);
        $('.signup-labelStep').css({"display": "none"});
    });
    //----------------------- spotter-signup02-next ------------------
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
            signupStep3();
        }
    });
    //----------------------- spotter-signup02-back ------------------
    $('#spotter-signup02-back').click(function() {
        $('#spotter-signup02').hide('slide', {direction: "right"}, "slow");
        setTimeout(function() {
            $('#signup01-signup01').show('slide', {direction: "left"}, "slow");
        }, 600);
        //il secondo blocco dello step sara' arancione gli altri arancione scuro
        signupStep1();
    });
    //----------------------- spotter-signup03-next ------------------
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
    //----------------------- spotter-signup03-back ------------------
    $('#spotter-signup03-back').click(function() {
        $('#spotter-signup03').hide('slide', {direction: "right"}, "slow");
        setTimeout(function() {
            $('#spotter-signup02').show('slide', {direction: "left"}, "slow");
        }, 600);
        //il secondo blocco dello step sara' arancione gli altri arancione scuro
        signupStep2();
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
    //----------------------- jammer-signup02-next ------------------
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
            signupStep3();
        }
    });
    //----------------------- jammer-signup02-back ------------------
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
    //----------------------- jammer-signup03-next ------------------
    $('#jammer-signup03-next').click(function() {
        var validation_genre = false;
        var validation_description = false;
        //validation county
        var espressione = new RegExp(exp_username);
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
    //----------------------- jammer-signup03-back ------------------
    $('#jammer-signup03-back').click(function() {

        $('#jammer-signup03').hide('slide', {direction: "right"}, "slow");
        setTimeout(function() {
            $('#jammer-signup02').show('slide', {direction: "left"}, "slow");
        }, 600);
        //il secondo blocco dello step sara' arancione gli altri arancione scuro
        signupStep2();
    });
    //----------------------- venue-signup02-next ------------------
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
            signupStep3();
        }
    });
    //----------------------- venue-signup02-back ------------------
    $('#venue-signup02-back').click(function() {
        $('#venue-signup02').hide('slide', {direction: "right"}, "slow");
        setTimeout(function() {
            $('#signup01-signup01').show('slide', {direction: "left"}, "slow");
        }, 600);
        //il secondo blocco dello step sara' arancione gli altri arancione scuro
        signupStep1();
    });
    //----------------------- venue-signup03-next ------------------
    $('#venue-signup03-next').click(function() {
        var validation_genre = false;
        var validation_description = false;
        //validation county
        var espressione = new RegExp(exp_username);
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
    //----------------------- venue-signup03-back ------------------
    $('#venue-signup03-back').click(function() {
        $('#venue-signup03').hide('slide', {direction: "right"}, "slow");
        setTimeout(function() {
            $('#venue-signup02').show('slide', {direction: "left"}, "slow");
        }, 600);
        //il secondo blocco dello step sara' arancione gli altri arancione scuro
        signupStep2();
    });

    // ------------------------ FINE GESTIONE BOTTONE DI REGISTRAZIONE FINALE ------------------------------

    /*
     * Permette di gestire i bottni social, a seconda dell'icona che viene cliccata 
     * viene visualizzato l'imput text corrispodente
     */
    $('.signup-social-button a').click(function() {
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
    });
    /*
     * viene utilizzata per aumentare il numero di componenti della band
     */
    var numComponent = 3;
    $('.addComponents').click(function() {

        text = '<div class="row jammer-componentName' + numComponent + '-singup02"> <div  class="small-12 columns"> <input type="text" name="jammer-componentName' + numComponent + '" id="jammer-componentName' + numComponent + '" pattern="username" maxlength="50"/>	<label for="jammer-componentName' + numComponent + '" >Name<small class="error"> Please enter a valid Name</small></label> </div> </div>';
        $('#addComponentName').append(text);
        text = '<div class="row jammer-componentInstrument' + numComponent + '-singup02"> <div  class="small-12 columns"> <select id="jammer_componentInstrument' + numComponent + '" ></select>	<label for="jammer-componentInstrument' + numComponent + '" >Instrument<small class="error"> Please enter a valid Instrument</small></label> </div> </div>';
        $('#addComponentInstrument').append(text);
        getTag('intruments', 'jammer', 'jammer-signup02', null, 'select', numComponent);
        numComponent = numComponent + 1;
    });

    function signupStep1() {
        $('#signup-labelStep-step1').css({"background-color": "#FF7505"});
        $('#signup-labelStep-step1').css({"color": "#F3F3F3"});
        $('#signup-labelStep-step2').css({"background-color": "#C95600"});
        $('#signup-labelStep-step2').css({"color": "#D8D8D8"});
        $('#signup-labelStep-step3').css({"background-color": "#C95600"});
        $('#signup-labelStep-step3').css({"color": "#D8D8D8"});
    }
    function signupStep2() {
        $('#signup-labelStep-step2').css({"background-color": "#FF7505"});
        $('#signup-labelStep-step2').css({"color": "#F3F3F3"});
        $('#signup-labelStep-step1').css({"background-color": "#C95600"});
        $('#signup-labelStep-step1').css({"color": "#D8D8D8"});
        $('#signup-labelStep-step3').css({"background-color": "#C95600"});
        $('#signup-labelStep-step3').css({"color": "#D8D8D8"});
    }
    function signupStep3() {
        $('#signup-labelStep-step3').css({"background-color": "#FF7505"});
        $('#signup-labelStep-step3').css({"color": "#F3F3F3"});
        $('#signup-labelStep-step1').css({"background-color": "#C95600"});
        $('#signup-labelStep-step1').css({"color": "#D8D8D8"});
        $('#signup-labelStep-step2').css({"background-color": "#C95600"});
        $('#signup-labelStep-step2').css({"color": "#D8D8D8"});
    }


    $('.uploadImage_save').click(function() {
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
    });

    //----------------------------------- FINE SIGNUP -----------------------------------

    //creo il recaptcha all'interno del div "signup01-captcha"
    showCaptcha();
});


/*
 * legge i dati da filename e a seconda del tipo di operazione (typeSelect) inseriesce questi dati nella rispettiva scheda del tipo di utente typeUser
 * -filename: nome del file che verra inviato tramite POST a getTag.php, questo restituisce un array di elementi
 * -typeSelect: tipo di elemento html da inserire dinamicamente (check o select)
 * -typeUser: tipo di utente 
 * -scheda: indica la scheda in cui vannp inseriti i dati
 * -max-check: se typeSelect="check" allora max-check indica il max num di check possibili
 * -number: se typeSelect="select" allora number indica il numero di componentInstrument da inserire
 * 
 * @author: Maria Laura
 * 
 */
function getTag(typeTag, typeSelect, typeUser, scheda, max_check, number) {

    //carica i tag music
    $.ajax({
        url: "../config/views/tag.config.json",
        dataType: 'json',
        success: function(data, stato) {
            var music = '';
            if (typeTag == 'instruments')
                music = data.instruments;
            if (typeTag == 'localType')
                music = data.localType;
            if (typeTag == 'music')
                music = data.music;

            for (var value in music) {

                if (typeSelect == "check") {
                    $('<input type="checkbox" name="' + typeUser + '-genre[' + value + ']" id="' + typeUser + '-genre[' + value + ']" value="' + value + '" class="no-display"><label for="' + typeUser + '-genre[' + value + ']">' + music[value] + '</label>').appendTo('#' + scheda + ' .signup-genre');
                    //Limita il numero di checked per quanto riguarda il genre dello JAMMER (max 5)
                    $("#" + scheda + " .signup-genre input[type='checkbox']").click(function() {
                        $("#" + scheda + " .label-signup-genre .error").css({'display': 'none'});
                        var bol = $("#" + scheda + " .signup-genre input[type='checkbox']:checked").length >= max_check;
                        $("#" + scheda + " .signup-genre input[type='checkbox']").not(":checked").attr("disabled", bol);
                    });
                }
                else {
                    if (number == 2) {
                        $('<option name="' + typeUser + '-componentInstrument1" id="' + typeUser + '-componentInstrument1" value="' + music[value] + '">' + music[value] + '</option>').appendTo('#jammer_componentInstrument1');
                        $('<option name="' + typeUser + '-componentInstrument2" id="' + typeUser + '-componentInstrument2" value="' + music[value] + '">' + music[value] + '</option>').appendTo('#jammer_componentInstrument2');

                    }
                    else {
                        $('<option name="' + typeUser + '-componentInstrument' + number + '" id="' + typeUser + '-componentInstrument' + number + '" value="' + music[value] + '">' + music[value] + '</option>').appendTo('#jammer_componentInstrument' + number + '');

                    }

                }

            }

        },
        error: function(richiesta, stato, errori) {
            console.log("E' evvenuto un errore. Il stato della chiamata: " + stato);
        }
    });


    /*
     $.ajax({
     url: "utilities/readFile.php",
     type: 'POST',
     dataType: 'json',
     data: {file_name_txt: fileName},
     success: function(data, stato) {
     $.each(data, function(index, val) {
     text = val.split('\n');
     if (typeSelect == "check") {
     $('<input type="checkbox" name="' + typeUser + '-genre[' + index + ']" id="' + typeUser + '-genre[' + index + ']" value="' + index + '" class="no-display"><label for="' + typeUser + '-genre[' + index + ']">' + text[0] + '</label>').appendTo('#' + scheda + ' .signup-genre');
     //Limita il numero di checked per quanto riguarda il genre dello JAMMER (max 5)
     $("#" + scheda + " .signup-genre input[type='checkbox']").click(function() {
     $("#" + scheda + " .label-signup-genre .error").css({'display': 'none'});
     var bol = $("#" + scheda + " .signup-genre input[type='checkbox']:checked").length >= max_check;
     $("#" + scheda + " .signup-genre input[type='checkbox']").not(":checked").attr("disabled", bol);
     });
     }
     else {
     if (number == 2) {
     $('<option name="' + typeUser + '-componentInstrument1" id="' + typeUser + '-componentInstrument1" value="' + text[0] + '">' + text[0] + '</option>').appendTo('#jammer_componentInstrument1');
     $('<option name="' + typeUser + '-componentInstrument2" id="' + typeUser + '-componentInstrument2" value="' + text[0] + '">' + text[0] + '</option>').appendTo('#jammer_componentInstrument2');
     
     }
     else {
     $('<option name="' + typeUser + '-componentInstrument' + number + '" id="' + typeUser + '-componentInstrument' + number + '" value="' + text[0] + '">' + text[0] + '</option>').appendTo('#jammer_componentInstrument' + number + '');
     
     }
     
     }
     
     });
     },
     error: function(richiesta, stato, errori) {
     alert("E' evvenuto un errore. Il stato della chiamata: " + stato);
     }
     });
     */
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

        },
        error: function(data, status) {
            console.log("[validateCaptcha] errore.data : " + JSON.stringify(data));
            console.log("[validateCaptcha] errore.status : " + status);

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
    var url = "../controllers/request/uploadRequest.php";
    var runtime = 'html4';
    var multi_selection = false;
    var maxFileSize = "10mb";

    switch (userType) {
        case  "SPOTTER" :
            containerId = "spotter_container";
            selectButtonId = "spotter_uploadImage_file_label";

            break;
        case  "VENUE" :
            containerId = "venue_container";
            selectButtonId = "venue_uploadImage_file_label";
            break;
        case  "JAMMER" :
            containerId = "jammer_container";
            selectButtonId = "jammer_uploadImage_file_label";
            break;
    }

//creo l'oggetto uploader (l'ho dichiarato ad inizio js in modo che sia globale)
    uploader = new plupload.Uploader({
        runtimes: runtime, //runtime di upload
        browse_button: selectButtonId, //id del pulsante di selezione file
        container: containerId, //id del div per l'upload
        max_file_size: maxFileSize, //dimensione max dei file da caricare
        multi_selection: multi_selection, //forza un file alla volta per upload
        url: url,
        filters: [
            {title: "Image files", extensions: "jpg,gif,png"}, //lista file accettati
        ],
        multipart_params: {"request": "uploadImage"}, //parametri passati in POST
    });

    uploader.bind('Init', function(up, params) {
//        window.console.log("initUploader - EVENT: Ini");
        $('#filelist').html("");
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
        json_signup_user.imageProfile = obj.src;

        //qua ora va attivato il jcrop
        var img = new Image();
        img.src = "../media/cache/" + obj.src;
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