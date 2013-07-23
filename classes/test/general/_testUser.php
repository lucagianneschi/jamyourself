<?php
if (!defined('ROOT_DIR'))
	define('ROOT_DIR', '../../');

ini_set('display_errors', '1');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'utils.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'userParse.class.php';

$fp = fopen('debug.txt', 'w+');
$aCapo = '
';

$start = microtime();

function executionTime($start, $end) {
	echo 'executionTime->' . $start . '<br />';
	echo 'executionTime->' . $end . '<br />';
	$arrStart = explode(' ', $start);
	$arrEnd = explode(' ', $end);
	
	$secStart = $arrStart[1];
	$secEnd = $arrEnd[1];
	
	$msecStart = substr($arrStart[0], 2, 6);
	$msecEnd = substr($arrEnd[0], 2, 6);
	
	echo 'executionTime->' . $msecEnd . ', ' . $msecStart . '<br />';
	
	$time = ($secEnd - $secStart) . '.' . ($msecEnd - $msecStart);
	
	return $time;
}

$end = microtime();

echo microtime();

echo executionTime($start, $end);
/*
$totale['start'] = microtime();

$creazione['start'] = microtime();

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
$user->setUsername('test' . $r);
$user->setPassword('test' . $r);
//$user->setAuthData();
//$user->setEmailVerified();
$user->setActive(true);
//$user->setAlbums();
$user->setBackground('Un background');
$user->setBirthDay('1982-02-18');
$user->setCity('Una citta');
$user->setCollaboration(array('GuUAj83MGH', 'WeTEWWfASn'));
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

$creazione['end'] = microtime();
fwrite($fp, 'creazione -> ' . diff_sec($creazione) . $aCapo);
$save['start'] = microtime();

$userParse = new UserParse();
$resSave = $userParse->saveUser($user);

$save['end'] = microtime();
fwrite($fp, 'save -> ' . diff_sec($save) . $aCapo);
$get['start'] = microtime();

$userParse = new UserParse();
$resGet = $userParse->getUser('GuUAj83MGH');

$get['end'] = microtime();
fwrite($fp, 'get -> ' . diff_sec($get) . $aCapo);
$delete['start'] = microtime();

$userParse = new UserParse();
$resDelete = $userParse->deleteUser($resSave->getObjectId());

$delete['end'] = microtime();
fwrite($fp, 'delete -> ' . diff_sec($delete) . $aCapo);
$gets['start'] = microtime();

$userParse = new UserParse();
$userParse->whereExists('objectId');
$userParse->orderByDescending('createdAt');
$userParse->setLimit(5);
$resGets = $userParse->getUsers();

$gets['end'] = microtime();
fwrite($fp, 'gets -> ' . diff_sec($gets) . $aCapo);
$update['start'] = microtime();

$userParse = new UserParse();
$user = $userParse->getUser($resSave->getObjectId());
$user->setLevel(99);
$resUpdate = $userParse->saveUser($user);

$update['end'] = microtime();
fwrite($fp, 'update -> ' . diff_sec($update) . $aCapo);
$login['start'] = microtime();

$userParse = new UserParse();
$username = 'test1193803186';
$password = 'test1193803186';
$resLogin = $userParse->loginUser($username, $password);

$login['end'] = microtime();
fwrite($fp, 'login -> ' . diff_sec($login) . $aCapo);

echo 'Per controllare il risultato del debug: <a href="debug.txt">debug.txt</a>';

##############
# RELATION 1 #
##############
$userParse = new UserParse();
$relation['start'] = microtime();
$userParse->whereRelatedTo('collaboration', '_User', 'pr7rmTxo6w');
$userParse->setLimit(1);
$userParse->orderByAscending('createdAt');
$resRel1 = $userParse->getUsers();
$relation['end'] = microtime();
fwrite($fp, 'relation1 -> ' . diff_sec($relation) . $aCapo);
print_r($resRel1);

##############
# RELATION 2 #
##############
$parseQuery = new parseQuery('_User');
$whereRelatedTo['start'] = microtime();
$parseQuery->whereRelatedTo('collaboration', '_User', 'pr7rmTxo6w');
$parseQuery->setLimit(1);
$parseQuery->orderByAscending('createdAt');
$resRel2 = $parseQuery->find();
$whereRelatedTo['end'] = microtime();
fwrite($fp, 'relation2 -> ' . diff_sec($whereRelatedTo) . $aCapo);
print_r($resRel2);
			
$totale['end'] = microtime();
fwrite($fp, 'totale -> ' . diff_sec($totale) . $aCapo);
fclose($fp);

$parseQuery = new parseQuery('Comment');
print_r($parseQuery->where('commentators', $parseQuery->dataType("pointer", array('_User', 'n1TXVlIqHw'))));
*/

?>