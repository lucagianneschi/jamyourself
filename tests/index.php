<?php

echo "<h2> Elenco delle cartelle e dei file di test</h2>";
foreach (scandir('.') as $filename) {
	if($filename != 'index.php' && $filename != '/examples'){
   		 echo "<a  href='$filename'>$filename</a><br>";
	}

}
?>

