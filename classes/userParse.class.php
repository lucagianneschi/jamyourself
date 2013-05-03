<?php

class UserParse{

	private $parseQuery;

	public function __construct() {

		$this->parseQuery = new ParseQuery("_User");

	}

	/**
	 * Effettua la registrazione dell'utente
	 * fondamentali esistano e effettuo il salvataggio nel DB
	 *
	 */
	function save(User $user){

		if($user == null) return null;
			
		$parse = new parseUser();

		//inizializzo l'utente a seconda del profilo
		if($user->getType()=="JAMMER"){
			$parse->members = $user->getMembers();
		}
		if($user->getType()=="VENUE"){
			$parse->address = $user->getAddress();
			$parse->localType = $user->getLocalType();
		}
		//poi recupero i dati fondamentali (che appartengono a tutti gli utenti)

		$parse->type = $user->getType();
		$parse->email = $user->getEmail();
		$parse->username = $user->getUsername();

		$parse->sex = $user->getSex();
		$parse->firstname = $user->getFirstname();
		//è un tipo DateTime
		
		//formatto l'anno di nascita 
		if($user->getEta()){
			//eta è un tipo DateTime
			$data = $user->getEta();
			$parse->eta = $parse->dataType("date", $data->format('Y-m-d H:i:s'));	
		}

		$parse->lastname = $user->getLastname();
		$parse->profilePicture = $user->getProfilePicture();
		$parse->thumbnail = $user->getProfileThumbnail();
		
		if($user->getStatus() ){
			//status è di tipo Status, deve essere un Pointer
			$status = $user->getStatus();
			
			$parse->status = array("__type" => "Pointer", "className" => "Status", "objectId" => $status->getObjectId());
			
		}
		$parse->website = $user->getWebsite();
		$parse->fbPage = $user->getFbPage();
		$parse->twitterPage = $user->getTwitterPage();
		$parse->youtubeChannel = $user->getYoutubeChannel();
		$parse->country = $user->getCountry();
		$parse->city = $user->getCity();
		$parse->description = $user->getDescription();
		$parse->facebookId = $user->getFacebookId();
		$parse->music = $user->getMusic();
		$parse->background = $user->getBackground();
		$parse->customField = $user->getCustomField();
		$parse->geoCoding = $user->getGeoCoding();//è un geopoint? spero di si...
		$parse->settings = $user->getSettings();
		$parse->level = $user->getLevel();

		if($user->getObjectId() != null){
				
			//update
				
			try{
				
				$ret = $parse->update($user->getObjectId(), $user->getSessionToken());
					
				$user = $this->parseToUser($ret);					
					
			}
			catch(ParseLibraryException $error){
				return null;
			}
				
				
		}
		else{
			//registrazione
				
			$parse->password = $user->getPassword();

			try{
				$ret = $parse->signup($user->getUsername(),$user->getPassword());
				
				$user = $this->parseToUser($ret);					
					
			}
			catch(ParseLibraryException $error){
				return null;
			}
				
		}
			
		return $user;

	}

	/**
	 * Effettua il login dell'utente fornendo un utente che deve avere qualche parametro impostato, dopodiché creo uno User specifico
	 * e lo restituisco.
	 */
	function login(User $user){

		//o la mail o lo username!
		if( ($user == null) || ( $user->getUsername()==null || $user->getEmail()==null ) && $user->getPassword()==null  ) return false;
		$parse = new parseUser();

		//login tramite username o email
		if($user->getUsername()==null)$parse->username=$this->getUserIdByMail($user->getEmail());
		else $parse->username = $user->getUsername();

		$parse->password = $user->getPassword();

		try{

			if($ret){
				$ret = $parse->login();
				
				$user = $this->parseToUser($ret);
				
			}

		}catch(ParseLibraryException $e){

			return false;

		}

		return $user;

	}

	/**
	 * La funzione di Logout non ha effetti nel DB, probabilmente
	 * si dovrà agire probabilmente sulle Activity
	 *
	 */
	function logout(){

		if(isset($_SESSION['user_id'])){

			unset($_SESSION['user_id']);

			//al logout devo sempre distruggere la sessione

			session_destroy();
		}

	}
	/**
	 * Inizializza un oggetto Utente recuperandolo tramite l'id
	 */
	function getUserById($user_id){

		$user = null;

		$this->parseQuery->where('objectId', $user_id);

		$result = $this->parseQuery->find();

		if (is_array($result->results) && count($result->results)>0){

			$ret = $result->results[0];

			if($ret){

				//recupero l'utente
				$user = $this->parseToUser($ret);

			}

		}
		
		return $user;

	}

	/**
	 * Restituisce un array di utenti recuperati tramite un array di id passato per argomento
	 * @param array $userArray
	 * @return multitype:
	 */
	function getUserArrayById(array $userArray){
		
		$array = array();
		
		foreach($userArray as $user_id){
			array_push($array, getUserById($user_id));
		}
		
		return $array;
				
	}
	
	function delete(User $user){

		//solo l'utente corrente può cancellare se stesso
		if($user){

			$temp =  new parseUser();

			$temp->delete($user->getObjectId(),$user->getSessionToken());

			return true;

		}
		else return false;

	}


	/**Restituisce lo username di un utente
	 * in base alla sua mail
	* (serve per il login differenziato)
	*/
	function getUserIdByMail($email){

		$this->parseQuery->where('email', $email);

		$result = $this->parseQuery->find();

		if (is_array($result->results) && count($result->results)>0){

			$ret = $result->results[0];

			if($ret){

				//poi recupero i dati fondamentali (che appartengono a tutti gli utenti)

				if( isset($ret->username ) ) return $ret->username;

			}

		}

		return false;

	}
	
	/**
	 * Recupera un utente in base al suo username
	 * @param string $username
	 * @return Ambigous <NULL, User>
	 */
	public function getUserByUsername($username){
		
		$user = null;
		
		$this->parseQuery->where('username', $username);
		
		$result = $this->parseQuery->find();
		
		if (is_array($result->results) && count($result->results)>0){
		
			$ret = $result->results[0];
		
			if($ret){
		
				//poi recupero i dati fondamentali (che appartengono a tutti gli utenti)
		
				$user = $this->parseToUser($ret);
		
			}
		
		}
		
		return $user;		
	}

	/**
	 * 
	 * @param User $user
	 * @return string
	 */
	public function toString(User $user){

		$string = "";

		if(isset($user)){

			$string .= "Tipo Profilo : ". $user->getType()."<br>";

			$string .= "ObjectId : ".$user->getObjectId()."<br>";

			$string .= "SessionToken : ".$user->getSessionToken()."<br>";

			$string .= "Username : ". $user->getUsername()."<br>";

			//$string .= "Password : ". $user->getPassword()."<br>";

			$string .= "Email : ". $user->getEmail()."<br>";

			$string .= "EmailVerified : ". $user->getEmailVerified()."<br>";

			$string .= "Nome : ". $user->getFirstname()."<br>";

			$string .= "Cognome : ". $user->getLastname()."<br>";

			$string .= "Sex : ". $user->getSex()."<br>";

			$string .= "Giorno di Nascita : ". $user->getEta()."<br>";

			$string .= "UpdatedAt : ".$user->getUpdatedAt()."<br>";

			$string .= "CreatedAt : ". $user->getCreatedAt()."<br>";

			$string .= "GeoCoding : ". $user->getGeoCoding()."<br>";

			//$string .= "Settings : ". $user->getSettings()."<br>";

			$string .= "Foto Profilo : ". $user->getProfilePicture()."<br>";

			$string .= "Thumbnail Profilo : ". $user->getProfileThumbnail()."<br>";

			$string .= "Status : ". $user->getStatus()."<br>";

			$string .= "Sito Web : ". $user->getWebsite()."<br>";

			$string .= "Id Facebook : ". $user->getFacebookId()."<br>";

			$string .= "Pagina Facebook : ". $user->getFbPage()."<br>";

			$string .= "Pagina Twitter : ". $user->getTwitterPage()."<br>";

			$string .= "Canale Youtube : ". $user->getYoutubeChannel()."<br>";

			$string .= "Stato : ". $user->getCountry()."<br>";

			$string .= "Citta' : ". $user->getCity()."<br>";

			$string .= "Descrizione : ". $user->getDescription()."<br>";

			$string .= "Musica : ". implode(",", $user->getMusic())."<br>";

			$string .= "AuthData : ". $user->getAuthData()."<br>";

			$string .= "Background : ". $user->getBackground()."<br>";

			$string .= "Custom Field : ". $user->getCustomField()."<br>";

			$string .= "Level : ". $user->getLevel()."<br>";

			if($user->getType() == "JAMMER" )  $string .= "Members : ". $user->getMembers()."<br>";

			if($user->getType() == "VENUE" ){

				$string .= "Address : ". $user->getAddress()."<br>";

				$string .= "LocalType : ". $user->getLocalType()."<br>";

			}

			return $string;

		}
		else{

			return "NULL";

		}
	}
	
	public function parseToUser(stdClass $parseObj){
		
		$user = null;
		
		
		if($parseObj && isset($parseObj->type)){
		
			//inizializzo l'utente a seconda del profilo
		
		
			switch($parseObj->type){
				case "SPOTTER":
		
					$user = new Spotter();
		
					break;
				case "JAMMER":
		
					$user = new Jammer();
		
					if( isset($parseObj->members) )$user->setMembers($parseObj->members);
		
					break;
		
				case "VENUE":
		
					$user = new Venue();
		
					if( isset($parseObj->address) ) $user->setAddress($parseObj->address);
					if( isset($parseObj->localType) ) $user->setLocalType($parseObj->localType);
		
					break;
			}
		
			//poi recupero i dati fondamentali (che appartengono a tutti gli utenti)
		
			if( isset($parseObj->email) )$user->setEmail($parseObj->email);
			if( isset($parseObj->username ) )$user->setUsername($parseObj->username);
			if( isset($parseObj->sex) )$user->setSex($parseObj->sex);
			if( isset($parseObj->firstname) ) $user->setFirstname($parseObj->firstname);
			if( isset($parseObj->eta) ) $user->setEta($parseObj->eta);
			if( isset($parseObj->lastname) ) $user->setLastname($parseObj->lastname);
			if( isset($parseObj->profilePicture) ) $user->setProfilePicture($parseObj->profilePicture);
			if( isset($parseObj->profileThumbnail) ) $user->setProfileThumbnail($parseObj->profileThumbnail);
			
			if( isset($parseObj->status) ){
				//recupero il pointer
				$pointer_status = $parseObj->status;
				
				//recupero l'id
				$id_status = $pointer_status->objectId;
				
				//recupero lo status
				$parseStatus = new statusParse();
				$status = $parseStatus->getStatus($id_status);
				
				//aggiungo lo status
				$user->setStatus($parseObj->status);
			}
			
			if( isset($parseObj->website) ) $user->setWebsite($parseObj->website);
			if( isset($parseObj->fbPage) ) $user->setFbPage($parseObj->fbPage);
			if( isset($parseObj->twitterPage) ) $user->setTwitterPage($parseObj->twitterPage);
			if( isset($parseObj->youtubeChannel) ) $user->setYoutubeChannel($parseObj->youtubeChannel);
			if( isset($parseObj->country) ) $user->setCountry($parseObj->country);
			if( isset($parseObj->city) ) $user->setCity($parseObj->city);
			if( isset($parseObj->description) ) $user->setDescription($parseObj->description);
			if( isset($parseObj->facebookId) ) $user->setFacebookId($parseObj->facebookId);
			if( isset($parseObj->music) ) $user->setMusic($parseObj->music);
			if( isset($parseObj->background) ) $user->setBackground($parseObj->background);
			if( isset($parseObj->customField) ) $user->setCustomField($parseObj->customField);
			
			if( isset($parseObj->geoCoding) ){
				//recupero il GeoPoint
				$geoParse = $parseObj->geoCoding;
				
				$geoPoint = new parseGeoPoint($geoParse->latitude, $geoParse->longitude);				
				
				//aggiungo lo status
				$user->setGeoCoding($geoPoint);				

			}
			
			if( isset($parseObj->settings) ) $user->setSettings($parseObj->settings);
			if( isset($parseObj->objectId) ) $user->setObjectId($parseObj->objectId);
			if( isset($parseObj->sessionToken) ) $user->setSessionToken($parseObj->sessionToken);
			//createdAt e updatedAt parsati come oggetti! Yo!
			if( isset($parseObj->createdAt) ) $user->setCreatedAt(new DateTime($parseObj->createdAt));
			if( isset($parseObj->updatedAt) ) $user->setUpdatedAt(new DateTime($parseObj->updatedAt));
			
			if( isset($parseObj->emailVerified) ) $user->setEmailVerified($parseObj->emailVerified);
				
		}
		
		return $user;		
		
	}

}


?>