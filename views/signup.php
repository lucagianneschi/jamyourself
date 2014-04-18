<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'mantainance.service.php';
require_once SERVICES_DIR . 'session.service.php';
require_once CONTROLLERS_DIR . 'signup.controller.php';
require_once SERVICES_DIR . 'recaptcha.service.php';

global $views;

$sc = new SignupController();
$sc->init();

//recupero la chiave pubblica del captcha dalla sessione
$captchaPublicKey = $_SESSION['captchaPublicKey'];
?>
<!DOCTYPE html>
<!--[if IE 8]><html class="no-js lt-ie9" lang="en" ><![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" lang="en" ><!--<![endif]-->

    <head>
	<title><?php echo $views['metatag']['signup']['title'] ?></title>
	<meta name="description" content="<?php echo $views['metatag']['signup']['description'] ?>">
	<meta name="keywords" content="<?php echo $views['metatag']['signup']['keywords'] ?>">
	<link rel="icon" href="<?php echo VIEWS_DIR . "resources/images/icon/favicon.ico"; ?>" sizes="16x16"></link>
        <!-------------------------- METADATI --------------------------->
	<?php require_once(VIEWS_DIR . "content/general/meta.php"); ?>
	<!--	<script type="text/javascript" src="resources/javascripts/customs/signup.js"></script> -->
    </head>

    <body>

        <!-------------------------- HEADER --------------------------->
	<?php require_once(VIEWS_DIR . 'content/header/main.php'); ?>

        <!-------------------------- BODY --------------------------->
        <div class="body-content">
	    <?php require_once(VIEWS_DIR . 'content/signup/signup-main.php'); ?>
        </div>
        <!-------------------------- FOOTER --------------------------->
	<?php require_once(VIEWS_DIR . 'content/general/footer.php'); ?>	

        <!-------------------------- SCRIPT --------------------------->
	<?php require_once(VIEWS_DIR . "content/general/script.php"); ?>

    </body>

</html>
