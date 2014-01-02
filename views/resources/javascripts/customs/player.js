//var myPlaylist;
//<![CDATA[
var duration;
$(document).ready(function(){
   duration = $('#duration-player').val();
// permette di muovere il playhead ------ INIT POSITION playhead-player 110
//loadBoxPlayList();

  

	// The shuffle commands

	$("#playlist-shuffle").click(function() {
		myPlaylist.shuffle();
	});

	$("#playlist-shuffle-false").click(function() {
		myPlaylist.shuffle(false);
	});
	$("#playlist-shuffle-true").click(function() {
		myPlaylist.shuffle(true);
	});



	// The next/previous commands

	$("#playlist-next").click(function() {
		myPlaylist.next();
	});
	$("#playlist-previous").click(function() {
		myPlaylist.previous();
	});

	// The play commands

	$("#playlist-play").click(function() {
		myPlaylist.play();
	});



	// The pause command

	$("#playlist-pause").click(function() {
		myPlaylist.pause();
	});




});

function getPlayer(){

	var myPlaylist = new jPlayerPlaylist({
			jPlayer: "#jquery_jplayer_N",
			cssSelectorAncestor: "#jp_container_N"
		}, [], {
			playlistOptions: {
				enableRemoveControls: true
			},
			nativeVideoControls:{
				
			},
			swfPath: "js",
			supplied: "mp3",
			smoothPlayBar: true,
			keyEnabled: true,
			audioFullScreen: false
		});
	return myPlaylist;
}

/*
 * aggiunge track alla playlist
 */
function addTrackPlaylist(_this,objectId){
	//chiama il controller per aggiungere la song alla playlist
	var json_playlist = {};
	
	typeOpt = $(_this).text();
	switch(typeOpt){
		case ' add to playlist':
			json_playlist.request = "addSong";
			break;
		case ' remove':
			json_playlist.request = "removeSong";
			break;
	}
	json_playlist.songId = objectId;
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
			playlist  = myPlaylist.playlist;
			jQuery.each(playlist, function (index, obj){
            if (obj.objectId == objectId){
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