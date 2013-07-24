<?php

/* ! \par	    Info Generali:
 * \author	    Daniele Caldelli
 * \version	    1.0
 * \date		    2013
 * \copyright	    Jamyourself.com 2013
 *
 * \par		    Info Classe:
 * \brief	    Classe di test
 * \details	    Classe di test per i box della pagina utente
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
require_once BOXES_DIR . 'info.box.php';
require_once BOXES_DIR . 'album.box.php';
require_once BOXES_DIR . 'event.box.php';
require_once BOXES_DIR . 'reviewRecords.box.php';
require_once BOXES_DIR . 'record.box.php';


//SPOTTER
$mari = '1oT7yYrpfZ';//MARI
$FLAVYCAP = 'oN7Pcp2lxf';//FLAVYCAP 
$Kessingtong = '2OgmANcYaT';//Kessingtong


//JAMMER
$ROSESINBLOOM = 'uMxy47jSjg';//ROSESINBLOOM
$Stanis = 'HdqSpIhiXo';//Stanis
$LDF = '7fes1RyY77'; //LDF

//Venue
$ZonaPlayed = '2K5Lv7qxzw';//ZonaPlayed  
$Ultrasuono = 'iovioSH5mq'; //Ultrasuono 
$jump = 'wrpgRuSgRA';//jump rock club

echo '<br />------------------------- TEST INFO BOX-------------------------------------------<br />';
echo '<br />TEST INFO BOX SPOTTER<br />';
echo '<br />TEST INFO BOX MARI<br />';
$infoBoxP = new infoBox();
$info = $infoBoxP->sendInfo($mari);
print "<pre>";
print_r($info);
print "</pre>";
echo '<br />TEST INFO BOX MARI<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST INFO BOX FLAVYCAP<br />';
$infoBoxP = new infoBox();
$info = $infoBoxP->sendInfo($FLAVYCAP);
print "<pre>";
print_r($info);
print "</pre>";
echo '<br />TEST INFO BOX FLAVYCAP<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST INFO BOX Kessingtong<br />';
$infoBoxP = new infoBox();
$info = $infoBoxP->sendInfo($Kessingtong);
print "<pre>";
print_r($info);
print "</pre>";
echo '<br />TEST INFO BOX Kessingtong<br />';
echo '<br />FINE TEST INFO BOX SPOTTER<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST INFO BOX VENUE<br />';
echo '<br />TEST INFO BOX ZonaPlayed<br />';
$infoBoxP = new infoBox();
$info = $infoBoxP->sendInfo($ZonaPlayed);
print "<pre>";
print_r($info);
print "</pre>";
echo '<br />TEST INFO BOX ZonaPlayed<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST INFO BOX Ultrasuono<br />';
$infoBoxP = new infoBox();
$info = $infoBoxP->sendInfo($Ultrasuono);
print "<pre>";
print_r($info);
print "</pre>";
echo '<br />TEST INFO BOX Ultrasuono<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST INFO BOX jump<br />';
$infoBoxP = new infoBox();
$info = $infoBoxP->sendInfo($jump);
print "<pre>";
print_r($info);
print "</pre>";
echo '<br />TEST INFO BOX jump<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />FINE TEST INFO BOX VENUE<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST INFO BOX JAMMER<br />';
echo '<br />TEST INFO BOX ROSESINBLOOM<br />';
$infoBoxP = new infoBox();
$info = $infoBoxP->sendInfo($ROSESINBLOOM);
print "<pre>";
print_r($info);
print "</pre>";
echo '<br />TEST INFO BOX ROSESINBLOOM<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST INFO BOX Stanis<br />';
$infoBoxP = new infoBox();
$info = $infoBoxP->sendInfo($Stanis);
print "<pre>";
print_r($info);
print "</pre>";
echo '<br />TEST INFO BOX Stanis<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST INFO BOX LDF<br />';
$infoBoxP = new infoBox();
$info = $infoBoxP->sendInfo($LDF);
print "<pre>";
print_r($info);
print "</pre>";
echo '<br />TEST INFO BOX LDF<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />FINE TEST INFO BOX JAMMER<br />';
echo '<br />-------------------------FINE TEST INFO BOX-------------------------------------------<br />';
echo '<br />-------------------------TEST ALBUM BOX-------------------------------------------<br />';
echo '<br />TEST ALBUM BOX SPOTTER<br />';
echo '<br />TEST ALBUM BOX MARI<br />';
$albumBoxP = new albumBox();
$albumBox = $albumBoxP->sendInfo($mari);
print "<pre>";
print_r($albumBox);
print "</pre>";
echo '<br />TEST ALBUM BOX MARI<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST ALBUM BOX FLAVYCAP<br />';
$albumBoxP = new albumBox();
$albumBox = $albumBoxP->sendInfo($FLAVYCAP);
print "<pre>";
print_r($albumBox);
print "</pre>";
echo '<br />TEST ALBUM BOX FLAVYCAP<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST ALBUM BOX Kessingtong<br />';
$albumBoxP = new albumBox();
$albumBox = $albumBoxP->sendInfo($Kessingtong);
print "<pre>";
print_r($albumBox);
print "</pre>";
echo '<br />TEST ALBUM BOX Kessingtong<br />';
echo '<br />FINE TEST ALBUM BOX SPOTTER<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST ALBUM BOX JAMMER<br />';
echo '<br />TEST ALBUM BOX ROSESINBLOOM<br />';
$albumBoxP = new albumBox();
$albumBox = $albumBoxP->sendInfo($ROSESINBLOOM);
print "<pre>";
print_r($albumBox);
print "</pre>";
echo '<br />TEST ALBUM BOX ROSESINBLOOM<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST ALBUM BOX STANIS<br />';
$albumBoxP = new albumBox();
$albumBox = $albumBoxP->sendInfo($Stanis);
print "<pre>";
print_r($albumBox);
print "</pre>";
echo '<br />TEST ALBUM BOX STANIS<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST ALBUM BOX LDF<br />';
$albumBoxP = new albumBox();
$albumBox = $albumBoxP->sendInfo($LDF);
print "<pre>";
print_r($albumBox);
print "</pre>";
echo '<br />TEST ALBUM BOX LDF<br />';
echo '<br /FINE TEST ALBUM BOX JAMMER<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br /TEST ALBUM BOX VENUE<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST ALBUM BOX ZonaPlayed<br />';
$albumBoxP = new albumBox();
$albumBox = $albumBoxP->sendInfo($ZonaPlayed);
print "<pre>";
print_r($albumBox);
print "</pre>";
echo '<br />TEST ALBUM BOX ZonaPlayed<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST ALBUM BOX Ultrasuono<br />';
$albumBoxP = new albumBox();
$albumBox = $albumBoxP->sendInfo($Ultrasuono);
print "<pre>";
print_r($albumBox);
print "</pre>";
echo '<br />TEST ALBUM BOX Ultrasuono<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST ALBUM BOX Jump<br />';
$albumBoxP = new albumBox();
$albumBox = $albumBoxP->sendInfo($jump);
print "<pre>";
print_r($albumBox);
print "</pre>";
echo '<br />TEST ALBUM BOX Jump<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br /FINE TEST ALBUM BOX VENUE<br />';
echo '<br />-------------------------FINE TEST ALBUM BOX-------------------------------------------<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />-------------------------TEST EVENT BOX-------------------------------------------<br />';
echo '<br /TEST EVENT BOX JAMMER<br />';
echo '<br />TEST EVENT BOX HDgcsTLpEx<br />';
$eventBoxP = new eventBox();
$eventBox = $eventBoxP->sendInfo('HDgcsTLpEx');
print "<pre>";
print_r($eventBox);//
print "</pre>";
echo '<br />TEST EVENT BOX HDgcsTLpEx<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br /FINE TEST EVENT BOX JAMMER<br />';
echo '<br />-------------------------FINE TEST ALBUM BOX-------------------------------------------<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />------------------------- TEST REVIEW RECORD BOX -------------------------------------------<br />';
echo '<br />------------------------- TEST REVIEW RECORD BOX SPATAFORA-------------------------------------------<br />';
$reviewBoxP = new reviewRecordsBox();
$reviewBox = $reviewBoxP->sendInfo('GuUAj83MGH');
print "<pre>";
print_r($reviewBox);
print "</pre>";
echo '<br />-------------------------FINE TEST REVIEW RECORD BOX SPATAFORA-------------------------------------------<br />';
echo '<br />------------------------- TEST REVIEW RECORD BOX LDF-------------------------------------------<br />';
$reviewBoxP = new reviewRecordsBox();
$reviewBox = $reviewBoxP->sendInfo($LDF);
print "<pre>";
print_r($reviewBox);
print "</pre>";
echo '<br />-------------------------FINE TEST REVIEW RECORD BOX LDF-------------------------------------------<br />';
echo '<br />-------------------------FINE TEST REVIEW RECORD BOX -------------------------------------------<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />-------------------------TEST  RECORD BOX -------------------------------------------<br />';

echo '<br />------------------------- TEST RECORD BOX SPATAFORA-------------------------------------------<br />';
$recordBoxP = new recordBox();
$recordBox = $recordBoxP->sendInfo('GuUAj83MGH');
print "<pre>";
print_r($recordBox);
print "</pre>";
echo '<br />-------------------------FINE TEST RECORD BOX SPATAFORA-------------------------------------------<br />';
echo '<br />-------------------------FINE TEST RECORD BOX -------------------------------------------<br />';
?>
