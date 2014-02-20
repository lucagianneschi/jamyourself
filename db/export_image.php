<?php
ini_set('display_errors', '1');

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';

require_once CLASSES_DIR . 'image.class.php';
require_once CLASSES_DIR . 'imageParse.class.php';
$imageParse = new ImageParse();

//images
$imageParse->whereExists('createdAt');
$imageParse->orderByAscending('createdAt');
$imageParse->setLimit($_GET['l']);
$imageParse->setSkip($_GET['s']);
$images = $imageParse->getImages();

//image
/*
$image = $imageParse->getImage('rSyDWhF82L');
$images[] = $image;
*/

foreach ($images as $image) {
    
    //print_r($image);
    
    $query = "
    INSERT INTO image (id,
                       objectid,
                       active,
                       album,
                       commentcounter,
                       counter,
                       description,
                       filepath,
                       fromuser,
                       locationlat,
                       locationlon,
                       lovecounter,
                       sharecounter,
                       thumbnail,
                       created,
                       updated)
              VALUES (NULL,
                      '" . $image->getObjectId() . "',
                      " . ($image->getActive() ? 1 : 0) . ",
                      (SELECT id
                         FROM album
                        WHERE objectid = '" . $image->getAlbum() . "'),
                      " . ($image->getCommentCounter() != null ? $image->getCommentCounter() : 0) . ",
                      " . ($image->getCounter() != null ? $image->getCounter() : 0) . ",
                      '" . str_replace("'", "\'", $image->getDescription()) . "',
                      '" . $image->getFilePath() . "',
                      (SELECT id
                         FROM user
                        WHERE objectid = '" . $image->getFromUser() . "'),
                      " . ($image->getLocation()->lat != null ? $image->getLocation()->lat : 0) . ",
                      " . ($image->getLocation()->long != null ? $image->getLocation()->long : 0) . ",
                      " . ($image->getLoveCounter() != null ? $image->getLoveCounter() : 0) . ",
                      " . ($image->getShareCounter() != null ? $image->getShareCounter() : 0) . ",
                      '" . $image->getThumbnail() . "',
                      '" . strftime("%Y-%m-%d %H:%M:%S", $image->getCreatedAt()->getTimestamp()) . "',
                      '" . strftime("%Y-%m-%d %H:%M:%S", $image->getUpdatedAt()->getTimestamp()) . "')
    ";

    //echo $query;
    
    //scrivo lo user
    $connection = mysqli_connect('jam-mysql-dev.cloudapp.net', 'jamyourself', 'j4my0urs3lf', 'jamdatabase');
    mysqli_query($connection, $query);
    $id_image = mysqli_insert_id($connection);
    mysqli_close($connection);
    
    if ($id_image == 0) {
        echo 'Sono uno scarto';
        $connection = mysqli_connect('jam-mysql-dev.cloudapp.net', 'jamyourself', 'j4my0urs3lf', 'jamdatabase');
        mysqli_query($connection, "INSERT INTO scarti VALUES ('" . $image->getObjectId() . "', 'image')");
        mysqli_close($connection);
    } else {
        //scrivo i tag
        echo 'Sono i tag';
        foreach ($image->getTags() as $tag) {
            $connection = mysqli_connect('jam-mysql-dev.cloudapp.net', 'jamyourself', 'j4my0urs3lf', 'jamdatabase');
            mysqli_query($connection, "INSERT INTO image_tag VALUES (" . $id_image . ", " . $tag . ")");
            mysqli_close($connection);
        }
    }
    echo 'OK => ' . $id_image;
}

sleep(1);

?>
<html>
<head>
<script type="text/javascript">
    function redirectUrl() {
		window.location = "export_image.php?s=<?php echo ($_GET['s'] + $_GET['l']); ?>&l=10"
	}
</script>
</head>
<body onload="redirectUrl()">
</body>
</html>