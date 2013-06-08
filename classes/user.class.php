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

require_once'settings.php';

class User {

	//questi dati sono aggiornati solo dopo aver fatto save/userLogin/update
	private $objectId;
	private $username;
	private $password;
	private $authData;
	private $emailVerified;
	private $active;
	private $albums;
	private $background;
	private $city;
	private $comments;
	private $country;
	private $description;
	private $email;
	private $fbPage;
	private $geoCoding;
	private $images;
	private $level;
	private $levelValue; //si lascia per tutti, per ora si usa solo per lo spotter
	private $loveSongs;
	private $music;
	private $playlists;
	private $premium;
	private $premiumExpirationDate;
	private $profilePicture;
	private $profileThumbnail;
	private $sessionToken;
	private $settings;
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
	
	//****** FUNZIONI GET ***************************************************//
	
	public function getObjectId() {
		return $this->objectId;
	}
	
	public function getUsername() {
		return $this->username;
	}
	
	public function getPassword() {
		return $this->password;
	}
	
	public function getAuthData() {
		return $this->authData;
	}
	
	public function getEmailVerified() {
		return $this->emailVerified;
	}
	
	public function getActive() {
		return $this->active;
	}
	
	public function getAlbums() {
		return $this->albums;
	}
	
	public function getBackground() {
		return $this->background;
	}
	
	public function getCity() {
		return $this->city;
	}
	
	public function getComments() {
		return $this->comments;
	}
	
	public function getCountry() {
		return $this->country;
	}
	
	public function getDescription() {
		return $this->description;
	}
	
	public function getEmail() {
		return $this->email;
	}
	
	public function getFbPage() {
		return $this->fbPage;
	}
	
	public function getGeoCoding() {
		return $this->geoCoding;
	}
	
	public function getImages() {
		return $this->images;
	}
	
	public function getLevel() {
		return $this->level;
	}
	
	public function getLevelValue() {
		return $this->levelValue;
	}
	
	public function getLoveSongs() {
		return $this->loveSongs;
	}
	
	public function getMusic() {
		return $this->music;
	}
	
	public function getPlaylists() {
		return $this->playlists;
	}
	
	public function getPremium() {
		return $this->premium;
	}
	
	public function getPremiumExpirationDate() {
		return $this->premiumExpirationDate;
	}
	
	public function getProfilePicture() {
		return $this->profilePicture;
	}
	
	public function getProfileThumbnail() {
		return $this->profileThumbnail;
	}
	
	public function getSettings() {
		return $this->settings;
	}
	
	public function getStatuses() {
		return $this->statuses;
	}
	
	public function getTwitterPage() {
		return $this->twitterPage;
	}
	
	public function getType() {
		return $this->type;
	}
	
	public function getVideos() {
		return $this->videos;
	}
	
	public function getWebsite() {
		return $this->website;
	}
	
	public function getYoutubeChannel() {
		return $this->youtubeChannel;
	}
	
	public function getCreatedAt() {
		return $this->createdAt;
	}
	
	public function getUpdatedAt() {
		return $this->updatedAt;
	}
	
	public function getACL() {
		return $this->ACL;
	}
	
	public function getSessionToken() {
		return $this->sessionToken;
	}
	
	//****** FUNZIONI SET ***************************************************//
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
	
	public function setAlbums(array $albums) {
		$this->albums = $albums;
	}
	
	public function setBackground($background) {
		$this->background = $background;
	}
	
	public function setCity($city) {
		$this->city = $city;
	}
	
	public function setComments(array $comments) {
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
	
	public function setFbPage($fbPage) {
		$this->fbPage = $fbPage;
	}
	
	public function setGeoCoding($geoCoding) {
		$this->geoCoding = $geoCoding;
	}
	
	public function setImages(array $images) {
		$this->images = $images;
	}
	
	public function setLevel($level) {
		$this->level = $level;
	}
	
	public function setLevelValue($levelValue) {
		$this->view = $levelValue;
	}
	
	public function setLoveSongs(array $loveSongs) {
		$this->loveSongs = $loveSongs;
	}
	
	public function setMusic(array $music) {
		$this->music = $music;
	}
	
	public function setPlaylists(array $playlists) {
		$this->playlists = $playlists;
	}
	
	public function setPremium($premium) {
		$this->premium = $premium;
	}
	
	public function setPremiumExpirationDate(DateTime $premiumExpirationDate) {
		$this->premiumExpirationDate = $premiumExpirationDate;
	}
	
	public function setProfilePicture($profilePicture) {
		$this->profilePicture = $profilePicture;
	}
	
	public function setProfileThumbnail($profileThumbnail) {
		$this->profileThumbnail = $profileThumbnail;
	}
	
	public function setSettings(array $settings) {
		$this->settings = $settings;
	}
	
	public function setStatuses(array $statuses) {
		$this->statuses = $statuses;
	}
	
	public function setTwitterPage($twitterPage) {
		$this->twitterPage = $twitterPage;
	}
	
	public function setType($type) {
		$this->type = $type;
	}
	
	public function setVideos(array $videos) {
		$this->videos = $videos;
	}
	
	public function setWebsite($website) {
		$this->website = $website;
	}
	
	public function setYoutubeChannel($youtubeChannel) {
		$this->youtubeChannel = $youtubeChannel;
	}
	
	public function setUpdatedAt(DateTime $updatedAt) {
		$this->updatedAt = $updatedAt;
	}
	
	public function setCreatedAt(DateTime $createdAt) {
		$this->createdAt = $createdAt;
	}
	
	public function setACL($ACL) {
		$this->ACL = $ACL;
	}
	
	public function setSessionToken($sessionToken) {
		$this->sessionToken = $sessionToken;
	}
	
	public function __toString() {
		
		$string = '';
		$string .= '[objectId] => ' . $this->getObjectId() . '<br />';
		$string .= '[username] => ' . $this->getUsername() . '<br />';
		$string .= '[password] => ' . $this->getPassword() . '<br />';
		$string .= '[authData] => ' . $this->getAuthData() . '<br />';
		$string .= '[emailVerified] => ' . $this->getEmailVerified() . '<br />';
		$string .= '[active] => ' . $this->getActive() . '<br />';
		//TODO
		//$string .= '[albums] => ' . $this->getAlbums() . '<br />';
		$string .= '[background] => ' . $this->getBackground() . '<br />';
		$string .= '[city] => ' . $this->getCity() . '<br />';
		//TODO
		//$string .= '[comments] => ' . $this->getComments() . '<br />';
		$string .= '[country] => ' . $this->getCountry() . '<br />';
		$string .= '[description] => ' . $this->getDescription() . '<br />';
		$string .= '[email] => ' . $this->getEmail() . '<br />';
		$string .= '[fbPage] => ' . $this->getFbPage() . '<br />';
		$parseGeoPoint = $this->getGeoCoding();
		$string .= '[geoCoding] => ' . $parseGeoPoint->lat . ', ' . $parseGeoPoint->long . '<br />';
		//TODO
		//$string .= '[images] => ' . $this->getImages() . '<br />';
		$string .= '[level] => ' . $this->getLevel() . '<br />';
		$string .= '[levelValue] => ' . $this->getLevelValue() . '<br />';
		//TODO
		//$string .= '[loveSongs] => ' . $this->getLoveSongs() . '<br />';
		foreach ($this->getMusic() as $music) {
			$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$string .= '[music] => ' . $music . '<br />';
		}
		//TODO
		//$string .= '[playlists] => ' . $this->getPlaylists() . '<br />';
		$string .= '[premium] => ' . $this->getPremium() . '<br />';
		$string .= '[premiumExpirationDate] => ' . $this->getPremiumExpirationDate()->format('d-m-Y H:i:s') . '<br />';
		$string .= '[profilePicture] => ' . $this->getProfilePicture() . '<br />';
		$string .= '[profileThumbnail] => ' . $this->getProfileThumbnail() . '<br />';
		$string .= '[sessionToken] => ' . $this->getSessionToken() . '<br />';
		foreach ($this->getSettings() as $settings) {
			$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$string .= '[settings] => ' . $settings . '<br />';
		}
		//TODO
		//$string .= '[statuses] => ' . $this->getStatuses() . '<br />';
		$string .= '[twitterPage] => ' . $this->getTwitterPage() . '<br />';
		$string .= '[type] => ' . $this->getType() . '<br />';
		//TODO
		//$string .= '[videos] => ' . $this->getVideos() . '<br />';
		$string .= '[website] => ' . $this->getWebsite() . '<br />';
		$string .= '[youtubeChannel] => ' . $this->getYoutubeChannel() . '<br />';
		$string .= '[createdAt] => ' . $this->getCreatedAt()->format('d-m-Y H:i:s') . '<br />';
		$string .= '[updatedAt] => ' . $this->getUpdatedAt()->format('d-m-Y H:i:s') . '<br />';
		foreach ($this->getACL()->acl as $key => $acl) {
			$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$string .= '[key] => ' . $key . '<br />';
			foreach ($acl as $access => $value) {
				$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				$string .= '[access] => ' . $access . ' -> ' . $value . '<br />';
			}
		}
		
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
	
	public function setEvents(array $events) {
		$this->events = $events;
	}
	
	public function setLocalType($localType) {
		$this->localType = $localType;
	}
	
	public function __toString() {
		$string = parent::__toString();
		
		//TODO
		//$string.="[collaboration] => " . $this->getCollaboration() . "<br />";
		//$string.="[events] => " . $this->getEvents() . "<br />";
		$string.="[address] => " . $this->getAddress();
		$string.="[localType] => " . $this->getLocalType();
	
		return $string;
	}

}

class Jammer extends User {

	//solo jammer
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
	
	public function setCollaboration(array $collaboration) {
		$this->collaboration = $collaboration;
	}
	
	public function setEvents(array $events) {
		$this->events = $events;
	}
	
	public function setJammerType($jammerType) {
		$this->jammerType = $jammerType;
	}
	
	public function setMembers(array $members) {
		$this->members = $members;
	}
	
	public function setRecords(array $records) {
		$this->records = $records;
	}
	
	public function setSongs(array $songs) {
		$this->songs = $songs;
	}
	
	public function __toString() {
		$string = parent::__toString();
		//TODO
		//$string.="[collaboration] => " . $this->getCollaboration() . "<br />";
		//$string.="[events] => " . $this->getEvents() . "<br />";
		$string.="[jammerType] => " . $this->getJammerType() . "<br />";
		foreach ($this->getMembers() as $member) {
			$string.="&nbsp&nbsp&nbsp&nbsp&nbsp";
			$string.="[members] => " . $member . "<br />";
		}
		//TODO
		//$string.="[records] => " . $this->getRecords() . "<br />";
		//$string.="[songs] => " . $this->getSongs() . "<br />";
		
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
	
	//GETTER
	
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
	
	//SETTER
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
		//TODO
		//$string .= "[following]".$this->getFollowing()."<br />";
		//TODO
		//$string .= "[friendship]".$this->getFriendship()."<br />";
		$string .= "[lastname]" . $this->getLastname() . "<br />";
		$string .= "[sex]" . $this->getSex() . "<br />";
		
		return $string;
	}

}

?>