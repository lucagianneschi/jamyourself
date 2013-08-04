<?php

echo "<h2> Elenco dei file di test per box generali, da caricare su tutte le tipologie di pagina </h2>";

foreach (glob("*.php") as $filename) {
    echo "<a  href='$filename'>$filename</a><br>";
}

?>

