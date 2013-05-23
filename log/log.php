<?php 
function stampaLog($text){
	$cartella="D:\\EasyPHP\\www\\Jamyourself\\jamyourself\\log\\tmp\\";
	$today = date("m-d-y");
	$file=$cartella."".$today."-[LOG].txt";
	
	$fp = fopen($file, 'a');
	fwrite($fp, "[".date("H:i:s")."] ".$text."\n");
	fclose($fp);
}

?>