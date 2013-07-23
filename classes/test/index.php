<?php

echo "<h2> Elenco delle pagine di test della Jam/Parse library</h2>";
/*
foreach (glob("*.php") as $filename) {
    echo "<a  href='$filename'>$filename</a><br>";
}
*/
foreach (scandir('.') as $filename) {
    echo "<a  href='$filename'>$filename</a><br>";
}
?>

