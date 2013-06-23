<?php
/* ! \par Info Generali:
 *  \author    Stefano Muscas
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par Info Classe:
 *  \brief     Stutus Parse Class
 *  \details   Classe Parse dedicata allo status dello User
 *
 *  \par Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:status">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:status">API</a>
 */

if (!defined('ROOT_DIR'))
	define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'utils.class.php';

require_once CLASSES_DIR . 'commentParse.class.php';

class UserParse {

    private $parseQuery;

    public function __construct() {
        $this->parseQuery = new ParseQuery('_User');
    }
	
    public function deleteUser($objectId) {
		try {
			$parseUser = new parseUser();
			$res = $parseUser->get($objectId);
			$user = $this->parseToUser($res);
			
			//delete properties User
			foreach($user->getAlbums() as $albumObjectId) {
				$albumParse = new AlbumParse();
				$albumParse->deleteAlbum($albumObjectId);
			}
			foreach($user->getComments() as $cmtObjectId) {
				$cmtParse = new CommentParse();
				$cmtParse->deleteComment($cmtObjectId);
			}
			foreach($user->getImages() as $imageObjectId) {
				$imageParse = new ImageParse();
				$imageParse->deleteImage($imageObjectId);
			}
			foreach($user->getPlaylists() as $plObjectId) {
				$plParse = new PlaylistParse();
				$plParse->deletePlaylist($plObjectId);
			}
			foreach($user->getStatuses() as $statusObjectId) {
				$statusParse = new StatusParse();
				$statusParse->deleteStatus($statusObjectId);
			}
			
			if ($user->getType == 'VENUE') {
				//delete properties Venue
				foreach($user->getEvents() as $eventObjectId) {
					$eventParse = new EventParse();
					$eventParse->deleteEvent($eventObjectId);
				}
			} elseif ($res->type == 'JAMMER') {
				//delete properties Jammer
				foreach($user->getEvents() as $eventObjectId) {
					$eventParse = new EventParse();
					$eventParse->deleteEvent($eventObjectId);
				}
				foreach($user->getRecords() as $recordObjectId) {
					$recordParse = new RecordParse();
					$recordParse->deleteRecord($recordObjectId);
				}
				foreach($user->getSongs() as $songObjectId) {
					$songParse = new SongParse();
					$songParse->deleteSong($songObjectId);
				}
			} elseif ($res->type == 'SPOTTER') {
				//delete properties Spotter
			}
			$user->setActive(false);
			$this->saveUser($user);
		} catch (Exception $e) {
			return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
		}
    }
	
	public function getCount() {
		return $this->parseQuery->getCount()->count;
	}

	public function getUser($objectId) {
		try {
			$parseObject = new parseObject('_User');
			$res = $parseObject->get($objectId);
			$user = $this->parseToUser($res);
			return $user;
		} catch (Exception $e) {
			return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
		}
    }

    public function getUsers() {
		try {
			$users = null;
			$res = $this->parseQuery->find();
			if (is_array($res->results) && count($res->results) > 0) {
				$users = array();
				foreach ($res->results as $obj) {
					$user = $this->parseToUser($obj);
					$users[$user->getObjectId()] = $user;
				}
			}
			return $users;
		} catch (Exception $e) {
			return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
		}
    }

	#############
	# INVARIATA #
	#############
	# Apparentemente non credo che funzioni perchè la chiamata getUser non ha nessun parametro impostato.
    /**
     * Effettua il login dell'utente fornendo un utente che deve avere qualche parametro impostato, dopodich� creo uno User specifico
     * e lo restituisco.
     */
    public function login($login, $password) {

        //login tramite username o email
        if (filter_var("some@address.com", FILTER_VALIDATE_EMAIL)) {
            // valid address
            $this->parseQuery->where("email", $login);
        } else {
            // invalid address
            $this->parseQuery->where("username", $login);
        }
        $user = $this->getUser();

        if ($user != null) {
            $parse = new parseUser();
            $parse->username = $user->getUsername();
            $parse->password = $password;
            try {
                $ret = $parse->login();
                return $this->parseToUser($ret);
            } catch (Exception $e) {
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
        } else {
            return null;
        }
        return $user;
    }
	
	public function loginUser($username, $password) {
		try {
			$parseUser = new parseUser();
			$parseUser->username = $username;
			$parseUser->password = $password;
			$ret = $parseUser->login();
			$user = $this->parseToUser($ret);
			return $user;
		} catch (Exception $e) {
			return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
		}
    }

	public function orderBy($field) {
		$this->parseQuery->orderBy($field);
	}	
 
	public function orderByAscending($field) {
		$this->parseQuery->orderByAscending($field);
	}
 
	public function orderByDescending($field) {
		$this->parseQuery->orderByDescending($field);
	}
 
	public function parseToUser($res) {
		if ($res == null || !isset($res->objectId))
			return throwError(new Exception('parseToUser parameter is unset'), __CLASS__, __FUNCTION__, func_get_args());
		try {
			if ($res->type == 'VENUE') {
				$user = new Venue();
				//properties Venue
				$user->setAddress($res->address);
				$user->setCollaboration(fromParseRelation('_User', 'collaboration', $res->objectId, '_User'));
				$user->setEvents(fromParseRelation('_User', 'events', $res->objectId, 'Event'));
				$user->setLocalType($res->localType);
			} elseif ($res->type == 'JAMMER') {
				$user = new Jammer();
				//properties Jammer
				$user->setCollaboration(fromParseRelation('_User', 'collaboration', $res->objectId, '_User'));
				$user->setEvents(fromParseRelation('_User', 'events', $res->objectId, 'Event'));
				$user->setJammerType($res->jammerType);
				$user->setMembers($res->members);
				$user->setRecords(fromParseRelation('_User', 'records', $res->objectId, 'Record'));
				$user->setSongs(fromParseRelation('_User', 'songs', $res->objectId, 'Song'));
			} elseif ($res->type == 'SPOTTER') {
				$user = new Spotter();
				//properties Spotter
				// TODO - attualmente la data di nascita è gestita come una normale Date, ma deve essere gestita staticamente!!!
				$user->setBirthDay(new DateTime($res->birthDay));
				$user->setFacebookId($res->facebookId);
				$user->setFirstname($res->firstname);
				$user->setFollowing(fromParseRelation('_User', 'following', $res->objectId, '_User'));
				$user->setFriendship(fromParseRelation('_User', 'friendship', $res->objectId, '_User'));
				$user->setLastname($res->lastname);
				$user->setSex($res->sex);
			}
			
			//properties User
			$user->setObjectId($res->objectId);
			$user->setUsername($res->username);
			$user->setPassword($res->password);
			$user->setAuthData($res->authData);
			$user->setEmailVerified($res->emailVerified);
			$user->setActive($res->active);
			$user->setAlbums(fromParseRelation('_User', 'albums', $res->objectId, 'Album'));
			$user->setBackground($res->background);
			$user->setCity($res->city);
			$user->setComments(fromParseRelation('_User', 'comments', $res->objectId, 'Comment'));
			$user->setCountry($res->country);
			$user->setDescription($res->description);
			$user->setEmail($res->email);
			$user->setFbPage($res->fbPage);
			$user->setGeoCoding(fromParseGeoPoint($res->geoCoding));
			$user->setImages(fromParseRelation('_User', 'images', $res->objectId, 'Image'));
			$user->setLevel($res->level);
			$user->setLevelValue($res->levelValue);
			$user->setLoveSongs(fromParseRelation('_User', 'loveSongs', $res->objectId, 'Song'));
			$user->setMusic($res->music);
			$user->setPlaylists(fromParseRelation('_User', 'playlist', $res->objectId, 'Playlist'));
			$user->setPremium($res->premium);
			$user->setPremiumExpirationDate(fromParseDate($res->premiumExpirationDate));
			$user->setProfilePicture($res->profilePicture);
			$user->setProfilePictureFile($res->profilePictureFile);
			$user->setProfileThumbnail($res->profileThumbnail);
			$user->setSessionToken($res->sessionToken);
			$user->setSettings($res->settings);
			$user->setStatuses(fromParseRelation('_User', 'statuses', $res->objectId, 'Status'));
			$user->setTwitterPage($res->twitterPage);
			$user->setType($res->type);
			$user->setVideos(fromParseRelation('_User', 'videos', $res->objectId, 'Video'));
			$user->setWebsite($res->website);
			$user->setYoutubeChannel($res->youtubeChannel);
			$user->setCreatedAt(new DateTime($res->createdAt));
			$user->setUpdatedAt(new DateTime($res->updatedAt));
			$user->setACL(fromParseACL($res->ACL));
			
			return $user;
		} catch (Exception $e) {
			return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
		}
	}
	
	public function saveUser($user) {
		try {
			$parseUser = new parseUser();
			
			//properties User
			is_null($user->getUsername()) ? $parseUser->username = null : $parseUser->username = $user->getUsername();
			is_null($user->getPassword()) ? $parseUser->password = null : $parseUser->password = $user->getPassword();
			# is_null($user->getAuthData()) ? $parseUser->authData = null : $parseUser->authData = $user->getAuthData();
			# is_null($user->getEmailVerified()) ? $parseUser->emailVerified = null : $parseUser->emailVerified = $user->getEmailVerified();
			is_null($user->getActive()) ? $parseUser->active = null : $parseUser->active = $user->getActive();
			is_null($user->getAlbums()) ? $parseUser->albums = null : $parseUser->albums = toParseRelation('Album', $user->getAlbums());
			is_null($user->getBackground()) ? $parseUser->background = null : $parseUser->background = $user->getBackground();
			is_null($user->getCity()) ? $parseUser->city = null : $parseUser->city = $user->getCity();
			is_null($user->getComments()) ? $parseUser->comments = null : $parseUser->comments = toParseRelation('Comment', $user->getComments());
			is_null($user->getCountry()) ? $parseUser->country = null : $parseUser->country = $user->getCountry();
			is_null($user->getDescription()) ? $parseUser->description = null : $parseUser->description = $user->getDescription();
			is_null($user->getEmail()) ? $parseUser->email = null : $parseUser->email = $user->getEmail();
			is_null($user->getFbPage()) ? $parseUser->fbPage = null : $parseUser->fbPage = $user->getFbPage();
			is_null($user->getGeoCoding()) ? $parseUser->geoCoding = null : $parseUser->geoCoding = toParseGeoPoint($user->getGeoCoding());
			is_null($user->getImages()) ? $parseUser->images = null : $parseUser->images = toParseRelation('Image', $user->getImages());
			is_null($user->getLevel()) ? $parseUser->level = null : $parseUser->level = $user->getLevel();
			is_null($user->getLevelValue()) ? $parseUser->levelValue = null : $parseUser->levelValue = $user->getLevelValue();
			is_null($user->getLoveSongs()) ? $parseUser->loveSongs = null : $parseUser->loveSongs = toParseRelation('Song', $user->getLoveSongs());
			is_null($user->getMusic()) ? $parseUser->music = null : $parseUser->music = $user->getMusic();
			is_null($user->getPlaylists()) ? $parseUser->playlists = null : $parseUser->playlists = toParseRelation('Playlist', $user->getPlaylists());
			is_null($user->getPremium()) ? $parseUser->premium = null : $parseUser->premium = $user->getPremium();
			is_null($user->getPremiumExpirationDate()) ? $parseUser->premiumExpirationDate = null : $parseUser->premiumExpirationDate = $parseUser->dataType('date', $user->getPremiumExpirationDate()->date);
			is_null($user->getProfilePicture()) ? $parseUser->profilePicture = null : $parseUser->profilePicture = $user->getProfilePicture();
			is_null($user->getProfilePictureFile()) ? $parseUser->profilePictureFile = null : $parseUser->profilePictureFile = $user->getProfilePictureFile();
			is_null($user->getProfileThumbnail()) ? $parseUser->profileThumbnail = null : $parseUser->profileThumbnail = $user->getProfileThumbnail();
			# sessionToken non può essere salvato su Parse perchè è una parola chiave
			# is_null($user->getSessionToken()) ? $parseUser->sessionToken = null : $parseUser->sessionToken = $user->getSessionToken();
			is_null($user->getSettings()) ? $parseUser->settings = null : $parseUser->settings = $user->getSettings();
			is_null($user->getStatuses()) ? $parseUser->statuses = null : $parseUser->statuses = toParseRelation('Status', $user->getStatuses());
			is_null($user->getTwitterPage()) ? $parseUser->twitterPage = null : $parseUser->twitterPage = $user->getTwitterPage();
			is_null($user->getType()) ? $parseUser->type = null : $parseUser->type = $user->getType();
			is_null($user->getVideos()) ? $parseUser->videos = null : $parseUser->videos = toParseRelation('Video', $user->getVideos());
			is_null($user->getWebsite()) ? $parseUser->website = null : $parseUser->website = $user->getWebsite();
			is_null($user->getYoutubeChannel()) ? $parseUser->youtubeChannel = null : $parseUser->youtubeChannel = $user->getYoutubeChannel();
			# is_null($user->getCreatedAt()) ? $parseUser->createdAt = null : $parseUser->createdAt = $user->getCreatedAt();
			# is_null($user->getUpdatedAt()) ? $parseUser->updatedAt = null : $parseUser->updatedAt = $user->getUpdatedAt();
			is_null($user->getACL()) ? $parseUser->ACL = null : $parseUser->ACL = $user->getACL()->acl;
			
			if ($user->getType() == 'VENUE') {
				is_null($user->getAddress()) ? $parseUser->address = null : $parseUser->address = $user->getAddress();
				$parseUser->birthDay = null;
				is_null($user->getCollaboration()) ? $parseUser->collaboration = null : $parseUser->collaboration = toParseRelation('_User', $user->getCollaboration());
				is_null($user->getEvents()) ? $parseUser->events = null : $parseUser->events = toParseRelation('Event', $user->getEvents());
				$parseUser->facebookId = null;
				$parseUser->firstname = null;
				$parseUser->jammerType = null;
				$parseUser->lastname = null;
				is_null($user->getLocalType()) ? $parseUser->localType = null : $parseUser->localType = $user->getLocalType();
				$parseUser->members = null;
				$parseUser->sex = null;
			} elseif ($user->getType() == 'JAMMER') {
				$parseUser->address = null;
				$parseUser->birthDay = null;
				is_null($user->getCollaboration()) ? $parseUser->collaboration = null : $parseUser->collaboration = toParseRelation('_User', $user->getCollaboration());
				is_null($user->getEvents()) ? $parseUser->events = null : $parseUser->events = toParseRelation('Event', $user->getEvents());
				$parseUser->facebookId = null;
				$parseUser->firstname = null;
				is_null($user->getJammerType()) ? $parseUser->jammerType = null : $parseUser->jammerType = $user->getJammerType();
				$parseUser->lastname = null;
				$parseUser->localType = null;
				is_null($user->getMembers()) ? $parseUser->members = null : $parseUser->members = $user->getMembers();
				is_null($user->getRecords()) ? $parseUser->records = null : $parseUser->records = toParseRelation('Record', $user->getRecords());
				is_null($user->getSongs()) ? $parseUser->songs = null : $parseUser->songs = toParseRelation('Song', $user->getSongs());
				$parseUser->sex = null;
			} elseif ($user->getType() == 'SPOTTER') {
				$parseUser->address = null;
				// TODO - attualmente la data di nascita è gestita come una normale Date, ma deve essere gestita staticamente!!!
				is_null($user->getBirthDay()) ? $parseUser->birthDay = null : $parseUser->birthDay = $user->getBirthDay();
				$parseUser->collaboration = null;
				$parseUser->events = null;
				is_null($user->getFacebookId()) ? $parseUser->facebookId = null : $parseUser->facebookId = $user->getFacebookId();
				is_null($user->getFirstname()) ? $parseUser->firstname = null : $parseUser->firstname = $user->getFirstname();
				is_null($user->getFollowing()) ? $parseUser->following = null : $parseUser->following = toParseRelation('_User', $user->getFollowing());
				is_null($user->getFriendship()) ? $parseUser->friendship = null : $parseUser->friendship = toParseRelation('_User', $user->getFriendship());
				$parseUser->jammerType = null;
				is_null($user->getLastname()) ? $parseUser->lastname = null : $parseUser->lastname = $user->getLastname();
				$parseUser->localType = null;
				$parseUser->members = null;
				is_null($user->getSex()) ? $parseUser->sex = null : $parseUser->sex = $user->getSex();
			}

			if ($user->getObjectId() == '') {
				$res = $parseUser->signup($user->getUsername(), $user->getPassword());
				$user->setObjectId($res->objectId);
				$user->setSessionToken($res->sessionToken);
				return $user;
			} else {
				$parseUser->update($user->getObjectId(), $user->getSessionToken());
			}
		} catch (Exception $e) {
			return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
		}
	}
    
    public function setLimit($limit) {
		$this->parseQuery->setLimit($limit);
	}
 
	public function setSkip($skip) {
		$this->parseQuery->setSkip($skip);
	}
 
	public function where($field, $value) {
		$this->parseQuery->where($field, $value);
	}
 
	public function whereContainedIn($field, $values) {
		$this->parseQuery->whereContainedIn($field, $values);
	}
 
	public function whereEqualTo($field, $value) {
		$this->parseQuery->whereEqualTo($field, $value);
	}
 
	public function whereExists($field) {
		$this->parseQuery->whereExists($field);
	}	
 
	public function whereGreaterThan($field, $value) {
		$this->parseQuery->whereGreaterThan($field, $value);
	}
 
	public function whereGreaterThanOrEqualTo($field, $value) {
		$this->parseQuery->whereGreaterThanOrEqualTo($field, $value);
	}
 
	public function whereLessThan($field, $value) {
		$this->parseQuery->whereLessThan($field, $value);
	}
 
	public function whereLessThanOrEqualTo($field, $value) {
		$this->parseQuery->whereLessThanOrEqualTo($field, $value);
	}
 
	public function whereNotContainedIn($field, $array) {
		$this->parseQuery->whereNotContainedIn($field, $array);
	}
 
	public function whereNotEqualTo($field, $value) {
		$this->parseQuery->whereNotEqualTo($field, $value);
	}
 
	public function whereNotExists($field) {
		$this->parseQuery->whereDoesNotExist($field);
	}
 
	public function wherePointer($field, $className, $objectId) {
		$this->parseQuery->wherePointer($field, $className, $objectId);
	}
        
    public function whereRelatedTo($field, $className, $objectId) {
		$this->parseQuery->whereRelatedTo($field, $className, $objectId);
	}

}

?>