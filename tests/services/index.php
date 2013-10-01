<?php

echo "<h2> Elenco delle cartelle di test per i services</h2>";

foreach (scandir('.') as $filename) {
    echo "<a  href='$filename'>$filename</a><br>";
}
?>

