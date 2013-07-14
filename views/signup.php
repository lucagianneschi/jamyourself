<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once CONTROLLERS_DIR . 'signup/signup.controller.php';

$sc = new SignupController();
$sc->init();
?>
<!DOCTYPE html>
<!--[if IE 8]><html class="no-js lt-ie9" lang="en" ><![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" lang="en" ><!--<![endif]-->

    <head>

        <title>Jamyourself</title>
        <!-------------------------- METADATI --------------------------->
        <?php require_once(VIEW_DIR . "content/general/meta.php"); ?>

    </head>

    <body>

        <!-------------------------- HEADER --------------------------->
        <?php require_once(VIEW_DIR . 'content/general/header.php'); ?>

        <!-------------------------- BODY --------------------------->
        <div class="body-content">
            <?php require_once(VIEW_DIR . 'content/signup/signup-main.php'); ?>
        </div>
        <!-------------------------- FOOTER --------------------------->
        <?php require_once(VIEW_DIR . 'content/general/footer.php'); ?>	

        <!-------------------------- SCRIPT --------------------------->
        <?php require_once(VIEW_DIR . "content/general/script.php"); ?>
    </body>

</html>
