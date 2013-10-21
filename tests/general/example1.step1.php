<?php
//inizializzo la sessione SEMPRE prima di qualsiasi altra cosa nella pagina
session_start();

ini_set('display_errors', 1);
?>
<html>
<head>
</head>
<body>
<form action="http://www.socialmusicdiscovering.com/script/wp_daniele/root/controllers/example1.step1.controller.php" method="post">
	Seleziona il tipo utente:<br />
	<input type="radio" name="type" value="j" />Jammer<br />
	<input type="radio" name="type" value="s" />Spotter<br />
	<input type="radio" name="type" value="v" />Venue<br />

	<input type="submit" name="Step 1" value="step1">
	<input type="hidden" name="action" value="step1">
	<?php
	if (isset($_SESSION['step1Error'])) {
		echo $_SESSION['step1Error'];
		unset($_SESSION['step1Error']);
	}
	?>
</form>
</body>
</html>