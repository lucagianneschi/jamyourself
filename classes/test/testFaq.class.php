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
ini_set('display_errors', '1');

require_once $_SERVER['DOCUMENT_ROOT'] . '/script/wp_daniele/root/config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'faq.class.php';
require_once CLASSES_DIR . 'faqParse.class.php';

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

echo 'INIZIO IL SALVATAGGIO DELLa faq APPENA CREATO<br />';
$faqParse = new FaqParse();
if (get_class($faqParse->saveFaq($faq))) {
	echo 'ATTENZIONE: e\' stata generata un\'eccezione: ' . $faqParse->saveFaq($faq)->getErrorMessage() . '<br/>';
}
echo 'FINITO IL SALVATAGGIO DEL faq APPENA CREATO<br />';

echo '<br />-------------------------------------------------------------------------------<br />';
?>