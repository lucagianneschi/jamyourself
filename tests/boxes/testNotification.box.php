<?php
/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		test box Notification
 * \details		Recupera i counter delle notifiche
 * \par			Commenti:
 * \warning
 * \bug
 * \todo        fare il test sul dettaglio delle notifiche
 *
 */
$t_start = microtime(); //timer tempo totale
$i_start = microtime(); //timer include

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

ini_set('display_errors', '1');
require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once BOXES_DIR . 'notification.box.php';
$i_end = microtime();
$objectId = '7fes1RyY77';
$notification_start = microtime();
$notificationBoxP = new NotificationBox();
$notificationBox = $notificationBoxP->init($objectId, 'JAMMER');
print "<pre>";
print_r($notificationBox);
print "</pre>";
$notification_stop = microtime();
$notification1_start = microtime();
//echo '<br />----------------------EVENTLIST---------------------------<br />';
//$notificationBoxP0 = new NotificationBox();
//$notificationBox0 = $notificationBoxP0->initForEventList($id);
//print "<pre>";
//print_r($notificationBox0);
//print "</pre>";
//echo '<br />----------------------MESSAGELIST---------------------------<br />';
//$notificationBoxP1 = new NotificationBox();
//$notificationBox1 = $notificationBoxP1->initForMessageList($id);
//print "<pre>";
//print_r($notificationBox1);
//print "</pre>";
//echo '<br />----------------------RELATIONLIST---------------------------<br />';
//$notificationBoxP2 = new NotificationBox();
//$notificationBox2 = $notificationBoxP2->initForRelationList($objectId, 'JAMMER');
//print "<pre>";
//print_r($notificationBox2);
//print "</pre>";
$notification1_stop = microtime();
$t_end = microtime();
echo '<br />----------------------TIMERS---------------------------<br />';
echo 'Tempo include ' . executionTime($i_start, $i_end) . '<br />';
echo 'Tempo CONTATORI ' . executionTime($notification_start, $notification_stop) . '<br />';
echo 'Tempo LISTE ' . executionTime($notification1_start, $notification1_stop) . '<br />';
echo 'Tempo totale ' . executionTime($t_start, $t_end) . '<br />';
echo '<br />----------------------TIMERS---------------------------<br />';
?>