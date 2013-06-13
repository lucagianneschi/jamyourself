<?php

/* ! \par Info Generali:
 *  \author    Stefano Muscas
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par Info Classe:
 *  \brief     User Class
 *  \details   Classe utente
 *  
 *  \par Commenti:
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
	private $birthdDay;
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
	private $levelValue; //usato solo per lo SPOTTER
	private $localTime;
	private $loveSongs;
	private $members;
	private $music;
	private $playlists;
	private $premium;
	private $premiumExpirationDate;
	private $profilePicture;
	private $profileThumbnail;
	private $records;
	private $sessionToken;
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
	
	//COSTRUTTORE
	public function __construct() {
	}
	
	public function getObjectId() {
		return $this->objectId
	}

	public function getUsername() {
		return $this->username
	}

	public function getPassword() {
		return $this->password
	}

	public function getAuthData() {
		return $this->authData
	}

	public function getEmailVerified() {
		return $this->emailVerified
	}

	public function getActive() {
		return $this->active
	}

	public function getAddress() {
		return $this->address
	}

	public function getAlbums() {
		return $this->albums
	}

	public function getBackground() {
		return $this->background
	}

	public function getBirthdDay() {
		return $this->birthdDay
	}

	public function getCity() {
		return $this->city
	}

	public function getCollaboration() {
		return $this->collaboration
	}

	public function getComments() {
		return $this->comments
	}

	public function getCountry() {
		return $this->country
	}

	public function getDescription() {
		return $this->description
	}

	public function getEmail() {
		return $this->email
	}

	public function getEvents() {
		return $this->events
	}

	public function getFacebookId() {
		return $this->facebookId
	}

	public function getFbPage() {
		return $this->fbPage
	}

	public function getFirstname() {
		return $this->firstname
	}

	public function getFollowing() {
		return $this->following
	}

	public function getFriendship() {
		return $this->friendship
	}

	public function getGeoCoding() {
		return $this->geoCoding
	}

	public function getImages() {
		return $this->images
	}

	public function getJammerType() {
		return $this->jammerType
	}

	public function getLastname() {
		return $this->lastname
	}

	public function getLevel() {
		return $this->level
	}

	public function getLevelValue() {
		return $this->levelValue
	}

	public function getLocalTime() {
		return $this->localTime
	}

	public function getLoveSongs() {
		return $this->loveSongs
	}

	public function getMembers() {
		return $this->members
	}

	public function getMusic() {
		return $this->music
	}

	public function getPlaylists() {
		return $this->playlists
	}

	public function getPremium() {
		return $this->premium
	}

	public function getPremiumExpirationDate() {
		return $this->premiumExpirationDate
	}

	public function getProfilePicture() {
		return $this->profilePicture
	}

	public function getProfileThumbnail() {
		return $this->profileThumbnail
	}

	public function getRecords() {
		return $this->records
	}

	public function getSessionToken() {
		return $this->sessionToken
	}

	public function getSettings() {
		return $this->settings
	}

	public function getSex() {
		return $this->sex
	}

	public function getSongs() {
		return $this->songs
	}

	public function getStatuses() {
		return $this->statuses
	}

	public function getTwitterPage() {
		return $this->twitterPage
	}

	public function getType() {
		return $this->type
	}

	public function getVideos() {
		return $this->videos
	}

	public function getWebsite() {
		return $this->website
	}

	public function getYoutubeChannel() {
		return $this->youtubeChannel
	}

	public function getCreatedAt() {
		return $this->createdAt
	}

	public function getUpdatedAt() {
		return $this->updatedAt
	}

	public function getACL() {
		return $this->ACL
	}
	
	public function setObjectId($objectId) {
		$this->objectId = $objectId;
	}
	public function setUsername($username) {
		$this->username = $username;
	}
	public function setPassword($password) {
		$this->password = $password;
	}
	public function setAuthData($authData) {
		$this->authData = $authData;
	}
	public function setEmailVerified($emailVerified) {
		$this->emailVerified = $emailVerified;
	}
	public function setActive($active) {
		$this->active = $active;
	}
	public function setAddress($address) {
		$this->address = $address;
	}
	public function setAlbums($albums) {
		$this->albums = $albums;
	}
	public function setBackground($background) {
		$this->background = $background;
	}
	public function setBirthdDay($birthdDay) {
		$this->birthdDay = $birthdDay;
	}
	public function setCity($city) {
		$this->city = $city;
	}
	public function setCollaboration($collaboration) {
		$this->collaboration = $collaboration;
	}
	public function setComments($comments) {
		$this->comments = $comments;
	}
	public function setCountry($country) {
		$this->country = $country;
	}
	public function setDescription($description) {
		$this->description = $description;
	}
	public function setEmail($email) {
		$this->email = $email;
	}
	public function setEvents($events) {
		$this->events = $events;
	}
	public function setFacebookId($facebookId) {
		$this->facebookId = $facebookId;
	}
	public function setFbPage($fbPage) {
		$this->fbPage = $fbPage;
	}
	public function setFirstname($firstname) {
		$this->firstname = $firstname;
	}
	public function setFollowing($following) {
		$this->following = $following;
	}
	public function setFriendship($friendship) {
		$this->friendship = $friendship;
	}
	public function setGeoCoding($geoCoding) {
		$this->geoCoding = $geoCoding;
	}
	public function setImages($images) {
		$this->images = $images;
	}
	public function setJammerType($jammerType) {
		$this->jammerType = $jammerType;
	}
	public function setLastname($lastname) {
		$this->lastname = $lastname;
	}
	public function setLevel($level) {
		$this->level = $level;
	}
	public function setLevelValue($levelValue) {
		$this->levelValue = $levelValue;
	}
	public function setLocalTime($localTime) {
		$this->localTime = $localTime;
	}
	public function setLoveSongs($loveSongs) {
		$this->loveSongs = $loveSongs;
	}
	public function setMembers($members) {
		$this->members = $members;
	}
	public function setMusic($music) {
		$this->music = $music;
	}
	public function setPlaylists($playlists) {
		$this->playlists = $playlists;
	}
	public function setPremium($premium) {
		$this->premium = $premium;
	}
	public function setPremiumExpirationDate($premiumExpirationDate) {
		$this->premiumExpirationDate = $premiumExpirationDate;
	}
	public function setProfilePicture($profilePicture) {
		$this->profilePicture = $profilePicture;
	}
	public function setProfileThumbnail($profileThumbnail) {
		$this->profileThumbnail = $profileThumbnail;
	}
	public function setRecords($records) {
		$this->records = $records;
	}
	public function setSessionToken($sessionToken) {
		$this->sessionToken = $sessionToken;
	}
	public function setSettings($settings) {
		$this->settings = $settings;
	}
	public function setSex($sex) {
		$this->sex = $sex;
	}
	public function setSongs($songs) {
		$this->songs = $songs;
	}
	public function setStatuses($statuses) {
		$this->statuses = $statuses;
	}
	public function setTwitterPage($twitterPage) {
		$this->twitterPage = $twitterPage;
	}
	public function setType($type) {
		$this->type = $type;
	}
	public function setVideos($videos) {
		$this->videos = $videos;
	}
	public function setWebsite($website) {
		$this->website = $website;
	}
	public function setYoutubeChannel($youtubeChannel) {
		$this->youtubeChannel = $youtubeChannel;
	}
	public function setCreatedAt($createdAt) {
		$this->createdAt = $createdAt;
	}
	public function setUpdatedAt($updatedAt) {
		$this->updatedAt = $updatedAt;
	}
	public function setACL($ACL) {
		$this->ACL = $ACL;
	}
	
	public function __toString() {
		
		$string = '';
		
		$string .= '[objectId] => ' . $this->getObjectId() . '<br />';
		$string .= '[username] => ' . $this->getUsername() . '<br />';
		$string .= '[password] => ' . $this->getPassword() . '<br />';
		$string .= '[authData] => ' . $this->getAuthData() . '<br />';
		$string .= '[emailVerified] => ' . $this->getEmailVerified() . '<br />';
		$string .= '[active] => ' . $this->getActive() . '<br />';
		$string .= '[address] => ' . $this->getAddress() . '<br />';
		$string .= '[albums] => ' . $this->getAlbums() . '<br />';
		$string .= '[background] => ' . $this->getBackground() . '<br />';
		$string .= '[birthdDay] => ' . $this->getBirthdDay() . '<br />';
		$string .= '[city] => ' . $this->getCity() . '<br />';
		$string .= '[collaboration] => ' . $this->getCollaboration() . '<br />';
		$string .= '[comments] => ' . $this->getComments() . '<br />';
		$string .= '[country] => ' . $this->getCountry() . '<br />';
		$string .= '[description] => ' . $this->getDescription() . '<br />';
		$string .= '[email] => ' . $this->getEmail() . '<br />';
		$string .= '[events] => ' . $this->getEvents() . '<br />';
		$string .= '[facebookId] => ' . $this->getFacebookId() . '<br />';
		$string .= '[fbPage] => ' . $this->getFbPage() . '<br />';
		$string .= '[firstname] => ' . $this->getFirstname() . '<br />';
		$string .= '[following] => ' . $this->getFollowing() . '<br />';
		$string .= '[friendship] => ' . $this->getFriendship() . '<br />';
		$string .= '[geoCoding] => ' . $this->getGeoCoding() . '<br />';
		$string .= '[images] => ' . $this->getImages() . '<br />';
		$string .= '[jammerType] => ' . $this->getJammerType() . '<br />';
		$string .= '[lastname] => ' . $this->getLastname() . '<br />';
		$string .= '[level] => ' . $this->getLevel() . '<br />';
		$string .= '[levelValue] => ' . $this->getLevelValue() . '<br />'; //usato so
		$string .= '[localTime] => ' . $this->getLocalTime() . '<br />';
		$string .= '[loveSongs] => ' . $this->getLoveSongs() . '<br />';
		$string .= '[members] => ' . $this->getMembers() . '<br />';
		$string .= '[music] => ' . $this->getMusic() . '<br />';
		$string .= '[playlists] => ' . $this->getPlaylists() . '<br />';
		$string .= '[premium] => ' . $this->getPremium() . '<br />';
		$string .= '[premiumExpirationDate] => ' . $this->getPremiumExpirationDate() . '<br />';
		$string .= '[profilePicture] => ' . $this->getProfilePicture() . '<br />';
		$string .= '[profileThumbnail] => ' . $this->getProfileThumbnail() . '<br />';
		$string .= '[records] => ' . $this->getRecords() . '<br />';
		$string .= '[sessionToken] => ' . $this->getSessionToken() . '<br />';
		$string .= '[settings] => ' . $this->getSettings() . '<br />';
		$string .= '[sex] => ' . $this->getSex() . '<br />';
		$string .= '[songs] => ' . $this->getSongs() . '<br />';
		$string .= '[statuses] => ' . $this->getStatuses() . '<br />';
		$string .= '[twitterPage] => ' . $this->getTwitterPage() . '<br />';
		$string .= '[type] => ' . $this->getType() . '<br />';
		$string .= '[videos] => ' . $this->getVideos() . '<br />';
		$string .= '[website] => ' . $this->getWebsite() . '<br />';
		$string .= '[youtubeChannel] => ' . $this->getYoutubeChannel() . '<br />';
		$string .= '[createdAt] => ' . $this->getCreatedAt() . '<br />';
		$string .= '[updatedAt] => ' . $this->getUpdatedAt() . '<br />';
		$string .= '[ACL] => ' . $this->getACL() . '<br />';
		
		return $string;
	}

}

class Venue extends User {

	private $address;
	private $collaboration;
	private $events;
	private $localType;
	
	public function __construct() {
		parent::__construct();
		$this->setType("VENUE");
	}
	
	public function getAddress() {
		return $this->address;
	}
	
	public function getCollaboration() {
		return $this->collaboration;
	}
	
	public function getEvents() {
		return $this->events;
	}
	
	public function getLocalType() {
		return $this->localType;
	}
	
	public function setAddress($address) {
		$this->address = $address;
	}
	
	public function setCollaboration(array $collaboration) {
		$this->collaboration = $collaboration;
	}
	
	public function setEvents($events) {
		$this->events = $events;
	}
	
	public function setLocalType($localType) {
		$this->localType = $localType;
	}
	
	public function __toString() {
		$string = parent::__toString();
		
		$string.= '[collaboration] => ' . $this->getCollaboration() . '<br />';
		$string.= '[events] => ' . $this->getEvents() . '<br />';
		$string.= '[address] => ' . $this->getAddress() . '<br />';
		$string.= '[localType] => ' . $this->getLocalType() . '<br />';
	
		return $string;
	}

}

class Jammer extends User {

	private $collaboration;
	private $events;
	private $jammerType;
	private $members;
	private $records;
	private $songs;
	
	public function __construct() {
		$this->setType("JAMMER");
	}
	
	public function getCollaboration() {
		return $this->collaboration;
	}
	
	public function getEvents() {
		return $this->events;
	}
	
	public function getJammerType() {
		return $this->jammerType;
	}
	
	public function getMembers() {
		return $this->members;
	}
	
	public function getRecords() {
		return $this->records;
	}
	
	public function getSongs() {
		return $this->songs;
	}
	
	public function setCollaboration($collaboration) {
		$this->collaboration = $collaboration;
	}
	
	public function setEvents($events) {
		$this->events = $events;
	}
	
	public function setJammerType($jammerType) {
		$this->jammerType = $jammerType;
	}
	
	public function setMembers(array $members) {
		$this->members = $members;
	}
	
	public function setRecords($records) {
		$this->records = $records;
	}
	
	public function setSongs($songs) {
		$this->songs = $songs;
	}
	
	public function __toString() {
		$string = parent::__toString();
		
		$string.="[collaboration] => " . $this->getCollaboration() . "<br />";
		$string.="[events] => " . $this->getEvents() . "<br />";
		$string.="[jammerType] => " . $this->getJammerType() . "<br />";
		foreach ($this->getMembers() as $member) {
			$string.="&nbsp&nbsp&nbsp&nbsp&nbsp";
			$string.="[members] => " . $member . "<br />";
		}
		$string.="[records] => " . $this->getRecords() . "<br />";
		$string.="[songs] => " . $this->getSongs() . "<br />";
		
		return $string;
	}

}

class Spotter extends User {

	private $birthDay;
	private $facebookId;
	private $firstname;
	private $following;
	private $friendship;
	private $lastname;
	private $sex;
	
	public function __construct() {
		$this->setType("SPOTTER");
	}
	
	public function getBirthDay() {
		return $this->birthDay;
	}
	
	public function getFacebookId() {
		return $this->facebookId;
	}
	
	public function getFirstname() {
		return $this->firstname;
	}
	
	public function getFollowing() {
		return $this->following;
	}
	
	public function getFriendship() {
		return $this->friendship;
	}
	
	public function getLastname() {
		return $this->lastname;
	}
	
	public function getSex() {
		return $this->sex;
	}
	
	public function setBirthDay(DateTime $birthDay) {
		$this->birthDay = $birthDay;
	}
	
	public function setFacebookId($facebookId) {
		$this->facebookId = $facebookId;
	}
	
	public function setFirstname($firstname) {
		$this->firstname = $firstname;
	}
	
	public function setFollowing(array $following) {
		$this->following = $following;
	}
	
	public function setFriendship(array $friendship) {
		$this->friendship = $friendship;
	}
	
	public function setLastname($lastname) {
		$this->lastname = $lastname;
	}
	
	public function setSex($sex) {
		$this->sex = $sex;
	}
	
	public function __toString() {
		$string = parent::__toString();
	
		$string .= "[birthDay] => " . $this->this->getBirthDay()->format("d-m-Y") . "<br />";
		$string .= "[facebookId]" . $this->getFacebookId() . "<br />";
		$string .= "[firstname]" . $this->getFirstname() . "<br />";
		$string .= "[following]".$this->getFollowing()."<br />";
		$string .= "[friendship]".$this->getFriendship()."<br />";
		$string .= "[lastname]" . $this->getLastname() . "<br />";
		$string .= "[sex]" . $this->getSex() . "<br />";
		
		return $string;
	}

}

?>