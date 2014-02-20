<?php
ini_set('display_errors', '1');

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';

require_once CLASSES_DIR . 'song.class.php';
require_once CLASSES_DIR . 'songParse.class.php';
$songParse = new SongParse();

//songs
$songParse->whereExists('createdAt');
$songParse->orderByAscending('createdAt');
$songParse->setLimit($_GET['l']);
$songParse->setSkip($_GET['s']);
$songs = $songParse->getSongs();

//song
/*
$song = $songParse->getsong('XUe4IsZsdX');
$songs[] = $song;
*/

foreach ($songs as $song) {
    
    //print_r($song);
    
    $query = "
    INSERT INTO song (id,
                      objectid,
                      active,
                      commentcounter,
                      counter,
                      duration,
                      filepath,
                      fromuser,
                      locationlat,
                      locationlon,
                      lovecounter,
                      position,
                      record,
                      sharecounter,
                      title,
                      created,
                      updated)
              VALUES (NULL,
                      '" . $song->getObjectId() . "',
                      " . ($song->getActive() ? 1 : 0) . ",
                      " . ($song->getCommentCounter() != null ? $song->getCommentCounter() : 0) . ",
                      " . ($song->getCounter() != null ? $song->getCounter() : 0) . ",
                      " . ($song->getDuration() != null ? $song->getDuration() : 0) . ",
                      '" . $song->getFilePath() . "',
                      (SELECT id
                         FROM user
                        WHERE objectid = '" . $song->getFromUser() . "'),
                      " . ($song->getLocation()->lat != null ? $song->getLocation()->lat : 0) . ",
                      " . ($song->getLocation()->long != null ? $song->getLocation()->long : 0) . ",
                      " . ($song->getLoveCounter() != null ? $song->getLoveCounter() : 0) . ",
                      " . ($song->getPosition() != null ? $song->getPosition() : 0) . ",
                      (SELECT id
                         FROM record
                        WHERE objectid = '" . $song->getRecord() . "'),
                      " . ($song->getShareCounter() != null ? $song->getShareCounter() : 0) . ",
                      '" . str_replace("'", "\'", $song->getTitle()) . "',
                      '" . strftime("%Y-%m-%d %H:%M:%S", $song->getCreatedAt()->getTimestamp()) . "',
                      '" . strftime("%Y-%m-%d %H:%M:%S", $song->getUpdatedAt()->getTimestamp()) . "')
    ";

    echo $query;
    
    //scrivo lo user
    $connection = mysqli_connect('jam-mysql-dev.cloudapp.net', 'jamyourself', 'j4my0urs3lf', 'jamdatabase');
    mysqli_query($connection, $query);
    $id_song = mysqli_insert_id($connection);
    mysqli_close($connection);
    
    if ($id_song == 0) {
        echo 'Sono uno scarto';
        $connection = mysqli_connect('jam-mysql-dev.cloudapp.net', 'jamyourself', 'j4my0urs3lf', 'jamdatabase');
        mysqli_query($connection, "INSERT INTO scarti VALUES ('" . $song->getObjectId() . "', 'song')");
        mysqli_close($connection);
    } else {
        //scrivo il genre
        echo 'Sono il genre';
        $connection = mysqli_connect('jam-mysql-dev.cloudapp.net', 'jamyourself', 'j4my0urs3lf', 'jamdatabase');
        $results = mysqli_query($connection, "SELECT id FROM genre WHERE genre = '" . $song->getGenre() . "'");
        $row = mysqli_fetch_array($results, MYSQLI_ASSOC);
        mysqli_query($connection, "INSERT INTO song_genre VALUES (" . $id_song . ", " . $row['id'] . ")");
        mysqli_close($connection);
    }
    echo 'OK => ' . $id_song;
}

sleep(1);

?>
<html>
<head>
<script type="text/javascript">
    function redirectUrl() {
		window.location = "export_song.php?s=<?php echo ($_GET['s'] + $_GET['l']); ?>&l=10"
	}
</script>
</head>
<body onload="redirectUrl()">
</body>
</html>