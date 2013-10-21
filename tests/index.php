<?php

echo "<h2> Elenco delle cartelle di test</h2>";
/*
foreach (glob("*.php") as $filename) {
    echo "<a  href='$filename'>$filename</a><br>";
}
*/
foreach (scandir('.') as $filename) {
	if($filename != 'index.php' && $filename != '/examples'){
   		 echo "<a  href='$filename'>$filename</a><br>";
	}

}
?>

