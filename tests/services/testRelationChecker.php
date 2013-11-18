<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');
ini_set('display_errors', '1');
require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once SERVICES_DIR . 'relationChecker.service.php';

$ldf = '7fes1RyY77';
$id1 = 'bNoL9OZt7V';

$t_start = microtime(); //timer tempo totale
$rel = relationChecker($ldf, 'JAMMER', $id1, 'JAMMER');
print "<pre>";
print_r(($rel === true)? 'TRUE':'FALSE');
print "</pre>";
$t_stop = microtime(); //timer tempo totale
$t1_start = microtime(); //timer tempo totale
$rel1 = relationChecker($ldf, 'JAMMER', 'pippopo', 'JAMMER');
$t1_stop = microtime(); //timer tempo totale
print "<pre>";
print_r(($rel1 === true)? 'TRUE':'FALSE');
print "</pre>";

echo 'Tempo check LDF ok ' . executionTime($t_start, $t_stop) . '<br />';
echo 'Tempo check  LDF fallito ' . executionTime($t1_start, $t1_stop) . '<br />';

$lucagianneschi = 'EKElKcMMRM';
$id2 = '8WRJN0nCal';

$t2_start = microtime(); //timer tempo totale
$rel2 = relationChecker($lucagianneschi, 'JAMMER', $id2, 'JAMMER');
print "<pre>";
print_r(($rel2 === true)? 'TRUE':'FALSE');
print "</pre>";
$t3_stop = microtime(); //timer tempo totale
$t4_start = microtime(); //timer tempo totale
$rel4 = relationChecker($lucagianneschi, 'JAMMER', 'pippopo', 'JAMMER');
$t4_stop = microtime(); //timer tempo totale
print "<pre>";
print_r(($rel4 === true)? 'TRUE':'FALSE');
print "</pre>";

echo 'Tempo check lucagianneschi (926 utenti in relazione) ok ' . executionTime($t_start, $t_stop) . '<br />';
echo 'Tempo check  lucagianneschi (146 utenti in relazione) fallito ' . executionTime($t1_start, $t1_stop) . '<br />';





?>