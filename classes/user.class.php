<?php

/* ! \par 		Info Generali:
 *  \author		Stefano Muscas
 *  \version		0.3
 *  \date		2013
 *  \copyright		Jamyourself.com 2013
 *  \par		Info Classe:
 *  \brief		User Class
 *  \details		Classe utente
 *  \par		Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="https://github.com/lucagianneschi/jamyourself/wiki/Definizione-Classe:-User">Descrizione della classe</a>
 *  <a href="https://github.com/lucagianneschi/jamyourself/wiki/API:-User">API</a>
 */

class User {

    private $objectId;
    private $createdAt;
    private $updatedAt;
    private $password;
    private $active;
    private $address;
    private $avatar;
    private $background;
    private $birthDay;
    private $city;
    private $collaborationCounter;
    private $country;
    private $description;
    private $email;
    private $facebookId;
    private $fbPage;
    private $firstname;
    private $followersCounter;
    private $followingCounter;
    private $friendshipCounter;
    private $googlePlusPage;
    private $jammerCounter;
    private $jammerType;
    private $lastname;
    private $latitude;
    private $level;
    private $levelValue;
    private $longitude;
    private $premium;
    private $premiumExpirationDate;
    private $thumbnail;
    private $settings;
    private $sex;
    private $twitterPage;
    private $type;
    private $username;
    private $venueCounter;
    private $website;
    private $youtubeChannel;

    /**
     * \fn	void __construct($type)
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
     * \fn	int getObjectId()
     * \brief	Return the objectId value
     * \return	string
     */
    public function getObjectId() {
	return $this->objectId;
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
     * \fn	string getAvatar()
     * \brief	Return the profile picture link of the User
     * \return	string
     */
    public function getAvatar() {
	return $this->avatar;
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
     * \fn		number getCollaborationCounter()
     * \brief	Return the number of User in collaboration with
     * \return	number
     */
    public function getCollaborationCounter() {
	return $this->collaborationCounter;
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
     * \fn		number getLevel()
     * \brief	Return the number of User followed
     * \return	number
     */
    public function getFollowersCounter() {
	return $this->followersCounter;
    }

    /**
     * \fn		number getFollowingCounter()
     * \brief	Return the number of User followed
     * \return	number
     */
    public function getFollowingCounter() {
	return $this->followingCounter;
    }

    /**
     * \fn		number getLevel()
     * \brief	Return the number of User in friendship relation
     * \return	number
     */
    public function getFriendshipCounter() {
	return $this->friendshipCounter;
    }

    /**
     * \fn		string getGooglePlusPage()
     * \brief	Return the googlePlus page link of the User
     * \return	string
     */
    public function getGooglePlusPage() {
	return $this->googlePlusPage;
    }

    /**
     * \fn		number getJammerCounter()
     * \brief	Return the jammer counter, number of Jammer in collaboration
     * \return	number
     */
    public function getJammerCounter() {
	return $this->jammerCounter;
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
     * \fn		string getLastname()
     * \brief	Return the lastname of the User
     * \return	string
     */
    public function getLastname() {
	return $this->lastname;
    }

    /**
     * \fn	getLatitude()
     * \brief	Return the latitude value
     * \return	latitude
     */
    public function getLatitude() {
	return $this->latitude;
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
     * \fn	getLongitude()
     * \brief	Return the longitude value
     * \return	long
     */
    public function getLongitude() {
	return $this->longitude;
    }

    /**
     * \fn	string getPassword()
     * \brief	Return the password of the User
     * \return	string
     */
    public function getPassword() {
	return $this->password;
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
     * \fn	string getThumbnail()
     * \brief	Return the thumbnail profile picture link of the User
     * \return	string
     */
    public function getThumbnail() {
	return $this->thumbnail;
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
     * \fn		string getUsername()
     * \brief	Return the username of the User
     * \return	string
     */
    public function getUsername() {
	return $this->username;
    }

    /**
     * \fn		number getVenueCounter()
     * \brief	Return venue counter, number of venue in collaboration
     * \return	number
     */
    public function getVenueCounter() {
	return $this->venueCounter;
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
     * \fn		void setObjectId($objectId)
     * \brief	Sets the objectId value
     * \param	string
     */
    public function setObjectId($objectId) {
	$this->objectId = $objectId;
    }

    /**
     * \fn	void setCreatedAt($createdAt)
     * \brief	Sets the User creation date
     * \param	DateTime
     */
    public function setUpdatedAt(DateTime $updatedAt) {
	$this->updatedAt = $updatedAt;
    }

    /**
     * \fn	void setUpdatedAt($updatedAt)
     * \brief	Sets the User modification date
     * \param	DateTime
     */
    public function setCreatedAt(DateTime $createdAt) {
	$this->createdAt = $createdAt;
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
     * \fn	void setAvatar($avatar)
     * \brief	Sets the avatar of the User
     * \param	string
     */
    public function setAvatar($avatar) {
	$this->avatar = $avatar;
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
     * \fn	string setBirthDay($birthDay)
     * \brief	Sets the birthday of the User represented by a string with format YYYY-MM-DD
     * \param	string
     */
    public function setBirthDay($birthDay) {
	$this->birthDay = $birthDay;
    }

    /**
     * \fn	void setCity($city)
     * \brief	Sets the city value of the User
     * \param	string
     */
    public function setCity($city) {
	$this->city = $city;
    }

    /**
     * \fn	void setLevel($collaborationCounter)
     * \brief	Sets the collaborationCounter of the User
     * \param	number
     */
    public function setCollaborationCounter($collaborationCounter) {
	$this->collaborationCounter = $collaborationCounter;
    }

    /**
     * \fn	void setCountry($country)
     * \brief	Sets the country value of the User
     * \param	string
     */
    public function setCountry($country) {
	$this->country = $country;
    }

    /**
     * \fn	void setDescription($description)
     * \brief	Sets the description value of the User
     * \param	string
     */
    public function setDescription($description) {
	$this->description = $description;
    }

    /**
     * \fn	void setEmail($email)
     * \brief	Sets the email value of the User
     * \param	string
     */
    public function setEmail($email) {
	$this->email = $email;
    }

    /**
     * \fn	string setFacebookId($facebookId)
     * \brief	Sets the facebook id of the User
     * \param	string
     */
    public function setFacebookId($facebookId) {
	$this->facebookId = $facebookId;
    }

    /**
     * \fn	void setFbPage($fbPage)
     * \brief	Sets the facebook page link of the User
     * \param	string
     */
    public function setFbPage($fbPage) {
	$this->fbPage = $fbPage;
    }

    /**
     * \fn	string setFirstname($firstname)
     * \brief	Sets the firstname id of the User
     * \param	string
     */
    public function setFirstname($firstname) {
	$this->firstname = $firstname;
    }

    /**
     * \fn	void setFollowersCounter($followersCounter)
     * \brief	Sets the followersCounter of the User
     * \param	number
     */
    public function setFollowersCounter($followersCounter) {
	$this->followersCounter = $followersCounter;
    }

    /**
     * \fn	void setFollowingCounter($followingCounter)
     * \brief	Sets the followingCounter of the User
     * \param	number
     */
    public function setFollowingCounter($followingCounter) {
	$this->followingCounter = $followingCounter;
    }

    /**
     * \fn	void setFriendshipCounter($friendshipCounter)
     * \brief	Sets the friendshipCounter of the User
     * \param	number
     */
    public function setFriendshipCounter($friendshipCounter) {
	$this->friendshipCounter = $friendshipCounter;
    }

    /**
     * \fn	void setGooglePlusPage($googlePlusPage)
     * \brief	Sets the google plus page link of the User
     * \param	string
     */
    public function setGooglePlusPage($googlePlusPage) {
	$this->googlePlusPage = $googlePlusPage;
    }

    /**
     * \fn	void setJammerCounter($jammerCounter)
     * \brief	Sets the jammer counter 
     * \param	number
     */
    public function setJammerCounter($jammerCounter) {
	$this->jammerCounter = $jammerCounter;
    }

    /**
     * \fn	void setJammerType($jammerType)
     * \brief	Sets the jammer type of the User
     * \param	string
     */
    public function setJammerType($jammerType) {
	$this->jammerType = $jammerType;
    }

    /**
     * \fn	string setLastname($lastname)
     * \brief	Sets the lastname id of the User
     * \param	string
     */
    public function setLastname($lastname) {
	$this->lastname = $lastname;
    }

    /**
     * \fn	void setLatitude($latitude)
     * \brief	Sets the latitude value
     * \param	$longitude
     */
    public function setLatitude($latitude) {
	$this->latitude = $latitude;
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
     * \fn	void setLongitude($longitude)
     * \brief	Sets the longitude value
     * \param	$longitude
     */
    public function setLongitude($longitude) {
	$this->longitude = $longitude;
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
     * \fn		void setPassword($password)
     * \brief	Sets the password value of the User
     * \param	string
     */
    public function setPassword($password) {
	$this->password = $password;
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
     * \fn	void setThumbnail($thumbnail)
     * \brief	Sets the profile picture thumbnail link of the User
     * \param	string
     */
    public function setThumbnail($thumbnail) {
	$this->thumbnail = $thumbnail;
    }

    /**
     * \fn	void setSettings($settings)
     * \brief	Sets an array of settings of the User
     * \param	array
     */
    public function setSettings($settings) {
	$this->settings = $settings;
    }

    /**
     * \fn	string setSex($sex)
     * \brief	Sets the sex id of the User
     * \param	string
     */
    public function setSex($sex) {
	$this->sex = $sex;
    }

    /**
     * \fn	void setTwitterPage($twitterPage)
     * \brief	Sets the twitter page link of the User
     * \param	string
     */
    public function setTwitterPage($twitterPage) {
	$this->twitterPage = $twitterPage;
    }

    /**
     * \fn	void setType($type)
     * \brief	Sets the type of the User
     * \param	string
     */
    public function setType($type) {
	$this->type = $type;
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
     * \fn	void setVenueCounter($venueCounter)
     * \brief	Sets the venue counter 
     * \param	number
     */
    public function setVenueCounter($venueCounter) {
	$this->venueCounter = $venueCounter;
    }

    /**
     * \fn	void setWebsite($website)
     * \brief	Sets the website link of the User
     * \param	string
     */
    public function setWebsite($website) {
	$this->website = $website;
    }

    /**
     * \fn	void setYoutubeChannel($youtubeChannel)
     * \brief	Sets the youtube channel link of the User
     * \param	string
     */
    public function setYoutubeChannel($youtubeChannel) {
	$this->youtubeChannel = $youtubeChannel;
    }

    /**
     * \fn	string __toString()
     * \brief	Return a printable string representing the User object
     * \return	string
     */
    public function __toString() {
	$string = '';
	$string .= '[objectId] => ' . $this->getObjectId() . '<br />';
	$string .= '[createdAt] => ' . $this->getCreatedAt()->format('d-m-Y H:i:s') . '<br />';
	$string .= '[updatedAt] => ' . $this->getUpdatedAt()->format('d-m-Y H:i:s') . '<br />';
	$string .= '[active] => ' . $this->getActive() . '<br />';
	$string .= '[address] => ' . $this->getAddress() . '<br />';
	$string .= '[avatar] => ' . $this->getAvatar() . '<br />';
	$string .= '[background] => ' . $this->getBackground() . '<br />';
	$string .= '[birthDay] => ' . $this->getBirthDay() . '<br />';
	$string .= '[city] => ' . $this->getCity() . '<br />';
	$string .= '[collaborationCounter] => ' . $this->getCollaborationCounter() . '<br />';
	$string .= '[country] => ' . $this->getCountry() . '<br />';
	$string .= '[description] => ' . $this->getDescription() . '<br />';
	$string .= '[email] => ' . $this->getEmail() . '<br />';
	$string .= '[facebookId] => ' . $this->getFacebookId() . '<br />';
	$string .= '[fbPage] => ' . $this->getFbPage() . '<br />';
	$string .= '[firstname] => ' . $this->getFirstname() . '<br />';
	$string .= '[followersCounter] => ' . $this->getFollowersCounter() . '<br />';
	$string .= '[followingCounter] => ' . $this->getFollowingCounter() . '<br />';
	$string .= '[friendshipCounter] => ' . $this->getFriendshipCounter() . '<br />';
	$string .= '[googlePlusPage] => ' . $this->getGooglePlusPage() . '<br />';
	$string .= '[jammerCounter] => ' . $this->getJammerCounter() . '<br />';
	$string .= '[jammerType] => ' . $this->getJammerType() . '<br />';
	$string .= '[lastname] => ' . $this->getLastname() . '<br />';
	$string .= '[latitude] => ' . $this->getLatitude() . '<br />';
	$string .= '[longitude] => ' . $this->getLongitude() . '<br />';
	$string .= '[level] => ' . $this->getLevel() . '<br />';
	$string .= '[levelValue] => ' . $this->getLevelValue() . '<br />';
	$string .= '[password] => ' . $this->getPassword() . '<br />';
	$string .= '[premium] => ' . $this->getPremium() . '<br />';
	if ($this->getPremiumExpirationDate() != null) {
	    $string .= '[premiumExpirationDate] => ' . $this->getPremiumExpirationDate()->format('d-m-Y H:i:s') . '<br />';
	} else {
	    $string .= '[premiumExpirationDate] => NULL<br />';
	}
	$string .= '[thumbnail] => ' . $this->getThumbnail() . '<br />';
	$string .= '[settings] => ' . $this->getSettings() . '<br />';
	$string .= '[sex] => ' . $this->getSex() . '<br />';
	$string .= '[twitterPage] => ' . $this->getTwitterPage() . '<br />';
	$string .= '[type] => ' . $this->getType() . '<br />';
	$string .= '[username] => ' . $this->getUsername() . '<br />';
	$string .= '[venueCounter] => ' . $this->getVenueCounter() . '<br />';
	$string .= '[website] => ' . $this->getWebsite() . '<br />';
	$string .= '[youtubeChannel] => ' . $this->getYoutubeChannel() . '<br />';
	return $string;
    }

}

?>