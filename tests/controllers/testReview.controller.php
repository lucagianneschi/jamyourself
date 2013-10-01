<?php
/*
 * Classe di test per l'invio automatico di post JSON per il test
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

ini_set('error_reporting', E_ALL);
require_once ROOT_DIR . 'config.php';
require_once CONTROLLERS_DIR . 'review.controller.php';
$controller = new ReviewController();
$controller->init();
?>
<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<script src="jquery.js"></script>
	<script src="review.js"></script>
        <title></title>
    </head>
    <body>
        <form action="javascript:sendReview()">
            <label for="post" />
<?php
echo '<textarea id="review" rows="' . $controller->config->inputReviewRowNumber . '" cols="' . $controller->config->inputReviewColumnNumber . '"></textarea>';
?>
            <input type="submit" value="Send Review" name="sendReview" id="sendReview" />
        </form>
        <h2>
            Risposta del controller:           
        </h2>
        <div id="data"> 
        </div>
    </body>
</html>