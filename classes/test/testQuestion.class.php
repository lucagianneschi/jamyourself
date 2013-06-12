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
ini_set('display_errors', '1');

require_once $_SERVER['DOCUMENT_ROOT'] . '/script/wp_daniele/root/config.php';
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
if (get_class($questionParse->saveQuestion($question))) {
	echo 'ATTENZIONE: e\' stata generata un\'eccezione: ' . $questionParse->saveQuestion($question)->getErrorMessage() . '<br/>';
}
echo 'FINITO IL SALVATAGGIO DEL question APPENA CREATO<br />';

echo '<br />-------------------------------------------------------------------------------<br />';
?>