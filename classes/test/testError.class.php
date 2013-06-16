<?php
/* ! \par Info Generali:
* \author Luca Gianneschi
* \version 1.0
* \date 2013
* \copyright Jamyourself.com 2013
*
* \par Info Classe:
* \brief Classe di test
* \details Classe di test per la classe Error
*
* \par Commenti:
* \warning
* \bug
* \todo modificare require_once
*
*/
if (!defined('ROOT_DIR'))
	define('ROOT_DIR', '../../');
	
ini_set('display_errors', '1');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'comment.class.php';
require_once CLASSES_DIR . 'commentParse.class.php';

$error = new Error();
$error->setObjectId('aAbBcCdD');
$error->setErrorClass('Classe che genera errore');
$error->setErrorCode(999);
$error->setErrorFunction('funzione che ha generato errore');
$error->setErrorFunctionParameter(array('parameter1', 'parameter2'));
$dateTime = new DateTime();
$error->setCreatedAt($dateTime);
$error->setUpdatedAt($dateTime);
$acl = new parseACL();
$acl->setPublicReadAccess(true);
$acl->setPublicWriteAccess(true);
$error->setACL($acl);

echo 'STAMPO LA error APPENA CREATO  <br>';
echo $error;

echo '<br />-------------------------------------------------------------------------------<br />';

echo 'INIZIO IL SALVATAGGIO DELLa error APPENA CREATO<br />';
$errorParse = new ErrorParse();
if (get_class($errorParse->saveError($error))) {
	echo 'ATTENZIONE: e\' stata generata un\'eccezione: ' . $errorParse->saveError($error)->getErrorMessage() . '<br/>';
}
echo 'FINITO IL SALVATAGGIO DEL error APPENA CREATO<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL RECUPERO DI UN ERROR<br /><br />';

$errorParse1 = new ErrorParse();
$resGet = $errorParse1->getError('OebQbNJgA3');
if (get_class($resGet) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGet->getErrorMessage() . '<br/>';
} else {
	echo $resGet;
}

echo '<br />FINITO IL RECUPERO DI UN ERROR <br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL RECUPERO DI PIU\'  ERROR <br />';

$errorParse2 = new ErrorParse();
$errorParse2->whereExists('objectId');
$errorParse2->orderByDescending('createdAt');
$errorParse2->setLimit(5);
$resGets = $errorParse2->getErrors();
if (get_class($resGets) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGets->getErrorMessage() . '<br/>';
} else {
	foreach($resGets as $cmt) {
		echo '<br />' . $cmt->getObjectId() . '<br />';
	}
}

echo '<br />FINITO IL RECUPERO DI PIU\' ERROR <br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO L\'AGGIORNAMENTO DI UN ERROR <br />';

$errorParse3 = new ErrorParse();;
$error1 = new Comment();
$error1->setObjectId('5WXsSzgdEl');
$error1->setErrorCOde(99999);
$resUpdate = $errorParse3->saveError($error1);
if (get_class($resUpdate)) {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resUpdate->getErrorMessage() . '<br/>';
} else {
	echo '<br />Comment UPDATED<br />';
}

echo '<br />FINITO L\'AGGIORNAMENTO DI UN  ERROR <br />';

echo '<br />-------------------------------------------------------------------------------<br />';

?>