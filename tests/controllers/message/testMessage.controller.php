<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../');

ini_set('error_reporting', E_ALL);
require_once ROOT_DIR . 'config.php';
require_once CONTROLLERS_DIR . 'message.controller.php';
$controller = new MessageController();
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
	<script src="message.js"></script>
        <title></title>
    </head>
    <body>
        <form action="javascript:sendComment()">
            <label for="comment" />
	    <?php
	    echo '<textarea id="message" rows="' . $controller->config->inputMessageRowNumber . '" cols="' . $controller->config->inputMessageColumnNumber . '"></textarea>';
	    ?>
            <input type="submit" value="Send Message" name="sendMessage" id="sendMessage" />
        </form>
        <h2>
            Risposta del controller:           
        </h2>
        <div id="data"> 
        </div>
    </body>
</html>