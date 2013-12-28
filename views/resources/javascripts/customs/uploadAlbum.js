//---------------- VALIDAZIONE FOUNDATION abide  ----------------------------- 
//------ espressioni regolari -------------------------------
var exp_description = /^([a-zA-Z0-9\s\xE0\xE8\xE9\xF9\xF2\xEC\x27!#$%&'()*+,-./:;<=>?[\]^_`{|}~][""]{0,0})*([a-zA-Z0-9\xE0\xE8\xE9\xF9\xF2\xEC\x27!#$%&'()*+,-./:;<=>?[\]^_`{|}~][""]{0,0})$/;
var featuringJSON = [];
var json_album_create = {};

$(document).ready(function() {

    initFeaturing();


    //scorrimento lista album  
    var sliderInstance = $("#uploadAlbum-listAlbumTouch").touchCarousel({
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
            initGeocomplete();
        });
    });

    //gestione button new in uploadAlbum02
    $('#uploadAlbum02-next').click(function() {
        var validation_title, validation_description = true;
        //controllo validazione campi di uploadAlbum2
        var espressione = new RegExp(exp_description);
        //validation description
        if (!espressione.test($('#description').val())) {
            $('#description').focus();
            //   $('label[for="description"] small.error').css({'display':'block'});
            validation_description = false;
        } else {
            validation_description = true;
        }
        //validation title        
        if (!espressione.test($('#albumTitle').val())) {
            $('#albumTitle').focus();
            //  $('label[for="albumTitle"] small.error').css({'display':'block'});
            validation_title = false;
        }
        else {
            validation_title = true;
        }
        if (validation_title && validation_description) {
            $("#uploadAlbum02").fadeOut(100, function() {
                $("#uploadAlbum03").fadeIn(100);

            });
        }
    });

    //gesione button publish 
    $('#uploadAlbum03-publish').click(function() {
        //  publish();
    });
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

function initFeaturing() {
    try {
        //inizializza le info in sessione
        sendRequest("uploadAlbum", "getFeaturingJSON", {"force": true}, null, true);

        $('#featuring').select2({
            multiple: true,
            minimumInputLength: 1,
            width: "100%",
            ajax: {
                url: "../controllers/request/uploadAlbumRequest.php?request=getFeaturingJSON",
                dataType: 'json',
                data: function(term) {
                    return {
                        term: term
                    };
                },
                results: function(data) {
                    return {
                        results: data
                    };
                }
            }
        });
    } catch (err) {
        console.log("initFeaturing | An error occurred - message : " + err.message);
    }
}
function initGeocomplete() {
    try {
        $("#city").geocomplete()
                .bind("geocode:result", function(event, result) {
            json_album_create.city = prepareLocationObj(result);
        })
                .bind("geocode:error", function(event, status) {
            json_album_create.city = null;

        })
                .bind("geocode:multiple", function(event, results) {
            json_album_create.city = prepareLocationObj(results[0]);
        });

    } catch (err) {
        console.log("initGeocomplete | An error occurred - message : " + err.message);
    }

}