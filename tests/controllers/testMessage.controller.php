<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

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
	<script src="jquery.js"></script>
	<script src="comment.js"></script>
        <title></title>
    </head>
    <body>
        <form action="javascript:sendComment()">
            <label for="comment" />
<?php
echo '<textarea id="comment" rows="' . $controller->config->inputCommentRowNumber . '" cols="' . $controller->config->inputCommentColumnNumber . '"></textarea>';
?>
            <input type="submit" value="Send Comment" name="sendComment" id="sendComment" />
        </form>
        <h2>
            Risposta del controller:           
        </h2>
        <div id="data"> 
        </div>
    </body>
</html>