var json_event_create = {"hours": "", "image": "", "crop": ""};
var music = null;
var uploader;
//-------------- variabili per jcrop ----------------------//
var input_x,
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

$(document).ready(function() {
    initJammersJSON();
    initGeocomplete();
    initImgUploader();

    //gestione calendario
    $("#date").datepicker({
        altFormat: "dd/mm/yy"
    });

    //gesione button create
    $('#uploadEvent01-next').click(function() {
    });

    var time = getClockTime();
    $("#hours").html(time);

    //carica i tag music
    $.ajax({
        url: "../config/views/tag.config.json",
        dataType: 'json',
        success: function(data, stato) {
            music = data.localType;

            for (var value in music) {
                var tagCheck = '<input type="checkbox" name="';
                var tagCheckTrack = '<input type="checkbox" name="';
                var name = 'tag-music' + value + '"';
                var nameTrack = 'tag-musicTrack' + value + '"';
                tagCheck = tagCheck + name + 'id="' + name + 'value="' + value + '" class="no-display">';
                tagCheck = tagCheck + '<label for="' + name + '>' + music[value] + '</label>';

                tagCheckTrack = tagCheckTrack + nameTrack + 'id="' + nameTrack + 'value="' + value + '" class="no-display">';
                tagCheckTrack = tagCheckTrack + '<label for="' + nameTrack + '>' + music[value] + '</label>';

                $(tagCheck).appendTo('#uploadEvent #tag-music');
                $(tagCheckTrack).appendTo('#uploadEvent #tag-musicTrack');
            }

        },
        error: function(richiesta, stato, errori) {
            console.log("E' evvenuto un errore. Il stato della chiamata: " + stato);
        }
    });

});

function getClockTime() {
    var timeString = '';
    timeString = timeString + '<option value=""></option>';
    for (i = 0; i < 24; i++) {
        if (i < 10) {
            timeString = timeString + '<option value="0' + i + ':00">0' + i + ':00</option>';
            timeString = timeString + '<option value="0' + i + ':30">0' + i + ':30</option>';
        }
        else {
            timeString = timeString + '<option value="' + i + ':00">' + i + ':00</option>';
            timeString = timeString + '<option value="' + i + ':30">' + i + ':30</option>';
        }
    }
    return timeString;
}

function creteEvent() {
    try {
        json_event_create.title = $("#eventTitle").val();
        json_event_create.description = $("#description").val();
        json_event_create.date = $("#date").val();
        json_event_create.hours = $("#hours").val();
        json_event_create.venue = $("#venueName").val();
        json_event_create.jammers = getJammersUploadEvent();
        json_event_create.tags = getTagsEventCreate();

        sendRequest("uploadEvent", "createEvent", json_event_create, eventCreateCallback, false);
    } catch (err) {
        window.console.error("creteEvent | An error occurred - message : " + err.message);
    }

}

function eventCreateCallback(data, status, xhr) {
    try {
        if(status === "success"){
            alert(data.status);
            clearAll();
        }
        else{
             alert(data.status);           
        }
    } catch (err) {
        window.console.log("eventCreateCallback | An error occurred - message : " + err.message);
    }
}

function getTagsEventCreate() {
    try {
        var tags = new Array();
        $.each($("#tag-music :checkbox"), function() {

            if ($(this).is(":checked")) {
                var index = parseInt($(this).val());
                tags.push(music[index]);
            }
        });

        return tags;
    } catch (err) {
        window.console.log("getTagsEventCreate |An error occurred - message : " + err.message);
    }
}


//////////////////////////////////////////////////////////////////////////////
//  
//      Sezione gestione immagine
//
/////////////////////////////////////////////////////////////////////////////
function initImgUploader() {

//inizializzazione dei parametri
    var selectButtonId = "uploader_img_button";
    var url = "../controllers/request/uploadRequest.php";
    var runtime = 'html4';
    var multi_selection = false;
    var maxFileSize = "12mb";

//creo l'oggetto uploader (l'ho dichiarato ad inizio js in modo che sia globale)
    uploader = new plupload.Uploader({
        runtimes: runtime, //runtime di upload
        browse_button: selectButtonId, //id del pulsante di selezione file
        max_file_size: maxFileSize, //dimensione max dei file da caricare
        multi_selection: multi_selection, //forza un file alla volta per upload
        url: url,
        filters: [
            {title: "Image files", extensions: "jpg,gif,png"}
        ],
        multipart_params: {"request": "uploadImage"} //parametri passati in POST
    });

    uploader.bind('Init', function(up, params) {
//        window.console.log("initImgUploader - EVENT: Ini");
        $('#filelist').html("");
    });

//inizializo l'uploader
//    window.console.log("initUploader - eseguo uploader.init()");
    uploader.init();

//evento: file aggiunto
    uploader.bind('FilesAdded', function(up, files) {
        //avvio subito l'upload
//        window.console.log("initImgUploader - EVENT: FilesAdded - parametri: files => " + JSON.stringify(files));

        uploader.start();
    });

//evento: cambiamento percentuale di caricamento
    uploader.bind('UploadProgress', function(up, file) {
//        window.console.log("initImgUploader - EVENT: UploadProgress - parametri: file => " + JSON.stringify(file));
    });

//evento: errore
    uploader.bind('Error', function(up, err) {
//        window.console.log("initImgUploader - EVENT: Error - parametri: err => " + JSON.stringify(err));
        alert("Error occurred");
        up.refresh();
    });

//evento: upload terminato
    uploader.bind('FileUploaded', function(up, file, response) {
//        console.log(response.response);
        var obj = JSON.parse(response.response);

        json_event_create.image = obj.src;

        //qua ora va attivato il jcrop
        var img = new Image();
        img.src = "../media/cache/" + obj.src;
        img.width = obj.width;
        img.height = obj.height;

        onUploadedImage(img);
    });
}

function onUploadedImage(img) {

    preview = $('#uploadImage_preview');
    tumbnail = $('#uploadImage_tumbnail');
    tumbnail_pane = $('#uploadImage_tumbnail-pane');

    id_tumbnail = tumbnail.attr('id');
    id_preview = preview.attr('id');

    //creo l'html per la preview dell'immagine

    input_x = 'crop_x';
    input_y = 'crop_y';
    input_w = 'crop_w';
    input_h = 'crop_h';

    var html_uploadImage_preview_box = "";
    html_uploadImage_preview_box += '<img src="' + img.src + '" id="' + id_preview + '" width="' + img.width + 'px" height="' + img.height + 'px" "/>';
    html_uploadImage_preview_box += '<input type="hidden" id="' + input_x + '" name="' + input_x + '" value="0"/>';
    html_uploadImage_preview_box += '<input type="hidden" id="' + input_y + '" name="' + input_y + '" value="0"/>';
    html_uploadImage_preview_box += '<input type="hidden" id="' + input_w + '" name="' + input_w + '" value="100"/>';
    html_uploadImage_preview_box += '<input type="hidden" id="' + input_h + '" name="' + input_h + '" value="100"/>';

    //mostra a video la preview dell'immagine:
    $('#uploadImage_preview_box').html(html_uploadImage_preview_box);
    preview = $('#uploadImage_preview_box');


    //creo l'html per la preview del thumbnail (l'immagine finale dopo il jcrop?)
    var html_tumbnail_pane = '';
    html_tumbnail_pane += '<img src="" id="' + id_tumbnail + '" height="50" width="50"/>';

//mostra a video la preview del thumbnail 
    $("#" + id_tumbnail).html(html_tumbnail_pane);
    tumbnail = $('#' + id_tumbnail);

//mostro a video l'immagine 
    $('#uploadImage_save').removeClass('no-display');

    //attivo il plugin jcrop (non funzionante per ora)
    initJcrop(img, preview);
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
        aspectRatio: xsize / ysize
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

function updatePreview(c) {
    $('#' + input_x).val(c.x);
    $('#' + input_y).val(c.y);
    $('#' + input_w).val(c.w);
    $('#' + input_h).val(c.h);

}

$('#uploadImage_save').click(function() {
    tumbnail = $('#uploadImage_tumbnail');
    tumbnail.attr('src', preview.attr('src'));
    thmImage = new Image();
    thmImage.src = preview.attr('src');
    var realwidth, realheight;
    thmImage.onload = function() {
        realwidth = this.width;
        realheight = this.height;
        thm_w = Math.round(realwidth / $('#' + input_w).val() * xsize);
        thm_h = Math.round(realheight / $('#' + input_h).val() * ysize);
        tumbnail.css({
            width: thm_w + 'px',
            height: thm_h + 'px',
            marginLeft: '-' + Math.round(thm_w * ($('#' + input_x).val() / realwidth)) + 'px',
            marginTop: '-' + Math.round(thm_h * ($('#' + input_y).val() / realheight)) + 'px'
        });

    };
    json_crop = {
        x: $('#' + input_x).val(),
        y: $('#' + input_y).val(),
        h: $('#' + input_h).val(),
        w: $('#' + input_w).val()
    };
    json_event_create.crop = json_crop;
    $('#upload').foundation('reveal', 'close');
});

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

function initJammersJSON() {
    try {
        //inizializza le info in sessione
        sendRequest("uploadEvent", "getFeaturingJSON", {"force": true}, null, true);

        //inizializza il plugin
        $("#jammers").fcbkcomplete({
            json_url: "../controllers/request/uploadEventRequest.php?request=getFeaturingJSON",
            addontab: true,
            width: "100%",
            addoncomma: false,
            input_min_size: 0,
            height: 10,
            cache: true,
            maxshownitems: 10,
            newel: false
        });

    } catch (err) {
        console.log("initJammersJSON | An error occurred - message : " + err.message);
    }
}

function getJammersUploadEvent() {
    try {
        var jammers = new Array();
        $.each($("#jammers option:selected"), function(key, item) {
            jammers.push($(item).val());
        });

        return jammers;
    } catch (err) {
        window.console.error("getJammersUploadEvent | An error occurred - message : " + err.message);
    }
}

function clearAll(){
    json_event_create = {"hours": "", "image": "", "crop": ""};
    $('#form-uploadEvent').reset();
}