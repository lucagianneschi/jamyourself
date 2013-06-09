<?php

if(isset($_POST['action']) && $_POST['data']){

	$return = null;
	$function = $_POST['action'];           //stringa col nome della funzione da chiamare
	$data = json_decode($_POST['data']);	//parametri per la funzione (ad esempio un oggetto JSON)

	//richiamo la funzione richiesta
	switch($_POST['action']){
		case "testFunction" :

			$return = testFunction($data);
			break;

		default :

			$return = new Response();
			$return->setError("No action defined for \"".$function."\"");

			break;

	}

	//fornisco la risposta all'utente
	echo json_encode($return);
}

function testFunction($data){
 
//    $obj = json_decode($data);
    
    $stringa = "[Parametro 1] => ".$data->uno.". - [Parametro 2] => ".$data->due;
    
    $risposta = new Response();

    $risposta->setMessage("Tutto apposto a ferragosto");
    $risposta->setData($stringa);
    
    return $risposta;
    
}
/**
 * Una semplice classe per i messaggi di risposta
 * alle chiamate Ajax
 *
 * @author Stefano
 *
 */
class Response{

	public $message;	//messaggio di conferma se necessario
	public $error;		//messaggio d'errore
	public $data; 		//deve essere un JSON o al max una stringa!

	function __construct(){
	}

	function setMessage($text){
		$this->message = $text;
	}

	function setError($text){
		$this->error = $text;
	}

	function setData($data){
		$this->data = $data;
	}

	function getMessage(){
		return $this->message;
	}

	function getError(){
		return $this->error;
	}

	function getData(){
		return $this->data;
	}
}
?>