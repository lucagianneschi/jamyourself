<?php
if (!defined('ROOT_DIR'))
	define('ROOT_DIR', '../../');

ini_set('display_errors', '1');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';

// TODO - cambiare il tipo a piacimento per eseguire i test
$tipo = 'SPOTTER';
try {
	if ($tipo == 'VENUE') {
		$user = new User('VENUE');
	} elseif ($tipo == 'JAMMER') {
		$user = new User('JAMMER');
	} elseif ($tipo == 'SPOTTER') {
		$user = new User('SPOTTER');
	}
} catch (Exception $e){
	die($e->getMessage());
}

$user->setObjectId();
$r = rand();
$userEpass = 'test' . $r;
$user->setUsername($userEpass);
$user->setPassword($userEpass);
//$user->setAuthData();
//$user->setEmailVerified();
$user->setActive(true);
//$user->setAlbums();
$user->setBackground('Un background');
$user->setBirthDay('1982-02-18');
$user->setCity('Una citta');
$user->setCollaborationCounter(666);
$user->setComments(array("nJr1ulgfVo"));
$user->setCountry('Un paese');
$user->setDescription('Una descrizione');
$user->setEmail('test'. $r .'@xxx.xx');
$user->setFbPage('Una pagina FB');
$user->setFollowersCounter(666);
$user->setFollowingCounter(666);
$user->setFriendshipCounter(666);
$parseGeoPoint = new parseGeoPoint(12.34, 56.78);
$user->setGeoCoding($parseGeoPoint);
//$user->setImages();
$user->setLevel(1);
$user->setLevelValue(2);
//$user->setLoveSongs();
$user->setMusic(array('music1', 'music2'));
//$user->setPlaylists();
$user->setPremium(true);
$dateTime = new DateTime();
$dateTime->add(new DateInterval('P1D'));
$user->setPremiumExpirationDate($dateTime);
$user->setProfilePicture('Una immagine di profilo');
//$user->setProfilePictureFile();
$user->setProfileThumbnail('Una micro immagine di profilo');
//$user->setSessionToken();
$user->setSettings(array('setting1', 'setting2'));
//$user->setStatuses();
$user->setTwitterPage('Una pagina twitter');
//$user->setVideos();
$user->setWebsite('Un sito web');
$user->setYoutubeChannel('Un canale youtube');
//$user->setCreatedAt();
//$user->setUpdatedAt();
$parseACL = new parseACL();
$parseACL->setPublicReadAccess(true);
// TODO - la chiamata setPublicWriteAccess(true) non sembra funzionare
//$acl->setPublicWriteAccess(true);
$user->setACL($parseACL);

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />STAMPO LO User APPENA CREATO<br />';
echo $user;

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL SALVATAGGIO DELLO User APPENA CREATO<br />';

$userParse = new UserParse();
$resSave = $userParse->saveUser($user);
if (get_class($resSave) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resSave->getErrorMessage() . '<br/>';
} else {
	echo '<br />User SAVED:<br />' . $resSave . '<br />';
}

echo '<br />FINITO IL SALVATAGGIO DELLO User APPENA CREATO<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL RECUPERO DI UNO User<br /><br />';

$userParse = new UserParse();
$resGet = $userParse->getUser($resSave->getObjectId());
if (get_class($resGet) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGet->getErrorMessage() . '<br/>';
} else {
	echo $resGet;
}

echo '<br />FINITO IL RECUPERO DI UNO User<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO LA CANCELLAZIONE DI UNO User<br />';

$userParse = new UserParse();
$resDelete = $userParse->deleteUser($resSave->getObjectId());
if (get_class($resDelete)) {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resDelete->getErrorMessage() . '<br/>';
} else {
	echo '<br />User DELETED<br />';
}

echo '<br />FINITO LA CANCELLAZIONE DI UNO User<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL RECUPERO DI PIU\' User<br />';

$userParse = new UserParse();
$userParse->whereExists('objectId');
$userParse->orderByDescending('createdAt');
$userParse->setLimit(5);
$resGets = $userParse->getUsers();
if (get_class($resGets) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGets->getErrorMessage() . '<br/>';
} else {
	foreach($resGets as $user) {
		echo '<br />' . $user->getObjectId() . '<br />';
	}
}

echo '<br />FINITO IL RECUPERO DI PIU\' User<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO L\'AGGIORNAMENTO DI UNO User<br />';

$userParse = new UserParse();
$user = $userParse->getUser($resSave->getObjectId());
$user->setLevel(99);
$resUpdate = $userParse->saveUser($user);
if (get_class($resUpdate)) {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resUpdate->getErrorMessage() . '<br/>';
} else {
	echo '<br />User UPDATED<br />';
}

echo '<br />FINITO L\'AGGIORNAMENTO DI UNO User<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL LOGIN DI UNO User<br />';

$userParse = new UserParse();
$username = $userEpass;
$password = $userEpass;
$resLogin = $userParse->loginUser($username, $password);
if (get_class($resLogin) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resLogin->getErrorMessage() . '<br/>';
} else {
	echo '<br />User LOGGED<br />';
}

echo '<br />FINITO IL LOGIN DI UNO User<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO L\'AGGIORNAMENTO DEI SINGOLI CAMPI DELLO User<br />';

$userParse = new UserParse();

$userParse->updateField($resSave->getObjectId(), $resSave->getSessionToken(), 'active', true);
echo 'Aggiornato un campo boolean<br />';
$userParse->updateField($resSave->getObjectId(), $resSave->getSessionToken(), 'address', 'Un indirizzo');
echo 'Aggiornato un campo string<br />';
$userParse->updateField($resSave->getObjectId(), $resSave->getSessionToken(), 'level', 101);
echo 'Aggiornato un campo number<br />';
$userParse->updateField($resSave->getObjectId(), $resSave->getSessionToken(), 'settings', array('set1', 'set2'));
echo 'Aggiornato un campo array<br />';

//$userParse->updateField($resSave->getObjectId(), 'image', toParsePointer('Image', 'MuTAFCZIKd'));
//echo 'Aggiornato un campo Pointer<br />';

$parseGeoPoint = new parseGeoPoint('56.78', '12.34');
$userParse->updateField($resSave->getObjectId(), $resSave->getSessionToken(), 'geoCoding', toParseGeoPoint($parseGeoPoint));
echo 'Aggiornato un campo GeoPoint<br />';

$parseACL = new parseACL();
$parseACL->setPublicWriteAccess(false);
$userParse->updateField($resSave->getObjectId(), $resSave->getSessionToken(), 'ACL', toParseACL($parseACL));
echo 'Aggiornato un campo ACL<br />';

$userParse->updateField($resSave->getObjectId(), $resSave->getSessionToken(), 'collaboration', array('n1TXVlIqHw', 'WeTEWWfASn'), true, 'add', '_User');
echo 'Aggiornato (add) un campo Relation<br />';

$userParse->updateField($resSave->getObjectId(), $resSave->getSessionToken(), 'collaboration', array('WeTEWWfASn'), true, 'remove', '_User');
echo 'Aggiornato (remove) un campo Relation<br />';

$userParse->updateField($resSave->getObjectId(), $resSave->getSessionToken(), 'followers', array('n1TXVlIqHw', 'WeTEWWfASn'), true, 'add', '_User');
echo 'Aggiornato (add) un campo Relation<br />';

$userParse->updateField($resSave->getObjectId(), $resSave->getSessionToken(), 'followers', array('WeTEWWfASn'), true, 'remove', '_User');
echo 'Aggiornato (remove) un campo Relation<br />';

$userParse->updateField($resSave->getObjectId(), $resSave->getSessionToken(), 'following', array('n1TXVlIqHw', 'WeTEWWfASn'), true, 'add', '_User');
echo 'Aggiornato (add) un campo Relation<br />';

$userParse->updateField($resSave->getObjectId(), $resSave->getSessionToken(), 'following', array('WeTEWWfASn'), true, 'remove', '_User');
echo 'Aggiornato (remove) un campo Relation<br />';

echo '<br />FINITO L\'AGGIORNAMENTO DEI SINGOLI CAMPI DEL Comment<br />';

echo '<br />-------------------------------------------------------------------------------<br />';
?>