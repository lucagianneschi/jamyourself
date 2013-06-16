<?php
/* ! \par Info Generali:
* \author Luca Gianneschi
* \version 1.0
* \date 2013
* \copyright Jamyourself.com 2013
*
* \par Info Classe:
* \brief Classe di test
* \details Classe di test per la classe Faq
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

$faq = new Faq();
$faq->setObjectId('aAbBcCdD');
$faq->setAnswer('Questa è una answer');
$faq->setArea('Area di interesse della Faq');
$faq->setPosition('posizione 10');
$faq->setQuestion('Questa è una question');
$faq->setTags(array('tag1', 'tag2'));
$dateTime = new DateTime();
$faq->setCreatedAt($dateTime);
$faq->setUpdatedAt($dateTime);
$acl = new parseACL();
$acl->setPublicReadAccess(true);
$acl->setPublicWriteAccess(true);
$faq->setACL($acl);

echo 'STAMPO LA faq APPENA CREATO  <br>';
echo $faq;

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL SALVATAGGIO DEL FAQ APPENA CREATO<br />';

$faqParse = new FaqParse();
$resSave = $faqParse->saveFaq($faq);
if (get_class($resSave)) {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resSave->getErrorMessage() . '<br/>';
} else {
	echo '<br />Comment SAVED con objectId => ' . $resSave . '<br />';
}

echo '<br />FINITO IL SALVATAGGIO DEL COMMENTO APPENA CREATO<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL RECUPERO DI UN FAQ<br /><br />';

$faqParse1 = new FaqParse();
$resGet = $faqParse1->getComment('L82oBCwOLN');
if (get_class($resGet) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGet->getErrorMessage() . '<br/>';
} else {
	echo $resGet;
}

echo '<br />FINITO IL RECUPERO DI UN FAQ<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL RECUPERO DI PIU\' FAQ<br />';

$faqParse2 = new FaqParse();
$faqParse2->whereExists('objectId');
$faqParse2->orderByDescending('createdAt');
$faqParse2->setLimit(5);
$resGets = $faqParse2->getComments();
if (get_class($resGets) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGets->getErrorMessage() . '<br/>';
} else {
	foreach($resGets as $cmt) {
		echo '<br />' . $cmt->getObjectId() . '<br />';
	}
}

echo '<br />INIZIO IL RECUPERO DI PIU\' FAQ<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO L\'AGGIORNAMENTO DI UN FAQ<br />';

$faqParse3 = new FaqParse();
$faq1 = new Faq();
$faq1->setObjectId('AOPyno3s8m');
$faq1->setQuestion('Sono una fa aggiornata');
$resUpdate = $faqParse3->savefaq($faq1);
if (get_class($resUpdate)) {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resUpdate->getErrorMessage() . '<br/>';
} else {
	echo '<br />FAQ UPDATED<br />';
}

echo '<br />FINITO L\'AGGIORNAMENTO DI UN FAQ<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

?>