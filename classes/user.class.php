<?php
/* ! \par 		Info Generali:
 *  \author		Stefano Muscas
 *  \version	1.0
 *  \date		2013
 *  \copyright	Jamyourself.com 2013
 *  \par		Info Classe:
 *  \brief		User Class
 *  \details	Classe utente
 *  \par		Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:user">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:user">API</a>
 */

require_once 'settings.php';

class User {

	private $objectId;
	private $username;
	private $password;
	private $authData;
	private $emailVerified;
	private $active;
	private $address;
	private $albums;
	private $background;
	private $birthDay;
	private $city;
	private $collaboration;
	private $comments;
	private $country;
	private $description;
	private $email;
	private $events;
	private $facebookId;
	private $fbPage;
	private $firstname;
	private $following;
	private $friendship;
	private $geoCoding;
	private $images;
	private $jammerType;
	private $lastname;
	private $level;
	private $levelValue;
	private $localType;
	private $loveSongs;
	private $members;
	private $music;
	private $playlists;
	private $premium;
	private $premiumExpirationDate;
	private $profilePicture;
	private $profilePictureFile;
	private $profileThumbnail;
	private $records;
	private $settings;
	private $sex;
	private $songs;
	private $statuses;
	private $twitterPage;
	private $type;
	private $videos;
	private $website;
	private $youtubeChannel;
	private $createdAt;
	private $updatedAt;
	private $ACL;
	private $sessionToken;

	/**
	 * \fn		void __construct($type)
	 * \brief	The constructor instantiate the type of the User
	 * \param	$type the string which represent the User type (VENUE|JAMMER|SPOTTER)
	 */
	public function __construct($type) {
		if (is_null($type) || !in_array($type, array('VENUE', 'JAMMER', 'SPOTTER'))) {
			$e = new Exception('User Class type must be defined');
			throwError($e, __CLASS__, __FUNCTION__, func_get_args());
			throw $e;
		} else {
			$this->setType($type);
		}
	}

	/**
	 * \fn		string getObjectId()
	 * \brief	Return the objectId value
	 * \return	string
	 */
	public function getObjectId() {
		return $this->objectId;
	}

	/**
	 * \fn		string getUsername()
	 * \brief	Return the username of the User
	 * \return	string
	 */
	public function getUsername() {
		return $this->username;
	}

	/**
	 * \fn		string getPassword()
	 * \brief	Return the password of the User
	 * \return	string
	 */
	public function getPassword() {
		return $this->password;
	}

	/**
	 * \fn		string getAuthData()
	 * \brief	Return the authorization data of the User
	 * \return	string
	 * \warning	the function is not used yet
	 */
	public function getAuthData() {
		return $this->authData;
	}

	/**
	 * \fn		string getEmailVerified()
	 * \brief	Return the email verification of the User
	 * \return	string
	 * \warning	the function is not used yet
	 */
	public function getEmailVerified() {
		return $this->emailVerified;
	}

	/**
	 * \fn		boolean getActive()
	 * \brief	Return the activation state of the User
	 * \return	boolean
	 */
	public function getActive() {
		return $this->active;
	}

	/**
	 * \fn		string getAddress()
	 * \brief	Return the address of the User
	 * \return	string
	 */
	public function getAddress() {
		return $this->address;
	}

	/**
	 * \fn		array getAlbum()
	 * \brief	Return an array of objectId of the Album related with the User
	 * \return	array
	 */
	public function getAlbums() {
		return $this->albums;
	}

	/**
	 * \fn		string getBackground()
	 * \brief	Return the background link of the User
	 * \return	string
	 */
	public function getBackground() {
		return $this->background;
	}

	/**
	 * \fn		string getBirthDay()
	 * \brief	Return the birthday of the User represented by a string with format YYYY-MM-DD
	 * \return	string
	 */
	public function getBirthDay() {
		return $this->birthDay;
	}

	/**
	 * \fn		string getCity()
	 * \brief	Return the city of the User
	 * \return	string
	 */
	public function getCity() {
		return $this->city;
	}

	/**
	 * \fn		array getCollaboration()
	 * \brief	Return an array of objectId of the User related with the User
	 * \return	array
	 */
	public function getCollaboration() {
		return $this->collaboration;
	}

	/**
	 * \fn		array getComments()
	 * \brief	Return an array of objectId of the Comment related with the User
	 * \return	array
	 */
	public function getComments() {
		return $this->comments;
	}

	/**
	 * \fn		string getCountry()
	 * \brief	Return the country of the User
	 * \return	string
	 */
	public function getCountry() {
		return $this->country;
	}

	/**
	 * \fn		string getDescription()
	 * \brief	Return the description of the User
	 * \return	string
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * \fn		string getEmail()
	 * \brief	Return the email of the User
	 * \return	string
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * \fn		array getEvents()
	 * \brief	Return an array of objectId of the Event related with the User
	 * \return	array
	 */
	public function getEvents() {
		return $this->events;
	}

	/**
	 * \fn		string getFacebookId()
	 * \brief	Return the facebook id of the User
	 * \return	string
	 */
	public function getFacebookId() {
		return $this->facebookId;
	}

	/**
	 * \fn		string getFbPage()
	 * \brief	Return the facebook page link of the User
	 * \return	string
	 */
	public function getFbPage() {
		return $this->fbPage;
	}

	/**
	 * \fn		string getFirstname()
	 * \brief	Return the firstname of the User
	 * \return	string
	 */
	public function getFirstname() {
		return $this->firstname;
	}

	/**
	 * \fn		array getFollowing()
	 * \brief	Return an array of objectId of the User related with the User
	 * \return	array
	 */
	public function getFollowing() {
		return $this->following;
	}

	/**
	 * \fn		array getFriendship()
	 * \brief	Return an array of objectId of the User related with the User
	 * \return	array
	 */
	public function getFriendship() {
		return $this->friendship;
	}

	/**
	 * \fn		parseGeoPoint getGeoCoding()
	 * \brief	Return the parseGeoPoint object of the User
	 * \return	parseGeoPoint
	 */
	public function getGeoCoding() {
		return $this->geoCoding;
	}

	/**
	 * \fn		string getJammerType()
	 * \brief	Return the jammer type of the User
	 * \return	string
	 */
	public function getJammerType() {
		return $this->jammerType;
	}

	/**
	 * \fn		array getImages()
	 * \brief	Return an array of objectId of the Image related with the User
	 * \return	array
	 */
	public function getImages() {
		return $this->images;
	}

	/**
	 * \fn		string getLastname()
	 * \brief	Return the lastname of the User
	 * \return	string
	 */
	public function getLastname() {
		return $this->lastname;
	}

	/**
	 * \fn		number getLevel()
	 * \brief	Return the level of the User
	 * \return	number
	 */
	public function getLevel() {
		return $this->level;
	}

	/**
	 * \fn		number getLevelValue()
	 * \brief	Return the level value of the User
	 * \return	number
	 */
	public function getLevelValue() {
		return $this->levelValue;
	}

	/**
	 * \fn		string getLocalType()
	 * \brief	Return the local type of the User
	 * \return	string
	 */
	public function getLocalType() {
		return $this->localType;
	}

	/**
	 * \fn		array getLoveSongs()
	 * \brief	Return an array of objectId of the Song related with the User
	 * \return	array
	 */
	public function getLoveSongs() {
		return $this->loveSongs;
	}

	/**
	 * \fn		array getMembers()
	 * \brief	Return an array of objectId of the User related with the User
	 * \return	array
	 */
	public function getMembers() {
		return $this->members;
	}

	/**
	 * \fn		array getMusic()
	 * \brief	Return an array of the type of music preferred by the User
	 * \return	array
	 */
	public function getMusic() {
		return $this->music;
	}

	/**
	 * \fn		array getPlaylists()
	 * \brief	Return an array of objectId of the Playlist related with the User
	 * \return	array
	 */
	public function getPlaylists() {
		return $this->playlists;
	}

	/**
	 * \fn		boolean getPremium()
	 * \brief	Return if the User has a Premium account
	 * \return	boolean
	 */
	public function getPremium() {
		return $this->premium;
	}

	/**
	 * \fn		DateTime getPremiumExpirationDate()
	 * \brief	Return the expiration date of the premium account of the User
	 * \return	DateTime
	 */
	public function getPremiumExpirationDate() {
		return $this->premiumExpirationDate;
	}

	/**
	 * \fn		string getProfilePicture()
	 * \brief	Return the profile picture link of the User
	 * \return	string
	 */
	public function getProfilePicture() {
		return $this->profilePicture;
	}

	/**
	 * \fn		File getProfilePictureFile()
	 * \brief	Return the file of the profile picture of the User
	 * \return	File
	 */
	public function getProfilePictureFile() {
		return $this->profilePictureFile;
	}

	/**
	 * \fn		string getProfilePictureFile()
	 * \brief	Return the thumbnail profile picture link of the User
	 * \return	string
	 */
	public function getProfileThumbnail() {
		return $this->profileThumbnail;
	}

	/**
	 * \fn		array getRecords()
	 * \brief	Return an array of objectId of the Record related with the User
	 * \return	array
	 */
	public function getRecords() {
		return $this->records;
	}

	/**
	 * \fn		array getSettings()
	 * \brief	Return an array of the setting of the User
	 * \return	array
	 */
	public function getSettings() {
		return $this->settings;
	}

	/**
	 * \fn		string getSex()
	 * \brief	Return the sex of the User
	 * \return	string
	 */
	public function getSex() {
		return $this->sex;
	}

	/**
	 * \fn		array getRecords()
	 * \brief	Return an array of objectId of the Song related with the User
	 * \return	array
	 */
	public function getSongs() {
		return $this->songs;
	}

	/**
	 * \fn		array getStatuses()
	 * \brief	Return an array of objectId of the Status related with the User
	 * \return	array
	 */
	public function getStatuses() {
		return $this->statuses;
	}

	/**
	 * \fn		string getTwitterPage()
	 * \brief	Return the twitter page link of the User
	 * \return	string
	 */
	public function getTwitterPage() {
		return $this->twitterPage;
	}

	/**
	 * \fn		string getType()
	 * \brief	Return the type of the User
	 * \return	string
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * \fn		array getVideos()
	 * \brief	Return an array of objectId of the Video related with the User
	 * \return	array
	 */
	public function getVideos() {
		return $this->videos;
	}

	/**
	 * \fn		string getWebsite()
	 * \brief	Return the website link of the User
	 * \return	string
	 */
	public function getWebsite() {
		return $this->website;
	}

	/**
	 * \fn		string getYoutubeChannel()
	 * \brief	Return the youtube channel link of the User
	 * \return	string
	 */
	public function getYoutubeChannel() {
		return $this->youtubeChannel;
	}

	/**
	 * \fn		DateTime getCreatedAt()
	 * \brief	Return the User creation date
	 * \return	DateTime
	 */
	public function getCreatedAt() {
		return $this->createdAt;
	}

	/**
	 * \fn		DateTime getUpdatedAt()
	 * \brief	Return the User modification date
	 * \return	DateTime
	 */
	public function getUpdatedAt() {
		return $this->updatedAt;
	}

	/**
	 * \fn		parseACL getACL()
	 * \brief	Return the parseACL object representing the User ACL 
	 * \return	parseACL
	 */
	public function getACL() {
		return $this->ACL;
	}

	/**
	 * \fn		string getSessionToken()
	 * \brief	Return the session token of the User
	 * \return	string
	 */
	public function getSessionToken() {
		return $this->sessionToken;
	}

	/**
	 * \fn		void setObjectId($objectId)
	 * \brief	Sets the objectId value
	 * \param	string
	 */
	public function setObjectId($objectId) {
		$this->objectId = $objectId;
	}

	/**
	 * \fn		void setUsername($username)
	 * \brief	Sets the username value of the User
	 * \param	string
	 */
	public function setUsername($username) {
		$this->username = $username;
	}

	/**
	 * \fn		void setPassword($password)
	 * \brief	Sets the password value of the User
	 * \param	string
	 */
	public function setPassword($password) {
		$this->password = $password;
	}

	/**
	 * \fn		void setAuthData($authData)
	 * \brief	Sets the authorization data of the User
	 * \param	string
	 * \warning	the function is not used yet
	 */
	public function setAuthData($authData) {
		$this->authData = $authData;
	}

	/**
	 * \fn		void setEmailVerified($emailVerified)
	 * \brief	Sets the email verification of the User
	 * \param	string
	 * \warning	the function is not used yet
	 */
	public function setEmailVerified($emailVerified) {
		$this->emailVerified = $emailVerified;
	}

	/**
	 * \fn		void setActive($active)
	 * \brief	Sets the active value of the User
	 * \param	boolean
	 */
	public function setActive($active) {
		$this->active = $active;
	}

	/**
	 * \fn		void setAddress($address)
	 * \brief	Sets the address of the User
	 * \param	string
	 */
	public function setAddress($address) {
		$this->address = $address;
	}

	/**
	 * \fn		void setAlbums($albums)
	 * \brief	Sets an array of objectId of the Album related with the User
	 * \param	array
	 */
	public function setAlbums($albums) {
		$this->albums = $albums;
	}

	/**
	 * \fn		void setBackground($background)
	 * \brief	Sets the background value of the User
	 * \param	string
	 */
	public function setBackground($background) {
		$this->background = $background;
	}

	/**
	 * \fn		string setBirthDay($birthDay)
	 * \brief	Sets the birthday of the User represented by a string with format YYYY-MM-DD
	 * \param	string
	 */
	public function setBirthDay($birthDay) {
		$this->birthDay = $birthDay;
	}

	/**
	 * \fn		void setCity($city)
	 * \brief	Sets the city value of the User
	 * \param	string
	 */
	public function setCity($city) {
		$this->city = $city;
	}

	/**
	 * \fn		void setCollaboration($collaboration)
	 * \brief	Sets an array of objectId of the User related with the User
	 * \param	array
	 */
	public function setCollaboration($collaboration) {
		$this->collaboration = $collaboration;
	}

	/**
	 * \fn		void setComments($comments)
	 * \brief	Sets an array of objectId of the Comment related with the User
	 * \param	array
	 */
	public function setComments($comments) {
		$this->comments = $comments;
	}

	/**
	 * \fn		void setCountry($country)
	 * \brief	Sets the country value of the User
	 * \param	string
	 */
	public function setCountry($country) {
		$this->country = $country;
	}

	/**
	 * \fn		void setDescription($description)
	 * \brief	Sets the description value of the User
	 * \param	string
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * \fn		void setEmail($email)
	 * \brief	Sets the email value of the User
	 * \param	string
	 */
	public function setEmail($email) {
		$this->email = $email;
	}

	/**
	 * \fn		void setEvents($events)
	 * \brief	Sets an array of objectId of the Event related with the User
	 * \param	array
	 */
	public function setEvents($events) {
		$this->events = $events;
	}

	/**
	 * \fn		string setFacebookId($facebookId)
	 * \brief	Sets the facebook id of the User
	 * \param	string
	 */
	public function setFacebookId($facebookId) {
		$this->facebookId = $facebookId;
	}

	/**
	 * \fn		void setFbPage($fbPage)
	 * \brief	Sets the facebook page link of the User
	 * \param	string
	 */
	public function setFbPage($fbPage) {
		$this->fbPage = $fbPage;
	}

	/**
	 * \fn		string setFirstname($firstname)
	 * \brief	Sets the firstname id of the User
	 * \param	string
	 */
	public function setFirstname($firstname) {
		$this->firstname = $firstname;
	}

	/**
	 * \fn		void setFollowing($following)
	 * \brief	Sets an array of objectId of the User related with the User
	 * \param	array
	 */
	public function setFollowing($following) {
		$this->following = $following;
	}

	/**
	 * \fn		void setFriendship($friendship)
	 * \brief	Sets an array of objectId of the User related with the User
	 * \param	array
	 */
	public function setFriendship($friendship) {
		$this->friendship = $friendship;
	}

	/**
	 * \fn		void setGeoCoding($geoCoding)
	 * \brief	Sets the parseGeoPoint object of the User
	 * \param	parseGeoPoint
	 */
	public function setGeoCoding($geoCoding) {
		$this->geoCoding = $geoCoding;
	}

	/**
	 * \fn		void setImages($images)
	 * \brief	Sets an array of objectId of the Image related with the User
	 * \param	array
	 */
	public function setImages($images) {
		$this->images = $images;
	}

	/**
	 * \fn		void setJammerType($jammerType)
	 * \brief	Sets the jammer type of the User
	 * \param	string
	 */
	public function setJammerType($jammerType) {
		$this->jammerType = $jammerType;
	}

	/**
	 * \fn		string setLastname($lastname)
	 * \brief	Sets the lastname id of the User
	 * \param	string
	 */
	public function setLastname($lastname) {
		$this->lastname = $lastname;
	}

	/**
	 * \fn		void setLevel($level)
	 * \brief	Sets the level of the User
	 * \param	number
	 */
	public function setLevel($level) {
		$this->level = $level;
	}

	/**
	 * \fn		void setLevelValue($levelValue)
	 * \brief	Sets the level value of the User
	 * \param	number
	 */
	public function setLevelValue($levelValue) {
		$this->view = $levelValue;
	}

	/**
	 * \fn		void setLocalType($localType)
	 * \brief	Sets the local type of the User
	 * \param	string
	 */
	public function setLocalType($localType) {
		$this->localType = $localType;
	}

	/**
	 * \fn		void setLoveSongs($loveSongs)
	 * \brief	Sets an array of objectId of the Song related with the User
	 * \param	array
	 */
	public function setLoveSongs($loveSongs) {
		$this->loveSongs = $loveSongs;
	}

	/**
	 * \fn		void setMembers($members)
	 * \brief	Sets an array of objectId of the User related with the User
	 * \param	array
	 */
	public function setMembers($members) {
		$this->members = $members;
	}

	/**
	 * \fn		void setMusic($music)
	 * \brief	Sets an array of the type of music preferred by the User
	 * \param	array
	 */
	public function setMusic($music) {
		$this->music = $music;
	}

	/**
	 * \fn		void setPlaylists($playlists)
	 * \brief	Sets an array of objectId of the Playlist related with the User
	 * \param	array
	 */
	public function setPlaylists($playlists) {
		$this->playlists = $playlists;
	}

	/**
	 * \fn		void setPremium($premium)
	 * \brief	Sets if the User has a Premium account
	 * \param	boolean
	 */
	public function setPremium($premium) {
		$this->premium = $premium;
	}

	/**
	 * \fn		void setPremiumExpirationDate($premiumExpirationDate)
	 * \brief	Sets the expiration date of the User Premium account
	 * \param	DateTime
	 */
	public function setPremiumExpirationDate($premiumExpirationDate) {
		$this->premiumExpirationDate = $premiumExpirationDate;
	}

	/**
	 * \fn		void setProfilePicture($profilePicture)
	 * \brief	Sets the profile picture link of the User
	 * \param	string
	 */
	public function setProfilePicture($profilePicture) {
		$this->profilePicture = $profilePicture;
	}

	/**
	 * \fn		void setProfilePictureFile($profilePictureFile)
	 * \brief	Sets the profile picture File of the User
	 * \param	File
	 */
	public function setProfilePictureFile($profilePictureFile) {
		$this->profilePictureFile = $profilePictureFile;
	}

	/**
	 * \fn		void setProfileThumbnail($profileThumbnail)
	 * \brief	Sets the profile picture thumbnail link of the User
	 * \param	string
	 */
	public function setProfileThumbnail($profileThumbnail) {
		$this->profileThumbnail = $profileThumbnail;
	}

	/**
	 * \fn		void setRecords($records)
	 * \brief	Sets an array of objectId of the Record related with the User
	 * \param	array
	 */
	public function setRecords($records) {
		$this->records = $records;
	}

	/**
	 * \fn		void setSettings($settings)
	 * \brief	Sets an array of settings of the User
	 * \param	array
	 */
	public function setSettings($settings) {
		$this->settings = $settings;
	}

	/**
	 * \fn		string setSex($sex)
	 * \brief	Sets the sex id of the User
	 * \param	string
	 */
	public function setSex($sex) {
		$this->sex = $sex;
	}

	/**
	 * \fn		void setSongs($songs)
	 * \brief	Sets an array of objectId of the Song related with the User
	 * \param	array
	 */
	public function setSongs($songs) {
		$this->songs = $songs;
	}

	/**
	 * \fn		void setStatuses($statuses)
	 * \brief	Sets an array of objectId of the Status related with the User
	 * \param	array
	 */
	public function setStatuses($statuses) {
		$this->statuses = $statuses;
	}

	/**
	 * \fn		void setTwitterPage($twitterPage)
	 * \brief	Sets the twitter page link of the User
	 * \param	string
	 */
	public function setTwitterPage($twitterPage) {
		$this->twitterPage = $twitterPage;
	}

	/**
	 * \fn		void setType($type)
	 * \brief	Sets the type of the User
	 * \param	string
	 */
	public function setType($type) {
		$this->type = $type;
	}

	/**
	 * \fn		void setVideos($videos)
	 * \brief	Sets an array of objectId of the Video related with the User
	 * \param	array
	 */
	public function setVideos($videos) {
		$this->videos = $videos;
	}

	/**
	 * \fn		void setWebsite($website)
	 * \brief	Sets the website link of the User
	 * \param	string
	 */
	public function setWebsite($website) {
		$this->website = $website;
	}

	/**
	 * \fn		void setYoutubeChannel($youtubeChannel)
	 * \brief	Sets the youtube channel link of the User
	 * \param	string
	 */
	public function setYoutubeChannel($youtubeChannel) {
		$this->youtubeChannel = $youtubeChannel;
	}

	/**
	 * \fn		void setCreatedAt($createdAt)
	 * \brief	Sets the User creation date
	 * \param	DateTime
	 */
	public function setUpdatedAt(DateTime $updatedAt) {
		$this->updatedAt = $updatedAt;
	}

	/**
	 * \fn		void setUpdatedAt($updatedAt)
	 * \brief	Sets the User modification date
	 * \param	DateTime
	 */
	public function setCreatedAt(DateTime $createdAt) {
		$this->createdAt = $createdAt;
	}

	/**
	 * \fn		void setACL($ACL)
	 * \brief	Sets the parseACL object representing the User ACL
	 * \param	parseACL
	 */
	public function setACL($ACL) {
		$this->ACL = $ACL;
	}

	/**
	 * \fn		void setSessionToken($sessionToken)
	 * \brief	Sets the session token of the User
	 * \param	string
	 */
	public function setSessionToken($sessionToken) {
		$this->sessionToken = $sessionToken;
	}

	/**
	 * \fn		string __toString()
	 * \brief	Return a printable string representing the User object
	 * \return	string
	 */
	public function __toString() {
		$string = '';
		$string .= '[objectId] => ' . $this->getObjectId() . '<br />';
		$string .= '[username] => ' . $this->getUsername() . '<br />';
		$string .= '[password] => ' . $this->getPassword() . '<br />';
		$string .= '[authData] => ' . $this->getAuthData() . '<br />';
		$string .= '[emailVerified] => ' . $this->getEmailVerified() . '<br />';
		if (is_null($this->getActive())) {
			$string .= '[active] => NULL<br />';
		} else {
			$this->getActive() ? $string .= '[active] => 1<br />' : $string .= '[active] => 0<br />';
		}
		$string.= '[address] => ' . $this->getAddress() . '<br />';
		if (count($this->getAlbums()) != 0) {
			foreach ($this->getAlbums() as $album) {
				$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				$string .= '[albums] => ' . $album . '<br />';
			}
		} else {
			$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$string .= '[albums] => NULL<br />';
		}
		$string .= '[background] => ' . $this->getBackground() . '<br />';
		$string .= '[birthDay] => ' . $this->getBirthDay() . '<br />';
		$string .= '[city] => ' . $this->getCity() . '<br />';
		if (count($this->getCollaboration()) != 0) {
			foreach ($this->getCollaboration() as $collaboration) {
				$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				$string .= '[collaboration] => ' . $collaboration . '<br />';
			}
		} else {
			$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$string .= '[collaboration] => NULL<br />';
		}
		if (count($this->getComments()) != 0) {
			foreach ($this->getComments() as $comments) {
				$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				$string .= '[comments] => ' . $comments . '<br />';
			}
		} else {
			$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$string .= '[comments] => NULL<br />';
		}
		$string .= '[country] => ' . $this->getCountry() . '<br />';
		$string .= '[description] => ' . $this->getDescription() . '<br />';
		$string .= '[email] => ' . $this->getEmail() . '<br />';
		if (count($this->getEvents()) != 0) {
			foreach ($this->getEvents() as $event) {
				$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				$string .= '[events] => ' . $event . '<br />';
			}
		} else {
			$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$string .= '[event] => NULL<br />';
		}
		$string .= '[facebookId] => ' . $this->getFacebookId() . '<br />';
		$string .= '[fbPage] => ' . $this->getFbPage() . '<br />';
		$string .= '[firstname] => ' . $this->getFirstname() . '<br />';
		if (count($this->getFollowing()) != 0) {
			foreach ($this->getFollowing() as $following) {
				$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				$string .= '[following] => ' . $following . '<br />';
			}
		} else {
			$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$string .= '[following] => NULL<br />';
		}
		if (count($this->getFriendship()) != 0) {
			foreach ($this->getFriendship() as $friendship) {
				$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				$string .= '[friendship] => ' . $friendship . '<br />';
			}
		} else {
			$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$string .= '[friendship] => NULL<br />';
		}
		if ($this->getGeoCoding() != null) {
			$geoCoding = $this->getGeoCoding();
			$string .= '[geoCoding] => ' . $geoCoding->lat . ', ' . $geoCoding->long . '<br />';
		} else {
			$string .= '[geoCoding] => NULL<br />';
		}
		if (count($this->getImages()) != 0) {
			foreach ($this->getImages() as $image) {
				$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				$string .= '[images] => ' . $image . '<br />';
			}
		} else {
			$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$string .= '[image] => NULL<br />';
		}
		$string .= '[jammerType] => ' . $this->getJammerType() . '<br />';
		$string .= '[lastname] => ' . $this->getLastname() . '<br />';
		$string .= '[level] => ' . $this->getLevel() . '<br />';
		$string .= '[levelValue] => ' . $this->getLevelValue() . '<br />';
		$string .= '[localType] => ' . $this->getLocalType() . '<br />';
		if (count($this->getLoveSongs()) != 0) {
			foreach ($this->getLoveSongs() as $loveSong) {
				$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				$string .= '[loveSongs] => ' . $loveSong . '<br />';
			}
		} else {
			$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$string .= '[loveSongs] => NULL<br />';
		}
		if ($this->getMembers()!= null && count($this->getMembers()) > 0) {
			foreach ($this->getMembers() as $member) {
				$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				$string .= '[members] => ' . $member . '<br />';
			}
		} else {
			$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$string .= '[members] => NULL<br />';
		}
		foreach ($this->getMusic() as $music) {
			$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$string .= '[music] => ' . $music . '<br />';
		}
		if (count($this->getPlaylists()) != 0) {
			foreach ($this->getPlaylists() as $playlist) {
				$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				$string .= '[playlists] => ' . $playlist . '<br />';
			}
		} else {
			$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$string .= '[playlists] => NULL<br />';
		}
		$string .= '[premium] => ' . $this->getPremium() . '<br />';
		if ($this->getPremiumExpirationDate() != null) {
			$string .= '[premiumExpirationDate] => ' . $this->getPremiumExpirationDate()->format('d-m-Y H:i:s') . '<br />';
		} else {
			$string .= '[premiumExpirationDate] => NULL<br />';
		}
		$string .= '[profilePicture] => ' . $this->getProfilePicture() . '<br />';
		$string .= '[profilePictureFile] => ' . $this->getProfilePictureFile() . '<br />';
		if (count($this->getRecords()) != 0) {
			foreach ($this->getRecords() as $record) {
				$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				$string .= '[records] => ' . $record . '<br />';
			}
		} else {
			$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$string .= '[records] => NULL<br />';
		}
		$string .= '[profileThumbnail] => ' . $this->getProfileThumbnail() . '<br />';
		$string .= '[sessionToken] => ' . $this->getSessionToken() . '<br />';
		foreach ($this->getSettings() as $settings) {
			$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$string .= '[settings] => ' . $settings . '<br />';
		}
		$string .= '[sex] => ' . $this->getSex() . '<br />';
		if (count($this->getSongs()) != 0) {
			foreach ($this->getSongs() as $song) {
				$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				$string .= '[songs] => ' . $song . '<br />';
			}
		} else {
			$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$string .= '[songs] => NULL<br />';
		}
		if (count($this->getStatuses()) != 0) {
			foreach ($this->getStatuses() as $status) {
				$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				$string .= '[status] => ' . $status . '<br />';
			}
		} else {
			$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$string .= '[statuss] => NULL<br />';
		}
		$string .= '[twitterPage] => ' . $this->getTwitterPage() . '<br />';
		$string .= '[type] => ' . $this->getType() . '<br />';
		if (count($this->getVideos()) != 0) {
			foreach ($this->getVideos() as $video) {
				$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				$string .= '[video] => ' . $video . '<br />';
			}
		} else {
			$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$string .= '[video] => NULL<br />';
		}
		$string .= '[website] => ' . $this->getWebsite() . '<br />';
		$string .= '[youtubeChannel] => ' . $this->getYoutubeChannel() . '<br />';
		if ($this->getCreatedAt() != null) {
			$string .= '[createdAt] => ' . $this->getCreatedAt()->format('d-m-Y H:i:s') . '<br />';
		} else {
			$string .= '[createdAt] => NULL<br />';
		}
		if ($this->getUpdatedAt() != null) {
			$string .= '[updatedAt] => ' . $this->getUpdatedAt()->format('d-m-Y H:i:s') . '<br />';
		} else {
			$string .= '[updatedAt] => NULL<br />';
		}
		if ($this->getACL() != null) {
			foreach ($this->getACL()->acl as $key => $acl) {
				$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				$string .= '[ACL] => ' . $key . '<br />';
				foreach ($acl as $access => $value) {
					$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					$string .= '[access] => ' . $access . ' -> ' . $value . '<br />';
				}
			}
		} else {
			$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$string .= '[ACL] => NULL<br />';
		}
		return $string;
	}

}

?>