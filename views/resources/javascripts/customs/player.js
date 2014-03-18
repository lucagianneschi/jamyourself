//var myPlaylist;
//<![CDATA[
var duration;
$(document).ready(function() {

    duration = $('#duration-player').val();

    // permette di muovere il playhead ------ INIT POSITION playhead-player 110
    $("#playhead-player").draggable({
	containment: "#bar-player",
	axis: "x",
	opacity: 50,
	drag: function(ev, ui) {
	    pos = ui.position.left - 115;
	    //--- in base alla posizione del playhead si muove la barra dello status della canzone
	    $("#statusbar-player").css({width: pos + "px"});
	    var posizione = parseInt((pos / 155) * 100);
	    $("#jquery_jplayer_N").jPlayer("playHead", posizione);
	}
    });
    $('.play-pause').click(function() {
	if ($("#pause").is(":visible") == true) {
	    myPlaylist.pause();
	}
	else {
	    myPlaylist.play();
	}
    });




});
/*
 * play song dalla playlist
 */
function playSongPlayList(song, play) {
    try {
	jQuery.each($('#header-profile .songTitle'), function(index, obj) {
	    $(obj).removeClass('orange');
	});
	var title = $('#pl_' + song.id + ' .songTitle').html();
	var mp3 = $('#pl_' + song.id + ' input[name="song"]').val();
	var index = parseInt($('#pl_' + song.id + ' input[name="index"]').val());
	$('#header-box-thum img').attr('src', song.pathCover);
	$('#header-box-menu .title-player').html(title);
	if (play)
	    myPlaylist.play(index);
	$('#pl_' + song.id + ' .songTitle').addClass('orange');
	$('#play').hide();
	$('#pause').show();
    } catch (err) {
	window.console.error("playSongPlayList a | An error occurred - message : " + err.message);
    }
}
/*
 * play song da box record
 */
function playSong(id, pathCover) {
    try {
	jQuery.each($('#box-record a.jpPlay'), function(index, obj) {
	    $(obj).removeClass('orange');
	});
	var title = $('#' + id + ' .songTitle').html();
	var mp3 = $('#' + id + ' input[name="song"]').val();

	$('#header-box-thum img').attr('src', pathCover);
	$('#header-box-menu .title-player').html(title);

	$('#' + id + ' .jpPlay').addClass('orange');
	$("#jquery_jplayer_N").jPlayer("setMedia", {
	    mp3: mp3
	});

	myPlaylist.play();
    } catch (err) {
	window.console.error("playSong a | An error occurred - message : " + err.message);
    }
}

function getPlayer() {
    var myPlaylist = new jPlayerPlaylist({
	jPlayer: "#jquery_jplayer_N",
	cssSelectorAncestor: "#jp_container_N",
	cssSelector: {
	    play: '.jp-play',
	    duration: '#duration-player',
	}
    }, [], {
	playlistOptions: {
	    enableRemoveControls: true
	},
	nativeVideoControls: {
	},
	swfPath: "js",
	supplied: "mp3",
	smoothPlayBar: true,
	keyEnabled: true,
	audioFullScreen: false,
	play: function(event) {
	    $('#play').hide();
	    $('#pause').show();
	    playSongPlayList(event.jPlayer.status.media, false);
	},
	pause: function(event) {
	    $('#pause').hide();
	    $('#play').show();
	},
	ended: function(event) {
	    jQuery.each($('#header-profile .songTitle'), function(index, obj) {
		$(obj).removeClass('orange');
	    });
	},
	timeupdate: function(event) {
	    var currentTime = event.jPlayer.status.currentTime;
	    $('#time-player').html(getTime(currentTime));
	    var durata = event.jPlayer.status.duration;
	    $('#duration-player').html(getTime(durata));
	    var posizione = parseInt(currentTime / durata * 155);
	    $("#statusbar-player").css({'width': posizione + "px"});
	    posizione = posizione + 115;
	    $("#playhead-player").css({'left': posizione + "px"});
	},
    });
    return myPlaylist;
}

/*
 * formato time
 */
function getTime(time) {
    var sec_num = parseInt(time, 10); // don't forget the second param
    var hours = Math.floor(sec_num / 3600);
    var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
    var seconds = sec_num - (hours * 3600) - (minutes * 60);
    if (hours < 10) {
	hours = "0" + hours;
    }
    if (minutes < 10) {
	minutes = "0" + minutes;
    }
    if (seconds < 10) {
	seconds = "0" + seconds;
    }
    if (hours == '00')
	var timeF = minutes + ':' + seconds;
    else
	var timeF = hours + ':' + minutes + ':' + seconds;
    return timeF;
}

/*
 * aggiunge track alla playlist
 */
function addTrackPlaylist(_this, id) {
    //chiama il controller per aggiungere la song alla playlist
    var json_playlist = {};

    typeOpt = $(_this).text();
    switch (typeOpt) {
	case ' add to playlist':
	    json_playlist.request = "addSong";
	    break;
	case ' remove':
	    json_playlist.request = "removeSong";
	    break;
    }
    json_playlist.songId = id;
    $.ajax({
	data: json_playlist,
	type: "POST",
	url: "../controllers/request/playlistRequest.php"
    })
	    .done(function(response, status, xhr) {
	if (typeOpt === ' add to playlist') {
	    loadBoxPlayList();
	    $(_this).text(' remove');
	} else {
	    playlist = myPlaylist.playlist;
	    jQuery.each(playlist, function(index, obj) {
		if (obj.id == id) {
		    myPlaylist.remove(index);

		} // if condition end
		$(_this).text(' add to playlist');
	    });


	}
	code = xhr.status;
	message = $.parseJSON(xhr.responseText).status;
	console.log("Code: " + code + " | Message: " + message);
    })
	    .fail(function(xhr) {
	message = $.parseJSON(xhr.responseText).status;
	code = xhr.status;
	console.log("Code: " + code + " | Message: " + message);
    });


    //controllare il risultato dal controller

    //aggiungere alla playlist

}

function playlist(_this, opt, song) {
    var json_playlist = {};
    try {

	//chiama il controller per aggiungere la song alla playlist			
	switch (opt) {
	    case 'add':
		json_playlist.request = "addSong";
		break;
	    case 'remove':
		json_playlist.request = "removeSong";
		break;
	}
	json_playlist.songId = song.id;
	$.ajax({
	    data: json_playlist,
	    type: "POST",
	    url: "../controllers/request/playlistRequest.php"
	})
		.done(function(response, status, xhr) {
	    if (opt == 'add') {
		myPlaylist.add({
		    id: song.id,
		    title: song.title,
		    artist: song.artist,
		    mp3: song.mp3, //ci va l'url dell'mp3  -> song.mp3
		    love: song.love,
		    share: song.share,
		    pathCover: song.pathCover
		});
		$(_this).addClass('no-display');
		$(_this).next().removeClass('no-display');
	    } else {

		var songs = myPlaylist.playlist;

		jQuery.each(songs, function(index, obj) {
		    if (obj.id === song.id) {
			myPlaylist.remove(index);

		    }

		});
		$(_this).addClass('no-display');
		$(_this).prev().removeClass('no-display');

	    }
	    loadBoxPlayList();
	    code = xhr.status;
	    message = $.parseJSON(xhr.responseText).status;
	    console.log("Code: " + code + " | Message: " + message);
	})
		.fail(function(xhr) {
	    message = $.parseJSON(xhr.responseText).status;
	    code = xhr.status;
	    console.log("Code: " + code + " | Message: " + message);
	});

    } catch (err) {
	console.log("playlist | An error occurred - message : " + err.message);
    }

}
//]]>



//var duration;

// MODIFICARE (leggere in soundManager.onload)
//duration = $('#duration-player').val();


//$(document).ready(function() {
/*
 // permette di muovere il playhead ------ INIT POSITION playhead-player 110
 $("#playhead-player").draggable({ 
 containment: "#bar-player",
 axis: "x",
 opacity:50,
 drag: function(ev,ui) {      
 //   d_width = $('#bar-player').width();
 pos = ui.position.left - 110;
 
 //--- in base alla posizione del playhead si muove la barra dello status della canzone
 $("#statusbar-player").css({width: pos+"px"});
 
 //   pos = ui.position.left;	       
 //   tempo_att = (duration * pos)/d_width;
 
 //   soundManager.setPosition('mySound',tempo_att);	
 }
 });
 
 
 //controllo sul clic play-pause 
 $('.play-pause').click(function() {
 if($("#pause").is(":visible") == true){
 $('#pause').hide();
 $('#play').show();
 }
 else{
 $('#play').hide();
 $('#pause').show();
 }
 }); 
 */
//});