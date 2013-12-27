//---------------- VALIDAZIONE FOUNDATION abide  ----------------------------- 
//------ espressioni regolari -------------------------------
var exp_description = /^([a-zA-Z0-9\s\xE0\xE8\xE9\xF9\xF2\xEC\x27!#$%&'()*+,-./:;<=>?[\]^_`{|}~][""]{0,0})*([a-zA-Z0-9\xE0\xE8\xE9\xF9\xF2\xEC\x27!#$%&'()*+,-./:;<=>?[\]^_`{|}~][""]{0,0})$/;


$(document).ready(function() {
		
    //scorrimento lista album  
   var sliderInstance =  $("#uploadAlbum-listAlbumTouch").touchCarousel({
        pagingNav: false,
        snapToItems: true,
        itemsPerMove: 1,
        scrollToLast: false,
        loopItems: false,
        scrollbar: false,
        dragUsingMouse: false
    }).data("touchCarousel"); 
         

    //gestione select album record
    $('.uploadAlbum-boxSingleAlbum').click(function() {
        $("#uploadAlbum01").fadeOut(100, function() {
            $("#uploadAlbum03").fadeIn(100);
        });
        
    });

    //gesione button create new 
    $('#uploadAlbum-new').click(function() {
        $("#uploadAlbum01").fadeOut(100, function() {
            $("#uploadAlbum02").fadeIn(100);
            autoComplete('#uploadAlbum #featuring');
            initGeocomplete();
        });
    });

    //gestione button new in uploadAlbum02
    $('#uploadAlbum02-next').click(function() {
        var validation_title,validation_description  = true; 
        //controllo validazione campi di uploadAlbum2
        var espressione = new RegExp(exp_description);        
       //validation description
        if (!espressione.test($('#description').val())) {
            $('#description').focus();
         //   $('label[for="description"] small.error').css({'display':'block'});
            validation_description = false;
        }else{
        	validation_description = true;
        }
        //validation title        
        if (!espressione.test($('#albumTitle').val())) {
            $('#albumTitle').focus();
          //  $('label[for="albumTitle"] small.error').css({'display':'block'});
            validation_title = false;
        }
        else{
        	validation_title = true;
        }
        if(validation_title && validation_description){
        	$("#uploadAlbum02").fadeOut(100, function() {
	            $("#uploadAlbum03").fadeIn(100);         
	            
	        });
        }
    });

    //gesione button publish 
    $('#uploadAlbum03-publish').click(function() {
      //  publish();
    });

       
   
    
/*
    $("#albumFeaturing").fcbkcomplete({
        json_url: "../controllers/request/uploadAlbumRequest.php?request=getFeaturingJSON",
        addontab: true,
        addoncomma: false,
        input_min_size: 0,
        height: 10,
        width:"100%",
        cache: true,
        maxshownitems: 10,
        newel: false
    });
    $("#trackFeaturing").fcbkcomplete({
        json_url: "../controllers/request/uploadAlbumRequest.php?request=getFeaturingJSON",
        addontab: true,
        width:"100%",
        addoncomma: false,
        input_min_size: 0,
        height: 10,
        cache: true,
        maxshownitems: 10,
        newel: false
    });
  */  
//    Per stampare in console l'array del featuring:
//    
//        $.getJSON("../controllers/request/uploadAlbumRequest.php?request=getFeaturingJSON", function(data) {
//            console.log("featuring: list : ");
//            console.log(JSON.stringify(data));
//    });

});

// plugin di fondation per validare i campi tramite espressioni regolari (vedi sopra)
$(document).foundation('abide', {
    live_validate: true,
    focus_on_invalid: true,
    timeout: 1000,
    patterns: {        
        description: exp_description,
    }
});

//autocomplete
function autoComplete(box){
	$(box).fcbkcomplete({
        json_url: "../controllers/request/uploadRecordEvent.php?request=getFeaturingJSON",
        width:"100%",
        input_min_size: 0,
        height: 10,
        cache: true,
        maxshownitems: 20,
        onselect: function(){        	
       		//$('.bit-input').addClass('no-display'); 			
        },
        onremove: function(){
        	//$('.bit-input').removeClass('no-display');
        }
    });
}


function initGeocomplete() {
    try {
        $("#city").geocomplete()
                .bind("geocode:result", function(event, result) {
            json_event_create.city = prepareLocationObj(result);
            var complTest = getCompleteLocationInfo(json_event_create.city);
        })
                .bind("geocode:error", function(event, status) {
            json_event_create.city = null;

        })
                .bind("geocode:multiple", function(event, results) {
            json_event_create.city = prepareLocationObj(results[0]);
        });

    } catch (err) {
        console.log("initGeocomplete | An error occurred - message : " + err.message);
    }

}