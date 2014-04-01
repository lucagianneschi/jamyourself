<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');
//ini_set( "display_errors", 0);
require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'mantainance.service.php';
require_once SERVICES_DIR . 'session.service.php';
require_once CONTROLLERS_DIR . 'uploadReview.controller.php';

$currentUserId = $_SESSION['id'];
$uploadReviewController = new UploadReviewController();
$uploadReviewController->init();
$title = $uploadReviewController->reviewed->getTitle();
$tagGenere = "";
$thumbnail = "";
switch ($uploadReviewController->reviewedClassType) {
    case "Record":
	$tagGenere = $uploadReviewController->reviewed->getGenre();
	$thumbnail = $uploadReviewController->reviewed->getThumbnail();
	break;
    case "Event" :
	$tagGenere = implode(",", $uploadReviewController->reviewed->getTag());
	$thumbnail = $uploadReviewController->reviewed->getThumbnail();
	break;
}
$rating = "3";
$authorObjectId = $uploadReviewController->reviewedFromUser->getId();
$authorThumbnail = $uploadReviewController->reviewedFromUser->getThumbnail();
$author = $uploadReviewController->reviewedFromUser->getUsername();

if ($authorObjectId == $currentUserId) {
    header('Location: stream.php');
} else {
    ?>
    <!DOCTYPE html>
    <!--[if IE 8]><html class="no-js lt-ie9" lang="en" ><![endif]-->
    <!--[if gt IE 8]><!--><html class="no-js" lang="en" ><!--<![endif]-->

        <head>
	<title><?php echo $views['metatag']['uploadReview']['title'] ?></title>
	<meta name="description" content="<?php echo $views['metatag']['uploadReview']['description'] ?>">
	<meta name="keywords" content="<?php echo $views['metatag']['uploadReview']['keywords'] ?>">
	<link rel="icon" href="<?php echo VIEWS_DIR . "resources/images/icon/favicon.ico"; ?>" sizes="16x16"></link>
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
<?php } ?>