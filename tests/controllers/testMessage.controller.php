<?php

/*
 * Classe di test per l'invio automatico di post JSON per il test
 */
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
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
             <script src="jquery.js"></script>
            <script src="comment.js"></script>
        <title></title>
    </head>
    <body>
        <form action="javascript:sendMessage()">
            <label for="post">
            <?php 
            echo "<textarea id=\"post\" rows=".$controller->config->inputMessageRowNumber." cols=".$controller->config->inputMessageColumnNumber."> </textarea>"
            ?>
            <input type="submit" value="Send Message" name="sendMessage" id="sendMessage">
        </form>
        <h2>
            Risposta del controller:           
        </h2>
        <div id="data"> 
        </div>
    </body>
</html>
