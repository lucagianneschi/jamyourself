<?php
/*! \par Info Generali:
 *  \author    Stefano Muscas
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par Info Classe:
 *  \brief     PlayslistParse
 *  \details   Classe che accoglie le canzoni che andranno nel player della pagina utente
 *  
 *  \par Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:playlist">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:playlist">API</a>
 */
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
		$parseObj = new parseObject("Playlist");
			
		//inizializzo le properties

		//boolean
		$parseObj->active = $playlist->getActive();
		//User
		if($playlist->getFromUser()){
			$fromUser = $playlist->getFromUser();
			$pointerParse = new PointerParse("_User", $fromUser->getObjectId());
			$parseObj->fromUser = $pointerParse->getPointer();
		}

		$parseObj->name = $playlist->getName();		

                
                if($playlist->getSongs() != null && count($playlist->getSongs())>0){
			$songList = $playlist->getSongs();
			foreach($songList as $song){
				$parseObj->songs->__op = "AddRelation";
				$parseObj->songs->objects = array(array("__type" => "Pointer", "className" => "Song", "objectId" => ($song ->getObjectId())));
			}
		} else {
                    $parseObj->tags = null;   
                }

		//boolean
		$parseObj->unlimited = $playlist->getUnlimited();

		if( $playlist->getObjectId()==null ){

			try{
				//caso save
				$ret = $parseObj->save();
					
				$playlist->setObjectId($ret->objectId);
					
				$playlist->setUpdatedAt(new DateTime($ret->createdAt, new DateTimeZone("America/Los_Angeles")));
					
				$playlist->setCreatedAt(new DateTime($ret->createdAt, new DateTimeZone("America/Los_Angeles")));
			}
			catch(ParseLibraryException $e){
					
				return false;		
			}

		}
		else{
			//caso update
			try{

				$ret = $parseObj->update($playlist->getObjectId());	
				$playlist->setUpdatedAt(new DateTime($ret->updatedAt, new DateTimeZone("America/Los_Angeles")));
					
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

		if(isset($parseObj->objectId)) $playlist->setObjectId($parseObj->objectId) ;
	
		if(isset($parseObj->active ) )$playlist->setActive($parseObj->active);

		if(isset($parseObj->fromUser ) ){
			$parseUser = new UserParse();
			$pointer = $parseObj->fromUser;
			$fromUser = $parseUser->getUserById($pointer->objectId);
			$playlist->setFromUser($fromUser);
		}
		
                if(isset($parseObj->name)) $playlist->setName($parseObj->name);

		if(isset($parseObj->songs ) ){
			foreach ($parseObj->songs as $song){
				$playlist->songs->__op = "AddRelation";
				$playlist->songs->objects = array(array("__type" => "Pointer", "className" => "Song", "objectId" => ($song ->getObjectId())));
			}
		}

		if(isset($parseObj->unlimited ) )$playlist->setUnlimited($parseObj->unlimited);
		//generali

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