<?php
class PlaylistParse{

	private $parseQuery;

	function __construct(){
			
		$this->parseQuery = new ParseQuery("Playlist");
			
	}

	/**
	 *
	 * @param Playlist $playlist
	 * @return boolean|Playlist
	 */
	function save(Playlist $playlist){
			
		//creo un'istanza dell'oggetto della libreria ParseLib
		$parseObj = new parseObject("Album");
			
		//inizializzo le properties

		//boolean
		$parseObj->active = $playlist->getActive();

		//User
		if($playlist->getToUser()){
			$toUser = $playlist->getToUser();
			$pointerParse = new PointerParse("_User", $toUser->getObjectId());
			$parseObj->toUser = $pointerParse->getPointer();
		}

		//Array di Song
		$parseObj->songs = array();		

		if($playlist->getSongs()){
			$songList = $playlist->getSongs();
			foreach($songList as $song){
				$pointerParse = new PointerParse("Song", $song->getObjectId());
				array_push($parseObj->songs, $pointerParse->getPointer());
			}
		}

		//boolean
		$parseObj->unlimited = $playlist->getUnlimited();

			
			
		if( $playlist->getObjectId()!=null ){

			try{
				$ret = $parseObj->update($playlist->getObjectId());
					
				$playlist->setObjectId($playlist->objectId);
					
				$playlist->setUpdatedAt($playlist->createdAt);
					
				$playlist->setCreatedAt($playlist->createdAt);
			}
			catch(ParseLibraryException $e){
					
				return false;
					
			}

		}
		else{
			//caso save
			try{

				$ret = $parseObj->save();
					
				$playlist->setUpdatedAt(new DateTime($ret->createdAt, new DateTimeZone("America/Los_Angeles")));
					
			}
			catch(ParseLibraryException $e){
					
				return false;
					
			}

		}
			
		return $playlist;
	}


	/**
	 *
	 * @param string $playlistId
	 * @return Ambigous <NULL, Playlist>
	 */
	function getPlaylist($playlistId){

		$playlist = null;

		$this->parseQuery->where('objectId', $playlistId);

		$result = $this->parseQuery->find();

		if (is_array($result->results) && count($result->results)>0){

			$ret = $result->results[0];

			if($ret){

				//recupero l'utente
				$playlist = $this->parseToPlaylist($ret);

			}

		}

		return $playlist;
	}
	
	public function getUserPlaylists(User $user){
		
		$this->parseQuery->wherePointer('fromUser','_User', $user->getObjectId());
		
		$result = $this->parseQuery->find();
		
		if (is_array($result->results) && count($result->results)>0){
			$ret = array();
		
			foreach($result->results as $playlist){
				
				array_push($ret,  $this->parseToPlaylist($playlist));
			}
		
		}
		
		return $ret;
	}


	/**
	 *
	 * @param Playlist $playlist
	 * @return boolean
	 */
	function delete(Playlist $playlist){
		if($playlist){
			$playlist->setActive(false);

			if( $this->save($playlist) ) return true;
			else return false;
		}
		else return false;
	}

	/**
	 *
	 * @param stdClass $parseObj
	 * @return Playlist
	 */
	function parseToPlaylist(stdClass $parseObj){

		$playlist = new Playlist();

		//specifiche

		if(isset($parseObj->toUser ) ){
			$parseUser = new UserParse();
			$pointer = $parseObj->toUser;
			$toUser = $parseUser->getUserById($pointer->getObjectId());
			$playlist->setToUser($toUser);
		}
		if(isset($parseObj->active ) )$playlist->setActive($parseObj->active);
		if(isset($parseObj->unlimited ) )$playlist->setUnlimited($parseObj->unlimited);

		if(isset($parseObj->song ) ){
			$parseSong =  new SongParse();
			$songs = array();
			foreach ($parseObj->songs as $songId){
				$song = $parseSong->getSong($songId);
				array_push($array, $var);
			}
			$playlist->setSongs($songs);
		}
			

		//generali

		if(isset($parseObj->objectId)) $playlist->setObjectId($parseObj->objectId) ;

		if(isset($parseObj->createdAt)){

			$createdAt = new DateTime($parseObj->createdAt);

			$playlist->setCreatedAt($createdAt)  ;
		}

		if(isset($parseObj->updatedAt)){
			$updatedAt = new DateTime( $parseObj->updatedAt );

			$playlist->setUpdatedAt($updatedAt)  ;
		}
		if(isset($parseObj->ACL)){

			$ACL = null;

			$playlist->setACL($ACL)  ;
		}

		return $playlist;
	}
}

?>