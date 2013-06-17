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
require_once CLASSES_DIR . 'error.class.php';
require_once CLASSES_DIR . 'errorParse.class.php';
require_once CLASSES_DIR . 'commentParse.class.php';

class UserParse {

    private $parseQuery;

    public function __construct() {
        $this->parseQuery = new ParseQuery('_User');
    }
	
	#########
	# FATTA #
	#########
    public function getRelatedTo($field, $className, $objectId) {
		try {
			$this->parseQuery->whereRelatedTo($field, $className, $objectId);
			$rel = $this->parseQuery->find();
			$relUser = array();
			foreach ($rel->results as $user) {
				$relUser[] = $user->objectId;
			}
			return $relUser;
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
	}
	
	#########
	# FATTA #
	#########
    public function getUser($objectId) {
		$parseObject = new parseObject('_User');
		$res = $parseObject->get($objectId);
		$user = $this->parseToUser($res);
		return $user;
    }

    public function getUsers() {
        $users = null;
        $result = $this->parseQuery->find();
        if (is_array($result->results) && count($result->results) > 0) {
            $users = array();
            foreach (($result->results) as $user) {
                $users [] = $this->parseToUser($user);
            }
        }
        return $users;
    }

	#########
	# FATTA #
	#########
    public function parseToUser ($obj) {
		if ($obj->type == 'VENUE') {
			$user = new Venue();
			
			//properties Venue
			if ($obj->address != null) $user->setAddress($obj->address);
			if ($obj->collaboration != null) {
				$userParse = new UserParse();
				$userRelatedTo = $userParse->getRelatedTo('collaboration', '_User', $obj->objectId);
				$user->setCollaboration($userRelatedTo);
			}
			/*
			if ($obj->events != null) {
				$eventParse = new EventParse();
				$eventRelatedTo = $eventParse->getRelatedTo('events', 'Event', $obj->objectId);
				$user->setEvents($eventRelatedTo);
			}
			*/
			if ($obj->localType != null) $user->setLocalType($obj->localType);
		} elseif ($obj->type == 'JAMMER') {
			$user = new Jammer();
			
			//properties Jammer
			if ($obj->collaboration != null) {
				$userParse = new UserParse();
				$userRelatedTo = $userParse->getRelatedTo('collaboration', '_User', $obj->objectId);
				$user->setCollaboration($userRelatedTo);
			}
			/*
			if ($obj->events != null) {
				$eventParse = new EventParse();
				$eventRelatedTo = $eventParse->getRelatedTo('events', 'Event', $obj->objectId);
				$user->setEvents($eventRelatedTo);
			}
			*/
			if ($obj->jammerType != null) $user->setJammerType($obj->jammerType);
			if ($obj->members != null) $user->setMembers($obj->members);
			/*
			if ($obj->records != null) {
				$recordParse = new RecordParse();
				$recordRelatedTo = $recordParse->getRelatedTo('records', 'Record', $obj->objectId);
				$user->setRecords($recordRelatedTo);
			}
			if ($obj->songs != null) {
				$songParse = new SongParse();
				$songRelatedTo = $songParse->getRelatedTo('songs', 'Song', $obj->objectId);
				$user->setSong($songRelatedTo);
			}
			*/
		} elseif ($obj->type == 'SPOTTER') {
			$user = new Spotter();
			
			//properties Spotter
			// TODO - attualmente la data di nascita è gestita come una normale Date, ma deve essere gestita staticamente!!!
			if ($obj->birthDay != null) {
				$dateTime = new DateTime($obj->birthDay);
				$user->setBirthDay($dateTime);
			}
			if ($obj->facebookId != null) $user->setFacebookId($obj->facebookId);
			if ($obj->firstname != null) $user->setFirstname($obj->firstname);
			if ($obj->following != null) {
				$userParse = new UserParse();
				$userRelatedTo = $userParse->getRelatedTo('following', '_User', $obj->objectId);
				$user->setFollowing($userRelatedTo);
			}
			if ($obj->friendship != null) {
				$userParse = new UserParse();
				$userRelatedTo = $userParse->getRelatedTo('friendship', '_User', $obj->objectId);
				$user->setFriendship($userRelatedTo);
			}
			if ($obj->lastname != null) $user->setLastname($obj->lastname);
			if ($obj->sex != null) $user->setSex($obj->sex);
		}
		
		//properties User
		if ($obj->objectId != null) $user->setObjectId($obj->objectId);
		if ($obj->username != null) $user->setUsername($obj->username);
		if ($obj->password != null) $user->setPassword($obj->password);
		if ($obj->authData != null) $user->setAuthData($obj->authData);
		if ($obj->emailVerified != null) $user->setEmailVerified($obj->emailVerified);
		if ($obj->active != null) $user->setActive($obj->active);
		/*
		if ($obj->albums != null) {
			$albumParse = new AlbumParse();
			$albumRelatedTo = $albumParse->getRelatedTo('albums', '_User', $obj->objectId);
			$user->setAlbums($albumRelatedTo);
		}
		*/
		if ($obj->background != null) $user->setBackground($obj->background);
		if ($obj->city != null) $user->setCity($obj->city);
		if ($obj->comments != null) {
			$cmtParse = new CommentParse();
			$cmtRelatedTo = $cmtParse->getRelatedTo('comments', 'Comment', $obj->objectId);
			$user->setComments($cmtRelatedTo);
		}
		if ($obj->country != null) $user->setCountry($obj->country);
		if ($obj->description != null) $user->setDescription($obj->description);
		if ($obj->email != null) $user->setEmail($obj->email);
		if ($obj->fbPage != null) $user->setFbPage($obj->fbPage);
		if ($obj->geoCoding != null) {
			$parseGeoPoint = new parseGeoPoint($obj->geoCoding->latitude, $obj->geoCoding->longitude);
			$user->setGeoCoding($parseGeoPoint->location);
		}
		/*
		if ($obj->images != null) {
			$imageParse = new ImageParse();
			$imageRelatedTo = $imageParse->getRelatedTo('images', 'Image', $obj->objectId);
			$user->setImages($imageRelatedTo);
		}
		*/
		if ($obj->level != null) $user->setLevel($obj->level);
		if ($obj->levelValue != null) $user->setLevelValue($obj->levelValue);
		/*
		if ($obj->loveSongs != null) {
			$songParse = new SongParse();
			$songRelatedTo = $songParse->getRelatedTo('loveSongs', 'Song', $obj->objectId);
			$user->setLoveSongs($songRelatedTo);
		}
		*/
		if ($obj->music != null) $user->setMusic($obj->music);
		/*
		if ($obj->playlists != null) {
			$plParse = new PlaylistParse();
			$plRelatedTo = $plParse->getRelatedTo('playlist', 'Playlist', $obj->objectId);
			$user->setPlaylists($plRelatedTo);
		}
		*/
		if ($obj->premium != null) $user->setPremium($obj->premium);
		if ($obj->premiumExpirationDate != null) {
			$dateTime = new DateTime($obj->premiumExpirationDate);
			$user->setPremiumExpirationDate($dateTime);
		}
		if ($obj->profilePicture != null) $user->setProfilePicture($obj->profilePicture);
		if ($obj->profilePictureFile != null) $user->setProfilePictureFile($obj->profilePictureFile);
		if ($obj->profileThumbnail != null) $user->setProfileThumbnail($obj->profileThumbnail);
		if ($obj->sessionToken != null) $user->setSessionToken($obj->sessionToken);
		if ($obj->settings != null) $user->setSettings($obj->settings);
		/*
		if ($obj->statuses != null) {
			$statusParse = new StatusParse();
			$statusRelatedTo = $statusParse->getRelatedTo('statuses', 'Status', $obj->objectId);
			$user->setStatuses($statusRelatedTo);
		}
		*/
		if ($obj->twitterPage != null) $user->setTwitterPage($obj->twitterPage);
		if ($obj->type != null) $user->setType($obj->type);
		/*
		if ($obj->videos != null) {
			$videoParse = new VideoParse();
			$videoRelatedTo = $videoParse->getRelatedTo('videos', 'Video', $obj->objectId);
			$user->setVideos($videoRelatedTo);
		}
		*/
		if ($obj->website != null) $user->setWebsite($obj->website);
		if ($obj->youtubeChannel != null) $user->setYoutubeChannel($obj->youtubeChannel);
		if ($obj->createdAt != null) {
			$dateTime = new DateTime($obj->createdAt);
			$user->setCreatedAt($dateTime);
		}
		if ($obj->updatedAt != null) {
			$dateTime = new DateTime($obj->updatedAt);
			$user->setUpdatedAt($dateTime);
		}
		if ($obj->ACL != null) $user->setACL($obj->ACL);
		
		return $user;
	}
	
	#########
	# FATTA #
	#########
    function saveUser($user) {
		try {
			$parseUser = new parseUser();
			
			if ($user->getObjectId() == '') {
				//properties User
				$user->getUsername() == null ? $parseUser->username = null : $parseUser->username = $user->getUsername();
				$user->getPassword() == null ? $parseUser->password = null : $parseUser->password = $user->getPassword();
				//$user->getAuthData() == null ? $parseUser->authData = null : $parseUser->authData = $user->getAuthData();
				//$user->getEmailVerified() == null ? $parseUser->emailVerified = null : $parseUser->emailVerified = $user->getEmailVerified();
				$user->getActive() === null ? $parseUser->active = null : $parseUser->active = $user->getActive();
				$user->getAlbums() == null ? $parseUser->albums = null : $parseUser->albums = $user->getAlbums();
				$user->getBackground() == null ? $parseUser->background = null : $parseUser->background = $user->getBackground();
				$user->getCity() == null ? $parseUser->city = null : $parseUser->city = $user->getCity();
				$user->getComments() == null ? $parseUser->comments = null : $parseUser->comments = $user->getComments();
				$user->getCountry() == null ? $parseUser->country = null : $parseUser->country = $user->getCountry();
				$user->getDescription() == null ? $parseUser->description = null : $parseUser->description = $user->getDescription();
				$user->getEmail() == null ? $parseUser->email = null : $parseUser->email = $user->getEmail();
				$user->getFbPage() == null ? $parseUser->fbPage = null : $parseUser->fbPage = $user->getFbPage();
				$user->getGeoCoding() == null ? $parseUser->geoCoding = null : $parseUser->geoCoding = $user->getGeoCoding();
				$user->getImages() == null ? $parseUser->images = null : $parseUser->images = $user->getImages();
				$user->getLevel() == null ? $parseUser->level = null : $parseUser->level = $user->getLevel();
				$user->getLevelValue() == null ? $parseUser->levelValue = null : $parseUser->levelValue = $user->getLevelValue();
				$user->getLoveSongs() == null ? $parseUser->loveSongs = null : $parseUser->loveSongs = $user->getLoveSongs();
				$user->getMusic() == null ? $parseUser->music = null : $parseUser->music = $user->getMusic();
				$user->getPlaylists() == null ? $parseUser->playlists = null : $parseUser->playlists = $user->getPlaylists();
				$user->getPremium() == null ? $parseUser->premium = null : $parseUser->premium = $user->getPremium();
				$user->getPremiumExpirationDate() == null ? $parseUser->premiumExpirationDate = null : $parseUser->premiumExpirationDate = $parseUser->dataType('date', $user->getPremiumExpirationDate()->date);
				$user->getProfilePicture() == null ? $parseUser->profilePicture = null : $parseUser->profilePicture = $user->getProfilePicture();
				$user->getProfilePictureFile() == null ? $parseUser->profilePictureFile = null : $parseUser->profilePictureFile = $user->getProfilePictureFile();
				$user->getProfileThumbnail() == null ? $parseUser->profileThumbnail = null : $parseUser->profileThumbnail = $user->getProfileThumbnail();
				$user->getSessionToken() == null ? $parseUser->sessionToken = null : $parseUser->sessionToken = $user->getSessionToken();
				$user->getSettings() == null ? $parseUser->settings = null : $parseUser->settings = $user->getSettings();
				$user->getStatuses() == null ? $parseUser->statuses = null : $parseUser->statuses = $user->getStatuses();
				$user->getTwitterPage() == null ? $parseUser->twitterPage = null : $parseUser->twitterPage = $user->getTwitterPage();
				$user->getType() == null ? $parseUser->type = null : $parseUser->type = $user->getType();
				$user->getVideos() == null ? $parseUser->videos = null : $parseUser->videos = $user->getVideos();
				$user->getWebsite() == null ? $parseUser->website = null : $parseUser->website = $user->getWebsite();
				$user->getYoutubeChannel() == null ? $parseUser->youtubeChannel = null : $parseUser->youtubeChannel = $user->getYoutubeChannel();
				//$user->getCreatedAt() == null ? $parseUser->createdAt = null : $parseUser->createdAt = $user->getCreatedAt();
				//$user->getUpdatedAt() == null ? $parseUser->updatedAt = null : $parseUser->updatedAt = $user->getUpdatedAt();
				$user->getACL() == null ? $parseUser->ACL = null : $parseUser->ACL = $user->getACL()->acl;
				
				if ($user->getType() == 'VENUE') {
					$user->getAddress() == null ? $parseUser->address = null : $parseUser->address = $user->getAddress();
					$parseUser->birthDay = null;
					$user->getCollaboration() == null ? $parseUser->collaboration = null : $parseUser->collaboration = $user->getCollaboration();
					$user->getEvents() == null ? $parseUser->events = null : $parseUser->events = $user->getEvents();
					$parseUser->facebookId = null;
					$parseUser->firstname = null;
					$parseUser->jammerType = null;
					$parseUser->lastname = null;
					$user->getLocalType() == null ? $parseUser->localType = null : $parseUser->localType = $user->getLocalType();
					$parseUser->members = null;
					$parseUser->sex = null;
				} elseif ($user->getType() == 'JAMMER') {
					$parseUser->address = null;
					$parseUser->birthDay = null;
					$user->getCollaboration() == null ? $parseUser->collaboration = null : $parseUser->collaboration = $user->getCollaboration();
					$user->getEvents() == null ? $parseUser->events = null : $parseUser->events = $user->getEvents();
					$parseUser->facebookId = null;
					$parseUser->firstname = null;
					$user->getJammerType() == null ? $parseUser->jammerType = null : $parseUser->jammerType = $user->getJammerType();
					$parseUser->lastname = null;
					$parseUser->localType = null;
					$user->getMembers() == null ? $parseUser->members = null : $parseUser->members = $user->getMembers();
					$user->getRecords() == null ? $parseUser->records = null : $parseUser->records = $user->getRecords();
					$user->getSongs() == null ? $parseUser->songs = null : $parseUser->songs = $user->getSongs();
					$parseUser->sex = null;
				} elseif ($user->getType() == 'SPOTTER') {
					$parseUser->address = null;
					// TODO - attualmente la data di nascita è gestita come una normale Date, ma deve essere gestita staticamente!!!
					$user->getBirthDay() == null ? $parseUser->birthDay = null : $parseUser->birthDay = $user->getBirthDay();
					$parseUser->collaboration = null;
					$parseUser->events = null;
					$user->getFacebookId() == null ? $parseUser->facebookId = null : $parseUser->facebookId = $user->getFacebookId();
					$user->getFirstname() == null ? $parseUser->firstname = null : $parseUser->firstname = $user->getFirstname();
					$user->getFollowing() == null ? $parseUser->following = null : $parseUser->following = $user->getFollowing();
					$user->getFriendship() == null ? $parseUser->friendship = null : $parseUser->friendship = $user->getFriendship();
					$parseUser->jammerType = null;
					$user->getLastname() == null ? $parseUser->lastname = null : $parseUser->lastname = $user->getLastname();
					$parseUser->localType = null;
					$parseUser->members = null;
					$user->getSex() == null ? $parseUser->sex = null : $parseUser->sex = $user->getSex();
				}
				
				$res = $parseUser->signup($user->getUsername(), $user->getPassword());
				$user->setObjectId($res->objectId);
				$user->setSessionToken($res->sessionToken);
		
				return $user;
			} else {
				//properties User
				if ($user->getUsername() != null) $parseUser->username = $user->getUsername();
				if ($user->getPassword() != null) $parseUser->password = $user->getPassword();
				//if ($user->getAuthData() != null) $parseUser->authData = $user->getAuthData();
				//if ($user->getEmailVerified() != null) $parseUser->emailVerified = $user->getEmailVerified();
				if ($user->getActive() != null) $parseUser->active = $user->getActive();
				if ($user->getAlbums() != null) $parseUser->albums = $user->getAlbums();
				if ($user->getBackground() != null) $parseUser->background = $user->getBackground();
				if ($user->getCity() != null) $parseUser->city = $user->getCity();
				if ($user->getComments() != null) $parseUser->comments = $user->getComments();
				if ($user->getCountry() != null) $parseUser->country = $user->getCountry();
				if ($user->getDescription() != null) $parseUser->description = $user->getDescription();
				if ($user->getEmail() != null) $parseUser->email = $user->getEmail();
				if ($user->getFbPage() != null) $parseUser->fbPage = $user->getFbPage();
				if ($user->getGeoCoding() != null) $parseUser->geoCoding = $user->getGeoCoding();
				if ($user->getImages() != null) $parseUser->images = $user->getImages();
				if ($user->getLevel() != null) $parseUser->level = $user->getLevel();
				if ($user->getLevelValue() != null) $parseUser->levelValue = $user->getLevelValue();
				if ($user->getLoveSongs() != null) $parseUser->loveSongs = $user->getLoveSongs();
				if ($user->getMusic() != null) $parseUser->music = $user->getMusic();
				if ($user->getPlaylists() != null) $parseUser->playlists = $user->getPlaylists();
				if ($user->getPremium() != null) $parseUser->premium = $user->getPremium();
				if ($user->getPremiumExpirationDate() != null) $parseUser->premiumExpirationDate = $user->getPremiumExpirationDate();
				if ($user->getProfilePicture() != null) $parseUser->profilePicture = $user->getProfilePicture();
				if ($user->getProfilePictureFile() != null) $parseUser->profilePictureFile = $user->getProfilePictureFile();
				if ($user->getProfileThumbnail() != null) $parseUser->profileThumbnail = $user->getProfileThumbnail();
				if ($user->getSettings() != null) $parseUser->settings = $user->getSettings();
				if ($user->getStatuses() != null) $parseUser->statuses = $user->getStatuses();
				if ($user->getTwitterPage() != null) $parseUser->twitterPage = $user->getTwitterPage();
				if ($user->getType() != null) $parseUser->type = $user->getType();
				if ($user->getVideos() != null) $parseUser->videos = $user->getVideos();
				if ($user->getWebsite() != null) $parseUser->website = $user->getWebsite();
				if ($user->getYoutubeChannel() != null) $parseUser->youtubeChannel = $user->getYoutubeChannel();
				//if ($user->getCreatedAt() != null) $parseUser->createdAt = $user->getCreatedAt();
				//if ($user->getUpdatedAt() != null) $parseUser->updatedAt = $user->getUpdatedAt();
				if ($user->getACL() != null) $parseUser->ACL = $user->getACL()->acl;
				//if ($user->getSessionToken() != null) $parseUser->sessionToken = $user->getSessionToken();
				
				if ($user->getType() == 'VENUE') {
					if ($user->address() != null) $parseUser->address = $user->getAddress();
					if ($user->collaboration() != null) $parseUser->collaboration = $user->getCollaboration();
					if ($user->events() != null) $parseUser->events = $user->getEvents();
					if ($user->localType() != null) $parseUser->localType = $user->getLocalType();
				} elseif ($user->getType() == 'JAMMER') {
					if ($user->collaboration() != null) $parseUser->collaboration = $user->getCollaboration();
					if ($user->events() != null) $parseUser->events = $user->getEvents();
					if ($user->jammerType() != null) $parseUser->jammerType = $user->getJammerType();
					if ($user->members() != null) $parseUser->members = $user->getMembers();
					if ($user->records() != null) $parseUser->records = $user->getRecords();
					if ($user->songs() != null) $parseUser->songs = $user->getSongs();
				} elseif ($user->getType() == 'SPOTTER') {
					// TODO - attualmente la data di nascita è gestita come una normale Date, ma deve essere gestita staticamente!!!
					if ($user->birthDay() != null) $parseUser->birthDay = $user->getBirthDay();
					if ($user->facebookId() != null) $parseUser->facebookId = $user->getFacebookId();
					if ($user->firstname() != null) $parseUser->firstname = $user->getFirstname();
					if ($user->following() != null) $parseUser->following = $user->getFollowing();
					if ($user->friendship() != null) $parseUser->friendship = $user->getFriendship();
					if ($user->lastname() != null) $parseUser->lastname = $user->getLastname();
					if ($user->sex() != null) $parseUser->sex = $user->getSex();
				}
				
				$parseUser->update($user->getObjectId(), $user->getSessionToken());
			}
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
	}
    
    /**
     * Effettua il login dell'utente fornendo un utente che deve avere qualche parametro impostato, dopodich� creo uno User specifico
     * e lo restituisco.
     */
    function login($login, $password) {

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

	#########
	# FATTA #
	#########
    function deleteUser($user) {
		try {
			$parseUser = new parseUser();
			$parseUser->active = false;
			$parseUser->update($user->getObjectId(), $user->getSessionToken());
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