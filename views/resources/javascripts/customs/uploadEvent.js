var json_event_create = {"hours": "", "image": "", "crop": ""};
var music = null;
var uploader;
//------ espressioni regolari -------------------------------
var exp_general = /^([a-zA-Z0-9\s\xE0\xE8\xE9\xF9\xF2\xEC\x27!#$%&'()*+,-./:;<=>?[\]^_`{|}~][""]{0,0})*([a-zA-Z0-9\xE0\xE8\xE9\xF9\xF2\xEC\x27!#$%&'()*+,-./:;<=>?[\]^_`{|}~\s][""]{0,0})$/;

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
var maxCheckGenre = 0;
var maxCheckLocalType = 0;

$(document).ready(function() {
 //   initJammersJSON();
    initGeocomplete();
    initImgUploader();

    getCalendar();
    var time = getClockTime();
    $("#hours").html(time);

    validation();

    $("#city").onblur = function() {
	if (json_event_create.city === null) {
	    //NON VALIDO
	    $('label[for="city"]').addClass('error');
	    $("#city").attr("data-invalid", '');
	}
    };


});

/*
 * controller javascrip
 */
function validation() {
    try {
	// plugin di fondation per validare i campi tramite espressioni regolari (vedi sopra)
	$(document).foundation('abide', {
	    live_validate: true,
	    focus_on_invalid: true,
	    timeout: 1000,
	    patterns: {
		general: exp_general,
	    }
	});
    } catch (err) {
	window.console.error("validation | An error occurred - message : " + err.message);
    }
}

/*
 * gestione calendario
 */

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

/*
 * compila campo hours
 */
function getClockTime() {
    try {
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
    } catch (err) {
	window.console.error("getClockTime | An error occurred - message : " + err.message);
    }
}


function creteEvent() {
    try {
	json_event_create.title = $("#eventTitle").val();
	json_event_create.description = $("#description").val();
	json_event_create.date = $("#date").val();
	json_event_create.hours = $("#hours").val();
	json_event_create.venue = $("#venueName").val();
	json_event_create.jammers = getFeaturingList("jammers");
	json_event_create.tags = getTagsEventCreate();
	json_event_create.music = getMusicEventCreate();
	if (json_event_create.tags.length > 0) {
	    $("#label-tag-music .error").css({'display': 'none'});
	    sendRequest("uploadEvent", "createEvent", json_event_create, eventCreateCallback, false);
	}
	else {

	    $("#label-tag-music  .error").css({'display': 'block'});
	}

    } catch (err) {
	window.console.error("creteEvent | An error occurred - message : " + err.message);
    }

}

function eventCreateCallback(data, status, xhr) {
    try {
    	
	if (status === "success" && data !== undefined && data !== null && data.id !== undefined && data.id !== null) {
	    alert(data.status);
	    console.log(data.responseText);
//            clearAll();
	    redirect("event.php?event=" + data.id);
	}
	else {
	    alert(data.status);
	    console.log(data.responseText);
	    location.reload();
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
		tags.push($(this).val());
	    }
	});

	return tags;
    } catch (err) {
	window.console.log("getTagsEventCreate |An error occurred - message : " + err.message);
    }
}

function getMusicEventCreate() {
    try {
	var music = new Array();
	$.each($("#tag-localType :checkbox"), function() {
	    if ($(this).is(":checked")) {
		music.push($(this).val());
	    }
	});
	return music;
    } catch (err) {
	window.console.log("getMusicEventCreate |An error occurred - message : " + err.message);
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
    var runtime = 'html5';
    var multi_selection = false;
    var maxFileSize = "12mb";

//creo l'oggetto uploader (l'ho dichiarato ad inizio js in modo che sia globale)
    uploader = new plupload.Uploader({
	runtimes: runtime, //runtime di upload
	browse_button: selectButtonId, //id del pulsante di selezione file
	max_file_size: maxFileSize, //dimensione max dei file da caricare
	multi_selection: multi_selection, //forza un file alla volta per upload
	url: url,
	chunk_size: '100kb',
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
	goSpinner('#uploadImage_preview_box');
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
	img.src = "../cache/" + obj.src;
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
	stopSpinner('#uploadImage_preview_box');
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

//////////////////////////////////////////////////////////////////////////////
//  
//      Sezione geolocalizzazione
//
/////////////////////////////////////////////////////////////////////////////
function initGeocomplete() {
    try {
	$("#city").geocomplete()
		.bind("geocode:result", function(event, result) {
	    validateLocation(result);
	})
		.bind("geocode:error", function(event, status) {
	    json_event_create.city = null;

	})
		.bind("geocode:multiple", function(event, results) {
	    validateLocation(results[0]);
	});

    } catch (err) {
	console.log("initGeocomplete | An error occurred - message : " + err.message);
    }

}

function validateLocation(_result) {
    try {
	var location = getCompleteLocationInfo(_result);
	if (location.latitude === 0 || location.longitude === 0 || location.address === null) {
	    //NON VALIDO
	    json_event_create.city = null;
	    $('label[for="city"]').addClass('error');
	    $("#city").attr("data-invalid", '');
	} else {
	    //VALIDO
	    if ($('label[for="city"]').hasClass('error')) {
		$('label[for="city"]').removeClass('error');
		$("#city").removeAttr("data-invalid");
	    }
	    json_event_create.city = prepareLocationObj(_result);
	}
    } catch (err) {
	console.log("validateLocation | An error occurred - message : " + err.message);
    }
}
//////////////////////////////////////////////////////////////////////////////
//  
//      Sezione featuring
//
/////////////////////////////////////////////////////////////////////////////
function initJammersJSON() {
    try {
	//inizializza le info in sessione
	sendRequest("uploadEvent", "getFeaturingJSON", {"force": true}, null, true);

	//inizializza il plugin
	$('#jammers').select2({
	    multiple: true,
	    minimumInputLength: 1,
	    width: "100%",
	    ajax: {
		url: "../controllers/request/uploadEventRequest.php?request=getFeaturingJSON",
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
	console.log("initJammersJSON | An error occurred - message : " + err.message);
    }
}

function clearAll() {
    json_event_create = {"hours": "", "image": "", "crop": ""};
    $('#form-uploadEvent').reset();
}

/*
 * verifica numero max di checkbox
 */

function checkmaxGenre(elemento, max) {
    if (elemento.checked) {
	if ((maxCheckGenre + 1) == max)
	    maxCheckGenre += 1;
	else if ((maxCheckGenre) + 1 > max)
	    elemento.checked = false;
	else
	    maxCheckGenre += 1;
    }
    else {
	maxCheckGenre -= 1;
    }
}

/*
 * verifica numero max di checkbox
 */

function checkmaxLocalType(elemento, max) {
    if (elemento.checked) {
	if ((maxCheckLocalType + 1) == max)
	    maxCheckLocalType += 1;
	else if ((maxCheckLocalType) + 1 > max)
	    elemento.checked = false;
	else
	    maxCheckLocalType += 1;
    }
    else {
	maxCheckLocalType -= 1;
    }
}