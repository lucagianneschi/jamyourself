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
require_once CLASSES_DIR . 'error.class.php';
require_once CLASSES_DIR . 'errorParse.class.php';

$error = new Error();
$error->setErrorClass('Classe che ha generato errore');
$error->setErrorCode(999);
$error->setErrorFunction('Funzione che ha generato errore');
$error->setErrorFunctionParameter(array('parameter1', 'parameter2'));
$acl = new parseACL();
$acl->setPublicReadAccess(true);
$acl->setPublicWriteAccess(true);
$error->setACL($acl);

echo 'STAMPO LA Error APPENA CREATA  <br>';
echo $error;

echo '<br />-------------------------------------------------------------------------------<br />';

echo 'INIZIO IL SALVATAGGIO DELLA Error APPENA CREATA<br />';
$errorParse = new ErrorParse();
$resSave = $errorParse->saveError($error);
if (get_class($resSave) == 'Exception') {
	echo 'ATTENZIONE: e\' stata generata un\'eccezione: ' . $resSave->getMessage() . '<br />';
} else {
	echo '<br />Error SAVED:<br />' . $resSave . '<br />';
}

echo '<br />FINITO IL SALVATAGGIO DELLA Error APPENA CREATA<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL RECUPERO DI UN Error<br /><br />';

$errorParse = new ErrorParse();
$resGet = $errorParse->getError('lFgJYFTZyM');
if ( !method_exists($resSave, 'getObjectId') ) {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGet->getErrorMessage() . '<br/>';
} else {
	echo $resGet;
}

echo '<br />FINITO IL RECUPERO DI UN Error<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL RECUPERO DI PIU\' Error<br />';

$errorParse = new ErrorParse();
$errorParse->whereExists('objectId');
$errorParse->orderByDescending('createdAt');
$errorParse->setLimit(5);
$resGets = $errorParse->getErrors();
if (get_class($resGets)) {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGets->getErrorMessage() . '<br/>';
} else {
	foreach($resGets as $error) {
		echo '<br />' . $error->getObjectId() . '<br />';
	}
}

echo '<br />FINITO IL RECUPERO DI PIU\' Error<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO L\'AGGIORNAMENTO DI UN ERROR <br />';

$errorParse = new ErrorParse();
$error = $errorParse->getError($resSave->getObjectId());
$error->setErrorCode(99999);
$resUpdate = $errorParse->saveError($error);
if (get_class($resUpdate) == 'Exception') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resUpdate->getMessage() . '<br/>';
} else {
	echo '<br />Error UPDATED<br />';
}

echo '<br />FINITO L\'AGGIORNAMENTO DI UN  ERROR <br />';

echo '<br />-------------------------------------------------------------------------------<br />';

?>