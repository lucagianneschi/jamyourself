<?php
function debug($path, $file, $msg) {
	$fp = fopen($path . $file, 'a+');
	fwrite($fp, $msg . "\n");
	fclose($fp);
}
?>