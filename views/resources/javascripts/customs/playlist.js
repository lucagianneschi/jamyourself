function playlist(playlistId, songId, opType, objectIdUser) {
    var json_playlist = {};
    if (opType === 'add') {
        json_playlist.request = 'addSong';
    } else {
        json_playlist.request = 'removeSong';
    }
    json_playlist.playlistId = playlistId;
    json_playlist.songId = songId;
    json_playlist.objectIdUser = objectIdUser;

    $.ajax({
        data: json_playlist,
        type: "POST",
        url: "../../../controllers/request/playlistRequest.php"
    })
            .done(function(number_love, status, xhr) {
                if (typeOpt === 'add') {

                } else {

                }
                code = xhr.status;
                console.log("Code: " + code + " | Message: " + number_love);
            })
            .fail(function(xhr) {
                message = $.parseJSON(xhr.responseText).status;
                code = xhr.status;
                console.log("Code: " + code + " | Message: " + message);
            });

}