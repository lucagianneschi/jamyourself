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
require_once BOXES_DIR . 'post.box.php';
require_once BOXES_DIR . 'relations.box.php';


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
echo '<br />-------------------------TEST  RELATION BOX -------------------------------------------<br />';
echo '<br />------------------------- TEST  RELATION BOX LDF-------------------------------------------<br />';
$relationsP = new RelationsBox();
$rel = $relationsP->init($LDF,'JAMMER');
print "<pre>";
print_r($rel);
print "</pre>";
echo '<br />-------------------------FINE TEST  RELATION BOX BOX LDF-------------------------------------------<br />';
echo '<br />-------------------------FINE TEST  RELATION BOX -------------------------------------------<br />';





echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />-------------------------TEST  POST BOX -------------------------------------------<br />';
echo '<br />------------------------- TEST POST BOX LDF-------------------------------------------<br />';
$recordPostP = new PostBox();
$recordPost = $recordPostP->init($LDF);
print "<pre>";
print_r($recordPost);
print "</pre>";
echo '<br />-------------------------FINE TEST POST BOX LDF-------------------------------------------<br />';
echo '<br />-------------------------FINE TEST POST BOX -------------------------------------------<br />';


echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />-------------------------TEST  RECORD BOX -------------------------------------------<br />';
echo '<br />------------------------- TEST RECORD BOX SPATAFORA-------------------------------------------<br />';
$recordBoxP = new RecordBox();
$recordBox = $recordBoxP->init('GuUAj83MGH');
print "<pre>";
print_r($recordBox);
print "</pre>";
echo '<br />-------------------------FINE TEST RECORD BOX SPATAFORA-------------------------------------------<br />';
echo '<br />-------------------------FINE TEST RECORD BOX -------------------------------------------<br />';

echo '<br />-------------------------TEST EVENT BOX-------------------------------------------<br />';
echo '<br /TEST EVENT BOX JAMMER<br />';
echo '<br />TEST EVENT BOX HDgcsTLpEx<br />';
$eventBoxP = new EventBox();
$eventBox = $eventBoxP->init('HDgcsTLpEx');
print "<pre>";
print_r($eventBox); //
print "</pre>";
echo '<br />TEST EVENT BOX HDgcsTLpEx<br />';


echo '<br />------------------------- TEST INFO BOX-------------------------------------------<br />';
echo '<br />TEST INFO BOX SPOTTER<br />';
echo '<br />TEST INFO BOX OBJ MARI<br />';
$info1BoxP = new InfoBox();
$info1 = $info1BoxP->init($mari);
print "<pre>";
print_r($info1);
print "</pre>";
echo '<br />TEST INFO BOX OBJ MARI<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST INFO BOX OBJ FLAVYCAP<br />';
$info1BoxP = new InfoBox();
$info1 = $info1BoxP->init($FLAVYCAP);
print "<pre>";
print_r($info1);
print "</pre>";
echo '<br />TEST INFO BOX OBJ FLAVYCAP<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST INFO BOX OBJ MARI<br />';
echo '<br />TEST INFO BOX Kessingtong<br />';
$info1BoxP = new InfoBox();
$info1 = $info1BoxP->init($Kessingtong);
print "<pre>";
print_r($info1);
print "</pre>";
echo '<br />TEST INFO BOX Kessingtong<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST INFO BOX JAMMER<br />';
echo '<br />TEST INFO BOX ROSESINBLOOM<br />';
$info1BoxP = new InfoBox();
$info1 = $info1BoxP->init($ROSESINBLOOM);
print "<pre>";
print_r($info1);
print "</pre>";
echo '<br />TEST INFO BOX ROSESINBLOOM<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST INFO Stanis<br />';
$info1BoxP = new InfoBox();
$info1 = $info1BoxP->init($Stanis);
print "<pre>";
print_r($info1);
print "</pre>";
echo '<br />TEST INFO Stanis<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST INFO BOX OBJ LDF<br />';
$info1BoxP = new InfoBox();
$info1 = $info1BoxP->init($LDF);
print "<pre>";
print_r($info1);
print "</pre>";
echo '<br />TEST INFO BOX OBJ LDF<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST INFO BOX VENUE<br />';
echo '<br />TEST INFO BOX ZonaPlayed<br />';
$info1BoxP = new InfoBox();
$info1 = $info1BoxP->init($ZonaPlayed);
print "<pre>";
print_r($info1);
print "</pre>";
echo '<br />TEST INFO BOX ZonaPlayed<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST INFO BOX Ultrasuono<br />';
$info1BoxP = new InfoBox();
$info1 = $info1BoxP->init($Ultrasuono);
print "<pre>";
print_r($info1);
print "</pre>";
echo '<br />TEST INFO BOX Ultrasuono<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST INFO BOX Jump<br />';
$info1BoxP = new InfoBox();
$info1 = $info1BoxP->init($jump);
print "<pre>";
print_r($info1);
print "</pre>";
echo '<br />TEST INFO BOX Jump<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />------------------------- FINE TEST INFO BOX-------------------------------------------<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />-------------------------TEST ALBUM BOX-------------------------------------------<br />';
echo '<br />TEST ALBUM BOX SPOTTER<br />';
echo '<br />TEST ALBUM BOX MARI<br />';
$albumBoxP = new AlbumBox();
$albumBox = $albumBoxP->init($mari);
print "<pre>";
print_r($albumBox);
print "</pre>";
echo '<br />TEST ALBUM BOX MARI<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST ALBUM BOX FLAVYCAP<br />';
$albumBoxP = new AlbumBox();
$albumBox = $albumBoxP->init($FLAVYCAP);
print "<pre>";
print_r($albumBox);
print "</pre>";
echo '<br />TEST ALBUM BOX FLAVYCAP<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST ALBUM BOX Kessingtong<br />';
$albumBoxP = new AlbumBox();
$albumBox = $albumBoxP->init($Kessingtong);
print "<pre>";
print_r($albumBox);
print "</pre>";
echo '<br />TEST ALBUM BOX Kessingtong<br />';
echo '<br />FINE TEST ALBUM BOX SPOTTER<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST ALBUM BOX JAMMER<br />';
echo '<br />TEST ALBUM BOX ROSESINBLOOM<br />';
$albumBoxP = new AlbumBox();
$albumBox = $albumBoxP->init($ROSESINBLOOM);
print "<pre>";
print_r($albumBox);
print "</pre>";
echo '<br />TEST ALBUM BOX ROSESINBLOOM<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST ALBUM BOX STANIS<br />';
$albumBoxP = new AlbumBox();
$albumBox = $albumBoxP->init($Stanis);
print "<pre>";
print_r($albumBox);
print "</pre>";
echo '<br />TEST ALBUM BOX STANIS<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST ALBUM BOX LDF<br />';
$albumBoxP = new AlbumBox();
$albumBox = $albumBoxP->init($LDF);
print "<pre>";
print_r($albumBox);
print "</pre>";
echo '<br />TEST ALBUM BOX LDF<br />';
echo '<br /FINE TEST ALBUM BOX JAMMER<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br /TEST ALBUM BOX VENUE<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST ALBUM BOX ZonaPlayed<br />';
$albumBoxP = new AlbumBox();
$albumBox = $albumBoxP->init($ZonaPlayed);
print "<pre>";
print_r($albumBox);
print "</pre>";
echo '<br />TEST ALBUM BOX ZonaPlayed<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST ALBUM BOX Ultrasuono<br />';
$albumBoxP = new AlbumBox();
$albumBox = $albumBoxP->init($Ultrasuono);
print "<pre>";
print_r($albumBox);
print "</pre>";
echo '<br />TEST ALBUM BOX Ultrasuono<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />TEST ALBUM BOX Jump<br />';
$albumBoxP = new AlbumBox();
$albumBox = $albumBoxP->init($jump);
print "<pre>";
print_r($albumBox);
print "</pre>";
echo '<br />TEST ALBUM BOX Jump<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br /FINE TEST ALBUM BOX VENUE<br />';
echo '<br />-------------------------FINE TEST ALBUM BOX-------------------------------------------<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
echo '<br />-------------------------------------------------------------------------------------------<br />';
/*
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
 * *
 */
?>
