<?php

/* ! \par		Info Generali:
 *  \author		Stefano Muscas
 *  \version	1.0
 *  \date		2013
 *  \copyright	Jamyourself.com 2013
 *  \par		Info Classe:
 *  \brief		Stutus Parse Class
 *  \details	Classe Parse dedicata allo status dello User
 *  \par		Commenti:
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
require_once SERVICES_DIR . 'debug.service.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'classes/' . getLanguage() . '.classes.lang.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'utilsClass.php';
require_once CLASSES_DIR . 'user.class.php';
require_once CLASSES_DIR . 'albumParse.class.php';
require_once CLASSES_DIR . 'commentParse.class.php';
require_once CLASSES_DIR . 'eventParse.class.php';
require_once CLASSES_DIR . 'playlistParse.class.php';
require_once CLASSES_DIR . 'recordParse.class.php';
require_once CLASSES_DIR . 'statusParse.class.php';

class UserParse {

    private $parseQuery;

    /**
     * \fn		void __construct()
     * \brief	The constructor instantiates a new object of type ParseQuery on the User class
     */
    public function __construct() {
        $this->parseQuery = new ParseQuery('_User');
    }

    /**
     * \fn		void decrementUser(string $objectId, string $field, int $value)
     * \brief	Decrement the value of the $field of the objectId $objectId of $value unit
     * \param	$objectId	the string that represent the objectId of the User
     * \param	$field		the string that represent the field to decrement
     * \param 	$value		the number that represent the quantity to decrease the $field
     * \return	int			the new value of the $field
     * \return	error		in case of exception
     */
    public function decrementUser($objectId, $field, $value, $withArray = false, $fieldArray = '', $valueArray = array()) {
        try {
            $parseObject = new parseObject('_User');
            //we use the increment function with a negative value because decrement function still not work
            $parseObject->increment($field, array(0 - $value));
            if ($withArray) {
                if (is_null($fieldArray) || empty($valueArray))
                    return throwError(new Exception('decrementUser parameters fieldArray and valueArray must to be set for array update'), __CLASS__, __FUNCTION__, func_get_args());
                $parseObject->removeArray($fieldArray, $valueArray);
            }
            $res = $parseObject->update($objectId);
            return $res->$field;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

    /**
     * \fn		void deleteUser(string $objectId)
     * \brief	The function delete an User, setting active property to false
     * \param	$objectId the string that represent the objectId of the User to delete
     * \return	Error	the Error raised by the function
     */
    public function deleteUser($objectId) {
        try {
            $parseUser = new parseUser();
            $res = $parseUser->get($objectId);
            $user = $this->parseToUser($res);
            //delete properties User
            foreach ($user->getAlbums() as $albumObjectId) {
                $albumParse = new AlbumParse();
                $albumParse->deleteAlbum($albumObjectId);
            }
            foreach ($user->getComments() as $cmtObjectId) {
                $cmtParse = new CommentParse();
                $cmtParse->deleteComment($cmtObjectId);
            }
            foreach ($user->getPlaylists() as $plObjectId) {
                $plParse = new PlaylistParse();
                $plParse->deletePlaylist($plObjectId);
            }
            foreach ($user->getStatuses() as $statusObjectId) {
                $statusParse = new StatusParse();
                $statusParse->deleteStatus($statusObjectId);
            }
            if ($user->getType == 'VENUE') {
                //delete properties Venue
                foreach ($user->getEvents() as $eventObjectId) {
                    $eventParse = new EventParse();
                    $eventParse->deleteEvent($eventObjectId);
                }
            } elseif ($res->type == 'JAMMER') {
                //delete properties Jammer
                foreach ($user->getEvents() as $eventObjectId) {
                    $eventParse = new EventParse();
                    $eventParse->deleteEvent($eventObjectId);
                }
                foreach ($user->getRecords() as $recordObjectId) {
                    $recordParse = new RecordParse();
                    $recordParse->deleteRecord($recordObjectId);
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

    /**
     * \fn		number getCount()
     * \brief	Returns the number of requests User
     * \return	number
     */
    public function getCount() {
        return $this->parseQuery->getCount()->count;
    }

    /**
     * \fn		User getUser(string $objectId)
     * \brief	The function returns the User object specified
     * \param	$objectId the string that represent the objectId of the User
     * \return	User	the User with the specified $objectId
     * \return	Error	the Error raised by the function
     */
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

    /**
     * \fn		array getUsers()
     * \brief	The function returns an array Users objects specified
     * \return	array	an array of Users, if one or more Users are found
     * \return	null	if no User is found
     * \return	Error	the Error raised by the function
     */
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

    /**
     * \fn		void incrementUser(string $objectId, string $field, int $value)
     * \brief	iNcrement the value of the $field of the objectId $objectId of $value unit
     * \param	$objectId	the string that represent the objectId of the User
     * \param	$field		the string that represent the field to increment
     * \param 	$value		the number that represent the quantity to increase the $field
     * \return	int			the new value of the $field
     * \return	error		in case of exception
     */
    public function incrementUser($objectId, $field, $value, $withArray = false, $fieldArray = '', $valueArray = array()) {
        try {
            $parseObject = new parseObject('_User');
            $parseObject->increment($field, array($value));
            if ($withArray) {
                if (is_null($fieldArray) || empty($valueArray))
                    return throwError(new Exception('incrementUser parameters fieldArray and valueArray must to be set for array update'), __CLASS__, __FUNCTION__, func_get_args());
                $parseObject->addUniqueArray($fieldArray, $valueArray);
            }
            $res = $parseObject->update($objectId);
            return $res->$field;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

    /**
     * \fn	void linkUser($user, $authData)
     * \brief	link the user account with a Social Network
     * \param	$user		the object that represent the User	
     * \param	$authData	the array that represent the Parse authData properity
     * \return	array		the updatedAt time. Ex: {"updatedAt":"2013-11-11T16:56:47.632Z"}
     * \return	error		in case of exception
     */
    public function linkUser($user, $authData) {
        try {
            $parseUser = new parseUser();
            $parseUser->addAuthData($authData);
            $res = $parseUser->linkAccounts($user->getObjectId(), $user->getSessionToken());
            return $res;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

    /**
     * \fn		User loginUser()
     * \brief	The function returns the User logged by the username or email $usernameEmail and password $password
     * \return	User 	the User logged in
     * \return	Error	the Error raised by the function
     */
    public function loginUser($usernameEmail, $password) {
        try {
            // determino lo username tramite l'email
            if (filter_var($usernameEmail, FILTER_VALIDATE_EMAIL)) {
                $parseQuery = new parseQuery('_User');
                $parseQuery->where('email', $usernameEmail);
                $res = $parseQuery->find();
                if (count($res->results) > 0) {
                    $user = $this->parseToUser($res->results[0]);
                    $username = $user->getUsername();
                } else {
                    return throwError(new Exception('loginUser email not found'), __CLASS__, __FUNCTION__, func_get_args());
                }
            } else {
                $username = $usernameEmail;
            }
            $parseUser = new parseUser();
            $parseUser->username = $username;
            $parseUser->password = $password;
            $res = $parseUser->login();
            $user = $this->parseToUser($res);
            return $user;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

    /**
     * \fn		void orderBy($field)
     * \brief	Specifies which field need to be ordered of requested User
     * \param	$field	the field on which to sort
     */
    public function orderBy($field) {
        $this->parseQuery->orderBy($field);
    }

    /**
     * \fn		void orderByAscending($field)
     * \brief	Specifies which field need to be ordered ascending of requested User
     * \param	$field	the field on which to sort ascending
     */
    public function orderByAscending($field) {
        $this->parseQuery->orderByAscending($field);
    }

    /**
     * \fn		void orderByDescending($field)
     * \brief	Specifies which field need to be ordered descending of requested User
     * \param	$field	the field on which to sort descending
     */
    public function orderByDescending($field) {
        $this->parseQuery->orderByDescending($field);
    }

    /**
     * \fn		User parseToUser($res)
     * \brief	The function returns a representation of an User object in Parse
     * \param	$res	represent the User object returned from Parse
     * \return	User	the User object
     * \return	Error	the Error raised by the function
     */
    public function parseToUser($res) {
        if (is_null($res))
            return throwError(new Exception('parseToUser parameter is unset'), __CLASS__, __FUNCTION__, func_get_args());
        try {
            $user = new User($res->type);

            $user->setObjectId($res->objectId);
            $user->setUsername($res->username);
            $user->setPassword($res->password);
            $user->setAuthData($res->authData);
            $user->setEmailVerified($res->emailVerified);
            $user->setActive($res->active);
            $user->setAddress($res->address);
            # $user->setAlbums(fromParseRelation('_User', 'albums', $res->objectId, 'Album'));
            $user->setBackground($res->background);
            $user->setBirthDay($res->birthDay);
            $user->setCity($res->city);
            # $user->setCollaboration(fromParseRelation('_User', 'collaboration', $res->objectId, '_User'));
            $user->setCollaborationCounter($res->collaborationCounter);
            # $user->setComments(fromParseRelation('_User', 'comments', $res->objectId, 'Comment'));
            $user->setCountry($res->country);
            $user->setDescription($res->description);
            $user->setEmail($res->email);
            # $user->setEvents(fromParseRelation('_User', 'events', $res->objectId, 'Event'));
            $user->setFacebookId($res->facebookId);
            $user->setFbPage($res->fbPage);
            $user->setFirstname($res->firstname);
            # $user->setFollowers(fromParseRelation('_User', 'followers', $res->objectId, '_User'));
            $user->setFollowersCounter($res->followersCounter);
            # $user->setFollowing(fromParseRelation('_User', 'following', $res->objectId, '_User'));
            $user->setFollowingCounter($res->followingCounter);
            # $user->setFriendship(fromParseRelation('_User', 'friendship', $res->objectId, '_User'));
            $user->setFriendshipCounter($res->friendshipCounter);
            $user->setGooglePlusPage($res->googlePlusPage);
            $user->setGeoCoding(fromParseGeoPoint($res->geoCoding));
            # $user->setImages(fromParseRelation('_User', 'images', $res->objectId, 'Image'));
            $user->setJammerCounter($res->jammerCounter);
            $user->setJammerType($res->jammerType);
            $user->setLastname($res->lastname);
            $user->setLevel($res->level);
            $user->setLevelValue($res->levelValue);
            $user->setLocalType($res->localType);
            # $user->setLoveSongs(fromParseRelation('_User', 'loveSongs', $res->objectId, 'Song'));
            $user->setMembers($res->members);
            $user->setMusic($res->music);
            # $user->setPlaylists(fromParseRelation('_User', 'playlist', $res->objectId, 'Playlist'));
            $user->setPremium($res->premium);
            $res->premium ? $user->setPremiumExpirationDate(fromParseDate($res->premiumExpirationDate)) : $user->setPremiumExpirationDate(null);
            $user->setProfilePicture($res->profilePicture);
            $user->setProfilePictureFile($res->profilePictureFile);
            $user->setProfileThumbnail($res->profileThumbnail);
            # $user->setRecords(fromParseRelation('_User', 'records', $res->objectId, 'Record'));
            $user->setSessionToken($res->sessionToken);
            $user->setSettings($res->settings);
            $user->setSex($res->sex);
            # $user->setSongs(fromParseRelation('_User', 'songs', $res->objectId, 'Song'));
            # $user->setStatuses(fromParseRelation('_User', 'statuses', $res->objectId, 'Status'));
            $user->setTwitterPage($res->twitterPage);
            $user->setType($res->type);
            $user->setVenueCounter($res->venueCounter);
            # $user->setVideos(fromParseRelation('_User', 'videos', $res->objectId, 'Video'));
            $user->setWebsite($res->website);
            $user->setYoutubeChannel($res->youtubeChannel);
            $user->setCreatedAt(fromParseDate($res->createdAt));
            $user->setUpdatedAt(fromParseDate($res->updatedAt));
            $user->setACL(fromParseACL($res->ACL));

            return $user;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

    /**
     * \fn	passwordReset($email)
     * \brief	The function returns the User who's requesting the password reset
     * \return	User 	the User requesting the password reset
     * \return	Error	the Error raised by the function
     */
    public function passwordReset($email) {
        try {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $parseQuery = new parseQuery('_User');
                $parseQuery->where('email', $email);
                $res = $parseQuery->find();
                if (count($res->results) > 0) {
                    $user = $this->parseToUser($res->results[0]);
                    $parseUser = new parseUser();
                    $parseUser->email = $email;
                    $parseUser->requestPasswordReset($email);
                    return $user;
                } else {
                    return throwError(new Exception('user  not found'), __CLASS__, __FUNCTION__, func_get_args());
                }
            }
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

    /**
     * \fn		User saveUser($user)
     * \brief	This function save an User object in Parse
     * \param	$user		represent the User object to save
     * \return	User		the User object with the new objectId parameter saved
     * \return	Exception	the Exception raised by the function
     */
    public function saveUser($user) {
        try {
            $nullArray = array();
            $parseUser = new parseUser();
            is_null($user->getUsername()) ? $parseUser->username = null : $parseUser->username = $user->getUsername();
            is_null($user->getPassword()) ? $parseUser->password = null : $parseUser->password = $user->getPassword();
            is_null($user->getActive()) ? $parseUser->active = null : $parseUser->active = $user->getActive();
            is_null($user->getAddress()) ? $parseUser->address = null : $parseUser->address = $user->getAddress();
            is_null($user->getAlbums()) ? $parseUser->albums = null : $parseUser->albums = toParseAddRelation('Album', $user->getAlbums());
            is_null($user->getBackground()) ? $parseUser->background = DEFBGD : $parseUser->background = $user->getBackground();
            is_null($user->getBirthDay()) ? $parseUser->birthDay = null : $parseUser->birthDay = $user->getBirthDay();
            is_null($user->getCity()) ? $parseUser->city = null : $parseUser->city = $user->getCity();
            is_null($user->getCollaboration()) ? $parseUser->collaboration = null : $parseUser->collaboration = toParseAddRelation('_User', $user->getCollaboration());
            is_null($user->getCollaborationCounter()) ? $parseUser->collaborationCounter = -1 : $parseUser->collaborationCounter = $user->getCollaborationCounter();
            is_null($user->getComments()) ? $parseUser->comments = null : $parseUser->comments = toParseAddRelation('Comment', $user->getComments());
            is_null($user->getCountry()) ? $parseUser->country = null : $parseUser->country = $user->getCountry();
            is_null($user->getDescription()) ? $parseUser->description = null : $parseUser->description = $user->getDescription();
            is_null($user->getEmail()) ? $parseUser->email = null : $parseUser->email = $user->getEmail();
            is_null($user->getEvents()) ? $parseUser->events = null : $parseUser->events = toParseAddRelation('Event', $user->getEvents());
            is_null($user->getFacebookId()) ? $parseUser->facebookId = null : $parseUser->facebookId = $user->getFacebookId();
            is_null($user->getFbPage()) ? $parseUser->fbPage = null : $parseUser->fbPage = $user->getFbPage();
            is_null($user->getFirstname()) ? $parseUser->firstname = null : $parseUser->firstname = $user->getFirstname();
            is_null($user->getFollowers()) ? $parseUser->followers = null : $parseUser->followers = toParseAddRelation('_User', $user->getFollowers());
            is_null($user->getFollowersCounter()) ? $parseUser->followersCounter = -1 : $parseUser->followersCounter = $user->getFollowersCounter();
            is_null($user->getFollowing()) ? $parseUser->following = null : $parseUser->following = toParseAddRelation('_User', $user->getFollowing());
            is_null($user->getFollowingCounter()) ? $parseUser->followingCounter = -1 : $parseUser->followingCounter = $user->getFollowingCounter();
            is_null($user->getFriendship()) ? $parseUser->friendship = null : $parseUser->friendship = toParseAddRelation('_User', $user->getFriendship());
            is_null($user->getFriendshipCounter()) ? $parseUser->friendshipCounter = -1 : $parseUser->friendshipCounter = $user->getFriendshipCounter();
            is_null($user->getGooglePlusPage()) ? $parseUser->googlePlusPage = null : $parseUser->googlePlusPage = $user->getGooglePlusPage();
            is_null($user->getGeoCoding()) ? $parseUser->geoCoding = null : $parseUser->geoCoding = toParseGeoPoint($user->getGeoCoding());
            is_null($user->getImages()) ? $parseUser->images = null : $parseUser->images = toParseAddRelation('Image', $user->getImages());
            is_null($user->getJammerCounter()) ? $parseUser->jammerCounter = -1 : $parseUser->jammerCounter = $user->getJammerCounter();
            is_null($user->getJammerType()) ? $parseUser->jammerType = $nullArray : $parseUser->jammerType = $user->getJammerType();
            is_null($user->getLastname()) ? $parseUser->lastname = null : $parseUser->lastname = $user->getLastname();
            is_null($user->getLevel()) ? $parseUser->level = -1 : $parseUser->level = $user->getLevel();
            is_null($user->getLevelValue()) ? $parseUser->levelValue = -1 : $parseUser->levelValue = $user->getLevelValue();
            is_null($user->getLocalType()) ? $parseUser->localType = null : $parseUser->localType = $user->getLocalType();
            is_null($user->getLoveSongs()) ? $parseUser->loveSongs = null : $parseUser->loveSongs = toParseAddRelation('Song', $user->getLoveSongs());
            is_null($user->getMembers()) ? $parseUser->members = null : $parseUser->members = $user->getMembers();
            is_null($user->getMusic()) ? $parseUser->music = $nullArray : $parseUser->music = $user->getMusic();
            is_null($user->getPlaylists()) ? $parseUser->playlists = null : $parseUser->playlists = toParseAddRelation('Playlist', $user->getPlaylists());
            is_null($user->getPremium()) ? $parseUser->premium = null : $parseUser->premium = $user->getPremium();
            is_null($user->getPremiumExpirationDate()) ? $parseUser->premiumExpirationDate = null : $parseUser->premiumExpirationDate = toParseDate($user->getPremiumExpirationDate());
            //is_null($user->getProfilePicture()) ? $parseUser->profilePicture = $default_img['DEFAVATAR'] : $parseUser->profilePicture = $user->getProfilePicture();
            is_null($user->getProfilePictureFile()) ? $parseUser->profilePictureFile = null : $parseUser->profilePictureFile = $user->getProfilePictureFile();
            //is_null($user->getProfileThumbnail()) ? $parseUser->profileThumbnail = $default_img['DEFAVATARTHUMB'] : $parseUser->profileThumbnail = $user->getProfileThumbnail();
            is_null($user->getRecords()) ? $parseUser->records = null : $parseUser->records = toParseAddRelation('Record', $user->getRecords());
            is_null($user->getSettings()) ? $parseUser->settings = $nullArray : $parseUser->settings = $user->getSettings();
            is_null($user->getSex()) ? $parseUser->sex = null : $parseUser->sex = $user->getSex();
            is_null($user->getSongs()) ? $parseUser->songs = null : $parseUser->songs = toParseAddRelation('Song', $user->getSongs());
            is_null($user->getStatuses()) ? $parseUser->statuses = null : $parseUser->statuses = toParseAddRelation('Status', $user->getStatuses());
            is_null($user->getTwitterPage()) ? $parseUser->twitterPage = null : $parseUser->twitterPage = $user->getTwitterPage();
            is_null($user->getType()) ? $parseUser->type = null : $parseUser->type = $user->getType();
            is_null($user->getVenueCounter()) ? $parseUser->venueCounter = -1 : $parseUser->venueCounter = $user->getVenueCounter();
            is_null($user->getVideos()) ? $parseUser->videos = null : $parseUser->videos = toParseAddRelation('Video', $user->getVideos());
            is_null($user->getWebsite()) ? $parseUser->website = null : $parseUser->website = $user->getWebsite();
            is_null($user->getYoutubeChannel()) ? $parseUser->youtubeChannel = null : $parseUser->youtubeChannel = $user->getYoutubeChannel();
            is_null($user->getACL()) ? $parseUser->ACL = null : $parseUser->ACL = $user->getACL()->acl;
            if ($parseUser->type == 'SPOTTER') {
                $defAvatar = DEFAVATARSPOTTER;
                $defAvatarThumb = DEFTHUMBSPOTTER;
            } elseif ($parseUser->type == 'JAMMER') {
                $defAvatar = DEFAVATARJAMMER;
                $defAvatarThumb = DEFTHUMBJAMMER;
            } elseif ($parseUser->type == 'VENUE') {
                $defAvatar = DEFAVATARVENUE;
                $defAvatarThumb = DEFTHUMBVENUE;
            } else {
                return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
            }
            is_null($user->getProfilePicture()) ? $parseUser->profilePicture = $defAvatar : $parseUser->profilePicture = $user->getProfilePicture();
            is_null($user->getProfileThumbnail()) ? $parseUser->profileThumbnail = $defAvatarThumb : $parseUser->profileThumbnail = $user->getProfileThumbnail();
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

    /**
     * \fn		void setLimit($limit)
     * \brief	Sets the maximum number of User to return
     * \param	$limit	the maximum number
     */
    public function setLimit($limit) {
        $this->parseQuery->setLimit($limit);
    }

    /**
     * \fn		void setSkip($skip)
     * \brief	Sets the number of how many User must be discarded initially
     * \param	$skip	the number of User to skip
     */
    public function setSkip($skip) {
        $this->parseQuery->setSkip($skip);
    }

    public function socialLoginUser($authData) {
        try {
            $parseUser = new parseUser();
            $parseUser->addAuthData($authData);
            $res = $parseUser->socialLogin();
            debug(DEBUG_DIR, 'debug.txt', json_encode($res));
            return $res;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

    /**
     * \fn	void unlinkUser($user, $authData)
     * \brief	unlink the user account from a Social Network
     * \param	$user		the object that represent the User
     * \param	$authData	the array that represent the Parse authData
     * \return	array		the updatedAt time. Ex: {"updatedAt":"2013-11-11T16:56:47.632Z"}
     * \return	error		in case of exception
     */
    public function unlinkUser($user, $authData) {
        try {
            $parseUser = new parseUser();
            $parseUser->addAuthData($authData);
            //we use the linkAccounts function for mantain a standard code type
            $res = $parseUser->linkAccounts($user->getObjectId(), $user->getSessionToken());
            return $res;
        } catch (Exception $e) {
            return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
        }
    }

    /**
     * \fn		void updateField($objectId, $sessionToken, $field, $value, $isRelation = false, $typeRelation, $className)
     * \brief	Update a field of the object
     * \param	$objectId		the objectId of the User to update
     * \param	$sessionToken	the sessionToken of the User to update
     * \param	$field			the field of the User to update
     * \param	$value			the value to update te field
     * \param	$isRelation		[optional] default = false - define if the field is a relational type
     * \param	$typeRelation	[optional] default = '' - define if the relational update must add or remove the value from the field
     * \param	$className		[optional] default = '' - define the class of the type of object present into the relational field
     */
    public function updateField($objectId, $sessionToken, $field, $value, $isRelation = false, $typeRelation = '', $className = '') {
        if (is_null($objectId) || is_null($sessionToken) || is_null($field) || is_null($value))
            return throwError(new Exception('updateField parameters objectId, sessionToken, field and value must to be set'), __CLASS__, __FUNCTION__, func_get_args());
        if ($isRelation) {
            if (is_null($typeRelation) || is_null($className))
                return throwError(new Exception('updateField parameters typeRelation and className must to be set for relation update'), __CLASS__, __FUNCTION__, func_get_args());
            if ($typeRelation == 'add') {
                $parseUser = new parseUser();
                $parseUser->$field = toParseAddRelation($className, $value);
                $parseUser->update($objectId, $sessionToken);
            } elseif ($typeRelation == 'remove') {
                $parseUser = new parseUser();
                $parseUser->$field = toParseRemoveRelation($className, $value);
                $parseUser->update($objectId, $sessionToken);
            } else {
                return throwError(new Exception('updateField parameter typeRelation allow only "add" or "remove" value'), __CLASS__, __FUNCTION__, func_get_args());
            }
        } else {
            $parseUser = new parseUser();
            $parseUser->$field = $value;
            $parseUser->update($objectId, $sessionToken);
        }
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

    /**
     * \fn		void whereRelatedTo($field, $className, $objectId)
     * \brief	Sets a condition for which to return all the User objects present in the field $field of object $objectId of type $className
     * \param	$field		the string which represent the field
     * \param	$className	the string which represent the className
     * \param	$objectId	the string which represent the objectId
     */
    public function whereRelatedTo($field, $className, $objectId) {
        $this->parseQuery->whereRelatedTo($field, $className, $objectId);
    }

}

?>