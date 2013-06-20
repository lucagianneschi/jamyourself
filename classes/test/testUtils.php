<?php

////////////////////////////////////////////////////////////////////////////////
//
//  Classe per verificare il corretto funzionamento delle Utils
//
////////////////////////////////////////////////////////////////////////////////

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

ini_set('display_errors', '1');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'utils.class.php';

////////////////////////////////////////////////////////////////////////////////
//
//    Script per le funzioni ausiliari nella gestione dei tipi di Parse
//    
//    =====>> NB: ciò che esce dalla FROM deve poter entrare nella TO <<=====
//
////////////////////////////////////////////////////////////////////////////////
if (!defined('ROOT_DIR'))
	define('ROOT_DIR', '../');
	
require_once ROOT_DIR . 'config.php';
require_once CLASSES_DIR . 'error.class.php';
require_once CLASSES_DIR . 'errorParse.class.php';


echo "Inizializzazione variabili:<br>";

echo "<br><br>************************************************************************";

$ACL = new parseACL();
$ACL->setPublicWriteAccess(true);
$ACL->setPublicWriteAccess(true);
$ACL->setReadAccessForId("n1TXVlIqHw",true);
$ACL->setWriteAccessForId("n1TXVlIqHw",true);


echo "<br><br>Var_dump ACL prima <br><br>";
echo var_dump($ACL);
echo "<br><br>Var_dump ACL dopo toParse<br><br>";
$a = toParseACL($ACL);
echo var_dump($a);
//echo "<br><br>Var_dump ACL dopo fromParse<br><br>";
//$a = fromParseACL($a); 
//echo var_dump($a);
echo "<br><br>************************************************************************";

$date = new DateTime();
echo "<br><br>Var_dump date prima<br><br>";
echo var_dump($date);
echo "<br><br>Var_dump date dopo toParse<br><br>";
$d = toParseDate($date);
echo var_dump($d);
//echo "<br><br>Var_dump date dopo fromParse<br><br>";
//$d = fromParseDate($d); 
//echo var_dump($d);
echo "<br><br>************************************************************************";

$geoPoint = new parseGeoPoint(36, 45);
echo "<br><br>Var_dump geopoint prima<br><br>";
echo var_dump($geoPoint);
echo "<br><br>Var_dump geopoint dopo toParse<br><br>";
$g = toParseGeoPoint($geoPoint);
echo var_dump($g);
//echo "<br><br>Var_dump geopoint dopo fromParse<br><br>";
//$g = fromParseGeoPoint($g); 
//echo var_dump($g);
echo "<br><br>************************************************************************<br>";

$albumid = "yfRrFv9ukW";

echo "<br><br>Var_dump pointer prima<br><br>";
echo var_dump($albumid);
echo "<br><br>Var_dump pointer dopo toParse<br><br>";
$p = toParsePointer("Album", $albumid);
echo var_dump($p);
//echo "<br><br>Var_dump geopoint dopo fromParse<br><br>";
//$g = fromParseGeoPoint($g); 
//echo var_dump($g);
echo "<br><br>************************************************************************<br>";

$albumsId = array("yfRrFv9ukW","6gH8DdFduP","0QO88Pn2fI");

echo "<br><br>Var_dump relation prima<br><br>";
echo var_dump($albumid);
echo "<br><br>Var_dump relation dopo toParse<br><br>";
$r = toParseRelation("Album", $albumsId);
echo var_dump($r);
//echo "<br><br>Var_dump geopoint dopo fromParse<br><br>";
//$g = fromParseGeoPoint($g); 
//echo var_dump($g);
echo "<br><br>************************************************************************<br>";
//

$test = new parseObject("Utils");
$test->dataCreazione = $d;
$test->ACL = $a;
$test->geopoint = $g;
$test->relazione = $r;
$test->puntatore = $p;
$test->descrizione = "Oggetto creato al primo giro";

echo "<br><br>Var_dump oggetto prima della save<br><br>";
echo var_dump($test);

echo "<br><br>Var_dump risposta della save<br><br>";

$ret = $test->save();
echo var_dump($ret);

echo "<br><br>************************************************************************<br>";

echo "<br><br>Var dump della get dell'oggetto recuperato con la get:<br><br>";

$ret = $test->get($ret->objectId);

echo var_dump($ret);

echo "<br><br>************************************************************************<br>";

echo "<br><br>Recupero i valori copn le FROM e salvo un nuovo oggetto con gli stessi valori recuperati
    automaticamente:<br><br>";

$restituito = new parseObject("Utils");
$restituito->dataCreazione = toParseDate(fromParseDate($ret->dataCreazione));
$restituito->ACL = toParseACL(fromParseACL($ret->ACL));
$restituito->geopoint = toParseGeoPoint(fromParseGeoPoint($ret->geopoint));
$restituito->relazione = toParseRelation("Album", fromParseRelation("Utils", "relazione", $ret->objectId, "Album"));
$restituito->puntatore = toParsePointer("Album", fromParsePointer($ret->puntatore));
$restituito->descrizione = "Oggetto creato al secondo giro";

$ret = $restituito->save();

echo var_dump($ret);
?>

