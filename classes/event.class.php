<?php
/*! \par Info Generali:
 *  \author    Maria Laura Fresu
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par Info Classe:
 *  \brief     Event
 *  \details   Classe dedicata agli eventi, solo JAMMER e VENUE possono istanziare questa classe
 *  
 *  \par Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:event">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:event">API</a>
 */

define('CLASS_DIR', '../classes/');
include_once CLASS_DIR.'geoPointParse.class.php';

class Event {
	
	private $objectId;				//string: objectId su Parse
	private $active;				//BOOL: attiva/disattiva l'evento
	private $attendee;				//relation: Array che contiene puntatori ad utenti che hanno accettato l'invito all'evento
	private $commentators;			//relation: Array che contiene puntatori ad utenti che hanno compiuto azione commento
    private $comments;				//relation: Array che contiene puntatori a Comment
	private $counter;				//number: counter per votazione dell'evento 
	private $description;			//string: Descrizione breve dell’evento
	private $eventDate;				//DataTime: Data di svolgimento dell’evento (comprende anche l’ora di inizio dell’evento)
	private $featuring;				//relation: Presenza di altri utenti all’evento  
	private $fromUser;				//User: User che crea l’evento
 	private $image;					//string: Stringa per il percorso di immagazzinamento della foto di copertina dell’evento
	private $invited;				//relation: Array che contiene puntatori ad utenti invitati all'evento
    private $location;				//GeoPoint: Luogo in cui si svolge l’evento
    private $locationName;			//string: Nome del locale in cui si svolge l’evento	
 	private $loveCounter; 			//number:counter per gestire le azioni love sull'evento 
	private $lovers;				//relation: Array che contiene puntatori ad utenti che hanno compiuto azione love
	private $refused;				//relation: Array che contiene puntatori ad utenti che hanno rifiutato l'invito all'evento
    private $tags;					//array: Categorizzazione dell’evento
	private $thumbnail;				//string: Stringa per il percorso di immagazzinamento della thumbnail
	private $title;					//string: Nome dell’evento
	private $createdAt;				//DataTime: data di registrazione dell'evento
	private $updatedAt;				//DataTime: data di ultimo update dell'evento
	private $ACL;					//Access Control List: definisce le politiche di accesso all'evento 

	//DEFINIZIONE DELLE FUNZIONI GET

	//string: objectId su Parse
	public function getObjectId() {
		return $this->objectId;
	}

	//BOOL: attiva/disattiva l'evento
	public function getActive(){
		return $this->active;
	}

    //relation: Array che contiene puntatori ad utenti che hanno accettato l'invito all'evento
	public function getAttendee() {
		return $this->attendee;
	}

	//relation: Array che contiene puntatori ad utenti che hanno compiuto azione commento
	public function getCommentators() {
		return $this->commentators;
	}

	//relation: Array che contiene puntatori a Comment
	public function getComments() {
		return $this->comments;
	}

	//number: counter per votazione dell'evento
	public function getCounter() {
		return $this->counter;
	}

    //string: Descrizione breve dell’evento
	public function getDescription() {
		return $this->description;
	}

 	//DataTime: Data di svolgimento dell’evento (comprende anche l’ora di inizio dell’evento)
	public function getEventDate() {
		return $this->eventDate;
	}

	//relation: Presenza di altri utenti all’evento (ad esempio che suonano, che presentano, che organizzano...)
	public function getFeaturing() {
		return $this->featuring;
	}

	//User: User che crea l’evento
	public function getFromUser() {
		return $this->fromuser;
	}

	//string: Stringa per il percorso di immagazzinamento della foto di copertina dell’evento
	public function getImage() {
		return $this->image;
	}

	//relation: Array che contiene puntatori ad utenti invitati all'evento
		public function getInvited() {
		return $this->invited;
	}

	//GeoPoint: Luogo in cui si svolge l’evento
	public function getLocation() {
		return $this->location;
	}

	//number:counter per gestire le azioni love sull'evento
	public function getLoveCounter() {
		return $this->loveCounter;
	}

	//relation: Array che contiene puntatori ad utenti che hanno effettuato love sull'evento
	public function getLovers() {
		return $this->lovers;
	}

	//string: Nome del locale in cui si svolge l’evento
	public function getLocationName() {
		return $this->locationName;
	}

    //relation: Array che contiene puntatori ad utenti che hanno rifiutato l'invito all'evento
	public function getRefused() {
		return $this->refused;
	}
	
    //array: Categorizzazione dell’evento
	public function getTags() {
		return $this->tags;
	}

    //string: Stringa per il percorso di immagazzinamento della thumbnail
	public function getThumbnail() {
		return $this->thumbnail;
	}

	//string: Nome dell’evento
	public function getTitle() {
		return $this->title;
	}

	//DataTime: data di registrazione dell'evento
	public function getCreatedAt() {
		return $this->createdAt;
	}	

	//DataTime: data di ultimo update dell'evento
	public function getUpdatedAt() {
		return $this->updatedAt;
	}

    //Access control list, definisce le politiche di accesso all'evento
	public function getACL() {
		return $this->ACL;
	}

	//DEFINIZIONE DELLE FUNZIONI SET
	//string: objectId su Parse
    public function setObjectId($value) {
		$this->objectId = $value;
	}

	//BOOL: attiva/disattiva l'evento
	public function setActive($active){
		$this->active = $active;
	}

	//relation: Array che contiene puntatori ad utenti che hanno accettato l'invito all'evento
	public function setAttendee(array $value) {
		$this->attendee = $value;
	}

	//relation: Array che contiene puntatori ad utenti che hanno effettuato commento
	public function setCommentators(array $value) {
		$this->commentators = $value;
	}

	//relation: Array che contiene puntatori a Comment
	public function setComments(array $value) {
		$this->comments = $value;
	}

       //number: counter per votazione dell'evento
	public function setCounter($value) {
		$this->counter = $value;
	}

  	//string: Descrizione breve dell’evento
	public function setDescription($value) {
		$this->description = $value;
	}

	//DataTime: Data di svolgimento dell’evento (comprende anche l’ora di inizio dell’evento)
	public function setEventDate(DataTime $value) {
		$this->eventDate = $value;
	}

  	//relation: Presenza di altri utenti all’evento (ad esempio che suonano, che presentano, che organizzano...)
	public function setFeaturing(array $value) {
		$this->featuring = $value;
	}

    //User: User che crea l’evento
	public function setFromUser(User $value) {
		$this->fromUser = $value;
	}

   //string: Stringa per il percorso di immagazzinamento della foto di copertina dell’evento
	public function setImage(Image $value) {
		$this->image = $value;
	}

	//relation: Array che contiene puntatori ad utenti invitati all'evento
	public function setInvited(array $value) {
		$this->invited = $value;
	}

	//GeoPoint: Luogo in cui si svolge l’evento
	public function setLocation(parseGeoPoint $value) {
		$this->location = $value;
	}

    //string: Nome del locale in cui si svolge l’evento
	public function setLocationName($value) {
		$this->locationName = $value;
	}

	//number:counter per gestire le azioni love sull'evento
	public function setLoveCounter($value) {
		$this->loveCounter = $value;
	}

	//relation: Array che contiene puntatori ad utenti che hanno compiuto azione love
	public function setLovers(array $value) {
		$this->lovers = $value;
	}

	//relation: Array che contiene puntatori ad utenti che hanno rifiutato l'invito all'evento
	public function setRefused(array $value) {
		$this->refused = $value;
	}

	//array: Categorizzazione dell’evento
	public function setTags(array $value) {
		$this->tags = $value;
	}

    //string: Stringa per il percorso di immagazzinamento della thumbnail
	public function setThumbnail($value) {
		$this->thumbnail = $value;
	}

 	//string: Nome dell’evento
	public function setTitle($value) {
		$this->title = $value;
	}

   //DataTime: data di registrazione dell'evento
	public function setCreatedAt(DataTime $value) {
		$this->createdAt = $value;
	}

	//DataTime: data di ultimo update dell'evento
	public function setUpdatedAt(DataTime $value) {
		$this->updatedAt = $value;
	}
	
    //Access control list, definisce le politiche di accesso all'evento
	public function setACL(parseACL $value) {
		$this->ACL = $value;
	}
	
	function __toString() {
		
		$stringa = '';
		$string .= '[objectId] => ' . $this->getObjectId() . '<br />';
		$string .= '[active] => ' . $this->getActive() . '<br />';
		//$this->getAttendee()
		//$this->getCommentators()
		//$this->getComments()
		$string .= '[counter] => ' . $this->getCounter() . '<br />';
		$string .= '[description] => ' . $this->getDescription() . '<br />';
	    $string .= '[eventDate] => ' . $this->getEventDate()->format('d-M-Y H:i:s') . '<br />';
		//$this->getFeaturing()
		$fu = $this->getFromUser();
		$string .= '[fromUser] => ' . $fu['className'] . ' -> ' . $fu['objectId'] . '<br/>';
		$im = $this->getImage();
		$string .= '[image] => ' . $im['className'] . ' -> ' . $im['objectId'] . '<br/>';
		//$this->getInvited()
		$parseGeoPoint = $this->getLocation();
		$string .= '[location] => ' . $parseGeoPoint->$lat . ', ' .  $parseGeoPoint->$long . '<br />';
	    $string .= '[locationName] => ' . $this->getLocationName() . '<br />';
		$string .= '[loveCounter] => ' . $this->getLoveCounter() . '<br />';
		//$this->getLovers()
	    //$this->getRefused()
		foreach ($this->getTags() as $ta) {
			$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$string .= '[tags] => ' . $ta . '<br />';
		}
	    $string .= '[thumbnail] => ' . $this->getThumbnail() . '<br />'; 	
	    $string .= '[title] => ' . $this->getTitle() . '<br />';			
	    $string .= '[createdAt] => ' . $this->getCreatedAt() . '<br />';
	    $string .= '[updatedAt] => ' . $this->getUpdatedAt() . '<br />';
	    $string .= '[ACL] => ' . $this->getACL() . '<br />';
		
		return $string;
	}
}

?>
