<html>
<head>
</head>
<body>
<form action="controllers/example1.step1.controller.php" method="post">
	Seleziona il tipo utente:<br />
	<input type="radio" name="type" value="j" />Jammer<br />
	<input type="radio" name="type" value="s" />Spotter<br />
	<input type="radio" name="type" value="v" />Venue<br />

	<input type="submit" name="Step 1" value="step1">
	<?php
	if (isset($_SESSION['step1Error'])) {
		echo $_SESSION['step1Error'];
	}
	?>
</form>
</body>
</html>