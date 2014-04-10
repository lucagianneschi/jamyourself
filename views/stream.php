<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'mantainance.service.php';
require_once SERVICES_DIR . 'session.service.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once SERVICES_DIR . 'log.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';

if (isset($_SESSION['id'])) {
    $currentUserUsername = $_SESSION['username'];
    ?>
    <!DOCTYPE html>
    <!--[if IE 8]><html class="no-js lt-ie9" lang="en" ><![endif]-->
    <!--[if gt IE 8]><!--><html class="no-js" lang="en" ><!--<![endif]-->
        <head>
        <title><?php echo $views['metatag']['stream']['title'] . $currentUserUsername ?></title>
        <meta name="description" content="<?php echo $views['metatag']['stream']['description'] ?>">
        <meta name="keywords" content="<?php echo $views['metatag']['stream']['keywords'] ?>">
        <link rel="icon" href="<?php echo VIEWS_DIR . "resources/images/icon/favicon.ico"; ?>" sizes="16x16"></link>
            <!-------------------------- METADATI --------------------------->
        <?php require_once(VIEWS_DIR . "content/general/meta.php"); ?>
        </head>
        <body>
            <!-------------------------- HEADER --------------------------->
        <?php require_once(VIEWS_DIR . 'content/header/main.php'); ?>
            <!-------------------------- BODY --------------------------->
        <?php require_once(VIEWS_DIR . 'content/stream/main.php'); ?>
            <!-------------------------- FOOTER --------------------------->
        <?php require_once(VIEWS_DIR . 'content/general/footer.php'); ?>	
            <!-------------------------- SCRIPT --------------------------->
        <?php require_once(VIEWS_DIR . "content/general/script.php"); ?>
            <script>
            loadBoxPost();
            loadBoxActivity();
            </script>
        </body>
    </html>
<?php
} else {
    header('Location: ../index.php?login');
}
?>