<?php

echo "<h2>TEST LOGIN LOGOUT</h2>";

foreach (scandir('.') as $filename) {
	if($filename != 'index.php'){
   		 echo "<a  href='$filename'>$filename</a><br>";
	}

}
?>