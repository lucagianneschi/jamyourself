<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';

$eventObjectId = $_GET['event'];

?>
<!DOCTYPE html>
<!--[if IE 8]><html class="no-js lt-ie9" lang="en" ><![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" lang="en" ><!--<![endif]-->

    <head>

        <title>Jamyourself</title>
        <!-------------------------- METADATI --------------------------->
        <?php require_once(VIEWS_DIR . "content/general/meta.php"); ?>
        
        <style>
        	
        </style>

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
        
    </body>

</html>