<?php
ini_set('display_errors', '1');

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';

require_once CLASSES_DIR . 'playlist.class.php';
require_once CLASSES_DIR . 'playlistParse.class.php';
$playlistParse = new PlaylistParse();

//playlists
$playlistParse->whereExists('createdAt');
$playlistParse->orderByAscending('createdAt');
$playlistParse->setLimit($_GET['l']);
$playlistParse->setSkip($_GET['s']);
$playlists = $playlistParse->getPlaylists();

//playlist
/*
$playlist = $playlistParse->getPlaylist('rSyDWhF82L');
$playlists[] = $playlist;
*/

foreach ($playlists as $playlist) {
    
    //print_r($playlist);
    
    $query = "
    INSERT INTO playlist (id,
                          objectid,
                          active,
                          fromuser,
                          name,
                          unlimited,
                          created,
                          updated)
              VALUES (NULL,
                      '" . $playlist->getObjectId() . "',
                      " . ($playlist->getActive() ? 1 : 0) . ",
                      (SELECT id
                         FROM user
                        WHERE objectid = '" . $playlist->getFromUser() . "'),
                      '" . $playlist->getName() . "',
                      " . ($playlist->getUnlimited() ? 1 : 0) . ",
                      '" . strftime("%Y-%m-%d %H:%M:%S", $playlist->getCreatedAt()->getTimestamp()) . "',
                      '" . strftime("%Y-%m-%d %H:%M:%S", $playlist->getUpdatedAt()->getTimestamp()) . "')
    ";

    //echo $query;
    
    //scrivo la playlist
    $connection = mysqli_connect('jam-mysql-dev.cloudapp.net', 'jamyourself', 'j4my0urs3lf', 'jamdatabase');
    mysqli_query($connection, $query);
    $id_playlist = mysqli_insert_id($connection);
    mysqli_close($connection);
    
    if ($id_playlist == 0) {
        echo 'Sono uno scarto';
        $connection = mysqli_connect('jam-mysql-dev.cloudapp.net', 'jamyourself', 'j4my0urs3lf', 'jamdatabase');
        mysqli_query($connection, "INSERT INTO scarti VALUES ('" . $playlist->getObjectId() . "', 'playlist')");
        mysqli_close($connection);
    }
    echo 'OK => ' . $id_playlist;
}

sleep(1);

?>
<html>
<head>
<script type="text/javascript">
    function redirectUrl() {
		window.location = "export_playlist.php?s=<?php echo ($_GET['s'] + $_GET['l']); ?>&l=10"
	}
</script>
</head>
<body onload="redirectUrl()">
</body>
</html>