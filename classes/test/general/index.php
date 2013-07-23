<?php

echo "<h2> Elenco dei file di test per le Classi (Models) </h2>";

foreach (glob("*.php") as $filename) {
    echo "<a  href='$filename'>$filename</a><br>";
}

?>

