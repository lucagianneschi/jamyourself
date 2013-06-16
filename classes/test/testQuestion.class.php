<?php
/* ! \par Info Generali:
* \author Luca Gianneschi
* \version 1.0
* \date 2013
* \copyright Jamyourself.com 2013
*
* \par Info Classe:
* \brief Classe di test
* \details Classe di test per la classe Question
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
require_once CLASSES_DIR . 'question.class.php';
require_once CLASSES_DIR . 'questionParse.class.php';

$question = new Question();
$question->setObjectId('aAbBcCdD');
$question->setAnswer('Questa è una answer');
$question->setMailFrom('indirizzo di chi invia la Question');
$question->setMailTo('indirizzo di riceve la Question');
$question->setName('nome di chi invia la mail');
$question->setReplied(false);
$question->setSubject('oggetto della question');
$question->setText('testo della question');
$dateTime = new DateTime();
$question->setCreatedAt($dateTime);
$question->setUpdatedAt($dateTime);
$acl = new parseACL();
$acl->setPublicReadAccess(true);
$acl->setPublicWriteAccess(true);
$question->setACL($acl);

echo 'STAMPO LA question APPENA CREATO  <br>';
echo $question;

echo '<br />-------------------------------------------------------------------------------<br />';

echo 'INIZIO IL SALVATAGGIO DELLa question APPENA CREATO<br />';
$questionParse = new QuestionParse();
$resSave = $questionParse->saveQuestion($question);
if (get_class($resSave) =='Error') {
    echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resSave->getErrorMessage() . '<br/>';
} else {
    echo 'FINITO IL SALVATAGGIO DEL question APPENA CREATO<br />';
}


echo '<br />-------------------------------------------------------------------------------<br />';
echo '<br />INIZIO IL RECUPERO DI UNA Question<br /><br />';

$questionParse1 = new QuestionParse();
$questionParse1->whereExists('objectId');
$questionParse1->orderByDescending('createdAt');
$questionParse1->setLimit(5);
$resGets = $questionParse1->getQuestions();
if (get_class($resGets) == 'Error') {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGets->getErrorMessage() . '<br/>';
} else {
	foreach($resGets as $question) {
		echo '<br />' . $question->getObjectId() . '<br />';
	}
}

echo '<br />FINITO IL RECUPERO DI PIU\' Question<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO L\'AGGIORNAMENTO DI UN Question <br />';

$questionParse2 = new QuestionParse();
$question1 = new Question();
$question1->setObjectId('IA63GZDVAK');
$question1->setAnswer('Ciao Pippo');
$question1->setQuestion('Sono una question modificata');
$resUpdate = $questionParse2->saveQuestion($question1);
if (get_class($resUpdate)) {
	echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resUpdate->getErrorMessage() . '<br/>';
} else {
	echo '<br />Question UPDATED<br />';
}
echo '<br />FINITO L\'AGGIORNAMENTO DI UN Question<br />';
echo '<br />-------------------------------------------------------------------------------<br />';
?>