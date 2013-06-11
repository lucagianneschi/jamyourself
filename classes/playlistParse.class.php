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

	public function getPlaylist() {
        $playlist = null;
        $result = $this->parseQuery->find();
        if (is_array($result->results) && count($result->results) > 0) {
            $ret = $result->results[0];
            if ($ret) {
                //recupero l'utente
                $playlist = $this->parseToPlaylist($ret);
            }
        }
        return $playlist;
    }

    public function getPlaylists() {
        $playlists = null;
        $result = $this->parseQuery->find();
        if (is_array($result->results) && count($result->results) > 0) {
            $playlists = array();
            foreach (($result->results) as $playlist) {
                $playlists; [] = $this->parseToPlaylist($playlist);
            }
        }
        return $playlists;
    }
	/**
	 *
	 * @param Playlist $playlist
	 * @return boolean|Playlist
	 */
	function savePlaylist(Playlist $playlist){
			
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
			catch(Exception $e){
				$error = new error();
                $error->setErrorClass(__CLASS__);
                $error->setErrorCode($e->getCode());
                $error->setErrorMessage($e->getMessage());
                $error->setErrorFunction(__FUNCTION__);
                $error->setErrorFunctionParameter(func_get_args());
                $errorParse = new errorParse();
                $errorParse->saveError($error);
                return $error;		
			}
		}
		else{
			//caso update
			try{
				$ret = $parseObj->update($playlist->getObjectId());	
				$playlist->setUpdatedAt(new DateTime($ret->updatedAt, new DateTimeZone("America/Los_Angeles")));	
			}
			catch(Exception $e){
				$error = new error();
                $error->setErrorClass(__CLASS__);
                $error->setErrorCode($e->getCode());
                $error->setErrorMessage($e->getMessage());
                $error->setErrorFunction(__FUNCTION__);
                $error->setErrorFunctionParameter(func_get_args());
                $errorParse = new errorParse();
                $errorParse->saveError($error);
                return $error;;		
			}
		}
		return $playlist;
	}
	/**
	 *
	 * @param Playlist $playlist
	 * @return boolean
	 */
	function deletePlaylist(Playlist $playlist){
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
		if(isset($parseObj->active))$playlist->setActive($parseObj->active);
		if(isset($parseObj->fromUser) ){
			$parseQueryUser = new UserParse();
			$parseQueryUser->whereEqualTo("objectId",$parseObj->fromUser);
			$playlist->setFromUser($parseQueryUser);
		}
        if(isset($parseObj->name)) $playlist->setName($parseObj->name);
		if (isset($parseObj->songs)) {
            $parseQuerySong = new SongParse();
            $parseQuerySong->whereRelatedTo("songs", "Playlist", $parseObj->objectId);
            $playlist->setSongs($parseQuerySong->getSongs());
        }
		if(isset($parseObj->unlimited ) ){
		$playlist->setUnlimited($parseObj->unlimited);
		} else {
		$playlist->unlimited = false;
		}
		if (isset($parseObj->createdAt))
            $video->setCreatedAt(new DateTime($parseObj->createdAt, new DateTimeZone("America/Los_Angeles")));
        if (isset($parseObj->updatedAt))
            $video->setUpdatedAt(new DateTime($parseObj->updatedAt, new DateTimeZone("America/Los_Angeles")));
		$acl = new parseACL();
        $acl->setPublicReadAccess(true);
        $acl->setPublicWriteAccess(true);
        $playlist->setACL($acl);
		}
		return $playlist;
	}
	public function getCount() {
        $this->parseQuery->getCount();
    }

    public function setLimit($int) {
        $this->parseQuery->setLimit($int);
    }

    public function setSkip($int) {
        $this->parseQuery->setSkip($int);
    }

    public function orderBy($field) {
        $this->parseQuery->orderBy($field);
    }

    public function orderByAscending($value) {
        $this->parseQuery->orderByAscending($value);
    }

    public function orderByDescending($value) {
        $this->parseQuery->orderByDescending($value);
    }

    public function whereInclude($value) {
        $this->parseQuery->whereInclude($value);
    }

    public function where($key, $value) {
        $this->parseQuery->where($key, $value);
    }

    public function whereEqualTo($key, $value) {
        $this->parseQuery->whereEqualTo($key, $value);
    }

    public function whereNotEqualTo($key, $value) {
        $this->parseQuery->whereNotEqualTo($key, $value);
    }

    public function whereGreaterThan($key, $value) {
        $this->parseQuery->whereGreaterThan($key, $value);
    }

    public function whereLessThan($key, $value) {
        $this->parseQuery->whereLessThan($key, $value);
    }

    public function whereGreaterThanOrEqualTo($key, $value) {
        $this->parseQuery->whereGreaterThanOrEqualTo($key, $value);
    }

    public function whereLessThanOrEqualTo($key, $value) {
        $this->parseQuery->whereLessThanOrEqualTo($key, $value);
    }

    public function whereContainedIn($key, $value) {
        $this->parseQuery->whereContainedIn($key, $value);
    }

    public function whereNotContainedIn($key, $value) {
        $this->parseQuery->whereNotContainedIn($key, $value);
    }

    public function whereExists($key) {
        $this->parseQuery->whereExists($key);
    }

    public function whereDoesNotExist($key) {
        $this->parseQuery->whereDoesNotExist($key);
    }

    public function whereRegex($key, $value, $options = '') {
        $this->parseQuery->whereRegex($key, $value, $options = '');
    }

    public function wherePointer($key, $className, $objectId) {
        $this->parseQuery->wherePointer($key, $className, $objectId);
    }

    public function whereInQuery($key, $className, $inQuery) {
        $this->parseQuery->whereInQuery($key, $className, $inQuery);
    }

    public function whereNotInQuery($key, $className, $inQuery) {
        $this->parseQuery->whereNotInQuery($key, $className, $inQuery);
    }

    public function whereRelatedTo($key, $className, $objectId) {
        $this->parseQuery->whereRelatedTo($key, $className, $objectId);
    }
}
?>