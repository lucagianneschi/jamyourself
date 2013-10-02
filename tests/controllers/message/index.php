<?php

echo "<h2> TEST MESSAGE</h2>";

foreach (scandir('.') as $filename) {
	if($filename != 'index.php' && $filename != 'message.js'){
   		 echo "<a  href='$filename'>$filename</a><br>";
	}

}
?>