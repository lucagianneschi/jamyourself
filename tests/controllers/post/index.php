<?php

echo "<h2> TEST POST</h2>";

foreach (scandir('.') as $filename) {
	if($filename != 'index.php' && $filename != 'post.js'){
   		 echo "<a  href='$filename'>$filename</a><br>";
	}

}
?>