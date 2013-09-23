<?php

echo "<h2> Elenco delle pagine di test per i controller</h2>";

foreach (glob("*.php") as $filename) {
    echo "<a  href='$filename'>$filename</a><br>";
}
?>

