<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
/*
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
*/
?>
<!DOCTYPE html>
<!--[if IE 8]><html class="no-js lt-ie9" lang="en" ><![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" lang="en" ><!--<![endif]-->

    <head>

        <title>Jamyourself</title>
        <!-------------------------- METADATI --------------------------->
        <?php
        require_once(VIEWS_DIR . "content/general/meta.php");
        ?>

    </head>

    <body>

        <!-------------------------- HEADER --------------------------->
        <?php
        require_once(VIEWS_DIR . 'content/header/main.php');
        ?>

        <!-------------------------- BODY --------------------------->
        <div class="body-content">
            <?php
            require_once(VIEWS_DIR . 'content/uploadAlbum/main.php');
            ?>
        </div>
        <!-------------------------- FOOTER --------------------------->
        <?php
        require_once(VIEWS_DIR . 'content/general/footer.php');
        ?>	

        <!-------------------------- SCRIPT --------------------------->
		<?php
		require_once(VIEWS_DIR . "content/general/script.php");
		?>
    </body>

</html>
