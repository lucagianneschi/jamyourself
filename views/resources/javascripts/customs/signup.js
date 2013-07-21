$(document).ready(function() {
// ----------------------------- SCELTA TIPO UTENTE ----------------------	
    $('#signup01 label').click(function() {
        var utente = $(this).attr('for');

        //noscondo la prima scheda signup01
        $('#signup01').hide('slide', {direction: "left"}, "slow");

        //visualizzo i blocchi che indicano lo step
        $('.signup-labelStep').css({"display": "block"});

        //il primo blocco dello step sara' arancione gli altri arancione scuro
        $('#signup-labelStep-step1').css({"background-color": "#FF7505"});
        $('#signup-labelStep-step1').css({"color": "#F3F3F3"});

        //UTENTE ----------- SPOTTER -----------------
        if (utente == "signup-typeUser-spotter") {
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
    });

    // ------------------------ GESTIONE BOTTONI DI NEXT E BACK ------------------------------

    /* esempio  di verifica campi scheda spotter signup01
     *  (da non prendere in considerazione il misero controlla ma serve solo come esempio per far visualizzare il messaggio di errore)
     *  #spotter-signup01-next : id del bottone next 
     *  #signup01-mail: id dell'elemento input che corrisponde all'email:
     *  per visualizzare gli elementi che rappresentato l'errore richiamare la classe a cui appartengono, in questo caso
     *  .signup01-mail-signup01 ed indicare l'elemento span.error (la scritta in rosso) e
     *  #signup01-mail per aggiungere la classe error che crea bordo rosso
     *  questi elementi verranno visualizzati tramite css({"display":"inline"})
     * 
     *  Se non ci sono errori viene visualizzata la scheda spotter-signup02	
     */

    $('#signup01-signup01 .signup-button').click(function() {
        var id = $(this).attr('id');

        var type_user = "";
        var scheda_succ = "";

        // ogni volta che un campo è valido sommo count_verify se alla fine tutti i campi sono validati vado avanti con la scheda
        var count_verify = 0;

        if (id == "spotter-signup01-next") {
            type_user = "spotter";
            scheda_succ = '#spotter-signup02';
        }
        if (id == "jammer-signup01-next") {
            type_user = "jammer";
            scheda_succ = '#jammer-signup02'
        }
        ;
        if (id == "venue-signup01-next") {
            type_user = "venue";
            scheda_succ = '#venue-signup02'
        }
        ;

        // validation username		
        var username = $('#signup01-username').val();
        if (username == "") {
            $('#signup01-username').addClass('error');
            $('#signup01-username-' + type_user + ' span.error').css({"display": "inline"});
        }
        else {
            $('#signup01-username').removeClass('error');
            $('#signup01-username-' + type_user + ' span.error').css({"display": "none"});
            count_verify = count_verify + 1;
        }

        // validation mail
        var mail = $('#signup01-mail').val();
        if (mail.indexOf('@') == -1) {
            $('.signup01-mail-signup01 span.error').css({"display": "inline"});
            $('#signup01-mail').addClass('error');
        }
        else {
            $('#signup01-mail').removeClass('error');
            $('.signup01-mail-signup01 span.error').css({"display": "none"});
            count_verify = count_verify + 1;
        }
        // ogni volta che un campo è valido sommo count_verify se alla fine tutti i campi sono validati vado avanti con la scheda
        if (count_verify == 2) {
            $('#signup01-signup01').hide('slide', {direction: "left"}, "slow");
            setTimeout(function() {
                $(scheda_succ).show('slide', {direction: "right"}, "slow");
            }, 600);
            $('#signup-labelStep-step1').css({"background-color": "#C95600"});
            $('#signup-labelStep-step1').css({"color": "#D8D8D8"});
            $('#signup-labelStep-step2').css({"background-color": "#FF7505"});
            $('#signup-labelStep-step2').css({"color": "#F3F3F3"});

            if (type_user == "jammer") {
                $('#signup02-jammer-name-artist').text($('#signup01-username').val() + ", ");
            }
        }

    });
    //----------------------- spotter-signup02-next ------------------
    $('#spotter-signup02-next').click(function() {
        $('#spotter-signup02').hide('slide', {direction: "left"}, "slow");
        setTimeout(function() {
            $('#spotter-signup03').show('slide', {direction: "right"}, "slow");
        }, 600);
        //il secondo blocco dello step sara' arancione gli altri arancione scuro
        $('#signup-labelStep-step2').css({"background-color": "#C95600"});
        $('#signup-labelStep-step2').css({"color": "#D8D8D8"});
        $('#signup-labelStep-step3').css({"background-color": "#FF7505"});
        $('#signup-labelStep-step3').css({"color": "#F3F3F3"});
    });
    //----------------------- spotter-signup02-back ------------------
    $('#spotter-signup02-back').click(function() {
        $('#spotter-signup02').hide('slide', {direction: "right"}, "slow");
        setTimeout(function() {
            $('#signup01-signup01').show('slide', {direction: "left"}, "slow");
        }, 600);
        //il secondo blocco dello step sara' arancione gli altri arancione scuro
        $('#signup-labelStep-step2').css({"background-color": "#C95600"});
        $('#signup-labelStep-step2').css({"color": "#D8D8D8"});
        $('#signup-labelStep-step1').css({"background-color": "#FF7505"});
        $('#signup-labelStep-step1').css({"color": "#F3F3F3"});
    });
    //----------------------- spotter-signup03-next ------------------
    $('#spotter-signup03-next').click(function() {
        $('#spotter-signup03').hide('slide', {direction: "left"}, "slow");
        setTimeout(function() {
            $('#signup-ok').show('slide', {direction: "right"}, "slow");
        }, 600);

        $('.signup-labelStep').css({"display": "none"});

    });
    //----------------------- spotter-signup03-back ------------------
    $('#spotter-signup03-back').click(function() {
        $('#spotter-signup03').hide('slide', {direction: "right"}, "slow");
        setTimeout(function() {
            $('#spotter-signup02').show('slide', {direction: "left"}, "slow");
        }, 600);
        //il secondo blocco dello step sara' arancione gli altri arancione scuro
        $('#signup-labelStep-step3').css({"background-color": "#C95600"});
        $('#signup-labelStep-step3').css({"color": "#D8D8D8"});
        $('#signup-labelStep-step2').css({"background-color": "#FF7505"});
        $('#signup-labelStep-step2').css({"color": "#F3F3F3"});
    });
    //----------------------- spotter-signup03-back ------------------
    $('#jammer-signup02-next').click(function() {
        $('#jammer-signup02').hide('slide', {direction: "left"}, "slow");
        setTimeout(function() {
            $('#jammer-signup03').show('slide', {direction: "right"}, "slow");
        }, 600);
        //il secondo blocco dello step sara' arancione gli altri arancione scuro
        $('#signup-labelStep-step2').css({"background-color": "#C95600"});
        $('#signup-labelStep-step2').css({"color": "#D8D8D8"});
        $('#signup-labelStep-step3').css({"background-color": "#FF7505"});
        $('#signup-labelStep-step3').css({"color": "#F3F3F3"});
    });
    //----------------------- spotter-signup03-back ------------------
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
        $('#jammer-signup03').hide('slide', {direction: "left"}, "slow");
        setTimeout(function() {
            $('#signup-ok').show('slide', {direction: "right"}, "slow");
        }, 600);

        $('.signup-labelStep').css({"display": "none"});

    });
    //----------------------- jammer-signup03-back ------------------
    $('#jammer-signup03-back').click(function() {
        $('#jammer-signup03').hide('slide', {direction: "right"}, "slow");
        setTimeout(function() {
            $('#jammer-signup02').show('slide', {direction: "left"}, "slow");
        }, 600);
        //il secondo blocco dello step sara' arancione gli altri arancione scuro
        $('#signup-labelStep-step3').css({"background-color": "#C95600"});
        $('#signup-labelStep-step3').css({"color": "#D8D8D8"});
        $('#signup-labelStep-step2').css({"background-color": "#FF7505"});
        $('#signup-labelStep-step2').css({"color": "#F3F3F3"});
    });
    //----------------------- venue-signup02-next ------------------
    $('#venue-signup02-next').click(function() {
        $('#venue-signup02').hide('slide', {direction: "left"}, "slow");
        setTimeout(function() {
            $('#venue-signup03').show('slide', {direction: "right"}, "slow");
        }, 600);
        //il secondo blocco dello step sara' arancione gli altri arancione scuro
        $('#signup-labelStep-step2').css({"background-color": "#C95600"});
        $('#signup-labelStep-step2').css({"color": "#D8D8D8"});
        $('#signup-labelStep-step3').css({"background-color": "#FF7505"});
        $('#signup-labelStep-step3').css({"color": "#F3F3F3"});
    });
    //----------------------- venue-signup02-back ------------------
    $('#venue-signup02-back').click(function() {
        $('#venue-signup02').hide('slide', {direction: "right"}, "slow");
        setTimeout(function() {
            $('#signup01-signup01').show('slide', {direction: "left"}, "slow");
        }, 600);
        //il secondo blocco dello step sara' arancione gli altri arancione scuro
        $('#signup-labelStep-step2').css({"background-color": "#C95600"});
        $('#signup-labelStep-step2').css({"color": "#D8D8D8"});
        $('#signup-labelStep-step1').css({"background-color": "#FF7505"});
        $('#signup-labelStep-step1').css({"color": "#F3F3F3"});
    });
    //----------------------- venue-signup03-next ------------------
    $('#venue-signup03-next').click(function() {
        $('#venue-signup03').hide('slide', {direction: "left"}, "slow");
        setTimeout(function() {
            $('#signup-ok').show('slide', {direction: "right"}, "slow");
        }, 600);

        $('.signup-labelStep').css({"display": "none"});

    });
    //----------------------- venue-signup03-back ------------------
    $('#venue-signup03-back').click(function() {
        $('#venue-signup03').hide('slide', {direction: "right"}, "slow");
        setTimeout(function() {
            $('#venue-signup02').show('slide', {direction: "left"}, "slow");
        }, 600);
        //il secondo blocco dello step sara' arancione gli altri arancione scuro
        $('#signup-labelStep-step3').css({"background-color": "#C95600"});
        $('#signup-labelStep-step3').css({"color": "#D8D8D8"});
        $('#signup-labelStep-step2').css({"background-color": "#FF7505"});
        $('#signup-labelStep-step2').css({"color": "#F3F3F3"});
    });
    // ------------------------ FINE GESTIONE BOTTONI DI NEXT E BACK ------------------------------

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

        text = '<div class="row jammer-componentName' + numComponent + '-singup02"> <div  class="small-12 columns"> <input type="text" name="jammer-componentName' + numComponent + '" id="jammer-componentName' + numComponent + '" />	<label for="jammer-componentName' + numComponent + '" >Name</label> </div> </div>'
        $('#addComponentName').append(text);
        text = '<div class="row jammer-componentInstrument' + numComponent + '-singup02"> <div  class="small-12 columns"> <input type="text" name="jammer-componentInstrument' + numComponent + '" id="jammer-componentInstrument' + numComponent + '" />	<label for="jammer-componentInstrument' + numComponent + '" >Instrument</label> </div> </div>'
        $('#addComponentInstrument').append(text);
        numComponent = numComponent + 1;
    });

    //----------------------------------- FINE SIGNUP -----------------------------------

    //---------------------------------- STEFANO (was here) ---------------------------------------------//

    //imposto un event-handler per la password e la email onblur:
    $('#signup01-username').blur(function() {
        checkUsernameExists($(this).val());
    });

    $('#signup01-mail').blur(function() {
        checkEmailExists($(this).val());
    });

    $('#spotter-signup03-next, #jammer-signup03-next, #venue-signup03-next').click(function() {
        var nuovoUtente = getFormFieldValues();
        console.debug(nuovoUtente);
    });
});



/**
 * Da chiamare al momento dell'esecuzione effettiva 
 * della registrazione (onClick "complete")
 * 
 */
function signup() {
    //recupero tutti i campi che l'utente
    //ha inizializzato nel form
    var newUser = getFormFieldValues();

    var json_signup = {};
    json_signup.request = "signup";
    json_signup.newUser = newUser;

    $.ajax({
        type: "POST",
        url: "../controllers/signup/signupRequest.php",
        data: json_signup,
        async: false,
        "beforeSend": function(xhr) {
            xhr.setRequestHeader("X-AjaxRequest", "1");
        },
        success: function(data, status) {
            console.log("[onLoad] [SUCCESS] Status: " + status);
        },
        error: function(data, status) {
            console.log("[onLoad] [ERROR] Status: " + status);
        }
    });

}

/**
 * Recupera i valori dei campi del form d'iscrizione
 */
function getFormFieldValues() {
    var user = {};
    user.username = $("#signup01-username").val()? $("#signup01-username").val() : null;
    user.email = $("#signup01-mail").val()? $("#signup01-mail").val() : null;
    user.password = $("#signup01-password").val()? $("#signup01-password").val() : null;
    user.verifyPassword = $("#signup01-verifyPassword").val()? $("#signup01-verifyPassword").val() : null;
    user.type = $('#signup01 label').attr('for').toUpperCase();

    switch (user.type) {
        case "JAMMER" :
            user.jammerType = $("#jammerType").val()? $().val() : null;
            user.description = $("#jammer-description").val()? $("#jammer-description").val() : null;
            user.music = "";
            user.location = $("#jammer-location").val()? $("#jammer-location").val() : null;
            user.members = '';
            user.fbPage = $("#jammer-facebook").val()? $("#-facebook").val() : null;
            user.twitterPage = $("#jammer-twitter").val()? $("#-twitter").val() : null;
            user.youtubeChannel = $("#jammer-youtube").val()? $("#-youtube").val() : null;
            user.google = $("#jammer-google").val()? $("#-google").val() : null;
            break;
        case "SPOTTER":
            user.music = "";
            user.description = $("#spotter-description").val()? $().val() : null;
            user.firstname = $("#spotter-firstname").val()? $().val() : null;
            user.lastname = $("#spotter-lastname").val()? $().val() : null;
            user.location = $("#spotter-location").val()? $().val() : null;
            user.sex = "";

            var birtdhay = {};
            birtdhay.year = $("#spotter-birth-year").val()? $().val() : null;
            birtdhay.month = $("#spotter-birth-month").val()? $().val() : null;
            birtdhay.day = $("#spotter-birth-day").val()? $().val() : null;

            user.birthday = birtdhay;
            //user.facebookId = $("#").val()? $().val() : null;

            user.fbPage = $("#spotter-facebook").val()? $("#-facebook").val() : null;
            user.twitterPage = $("#spotter-twitter").val()? $("#-twitter").val() : null;
            user.youtubeChannel = $("#spotter-youtube").val()? $("#-youtube").val() : null;
            user.google = $("#spotter-google").val()? $("#-google").val() : null;
            break;
        case "VENUE":
            user.country = $("#venue-country").val()? $().val() : null;
            user.city = $("#venue-city").val()? $().val() : null;
            user.province = $("#venue-province").val()? $().val() : null;
            user.address = $("#venue-adress").val()? $().val() : null;
            user.number = $("#venue-number").val()? $().val() : null;
            user.description = $("#venue-description").val()? $().val() : null;
            user.localType = "";

            user.fbPage = $("#venue-facebook").val()? $("#-facebook").val() : null;
            user.twitterPage = $("#venue-twitter").val()? $("#-twitter").val() : null;
            user.youtubeChannel = $("#venue-youtube").val()? $("#-youtube").val() : null;
            user.google = $("#venue-google").val()? $("#-google").val() : null;
            break;
    }

    return user;
}


/**
 * Verifica se l'email inserita dall'utente esiste gia'
 */
function checkEmailExists(email) {
    var json_email = {};
    json_email.request = "checkEmailExists";
    json_email.email = email; //recupero il valore della email o lo passo come parametro

    $.ajax({
        type: "POST",
        url: "../controllers/signup/signupRequest.php",
        data: json_email,
        async: true, //mettiamo asincrone se no si blocca la pagina...
        "beforeSend": function(xhr) {
            xhr.setRequestHeader("X-AjaxRequest", "1");
        },
        success: function(data, status) {
//            console.log("[onLoad] [SUCCESS] Data: " + data);
//            console.log("[onLoad] [SUCCESS] Status: " + status);
            if (data == 1) {
                //gestire in qualche modo la segnalazione all'utente
                alert("Email already exists!");
            }
            else {
                //email va bene
            }
        },
        error: function(data, status) {
//            console.log("[onLoad] [ERROR] Status: " + status);
        }
    });
}

/**
 * Verifica se lo username inserito dall'utente esiste gia'
 */
function checkUsernameExists(username) {
    var json_username = {};
    json_username.request = "checkUsernameExists";
    json_username.username = username; //recupero il valore della email o lo passo come parametro

    $.ajax({
        type: "POST",
        url: "../controllers/signup/signupRequest.php",
        data: json_username,
        async: true, //mettiamo asincrone se no si blocca la pagina...
        "beforeSend": function(xhr) {
            xhr.setRequestHeader("X-AjaxRequest", "1");
        },
        success: function(data, status) {
//            console.log("[onLoad] [SUCCESS] Data: " + data);
//            console.log("[onLoad] [SUCCESS] Status: " + status);
            if (data == 1) {
                //gestire in qualche modo la segnalazione all'utente
                alert("Username already taken!");
            } else {
                //username va bene
            }
        },
        error: function(data, status) {
//            console.log("[onLoad] [ERROR] Status: " + status);
        }
    });
}