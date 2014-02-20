<?php
//ini_set('display_errors', '1');

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';

require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';
$userParse = new UserParse();

//users
$userParse->whereExists('createdAt');
$userParse->orderByAscending('createdAt');
$userParse->setLimit($_GET['l']);
$userParse->setSkip($_GET['s']);
$users = $userParse->getUsers();

//user
/*
$user = $userParse->getUser('UZYqr00X7a');
$users[] = $user;
*/

foreach ($users as $user) {
    
    //print_r($user);
        
    //birthday
    if (!is_null($user->getBirthDay())) {
        $birthday = substr($user->getBirthDay(), 6, 4) . "-" . substr($user->getBirthDay(), 3, 2) . "-" . substr($user->getBirthDay(), 0, 2);
    } else {
        $birthday = '0000-00-00';
    }

    $query = "
    INSERT INTO user (id,
                      objectid,
                      username,
                      active,
                      address,
                      background,
                      birthday,
                      city,
                      collaborationcounter,
                      country,
                      description,
                      email,
                      facebookid,
                      facebookpage,
                      firstname,
                      followerscounter,
                      followingcounter,
                      friendshipcounter,
                      googlepluspage,
                      jammercounter,
                      jammertype,
                      lang,
                      lastname,
                      level,
                      levelvalue,
                      locationlat,
                      locationlon,
                      premium,
                      premiumexpirationdate,
                      profilepicture,
                      profilethumbnail,
                      sex,
                      twitterpage,
                      type,
                      venuecounter,
                      website,
                      youtubechannel,
                      created,
                      updated)
              VALUES (NULL,
                      '" . $user->getObjectId() . "',
                      '" . $user->getUsername() . "',
                      " . ($user->getActive() ? 1 : 0) . ",
                      '" . $user->getAddress() . "',
                      '" . $user->getBackground() . "',
                      '" . $birthday . "',
                      '" . str_replace("'", "\'", $user->getCity()) . "',
                      " . $user->getCollaborationCounter() . ",
                      '" . $user->getCountry() . "',
                      '" . str_replace("'", "\'", $user->getDescription()) . "',
                      '" . $user->getEmail() . "',
                      '" . $user->getFacebookId() . "',
                      '" . $user->getFbPage() . "',
                      '" . str_replace("'", "\'", $user->getFirstname()) . "',
                      " . $user->getFollowersCounter() . ",
                      " . $user->getFollowingCounter() . ",
                      " . $user->getFriendshipCounter() . ",
                      '" . $user->getGooglePlusPage() . "',
                      " . $user->getJammerCounter() . ",
                      '" . $user->getJammerType() . "',
                      NULL,
                      '" . str_replace("'", "\'", $user->getLastname()) . "',
                      " . ($user->getLevel() != null ? $user->getLevel() : 0) . ",
                      " . ($user->getLevelValue() != null ? $user->getLevelValue() : 0) . ",
                      " . ($user->getGeoCoding()->lat != null ? $user->getGeoCoding()->lat : 0) . ",
                      " . ($user->getGeoCoding()->long != null ? $user->getGeoCoding()->long : 0) . ",
                      " . ($user->getPremium() != null ? $user->getPremium() : 0) . ",
                      " . ($user->getPremiumExpirationDate() != null ? "'" . $user->getPremiumExpirationDate() . "'" : 'NULL') . ",
                      '" . $user->getProfilePicture() . "',
                      '" . $user->getProfileThumbnail() . "',
                      '" . $user->getSex() . "',
                      '" . $user->getTwitterPage() . "',
                      '" . $user->getType() . "',
                      " . $user->getVenueCounter() . ",
                      '" . $user->getWebsite() . "',
                      '" . $user->getYoutubeChannel() . "',
                      '" . strftime("%Y-%m-%d %H:%M:%S", $user->getCreatedAt()->getTimestamp()) . "',
                      '" . strftime("%Y-%m-%d %H:%M:%S", $user->getUpdatedAt()->getTimestamp()) . "')
    ";

    //echo $query;
    
    //scrivo lo user
    $connection = mysqli_connect('jam-mysql-dev.cloudapp.net', 'jamyourself', 'j4my0urs3lf', 'jamdatabase');
    mysqli_query($connection, $query);
    $id_user = mysqli_insert_id($connection);
    mysqli_close($connection);
    
    if ($id_user == 0) {
        echo 'Sono uno scarto';
        $connection = mysqli_connect('jam-mysql-dev.cloudapp.net', 'jamyourself', 'j4my0urs3lf', 'jamdatabase');
        mysqli_query($connection, "INSERT INTO scarti VALUES ('" . $user->getObjectId() . "', 'user')");
        mysqli_close($connection);
    } else {
        //scrivo il badge
        echo 'Sono il badge';
        foreach ($user->getBadge() as $badge) {
            $connection = mysqli_connect('jam-mysql-dev.cloudapp.net', 'jamyourself', 'j4my0urs3lf', 'jamdatabase');
            $results = mysqli_query($connection, "SELECT id FROM badge WHERE badge = '" . $badge . "'");
            $row = mysqli_fetch_array($results, MYSQLI_ASSOC);
            mysqli_query($connection, "INSERT INTO user_badge VALUES (" . $id_user . ", " . $row['id'] . ")");
            mysqli_close($connection);
        }
        
        //scrivo il localtype
        echo 'Sono il localtype';
        foreach ($user->getLocalType() as $localtype) {
            $connection = mysqli_connect('jam-mysql-dev.cloudapp.net', 'jamyourself', 'j4my0urs3lf', 'jamdatabase');
            $results = mysqli_query($connection, "SELECT id FROM localtype WHERE localtype = '" . $localtype . "'");
            $row = mysqli_fetch_array($results, MYSQLI_ASSOC);
            mysqli_query($connection, "INSERT INTO user_localtype VALUES (" . $id_user . ", " . $row['id'] . ")");
            mysqli_close($connection);
        }

        //scrivo la music
        echo 'Sono la music';
        foreach ($user->getMusic() as $music) {
            $connection = mysqli_connect('jam-mysql-dev.cloudapp.net', 'jamyourself', 'j4my0urs3lf', 'jamdatabase');
            $results = mysqli_query($connection, "SELECT id FROM music WHERE music = '" . $music . "'");
            $row = mysqli_fetch_array($results, MYSQLI_ASSOC);
            mysqli_query($connection, "INSERT INTO user_music VALUES (" . $id_user . ", " . $row['id'] . ")");
            mysqli_close($connection);
        }
    }
    echo 'OK => ' . $id_user;
}

sleep(1);

?>
<html>
<head>
<script type="text/javascript">
    function redirectUrl() {
		window.location = "export_user.php?s=<?php echo ($_GET['s'] + $_GET['l']); ?>&l=10"
	}
</script>
</head>
<body onload="redirectUrl()">
</body>
</html>