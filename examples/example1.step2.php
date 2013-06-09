<?php
//inizializzo la sessione SEMPRE prima di qualsiasi altra cosa nella pagina
session_start();

ini_set('display_errors', 1);
?>
<html>
<head>
</head>
<body>
L'utente presente in sessione è:
<?php
//stampo a video l'oggetto user passato dalla sessione
print_r($_SESSION['user']);
?>
</body>
</html>