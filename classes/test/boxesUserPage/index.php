<?php

echo "<h2> Elenco dei file relativi ai box della pagina utente</h2>";

foreach (glob("*.php") as $filename) {
    echo "<a  href='$filename'>$filename</a><br>";
}

?>
