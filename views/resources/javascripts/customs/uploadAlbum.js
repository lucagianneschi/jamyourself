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
        });
    });

    //gestione button new in uploadAlbum02
    $('#uploadAlbum02-next').click(function() {
        $("#uploadAlbum02").fadeOut(100, function() {
            $("#uploadAlbum03").fadeIn(100);
        });
    });

    //gesione button publish 
    $('#uploadAlbum03-publish').click(function() {
      //  publish();
    });

    //gesione button publish 
    $('#uploadAlbum02-next').click(function() {
      //  albumCreate();
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