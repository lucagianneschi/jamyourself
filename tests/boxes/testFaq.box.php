<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		File di caricamento FAQ
 * \details		Recupera le informazioni da mostrare nella pagina delle FAQ
 * \par			Commenti:
 * \warning
 * \bug
 *
 */

$t_start = microtime(); //timer tempo totale
$i_start = microtime(); //timer include

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

ini_set('display_errors', '1');
require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once BOXES_DIR . 'faq.box.php';
$i_end = microtime();

echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />-------------------------TEST FAQ BOX-------------------------------------------<br />';
$faqBoxP = new FaqBox();
$faqBox = $faqBoxP->initForFaqPage(5, 'it', 'createdAt', true);
print "<pre>";
print_r($faqBox);
print "</pre>";
echo '<br />TEST FAQ BOX <br />';
$faqBoxP1 = new FaqBox();
$faqBox1 = $faqBoxP1->initForFaqPage(5, 'it', 'createdAt', false);
print "<pre>";
print_r($faqBox1);
print "</pre>";
echo '<br />TEST FAQ BOX <br />';
$faqBoxP2 = new FaqBox();
$faqBox2 = $faqBoxP2->initForFaqPage(10, 'it', 'question', true);
print "<pre>";
print_r($faqBox2);
print "</pre>";
echo '<br />TEST FAQ BOX <br />';
$faqBoxP3 = new FaqBox();
$faqBox3 = $faqBoxP3->initForFaqPage(2, 'en', 'answer', true);
print "<pre>";
print_r($faqBox3);
print "</pre>";
echo '<br />TEST FAQ BOX <br />';
$faqBoxP4 = new FaqBox();
$faqBox4 = $faqBoxP4->initForFaqPage(1, 'it', 'createdAt', true);
print "<pre>";
print_r($faqBox4);
print "</pre>";
echo '<br />TEST FAQ BOX <br />';
$t_end = microtime();
echo '<br />----------------------TIMERS---------------------------<br />';
echo 'Tempo include ' . executionTime($i_start, $i_end) . '<br />';
echo 'Tempo totale ' . executionTime($t_start, $t_end) . '<br />';
echo '<br />----------------------TIMERS---------------------------<br />';
?>