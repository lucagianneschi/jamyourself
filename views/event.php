<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'mantainance.service.php';
require_once SERVICES_DIR . 'session.service.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once SERVICES_DIR . 'debug.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
require_once BOXES_DIR . 'event.box.php';

$objectId = '';
if (isset($_GET['event']))
    $objectId = $_GET['event'];
$eventBox = new EventBox();
$eventBox->initForMediaPage($objectId);
if (is_null($eventBox->error) && !empty($eventBox->eventArray)) {
    $event = $eventBox->eventArray[$objectId];
    ?>
    <!DOCTYPE html>
    <!--[if IE 8]><html class="no-js lt-ie9" lang="en" ><![endif]-->
    <!--[if gt IE 8]><!--><html class="no-js" lang="en" ><!--<![endif]-->
        <head>
    	<title>Jamyourself</title>
    	<!-------------------------- METADATI --------------------------->
	    <?php require_once(VIEWS_DIR . "content/general/meta.php"); ?>
        </head>
        <body>
    	<!-------------------------- HEADER --------------------------->
	    <?php require_once(VIEWS_DIR . 'content/header/main.php'); ?>
    	<!-------------------------- BODY --------------------------->
	    <?php require_once(VIEWS_DIR . 'content/event/main.php'); ?>
    	<!-------------------------- FOOTER --------------------------->
	    <?php require_once(VIEWS_DIR . 'content/general/footer.php'); ?>	
    	<!-------------------------- SCRIPT --------------------------->
	    <?php require_once(VIEWS_DIR . "content/general/script.php"); ?>
    	<script type="text/javascript">
    	    loadBoxInformationFeaturing();
    	    loadBoxInformationAttendee();
    	    loadBoxInformationInvited();
    	    loadBoxEventReview(3, 0);
    	    loadBoxComment(3, 0);
    	</script>
        </body>
    </html>
    <?php
} else {
    header('Location: ' . VIEWS_DIR . '404.php');
}
?>