<?php

/* ! \par Info Generali:
 *  \author    Stefano Muscas
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par Info Classe:
 *  \brief     Stutus Class
 *  \details   Classe status dello User, raccoglie uno stato dell'utente, posso collegarci immagine o song
 *  
 *  \par Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:status">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:status">API</a>
 */

class StatusParse {

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
    public function saveStatus(Status $status) {

        $parse = new parseObject("Status");
        $parse->active = $status->getActive();

        if ($status->getCommentators() != null && count($status->getCommentators()) > 0) {
            $arrayPointer = array();
            foreach ($status->getCommentators() as $user) {
                $pointer = $parse->dataType("pointer", array("_User"), $user->getObjectId());
                array_push($arrayPointer, $pointer);
            }
        } else {
            $parse->commentators = null;
        }

        if ($status->getComments() != null && count($status->getComments()) > 0) {
            $arrayPointer = array();
            foreach ($status->getComments() as $comment) {
                $pointer = $parse->dataType("pointer", array("Comment"), $comment->getObjectId());
                array_push($arrayPointer, $pointer);
            }
        } else {
            $parse->comments = null;
        }

        $parse->counter = $status->getCounter();

        //puntatore ad un evento
        if (($event = $status->getEvent())) {
            $parse->event = array("__type" => "Pointer", "className" => "Event", "objectId" => $event->getObjectId());
        };

        $parse->fromUser = $status->getfromUser();
        $parse->image = $status->getImage();
        if (($geoPoint = $status->getLocation())) {
            $parse->location = $geoPoint->location;
        }

        $parse->loveCounter = $status->getLoveCounter();

        if ($status->getLovers() != null && count($status->getLovers()) > 0) {
            $arrayPointer = array();
            foreach ($status->getLovers() as $user) {
                $pointer = $parse->dataType("pointer", array("_User"), $user->getObjectId());
                array_push($arrayPointer, $pointer);
            }
        } else {
            $parse->lovers = null;
        }

        if (($song = $status->getSong())) {
            $parse->song = array("__type" => "Pointer", "className" => "Song", "objectId" => $song->getObjectId());
        }

        if ($status->getTaggedUsers() != null && count($status->getTaggedUsers()) > 0) {
            $arrayPointer = array();
            foreach ($status->getTaggedUsers() as $user) {
                $pointer = $parse->dataType("pointer", array("_User"), $user->getObjectId());
                array_push($arrayPointer, $pointer);
            }
        } else {
            $parse->taggedUsers = null;
        }


        $parse->text = $status->getText();
        $acl = new parseACL();
        $acl->setPublicReadAccess(true);
        $acl->setPublicWriteAccess(true);
        $parse->setACL($acl);

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

	public function deleteStatus(Status $status){

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
	 	
		//array di puntatori ad oggetti
		if(isset($parseObj->commentators)){
			$parseUser = new UserParse();
			$commentators = $parseUser->getUserArrayById($parseObj->commentators);
			$status->setCommentators($commentators) ;
		}

                //array di puntatori ad oggetti
		if(isset($parseObj->comments)){
			$parseComment = new Comment();
			$comments = $parseComment->getObjectId($parseObj->comments);
			$status->setComments($comments) ;
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
	 		$status->setEvent($parseEvent);
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

	 	//array di puntatori ad oggetti
		if(isset($parseObj->lovers)){
			$parseUser = new UserParse();
			$lovers = $parseUser->getUserArrayById($parseObj->lovers);
			$status->setLovers($lovers) ;
		}

		if(isset( $parseObj->song ) )$status->setSong($parseObj->song);
	 	
	 	if(isset( $parseObj->text ) )$status->setText($parseObj->text);
	 	
	 	//array di puntatori ad oggetti
		if(isset($parseObj->taggedUsers)){
			$parseUser = new UserParse();
			$taggedUsers = $parseUser->getUserArrayById($parseObj->taggedUsers);
			$status->setTaggedUsers($taggedUsers) ;
		}
	 	
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