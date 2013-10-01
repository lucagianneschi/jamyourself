<?php

echo "<h2> TEST SIGNUP</h2>";

foreach (glob("*.php") as $filename) {
    if ($filename == "testSignup.controller.php") {
	echo "<a  href='$filename'>$filename</a><br>";
    }
}
?>