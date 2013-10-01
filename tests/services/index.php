<?php

echo "<h2>TEST SERVICES</h2>";
/*
foreach (glob("*.php") as $filename) {
    echo "<a  href='$filename'>$filename</a><br>";
}
*/
foreach (scandir('.') as $filename) {
	if($filename != 'index.php'){
   		 echo "<a  href='$filename'>$filename</a><br>";
	}

}
?>

