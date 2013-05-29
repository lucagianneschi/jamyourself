<?php
//definizione classe:http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:user
//api:http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:user

require_once'settings.php';

class User{

	//questi dati sono aggiornati solo dopo aver fatto save/userLogin/update
	private $objectId;	
	private $username;
	private $password;
    private $authData;
	private $emailVerified;
	private $ID;//DA RIMUOVERE DOPO ALLINEAMENTO DB
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
	private $levelValue;//si lascia per tutti, per ora si usa solo per lo spotter
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

	public function __construct(){

	}

	//****** FUNZIONI SET ***************************************************//
	public function setObjectId($objectId){
		$this->objectId = $objectId;
	}
	
	public function setUsername($username){
		$this->username = $username;
	}

	public function setPassword($password){
		$this->password = $password;
	}

	public function setAuthData($authData){
		$this->authData = $authData;
	}

	public function setEmailVerified($emailVerified){
		$this->emailVerified = $emailVerified;
	}

	public function setID($ID){
		$this->ID = $ID;
	}

	public function setActive($active){
		$this->active = $active;
	}

	public function setAlbums(Relation $albums){
			$this->albums = $albums;
	}

	public function setBackground($background){
		$this->background = $background;
	}

	public function setCity($city){
		$this->city = $city;
	}

	public function setComments(Relation $comments){
			$this->comments = $comments;
	}

	public function setCountry($country){
		$this->country = $country;
	}

	public function setDescription($description){
		$this->description = $description;
	}

	public function setEmail($email){
		$this->email = $email;
	}

	public function setFbPage($fbPage){
		$this->fbPage = $fbPage;
	}

	public function setGeoCoding(parseGeoPoint $geoCoding){
			$this->geoCoding = $geoCoding;
	}

	public function setImages(Relation $images){
			$this->images = $images;
	}

	public function setLevel($level){
		$this->level = $level;
	}

	public function setLevelValue($levelValue ){
		$this->view = $levelValue;
	}

	public function setLoveSongs(Relation $loveSongs){
		$this->loveSongs = $loveSongs;
	}

	public function setMusic(array $music){
		$this->music = $music;
	}

	public function setPlaylists(Relation $playlists){
			$this->playlists = $playlists;
	}

	public function setPremium($premium){
		$this->premium = $premium;
	}

	public function setPremium(DateTime $premiumExpirationDate){
		$this->premiumExpirationDate = $premiumExpirationDate;
	}

	public function setProfilePicture($profilePicture){
		$this->profilePicture = $profilePicture;
	}

	public function setProfileThumbnail($profileThumbnail){
		$this->profileThumbnail = $profileThumbnail;
	}

	public function setSettings(array $settings){
		$this->settings = $settings;
	}

	public function setStatuses(Relation $status){
		$this->statuses = $statuses;
	}

	public function setTwitterPage($twitterPage){
		$this->twitterPage = $twitterPage;
	}

	public function setType($type){
		$this->type = $type;
	}

	public function setVideos(Relation $videos){
		$this->videos = $videos;
	}

	public function setWebsite($website){
		$this->website = $website;
	}

	public function setYoutubeChannel($youtubeChannel){
		$this->youtubeChannel = $youtubeChannel;
	}

	public function setSessionToken($sessionToken){
		$this->sessionToken = $sessionToken;
	}
	
	public function setUpdatedAt(DateTime $updatedAt){
		$this->updatedAt = $updatedAt;
	}
	
	public function setCreatedAt(DateTime $createdAt){
		$this->createdAt = $createdAt;
	}

	public function setACL($ACL){
		$this->ACL = $ACL;
	}

	//****** FUNZIONI GET ***************************************************//

	public function getObjectId(){
		return $this->objectId;
	}

	public function getUsername(){
		return $this->username;
	}

	public function getPassword(){
		return $this->password;
	}

	public function getAuthData(){
		return $this->authData;
	}

	public function getEmailVerified(){
		return $this->emailVerified;
	}

	public function getID(){
		return $this->ID;
	}

	public function getActive(){
		retun $this->active;
	}
	
	public function getAlbums(){
		retun $this->albums;
	}

	public function getBackground(){
		return $this->background;
	}

	public function getCity(){
		return $this->city;
	}

	public function getComments(){
		return $this->comments;
	}

	public function getCountry(){
		return $this->country;
	}

	public function getDescription(){
		return $this->description;
	}

	public function getEmail(){
		return $this->email;
	}

	public function getFbPage(){
		return $this->fbPage;
	}

	public function getGeoCoding(){
		return $this->geoCoding;	
	}

	public function getImages(){
		return $this->images;
	}

	public function getLevel(){
		return $this->level;
	}

	public function getLevelValue(){
		return $this->levelValue;
	}

	public function getLoveSongs(){
		return $this->loveSongs;
	}

	public function getMusic(){
		return $this->music;
	}

	public function getPlaylists(){
		return $this->playlists;
	}

	public function getPremium(){
		return $this->premium;
	}

	public function getPremiumExpiringDate(){
		return $this->premiumExpiringDate;
	}

	public function getProfilePicture(){
		return $this->profilePicture;
	}

	public function getProfileThumbnail(){
		return $this->profileThumbnail;
	}

	public function getSettings(){
		return $this->settings;
	}

	public function getStatuses(){
		return $this->statuses;
	}

	public function getTwitterPage(){
		return $this->twitterPage;
	}

	public function getType(){
		return $this->type;
	}


	public function getVideos(){
		return $this->videos;
	}

	public function getWebsite(){
		return $this->website;
	}

	public function getYoutubeChannel(){
		return $this->youtubeChannel;
	}

	public function getSessionToken(){
		return $this->sessionToken;
	}
	
	public function getCreatedAt(){
		return $this->createdAt;
	}

	public function getUpdatedAt(){
		return $this->updatedAt;
	}

	public function getACL(){
		return $this->ACL;
	}

	public function __toString(){
	
		$string ="";
		$string.="Tipo profilo: ".$this->getType()."<br>";
		$string.="Username : ".$this->getUsername()."<br>";
		$string.="E-mail : ".$this->getEmail()."<br>";
		$verStr="";
		if($this->getEmailVerified()) $verStr = "SI";
		else $verStr = "NO";
		$string.="Mail Verificata : ".$verStr."<br>";
		$string.="Id utente : ".$this->getObjectId()."<br>";
		$string.="Session Token : ".$this->getSessionToken()."<br>";
		if($this->getUpdatedAt())$string.="Ultimo aggiornamento : ".$this->getUpdatedAt()->format('d/m/Y H:i:s')."<br>";
		if($this->getCreatedAt())$string.="Data Creazione : ".$this->getCreatedAt()->format('d/m/Y H:i:s')."<br>";
		$string.="Nome : ".$this->getFirstname()."<br>";
		$string.="Cognome : ".$this->getLastname()."<br>";
		$string.="Sesso : ".$this->getSex()."<br>";
		$string.="Giorno di nascita : ".$this->getBirthDay()->format('d/m/Y')."<br>";		
		$parseGeopoint = $this->getGeoCoding();
		if($this->getGeoCoding())$string.="Geolocalizzazione : ".$parseGeopoint->__toString()."<br>";
		//$string.=" : ".$this->getPassword()."<br>";
		$string.="Livello : ".$this->getLevel()."<br>";
		$string.="Url foto : ".$this->getProfilePicture()."<br>";
		$string.="Url thumbnail : ".$this->getProfileThumbnail()."<br>";
		//$string.=" : ".$this->getStatus()."<br>";
		$string.="Sito WEB : ".$this->getWebsite()."<br>";
		$string.="Facebook : ".$this->getFbPage()."<br>";
		$string.="Twitter : ".$this->getTwitterPage()."<br>";
		$string.="Youtube : ".$this->getYoutubeChannel()."<br>";
		$string.="Id Facebook : ".$this->getFacebookId()."<br>";
		$string.="Citt� : ".$this->getCity()."<br>";
		$string.="Descrizione : ".$this->getDescription()."<br>";
		if($this->getMusic())$string.="Gusti musiali : ".implode(" , ",$this->getMusic())."<br>";
		//$string.=" : ".$this->getAuthData()."<br>";
		//$string.=" : ".$this->getBackground()."<br>";
		
		$premium="";
		if($this->getPremium() )$premium="SI";
		else $premium = "NO";
		$string.="Premium: ".$premium."<br>";
	
		//$string." :".$this->getSettings()."<br>";
	
		return $string;
	
	}

}

class Venue extends User{

	private $address;
	private $collaboration;
	private $events;
	private $localType;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->setType("VENUE");

	}
	//perchè geoPoint?? è una stringa dalla quale ricavi poi il geoPoint. NON POSSONO ESISTERE 2 GEOPOINT NELLA STESSA CLASSE
	public function setAddress(parseGeoPoint $address){
		$this->address  = $address;
	}

	public function setCollaboration(Relation $collaboration){
    	$this->collaboration = $collaboration;
	}

	public function setEvents(Relation $events){
    	$this->events = $events;
	}
	
	public function setLocalType($localType){
		$this->localType = $localType;
	}
	
	public function getAddress(){
		return $this->address;
	}

	public function getCollaboration(){
		return $this->collaboration;
	}

	public function getEvents(){
		return $this->events;
	}
	
	public function getLocalType(){
		return $this->localType;
	}
	
	public function __toString(){
	
		$string = parent::__toString();
	
		$string.="Indirizzo Locale: ".$this->getAddress();
		$string.="Tipologia Locale: ".$this->getLocalType();
		
		return $string;
	}

}

class Jammer extends User{

	//solo jammer
	private $collaboration;
	private $events;
	private $members;
	private $records;
	private $songs;
	private $jammerType;

	public function __construct()
	{
		$this->setType("JAMMER");
	}

	public function setCollaboration(Relation $collaboration){
    	$this->collaboration = $collaboration;
	}

	public function setEvents(Relation $events){
    	$this->events = $events;
	}

	public function setMembers(array $members){
		$this->members = $members;
	}

	public function setRecords(Relation $records){
		$this->records = $records;
	}

	public function setSongs(Relation $songs){
		$this->songs = $songs;
	}

	public function setJammerType(array $jammerType){//perchè array??? stringa?
		$this->jammerType = $jammerType;
	}

	public function getCollaboration(){
		return $this->collaboration;
	}

	public function getEvents(){
		return $this->events;
	}

	public function getMembers(){
		return $this->members;
	}

	public function getRecords(){
		return $this->records;
	}

	public function getSongs(){
		return $this->songs;
	}

	public function getJammerType($jammerType){
		return $this->jammerType;
	}


	public function __toString(){
		
		$string = parent::__toString();
		
		$string.="Membri della band: ".implode(" , ", $this->getMembers());		
		
		return $string;
	}

}

class Spotter extends User{

	private $birthDay;
	private $facebookId;
	private $firstname;
	private $following;
	private $friendship;
	private $lastname;
	private $sex;

	public function __construct()
	{
		$this->setType("SPOTTER");
	}

	//SETTER
	public function setBirthDay(DateTime $birthDay){
		$this->birthDay = $birthDay;	
	}

	public function setFacebookId($facebookId){
		$this->facebookId = $facebookId;
	}

	public function setFirstname($firstname){
		$this->firstname = $firstname;
	}
	public function setFollowing(Relation $following){
		$this->following = $following;
	}

	public function setFriendship(Relation $friendship){
		$this->friendship = $friendship;
	}

	public function setLastname($lastname){
		$this->lastname = $lastname;
	}

	public function setSex($sex){
		$this->sex = $sex;
	}

	//GETTER

	public function getBirthDay(){
		return $this->birthDay;
	}

	public function getFacebookId(){
		return $this->facebookId;
	}

	public function getFirstname(){
		return $this->firstname;
	}

	public function getFollowing(){
		return $this->following;
	}

	public function getFriendship(){
		return $this->friendship;
	}

	public function getLastname(){
		return $this->lastname;
	}

	public function getSex(){
		return $this->sex;
	}
}
?>
