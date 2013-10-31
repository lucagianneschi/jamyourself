<?php

echo "<h2> Elenco delle pagine di test </h2>";
foreach (scandir('.') as $filename) {
	if($filename != 'index.php' ){
   		 echo "<a  href='$filename'>$filename</a><br>";
	}

}
?>