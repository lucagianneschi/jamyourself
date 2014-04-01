<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'mantainance.service.php';
require_once SERVICES_DIR . 'session.service.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once SERVICES_DIR . 'log.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
require_once BOXES_DIR . 'event.box.php';

$id = '';
if (isset($_GET['event']))
    $id = $_GET['event'];
$eventBox = new EventBox();
$eventBox->initForMediaPage($id);
if (is_null($eventBox->error) && !empty($eventBox->eventArray)) {
    $event = $eventBox->eventArray[$id];
    ?>
    <!DOCTYPE html>
    <!--[if IE 8]><html class="no-js lt-ie9" lang="en" ><![endif]-->
    <!--[if gt IE 8]><!--><html class="no-js" lang="en" ><!--<![endif]-->
        <head>
    	<title><?php echo $views['metatag']['event']['title'] . $event->getTitle() ?></title>
	<meta name="description" content="<?php echo $views['metatag']['event']['description'] ?>">
	<meta name="keywords" content="<?php echo $views['metatag']['event']['keywords'] ?>">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="icon" href="<?php echo VIEWS_DIR . "resources/images/icon/favicon.ico"; ?>" sizes="16x16"></link>
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