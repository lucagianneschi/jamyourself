<?php
if (!defined('ROOT_DIR'))
	define('ROOT_DIR', '../../');
	
ini_set('display_errors', '1');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';

// TODO - cambiare il tipo a piacimento per eseguire i test
$tipo = 'VENUE';
if ($tipo == 'VENUE') 
	$user = new Venue();
elseif ($tipo == 'JAMMER')
	$user = new Jammer();
elseif ($tipo == 'SPOTTER')
	$user = new Spotter();
	
$user->setObjectId();
$r = rand();
$user->setUsername('test' . $r);
$user->setPassword('test' . $r);
//$user->setAuthData();
//$user->setEmailVerified();
$user->setActive(true);
//$user->setAlbums();
$user->setBackground('Un background');
$user->setCity('Una citta');
$user->setComments(array("nJr1ulgfVo"));
$user->setCountry('Un paese');
$user->setDescription('Una descrizione');
$user->setEmail('test'. $r .'@xxx.xx');
$user->setFbPage('Una pagina FB');
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
$user->setType('VENUE');
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

echo '<br />STAMPO LO USER APPENA CREATO<br />';
echo $user;

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL SALVATAGGIO DELLO USER APPENA CREATO<br />';

$userParse = new UserParse();
$resSave = $userParse->saveUser($user);
if (get_class($resSave) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resSave->getErrorMessage() . '<br/>';
} else {
	echo '<br />User SAVED:<br />' . $resSave . '<br />';
}

echo '<br />FINITO IL SALVATAGGIO DELLO USER APPENA CREATO<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL RECUPERO DI UNO User<br /><br />';

$userParse = new UserParse();
$resGet = $userParse->getUser('GuUAj83MGH');
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
$username = 'test1193803186';
$password = 'test1193803186';
$resLogin = $userParse->loginUser($username, $password);
if (get_class($resLogin)) {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resLogin->getErrorMessage() . '<br/>';
} else {
	echo '<br />User LOGGED<br />';
}

echo '<br />FINITO IL LOGIN DI UNO User<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

?>