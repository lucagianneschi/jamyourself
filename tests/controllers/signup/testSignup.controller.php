<?php

/*
 * Classe di test per l'invio automatico di oggetti JSON per il test della
 * registrazione
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../');

require_once ROOT_DIR . 'config.php';
require_once CONTROLLERS_DIR . 'signup.controller.php';
$sc = new SignupController();
$sc->init();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
  <script src="jquery.js"></script>
  <script src="signup.js"></script>
  
  <title></title>
  </head>
  <body>
  <input type="button" value="Invia Spotter" onclick="javascript:spotter()">
  <input type="button" value="Invia Jammer Band" onclick="javascript:jband()">
  <input type="button" value="Invia Jammer Artista" onclick="javascript:jartist()">
  <input type="button" value="Invia Venue" onclick="javascript:venue()">
  
  <br><br>
  <input type="text" id ="username"> <button id="email_username" onclick="javascript:checkUsernameExists()">Verifica lo username</button>
  <input type="email" id ="email"> <button id="email_button" onclick="javascript:checkEmailExists()">Verifica la mail</button>

  <br><br>
  <p>Risultato della query:<p>
  <div id="log"</div>
  </body>
</html>
<?php
?>
