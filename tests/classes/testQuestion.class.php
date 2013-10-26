<?php

/* ! \par	    Info Generali:
 * \author	    Luca Gianneschi
 * \version	    1.0
 * \date		    2013
 * \copyright	    Jamyourself.com 2013
 *
 * \par		    Info Classe:
 * \brief	    Classe di test
 * \details	    Classe di test per la classe Question
 *
 * \par Commenti:
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
require_once CLASSES_DIR . 'question.class.php';
require_once CLASSES_DIR . 'questionParse.class.php';

$question = new Question();

$question->setAnswer('Questa è una answer');
$question->setMailFrom('Indirizzo di chi invia la Question');
$question->setMailTo('Indirizzo di riceve la Question');
$question->setName('nome di chi invia la mail');
$question->setReplied(false);
$question->setSubject('Oggetto della question');
$question->setText('Testo della question');
//$question->setACL();

echo 'STAMPO LA QUESTION APPENA CREATO  <br>';
echo $question;

echo '<br />-------------------------------------------------------------------------------<br />';

echo 'INIZIO IL SALVATAGGIO DELLA Question APPENA CREATA<br />';
$questionParse = new QuestionParse();
$resSave = $questionParse->saveQuestion($question);
if (get_class($resSave) == 'Error') {
    echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resSave->getErrorMessage() . '<br/>';
} else {
    echo '<br />Question SAVED:<br />' . $resSave . '<br />';
}

echo '<br />FINITO IL SALVATAGGIO DELLA Question APPENA CREATA<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL RECUPERO DI UNA Question<br /><br />';

$questionParse = new QuestionParse();
$resGet = $questionParse->getQuestion($resSave->getObjectId());
if (get_class($resGet) == 'Error') {
    echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGet->getErrorMessage() . '<br/>';
} else {
    echo $resGet;
}

echo '<br />FINITO IL RECUPERO DI UNA Question<br />';

echo '<br />-------------------------------------------------------------------------------<br />';

echo '<br />INIZIO IL RECUPERO DI PIU\' Question<br /><br />';

$questionParse = new QuestionParse();
$questionParse->whereExists('objectId');
$questionParse->orderByDescending('createdAt');
$questionParse->setLimit(5);
$resGets = $questionParse->getQuestions();
if (get_class($resGets) == 'Error') {
    echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $resGets->getErrorMessage() . '<br/>';
} else {
    foreach ($resGets as $question) {
        echo '<br />' . $question->getObjectId() . '<br />';
    }
}

echo '<br />FINITO IL RECUPERO DI PIU\' Question<br />';
echo '<br />-------------------------------------------------------------------------------<br />';
?>