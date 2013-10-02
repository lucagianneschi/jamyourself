<?php

echo "<h2> TEST REVIEW</h2>";

foreach (scandir('.') as $filename) {
	if($filename != 'index.php' && $filename != 'review.js'){
   		 echo "<a  href='$filename'>$filename</a><br>";
	}

}
?>