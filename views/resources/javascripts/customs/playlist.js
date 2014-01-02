function playlist(_this,opt,song) {	
	var json_playlist = {};
	try {
	
	   //chiama il controller per aggiungere la song alla playlist			
		switch(opt){
			case 'add':
				json_playlist.request = "addSong";
				break;
			case 'remove':
				json_playlist.request = "removeSong";
				break;
		}
		json_playlist.songId = song.objectId;
		$.ajax({
	        data: json_playlist,
	        type: "POST",
	        url: "../controllers/request/playlistRequest.php"
	    })
	    .done(function(response, status, xhr) {
	        if (opt == 'add') {
				myPlaylist.add({
					objectId: song.objectId,
					title: song.title,
					artist: song.artist,
					mp3:"http://www.jplayer.org/audio/mp3/TSP-01-Cro_magnon_man.mp3" //ci va l'url dell'mp3  -> song.mp3
				});
				$(_this).addClass('no-display');
				$(_this).next().removeClass('no-display');
	        } else {
				
				var songs  = myPlaylist.playlist;
				
				jQuery.each(songs, function (index, obj){
		            if (obj.objectId === song.objectId){
		                    myPlaylist.remove(index);
		
		            } 
		            
		        });
				$(_this).addClass('no-display');
				$(_this).prev().removeClass('no-display');	
				
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
	
  	} catch (err) {
        console.log("playlist | An error occurred - message : " + err.message);
    }
    
}