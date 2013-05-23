<?php
require_once '../parse/parse.php';
require_once '../classes/activity.class.php';
require_once '../classes/activityParse.class.php';
require_once '../classes/user.class.php';
require_once '../classes/userParse.class.php';
require_once '../classes/playlist.class.php';
require_once '../classes/playlistParse.class.php';
require_once '../log/log.php';


if(isset($_POST['action']) && $_POST['data']){

	$return = null;
	$function = $_POST['action']; 	//stringa col nome della funzione da chiamare
	$data = json_decode($_POST['data']);	//parametri per la funzione (ad esempio un oggetto JSON)


	//per il log
	ob_start();
	var_dump($json);
	$param = ob_get_clean();
	stampaLog("[playlistController] - ACTION: ".$function." - PARAM: ".$param);

	// 	richiamo la funzione richiesta
	switch($_POST['action']){
		case "playlistCreate" :
				
			$return = playlistCreate($data);
				
			break;
		
		case "playlistAddSong" :
			
			$return = playlistAddSong($data);
			break;

		default :
				
			$return = new Response();
			$return->setError("No action defined for \"".$function."\"");

			break;
				
	}

	//per il log
// 	ob_start();
// 	var_dump($return);
// 	$param = ob_get_clean();
// 	stampaLog("[playlistController] - Risultato call_user_func_array: ".$param);

	//fornisco la risposta all'utente
	echo json_encode($return);
}

/**
 * /request for playlistCreate
 * @param unknown $json
 */
function playlistCreate($data){
	ob_start();
	var_dump($data);
	$param = ob_get_clean();
	stampaLog("[playlistController - playlistCreate] - JSON: ".$param);

	//variabili locali
	$userParse = null;
	$user = null;
	$userId = "";
	$return = null;
	$playlist = null;
	$playlistParse = null;
	$param = null;

	//inizializzazione valori
	$userParse = new UserParse();
	$return = new Response();

	if($data == null){
		stampaLog("[playlistController - playlistCreate] - ERRORE: Il parametro JSON è NULL");
		$return->setError("Param is NULL");
		return $return;

	}


	$userId = $data->userId;
	stampaLog("[playlistController - playlistCreate] - userId: ".$userId);

	//recupero l'utente che ha effettuato la richiesta
	if( !($user = $userParse->getUserById($userId)) ){
		//errore
		stampaLog("[playlistController - playlistCreate] - JSON[userId]: ".$userId."  - ERRORE: Impossibile recuperare l'utente");
		$return->setError("Impossibile recuperare l'utente");
		return $return;
	}



	//verifico se l'utente può creare una nuova playlist
	if ($user->getPremium() == false ){
		//errore
		$return->setError("Account non premium");
		stampaLog("[playlistController - playlistCreate] - JSON[userId]: ".$userId." -ERRORE: Account non premium");
		return $return;
	}

	//creo la playlist
	$playlist = new Playlist();
	$playlist->setToUser($user);
	$playlist->setUnlimited(false);

	//salvo la playlist
	$playlistParse = new PlaylistParse();
	if( $playlistParse->save($playlist) == false){
		//errore nel salvataggio della playlist!
		$return->setError("Salvataggio della playlist fallito");
		stampaLog("[playlistController - playlistCreate] - JSON[userId]: ".$userId." -ERRORE: Salvataggio della playlist fallito");
		return $return;
	}

	//restituisco success!
	$return->setMessage("Playlist salvata correttamente");
	stampaLog("[playlistController - playlistCreate] - JSON[userId]: ".$userId." - PlaylistId: ".$playlist->getObjectId());
	$return->setData($playlist->getObjectId());
	return $return;

}


function playlistAddSong($json){
	//variabili locali
	$userParse = null;
	$user = null;
	$return = null;
	$playlist = null;
	$playlistParse = null;
	$param = null;
	$song = null;
	$songParse = null;
	$songs = null;

	//inizializzazione valori
	$userParse = new UserParse();
	$return = new Response();
	$playlistParse = new PlaylistParse();
	$songParse = new SongParse();
	$maxSongNumber = 20;

	if(!$json || !isset( $json['userId']) || !isset($json['songId']) || !isset($json['playlistId']) ){
		//errore
		$return->setError("Bad Request");

		return $return;
	}

	//decodifico l'oggetto
	if( !( $param = json_decode($json) ) ){
		//errore
		$return->setError("Impossibile interpreatare i parametri");

		return $return;

	}

	//recupero l'utente che ha effettuato la richiesta
	if( !($user = $userParse->getUserById($json['userId'])) ){

		//errore
		$return->setError("Impossibile recuperare l'utente");

		return $return;
	}


	//recupero la playlist

	if( !$playlist = $playlistParse->getPlaylist($json['playlistId']) ){

		$return->setError("Impossibile recuperare la playlist");

		return $return;

	}

	//recupero la canzone
	if( !$song = $songParse->getSong($json['songId']) ){

		$return->setError("Impossibile recuperare la canzone");

		return $return;

	}

	//recupero la lista delle canzoni
	if( ! $songs = $playlist->getSongs() ){

		$return->setError("Impossibile recuperare la lista delle canzoni");

		return $return;
	}

	//verifico se la playlist è unlimited
	if($playlist->getUnlimited() == false){
		//rimuovo la più vecchia canzone

		// si fa un count dell’array “songs”, se è ==20, allora rimuovi la song
		// all’indice 19 (l’ultima, la più vecchia) e shifti di 1 tutte le
		// song dalla 0 alla 18
		if(count($song) == $maxSongNumber){
				
			array_pop($songs);
				
		}

	}

	//aggiungo la canzone in posizione [0]
	array_unshift($songs, $song);

	//update della playlist
	$playlist->setSongs($songs);

	if( !$playlistParse->save($playlist) ){

		$return->setError("Impossibile aggiornare la playlist");

		return $return;
	}

	//return
	$return->setMessage("Playlist salvata correttamente");
	$return->setData($playlist->getObjectId());
	return $return;
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