<?php

echo "<h2>TEST COMMENT</h2>";

foreach (glob("*.php") as $filename) {
    if ($filename != "index.php" && $filename != "comment.js") {
	echo "<a  href='$filename'>$filename</a><br>";
    }
}
?>