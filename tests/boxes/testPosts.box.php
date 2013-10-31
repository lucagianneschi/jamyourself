<?php
/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box Post
 * \details		Recupera gli ultimi 3 post attivi (valido per ogni tipologia di utente)
 * \par			Commenti:
 * \warning
 * \bug
 * \todo        utilizzare le variabili di sessione e non fare la get dello user
 *
 */
$t_start = microtime(); //timer tempo totale
$i_start = microtime(); //timer include

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

ini_set('display_errors', '1');
require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once BOXES_DIR . 'post.box.php';
$i_end = microtime();

//SPOTTER
$karl01 = '7wi6AvviK4'; //karl01
$LDF = '7fes1RyY77'; //LDF 
$Ultrasuono = 'iovioSH5mq'; //Ultrasuono 

$limit = 5;
$skip = 2;
echo '<br />------------------------- TEST POST BOX LDF-------------------------------------------<br />';
$post1_start = microtime(); 
$postP = new PostBox();
$post = $postP->initForPersonalPage($LDF, $limit, $skip);
print "<pre>";
print_r($post);
print "</pre>";
$post1_stop = microtime();
echo '<br />-------------------------FINE TEST POST BOX LDF-------------------------------------------<br />';
echo '<br />------------------------- TEST POST BOX Ultrasuono-------------------------------------------<br />';
$post2_start = microtime();
$postP2 = new PostBox();
$post2 = $postP2->initForPersonalPage($Ultrasuono, $limit, $skip);
print "<pre>";
print_r($post2);
print "</pre>";
$post2_stop = microtime();
echo '<br />-------------------------FINE TEST POST BOX Ultrasuono-------------------------------------------<br />';
echo '<br />------------------------- TEST POST BOX Karl01-------------------------------------------<br />';
$post3_start = microtime();
$postP3 = new PostBox();
$post3 = $postP3->initForPersonalPage($Karl01, $limit, $skip);
print "<pre>";
print_r($post3);
print "</pre>";
$post3_stop = microtime();
echo '<br />-------------------------FINE TEST POST BOX Karl01-------------------------------------------<br />';
echo '<br />------------------------- TEST POST BOX ERRORE-------------------------------------------<br />';
$post4_start = microtime();
$postP4 = new PostBox();
$post4 = $postP4->initForPersonalPage('$Karl01', $limit, $skip);
print "<pre>";
print_r($post4);
print "</pre>";
$post4_stop = microtime();
echo '<br />-------------------------FINE TEST POST BOX ERRORE-------------------------------------------<br />';
$t_end = microtime();
echo '<br />----------------------TIMERS---------------------------<br />';
echo 'Tempo include ' . executionTime($i_start, $i_end) . '<br />';
echo 'Tempo recupero ultimi 3 LDF JAMMER' . executionTime($post1_start, $post1_stop) . '<br />';
echo 'Tempo recupero ultimi 3 Ultrasuono VENUE ' . executionTime($post2_start, $post2_stop) . '<br />';
echo 'Tempo recupero ultimi 3 Karl01 SPOTTER ' . executionTime($post3_start, $post3_stop) . '<br />';
echo 'Tempo recupero ERRORE ' . executionTime($post4_start, $post4_stop) . '<br />';
echo 'Tempo totale ' . executionTime($t_start, $t_end) . '<br />';
echo '<br />----------------------TIMERS---------------------------<br />';
?>