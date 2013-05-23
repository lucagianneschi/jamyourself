<?php 
require_once '../../parse/parse.php';
require_once '../../classes/user.class.php';
require_once '../../classes/userParse.class.php';

/*controllo che ci siano dati in POST*/
if(!isset($_POST)){
	echo "ERROR";
	exit();
}

/*recupero i dati*/
$username="";
$password="";

if(isset($_POST['username']))$username = $_POST['username'];
else{
	$risp =  array('Error' => "No username specified");
	echo $risp;
	exit();
}
if(isset($_POST['password']))$password = $_POST['password'];
else{
	$risp =  array('Error' => "No password specified");
	echo $risp;
	exit();
}
/**creo il been user*/
$user = new User();

/*imposto password e username per il login*/
$user->setUsername($username);
$user->setPassword($password);

/*effettuo il login*/
$userParse = new UserParse();

if( $user = $userParse->login($user) ){
	//successo!
	
	//inizializzo la sessione
	session_start();
	
	$_SESSION['currentUser'] = $user;
	
	//creo un activity login
	
	//preparo la risposta per la View
	$risp = array("userId" => $user->getObjectId());
}
else $risp =  array('Error' => "utente inesistente");

echo json_encode($risp);



?>
