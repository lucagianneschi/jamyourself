<?php
/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box Relations
 * \details		Recupera le ultime relazioni per tipologia di utente
 * \par			Commenti:
 * \warning
 * \bug
 * \todo        
 *
 */
$t_start = microtime(); //timer tempo totale
$i_start = microtime(); //timer include

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

ini_set('display_errors', '1');
require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once BOXES_DIR . 'relations.box.php';
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


echo '<br />-------------------------SPOTTER---------------- ------------------------------------------<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />-------------------------TEST  RELATION BOX -----------------------------------------------<br />';
echo '<br />------------------------- TEST  RELATION BOX mari------------------------------------------<br />';
$rel1_start = microtime();
$relationsP = new RelationsBox();
$rel = $relationsP->init($mari,'SPOTTER');
print "<pre>";
print_r($rel);
print "</pre>";
$rel1_stop = microtime();
echo '<br />-------------------------FINE TEST  RELATION BOX  mari-------------------------------------<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />-------------------------TEST  RELATION BOX -----------------------------------------------<br />';
echo '<br />------------------------- TEST  RELATION BOX FLAVYCAP--------------------------------------<br />';
$rel2_start = microtime();
$relationsP = new RelationsBox();
$rel = $relationsP->init($FLAVYCAP,'SPOTTER');
print "<pre>";
print_r($rel);
print "</pre>";
$rel2_stop = microtime();
echo '<br />-------------------------FINE TEST  RELATION BOX  FLAVYCAP---------------------------------<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />-------------------------TEST  RELATION BOX -----------------------------------------------<br />';
echo '<br />------------------------- TEST  RELATION BOX Kessingtong-----------------------------------<br />';
$rel3_start = microtime();
$relationsP = new RelationsBox();
$rel = $relationsP->init($Kessingtong,'SPOTTER');
print "<pre>";
print_r($rel);
print "</pre>";
$rel3_stop = microtime();
echo '<br />-------------------------FINE TEST  RELATION BOX  Kessingtong------------------------------<br />';
echo '<br />-------------------------JAMMER---------------- -------------------------------------------<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />-------------------------TEST  RELATION BOX -----------------------------------------------<br />';
echo '<br />------------------------- TEST  RELATION BOX ROSESINBLOOM----------------------------------<br />';
$rel4_start = microtime();
$relationsP = new RelationsBox();
$rel = $relationsP->init($ROSESINBLOOM,'JAMMER');
print "<pre>";
print_r($rel);
print "</pre>";
$rel4_stop = microtime();
echo '<br />-------------------------FINE TEST  RELATION BOX  ROSESINBLOOM-----------------------------<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />-------------------------TEST  RELATION BOX -----------------------------------------------<br />';
echo '<br />------------------------- TEST  RELATION BOX Stanis----------------------------------------<br />';
$rel5_start = microtime();
$relationsP = new RelationsBox();
$rel = $relationsP->init($Stanis,'JAMMER');
print "<pre>";
print_r($rel);
print "</pre>";
$rel5_stop = microtime();
echo '<br />-------------------------FINE TEST  RELATION BOX BOX Stanis--------------------------------<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />------------------------- TEST  RELATION BOX LDF-------------------------------------------<br />';
$rel6_start = microtime();
$relationsP = new RelationsBox();
$rel = $relationsP->init($LDF,'JAMMER');
print "<pre>";
print_r($rel);
print "</pre>";
$rel6_stop = microtime();
echo '<br />-------------------------FINE TEST  RELATION BOX BOX LDF------------------------------------<br />';
echo '<br />-------------------------FINE TEST  RELATION BOX -------------------------------------------<br />';
echo '<br />-------------------------VENUE---------------- ---------------------------------------------<br />';
echo '<br />--------------------------------------------------------------------------------------------<br />';
echo '<br />-------------------------TEST  RELATION BOX ------------------------------------------------<br />';
echo '<br />------------------------- TEST  RELATION BOX ZonaPlayed-------------------------------------<br />';
$rel7_start = microtime();
$relationsP = new RelationsBox();
$rel = $relationsP->init($ZonaPlayed,'VENUE');
print "<pre>";
print_r($rel);
print "</pre>";
$rel7_stop = microtime();
echo '<br />-------------------------FINE TEST  RELATION BOX  ZonaPlayed--------------------------------<br />';
echo '<br />--------------------------------------------------------------------------------------------<br />';
echo '<br />-------------------------TEST  RELATION BOX ------------------------------------------------<br />';
echo '<br />------------------------- TEST  RELATION BOX $Ultrasuono------------------------------------<br />';
$rel8_start = microtime();
$relationsP = new RelationsBox();
$rel = $relationsP->init($Ultrasuono,'VENUE');
print "<pre>";
print_r($rel);
print "</pre>";
$rel8_stop = microtime();
echo '<br />-------------------------FINE TEST  RELATION BOX  $Ultrasuono------------------------------<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />-------------------------TEST  RELATION BOX -----------------------------------------------<br />';
echo '<br />------------------------- TEST  RELATION BOX $jump-----------------------------------<br />';
$rel9_start = microtime();
$relationsP = new RelationsBox();
$rel = $relationsP->init($jump,'VENUE');
print "<pre>";
print_r($rel);
print "</pre>";
$rel9_stop = microtime();
echo '<br />-------------------------FINE TEST  RELATION BOX  $jump------------------------------<br />';
$t_end = microtime();
echo '<br />----------------------TIMERS----------------------------------------------------------------<br />';
echo 'Tempo include ' . executionTime($i_start, $i_end) . '<br />';
echo 'Tempo Relazione 1: ' . executionTime($rel1_start, $rel1_stop) . '<br />';
echo 'Tempo Relazione 2: ' . executionTime($rel2_start, $rel2_stop) . '<br />';
echo 'Tempo Relazione 3: ' . executionTime($rel3_start, $rel3_stop) . '<br />';
echo 'Tempo Relazione 4: ' . executionTime($rel4_start, $rel4_stop) . '<br />';
echo 'Tempo Relazione 5: ' . executionTime($rel5_start, $rel5_stop) . '<br />';
echo 'Tempo Relazione 6: ' . executionTime($rel6_start, $rel6_stop) . '<br />';
echo 'Tempo Relazione 7: ' . executionTime($rel7_start, $rel7_stop) . '<br />';
echo 'Tempo Relazione 8: ' . executionTime($rel8_start, $rel8_stop) . '<br />';
echo 'Tempo Relazione 9: ' . executionTime($rel9_start, $rel9_stop) . '<br />';
echo 'Tempo totale ' . executionTime($t_start, $t_end) . '<br />';
echo '<br />----------------------TIMERS----------------------------------------------------------------<br />';
?>