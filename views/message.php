<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
require_once CLASSES_DIR . 'userParse.class.php';
session_start();
$currentUser = $_SESSION['currentUser'];

//esempio: objectId dell'utente collegato 
$objectIdCurrentUser = "GuUAj83MGH";
$typeCurrentUser = $_GET['typeCurrentUser'];

//esempio: objectId dell'utente a cui si vuole vedere il profilo 
$objectIdUser = $_GET['objectIdUser'];


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
        <?php require_once(VIEWS_DIR . 'content/message/main.php'); ?>
        
        <!-------------------------- FOOTER --------------------------->
        <?php require_once(VIEWS_DIR . 'content/general/footer.php'); ?>	

        <!-------------------------- SCRIPT --------------------------->
        <?php require_once(VIEWS_DIR . "content/general/script.php"); ?>

    </body>

</html>
