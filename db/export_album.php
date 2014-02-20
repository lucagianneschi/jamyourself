<?php
ini_set('display_errors', '1');

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';

require_once CLASSES_DIR . 'album.class.php';
require_once CLASSES_DIR . 'albumParse.class.php';
$albumParse = new AlbumParse();

//albums
$albumParse->whereExists('createdAt');
$albumParse->orderByAscending('createdAt');
$albumParse->setLimit($_GET['l']);
$albumParse->setSkip($_GET['s']);
$albums = $albumParse->getAlbums();

//album
/*
$album = $albumParse->getAlbum('rSyDWhF82L');
$albums[] = $album;
*/

foreach ($albums as $album) {
    
    //print_r($album);
    
    $query = "
    INSERT INTO album (id,
                       objectid,
                       active,
                       commentcounter,
                       counter,
                       description,
                       fromuser,
                       imagecounter,
                       locationlat,
                       locationlon,
                       lovecounter,
                       sharecounter,
                       thumbnail,
                       title,
                       created,
                       updated)
              VALUES (NULL,
                      '" . $album->getObjectId() . "',
                      " . ($album->getActive() ? 1 : 0) . ",
                      " . ($album->getCommentCounter() != null ? $album->getCommentCounter() : 0) . ",
                      " . ($album->getCounter() != null ? $album->getCounter() : 0) . ",
                      '" . str_replace("'", "\'", $album->getDescription()) . "',
                      (SELECT id
                         FROM user
                        WHERE objectid = '" . $album->getFromuser() . "'),
                      " . ($album->getImageCounter() != null ? $album->getImageCounter() : 0) . ",
                      " . ($album->getLocation()->lat != null ? $album->getLocation()->lat : 0) . ",
                      " . ($album->getLocation()->long != null ? $album->getLocation()->long : 0) . ",
                      " . ($album->getLoveCounter() != null ? $album->getLoveCounter() : 0) . ",
                      " . ($album->getShareCounter() != null ? $album->getShareCounter() : 0) . ",
                      '" . $album->getThumbnailCover() . "',
                      '" . str_replace("'", "\'", $album->getTitle()) . "',
                      '" . strftime("%Y-%m-%d %H:%M:%S", $album->getCreatedAt()->getTimestamp()) . "',
                      '" . strftime("%Y-%m-%d %H:%M:%S", $album->getUpdatedAt()->getTimestamp()) . "')
    ";

    //echo $query;
    
    //scrivo l'album
    $connection = mysqli_connect('jam-mysql-dev.cloudapp.net', 'jamyourself', 'j4my0urs3lf', 'jamdatabase');
    mysqli_query($connection, $query);
    $id_album = mysqli_insert_id($connection);
    mysqli_close($connection);
    
    if ($id_album == 0) {
        echo 'Sono uno scarto';
        $connection = mysqli_connect('jam-mysql-dev.cloudapp.net', 'jamyourself', 'j4my0urs3lf', 'jamdatabase');
        mysqli_query($connection, "INSERT INTO scarti VALUES ('" . $album->getObjectId() . "', 'album')");
        mysqli_close($connection);
    } else {
        //scrivo i tag
        echo 'Sono i tag';
        foreach ($album->getTags() as $tag) {
            $connection = mysqli_connect('jam-mysql-dev.cloudapp.net', 'jamyourself', 'j4my0urs3lf', 'jamdatabase');
            mysqli_query($connection, "INSERT INTO album_tag VALUES (" . $id_album . ", " . $tag . ")");
            mysqli_close($connection);
        }
    }
    echo 'OK => ' . $id_album;
    
}

sleep(1);

?>
<html>
<head>
<script type="text/javascript">
    function redirectUrl() {
		window.location = "export_album.php?s=<?php echo ($_GET['s'] + $_GET['l']); ?>&l=10"
	}
</script>
</head>
<body onload="redirectUrl()">
</body>
</html>