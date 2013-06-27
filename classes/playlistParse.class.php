<?php

/* ! \par Info Generali:
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
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'utils.php';
require_once CLASSES_DIR . 'playlist.class.php';

class PlaylistParse {

    private $parseQuery;
	
	/**
	 * \fn		void __construct()
	 * \brief	The constructor instantiates a new object of type ParseQuery on the Playlist class
	 */
    function __construct() {

        $this->parseQuery = new ParseQuery("Playlist");
    }
	
	/**
	 * \fn		void deletePlaylist(string $objectId)
	 * \brief	Set unactive a specified Playlist by objectId
	 * \param   $objectId the string that represent the objectId of the Playlist
	 * \return	error in case of exception
	 */
    public function deletePlaylist($objectId) {
        try {
            $parsePlaylist = new parseObject('Playlist');
            $parsePlaylist->active = false;
            $parsePlaylist->update($objectId);
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

	/**
	 * \fn		number getCount()
	 * \brief	Returns the number of requests Playlist
	 * \return	number
	 */
    public function getCount() {
        return $this->parseQuery->getCount()->count;
    }
	
	/**
	 * \fn		void getPlaylist(string $objectId)
	 * \brief	The function returns the Playlist object specified
	 * \param	$objectId the string that represent the objectId of the Playlist
	 * \return	Playlist	the Playlist with the specified $objectId
	 * \return	Error	the Error raised by the function
	 */
    public function getPlaylist($objectId) {
        try {
            $parsePlaylist = new parseObject('Playlist');
            $res = $parsePlaylist->get($objectId);
            $playlist = $this->parseToPlaylist($res);
            return $playlist;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args);
        }
    }

	/**
	 * \fn		array getPlaylists()
	 * \brief	The function returns the Playlists objects specified
	 * \return	array 	an array of Playlist, if one or more Playlist are found
	 * \return	null	if no Playlist are found
	 * \return	Error	the Error raised by the function
	 */
     public function getPlaylists() {
        $playlists = null;
        try {
            $res = $this->parseQuery->find();
            if (is_array($res->results) && count($res->results) > 0) {
                $playlists = array();
                foreach ($res->results as $obj) {
                    if ($obj) {
                        $playlist = $this->parseToPlaylist($obj);
                        $playlists[$playlist->getObjectId] = $playlist;
                    }
                }
            }
            return $playlists;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

	/**
	 * \fn		void orderBy($field)
	 * \brief	Specifies which field need to be ordered of requested Playlist
	 * \param	$field	the field on which to sort
	 */
	public function orderBy($field) {
		$this->parseQuery->orderBy($field);
	}	
	
	/**
	 * \fn		void orderByAscending($field)
	 * \brief	Specifies which field need to be ordered ascending of requested Playlist
	 * \param	$field	the field on which to sort ascending
	 */
	public function orderByAscending($field) {
		$this->parseQuery->orderByAscending($field);
	}
	
	/**
	 * \fn		void orderByDescending($field)
	 * \brief	Specifies which field need to be ordered descending of requested Playlist
	 * \param	$field	the field on which to sort descending
	 */
	public function orderByDescending($field) {
		$this->parseQuery->orderByDescending($field);
	}
	
	/**
	 * \fn		Playlist parseToPlaylist($res)
	 * \brief	The function returns a representation of an Playlist object in Parse
	 * \param	$res 	represent the Playlist object returned from Parse
	 * \return	Playlist	the Playlist object
	 * \return	Error	the Error raised by the function
	 */
    function parseToPlaylist($res) {
        if (is_null($res))
		return throwError(new Exception('parseToPlaylist parameter is unset'), __CLASS__, __FUNCTION__, func_get_args());
        try {
            $playlist = new Playlist();
            $playlist->setObjectId($res->objectId);
            $playlist->setActive($res->active);
            $playlist->setFromUser(fromParsePointer($res->fromUser));
            $playlist->setName($res->name);
            $playlist->setSongs(fromParseRelation("Playlist", "songs", $res->objectId, "Song"));
            $playlist->setUnlimited($res->unlimited);
            $playlist->setCreatedAt(fromParseDate($res->createdAt));
            $playlist->setUpdatedAt(fromParseDate($res->updatedAt));
            $playlist->setACL(fromParseACL($res->ACL));
            return $playlist;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args);
        }
    }

	/**
	 * \fn		Playlist savePlaylist(Playlist $playlist)
	 * \brief	This function save an Playlist object in Parse
	 * \param	$playlist 	represent the Playlist object to save
	 * \return	Playlist	the Playlist object with the new objectId parameter saved
	 * \return	Error	the Error raised by the function
	 */
    public function savePlaylist($playlist) {
        try {

            $parsePlaylist = new parseObject('Playlist');
            is_null($playlist->getActive()) ? $parsePlaylist->active = true : $parsePlaylist->active = $playlist->getActive();
            is_null($playlist->getFromUser()) ? $parsePlaylist->fromUser = null : $parsePlaylist->fromUser = toParsePointer('_User', $playlist->getFromUser());
            is_null($playlist->getName()) ? $parsePlaylist->name = null : $parsePlaylist->name = $playlist->getName();
            is_null($playlist->getSongs()) ? $parsePlaylist->songs = null : $parsePlaylist->songs = toParseRelation('Song', $playlist->getSongs());
            is_null($playlist->getUnlimited()) ? $parsePlaylist->unlimited = false : $parsePlaylist->unlimited = $playlist->getUnlimited();
	    $acl = new ParseACL();
	    $acl->setPublicReadAccess(true);
            $acl->setPublicWriteAccess(true);
            is_null($playlist->getACL()) ? $parsePlaylist->ACL = $acl : $parsePlaylist->ACL = toParseACL($playlist->getACL());
            if ($playlist->getObjectId() == '') {
                $res = $parsePlaylist->save();
                $playlist->setObjectId($res->objectId);
                return $playlist;
            } else {
                $parsePlaylist->update($playlist->getObjectId());
            }
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

    /**
	 * \fn		void setLimit($limit)
	 * \brief	Sets the maximum number of Playlist to return
	 * \param	$limit	the maximum number
	 */
	public function setLimit($limit) {
		$this->parseQuery->setLimit($limit);
	}
	
	/**
	 * \fn		void setSkip($skip)
	 * \brief	Sets the number of how many Playlist(s) must be discarded initially
	 * \param	$skip	the number of Playlist(s) to skip
	 */
	public function setSkip($skip) {
		$this->parseQuery->setSkip($skip);
	}
	
	/**
	 * \fn		void where($field, $value)
	 * \brief	Sets a condition for which the field $field must value $value
	 * \param	$field	the string which represent the field
	 * \param	$value	the string which represent the value
	 */
	public function where($field, $value) {
		$this->parseQuery->where($field, $value);
	}
	
	/**
	 * \fn		void whereContainedIn($field, $value)
	 * \brief	Sets a condition for which the field $field must value one or more $value
	 * \param	$field	the string which represent the field
	 * \param	$value	the array which represent the values
	 */
	public function whereContainedIn($field, $values) {
		$this->parseQuery->whereContainedIn($field, $values);
	}
	
	/**
	 * \fn		void whereEqualTo($field, $value)
	 * \brief	Sets a condition for which the field $field must value $value
	 * \param	$field	the string which represent the field
	 * \param	$value	the string which represent the value
	 */
	public function whereEqualTo($field, $value) {
		$this->parseQuery->whereEqualTo($field, $value);
	}
	
	/**
	 * \fn		void whereExists($field)
	 * \brief	Sets a condition for which the field $field must be enhanced
	 * \param	$field	the string which represent the field
	 */
	public function whereExists($field) {
		$this->parseQuery->whereExists($field);
	}	
	
	/**
	 * \fn		void whereGreaterThan($field, $value)
	 * \brief	Sets a condition for which the field $field must value more than $value
	 * \param	$field	the string which represent the field
	 * \param	$value	the string which represent the value
	 */
	public function whereGreaterThan($field, $value) {
		$this->parseQuery->whereGreaterThan($field, $value);
	}
	
	/**
	 * \fn		void whereGreaterThanOrEqualTo($field, $value)
	 * \brief	Sets a condition for which the field $field must value equal or more than $value
	 * \param	$field	the string which represent the field
	 * \param	$value	the string which represent the value
	 */
	public function whereGreaterThanOrEqualTo($field, $value) {
		$this->parseQuery->whereGreaterThanOrEqualTo($field, $value);
	}
	
	/**
	 * \fn		void whereLessThan($field, $value)
	 * \brief	Sets a condition for which the field $field must value less than $value
	 * \param	$field	the string which represent the field
	 * \param	$value	the string which represent the value
	 */
	public function whereLessThan($field, $value) {
		$this->parseQuery->whereLessThan($field, $value);
	}
	
	/**
	 * \fn		void whereLessThanOrEqualTo($field, $value)
	 * \brief	Sets a condition for which the field $field must value equal or less than $value
	 * \param	$field	the string which represent the field
	 * \param	$value	the string which represent the value
	 */
	public function whereLessThanOrEqualTo($field, $value) {
		$this->parseQuery->whereLessThanOrEqualTo($field, $value);
	}
	
	/**
	 * \fn		void whereNotContainedIn($field, $value)
	 * \brief	Sets a condition for which the field $field must not value one or more $value
	 * \param	$field	the string which represent the field
	 * \param	$value	the array which represent the values
	 */
	public function whereNotContainedIn($field, $array) {
		$this->parseQuery->whereNotContainedIn($field, $array);
	}
	
	/**
	 * \fn		void whereNotEqualTo($field, $value)
	 * \brief	Sets a condition for which the field $field must not value $value
	 * \param	$field	the string which represent the field
	 * \param	$value	the string which represent the value
	 */
	public function whereNotEqualTo($field, $value) {
		$this->parseQuery->whereNotEqualTo($field, $value);
	}
	
	/**
	 * \fn		void whereNotExists($field)
	 * \brief	Sets a condition for which the field $field must not be enhanced
	 * \param	$field	the string which represent the field
	 */
	public function whereNotExists($field) {
		$this->parseQuery->whereDoesNotExist($field);
	}

	/**
	 * \fn		void wherePointer($field, $className, $objectId)
	 * \brief	Sets a condition for which the field $field must contain a Pointer to the class $className with pointer value $objectId
	 * \param	$field		the string which represent the field
	 * \param	$className	the string which represent the className of the Pointer
	 * \param	$objectId	the string which represent the objectId of the Pointer
	 */
	public function wherePointer($field, $className, $objectId) {
		$this->parseQuery->wherePointer($field, $className, $objectId);
	}
		
	public function whereRelatedTo($field, $className, $objectId) {
		$this->parseQuery->whereRelatedTo($field, $className, $objectId);
	}

}

?>