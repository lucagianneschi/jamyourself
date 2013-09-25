<?php

echo "<h2> Elenco file di test per il servizio di invio mail</h2>";

foreach (glob("*.php") as $filename) {
    echo "<a  href='$filename'>$filename</a><br>";
}
?>

