<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');
//ini_set( "display_errors", 0);
require_once ROOT_DIR . 'config.php';
require_once CONTROLLERS_DIR . 'uploadReview.controller.php';

session_start();

$uploadReviewController = new uploadReviewController();
$uploadReviewController->init();
$viewInfo = $uploadReviewController->reviewedInfo;


global $boxes;
$title = $viewInfo->title;
$tagGenere = $viewInfo->genre;
$rating="3";
$authorThumbnail=$viewInfo->authorThumbnail;
$thumbnail = $viewInfo->thumbnail;
$featuringInfoArray = $viewInfo->featuring;

$author = $viewInfo->fromUserInfo->username;

//  media info:
//    public $city;
//    public $className;
//    public $eventDate;
//    public $featuring;
//    public $fromUserInfo;
//    public $genre;
//    public $locationName;
//    public $objectId;
//    public $tags;
//    public $thumbnail;
//    public $title;  
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
        <div class="body-content">
            <?php require_once(VIEWS_DIR . 'content/uploadReview/main.php'); ?>
        </div>
        <!-------------------------- FOOTER --------------------------->
        <?php require_once(VIEWS_DIR . 'content/general/footer.php'); ?>	

        <!-------------------------- SCRIPT --------------------------->
        <?php require_once(VIEWS_DIR . "content/general/script.php"); ?>
    </body>

</html>
