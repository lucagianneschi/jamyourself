<?php
//inizializzo la sessione SEMPRE prima di qualsiasi altra cosa nella pagina
session_start();

ini_set('display_errors', 1);

require_once '../config.php';
include_once CLASSES_DIR.'user.class.php';

//entro solo se la mia chiamata viene dalla pagina example1.step1.php
if ($_POST['action'] == 'step1') {
	//controllo se l'utente ha inserito correttamente i dati
	if ($_POST['type'] == '') {
		//l'utente non ha dichiarato il tipo, quindi restituisco l'errore
		$_SESSION['step1Error'] = 'Attenzione, non è stato selezionato nessun tipo.';
		//richiamo lo step 1 per essere completato
		//header('Location: http://www.socialmusicdiscovering.com/script/wp_daniele/root/example1.step1.php');
		//ATTENZIONE redirect fatto con funzione javascript perchè altrimenti non sarebbe possibile debuggare
		echo '<script language="javascript">location.replace("http://www.socialmusicdiscovering.com/script/wp_daniele/root/example1.step1.php")</script>';
	} else {
		//i dati sembrano essere stati inseriti correttamente
		
		//creo l'utente
		$user = new User();
		
		//setto il parametro
		$user->setType($_POST['type']);
		
		//aggiungo l'utente alla sessione
		$_SESSION['user'] = $user;
		//$_SESSION['user'] = $_POST['type'];
		
		//richiamo lo step 2
		//header('Location: http://www.socialmusicdiscovering.com/script/wp_daniele/root/example1.step2.php');
		//ATTENZIONE redirect fatto con funzione javascript perchè altrimenti non sarebbe possibile debuggare
		echo '<script language="javascript">location.replace("http://www.socialmusicdiscovering.com/script/wp_daniele/root/example1.step2.php")</script>';
	}
}
?>