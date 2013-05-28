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
			foreach($user->getCollaboration() as $collaborator){
				$parse->data->collaboration->__op = "AddRelation";
				$parse->data->collaboration->objects = array(array("__type" => "Pointer", "className" => "_User", "objectId" => ($collaborator ->getObjectId()));
			}

			foreach($user->getEvents() as $event){
				$parse->data->events->__op = "AddRelation";
				$parse->data->events->objects = array(array("__type" => "Pointer", "className" => "Event", "objectId" => ($event ->getObjectId()));
			}

			$parse->members = $user->getMembers();

			foreach($user->getRecords() as $record){
				$parse->data->records->__op = "AddRelation";
				$parse->data->records->objects = array(array("__type" => "Pointer", "className" => "Record", "objectId" => ($record ->getObjectId()));
			}

			foreach($user->getSongs() as $song){
				$parse->data->songs->__op = "AddRelation";
				$parse->data->songs->objects = array(array("__type" => "Pointer", "className" => "Song", "objectId" => ($song ->getObjectId()));
			}

			$parse->jammerType = $user->getJammerType();
		}


		if($user->getType()=="SPOTTER"){
		
		//formatto l'anno di nascita 
		if($user->getBirthDay()){
			//birthDay � un tipo DateTime
			$data = $user->getBirthDay();
			$parse->birthDay = $parse->dataType("date", $data->format('r'));	
			}

		$parse->facebookId = $user->getFacebookId();
		$parse->firstname = $user->getFirstname();

		foreach($user->getFollowing() as $user){
				$parse->data->following->__op = "AddRelation";
				$parse->data->following->objects = array(array("__type" => "Pointer", "className" => "_User", "objectId" => ($user ->getObjectId()));
			}

		foreach($user->getFriendship() as $user){
				$parse->data->friendship->__op = "AddRelation";
				$parse->data->friendship->objects = array(array("__type" => "Pointer", "className" => "_User", "objectId" => ($user ->getObjectId()));
			}

		$parse->lastname = $user->getLastname();
		$parse->sex = $user->getSex();

		}

		if($user->getType()=="VENUE"){
			$parse->address = $user->getAddress();

			foreach($user->getCollaboration() as $collaborator){
				$parse->data->collaboration->__op = "AddRelation";
				$parse->data->collaboration->objects = array(array("__type" => "Pointer", "className" => "_User", "objectId" => ($collaborator ->getObjectId()));
			}

			foreach($user->getEvents() as $event){
				$parse->data->events->__op = "AddRelation";
				$parse->data->events->objects = array(array("__type" => "Pointer", "className" => "Event", "objectId" => ($event ->getObjectId()));
			}
						
			$parse->localType = $user->getLocalType();
		}
	
		//poi recupero i dati fondamentali (che appartengono a tutti gli utenti)
		$parse->username = $user->getUsername();
        //$parse->password = $user->getPassword(); VANNO MESSI?
    	//$parse->authData; = $user->getAuthData;(); VANNO MESSI?
		$parse->ID = $user->getID();
		$parse->active = $user->getActive();

		foreach($user->getAlbums() as $album){
				$parse->data->albums->__op = "AddRelation";
				$parse->data->albums->objects = array(array("__type" => "Pointer", "className" => "Album", "objectId" => ($album ->getObjectId()));
			}

		$parse->background = $user->getBackground();
		$parse->city = $user->getCity();
		
		foreach($user->getComments() as $comment){
				$parse->data->comments->__op = "AddRelation";
				$parse->data->comments->objects = array(array("__type" => "Pointer", "className" => "Comment", "objectId" => ($comment ->getObjectId()));
			}

		$parse->country = $user->getCountry();
		$parse->description = $user->getDescription();
		$parse->email = $user->getEmail();
		$parse->fbPage = $user->getFbPage();

		if($user->getGeoCoding()){
			$geo = $user->getGeoCoding();			
			$parse->geoCoding = $geo->location;//� un geopoint? spero di si...
		}

		foreach($user->getImages() as $image){
				$parse->data->images->__op = "AddRelation";
				$parse->data->images->objects = array(array("__type" => "Pointer", "className" => "Image", "objectId" => ($image ->getObjectId()));
			}

		$parse->level = $user->getLevel();
		$parse->levelValue= $user->getLevelValue();

		foreach($user->getLoveSongs() as $song){
				$parse->data->loveSongs->__op = "AddRelation";
				$parse->data->loveSongs->objects = array(array("__type" => "Pointer", "className" => "Song", "objectId" => ($song ->getObjectId()));
			}

		$parse->music = $user->getMusic();

		foreach($user->getPlaylists() as $playlist){
				$parse->data->playlists->__op = "AddRelation";
				$parse->data->playlists->objects = array(array("__type" => "Pointer", "className" => "Playlist", "objectId" => ($playlist ->getObjectId()));
			}

		$parse->premium = $user->getPremium();
		$parse->premiumExpirationDate = $user->getPremiumExpirationDate();
		$parse->profilePicture = $user->getProfilePicture();
		$parse->profileThumbnail = $user->getProfileThumbnail();
		$parse->settings = $user->getSettings();

		foreach($user->getStatuses() as $status){
				$parse->data->statuses->__op = "AddRelation";
				$parse->data->statuses->objects = array(array("__type" => "Pointer", "className" => "Status", "objectId" => ($status ->getObjectId()));
			}

		$parse->type = $user->getType();
		$parse->twitterPage = $user->getTwitterPage();
		
		foreach($user->getVideos() as $video){
				$parse->data->videos->__op = "AddRelation";
				$parse->data->videos->objects = array(array("__type" => "Pointer", "className" => "Video", "objectId" => ($video ->getObjectId()));
			}


		$parse->website = $user->getWebsite();
		$parse->youtubeChannel = $user->getYoutubeChannel();

		if($user->getObjectId() != null){
				
			//update
				
			try{
				
				$ret = $parse->update($user->getObjectId(), $user->getSessionToken());

				/** esempio di risposta:
				 *  $ret->updatedAt "2013-05-04T15:03:03.151Z";
				 */
				$user->setUpdatedAt(new DateTime($ret->updatedAt, new DateTimeZone("America/Los_Angeles")));		
					
			}
			catch(ParseLibraryException $error){
				return false;
			}		
		}
		else{
			//registrazione
				
			$parse->password = $user->getPassword();

			try{
				
				$ret = $parse->signup($user->getUsername(),$user->getPassword());
			
				/**
				 * Esempio di risposta: un oggetto di tipo stdObj cos� fatto:
				 * $ret->emailVerified = true/false
				 * $ret->createdAt = "2013-05-04T12:04:45.535Z"
				 * $ret->objectId = "OLwLSZQtNF"
				 * $ret->sessionToken = "qeutglxlz2k7cgzm3vgc038bf"
				 */
				$user->setEmailVerified($ret->emailVerified);
				$user->setSessionToken($ret->sessionToken);
				$user->setCreatedAt(new DateTime($ret->createdAt,new DateTimeZone("America/Los_Angeles")));
				$user->setUpdatedAt(new DateTime($ret->createdAt,new DateTimeZone("America/Los_Angeles")));
				$user->setObjectId($ret->objectId);
				//$user->setACL($ret->ACL);
								
					
			}
			catch(ParseLibraryException $error){
				return false;
			}
				
		}	
		return $user;
	}

	/**
	 * Effettua il login dell'utente fornendo un utente che deve avere qualche parametro impostato, dopodich� creo uno User specifico
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

			$ret = $parse->login();
			
			if($ret){
								
				$user = $this->parseToUser($ret);
				
			}

		}catch(ParseLibraryException $e){

			return false;

		}

		return $user;

	}

	/**
	 * La funzione di Logout non ha effetti nel DB, probabilmente
	 * si dovr� agire probabilmente sulle Activity
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
			array_push($array, $this->getUserById($user_id));
		}
		
		return $array;
				
	}

	/**
	 * Cancellazione utente: imposta il flag active a false
	 * @param User $user l'utente da cancellare
	 * @return boolean true in caso di successo, false in caso di fallimento
	 */
	function delete(User $user){

		//solo l'utente corrente pu� cancellare se stesso
		if($user){
			$user->setActive(false);
			
			if( $this->save($user) ) return true;
			else return false;
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
	
	public function parseToUser(stdClass $parseObj){
				
		$user = null;
		
		if($parseObj && isset($parseObj->type)){
		
			//inizializzo l'utente a seconda del profilo
		
			switch($parseObj->type){
				case "SPOTTER":
		
					$user = new Spotter();

					if( isset($parseObj->birthDay) ) $user->setBirthDay(new DateTime($parseObj->birthDay->iso, new DateTimeZone("America/Los_Angeles")));
					if( isset($parseObj->facebookId) ) $user->setFacebookId($parseObj->facebookId);
					if( isset($parseObj->firstname) ) $user->setFirstname($parseObj->firstname);
					if( isset($parseObj->following) ) $user->setFollowing($parseObj->following);//MODIFICARE
					if( isset($parseObj->friendship) ) $user->setFriendship($parseObj->friendship);//MODIFICARE
					if( isset($parseObj->lastname) ) $user->setLastname($parseObj->lastname);
					if( isset($parseObj->sex) )$user->setSex($parseObj->sex);
					break;

				case "JAMMER":
		
					$user = new Jammer();

					if( isset($parseObj->collaboration) )$user->setCollaboration($parseObj->collaboration);//MODIFICARE
					if( isset($parseObj->events) )$user->setEvents($parseObj->events);
					if( isset($parseObj->members) )$user->setMembers($parseObj->members);
					if( isset($parseObj->records) )$user->setRecords($parseObj->records);//MODIFICARE
					if( isset($parseObj->songs) )$user->setSongs($parseObj->songs);//MODIFICARE
					if( isset($parseObj->jammerType) )$user->setJammerType($parseObj->jammerType);
					break;
		
				case "VENUE":
		
					$user = new Venue();

					/*visto che deve essere un geopoint*/ //questo è sbagliato! dalla stringa si ricavano le coordinate e si mettono dentro la property geoCoding!
					//MODIFICARE!
					if( isset($parseObj->address) ){
						//recupero il GeoPoint
						$geoParse = $parseObj->address;
						$geoPoint = new parseGeoPoint($geoParse->latitude, $geoParse->longitude);				
						//aggiungo lo status
						$user->setAddress($geoPoint);				

					}

					if( isset($parseObj->collaboration) )$user->setCollaboration($parseObj->collaboration);//MODIFICARE
					if( isset($parseObj->events) )$user->setEvents($parseObj->events);//MODIFICARE
					if( isset($parseObj->localType) ) $user->setLocalType($parseObj->localType);
		
					break;
			}
		
			//poi recupero i dati fondamentali (che appartengono a tutti gli utenti)
			if( isset($parseObj->objectId) ) $user->setObjectId($parseObj->objectId);
			if( isset($parseObj->username ) )$user->setUsername($parseObj->username);
			//if( isset($parseObj->password ) )$user->setPassword($parseObj->password); VA MESSO??
			//if( isset($parseObj->authData ) )$user->setAuthData($parseObj->authData); VA MESSO??
			if( isset($parseObj->emailVerified) ) $user->setEmailVerified($parseObj->emailVerified);
			if( isset($parseObj->ID) ) $user->setID($parseObj->ID);//RIMUOVERE DOPO ALLINEAMENTO DB
			if( isset($parseObj->active)) $user->setActive($parseObj->active);
			if( isset($parseObj->albums ) )$user->setAlbums($parseObj->albums);//MODIFICARE
			if( isset($parseObj->background) ) $user->setBackground($parseObj->background);
			if( isset($parseObj->city) ) $user->setCity($parseObj->city);
			if( isset($parseObj->country) ) $user->setCountry($parseObj->country);
			if( isset($parseObj->description) ) $user->setDescription($parseObj->description);
			if( isset($parseObj->email) )$user->setEmail($parseObj->email);
			if( isset($parseObj->fbPage) ) $user->setFbPage($parseObj->fbPage);
			if( isset($parseObj->geoCoding) ){
				//recupero il GeoPoint
				$geoParse = $parseObj->geoCoding;
				$geoPoint = new parseGeoPoint($geoParse->latitude, $geoParse->longitude);				
				//aggiungo lo status
				$user->setGeoCoding($geoPoint);				
			}
			if( isset($parseObj->images) ) $user->setImages($parseObj->images);//MODIFICARE
			if( isset($parseObj->level) ) $user->setLevel($parseObj->level);
			if( isset($parseObj->levelValue) )$user->setLevelValue($parseObj->levelValue);
			if( isset($parseObj->loveSongs) )$user->setLoveSongs($parseObj->loveSongs);
			if( isset($parseObj->music) ) $user->setMusic($parseObj->music);
			if( isset($parseObj->playlists) ) $user->setPlaylists($parseObj->playlists);//MODIFICARE
			if( isset($parseObj->premium) ) $user->setPremium($parseObj->premium);
			if( isset($parseObj->premiumExpirationDate) ) $user->setPremiumExpirationDate($parseObj->premiumExpirationDate);
			if( isset($parseObj->profilePicture) ) $user->setProfilePicture($parseObj->profilePicture);
			if( isset($parseObj->profileThumbnail) ) $user->setProfileThumbnail($parseObj->profileThumbnail);
			if( isset($parseObj->settings) ) $user->setSettings($parseObj->settings);
            if( isset($parseObj->statuses) ) $user->setStatuses($parseObj->statuses);//MODIFICARE
			if( isset($parseObj->twitterPage) ) $user->setTwitterPage($parseObj->twitterPage);
			if( isset($parseObj->website) ) $user->setWebsite($parseObj->website);
			if( isset($parseObj->youtubeChannel) ) $user->setYoutubeChannel($parseObj->youtubeChannel);
			if( isset($parseObj->sessionToken) ) $user->setSessionToken($parseObj->sessionToken);
			if( isset($parseObj->createdAt) ) $user->setCreatedAt(new DateTime($parseObj->createdAt,new DateTimeZone("America/Los_Angeles")));
			if( isset($parseObj->updatedAt) ) $user->setUpdatedAt(new DateTime($parseObj->updatedAt,new DateTimeZone("America/Los_Angeles")));
			if( isset($parseObj->ACL) ) $user->setACL($parseObj->ACL);	//OK?
		}
		
		return $user;			
	}
}
?>
