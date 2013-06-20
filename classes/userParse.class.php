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
//require_once CLASSES_DIR . 'commentParse.class.php';

class UserParse {

    private $parseQuery;

    public function __construct() {
        $this->parseQuery = new ParseQuery('_User');
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
			return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
		}
    }
	
	#########
	# FATTA #
	#########
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

    #########
	# FATTA #
	#########
    public function getUsers() {
		try {
			$users = array();
			$res = $this->parseQuery->find();
			foreach ($res->results as $obj) {
				$user = $this->parseToComment($obj);
				$users[$user->getObjectId()] = $user;
			}
			return $users;
		} catch (Exception $e) {
			return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
		}
    }

	#########
	# FATTA #
	#########
    public function parseToUser ($res) {
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
			if ($res->birthDay != null) {
				$dateTime = new DateTime($res->birthDay);
				$user->setBirthDay($dateTime);
			}
			$user->setFacebookId($res->facebookId);
			$user->setFirstname($res->firstname);
			$user->setFollowing(fromParseRelation('_User', 'following', $res->objectId, '_User'));
			$user->setFriendship(fromParseRelation('_User', 'friendship', $res->objectId, '_User'));
			$user->setLastname($res->lastname);
			$user->setSex($res->sex);
		}
		
		//DA QUI
		
		//properties User
		if ($res->objectId != null) $user->setObjectId($res->objectId);
		if ($res->username != null) $user->setUsername($res->username);
		if ($res->password != null) $user->setPassword($res->password);
		if ($res->authData != null) $user->setAuthData($res->authData);
		if ($res->emailVerified != null) $user->setEmailVerified($res->emailVerified);
		if ($res->active != null) $user->setActive($res->active);
		/*
		if ($res->albums != null) {
			$albumParse = new AlbumParse();
			$albumRelatedTo = $albumParse->getRelatedTo('albums', '_User', $res->objectId);
			$user->setAlbums($albumRelatedTo);
		}
		*/
		if ($res->background != null) $user->setBackground($res->background);
		if ($res->city != null) $user->setCity($res->city);
		if ($res->comments != null) {
			$cmtParse = new CommentParse();
			$cmtRelatedTo = $cmtParse->getRelatedTo('comments', 'Comment', $res->objectId);
			$user->setComments($cmtRelatedTo);
		}
		if ($res->country != null) $user->setCountry($res->country);
		if ($res->description != null) $user->setDescription($res->description);
		if ($res->email != null) $user->setEmail($res->email);
		if ($res->fbPage != null) $user->setFbPage($res->fbPage);
		if ($res->geoCoding != null) {
			$parseGeoPoint = new parseGeoPoint($res->geoCoding->latitude, $res->geoCoding->longitude);
			$user->setGeoCoding($parseGeoPoint->location);
		}
		/*
		if ($res->images != null) {
			$imageParse = new ImageParse();
			$imageRelatedTo = $imageParse->getRelatedTo('images', 'Image', $res->objectId);
			$user->setImages($imageRelatedTo);
		}
		*/
		if ($res->level != null) $user->setLevel($res->level);
		if ($res->levelValue != null) $user->setLevelValue($res->levelValue);
		/*
		if ($res->loveSongs != null) {
			$songParse = new SongParse();
			$songRelatedTo = $songParse->getRelatedTo('loveSongs', 'Song', $res->objectId);
			$user->setLoveSongs($songRelatedTo);
		}
		*/
		if ($res->music != null) $user->setMusic($res->music);
		/*
		if ($res->playlists != null) {
			$plParse = new PlaylistParse();
			$plRelatedTo = $plParse->getRelatedTo('playlist', 'Playlist', $res->objectId);
			$user->setPlaylists($plRelatedTo);
		}
		*/
		if ($res->premium != null) $user->setPremium($res->premium);
		if ($res->premiumExpirationDate != null) {
			$dateTime = new DateTime($res->premiumExpirationDate);
			$user->setPremiumExpirationDate($dateTime);
		}
		if ($res->profilePicture != null) $user->setProfilePicture($res->profilePicture);
		if ($res->profilePictureFile != null) $user->setProfilePictureFile($res->profilePictureFile);
		if ($res->profileThumbnail != null) $user->setProfileThumbnail($res->profileThumbnail);
		if ($res->sessionToken != null) $user->setSessionToken($res->sessionToken);
		if ($res->settings != null) $user->setSettings($res->settings);
		/*
		if ($res->statuses != null) {
			$statusParse = new StatusParse();
			$statusRelatedTo = $statusParse->getRelatedTo('statuses', 'Status', $res->objectId);
			$user->setStatuses($statusRelatedTo);
		}
		*/
		if ($res->twitterPage != null) $user->setTwitterPage($res->twitterPage);
		if ($res->type != null) $user->setType($res->type);
		/*
		if ($res->videos != null) {
			$videoParse = new VideoParse();
			$videoRelatedTo = $videoParse->getRelatedTo('videos', 'Video', $res->objectId);
			$user->setVideos($videoRelatedTo);
		}
		*/
		if ($res->website != null) $user->setWebsite($res->website);
		if ($res->youtubeChannel != null) $user->setYoutubeChannel($res->youtubeChannel);
		if ($res->createdAt != null) {
			$dateTime = new DateTime($res->createdAt);
			$user->setCreatedAt($dateTime);
		}
		if ($res->updatedAt != null) {
			$dateTime = new DateTime($res->updatedAt);
			$user->setUpdatedAt($dateTime);
		}
		if ($res->ACL != null) $user->setACL($res->ACL);
		
		return $user;
	}
	
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