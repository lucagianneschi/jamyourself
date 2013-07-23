<?php

echo "<h2> Elenco dei file di test per i box di notifica </h2>";

foreach (glob("*.php") as $filename) {
    echo "<a  href='$filename'>$filename</a><br>";
}

?>

