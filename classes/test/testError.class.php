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
ini_set('display_errors', '1');

require_once $_SERVER['DOCUMENT_ROOT'] . '/script/wp_daniele/root/config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'error.class.php';
require_once CLASSES_DIR . 'errorParse.class.php';

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
?>