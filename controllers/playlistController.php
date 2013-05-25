<?php
require_once '../parse/parse.php';
require_once '../classes/activity.class.php';
require_once '../classes/activityParse.class.php';
require_once '../classes/user.class.php';
require_once '../classes/userParse.class.php';
require_once '../classes/playlist.class.php';
require_once '../classes/playlistParse.class.php';
require_once '../classes/song.class.php';
require_once '../classes/songParse.class.php';
require_once '../classes/pointerParse.class.php';
require_once '../log/log.php';


if(isset($_POST['action']) && $_POST['data']){

	$return = null;
	$function = $_POST['action']; 	//stringa col nome della funzione da chiamare
	$data = json_decode($_POST['data']);	//parametri per la funzione (ad esempio un oggetto JSON)

	// 	richiamo la funzione richiesta
	switch($_POST['action']){
		case "playlistCreate" :

			$return = playlistCreate($data);
			break;

		case "playlistAddSong" :

			$return = playlistAddSong($data);
			break;

		case "getUserPlaylists" :

			$return = getUserPlaylists($data);
			break;
				
		case "getPlaylist" :

			$return = getPlaylist($data);
			break;

		case "getSong" :
				
			$return = getSong($data);
			break;

		case "addSongToPlaylist" :

			$return = addSongToPlaylist($data);
			break;
		default :

			$return = new Response();
			$return->setError("No action defined for \"".$function."\"");

			break;

	}

	//fornisco la risposta all'utente
	echo json_encode($return);
}

/**
 * /request for playlistCreate
 * @param unknown $json
 */
function playlistCreate($data){

	//variabili locali
	$userParse = null;
	$user = null;
	$userId = "";
	$return = null;
	$playlist = null;
	$playlistParse = null;

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
	$playlist->setFromUser($user);
	$playlist->setUnlimited(false);
	$playlist->setName("Playlist");

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


// function playlistAddSong($json){
// 	//variabili locali
// 	$userParse = null;
// 	$user = null;
// 	$return = null;
// 	$playlist = null;
// 	$playlistParse = null;
// 	$song = null;
// 	$songParse = null;
// 	$songs = null;

// 	//inizializzazione valori
// 	$userParse = new UserParse();
// 	$return = new Response();
// 	$playlistParse = new PlaylistParse();
// 	$songParse = new SongParse();
// 	$maxSongNumber = 20;

// 	if(!$json || !isset( $json['userId']) || !isset($json['songId']) || !isset($json['playlistId']) ){
// 		//errore
// 		$return->setError("Bad Request");

// 		return $return;
// 	}

// 	//decodifico l'oggetto
// 	if( !( $param = json_decode($json) ) ){
// 		//errore
// 		$return->setError("Impossibile interpreatare i parametri");

// 		return $return;

// 	}

// 	//recupero l'utente che ha effettuato la richiesta
// 	if( !($user = $userParse->getUserById($json['userId'])) ){

// 		//errore
// 		$return->setError("Impossibile recuperare l'utente");

// 		return $return;
// 	}


// 	//recupero la playlist

// 	if( !$playlist = $playlistParse->getPlaylist($json['playlistId']) ){

// 		$return->setError("Impossibile recuperare la playlist");

// 		return $return;

// 	}

// 	//recupero la canzone
// 	if( !$song = $songParse->getSong($json['songId']) ){

// 		$return->setError("Impossibile recuperare la canzone");

// 		return $return;

// 	}

// 	//recupero la lista delle canzoni
// 	if( ! $songs = $playlist->getSongs() ){

// 		$return->setError("Impossibile recuperare la lista delle canzoni");

// 		return $return;
// 	}

// 	//verifico se la playlist è unlimited
// 	if($playlist->getUnlimited() == false){
// 		//rimuovo la più vecchia canzone

// 		// si fa un count dell’array “songs”, se è ==20, allora rimuovi la song
// 		// all’indice 19 (l’ultima, la più vecchia) e shifti di 1 tutte le
// 		// song dalla 0 alla 18
// 		if(count($song) == $maxSongNumber){

// 			array_pop($songs);

// 		}

// 	}

// 	//aggiungo la canzone in posizione [0]
// 	array_unshift($songs, $song);

// 	//update della playlist
// 	$playlist->setSongs($songs);

// 	if( !$playlistParse->save($playlist) ){

// 		$return->setError("Impossibile aggiornare la playlist");

// 		return $return;
// 	}

// 	//return
// 	$return->setMessage("Playlist salvata correttamente");
// 	$return->setData($playlist->getObjectId());
// 	return $return;
// }

function getUserPlaylists($data){

	stampaLog("[playlistController - getUserPlaylists] - INIZIO");

	//variabili locali
	$userParse = null;
	$user = null;
	$userId = "";
	$return = null;
	$playlist = null;
	$playlistParse = null;

	//inizializzazione valori
	$playlistParse = new PlaylistParse();
	$userParse = new UserParse();
	$return = new Response();

	if($data == null){
		stampaLog("[playlistController - getUserPlaylists] - ERRORE: Il parametro Data è NULL");
		$return->setError("Param is NULL");
		return $return;
	}



	$userId = $data->userId;
	stampaLog("[playlistController - playlistCreate] - userId: ".$userId);

	//recupero l'utente che ha effettuato la richiesta
	if( !($user = $userParse->getUserById($userId)) ){
		//errore
		stampaLog("[playlistController - getUserPlaylists] - JSON[userId]: ".$userId."  - ERRORE: Impossibile recuperare l'utente");
		$return->setError("Impossibile recuperare l'utente");
		return $return;
	}

	stampaLog("[playlistController - getUserPlaylists] - UserId: ".$user->getObjectId());


	//recupero la lista delle playlist

	if( !$playlists = $playlistParse->getUserPlaylists($user) ){
		stampaLog("[playlistController - getUserPlaylists] - JSON[userId]: ".$userId."  - ERRORE: Impossibile recuperare le playlists");

		$return->setError("Impossibile recuperare la playlist");

		return $return;

	}

	$returnlist = array();
	$i=0;
	foreach($playlists as $playlist){

		$jsonSinglePlaylist['title'] = $playlist->getName();
		$jsonSinglePlaylist['id'] = $playlist->getObjectId();

		stampaLog("[playlistController - getUserPlaylists] - Playlist[".$i."]: ID => ".$playlist->getObjectId()." - Titolo => ".$playlist->getName());

		array_push($returnlist, json_encode($jsonSinglePlaylist));
		$i++;
	}

	//return
	stampaLog("[playlistController - getUserPlaylists] - FINE");
	$return->setMessage("Playlists caricate correttamente");
	$return->setData($returnlist);
	return $return;


}


function getPlaylist($data){

	$playlistParse = null;
	$return = null;
	$songList = null;

	stampaLog("[playlistController - getPlaylist] - INIZIO");


	if(!$data){
		stampaLog("[playlistController - getUserPlaylists] - ERRORE: Il parametro Data è NULL");
		$return->setError("Param is NULL");
		return $return;
	}

	//inizializzazione valori
	$playlistParse = new PlaylistParse();
	$return = new Response();

	//recupero l'id della playlist da caricare
	$playlistId = $data->playlistId;

	stampaLog("[playlistController - getPlaylist] - IdPlaylist :".$playlistId);

	//recupero l'oggetto playlist
	if ( ($playlist = $playlistParse->getPlaylist($playlistId)) ){

		stampaLog("[playlistController - getPlaylist] - Playlist : ID => ".$playlist->getObjectId()." - Titolo => ".$playlist->getName());

		//recupero la lista delle canzoni delle playlist
		if($songList = $playlist->getSongs() ){
				
			$i=0;
			//creo un oggetto JSON per ogni canzone da inserire in un array per la risposta
			foreach($songList as $song){
					
				$jsonSingleSong['title'] = $song->getTitle();
				$jsonSingleSong['id'] = $song->getObjectId();
					
				stampaLog("[playlistController - getPlaylist] - Song[".$i."]: ID => ".$song->getObjectId()." - Titolo => ".$song->getTitle());

				//aggiungo all'array di risposta
				array_push($songList, json_encode($jsonSinglePlaylist));
				$i++;
			}
		}

		//preparo l'oggetto per la risposta
		$jsonPlaylist = array();
		$jsonPlaylist['name'] = $playlist->getName();
		$jsonPlaylist['id'] = $playlist->getObjectId();
		$jsonPlaylist['songs'] = $songList;

		//JSON encodizzo
		$return->setData(json_encode($jsonPlaylist));
		//setto un messaggio di conferma
		$return->setMessage("Playlist caricata correttamente! Numero Canzoni: ".count($songList));


	}else{
		$return->setError("Impossibile recuperare la playlist richiesta");
		return $return;
	}

	//restituisco!
	return $return;

}

function getSong($data){

	stampaLog("[playlistController - getSong] - INIZIO");

	//variabili locali
	$song = null;
	$jsonSongle = null;
	$songParse = null;
	$songId = null;

	//inizializzazione valori
	$songParse = new SongParse();

	if($data == null){
		stampaLog("[playlistController - getSong] - ERRORE: Il parametro Data è NULL");
		$return->setError("Param is NULL");
		return $return;
	}



	$songId = $data->songId;
	stampaLog("[playlistController - getSong] - songId: ".$songId);

	//recupero l'utente che ha effettuato la richiesta
	if( !($song = $songParse->getSong($songId)) ){
		//errore
		stampaLog("[playlistController - getSong] - Data[SongId]: ".$songId."  - ERRORE: Impossibile recuperare la canzone");
		$return->setError("Impossibile recuperare la canzone");
		return $return;
	}

	stampaLog("[playlistController - getSong] - Titolo Canzone: ".$song->getTitle());
	$jsonSongle = array();
	$jsonSongle['title'] = $song->getTitle();
	$jsonSongle['id'] = $playlist->getObjectId();

	//return
	stampaLog("[playlistController - getSong] - FINE");
	$return->setMessage("Playlists caricate correttamente");
	$return->setData(json_encode($jsonSongle));

	return $return;


}

function addSongToPlaylist($data){
	$song = null;
	$user = null;
	$playlist = null;
	$userId = null;
	$songId = null;
	$playlistId = null;
	
	stampaLog("[playlistController - addSongToPlaylist] - INIZIO");
	if($data == null){
		stampaLog("[playlistController - addSongToPlaylist] - ERRORE: Il parametro Data è NULL");
		$return->setError("Param is NULL");
		return $return;
	}	
	
	//inizializzazione valori
	$songParse = new SongParse();
	$playlistParse = new PlaylistParse();
	$userParse = new UserParse();
	
	$userId = $data->userId;
	$songId = $data->songId;
	$playlistId = $data->playlistId;
	
	stampaLog("[playlistController - addSongToPlaylist] - songId: ".$songId);
	
	//recupero l'utente che ha effettuato la richiesta
	if( !($user = $userParse->getUserById($userId) ) ){
		//errore
		stampaLog("[playlistController - addSongToPlaylist] - Data[userId]: ".$userId."  - ERRORE: Impossibile recuperare l'utente");
		$return->setError("Impossibile recuperare l'utente");
		return $return;
	}	
	//recupero la playlist
	if( !($playlist = $playlistParse->getPlaylist($playlistId) )){
		//errore
		stampaLog("[playlistController - addSongToPlaylist] - Data[playlistId]: ".$playlistId."  - ERRORE: Impossibile recuperare la playlist");
		$return->setError("Impossibile recuperare la playlist");
		return $return;
	}
	
	//verifico se l'utente è proprietario della playlist
	$fromUser = $playlist->getFromUser();
	if($user->getObjectId() != $fromUser->getObjectId()){
		//errore
		stampaLog("[playlistController - addSongToPlaylist] - ERRORE: UserId =".$user->getObjectId()." divero da FromUser della playlist = ".$fromUser->getObjectId());
		$return->setError("Non sei autorizzato a modificare la playlist");
		return $return;
	}
	
	//se l'utente non è premium può mettere al max 20 canzoni
	$songList = $playlist->getSongs();
	
	//recupero la canzone
	if( !($song = $songParse->getSong($songId)) ){
		//errore
		stampaLog("[playlistController - addSongToPlaylist] - Data[SongId]: ".$songId."  - ERRORE: Impossibile recuperare la canzone");
		$return->setError("Impossibile recuperare la canzone");
		return $return;
	}
		
	if(count($songList)<=20 || $user->getPremium() || $playlist->getUnlimited()){
		//aggiungo la canzone in posizione [0]
		array_unshift($songList, $song);
		
		
	}else{
		
		//togli & aggiungi in testa
		array_pop($songList);
		array_unshift($songList, $song);
	}
	
	//return
	stampaLog("[playlistController - addSongToPlaylist] - FINE");
	$return->setMessage("Canzone caricata correttamente");
	$return->setData(json_encode(true));
	
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