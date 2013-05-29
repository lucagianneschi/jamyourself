<?php

class StatusParse{

	private $parseQuery;

	public function __construct() {

		$this->parseQuery = new ParseQuery("Status");

	}

	/**
	 * Ho deciso di unificare la save e l'update cos� da poter effettuare semplicemente il salvataggio
	 * dell'oggetto senza paranoie se esiste gi� o meno su Parse
	 * Il test viene fatto sull'objectId dello status, che naturalmente � nullo se
	 * l'oggetto � creato per la prima volta
	 *
	 * @param unknown $status
	 * @return NULL|unknown
	 */
	public function save(Status $status){
		
		$parse = new parseObject("Status");
		$parse->active = $status->getActive();
		
		foreach($status->getCommentators() as $user){
			$parse->data->commentators->__op = "AddRelation";
			$parse->data->commentators->objects = array(array("__type" => "Pointer", "className" => "_User", "objectId" => ($user ->getObjectId()));
		}

	foreach($status->getComments() as $comment){
			$parse->data->commentators->__op = "AddRelation";
			$parse->data->commentators->objects = array(array("__type" => "Pointer", "className" => "Comment", "objectId" => ($comment ->getObjectId()));
		}

		$parse->counter = $status->getCounter();
		//puntatore ad un evento
		if($event = $status->getEvent()){
			$parse->event = array("__type" => "Pointer", "className" => "Event", "objectId" => $event->getObjectId());			
		};

		$parse->fromUser = $status->getfromUser();
		$parse->image = $status->getImage();
		if($geoPoint = $status->getLocation()){
			$parse->location = $geoPoint->location;			
		}
		$parse->loveCounter = $status->getLoveCounter();

		foreach($status->getLovers() as $user){
			$parse->data->lovers->__op = "AddRelation";
			$parse->data->lovers->objects = array(array("__type" => "Pointer", "className" => "_User", "objectId" => ($user ->getObjectId()));
		}

		if($song = $status->getSong()){
			$parse->song = array("__type" => "Pointer", "className" => "Song", "objectId" => $song->getObjectId());
		}

		foreach($status->getTaggedUsers() as $user){
			$parse->data->taggedUsers->__op = "AddRelation";
			$parse->data->taggedUsers->objects = array(array("__type" => "Pointer", "className" => "_User", "objectId" => ($user ->getObjectId()));
		}
		
		$parse->text = $status->getText();
		
		//SOSTITUITE DA 54-57
		//utenti taggati: salvo gli Id
		//if( $users = $status->getUsers()  && count($status->getUsers())){
			//$parse->users = array();
			//foreach ($users as $user){
				//array_push($parse->users, $user->getObjectId());}}

		//$parse->ACL = $status->getACL();

		//se esiste l'objectId vuol dire che devo aggiornare
		//se non esiste vuol dire che devo salvare
		if(( $status->getObjectId())!=null ){
			//update
			try{
				//update
				$result = $parse->update($status->getObjectId());
				
				//aggiorno l'update
				$status->setUpdatedAt(new DateTime($result->updatedAt, new DateTimeZone("America/Los_Angeles")));
			}
			catch(ParseLibraryException $e){
				return false;
			}
		}else{
				
			try{
				//salvo
				$result = $parse->save();

				//aggiorno i dati per la creazione
				$status->setObjectId($result->objectId);
				$status->setCreatedAt(new DateTime($result->createdAt,new DateTimeZone("America/Los_Angeles")));
				$status->setUpdatedAt(new DateTime($result->createdAt,new DateTimeZone("America/Los_Angeles")));
			}
			catch(ParseLibraryException $e){

				return false;

			}

		}

		//restituisco status aggiornato
		return $status;
	}

	public function delete(Status $status){

		$status->setActive(false);

		if($this->save($status)) return true;
		else return false;
			
	}

	/**
	 * 
	 * @param unknown $objectId
	 * @return Status
	 */
	public function getStatus($statusId){

		$status = new Status();
			
		$parseStatus = new parseObject("Status");

		$res = $parseStatus->get($statusId);
		
		$status = $this->parseToStatus($res);

		return $status;
	}

	/**
	 * Restituisce tutti gli status dell'utente
	 * (il limite delle query � impostato a 100 dalla parse.lib)
	 * @param User $user
	 * @return Ambigous <multitype:, NULL>
	 */
	public function getStatusByUser(User $user){

		$list = null;
			
		$this->parseQuery->wherePointer('fromUser','_User', $user->getObjectId());

		$return = $this->parseQuery->find();

		if (is_array($return->results) && count($return->results)>0){

			$list = array();

			foreach ($return->results as $result) {
									
				array_push($list, $this->parseToStatus($result));
				
			}

		}

		return $list;
	}

	/**
	 * Effettua il parsing di una riga di una tabella della classe Status
	 * trasformandola in un oggetto Status della nostra libreria
	 * @param stdClass $parseObj oggetto rappresentatne una riga della tabella Status del DB di Parse
	 * @return NULL|Status NULL in caso di errore, un oggetto Status in caso di successo
	 */
	public function parseToStatus(stdClass $parseObj){
			
		if($parseObj == null) return null; 	//se non ho ricevuto niente...
			
		//lo status da restituire
		$status = new status();
		
		//recupero objectId
		if(isset( $parseObj->objectId ) )$status->setObjectId($parseObj->objectId);

	 	//recupero Active
	 	if(isset( $parseObj->active ) )$status->setActive($parseObj->active);
	 	
		//DA MODIFICARE
		if(isset($parseObj->commentators)){
			$parseUser = new UserParse();
			$commentators = $parseUser->getUserArrayById($parseObj->commentators);
			$status->setCommentators($commentators) ;
		}

	//DA MODIFICARE!!!
		if(isset($parseObj->comments)){
			$parseComment = new UserParse();
			$comments = $parseComment->getUserArrayById($parseObj->comments);
			$status->setCommentators($commentators) ;
		}

	 	//recupero il counter
	 	if(isset( $parseObj->counter ) )$status->setCounter($parseObj->counter);

		if(isset( $parseObj->event ) ){
	 		
	 		//parse ha in ->event un puntatore 
	 		
	 		//creo un nuovo parseEvent per fare la query su Eventi
	 		$parseEvent = new EventParse();
	 		
	 		//recupero il puntatore all'evento
	 		$eventPointer = $parseObj->event;
	 		
	 		//recupero l'evento con una query su parse
	 		$parseEvent->getEvent($eventPointer->objectId);	 		
	 		
	 		//setto l'evento in status
	 		$status->setEvent($event);
	 	}


	 	//recupero l'utente che ha pubblicato lo status che � un Pointer
	 	if(isset( $parseObj->fromUser ) ){
	 		
	 		//userParse per fare la query sulla tabella Utenti
	 		$parseUser = new userParse();
	 		
	 		//prelevo il puntatore
	 		$parsePointer = $parseObj->fromUser;
	 		
	 		//request per reperire l'utente
	 		$fromUser = $parseUser->getUserById($parsePointer->objectId);
	 		
	 		//setto su status l'utente
	 		$status->setFromUser($fromUser);
	 	}
	 	
		if(isset( $parseObj->image ) )$status->setImage($parseObj->image);

	 	//recupero il geoPoint
	 	if(isset( $parseObj->location ) ){
	 		
	 		//recupero il GeoPoint
	 		$geoParse = $parseObj->geoCoding;
	 		
	 		//geopontizzo
	 		$geoPoint = new parseGeoPoint($geoParse->latitude, $geoParse->longitude);
	 		
	 		//salvo sullo status
	 		$status->setLocation($geoPoint);
	 	}

	 	//recupero il loveCounter
	 	if(isset( $parseObj->loveCounter ) )$status->setCounter($parseObj->loveCounter);

	 	//DA MODIFICARE
		if(isset($parseObj->lovers)){
			$parseUser = new UserParse();
			$lovers = $parseUser->getUserArrayById($parseObj->lovers);
			$status->setLovers($lovers) ;
		}

		if(isset( $parseObj->song ) )$status->setSong($parseObj->song);
	 	
	 	if(isset( $parseObj->text ) )$status->setText($parseObj->text);
	 	
	 	//DA MODIFICARE
		if(isset($parseObj->taggedUsers)){
			$parseUser = new UserParse();
			$taggedUsers = $parseUser->getUserArrayById($parseObj->taggedUsers);
			$status->setTaggedUsers($taggedUsers) ;
		}
	 	
	 	//SOSTITUITO da 261 in poi
	 	/* 
	 	//recupero gli utenti taggati
	 	if(isset( $parseObj->users ) ){
	 		//per fare la query su User
	 		$parseUser = new userParse();
	 		
	 		//array contenitore di User
	 		$users = array();
	 		
	 		foreach ($parseObj->refused as $user_id){
	 		
	 			//recupero e aggiungo all'array
	 			array_push($users, $parseUser->getUserById($user_id));
	 		
	 		}
	 		//salvo su status
	 		$status->setUser($users);
	 	}
        */
	 	
	 	//creo la data di tipo DateTime per createdAt e updatedAt
		if( isset($parseObj->createdAt) ) $status->setCreatedAt(new DateTime($parseObj->createdAt,new DateTimeZone("America/Los_Angeles")));
		if( isset($parseObj->updatedAt) ) $status->setUpdatedAt(new DateTime($parseObj->updatedAt,new DateTimeZone("America/Los_Angeles")));
	 	
	 	//recupero l'ACL
	 	if(isset( $parseObj->ACL ) ){
	 		$ACL = null;
	 		$status->setACL($ACL);
	 	}
	 	return $status;
	}
}
?> 
