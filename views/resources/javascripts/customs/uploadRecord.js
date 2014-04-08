var exp_url = /(https?|ftp|file|ssh):\/\/(((([a-zA-Z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-zA-Z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-zA-Z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-zA-Z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-zA-Z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-zA-Z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-zA-Z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-zA-Z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-zA-Z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-zA-Z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-zA-Z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-zA-Z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-zA-Z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?/;
var exp_general = /^([a-zA-Z0-9\s\xE0\xE8\xE9\xF9\xF2\xEC\x27!#$%&'()*+,-./:;<=>?[\]^_`{|}~][""]{0,0})*([a-zA-Z0-9\xE0\xE8\xE9\xF9\xF2\xEC\x27!#$%&'()*+,-./:;<=>?[\]^_`{|}~\s][""]{0,0})$/;
var music = null;
var json_album_create = {'city': null};
var uploader = null;
var json_album = {"list": [], 'count': 0};
var recordLoader = null;
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

 	onCarouselReady();
    initGeocomplete();
    validateFields();
    validateUrl('urlBuy');
    step1NewRecord();
    step2Next();
    step2Back();
    step3Ok();
    //gesione button publish 
    $('#uploadRecord03-publish').click(function() {
		publish();
    });

});
/*
 * validazione campi con plugin abide di foundation
 * trami espressioni regolari definite sopra
 */
function validateFields() {
    try {
	$(document).foundation('abide', {
	    live_validate: true,
	    focus_on_invalid: true,
	    timeout: 1000,
	    patterns: {
		general: exp_general,
		year: /^(19|20)\d{2}$/,
		url: exp_url
	    }
	});
    } catch (err) {
	window.console.error("validateFields | An error occurred - message : " + err.message);
    }

}

/*
 * validazione javascript campo url
 */
function validateUrl(field) {
    try {
	$('#' + field).blur(function() {
	    var str = $('#' + field).val();
	    if (str != '' && str.indexOf("http://") < 0) {
		$('#' + field).val('http://' + str);
	    }
	});
    } catch (err) {
	window.console.error("validateUrl | An error occurred - message : " + err.message);
    }
}

/*
 * gesione button create new record
 */
function step1NewRecord() {
    try {
	$('#uploadRecord-new').click(function() {
	    $("#uploadRecord01").fadeOut(100, function() {
		$("#uploadRecord02").fadeIn(100);
	    });
	    //inizializzazione per l'upload della copertina dell'album
	    initImgUploader();
	});
    } catch (err) {
	window.console.error("createNewRecord | An error occurred - message : " + err.message);
    }
}

/*
 * gestione button new in uploadRecord02
 */
function step2Next() {
    try {
	$('#uploadRecord02-next').click(function() {
	    var espressione = new RegExp(exp_general);
	    var esprUrl = new RegExp(exp_url);
	    var esprYear = new RegExp(/^(19|20)\d{2}$/);
	    //title
	    var validation_title = false;
	    if ($('#recordTitle').val() == '' || !espressione.test($('#recordTitle').val())) {
		$('#recordTitle').focus();
		validation_title = false;
	    } else
		validation_title = true;
	    //description
	    var validation_description = false;
	    if ($('#description').val() == '' || !espressione.test($('#description').val())) {
		$('#description').focus();
		validation_description = false;
	    } else
		validation_description = true;
	    //label
	    var validation_label = false;
	    if ($('#label').attr('data-invalid') != undefined) {
		$('#label').focus();
		validation_label = false;
	    } else
		validation_label = true;
	    //urlBuy
	    var validation_urlBuy = false;
	    if ($('#urlBuy').attr('data-invalid') != undefined) {
		$('#urlBuy').focus();
		validation_urlBuy = false;
	    } else
		validation_urlBuy = true;
	    //year
	    var validation_year = false;
	    if ($('#year').attr('data-invalid') != undefined) {
		$('#year').focus();
		validation_year = false;
	    } else
		validation_year = true;
	    //city
	    var validation_city = false;
	    if ($('#city').attr('data-invalid') != undefined) {
		$('#city').focus();
		validation_city = false;
	    } else
		validation_city = true;
	    //controllo se almeno esiste un checked per genre
	    var validation_genre = false;
	    if (!$("#tag-music input[type='checkbox']").is(':checked')) {
		$("#labelTag .error").css({'display': 'block'});
		validation_genre = false;
	    }
	    else {
		$("#labelTag .error").css({'display': 'none'});
		validation_genre = true;
	    }


	    if (validation_title && validation_description && validation_label && validation_urlBuy && validation_year && validation_city && validation_genre) {
		$("#uploadRecord02").fadeOut(100, function() {
		    $("#uploadRecord03").fadeIn(100);
		});
		if (uploader !== null) {
		    uploader.start();
		}
		initMp3Uploader();
		createRecord();
	    }
	});
    } catch (err) {
	window.console.error("step2Next | An error occurred - message : " + err.message);
    }
}

function step2Back() {
    try {
	$('#uploadRecord02-back').click(function() {
	    $("#uploadRecord02").fadeOut(100, function() {
		$("#uploadRecord01").fadeIn(100);
	    });
	});
    } catch (err) {
	window.console.error("step2Back | An error occurred - message : " + err.message);
    }
}

function step3Ok() {
    $('#uploadRecord03-next').click(function() {
	//trackTitle
	var validation_trackTitle = false;
	if ($('#trackTitle').val() == '' || $('#trackTitle').attr('data-invalid') != undefined) {
	    $('#trackTitle').focus();
	    validation_trackTitle = false;
	} else
	    validation_trackTitle = true;
	//genre
	var validation_genreTrack = false;
	if (!$("#tag-musicTrack input[type='checkbox']").is(':checked')) {
	    $("#labelmusicTrack .error").css({'display': 'block'});
	    validation_genreTrack = false;
	}
	else {
	    $("#labelmusicTrack .error").css({'display': 'none'});
	    validation_genreTrack = true;
	}

	if (validation_trackTitle && validation_genreTrack) {

	    if (uploader !== null) {
		uploader.start();
	    }

	}

    });
}


//////////////////////////////////////////////////////////////////////////////
//  
//      Sezione creazione nuovo album record
//
/////////////////////////////////////////////////////////////////////////////

function initImgUploader() {
    try {
//inizializzazione dei parametri
	var selectButtonId = "uploader_img_button";
	var url = "../controllers/request/uploadRequest.php";
	var runtime = 'html5';
	var multi_selection = false;
	var maxFileSize = "12mb";
//creo l'oggetto uploader (l'ho dichiarato ad inizio js in modo che sia globale)
	uploader = new plupload.Uploader({
	    runtimes: runtime, //runtime di upload
	    browse_button: selectButtonId, //id del pulsante di selezione file
	    max_file_size: maxFileSize, //dimensione max dei file da caricare
	    multi_selection: multi_selection, //forza un file alla volta per upload
	    chunk_size: '100kb',
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
	    var obj = JSON.parse(response.response);
	    json_album_create.image = obj.src;
	    //qua ora va attivato il jcrop
	    var img = new Image();
	    img.src = "../cache/" + obj.src;
	    img.width = obj.width;
	    img.height = obj.height;
	    onUploadedImage(img);
	});
    } catch (err) {
	window.console.error("onUploadedImage | An error occurred - message : " + err.message);
    }
}

function onUploadedImage(img) {
    try {
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
    } catch (err) {
	window.console.error("onUploadedImage | An error occurred - message : " + err.message);
    }
}

function  initJcrop(img, preview) {
    try {
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
    } catch (err) {
	window.console.error("initJcrop | An error occurred - message : " + err.message);
    }
}

function updatePreview(c) {
    try {
	$('#' + input_x).val(c.x);
	$('#' + input_y).val(c.y);
	$('#' + input_w).val(c.w);
	$('#' + input_h).val(c.h);
    } catch (err) {
	window.console.error("updatePreview | An error occurred - message : " + err.message);
    }

}

$('#uploadImage_save').click(function() {
    try {
	tumbnail = $('#uploadImage_tumbnail');
	tumbnail.attr('src', preview.attr('src'));
	thmImage = new Image();
	thmImage.src = preview.attr('src');
	var realwidth, realheight;
	thmImage.onload = function() {
	    try {
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
	    } catch (err) {
		window.console.error("thmImage.onload | An error occurred - message : " + err.message);
	    }

	};
	var json_crop = {
	    x: $('#' + input_x).val(),
	    y: $('#' + input_y).val(),
	    h: $('#' + input_h).val(),
	    w: $('#' + input_w).val(),
	};
	json_album_create.crop = json_crop;
	$('#upload').foundation('reveal', 'close');
    } catch (err) {
	window.console.error("#uploadImage_save.click | An error occurred - message : " + err.message);
    }
});
function getTagsAlbumCreate() {
    try {
	var tags = new Array();
	$.each($("#tag-music :checkbox"), function() {

	    if ($(this).is(":checked")) {
		var index = parseInt($(this).val());
		tags.push($(this).val());
	    }
	});
	return tags;
    } catch (err) {
	window.console.error("getTagsAlbumCreate | An error occurred - message : " + err.message);
    }
}
function createRecord() {
    try {
	json_album_create.recordTitle = $("#recordTitle").val();
	json_album_create.description = $("#description").val();
	json_album_create.label = $("#label").val();
	json_album_create.urlBuy = $("#urlBuy").val();
	json_album_create.albumFeaturing = getFeaturingList("albumFeaturing");
	json_album_create.year = $("#year").val();
	json_album_create.tags = getTagsAlbumCreate();
	json_album.record = json_album_create;
	json_album.recordId = null;
    } catch (err) {
	window.console.error("An error occurred - message : " + err.message);
    }
}
//////////////////////////////////////////////////////////////////////////////
//  
//      Sezione inserimento mp3 in album record
//
/////////////////////////////////////////////////////////////////////////////
function initMp3Uploader() {
    try {
//creo l'oggetto uploader (l'ho dichiarato ad inizio js in modo che sia globale)
	uploader = new plupload.Uploader({
	    runtimes: 'html5', //runtime di upload
	    browse_button: "uploader_mp3_button", //id del pulsante di selezione file
	    max_file_size: "12mb", //dimensione max dei file da caricare
	    chunk_size: '100kb',
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
	    var progressBarValue = up.total.percent;
	    $('#progressbar').fadeIn().progressbar({
		value: progressBarValue
	    });
	    $('#progressbar .ui-progressbar-value').html('<span class="progressTooltip">' + up.total.percent + '%</span>');
	});
//evento: errore
	uploader.bind('Error', function(up, err) {
//        window.console.log("initUploader - EVENT: Error - parametri: err => " + JSON.stringify(err));
	    $('#uploaderError').removeClass('no-display');
	    $('#progressbar').addClass('no-display');
	    console.log(err);
	    up.refresh();
	});
//evento: upload terminato
	uploader.bind('FileUploaded', function(up, file, response) {
//        window.console.log("initUploader - EVENT: FileUploaded - parametri: err => " + JSON.stringify(file) + " - response => " + JSON.stringify(response));
	    var obj = JSON.parse(response.response);
	    if (obj.error !== undefined && obj.error !== null) {
		$('#uploaderError').removeClass('no-display');
		$('#progressbar').addClass('no-display');
		console.log(response);
	    } else {
		addNewSong(obj.src, obj.duration, getTagsMusicTrack());
	    }
	    $('#progressbar').fadeOut();
	});
    } catch (err) {
	console.log("An error occurred - message : " + err.message);
    }
}

function getTagsMusicTrack() {
    try {
	var tags = new Array();
	$.each($("#tag-musicTrack :checkbox"), function() {

	    if ($(this).is(":checked")) {
		tags.push($(this).val());
	    }
	});
	return tags.join();
    } catch (err) {
	console.log("getTagsMusicTrack | An error occurred - message : " + err.message);
    }
}

function addNewSong(id, duration, tags) {
    try {
	var songTitle = $("#trackTitle").val();
	var featuring = getFeaturingList("trackFeaturing");
	var json_elem = {"src": id, "tags": tags, "featuring": featuring, "title": songTitle, "duration": duration};
	json_album.list.push(json_elem);
	window.console.log("Lista" + JSON.stringify(json_album.list));
	addSongToList(json_elem.title, json_elem.duration, json_elem.tags, true, id.substring(0, id.indexOf(".")));
	//clear values
	$("#trackTitle").val("");
	$('#tag-musicTrack').find(':checked').each(function() {
	    $(this).removeAttr('checked');
	});

    } catch (err) {
	console.log("addNewSong | An error occurred - message : " + err.message);
    }
}

function addSongToList(title, duration, genre, isNew, id) {
    try {
	var html = "";
	html += '<tr id="tr_song_list_' + id + '">';
	html += '<td class="title _note-button">' + title + '</td>';
	html += '<td class="time">' + duration + '</td>';
	var genreList = genre.split(",")
	var translatedGenreList = new Array();
	for (var c = 0; c < genreList.length; c++) {
	    translatedGenreList.push(($("#" + genreList[c])).html());
	}

	html += '<td class="genre">' + translatedGenreList.join() + '</td>';
	if (isNew) {
	    html += '<td class="delete _delete-button" onClick="javascript:removeSongFromList(\'' + id + '\')"></tdr>';
	} else {
	    html += '<td class="delete _delete-button" onClick="javascript:deleteSong(\'' + id + '\')"></tdr>';
	}

	$("#songlist").append(html);
	$('#uploadRecord-detail').removeClass('no-display');
	$('html, body').animate({scrollTop: $('#tr_song_list_' + id).position().top}, 'slow');

    } catch (err) {
	console.log("addSongToList | An error occurred - message : " + err.message);
    }
}

function publish() {
    try {
	sendRequest("uploadRecord", "publish", json_album, publishCallback, false);
    } catch (err) {
	console.log("publish | An error occurred - message : " + err.message);
    }
}

function publishCallback(data, status) {
    try {
	console.log(data);
	if (status === "success" && data !== undefined && data !== null && data.id !== undefined && data.id !== null) {
	    alert(data.status);
//	    redirect("record.php?record=" + data.id);
	} else {
	    alert(data.status);
//	    location.reload();
	}
    } catch (err) {
	console.log("publishCallback | An error occurred - message : " + err.message);
    }
}

////////////////////////////////////////////////////////////////////////////////
//
//  Dati per il precaricamento
//
////////////////////////////////////////////////////////////////////////////////

function getSongs(recordId) {
    try {
	//per test : sK0Azt3WiP
	if (recordId != undefined && recordId != null && recordId.length > 0) {
	    var json_for_count_song = {recordId: recordId};
	    sendRequest("uploadRecord", "getSongsList", json_for_count_song, getSongCallback, true);
	}
    } catch (err) {
	console.log("getSongs | An error occurred - message : " + err.message);
    }
}

function getSongCallback(data, status) {
    try {
	if (status == "success" && data.songList != undefined && data.songList != null && data.count != undefined && data.count != null && data.count >= 0) {
	    json_album.count = data.count;
	    for (var i = 0; i < data.count; i++) {
		var song = JSON.parse(data.songList[i]);
		var title = (song.title != undefined && song.title != null && song.title.length > 0) ? song.title : "no title";
		var genre = (song.genre != undefined && song.genre != null && song.genre.length > 0) ? song.genre : "no genre";
		var duration = (song.duration != undefined && song.duration != null) ? song.duration : "no duration";
		var id = (song.id != undefined && song.id != null) ? song.id : 0;
		addSongToList(title, duration, genre, false, id);
	    }
	} else {
	    json_album.count = 0;
	}
	if (data.count > 0)
	    $('#uploadRecord-detail').removeClass('no-display');
    } catch (err) {
	console.log("getSongCallback | An error occurred - message : " + err.message);
    }
}


function clearAll() {
    try {
	json_album.list = [];
	$("#songlist").html("");
	getSongs(json_album.recordId);
    } catch (err) {
	console.log("clearAll | An error occurred - message : " + err.message);
    }

}

function removeSongFromList(src) {
    try {
	$('#tr_song_list_' + src).remove();
	for (var i = 0; i < json_album.list.length; i++) {
	    var song = json_album.list[i];
	    if (song.src === src + ".mp3") {
		json_album.list.splice(i, 1);
		break;
	    }
	}
	console.log("Lista => " + JSON.stringify(json_album.list));
    } catch (err) {
	console.log("removeSongFromList | An error occurred - message : " + err.message);
    }

}

function deleteSong(songId) {
    try {
	if (songId !== undefined && songId !== null && json_album.recordId !== undefined && json_album.recordId !== null) {
	    var json_delete = {"songId": songId, "recordId": json_album.recordId};
	    sendRequest("uploadRecord", "deleteSong", json_delete, deleteSongCallback, false);
	}
    } catch (err) {
	console.log("deleteSong | An error occurred - message : " + err.message);
    }
}

function deleteSongCallback(data, status, xhr) {
    try {
	if (status === "success") {
	    window.console.log(data.status);
	    $('#tr_song_list_' + data.id).remove();
	    alert(data.status);
	} else {
	    alert(data.status);
	}

    } catch (err) {
	console.log("deleteSongCallback | An error occurred - message : " + err.message);
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


function onCarouselReady() {
    try {
//        stopLoader(recordLoader);
	//gestione select album record
	$('.uploadRecord-boxSingleRecord').click(function() {
	    $("#uploadRecord01").fadeOut(100, function() {
		$("#uploadRecord03").fadeIn(100);
	    });
	    json_album.recordId = this.id;
	    //recupero gli mp3 dell'album
	    getSongs(json_album.recordId);
	    //inizializzazione dell'uploader
	    initMp3Uploader();
	});
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
    } catch (err) {
	console.log("onCarouselReady | An error occurred - message : " + err.message);
    }
}