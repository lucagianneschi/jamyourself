<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');
//ini_set( "display_errors", 0);
require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'mantainance.service.php';
require_once SERVICES_DIR . 'session.service.php';
require_once CONTROLLERS_DIR . 'uploadReview.controller.php';

$uploadReviewController = new UploadReviewController();
$uploadReviewController->init();

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
