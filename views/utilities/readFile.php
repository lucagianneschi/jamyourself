<?php
/*
 * Se chiamato tramite ajax con chiamata POST, file_name_txt sara' il nome del file che andra' a leggere
 * restituisce un json (lettura per riga)  
 */

$file = $_POST['file_name_txt'];

$righe = file($file);

echo json_encode($righe);

?>