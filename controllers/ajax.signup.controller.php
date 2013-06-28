<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'utils.class.php';
require_once CLASSES_DIR . 'userParse.class.php';

if (isset($_POST['action']) && $_POST['data']) {

    $return = null;
    $function = $_POST['action'];  //stringa col nome della funzione da chiamare
    $data = json_decode($_POST['data']); //parametri per la funzione (ad esempio un oggetto JSON)
    // 	richiamo la funzione richiesta
    switch ($_POST['action']) {
        case "userExists" :

            $return = userExists($data);
            break;

        default :

            $return = new Response();
            $return->setError("No action defined for \"" . $function . "\"");

            break;
    }

    //fornisco la risposta all'utente
    echo json_encode($return);
}

function userExists($data) {

    $return = new Response();
    if (is_null($data) || !isset($data->username)) {
        $return->setMessage("data è null");
        return $return;
    }

    $pUser = new UserParse();
    $pUser->where("username", $data->username);   
    $result = $pUser->getCount();

    $return->setMessage($result);

    return $return;
}

/**
 * Una semplice classe per i messaggi di risposta
 * alle chiamate Ajax
 *
 * @author Stefano
 *
 */
class Response {

    public $message; //messaggio di conferma se necessario
    public $error;  //messaggio d'errore
    public $data;   //deve essere un JSON o al max una stringa!

    function __construct() {
        
    }

    function setMessage($text) {
        $this->message = $text;
    }

    function setError($text) {
        $this->error = $text;
    }

    function setData($data) {
        $this->data = $data;
    }

    function getMessage() {
        return $this->message;
    }

    function getError() {
        return $this->error;
    }

    function getData() {
        return $this->data;
    }

}

?>
