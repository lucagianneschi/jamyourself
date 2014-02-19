<?php
ini_set('display_errors', '1');

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';

require_once CLASSES_DIR . 'record.class.php';
require_once CLASSES_DIR . 'recordParse.class.php';
$recordParse = new recordParse();

//records
$recordParse->whereExists('createdAt');
$recordParse->orderByAscending('createdAt');
$recordParse->setLimit($_GET['l']);
$recordParse->setSkip($_GET['s']);
$records = $recordParse->getRecords();

//record
/*
$record = $recordParse->getRecord('rSyDWhF82L');
$records[] = $record;
*/

foreach ($records as $record) {
    
    //print_r($record);
    
    $query = "
    INSERT INTO record (id,
                        objectid,
                        active,
                        buylink,
                        city,
                        commentcounter,
                        counter,
                        cover,
                        description,
                        duration,
                        fromuser,
                        label,
                        locationlat,
                        locationlon,
                        lovecounter,
                        reviewcounter,
                        sharecounter,
                        songcounter,
                        thumbnail,
                        title,
                        year,
                        created,
                        updated)
              VALUES (NULL,
                      '" . $record->getObjectId() . "',
                      " . ($record->getActive() ? 1 : 0) . ",
                      '" . $record->getBuyLink() . "',
                      '" . $record->getCity() . "',
                      " . ($record->getCommentCounter() != null ? $record->getCommentCounter() : 0) . ",
                      " . ($record->getCounter() != null ? $record->getCounter() : 0) . ",
                      '" . $record->getCover() . "',
                      '" . str_replace("'", "\'", $record->getDescription()) . "',
                      " . ($record->getDuration() != null ? $record->getDuration() : 0) . ",
                      (SELECT id
                         FROM user
                        WHERE objectid = '" . $record->getFromUser() . "'),
                      '" . $record->getLabel() . "',
                      " . ($record->getLocation()->lat != null ? $record->getLocation()->lat : 0) . ",
                      " . ($record->getLocation()->long != null ? $record->getLocation()->long : 0) . ",
                      " . ($record->getLoveCounter() != null ? $record->getLoveCounter() : 0) . ",
                      " . ($record->getReviewCounter() != null ? $record->getReviewCounter() : 0) . ",
                      " . ($record->getShareCounter() != null ? $record->getShareCounter() : 0) . ",
                      " . ($record->getSongCounter() != null ? $record->getSongCounter() : 0) . ",
                      '" . $record->getThumbnailCover() . "',
                      '" . $record->getTitle() . "',
                      " . ($record->getYear() != null ? $record->getYear() : 0) . ",
                      '" . strftime("%Y-%m-%d %H:%M:%S", $record->getCreatedAt()->getTimestamp()) . "',
                      '" . strftime("%Y-%m-%d %H:%M:%S", $record->getUpdatedAt()->getTimestamp()) . "')
    ";

    //echo $query;
    
    //scrivo lo user
    $connection = mysqli_connect('jam-mysql-dev.cloudapp.net', 'jamyourself', 'j4my0urs3lf', 'jamdatabase');
    mysqli_query($connection, $query);
    $id_record = mysqli_insert_id($connection);
    mysqli_close($connection);
    
    if ($id_record == 0) {
        echo 'Sono uno scarto';
        $connection = mysqli_connect('jam-mysql-dev.cloudapp.net', 'jamyourself', 'j4my0urs3lf', 'jamdatabase');
        mysqli_query($connection, "INSERT INTO scarti VALUES ('" . $record->getObjectId() . "', 'record')");
        mysqli_close($connection);
    } else {
        //scrivo il genre
        echo 'Sono il genre';
        $connection = mysqli_connect('jam-mysql-dev.cloudapp.net', 'jamyourself', 'j4my0urs3lf', 'jamdatabase');
        mysqli_query($connection, "INSERT INTO genre VALUES (NULL, '" . $record->getGenre() . "')");
        $id_genre = mysqli_insert_id($connection);
        mysqli_query($connection, "INSERT INTO record_genre VALUES (" . $id_record . ", " . $id_genre . ")");
        mysqli_close($connection);
    }
    echo 'OK => ' . $id_record;
}

sleep(1);

?>
<html>
<head>
<script type="text/javascript">
    function redirectUrl() {
		window.location = "export_record.php?s=<?php echo ($_GET['s'] + $_GET['l']); ?>&l=10"
	}
</script>
</head>
<body onload="redirectUrl()">
</body>
</html>