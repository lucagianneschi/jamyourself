<?php

echo "<h2>TEST USER UTILITIES</h2>";

foreach (glob("*.php") as $filename) {
	if($filename != 'index.php'){
		echo "<a  href='$filename'>$filename</a><br>";
	}
}
?>