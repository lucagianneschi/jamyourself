<?php
/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 *
 * \par			Info Classe:
 * \brief		Classe di test
 * \details		Classe di test per la classe Faq
 *
 * \par			Commenti:
 * \warning
 * \bug
 * \todo
 *
 */

if (!defined('ROOT_DIR'))
	define('ROOT_DIR', '../../');
	
ini_set('display_errors', '1');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'faq.class.php';
require_once CLASSES_DIR . 'faqParse.class.php';

$faq = new Faq();
$faq->setAnswer('Questa è una answer');
$faq->setArea('Area di interesse della Faq');
$faq->setLang('it');
$faq->setPosition('posizione 10');
$faq->setQuestion('Questa è una question');
$faq->setTags(array('tag1', 'tag2'));
//$faq->setACL();

echo 'STAMPO LA FAQ APPENA CREATA <br>';
echo $faq;

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL SALVATAGGIO DELLA FAQ APPENA CREATA<br />';

$faqParse = new FaqParse();
$resSave = $faqParse->saveFaq($faq);
if (get_class($resSave) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resSave->getErrorMessage() . '<br/>';
} else {
	echo '<br />Faq SAVED:<br />' . $resSave . '<br />';
}

echo '<br />FINITO IL SALVATAGGIO DEL COMMENTO APPENA CREATO<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL RECUPERO DI UNA FAQ<br /><br />';

$faqParse = new FaqParse();
$resGet = $faqParse->getFaq('qzArYWw1w5');
if (get_class($resGet) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGet->getErrorMessage() . '<br/>';
} else {
	echo $resGet;
}

echo '<br />FINITO IL RECUPERO DI UNA FAQ<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL RECUPERO DI PIU\' FAQ<br />';

$faqParse = new FaqParse();
$faqParse->whereExists('objectId');
$faqParse->orderByDescending('createdAt');
$faqParse->setLimit(5);
$resGets = $faqParse->getFaqs();
if (get_class($resGets) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGets->getErrorMessage() . '<br/>';
} else {
	foreach($resGets as $faq) {
		echo '<br />' . $faq->getObjectId() . '<br />';
	}
}

echo '<br />FINITO IL RECUPERO DI PIU\' FAQ<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO L\'AGGIORNAMENTO DI UNA FAQ<br />';

$faqParse = new FaqParse();
$faq = $faqParse->getFaq($resSave->getObjectId());
$faq->setQuestion('Sono una faq aggiornata');
$resUpdate = $faqParse->saveFaq($faq);
if (get_class($resUpdate)) {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resUpdate->getErrorMessage() . '<br/>';
} else {
	echo '<br />FAQ UPDATED<br />';
}

echo '<br />FINITO L\'AGGIORNAMENTO DI UN FAQ<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

?>