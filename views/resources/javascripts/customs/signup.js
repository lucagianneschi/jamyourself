//---------------- VALIDAZIONE FOUNDATION abide  ----------------------------- 
//------ espressioni regolari -------------------------------
var exp_username = /^([a-zA-Z0-9\s\xE0\xE8\xE9\xF9\xF2\xEC\x27][!""#$%&'()*+,-./:;<=>?[\]^_`{|}~]{0,0})*([a-zA-Z0-9\xE0\xE8\xE9\xF9\xF2\xEC\x27][!""#$%&'()*+,-./:;<=>?[\]^_`{|}~]{0,0})$/;
var exp_mail = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+[\.]([a-z0-9-]+)*([a-z]{2,3})$/;
var exp_password = /(^[a-zA-Z0-9]{7,})+([a-zA-Z0-9])$/;
var exp_description = /^([a-zA-Z0-9\s\xE0\xE8\xE9\xF9\xF2\xEC\x27!#$%&'()*+,-./:;<=>?[\]^_`{|}~][""]{0,0})*([a-zA-Z0-9\xE0\xE8\xE9\xF9\xF2\xEC\x27!#$%&'()*+,-./:;<=>?[\]^_`{|}~][""]{0,0})$/;
var exp_url =  /(https?|ftp|file|ssh):\/\/(((([a-zA-Z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-zA-Z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-zA-Z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-zA-Z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-zA-Z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-zA-Z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-zA-Z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-zA-Z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-zA-Z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-zA-Z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-zA-Z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-zA-Z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-zA-Z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?/;

//------------ variabili generiche --------------------
var max_genre_spotter = 10;
var max_genre = 5;

// plugin di fondation per validare i campi tramite espressioni regolari (vedi sopra)
$(document).foundation('abide', {
	live_validate : true,
  	focus_on_invalid : true,
  	timeout : 1000,
    patterns: {    	
      	username: exp_username, 
      	mail : exp_mail,
      	password : exp_password,
      	description : exp_description,
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
		$('#signup01').hide('slide', { direction: "left" }, "slow");
		
		//visualizzo i blocchi che indicano lo step
		$('.signup-labelStep').css({"display":"block"});
		
		//visualizzo le label degli step 
		signupStep1();	
		
		//UTENTE ----------- SPOTTER -----------------
		if(utente == "signup-typeUser-spotter"){
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
	       		$('#signup01-signup01').show('slide', { direction: "right" }, "slow");     
	      	}, 600 );
	      	
	      	
		}		
		//UTENTE ----------- JAMMER -----------------
		if(utente == "signup-typeUser-jammer"){
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
	       		$('#signup01-signup01').show('slide', { direction: "right" }, "slow");     
	      	}, 600 );
		}
		//UTENTE ----------- venue -----------------
		if(utente == "signup-typeUser-venue"){
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
	       		$('#signup01-signup01').show('slide', { direction: "right" }, "slow");     
	      	}, 600 );
		}		
	});
	
	
	
	// ------------------------ GESTIONE BOTTONI DI NEXT E BACK ------------------------------
		
	//-------------------------- PRIMA SCHEDA NEXT ---------------------------------------
	/*
	 * Permette di effettuare una verifica dei campi, se i campi non sono tutti validi con va allo step successivo
	 * La verifica vera e propria dei campi viene fatta da fondation abide con le espressioni regolari (vedi sopra)
	 */		
	$('#signup01-signup01 .signup-button').click(function() {
		var type_user = "";
		scheda_succ = "";
		
		var validation_username = false;
    	var validation_mail = false;
    	var validation_password = false;
    	var validation_verifyPassword = false;
		
		var id = $(this).attr('id');
		
				
		if(id == "spotter-signup01-next"){ 
			type_user = "spotter"; 
			scheda_succ = '#spotter-signup02';
			readFile('music.txt','check','spotter','spotter-signup02',max_genre_spotter,null); 
			
		} 
		if(id == "jammer-signup01-next"){ 
			type_user = "jammer"; 
			scheda_succ = '#jammer-signup02';
			readFile('music.txt','check','jammer','jammer-signup03',max_genre,null);
			 readFile('intruments.txt','select','jammer','jammer-signup02',null,2);
		}
		if(id == "venue-signup01-next") {
			type_user = "venue"; 
			scheda_succ = '#venue-signup02';
			readFile('localType.txt','check','venue','venue-signup03',max_genre,null);
			
		}
					    
	    //validation username
	    var espressione = new RegExp(exp_username);		
		if ( !espressione.test($('#signup01-username').val())){
			 $('#signup01-username').focus();
			validation_username = false;
		}
		else validation_username = true;
		
		//validation mail
	    var espressione = new RegExp(exp_mail);		
		if ( !espressione.test($('#signup01-mail').val())){
			 $('#signup01-mail').focus();
			validation_mail = false;
		}
		else validation_mail = true;		
		
		//validation password
	    var espressione = new RegExp(exp_password);		
		if ( !espressione.test($('#signup01-password').val())){
			 $('#signup01-password').focus();
			validation_password = false;
		}
		else validation_password = true;
		
		//verify password
		if ($('#signup01-verifyPassword').val() == "" || !( $('#signup01-password').val() == $('#signup01-verifyPassword').val() )){
			$('#signup01-verifyPassword').focus();
			$('.signup01-verifyPassword-signup01 small.error').css({'display':'block'});
			validation_verifyPassword = false;		
		}	
    	else{
    		$('.signup01-verifyPassword-signup01 small.error').css({'display':'none'});
    		validation_verifyPassword = true;
    	} 
		//console.log(validateCaptcha());
		
		// va allo step successivo se tutti i campi sono validi
		if(validation_username && validation_mail && validation_password && validation_verifyPassword){			
			$('#signup01-signup01').hide('slide', { direction: "left" }, "slow");
			setTimeout(function() {
       		$(scheda_succ).show('slide', { direction: "right" }, "slow");     
      		}, 600 );			
			signupStep2();			
			if(type_user == "jammer"){
				$('#signup02-jammer-name-artist').text($('#signup01-username').val()+", ");
			}
		}
		
	});	
	//----------------------- signup01-back ------------------
	 $('#signup01-back').click(function() {
	 	$('#signup01-signup01').hide('slide', { direction: "right" }, "slow");
			setTimeout(function() {
	   			$('#signup01').show('slide', { direction: "left" }, "slow");     
	  		}, 600 );	
	  	$('.signup-labelStep').css({"display": "none"});		
	 });
    //----------------------- spotter-signup02-next ------------------
    $('#spotter-signup02-next').click(function() {
    	var validation_city = false;
    	var validation_country = false;
    	var validation_genre = false;
    	
    	//controllo se sono stati inseriti city e country
    	//validation county
	    var espressione = new RegExp(exp_username);		
		if ( !espressione.test($('#spotter-city').val())){
			 $('#spotter-city').focus();
			 validation_city = false;
		}
		else validation_city = true;
		
		//validation county
	    var espressione = new RegExp(exp_username);		
		if ( !espressione.test($('#spotter-country').val())){
			 $('#spotter-country').focus();
			 validation_country = false;	
		}
		else validation_country = true;	
    	
    	//controllo se almeno esiste un checked per genre    	    	 
    	if(!$(".signup-genre input[type='checkbox']").is(':checked')){
    		$(".label-signup-genre .error").css({'display':'block'});
    		validation_genre = false;
    	}
    	else{
    		validation_genre = true;
    		$(".label-signup-genre .error").css({'display':'none'});
    	} 
    	
    	//vado avanti se genre city e county sono validati    	
    	if(validation_city && validation_country && validation_genre){		
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
		if ( !espressione.test($('#spotter-description').val())){
			 $('#spotter-description').focus();
			 validation_description = false;
		}
		else validation_description = true;
    	
    	if(validation_description){	
	        $('#spotter-signup03').hide('slide', {direction: "left"}, "slow");
	        setTimeout(function() {
	            $('#signup-ok').show('slide', {direction: "right"}, "slow");
	        }, 600);
	
	        $('.signup-labelStep').css({"display": "none"});
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
    	if(id == "jammer-typeArtist-band"){
    		$('#jammer-component-signup02').removeClass('no-display');
    	}
    	else $('#jammer-component-signup02').addClass('no-display');
    });
    
    //----------------------- jammer-signup02-next ------------------
    $('#jammer-signup02-next').click(function() {
    	
    	var validation_city = false;
    	var validation_country = false;
    	var validation_typeArtist = false;
    	
    	//controllo se sono stati inseriti city e country
    	//validation county
	    var espressione = new RegExp(exp_username);		
		if ( !espressione.test($('#jammer-city').val())){
			 $('#jammer-city').focus();
			 validation_city = false;
		}
		else validation_city = true;
		
		//validation county
	    var espressione = new RegExp(exp_username);		
		if ( !espressione.test($('#jammer-country').val())){
			 $('#jammer-country').focus();
			  validation_county = false;
		}
		else validation_county = true;
    	
    	//controllo campo  jammer-typeArtist  	 
    	if(!$("input[name='jammer-typeArtist']").is(':checked')){
    		$("#jammer-typeArtist-label .error").css({'display':'block'});
    		validation_typeArtist = false;
    	}
    	else{
    		validation_typeArtist = true;
    		$("#jammer-typeArtist-label .error").css({'display':'none'});
    	} 
    	
    	    	
    	if(validation_county && validation_city && validation_typeArtist){	
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
		if ( !espressione.test($('#jammer-description').val())){
			 $('#jammer-description').focus();
			 validation_description = false;	
		}
		else validation_description = true;	
    	
    	//controllo se almeno esiste un checked per genre    	    	 
    	if(!$("#jammer-signup03 .signup-genre input[type='checkbox']").is(':checked')){
    		$("#jammer-signup03 .label-signup-genre .error").css({'display':'block'});
    		validation_genre = false;
    	}
    	else{
    		validation_genre = true;
    	} 
    	
    	//vado avanti se genre city e county sono validati    	
    	if(validation_description && validation_genre){	
    		console.log("ciao");
	        $('#jammer-signup03').hide('slide', {direction: "left"}, "slow");
	        setTimeout(function() {
	            $('#signup-ok').show('slide', {direction: "right"}, "slow");
	        }, 600);
	
	        $('.signup-labelStep').css({"display": "none"});
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
		if ( !espressione.test($('#venue-country').val())){
			 $('#venue-country').focus();
			 validation_country = false;	
		}
		else validation_country = true;
		
		if ( !espressione.test($('#venue-city').val())){
			 $('#venue-city').focus();
			 validation_city = false;	
		}
		else validation_city = true;
					
		if ( !espressione.test($('#venue-province').val())){
			 $('#venue-province').focus();
			 validation_zipcode = false;	
		}
		else validation_zipcode = true;
					
		if ( !espressione.test($('#venue-adress').val())){
			 $('#venue-adress').focus();
			 validation_adress = false;	
		}
		else validation_adress = true;
					
		if ( !espressione.test($('#venue-number').val())){
			 $('#venue-number').focus();
			 validation_number = false;	
		}
		else validation_number = true;		
    	    	
    	//vado avanti se genre city e county sono validati    	
    	if(validation_country && validation_city && validation_zipcode && validation_adress && validation_number){	
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
		if ( !espressione.test($('#venue-description').val())){
			 $('#venue-description').focus();
			 validation_description = false;	
		}
		else validation_description = true;	
    	
    	//controllo se almeno esiste un checked per genre    	    	 
    	if(!$("#venue-signup03 .signup-genre input[type='checkbox']").is(':checked')){
    		$("#venue-signup03 .label-signup-genre .error").css({'display':'block'});
    		validation_genre = false;
    	}
    	else{
    		validation_genre = true;
    	} 
    	
    	//vado avanti se genre city e county sono validati    	
    	if(validation_description && validation_genre){	
	        $('#venue-signup03').hide('slide', {direction: "left"}, "slow");
	        setTimeout(function() {
	            $('#signup-ok').show('slide', {direction: "right"}, "slow");
	        }, 600);
	
	        $('.signup-labelStep').css({"display": "none"});
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

        text = '<div class="row jammer-componentName' + numComponent + '-singup02"> <div  class="small-12 columns"> <input type="text" name="jammer-componentName' + numComponent + '" id="jammer-componentName' + numComponent + '" pattern="username" maxlength="50"/>	<label for="jammer-componentName' + numComponent + '" >Name<small class="error"> Please enter a valid Name</small></label> </div> </div>';
        $('#addComponentName').append(text);
        text = '<div class="row jammer-componentInstrument' + numComponent + '-singup02"> <div  class="small-12 columns"> <select id="jammer_componentInstrument' + numComponent + '" ></select>	<label for="jammer-componentInstrument' + numComponent + '" >Instrument<small class="error"> Please enter a valid Instrument</small></label> </div> </div>';
        $('#addComponentInstrument').append(text);
        readFile('intruments.txt','jammer','jammer-signup02',null,'select',numComponent);
        numComponent = numComponent + 1;
    });
	
	function signupStep1(){		
		$('#signup-labelStep-step1').css({"background-color":"#FF7505"});
		$('#signup-labelStep-step1').css({"color":"#F3F3F3"});
		$('#signup-labelStep-step2').css({"background-color":"#C95600"});
		$('#signup-labelStep-step2').css({"color":"#D8D8D8"});
		$('#signup-labelStep-step3').css({"background-color":"#C95600"});
		$('#signup-labelStep-step3').css({"color":"#D8D8D8"});
	}
	function signupStep2(){		
		$('#signup-labelStep-step2').css({"background-color":"#FF7505"});
		$('#signup-labelStep-step2').css({"color":"#F3F3F3"});
		$('#signup-labelStep-step1').css({"background-color":"#C95600"});
		$('#signup-labelStep-step1').css({"color":"#D8D8D8"});
		$('#signup-labelStep-step3').css({"background-color":"#C95600"});
		$('#signup-labelStep-step3').css({"color":"#D8D8D8"});
	}
	function signupStep3(){		
		$('#signup-labelStep-step3').css({"background-color":"#FF7505"});
		$('#signup-labelStep-step3').css({"color":"#F3F3F3"});
		$('#signup-labelStep-step1').css({"background-color":"#C95600"});
		$('#signup-labelStep-step1').css({"color":"#D8D8D8"});
		$('#signup-labelStep-step2').css({"background-color":"#C95600"});
		$('#signup-labelStep-step2').css({"color":"#D8D8D8"});
	}
	
	//----------------------------------- IMAGE UPLOAD ----------------------------------
	var signup_preview,
		signup_tumbnail,
		signup_tumbnail_pane,
		signup_type_user,
		signup_input_x,
		signup_input_y,
		signup_input_w,
		signup_input_h,
		signup_jcrop_api,
		signup_boundx,
		signup_boundy,
		signup_xsize,	
		signup_ysize;	
	
	var signup_img = new Image();
	
	$('.uploadImage input[type=file]').change(function(e) {		
		
		var type_user_split = this.id.split('_');
		
		signup_type_user = type_user_split[0];
		
		signup_preview = $('#'+signup_type_user+'_uploadImage_preview');
		signup_tumbnail = 	$('#'+signup_type_user+'_uploadImage_tumbnail');
		signup_tumbnail_pane = $('#'+signup_type_user+'_uploadImage_tumbnail-pane');
		
		id_tumbnail = signup_tumbnail.attr('id');
		id_preview = signup_preview.attr('id');
		
		$.each($('#'+signup_type_user+'_uploadImage_preview_box input[type="hidden"]'), function(k, v) {
			switch(k){
				case 0: signup_input_x = v.id;break;
				case 1: signup_input_y = v.id;break;
				case 2: signup_input_w = v.id;break;
				case 3: signup_input_h = v.id;break;
			}
		});	
			
		if(signup_jcrop_api){
			signup_jcrop_api.destroy();
			 signup_jcrop_api.setOptions({ allowSelect: !!this.checked });
     		 signup_jcrop_api.focus();     		 
     		 signup_tumbnail.remove();
     		 $('#'+signup_type_user+'_uploadImage_preview_box').html('<img src="" id="'+id_preview+'" /><input type="hidden" id="'+signup_input_x+'" name="'+signup_input_x+'" value="0"/><input type="hidden" id="'+signup_input_y+'" name="'+signup_input_y+'" value="0"/><input type="hidden" id="'+signup_input_w+'" name="'+signup_input_w+'" value="100"/><input type="hidden" id="'+signup_input_h+'" name="'+signup_input_h+'" value="100"/>');
     		 signup_preview = $('#'+signup_type_user+'_uploadImage_preview');     		 
     		 signup_tumbnail_pane.html('<img src="" id="'+id_tumbnail+'"/>');
     		 signup_tumbnail = $('#'+id_tumbnail);
		}
		
		//FILE CARICATO NON DEFINITO
		if(typeof FileReader == "undefined"){
			alert( "File undefined!" );
			return true;
		}
		
		var file = e.target.files[0]; 
		
		if(file.type == 'image/gif' || file.type == 'image/jpeg' || file.type == 'image/png'){  
			var reader = new FileReader();
			reader.onload = (function(theFile) {
				return function(e) {
					//--- URL ------------
					
					signup_img.src = e.target.result; 		
					
					signup_preview.attr('src', signup_img.src);
					
					width =  signup_img.width;  
					height =  signup_img.height; 
					if(signup_img.width > $('.'+signup_type_user+'_uploadImage_box-preview').width()){
		            	width = $('.'+signup_type_user+'_uploadImage_box-preview').width();
		            	height = $('.'+signup_type_user+'_uploadImage_box-preview').height();
		            }
		            		            
		            initJcrop(signup_img.src,width,height); 
			        
				};
			})(file);
			            
			reader.readAsDataURL(file);
			
			$('#'+signup_type_user+'_uploadImage_save').removeClass('no-display');
		}
		else{
			alert("Attenzione: \nErrore nel file "+file.name+"\nLe foto devono avere estensione di tipo: jpg/jpeg, gif, png");
		}
	});
	
	$('.uploadImage_save').click(function() {				
		signup_tumbnail.attr('src', signup_img.src);		
		rx = signup_xsize / $('#'+signup_input_w).val();
    	ry = signup_ysize / $('#'+signup_input_h).val();
		signup_tumbnail.css({
	      	width: Math.round(rx * signup_boundx) + 'px',
	      	height: Math.round(ry * signup_boundy) + 'px',
	      	marginLeft: '-' + Math.round(rx * $('#'+signup_input_x).val()) + 'px',
	      	marginTop: '-' + Math.round(ry * $('#'+signup_input_y).val()) + 'px'
		});		
		
		$('#'+signup_type_user+'-uploadImage').foundation('reveal', 'close');
	});	
	
	function  initJcrop(img,width,height) {
		signup_xsize = signup_tumbnail_pane.width(),
	    signup_ysize = signup_tumbnail_pane.height();	
		signup_preview.Jcrop({
			onChange: updatePreview,
	     	onSelect: updatePreview,	
	      	aspectRatio: signup_xsize / signup_ysize,
	      	
	    },function(){
	    	var bounds = this.getBounds();
	      	signup_boundx = bounds[0];
	      	signup_boundy = bounds[1];
			signup_jcrop_api = this;
			signup_jcrop_api.setImage(img);
			signup_jcrop_api.setOptions({
				boxWidth: width,
				boxHeight:height				
			});
			signup_jcrop_api.animateTo([0,0,100,100]);

		});
		
	}
	function updatePreview(c) {
		$('#'+signup_input_x).val(c.x);
	    $('#'+signup_input_y).val(c.y);
	    $('#'+signup_input_w).val(c.w);
	    $('#'+signup_input_h).val(c.h); 
	}
	
	
	
	
    //----------------------------------- FINE SIGNUP -----------------------------------

    //---------------------------------- STEFANO (was here) ---------------------------------------------//

    //creo il recaptcha all'interno del div "signup01-captcha"
    showCaptcha();

    //imposto un event-handler per la password e la email onblur:
    $('#signup01-username').blur(function() {
        checkUsernameExists($(this).val());
    });

    $('#signup01-mail').blur(function() {
        checkEmailExists($(this).val());
    });

    $('#spotter-signup03-next, #jammer-signup03-next, #venue-signup03-next').click(function() {
        getFormFieldValues();
    });

});


/*
 * legge i dati da filename e a seconda del tipo di operazione (typeSelect) inseriesce questi dati nella rispettiva scheda del tipo di utente typeUser
 * -filename: nome del file che verra inviato tramite POST a readFile.php, questo restituisce un array di elementi
 * -typeSelect: tipo di elemento html da inserire dinamicamente (check o select)
 * -typeUser: tipo di utente 
 * -scheda: indica la scheda in cui vannp inseriti i dati
 * -max-check: se typeSelect="check" allora max-check indica il max num di check possibili
 * -number: se typeSelect="select" allora number indica il numero di componentInstrument da inserire
 * 
 * @author: Maria Laura
 * 
 */
function readFile(fileName,typeSelect,typeUser,scheda,max_check, number){
	$.ajax({
    url : "utilities/readFile.php",
    type : 'POST',
    dataType: 'json',
    data: {file_name_txt : fileName},
    success : function (data,stato) {    	
    	$.each(data, function(index, val) {
			text = val.split('\n');
			if(typeSelect == "check"){
				 $('<input type="checkbox" name="'+typeUser+'-genre['+index+']" id="'+typeUser+'-genre['+index+']" value="'+index+'" class="no-display"><label for="'+typeUser+'-genre['+index+']">'+text[0]+'</label>').appendTo('#'+scheda+' .signup-genre');
				 //Limita il numero di checked per quanto riguarda il genre dello JAMMER (max 5)
				 $("#"+scheda+" .signup-genre input[type='checkbox']").click(function() {
					$("#"+scheda+" .label-signup-genre .error").css({'display':'none'});
		    		var bol = $("#"+scheda+" .signup-genre input[type='checkbox']:checked").length >= max_check;     
		    		$("#"+scheda+" .signup-genre input[type='checkbox']").not(":checked").attr("disabled",bol);
				});
			}
			else{
				if(number == 2){
					$('<option name="'+typeUser+'-componentInstrument1" id="'+typeUser+'-componentInstrument1" value="'+text[0]+'">'+text[0]+'</option>').appendTo('#jammer_componentInstrument1');
					$('<option name="'+typeUser+'-componentInstrument2" id="'+typeUser+'-componentInstrument2" value="'+text[0]+'">'+text[0]+'</option>').appendTo('#jammer_componentInstrument2');
			 	
				}
				else{
					$('<option name="'+typeUser+'-componentInstrument'+number+'" id="'+typeUser+'-componentInstrument'+number+'" value="'+text[0]+'">'+text[0]+'</option>').appendTo('#jammer_componentInstrument'+number+'');
				
				}
				
			}
			
		});    	
    },
    error : function (richiesta,stato,errori) {
        alert("E' evvenuto un errore. Il stato della chiamata: "+stato);
    }
	});
}
/**
 * Da chiamare al momento dell'esecuzione effettiva 
 * della registrazione (onClick "complete")
 * 
 */
function signup() {
    //recupero tutti i campi che l'utente
    //ha inizializzato nel form
    var formData = getFormFieldValues();

    var json_signup = {};
    json_signup.request = "signupTest";
    json_signup.formData = formData;

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

function getFormFieldValues() {
    var dati = $("#form-signup").serialize();
//    window.console.debug(dati);
    return dati;
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
        url: "../controllers/signup/signupRequest.php",
        data: json_email,
        async: true, //mettiamo asincrone se no si blocca la pagina...
        "beforeSend": function(xhr) {
            xhr.setRequestHeader("X-AjaxRequest", "1");
        },
        success: function(data, status) {
            if (data == 1) {
                //gestire in qualche modo la segnalazione all'utente
                console.log("[checkEmailExists] email esistente");
            }
            else {
                //email va bene
                console.log("[checkEmailExists] email NON esistente");
            }
        },
        error: function(data, status) {
            console.log("[checkEmailExists] errore.data : " + data);
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
                console.log("[checkUsernameExists] username esistente");
            } else {
                //username va bene
                console.log("[checkUsernameExists] username NON esistente");
            }
        },
        error: function(data, status) {
            console.log("[checkUsernameExists] errore.data : " + data);
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
function validateCaptcha()
{
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
        url: "../controllers/signup/signupRequest.php",
        data: json_captcha,
        async: false,
        success: function(data, status) {
            //gestione success
            console.log("[validateCaptcha] esito captcha : " + data);
            if (data == "success") {
                //ok...
                console.log("[validateCaptcha] =  captcha valido");
            }
            else {
                //errore
                console.log("[validateCaptcha] =  captcha  NON valido");
                Recaptcha.reload(); //ricarico il captcha
            }

        },
        error: function(data, status) {
            debugger;
            console.log("[validateCaptcha] errore.data : " + data);
            console.log("[validateCaptcha] errore.status : " + status);

        }
    });
}