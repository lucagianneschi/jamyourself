<?php
/*
 * Classe di test per l'invio automatico di post JSON per il test
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../');

require_once ROOT_DIR . 'config.php';
require_once CONTROLLERS_DIR . 'post.controller.php';
$controller = new PostController();
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
		<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
		<script src="post.js"></script>
        <title></title>
    </head>
    <body>
        <form action="javascript:sendPost()">
            <label for="post" />
	    <?php
	    echo '<textarea id="post" rows="' . $controller->config->inputPostRowNumber . '" cols="' . $controller->config->inputPostColumnNumber . '"></textarea>';
	    ?>
            <input type="submit" value="Send Post" name="sendPost" id="sendPost" />
        </form>
        <h2>
            Risposta del controller:           
        </h2>
        <div id="data"> 
        </div>
    </body>
</html>