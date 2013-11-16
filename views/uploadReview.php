<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');
//ini_set( "display_errors", 0);
require_once ROOT_DIR . 'config.php';
require_once CONTROLLERS_DIR . 'uploadReview.controller.php';

$uploadReviewController = new uploadReviewController();
$uploadReviewController->init();
$title = $uploadReviewController->recordInfo["title"];
$thumbnail = $uploadReviewController->recordInfo["thumbnail"];
$rating = $uploadReviewController->recordInfo["rating"];
$tagGenere = $uploadReviewController->recordInfo["tagGenere"];
$featuringInfoArray = $uploadReviewController->recordInfo["featuringInfoArray"];
$author = $uploadReviewController->recordInfo["author"];
$authorThumbnail = $uploadReviewController->recordInfo["authorThumbnail"];
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
