<?php

/* ! \par		Info Generali:
 *  \author		Stefano Muscas
 *  \version		1.0
 *  \date		2013
 *  \copyright		Jamyourself.com 2013
 *  \par		Info Classe:
 *  \brief		UserParse
 *  \details		Classe Parse dedicata allo  User
 *  \par		Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="https://github.com/lucagianneschi/jamyourself/wiki/API:-UserParse">API</a>
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'utilsClass.php';
require_once CLASSES_DIR . 'user.class.php';
require_once SERVICES_DIR . 'debug.service.php';

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
     * \fn	void addUniqueArrayUser($objectId, $field, $value)
     * \brief	add an element to an array filed
     * \param	$objectId of the user, field to add element, $value to be added to the field
     * \return	Error	the Error raised by the function
     */
    public function addUniqueArrayUser($objectId, $field, $value) {
	try {
	    $parseObject = new parseObject('_User');
	    $parseObject->addUniqueArray($field, $value);
	    $parseObject->update($objectId);
	} catch (Exception $e) {
	    return throwError($e, __CLASS__, __FUNCTION__, func_get_args());
	}
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
	    $this->deleteAllAlbums($objectId);
	    $this->deleteAllComments($objectId);
	    $this->deleteAllPlaylists($objectId);
	    if ($user->getType == 'VENUE' || $res->type == 'JAMMER') {
		$this->deleteAllEvents($objectId);
	    } elseif ($res->type == 'JAMMER') {
		$this->deleteAllRecords($objectId);
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
	    $user->setUsername(parse_decode_string($res->username));
	    $user->setActive($res->active);
	    $user->setAddress(parse_decode_string($res->address));
	    $user->setBackground($res->background);
	    $user->setBirthDay($res->birthDay);
	    $user->setBadge($res->badge);
	    $user->setCity(parse_decode_string($res->city));
	    $user->setCollaborationCounter($res->collaborationCounter);
	    $user->setCountry($res->country);
	    $user->setDescription(parse_decode_string($res->description));
	    $user->setEmail($res->email);
	    $user->setFacebookId($res->facebookId);
	    $user->setFbPage($res->fbPage);
	    $user->setFirstname(parse_decode_string($res->firstname));
	    $user->setFollowersCounter($res->followersCounter);
	    $user->setFollowingCounter($res->followingCounter);
	    $user->setFriendshipCounter($res->friendshipCounter);
	    $user->setGooglePlusPage($res->googlePlusPage);
	    $user->setGeoCoding(fromParseGeoPoint($res->geoCoding));
	    $user->setJammerCounter($res->jammerCounter);
	    $user->setJammerType($res->jammerType);
	    $user->setLastname(parse_decode_string($res->lastname));
	    $user->setLevel($res->level);
	    $user->setLevelValue($res->levelValue);
	    $user->setLocalType($res->localType);
	    $user->setMembers(parse_decode_array($res->members));
	    $user->setMusic(parse_decode_array($res->music));
	    $user->setPremium($res->premium);
	    $res->premium ? $user->setPremiumExpirationDate(fromParseDate($res->premiumExpirationDate)) : $user->setPremiumExpirationDate(null);
	    $user->setProfilePicture($res->profilePicture);
	    $user->setProfileThumbnail($res->profileThumbnail);
	    if (isset($res->sessionToken))
		$user->setSessionToken($res->sessionToken);
	    $user->setSettings($res->settings);
	    $user->setSex($res->sex);
	    $user->setTwitterPage($res->twitterPage);
	    $user->setType($res->type);
	    $user->setVenueCounter($res->venueCounter);
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
	    $parseUser->username = is_null($user->getUsername()) ? null : parse_encode_string($user->getUsername());
	    $parseUser->password = is_null($user->getPassword()) ? null : $user->getPassword();
	    $parseUser->active = is_null($user->getActive()) ? true : $user->getActive();
	    $parseUser->address = is_null($user->getAddress()) ? null : parse_encode_string($user->getAddress());
	    $parseUser->background = is_null($user->getBackground()) ? null : $user->getBackground();
	    $parseUser->badge = is_null($user->getBadge()) ? $nullArray : $user->getBadge();
	    $parseUser->birthDay = is_null($user->getBirthDay()) ? null : $user->getBirthDay();
	    $parseUser->city = is_null($user->getCity()) ? null : parse_encode_string($user->getCity());
	    $parseUser->collaboration = is_null($user->getCollaboration()) ? null : toParseAddRelation('_User', $user->getCollaboration());
	    $parseUser->collaborationCounter = is_null($user->getCollaborationCounter()) ? 0 : $user->getCollaborationCounter();
	    $parseUser->country = is_null($user->getCountry()) ? null : parse_encode_string($user->getCountry());
	    $parseUser->description = is_null($user->getDescription()) ? null : parse_encode_string($user->getDescription());
	    $parseUser->email = is_null($user->getEmail()) ? null : $user->getEmail();
	    $parseUser->facebookId = is_null($user->getFacebookId()) ? null : $user->getFacebookId();
	    $parseUser->fbPage = is_null($user->getFbPage()) ? null : $user->getFbPage();
	    $parseUser->firstname = is_null($user->getFirstname()) ? null : parse_encode_string($user->getFirstname());
	    $parseUser->followers = is_null($user->getFollowers()) ? null : toParseAddRelation('_User', $user->getFollowers());
	    $parseUser->followersCounter = is_null($user->getFollowersCounter()) ? 0 : $user->getFollowersCounter();
	    $parseUser->following = is_null($user->getFollowing()) ? null : toParseAddRelation('_User', $user->getFollowing());
	    $parseUser->followingCounter = is_null($user->getFollowingCounter()) ? 0 : $user->getFollowingCounter();
	    $parseUser->friendship = is_null($user->getFriendship()) ? null : toParseAddRelation('_User', $user->getFriendship());
	    $parseUser->friendshipCounter = is_null($user->getFriendshipCounter()) ? 0 : $user->getFriendshipCounter();
	    $parseUser->googlePlusPage = is_null($user->getGooglePlusPage()) ? null : $user->getGooglePlusPage();
	    $parseUser->geoCoding = is_null($user->getGeoCoding()) ? null : toParseGeoPoint($user->getGeoCoding());
	    $parseUser->jammerCounter = is_null($user->getJammerCounter()) ? 0 : $user->getJammerCounter();
	    $parseUser->jammerType = is_null($user->getJammerType()) ? null : $user->getJammerType();
	    $parseUser->lastname = is_null($user->getLastname()) ? null : $user->getLastname();
	    $parseUser->level = is_null($user->getLevel()) ? 1 : $user->getLevel();
	    $parseUser->levelValue = is_null($user->getLevelValue()) ? 1 : $user->getLevelValue();
	    $parseUser->localType = is_null($user->getLocalType()) ? $nullArray : $user->getLocalType();
	    $parseUser->loveSongs = is_null($user->getLoveSongs()) ? null : toParseAddRelation('Song', $user->getLoveSongs());
	    $parseUser->members = is_null($user->getMembers()) ? $nullArray : parse_encode_array($user->getMembers());
	    $parseUser->music = is_null($user->getMusic()) ? $nullArray : $user->getMusic();
	    $parseUser->profilePicture = is_null($user->getProfilePicture()) ? null : $user->getProfilePicture();
	    $parseUser->profileThumbnail = is_null($user->getProfileThumbnail()) ? null : $user->getProfileThumbnail();
	    $parseUser->premium = is_null($user->getPremium()) ? false : $user->getPremium();
	    $parseUser->premiumExpirationDate = is_null($user->getPremiumExpirationDate()) ? null : toParseDate($user->getPremiumExpirationDate());
	    $parseUser->settings = is_null($user->getSettings()) ? $nullArray : $user->getSettings();
	    $parseUser->sex = is_null($user->getSex()) ? null : $user->getSex();
	    $parseUser->twitterPage = is_null($user->getTwitterPage()) ? null : $user->getTwitterPage();
	    $parseUser->type = is_null($user->getType()) ? null : $user->getType();
	    $parseUser->venueCounter = is_null($user->getVenueCounter()) ? 0 : $user->getVenueCounter();
	    $parseUser->website = is_null($user->getWebsite()) ? null : $user->getWebsite();
	    $parseUser->youtubeChannel = is_null($user->getYoutubeChannel()) ? null : $user->getYoutubeChannel();
	    $parseUser->ACL = is_null($user->getACL()) ? null : $user->getACL()->acl;
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

    /**
     * \fn	void socialLoginUser($authData)
     * \brief	Login for user with social network account (just FB actually)
     * \param	$authData
     */
    public function socialLoginUser($authData) {
	try {
	    $parseUser = new parseUser();
	    $parseUser->addAuthData($authData);
	    $res = $parseUser->socialLogin();
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
     * \param	$value			the value to update te field (in case of relational type, this value must be an array)
     * \param	$isRelation		[optional] default = false - define if the field is a relational type
     * \param	$typeRelation	[optional] default = '' - define if the relational update must add or remove the value from the field
     * \param	$className		[optional] default = '' - define the class of the type of object present into the relational field
     */
    public function updateField($objectId, $field, $value, $isRelation = false, $typeRelation = '', $className = '') {
	if (is_null($objectId) || is_null($field))
	    return throwError(new Exception('updateField parameters objectId and value must to be set'), __CLASS__, __FUNCTION__, func_get_args());
	if ($isRelation) {
	    if (is_null($typeRelation) || is_null($className))
		return throwError(new Exception('updateField parameters typeRelation and className must to be set for relation update'), __CLASS__, __FUNCTION__, func_get_args());
	    if ($typeRelation == 'add') {
		$parseObject = new parseObject('_User');
		$parseObject->$field = toParseAddRelation($className, $value);
		$parseObject->update($objectId);
	    } elseif ($typeRelation == 'remove') {
		$parseObject = new parseObject('_User');
		$parseObject->$field = toParseRemoveRelation($className, $value);
		$parseObject->update($objectId);
	    } else {
		return throwError(new Exception('updateField parameter typeRelation allow only "add" or "remove" value'), __CLASS__, __FUNCTION__, func_get_args());
	    }
	} else {
	    $parseObject = new parseObject('_User');
	    $parseObject->$field = $value;
	    $parseObject->update($objectId);
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
     * \fn		void whereInclude($field)
     * \brief	Sets a condition for which the field $field, that represent a Pointer, must return all the entire object
     * \param	$field	the string which represent the field
     */
    public function whereInclude($field) {
	$this->parseQuery->whereInclude($field);
    }

    /**
     * \fn	whereInQuery($field, $className, $array)
     * \brief	Sets a condition for which the field $field matches a value in the array $array
     * \param	$field, $className, $array
     */
    public function whereInQuery($field, $className, $array) {
	$this->parseQuery->whereInQuery($field, $className, $array);
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
     * \fn	whereNearSphere($latitude, $longitude, $distance, $distanceType)
     * \brief	find element in a spherre near the given latitude e longitude
     * \param	$latitude, $longitude
     */
    public function whereNearSphere($latitude, $longitude, $distance = null, $distanceType = null) {
	$this->parseQuery->whereNearSphere('geoCoding', $latitude, $longitude, $distance, $distanceType);
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
     * \fn	whereNotInQuery($field, $className, $array)
     * \brief	Sets a condition for which the field $field does not match a value in the array $array
     * \param	$field, $className, $array
     */
    public function whereNotInQuery($field, $className, $array) {
	$this->parseQuery->whereNotInQuery($field, $className, $array);
    }

    /**
     * \fn		void whereOr($value)
     * \brief	Sets a condition for which the field in the array $value must value al least one value
     * 			An example of $value is:
     * 			$value = array(
     * 				array('type' => 'EVENTUPDATED'),
     * 				array('album' => array('__type' => 'Pointer', 'className' => 'Album', 'objectId' => 'lK0bNWIi7k'))
     * 			);
     * \param	$field	the array representing the field and the value to put in or
     */
    public function whereOr($value) {
	$this->parseQuery->where('$or', $value);
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

    /**
     * \fn      deleteAllAlbums($objectId)
     * \brief	delete all albums for a user
     * \param	$objectId	of the user to be deleted
     */
    private function deleteAllAlbums($objectId) {
	require_once CLASSES_DIR . 'albumParse.class.php';
	$albumParse = new AlbumParse();
	$albumParse->wherePointer('fromUser', '_User', $objectId);
	$albumParse->where('active', true);
	$albumCount = $albumParse->getCount();
	$albumCicles = ceil($albumCount / MAX);
	for ($i = 0; $i < $albumCicles; ++$i) {
	    $albumParse->setLimit(MAX);
	    $albumParse->setSkip($i * MAX);
	    $albums = $albumParse->getAlbums();
	    foreach ($albums as $album) {
		$albumP = new AlbumParse();
		$albumP->deleteAlbum($album->getObjectId());
	    }
	}
    }

    /**
     * \fn      deleteAllComments($objectId)
     * \brief	delete all instances of Comment class for a user
     * \param	$objectId	of the user to be deleted
     */
    private function deleteAllComments($objectId) {
	require_once CLASSES_DIR . 'commentParse.class.php';
	$cmtParse = new CommentParse();
	$cmtParse->wherePointer('fromUser', '_User', $objectId);
	$cmtParse->where('active', true);
	$cmtCount = $cmtParse->getCount();
	$cmtCicles = ceil($cmtCount / MAX);
	for ($i = 0; $i < $cmtCicles; ++$i) {
	    $cmtParse->setLimit(MAX);
	    $cmtParse->setSkip($i * MAX);
	    $cmts = $cmtParse->getComments();
	    foreach ($cmts as $cmt) {
		$cmtP = new CommentParse();
		$cmtP->deleteComment($cmt->getObjectId());
	    }
	}
    }

    /**
     * \fn      deleteAllEvents($objectId)
     * \brief	delete all instances of Events class for a user
     * \param	$objectId	of the user to be deleted
     */
    private function deleteAllEvents($objectId) {
	require_once CLASSES_DIR . 'eventParse.class.php';
	$eventP = new EventParse();
	$eventP->wherePointer('fromUser', '_User', $objectId);
	$eventP->where('active', true);
	$eventCount = $eventP->getCount();
	$eventCicles = ceil($eventCount / MAX);
	for ($i = 0; $i < $eventCicles; ++$i) {
	    $eventP->setLimit(MAX);
	    $eventP->setSkip($i * MAX);
	    $events = $eventP->getEvent();
	    foreach ($events as $event) {
		$eventParse = new EventParse();
		$eventParse->deleteEvent($event->getObjectId());
	    }
	}
    }

    /**
     * \fn      deleteAllPlaylists($objectId)
     * \brief	delete all instances of playlist class for a user
     * \param	$objectId	of the user to be deleted
     */
    private function deleteAllPlaylists($objectId) {
	require_once CLASSES_DIR . 'playlistParse.class.php';
	$plParse = new PlaylistParse();
	$plParse->wherePointer('fromUser', '_User', $objectId);
	$plParse->where('active', true);
	$playlistCount = $plParse->getCount();
	$playlistCicles = ceil($playlistCount / MAX);
	for ($i = 0; $i < $playlistCicles; ++$i) {
	    $plParse->setLimit(MAX);
	    $plParse->setSkip($i * MAX);
	    $playlists = $plParse->getComments();
	    foreach ($playlists as $playlist) {
		$playlistP = new PlaylistParse();
		$playlistP->deletePlaylist($playlist->getObjectId());
	    }
	}
    }

    /**
     * \fn      deleteAllRecords($objectId)
     * \brief	delete all instances of Record class for a user
     * \param	$objectId	of the user to be deleted
     */
    private function deleteAllRecords($objectId) {
	require_once CLASSES_DIR . 'recordParse.class.php';
	$recordP = new RecordParse();
	$recordP->wherePointer('fromUser', '_User', $objectId);
	$recordP->where('active', true);
	$recordCount = $recordP->getCount();
	$recordCicles = ceil($recordCount / MAX);
	for ($i = 0; $i < $recordCicles; ++$i) {
	    $recordP->setLimit(MAX);
	    $recordP->setSkip($i * MAX);
	    $records = $recordP->getRecords();
	    foreach ($records as $record) {
		$recordParse = new RecordParse();
		$recordParse->deleteRecord($record->getObjectId());
	    }
	}
    }

    /**
     * \fn      deleteAllVideos($objectId)
     * \brief	delete all instances of Video class for a user
     * \param	$objectId	of the user to be deleted
     */
    private function deleteAllVideos($objectId) {
	require_once CLASSES_DIR . 'videoParse.class.php';
	$videoParse = new VideoParse();
	$videoParse->wherePointer('fromUser', '_User', $objectId);
	$videoParse->where('active', true);
	$videoCount = $videoParse->getCount();
	$videoCicles = ceil($videoCount / MAX);
	for ($i = 0; $i < $videoCicles; ++$i) {
	    $videoParse->setLimit(MAX);
	    $videoParse->setSkip($i * MAX);
	    $videos = $videoParse->getVideos();
	    foreach ($videos as $video) {
		$videoP = new VideoParse();
		$videoP->deleteVideo($video->getObjectId());
	    }
	}
    }

}

?>