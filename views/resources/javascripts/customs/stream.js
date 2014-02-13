function discover(what) {
    $('.discover-button').removeClass('discover-button-active');
    var elID = "#search";
    $("#scroll-profile").mCustomScrollbar("scrollTo", elID);
    switch (what)
    {
	case 'music':
	    $("#discoverEvent").slideUp(function() {
		$("#discoverMusic").slideToggle('slow');
	    });
	    $("#discover").html('Discover new Music!');
	    $('#btn-music').addClass('discover-button-active');
	    initGeocomplete("#location");
	    break;
	case 'event':
	    $("#discoverMusic").slideUp(function() {
		$("#discoverEvent").slideToggle('slow');
	    });
	    $("#discover").html('Discover Events!');
	    $('#btn-event').addClass('discover-button-active');
	    getCalendar();
	    initGeocomplete("#eventTitle");
	    break;
    }
}

function hideResult() {
    $("#result").slideToggle('slow');
    $("#search").slideToggle('slow');
    $("#discover").html('What are you looking for?');
    var elID = "#search";
    $("#scroll-profile").mCustomScrollbar("scrollTo", elID);

}

function getCalendar() {
    try {
	$("#discoverEvent #date").datepicker({
	    dateFormat: "dd/mm/yy",
	    altFormat: "dd/mm/yy"
	});
    } catch (err) {
	window.console.error("getCalendar | An error occurred - message : " + err.message);
    }
}

function initGeocomplete(box) {
    try {
	console.log('GEOOO');
	$(box).geocomplete()
		.bind("geocode:result", function(event, result) {
	    json_data.location = getCompleteLocationInfo(result);
	    /*
	     json_data.location = prepareLocationObj(result);
	     var complTest = getCompleteLocationInfo(json_data.location);
	     */
	})
		.bind("geocode:error", function(event, status) {
	    json_data.location = null;
	})
		.bind("geocode:multiple", function(event, results) {
	    json_data.location = getCompleteLocationInfo(results[0]);
	});
    } catch (err) {
	console.log("initGeocomplete | An error occurred - message : " + err.message);
    }
}
