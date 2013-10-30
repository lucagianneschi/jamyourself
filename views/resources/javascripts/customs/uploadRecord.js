var music = null;
var uploader = null;
var json_album = {"list": []};

$(document).ready(function() {
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
        //inizializzazione dell'uploader
        if (uploader == null) {
            initMp3Uploader();
        }
    });

    //gesione button create new 
    $('#uploadRecord-new').click(function() {
        $("#uploadRecord01").fadeOut(100, function() {
            $("#uploadRecord02").fadeIn(100);
        });
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
        albumCreate();
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

    initImgUploader();
});

//////////////////////////////////////////////////////////////////////////////
//  
//      Sezione creazione nuovo album record
//
/////////////////////////////////////////////////////////////////////////////

function initImgUploader() {

    console.log("initImgUploader - start => upload div: " + $("#uploader_img_button"));
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
//        window.console.log("initUploader - EVENT: Ini");
        $('#filelist').html("");
    });

//inizializo l'uploader
//    window.console.log("initUploader - eseguo uploader.init()");
    uploader.init();

//evento: file aggiunto
    uploader.bind('FilesAdded', function(up, files) {
        //avvio subito l'upload
        window.console.log("initUploader - EVENT: FilesAdded - parametri: files => " + JSON.stringify(files));
    });

//evento: cambiamento percentuale di caricamento
    uploader.bind('UploadProgress', function(up, file) {
        window.console.log("initUploader - EVENT: UploadProgress - parametri: file => " + JSON.stringify(file));
    });

//evento: errore
    uploader.bind('Error', function(up, err) {
//        window.console.log("initUploader - EVENT: Error - parametri: err => " + JSON.stringify(err));
        alert("Error occurred");
        up.refresh();
    });

//evento: upload terminato
    uploader.bind('FileUploaded', function(up, file, response) {

        window.console.log("initUploader - EVENT: FileUploaded - parametri: err => " + JSON.stringify(file) + " - response => " + JSON.stringify(response));

        console.log(response.response);
        var obj = JSON.parse(response.response);
    });
}

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

function callbackAlbumCreate() {
    alert("Album Created");
}

function albumCreate() {
    var json_album_create = {
        "albumTitle": $("#albumTitle").val(),
        "description": $("#description").val(),
        "label": $("#label").val(),
        "urlBuy": $("#urlBuy").val(),
        "albumFeaturing": $("#albumFeaturing").val(),
        "year": $("#year").val(),
        "city": $("#city").val(),
        "tags": getTagsAlbumCreate()
    };

    sendRequest("albumCreate", json_album_create, callbackAlbumCreate, false);
}
//////////////////////////////////////////////////////////////////////////////
//  
//      Sezione inserimento mp3 in album record
//
/////////////////////////////////////////////////////////////////////////////
function initMp3Uploader() {

//    window.console.log("initUploader - params : userType => " + userType);
//inizializzazione dei parametri
    var selectButtonId = "uploader_mp3_button";
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
        window.console.log("initUploader - EVENT: FilesAdded - parametri: files => " + JSON.stringify(files));
    });

//evento: cambiamento percentuale di caricamento
    uploader.bind('UploadProgress', function(up, file) {
        window.console.log("initUploader - EVENT: UploadProgress - parametri: file => " + JSON.stringify(file));
    });

//evento: errore
    uploader.bind('Error', function(up, err) {
//        window.console.log("initUploader - EVENT: Error - parametri: err => " + JSON.stringify(err));
        alert("Error occurred");
        up.refresh();
    });

//evento: upload terminato
    uploader.bind('FileUploaded', function(up, file, response) {

        window.console.log("initUploader - EVENT: FileUploaded - parametri: err => " + JSON.stringify(file) + " - response => " + JSON.stringify(response));

        console.log(response.response);
        var obj = JSON.parse(response.response);

        addSong(obj.src, obj.duration, getTagsMusicTrack());

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


function addSong(id, duration, tags) {
    var json_elem = {"src": id, "tags": tags};
    json_album.list.push(json_elem);
    console.log("songTitle => " + songTitle + " - featuring => " + featuring + " - tags => " + tags + " - id => " + id);
    var songTitle, featuring = null;
    songTitle = $("#trackTitle").val();
    featuring = $("#trackFeaturing").val();

    var html = "";
    html += "<tr>";
    html += '<td class="title _note-button">' + songTitle + '</td>';
    html += '<td class="time">' + duration + '</td>';
    html += '<td class="genre">' + tags.join() + '</td>';
    html += '<td class="delete _delete-button"></td>';
    html += '</tr>';

    $("#songlist").append(html);
}

function publish() {



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
    console.log(uploader);

    if (uploader != null) {
        console.log("refreshing uploader");
        uploader.refresh();
    }
}