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
            break;
        case 'event':
            $("#discoverMusic").slideUp(function() {
                $("#discoverEvent").slideToggle('slow');
            });
            $("#discover").html('Discover Events!');
            $('#btn-event').addClass('discover-button-active');
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
        $("#date").datepicker({
            dateFormat: "dd/mm/yy",
            altFormat: "dd/mm/yy"
        });
    } catch (err) {
        window.console.error("getCalendar | An error occurred - message : " + err.message);
    }
}
