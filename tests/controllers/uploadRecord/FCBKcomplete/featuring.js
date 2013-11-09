$(document).ready(function() {
    var url ="http://localhost/jamyourself/controllers/request/uploadRecordRequest.php?request=getFeaturingJSON"
    $.getJSON(url, function(data) {
        var html = "Scegli tra: ";
            $.each( data, function( key, val ) {
                html += "\"" +val.value +" \" , "; 
            });
            $("#testme").html(html);
    });


    $("#select3").fcbkcomplete({
        json_url: url,
        addontab: true,                   
        maxitems: 10,
        input_min_size: 0,
        height: 10,
        cache: true,
        newel: false
    });
    
        $("#check").click(function() {
        $.each($("#select3 option:selected"), function(key, val) {
            console.log($(val).val());
        });

    });
});

// * width            - element width (by default 512px)
// * json_url         - url to fetch json object
// * cache            - use cache
// * height           - maximum number of element shown before scroll will apear
// * newel            - show typed text like a element
// * firstselected    - automaticly select first element from dropdown
// * filter_case      - case sensitive filter
// * filter_selected  - filter selected items from list
// * filter_begin     - filter only from begin
// * complete_text    - text for complete page
// * maxshownitems    - maximum numbers that will be shown at dropdown list (less better performance)
// * onselect         - fire event on item select
// * onremove         - fire event on item remove
// * oncreate         - fire event on item create
// * maxitimes        - maximum items that can be added
// * delay            - delay between ajax request (bigger delay, lower server time request)
// * addontab         - add first visible element on tab or enter hit
// * addoncomma       - add first visible element when pressing the comma key
// * attachto         - after this element fcbkcomplete insert own elements
// * bricket          - use square bricket with select (needed for asp or php) enabled by default
// * input_tabindex   - the tabindex of the input element
// * input_min_size   - minimum size of the input element (default: 1)
// * input_name       - value of the input element's 'name'-attribute (no 'name'-attribute set if empty)
// * select_all_text  - text for select all link