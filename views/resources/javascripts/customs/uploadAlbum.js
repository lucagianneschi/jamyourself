//---------------- VALIDAZIONE FOUNDATION abide  ----------------------------- 
//------ espressioni regolari -------------------------------
var exp_description = /^([a-zA-Z0-9\s\xE0\xE8\xE9\xF9\xF2\xEC\x27!#$%&'()*+,-./:;<=>?[\]^_`{|}~][""]{0,0})*([a-zA-Z0-9\xE0\xE8\xE9\xF9\xF2\xEC\x27!#$%&'()*+,-./:;<=>?[\]^_`{|}~\s][""]{0,0})$/;
var featuringJSON = [];
var json_album_create = null;
var json_album_update = null;
var imageList = null;
var uploader = null;
$(document).ready(function() {

    getAlbums();
    //#TODO eliminare la funzione initFeaturing
 //   initFeaturing();
    //gesione button create new 
    $('#uploadAlbum-new').click(function() {
	$("#uploadAlbum01").fadeOut(100, function() {
	    $("#uploadAlbum02").fadeIn(100);
	    initGeocomplete();
	    imageList = new Array();
	    json_album_create = {};
	    if (uploader === null) {
		initImgUploader();
	    }
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
	publish();
    });
});
// plugin di fondation per validare i campi tramite espressioni regolari (vedi sopra)
$(document).foundation('abide', {
    live_validate: true,
    focus_on_invalid: true,
    timeout: 1000,
    patterns: {
	description: exp_description
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
	window.console.log("initFeaturing | An error occurred - message : " + err.message);
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
	window.console.log("initGeocomplete | An error occurred - message : " + err.message);
    }
}
function initImgUploader() {
    try {
//inizializzazione dei parametri
	var selectButtonId = "upload-album";
	var url = "../controllers/request/uploadRequest.php";
	var runtime = 'html5';
	if (supportsCanvas()) {
	    runtime = 'html5';
	}
	var multi_selection = true;
	var maxFileSize = "12mb";
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
	});
	uploader.init();
	uploader.bind('FilesAdded', function(up, files) {
	    try {
		$.each(files, function() {
		    var elem = {};
		    elem.id = this.id;
		    elem.prevFile = this;
		    elem.isUploaded = false;
		    elem.isActive = false;
		    elem.uploaded = null;
		    imageList.push(elem);
		    var row = getTableRowImage(elem.id);
		    $('#photolist').append(row);
		    getFeaturing('#featuringPhoto_' + elem.id);
		    /*
		    $('#featuringPhoto_' + elem.id).select2({
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
		    });*/
		    if (supportsCanvas()) {
			var img = new mOxie.Image();
			startEventsImage(img, '#photo_img_' + elem.id);
			img.load(this.getSource());
		    } else {
			$('#photo_img_' + elem.id).attr("class", "sottotitle orange");
			$('#photo_img_' + elem.id).html(this.name);
		    }
		});
		//scroll to image list
		$('html, body').animate({scrollTop: $('#uploadAlbum-listPhoto').position().top}, 'slow');
		uploader.start();
	    } catch (err) {
		window.console.log("initImgUploader - FilesAdded | An error occurred - message : " + err.message);
	    }
	});
	uploader.bind('UploadProgress', function(up, file) {
	    handleProgressBar(file);
	    if (up.total.percent !== 100) {
		$('#uploadAlbum03-publish').hide();
	    } else {
		$('#uploadAlbum03-publish').show();
	    }
	});
	uploader.bind('Error', function(up, err) {
	    up.refresh();
	});
	uploader.bind('FileUploaded', function(up, file, response) {
	    try {
		var uploaded = JSON.parse(response.response);
		$.each(imageList, function() {
		    if (file.id === this.id) {
			this.isUploaded = true;
			this.isActive = true;
			this.uploaded = uploaded;
		    }
		});
	    } catch (err) {
		window.console.log("initImgUploader - FileUploaded | An error occurred - message : " + err.message);
	    }
	});
    } catch (err) {
	window.console.log("initImgUploader | An error occurred - message : " + err.message);
    }

}
function handleProgressBar(file) {
    $('#percentage_' + file.id).html(file.percent + "%");
}

function getTableRowImage(id) {
    try {
	return '<tr id="image-uploaded-row_' + id + '">' +
		'<td class="photo"><div id="photo_img_' + id + '"></div></td>' +
		'<td class="info">' +
		'<div class="row">' +
		'<div  class="small-12 columns">' +
		'<input type="text" name="descriptionPhoto_' + id + '" id="descriptionPhoto_' + id + '" pattern=""/>' +
		'<label for="descriptionPhoto_' + id + '">Describe this photo</label>' +
		'</div>' +
		'</div>' +
		'<div class="row">' +
		'<div  class="small-12 columns">' +
		'<input type="text" name="featuringPhoto_' + id + '" id="featuringPhoto_' + id + '" pattern=""/>' +
		'<label for="featuringPhoto_' + id + '">Who is in this photo?</label>' +
		'</div>' +
		'</div>' +
		'</td>' +
		'<td class="option">' +
		'<div class="iscover">' +
		'<span data-tooltip class="tip-top" title="Set as Cover">' +
		'<input type="radio" name="cover" id="idCover_' + id + '" value="idCover_' + id + '" class="no-display">' +
		'<label for="idCover_' + id + '"><div class="buttonIsCover"></div></label></span>' +
		'</div>' +
		'<div id="percentage_' + id + '">0%' +
		'</div>' +
		'<div class="delete _delete-button" onclick="javascript:removeImageFromList(\'' + $.trim(id) + '\')"></div>' +
		'</td>' +
		'</tr>';
    } catch (err) {
	window.console.log("getTableRowImage | An error occurred - message : " + err.message);
    }
}

function removeImageFromList(id) {
    try {
	$('#image-uploaded-row_' + id).remove();
	$.each(imageList, function() {
	    if (this.id === id) {
		this.isActive = false;
		return;
	    }
	});
    } catch (err) {
	window.console.log("removeImageFromList | An error occurred - message : " + err.message);
    }
}

function startEventsImage(img, id) {
    try {
	img.onload = function() {
	    this.embed($(id).get(0), {
		width: 300, //max width    
		height: 300, //max height
		crop: false     // true => immagini quadrate (ritagliate)
	    });
	};
	img.onembedded = function() {
	    this.destroy();
	};
	img.onerror = function() {
	    this.destroy();
	};
    } catch (err) {
	window.console.log("startEventsImage | An error occurred - message : " + err.message);
    }
}

function publish() {
    try {
	if (json_album_create !== null && json_album_create !== undefined) {
	    json_album_create.albumTitle = $("#albumTitle").val();
	    json_album_create.description = $("#description").val();
	    json_album_create.images = getImagesInfo();
	    json_album_create.featuring = getFeaturingList("featuring");
	    window.console.log("SENDING: " + JSON.stringify(json_album_create));
	    sendRequest("uploadAlbum", "createAlbum", json_album_create, publishCallback, false);
	} else if (json_album_update !== null && json_album_update !== undefined) {
	    json_album_update.images = getImagesInfo();
	    json_album_update.featuring = getFeaturingList("featuring");
	    window.console.log("SENDING: " + JSON.stringify(json_album_create));
	    sendRequest("uploadAlbum", "updateAlbum", json_album_update, publishCallback, false);
	}

    } catch (err) {
	window.console.log("publish | An error occurred - message : " + err.message);
    }

}
function clearList() {
//        json_album_create = null;
//        json_album_update = null;
    imageList = new Array();
    $("#photolist").empty();
}

function publishCallback(data, status, xhr) {
    try {
	console.debug("Data : " + JSON.stringify(data) + " | Status: " + status);
	if (status === "success") {
	    alert(data.status);
	    redirect("profile.php");
	} else {
	    alert(data.status);
	    console.debug("Data : " + JSON.stringify(data) + " | Status: " + status);
	    redirect("profile.php");
	}

	clearList();
    } catch (err) {
	window.console.log("publish | An error occurred - message : " + err.message);
    }
}

function getImagesInfo() {
    try {
	var info = new Array();
	$.each(imageList, function() {
	    if (this.isActive && this.isUploaded) {
		var elem = {};
		var id = this.id;
		elem.description = $("#descriptionPhoto_" + id).val();
		elem.featuring = getFeaturingList('featuringPhoto_' + id);
		elem.src = this.uploaded.src;
		if ($('#idCover_' + id).is(':checked')) {
		    elem.isCover = true;
		} else {
		    elem.isCover = false;
		}
		info.push(elem);
	    }
	});
	return info;
    } catch (err) {
	window.console.log("getImagesInfo | An error occurred - message : " + err.message);
    }
}

////////////////////////////////////////////////////////////////////////////////
//
// Gestione carosello album
//
////////////////////////////////////////////////////////////////////////////////
function getAlbums() {

    try {
	goSpinner('#albums_spinner');
	sendRequest("uploadAlbum", "getAlbums", null, getAlbumsCallback, false);
    } catch (err) {
	window.console.log("getAlbums | An error occurred - message : " + err.message);
    }
}
function getAlbumsCallback(data, status, xhr) {
    try {
	console.debug("Data : " + JSON.stringify(data) + " | Status: " + status);
	if (status === "success" && data.count !== undefined && data.count !== null && data.count > 0) {
	    for (var i = 0; i < data.count; i++) {
		$("#albumList").append(getCarouselElementHTML(data.albumList[i]));
	    }
	    stopSpinner('#albums_spinner');
	    onCarouselReady();
	} else {
	    stopSpinner('#albums_spinner');
	    console.debug("Data : " + JSON.stringify(data) + " | Status: " + status);
	}

    } catch (err) {
	window.console.log("getAlbumsCallback | An error occurred - message : " + err.message);
    }
}
function getCarouselElementHTML(obj) {
    var html = '<li class="touchcarousel-item">' +
	    '<div class="item-block uploadAlbum-boxSingleAlbum" id="' + obj.albumId + '">' +
	    '<div class="row uploadAlbum-rowSingleAlbum">' +
	    '<div  class="small-6 columns ">' +
	    '<img class="coverAlbum"  src="' + obj.thumbnail + '"> ' +
	    '</div>' +
	    '<div  class="small-6 columns title">' +
	    '<div class="sottotitle white">' + obj.title + '</div>' +
	    '<div class="text white">' + obj.images + ' photos</div>' +
	    '</div>' +
	    '</div>' +
	    '</div>' +
	    '</li>';
    return html;
}
function onCarouselReady() {
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
	imageList = new Array();
	json_album_update = {"albumId": this.id};
	if (uploader === null) {
	    initImgUploader();
	}
    });
}