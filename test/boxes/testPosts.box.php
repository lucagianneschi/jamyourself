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
$mari = '1oT7yYrpfZ'; //MARI
$FLAVYCAP = 'oN7Pcp2lxf'; //FLAVYCAP 
$Kessingtong = '2OgmANcYaT'; //Kessingtong
//JAMMER
$ROSESINBLOOM = 'uMxy47jSjg'; //ROSESINBLOOM
$Stanis = 'HdqSpIhiXo'; //Stanis
$LDF = '7fes1RyY77'; //LDF
//Venue
$ZonaPlayed = '2K5Lv7qxzw'; //ZonaPlayed  
$Ultrasuono = 'iovioSH5mq'; //Ultrasuono 
$jump = 'wrpgRuSgRA'; //jump rock club


echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />-------------------------TEST  POST BOX -------------------------------------------<br />';
echo '<br />-------------------------------SPOTTER-------------------------------------------<br />';
echo '<br />------------------------- TEST POST BOX mari-------------------------------------------<br />';
$post1_start = microtime(); 
$recordPostP = new PostBox();
$recordPost = $recordPostP->initForPersonalPage($mari);
print "<pre>";
print_r($recordPost);
print "</pre>";
$post1_stop = microtime();
echo '<br />-------------------------FINE TEST POST BOX mari-------------------------------------------<br />';
echo '<br />-------------------------FINE TEST POST BOX -------------------------------------------<br />';
echo '<br />------------------------- TEST POST BOX $FLAVYCAP-------------------------------------------<br />';
$post2_start = microtime(); 
$recordPostP = new PostBox();
$recordPost = $recordPostP->initForPersonalPage($FLAVYCAP);
print "<pre>";
print_r($recordPost);
print "</pre>";
$post2_stop = microtime();
echo '<br />-------------------------FINE TEST POST BOX $FLAVYCAP-------------------------------------------<br />';
echo '<br />------------------------- TEST POST BOX $Kessingtong-------------------------------------------<br />';
$post3_start = microtime(); 
$recordPostP = new PostBox();
$recordPost = $recordPostP->initForPersonalPage($LDF);
print "<pre>";
print_r($recordPost);
print "</pre>";
$post3_stop = microtime();
echo '<br />-------------------------FINE TEST POST BOX $Kessingtong-------------------------------------------<br />';
echo '<br />-------------------------------JAMMER-------------------------------------------<br />';
echo '<br />------------------------- TEST POST BOX ROSESINBLOOM-------------------------------------------<br />';
$post4_start = microtime(); 
$recordPostP = new PostBox();
$recordPost = $recordPostP->initForPersonalPage($ROSESINBLOOM);
print "<pre>";
print_r($recordPost);
print "</pre>";
$post4_stop = microtime();
echo '<br />-------------------------FINE TEST POST BOX ROSESINBLOOM-------------------------------------------<br />';
echo '<br />-------------------------FINE TEST POST BOX -------------------------------------------<br />';
echo '<br />------------------------- TEST POST BOX Stanis-------------------------------------------<br />';
$post5_start = microtime(); 
$recordPostP = new PostBox();
$recordPost = $recordPostP->initForPersonalPage($Stanis);
print "<pre>";
print_r($recordPost);
print "</pre>";
$post5_stop = microtime();
echo '<br />-------------------------FINE TEST POST BOX Stanis-------------------------------------------<br />';
echo '<br />------------------------- TEST POST BOX LDF-------------------------------------------<br />';
$post6_start = microtime(); 
$recordPostP = new PostBox();
$recordPost = $recordPostP->initForPersonalPage($LDF);
print "<pre>";
print_r($recordPost);
print "</pre>";
$post6_stop = microtime();
echo '<br />-------------------------FINE TEST POST BOX LDF-------------------------------------------<br />';
echo '<br />-------------------------FINE TEST POST BOX -------------------------------------------<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />-------------------------------VENUE-------------------------------------------<br />';
echo '<br />------------------------- TEST POST BOX ZonaPlayed-------------------------------------------<br />';
$post7_start = microtime(); 
$recordPostP = new PostBox();
$recordPost = $recordPostP->initForPersonalPage($ZonaPlayed);
print "<pre>";
print_r($recordPost);
print "</pre>";
$post7_stop = microtime();
echo '<br />-------------------------FINE TEST POST BOX ZonaPlayed-------------------------------------------<br />';
echo '<br />-------------------------FINE TEST POST BOX -------------------------------------------<br />';
echo '<br />------------------------- TEST POST BOX Ultrasuono-------------------------------------------<br />';
$post8_start = microtime();
$recordPostP = new PostBox();
$recordPost = $recordPostP->initForPersonalPage($Ultrasuono);
print "<pre>";
print_r($recordPost);
print "</pre>";
$post8_stop = microtime();
echo '<br />-------------------------FINE TEST POST BOX Ultrasuono-------------------------------------------<br />';
echo '<br />------------------------- TEST POST BOX JUMP-------------------------------------------<br />';
$post9_start = microtime();
$recordPostP = new PostBox();
$recordPost = $recordPostP->initForPersonalPage($jump);
print "<pre>";
print_r($recordPost);
print "</pre>";
echo '<br />-------------------------FINE TEST POST BOX JUMP-------------------------------------------<br />';
echo '<br />-------------------------FINE TEST POST BOX -------------------------------------------<br />';
$post_stop = microtime();
$t_end = microtime();
$post9_stop = microtime();
echo '<br />----------------------TIMERS---------------------------<br />';
echo 'Tempo include ' . executionTime($i_start, $i_end) . '<br />';
echo 'Tempo recupero ultimi 3 post ' . executionTime($post1_start, $post1_stop) . '<br />';
echo 'Tempo recupero ultimi 3 post ' . executionTime($post2_start, $post2_stop) . '<br />';
echo 'Tempo recupero ultimi 3 post ' . executionTime($post3_start, $post3_stop) . '<br />';
echo 'Tempo recupero ultimi 3 post ' . executionTime($post4_start, $post4_stop) . '<br />';
echo 'Tempo recupero ultimi 3 post ' . executionTime($post5_start, $post5_stop) . '<br />';
echo 'Tempo recupero ultimi 3 post ' . executionTime($post6_start, $post6_stop) . '<br />';
echo 'Tempo recupero ultimi 3 post ' . executionTime($post7_start, $post7_stop) . '<br />';
echo 'Tempo recupero ultimi 3 post ' . executionTime($post8_start, $post8_stop) . '<br />';
echo 'Tempo recupero ultimi 3 post ' . executionTime($post9_start, $post9_stop) . '<br />';
echo 'Tempo totale ' . executionTime($t_start, $t_end) . '<br />';
echo '<br />----------------------TIMERS---------------------------<br />';
?>