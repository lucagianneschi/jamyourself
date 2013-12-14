var music = null;
var json_album_create = {};
var uploader = null;
var json_album = {"list": []};
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

$(document).ready(function() {
    //inizializzazone in sessione dei featuring in maniera asincrona
    initFeaturingJSON();

    //scorrimento lista album record 
    $("#uploadRecord-listRecordTouch").touchCarousel({
        pagingNav: false,
        snapToItems: true,
        itemsPerMove: 1,
        scrollToLast: false,
        loopItems: false,
        scrollbar: false,
        dragUsingMouse: false
    });
 

    //gestione select album record
    $('.uploadRecord-boxSingleRecord').click(function() {
        $("#uploadRecord01").fadeOut(100, function() {
            $("#uploadRecord03").fadeIn(100);
        });

        json_album.recordId = this.id;
        //inizializzazione dell'uploader
        if (uploader == null) {
            initMp3Uploader();
        }

        //recupero gli mp3 dell'album
        getSongs(json_album.recordId);
    });

    //gesione button create new 
    $('#uploadRecord-new').click(function() {
        $("#uploadRecord01").fadeOut(100, function() {
            $("#uploadRecord02").fadeIn(100);
        });
        //inizializzazione per l'upload della copertina dell'album
        initImgUploader();

    });

    //gestione button new in uploadRecord02
    $('#uploadRecord03-next').click(function() {
        $("#uploadRecord02").fadeOut(100, function() {
            $("#uploadRecord03").fadeIn(100);
        });
        if (uploader != null) {
            uploader.start();
        }

    });

    //gesione button publish 
    $('#uploadRecord03-publish').click(function() {
        publish();
    });

    //gesione button publish 
    $('#uploadRecord02-next').click(function() {
        recordCreate();
    });

    //carica i tag music
    $.ajax({
        url: "../config/views/tag.config.json",
        dataType: 'json',
        success: function(data, stato) {
            music = data.music;

            for (var value in music) {
                var tagCheck = '<input type="checkbox" name="';
                var tagCheckTrack = '<input type="checkbox" name="';
                var name = 'tag-music' + value + '"';
                var nameTrack = 'tag-musicTrack' + value + '"';
                tagCheck = tagCheck + name + 'id="' + name + 'value="' + value + '" class="no-display">';
                tagCheck = tagCheck + '<label for="' + name + '>' + music[value] + '</label>';

                tagCheckTrack = tagCheckTrack + nameTrack + 'id="' + nameTrack + 'value="' + value + '" class="no-display">';
                tagCheckTrack = tagCheckTrack + '<label for="' + nameTrack + '>' + music[value] + '</label>';

                $(tagCheck).appendTo('#uploadRecord #tag-music');
                $(tagCheckTrack).appendTo('#uploadRecord #tag-musicTrack');
            }

        },
        error: function(richiesta, stato, errori) {
            console.log("E' evvenuto un errore. Il stato della chiamata: " + stato);
        }
    });


    $("#albumFeaturing").fcbkcomplete({
        json_url: "../controllers/request/uploadRecordRequest.php?request=getFeaturingJSON",
        addontab: true,
        addoncomma: false,
        input_min_size: 0,
        height: 10,
        width: "100%",
        cache: true,
        maxshownitems: 10,
        newel: false
    });
    $("#trackFeaturing").fcbkcomplete({
        json_url: "../controllers/request/uploadRecordRequest.php?request=getFeaturingJSON",
        addontab: true,
        width: "100%",
        addoncomma: false,
        input_min_size: 0,
        height: 10,
        cache: true,
        maxshownitems: 10,
        newel: false
    });

//    Per stampare in console l'array del featuring:
//    
//        $.getJSON("../controllers/request/uploadRecordRequest.php?request=getFeaturingJSON", function(data) {
//            console.log("featuring: list : ");
//            console.log(JSON.stringify(data));
//    });

});

//////////////////////////////////////////////////////////////////////////////
//  
//      Sezione creazione nuovo album record
//
/////////////////////////////////////////////////////////////////////////////

function initImgUploader() {

//    console.log("initImgUploader - start => upload div: " + $("#uploader_img_button"));
//    window.console.log("initUploader - params : userType => " + userType);
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
        multipart_params: {"request": "uploadImage"}, //parametri passati in POST
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

//        window.console.log("initImgUploader - EVENT: FileUploaded - parametri: err => " + JSON.stringify(file) + " - response => " + JSON.stringify(response));

//        console.log(response.response);
        var obj = JSON.parse(response.response);

        json_album_create.image = obj.src;

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

function updatePreview(c) {
    $('#' + input_x).val(c.x);
    $('#' + input_y).val(c.y);
    $('#' + input_w).val(c.w);
    $('#' + input_h).val(c.h);

}

$('#uploadImage_save').click(function() {
    tumbnail = $('#uploadImage_tumbnail');

    tumbnail.attr('src', preview.attr('src'));

    thmImage = new Image()

    thmImage.src = preview.attr('src');

    var realwidth, realheight;

    thmImage.onload = function() {
        realwidth = this.width;
        realheight = this.height;


        thm_w = Math.round(realwidth / $('#' + input_w).val() * xsize);
        thm_h = Math.round(realheight / $('#' + input_h).val() * ysize);

//        console.log(realwidth + ' ' + $('#' + input_w).val() + ' ' + xsize + ' ' + thm_w);
//        console.log(realheight + ' ' + $('#' + input_h).val() + ' ' + ysize + ' ' + thm_h);

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

    json_album_create.crop = json_crop;

    $('#upload').foundation('reveal', 'close');
});

function getTagsAlbumCreate() {
    var tags = new Array();
    $.each($("#tag-music :checkbox"), function() {

        if ($(this).is(":checked")) {
            var index = parseInt($(this).val());
            tags.push(music[index]);
        }
    });

    return tags;
}

function callbackAlbumCreate(data, status) {
    console.debug("Data : " + JSON.stringify(data) + " | Status: " + status);
    if (status == "success") {
        var idNuovoAlbum = data.id; //sse servisse...
//        console.log("Album Creato con successo con id => " + data.recordId);
        alert(data.status);
    } else {
        alert("Errore");
        console.debug("Data : " + JSON.stringify(data) + " | Status: " + status);
    }
}
function getFeaturingAlbumCreate() {
    var featuring = new Array();
    $.each($("#albumFeaturing option:selected"), function(key, item) {
        featuring.push($(item).val());
    });

    return featuring;
}
function recordCreate() {
    json_album_create.recordTitle = $("#recordTitle").val();
    json_album_create.description = $("#description").val();
    json_album_create.label = $("#label").val();
    json_album_create.urlBuy = $("#urlBuy").val();
    json_album_create.albumFeaturing = getFeaturingAlbumCreate();
    json_album_create.year = $("#year").val();
    json_album_create.city = $("#city").val();
    json_album_create.tags = getTagsAlbumCreate();

//    console.log("Record => " + JSON.stringify(json_album_create));
    sendRequest("recordCreate", json_album_create, callbackAlbumCreate, false);
}
//////////////////////////////////////////////////////////////////////////////
//  
//      Sezione inserimento mp3 in album record
//
/////////////////////////////////////////////////////////////////////////////
function initMp3Uploader() {
//creo l'oggetto uploader (l'ho dichiarato ad inizio js in modo che sia globale)
    uploader = new plupload.Uploader({
        runtimes: 'html4', //runtime di upload
        browse_button: "uploader_mp3_button", //id del pulsante di selezione file
        max_file_size: "12mb", //dimensione max dei file da caricare
        multi_selection: false, //forza un file alla volta per upload
        url: "../controllers/request/uploadRequest.php",
        filters: [
            {title: "Audio files", extensions: "mp3"}
        ],
        multipart_params: {"request": "uploadMp3"}, //parametri passati in POST
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

        while (up.files.length > 1) {
            up.removeFile(up.files[0]);
        }
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

//        console.log(response.response);
        var obj = JSON.parse(response.response);

        addNewSong(obj.src, obj.duration, getTagsMusicTrack());

    });
}

function getTagsMusicTrack() {
    var tags = new Array();
    $.each($("#tag-musicTrack :checkbox"), function() {

        if ($(this).is(":checked")) {
            var index = parseInt($(this).val());
            tags.push(music[index]);
        }
    });

    return tags;
}
function getFeaturingSongCreate() {
    var featuring = new Array();
    $.each($("#trackFeaturing option:selected"), function(key, item) {
        featuring.push($(item).val());
    });

    return featuring;
}

function addNewSong(id, duration, tags) {
    var songTitle = $("#trackTitle").val();
    var featuring = getFeaturingSongCreate();
    var json_elem = {"src": id, "tags": tags, "featuring": featuring, "title": songTitle, "duration": duration};
    json_album.list.push(json_elem);
    window.console.log("Lista" + JSON.stringify(json_album.list));
    addSongToList(json_elem.title, json_elem.duration, json_elem.tags.join(), true, id.substring(0,id.indexOf(".")));
}

function addSongToList(title, duration, genre, isNew, src) {

    var html = "";
    if(isNew){
        html += '<tr id="tr_song_list_' +src+'">';
    }else{
        html += "<tr>";        
    }
    html += '<td class="title _note-button">' + title + '</td>';
    html += '<td class="time">' + duration + '</td>';
    html += '<td class="genre">' + genre + '</td>';
    if (isNew) {
        html += '<td class="delete _delete-button" onClick="javascript:removeSong(\''+src+'\')"></tdr>';
    }

    $("#songlist").append(html);
}

function publish() {
    sendRequest("publishSongs", json_album, publishCallback, false);
}

function publishCallback(data, status) {
    var result = JSON.parse(data.responseText);
    window.console.log(data);
    alert(result.status);   
    clearAll();
}
//////////////////////////////////////////////////////////////////////////////
//  
//      Sezione comunicazione rest API
//
/////////////////////////////////////////////////////////////////////////////
function sendRequest(_action, _data, callback, _async) {
    if (_action === undefined || _action === null || _data === undefined || _data === null) {
        callback(null);
    }
    _data.request = _action;
    var url = "../controllers/request/uploadRecordRequest.php";
    var type = "POST";
    var async = true;
    if (async !== undefined && async !== null)
        async = _async;

    $.ajax({
        type: type,
        url: url,
        data: _data,
        dataType: "json",
        async: async,
        success: function(data, status) {
            //gestione success
            callback(data, status);
        },
        error: function(data, status) {
            callback(data, status);
        }
    });
}

function uploaderRefresh() {
//    console.log(uploader);

    if (uploader != null) {
//        console.log("refreshing uploader");
        uploader.refresh();
    }
}

////////////////////////////////////////////////////////////////////////////////
//
//  Dati per il precaricamento
//
////////////////////////////////////////////////////////////////////////////////

function getSongs(recordId) {
    //per test : sK0Azt3WiP
    if (recordId != undefined && recordId != null && recordId.length > 0) {
        var json_for_count_song = {recordId: recordId};
        sendRequest("getSongsList", json_for_count_song, getSongCallback, true);
    }
}

function getSongCallback(data, status) {
//    window.console.log("getSongCallback | data => " + JSON.stringify(data));
//    window.console.log("getSongCallback | status => " + JSON.stringify(status));

    if (data.songList != undefined && data.songList != null && data.count != undefined && data.count != null && data.count >= 0) {
        json_album.count = data.count;
        for (var i = 0; i < data.count; i++) {
            var song = JSON.parse(data.songList[i]);
            var title = (song.title != undefined && song.title != null && song.title.length > 0) ? song.title : "no title";
            var genre = (song.genre != undefined && song.genre != null && song.genre.length > 0) ? song.genre : "no genre";
            var duration = (song.duration != undefined && song.duration != null) ? song.duration : "no duration";
            addSongToList(title, duration, genre, false);
        }
    } else {
        json_album.count = 0;
    }
}

function initFeaturingJSON() {
    sendRequest("getFeaturingJSON", {}, callbackInitFeaturingJSON, true);
}

function callbackInitFeaturingJSON(data, status) {
//    window.console.log("callbackInitFeaturingJSON | data => " + JSON.stringify(data));
}

function clearAll() {
    json_album.list = [];
    $("#songlist").html("");
    getSongs(json_album.recordId);
}

function removeSong(src){
    $('#tr_song_list_' +src).remove();
    for(var i=0;i <json_album.list.length; i++){
        var song = json_album.list[i];
        if(song.src == src+".mp3"){
            json_album.list.splice(i,1);
            break;
        }
    }
    console.log("Lista => " + JSON.stringify(json_album.list));
}