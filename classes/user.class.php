<?php

require_once'settings.php';

class User{

	//questi dati sono aggiornati solo dopo aver fatto save/userLogin/update

	private $objectId;					//id di Parse (si aggiorna quando recupero l'utente dal DB)
	private $sessionToken;		//sessionToken relativo all'utente (fornito da Parse)
	private $createdAt;			//data creazione utente (fornito da Parse)
	private $updatedAt;			//data ultimo aggiornamento stato utente (fornito da Parse)
	
	private $emailVerified;		//TRUE se l'utente ha verificato la propria mail (fornito da Parse)
	private $email;
	private $username;
	private $password;

	//non obbligatori
	private $sex;
	private $firstname;
	private $eta;
	private $lastname;
	private $profilePicture;
	private $profileThumbnail;
	private $status;
	private $website;
	private $fbPage;
	private $twitterPage;
	private $youtubeChannel;
	private $country;
	private $city;
	private $description;
	private $facebookId;
	private $music;
	private $authData;
	private $background;
	private $customField;
	private $geoCoding;
	private $settings;
	private $level;
	private $premium;

	//COSTRUTTORE

	public function __construct(){

	}

	//****** FUNZIONI SET ***************************************************//
	public function setObjectId($objectId){
	
		$this->objectId = $objectId;
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
	
	public function setEmailVerified($emailVerified){
		
		$this->emailVerified = $emailVerified;
		
	}
	
	public function setGeoCoding(parseGeoPoint $geoCoding){
		
			$this->geoCoding = $geoCoding;

	}

	public function setEmail($email){
		
		$this->email = $email;
		
	}

	public function setUsername($username){

		$this->username = $username;
	}

	public function setPassword($password){

		$this->password = $password;
	}

	public function setType($type){

		$this->type = $type;
	}

	public function setLevel($level){

		$this->level = $level;
	}

	public function setSettings(array $settings){

		$this->settings = $settings;
	}

	public function setSex($sex){

		$this->sex = $sex;
	}

	public function setFirstname($firstname){

		$this->firstname = $firstname;
	}

	public function setEta(DateTime $eta){

		$this->eta = $eta;
	}
	
	public function setLastname($lastname){

		$this->lastname = $lastname;
	}

	public function setProfilePicture($profilePicture){

		$this->profilePicture = $profilePicture;
	}

	public function setProfileThumbnail($profileThumbnail){

		$this->profileThumbnail = $profileThumbnail;
	}

	public function setStatus(Status $status){

		$this->status = $status;
	}

	public function setWebsite($website){

		$this->website = $website;
	}

	public function setFbPage($fbPage){

		$this->fbPage = $fbPage;
	}

	public function setTwitterPage($twitterPage){

		$this->twitterPage = $twitterPage;
	}

	public function setYoutubeChannel($youtubeChannel){

		$this->youtubeChannel = $youtubeChannel;
	}

	public function setCountry($country){

		$this->country = $country;
	}

	public function setCity($city){

		$this->city = $city;
	}

	public function setDescription($description){

		$this->description = $description;
	}

	public function setFacebookId($facebookId){

		$this->facebookId = $facebookId;
	}

	public function setMusic(array $music){

		$this->music = $music;
	}

	public function setAuthData($authData){

		$this->authData = $authData;
	}

	public function setBackground($background){

		$this->background = $background;
	}

	public function setCustomField($customField){

		$this->customField = $customField;
	}

	
	public function setPremium($premium){
		
		$this->premium = $premium;
	}
	//****** FUNZIONI GET ***************************************************//

	public function getObjectId(){
	
		return $this->objectId;
	}
	
	public function getSessionToken(){
	
		return $this->sessionToken;
	}
	
	public function getUpdatedAt(){
		
		return $this->updatedAt;
		
	}
	
	public function getCreatedAt(){
		
		return $this->createdAt;
		
	}
	
	public function getEmailVerified(){
		
		return $this->emailVerified;
		
	}
	
	public function getGeoCoding(){

		return $this->geoCoding;
		
	}

	public function getEmail(){

		return $this->email;
	}

	public function getUsername(){

		return $this->username;
	}

	public function getPassword(){

		return $this->password;
	}

	public function getType(){

		return $this->type;
	}

	public function getLevel(){

		return $this->level;
	}

	public function getSettings(){

		return $this->settings;

	}

	public function getSex(){

		return $this->sex;
	}

	public function getFirstname(){

		return $this->firstname;
	}

	public function getEta(){

		return $this->eta;
	}

	public function getLastname(){

		return $this->lastname;
	}

	public function getProfilePicture(){

		return $this->profilePicture;
	}

	public function getProfileThumbnail(){

		return $this->profileThumbnail;
	}

	public function getStatus(){

		return $this->status;
	}

	public function getWebsite(){

		return $this->website;
	}

	public function getFbPage(){

		return $this->fbPage;
	}

	public function getTwitterPage(){

		return $this->twitterPage;
	}

	public function getYoutubeChannel(){

		return $this->youtubeChannel;
	}

	public function getCountry(){

		return $this->country;
	}

	public function getCity(){

		return $this->city;
	}

	public function getDescription(){

		return $this->description;
	}

	public function getFacebookId(){

		return $this->facebookId;
	}

	public function getMusic(){

		return $this->music;
	}

	public function getAuthData(){

		return $this->authData;
	}

	public function getBackground(){

		return $this->background;
	}

	public function getCustomField(){

		return $this->customField;
	}
	
	public function getPremium(){
	
		return $this->premium;
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
		$string.="Giorno di nascita : ".$this->getEta()->format('d/m/Y')."<br>";		
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
		//$string.=" : ".$this->getCustomField()."<br>";
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
	private $localType;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->setType("VENUE");

	}
	
	public function setAddress($address){
		
		$this->address  = $address;
		
	}
	
	public function setLocalType($localType){
		
		$this->localType = $localType;
		
	}
	
	public function getAddress(){
		
		return $this->address;
		
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

	private $members;

	public function __construct()
	{
		$this->setType("JAMMER");
	}

	public function setMembers(array $members){
		
		$this->members = $members;
		
	}

	public function getMembers(){
		
		return $this->members;
		
	}
	
	public function __toString(){
		
		$string = parent::__toString();
		
		$string.="Membri della band: ".implode(" , ", $this->getMembers());		
		
		return $string;
	}

}

class Spotter extends User{

	public function __construct()
	{
		$this->setType("SPOTTER");
	}	
	
}
?>