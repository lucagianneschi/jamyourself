<?php

/* ! \par Info Generali:
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

class Event {

    private $objectId;    //string: objectId su Parse
    private $active;    //BOOL: attiva/disattiva l'evento
    private $attendee;    //relation: Array che contiene puntatori ad utenti che hanno accettato l'invito all'evento
    private $commentators;   //relation: Array che contiene puntatori ad utenti che hanno compiuto azione commento
    private $comments;    //relation: Array che contiene puntatori a Comment
    private $counter;    //number: counter per votazione dell'evento 
    private $description;   //string: Descrizione breve dell’evento
    private $eventDate;    //DataTime: Data di svolgimento dell’evento (comprende anche l’ora di inizio dell’evento)
    private $featuring;    //relation: Presenza di altri utenti all’evento  
    private $fromUser;    //User: User che crea l’evento
    private $image;        //string: Stringa per il percorso di immagazzinamento della foto di copertina dell’evento
    private $imageFile;
    private $invited;    //relation: Array che contiene puntatori ad utenti invitati all'evento
    private $location;    //GeoPoint: Luogo in cui si svolge l’evento
    private $locationName;   //string: Nome del locale in cui si svolge l’evento	
    private $loveCounter;    //number:counter per gestire le azioni love sull'evento 
    private $lovers;    //relation: Array che contiene puntatori ad utenti che hanno compiuto azione love
    private $refused;    //relation: Array che contiene puntatori ad utenti che hanno rifiutato l'invito all'evento
    private $tags;     //array: Categorizzazione dell’evento
    private $thumbnail;    //string: Stringa per il percorso di immagazzinamento della thumbnail
    private $title;     //string: Nome dell’evento
    private $createdAt;    //DataTime: data di registrazione dell'evento
    private $updatedAt;    //DataTime: data di ultimo update dell'evento
    private $ACL;     //Access Control List: definisce le politiche di accesso all'evento 

    //DEFINIZIONE DELLE FUNZIONI GET
    //string: objectId su Parse

    public function getObjectId() {
        return $this->objectId;
    }

    //BOOL: attiva/disattiva l'evento
    public function getActive() {
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
        return $this->fromUser;
    }

    //string: Stringa per il percorso di immagazzinamento della foto di copertina dell’evento
    public function getImage() {
        return $this->image;
    }

    //string: Stringa per il percorso di immagazzinamento della foto di copertina dell’evento
    public function getImageFile() {
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
    public function setObjectId($objectId) {
        $this->objectId = $objectId;
    }

    //BOOL: attiva/disattiva l'evento
    public function setActive($active) {
        $this->active = $active;
    }

    //relation: Array che contiene puntatori ad utenti che hanno accettato l'invito all'evento
    public function setAttendee(array $attendee) {
        $this->attendee = $attendee;
    }

    //relation: Array che contiene puntatori ad utenti che hanno effettuato commento
    public function setCommentators(array $commentators) {
        $this->commentators = $commentators;
    }

    //relation: Array che contiene puntatori a Comment
    public function setComments(array $comments) {
        $this->comments = $comments;
    }

    //number: counter per votazione dell'evento
    public function setCounter($counter) {
        $this->counter = $counter;
    }

    //string: Descrizione breve dell’evento
    public function setDescription($description) {
        $this->description = $description;
    }

    //DataTime: Data di svolgimento dell’evento (comprende anche l’ora di inizio dell’evento)
    public function setEventDate(DateTime $eventDate) {
        $this->eventDate = $eventDate;
    }

    //relation: Presenza di altri utenti all’evento (ad esempio che suonano, che presentano, che organizzano...)
    public function setFeaturing(array $featuring) {
        $this->featuring = $featuring;
    }

    //User: User che crea l’evento
    public function setFromUser(User $fromUser) {
        $this->fromUser = $fromUser;
    }

    //string: Stringa per il percorso di immagazzinamento della foto di copertina dell’evento
    public function setImage($image) {
        $this->image = $image;
    }

    //string: Stringa per il percorso di immagazzinamento della foto di copertina dell’evento
    public function setImageFile($imageFile) {
        $this->imageile = $imageFile;
    }

    //relation: Array che contiene puntatori ad utenti invitati all'evento
    public function setInvited(array $invited) {
        $this->invited = $invited;
    }

    //GeoPoint: Luogo in cui si svolge l’evento
    public function setLocation($location) {
        $this->location = $location;
    }

    //string: Nome del locale in cui si svolge l’evento
    public function setLocationName($locationName) {
        $this->locationName = $locationName;
    }

    //number:counter per gestire le azioni love sull'evento
    public function setLoveCounter($loveCounter) {
        $this->loveCounter = $loveCounter;
    }

    //relation: Array che contiene puntatori ad utenti che hanno compiuto azione love
    public function setLovers(array $lovers) {
        $this->lovers = $lovers;
    }

    //relation: Array che contiene puntatori ad utenti che hanno rifiutato l'invito all'evento
    public function setRefused(array $refused) {
        $this->refused = $refused;
    }

    //array: Categorizzazione dell’evento
    public function setTags(array $tags) {
        $this->tags = $tags;
    }

    //string: Stringa per il percorso di immagazzinamento della thumbnail
    public function setThumbnail($thumbnail) {
        $this->thumbnail = $thumbnail;
    }

    //string: Nome dell’evento
    public function setTitle($title) {
        $this->title = $title;
    }

    //DataTime: data di registrazione dell'evento
    public function setCreatedAt(DateTime $createdAt) {
        $this->createdAt = $createdAt;
    }

    //DataTime: data di ultimo update dell'evento
    public function setUpdatedAt(DateTime $updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    //Access control list, definisce le politiche di accesso all'evento
    public function setACL($acl) {
        $this->ACL = $acl;
    }

    function __toString() {

        $string = '';
        $string .= '[objectId] => ' . $this->getObjectId() . '<br />';
        $string .= '[active] => ' . $this->getActive() . '<br />';
        if ($this->getAttendee() != null && count($this->getAttendee() > 0)) {
            foreach ($this->getAttendee() as $attendee) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= "[attendee] => " . $attendee->getObjectId() . "<br />";
            }
        } else {
            $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            $string .= '[attendee] => NULL<br />';
        }
        if ($this->getComments() != null && count($this->getComments() > 0)) {
            foreach ($this->getComments() as $comment) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= "[comment] => " . $comment->getObjectId() . "<br />";
            }
        } else {
            $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            $string .= '[comments] => NULL<br />';
        }
        if ($this->getCommentators() != null && count($this->getCommentators() > 0)) {
            foreach ($this->getCommentators() as $commentator) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= "[commentator] => " . $commentator->getObjectId() . "<br />";
            }
        } else {
            $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            $string .= '[commentators] => NULL<br />';
        }
        $string .= '[counter] => ' . $this->getCounter() . '<br />';
        $string .= '[description] => ' . $this->getDescription() . '<br />';
        if ($this->getEventDate() != null) {
            $string .= '[eventDate] => ' . $this->getEventDate()->format('d-m-Y H:i:s') . '<br />';
        } else {
            $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            $string .= '[eventDate] => NULL<br />';
        }
        if ($this->getFeaturing() != null && count($this->getFeaturing() > 0)) {
            foreach ($this->getFeaturing() as $user) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= "[featuring] => " . $user->getObjectId() . "<br />";
            }
        } else {
            $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            $string .= '[featuring] => NULL<br />';
        }
        $fromUser = $this->getFromUser();
        if ($fromUser != null) {
            $string.="[fromUser] => " . $fromUser->getObjectId() . "<br />";
        } else {
            $string .= '[fromUser] => NULL<br />';
        }
        $string .= '[image] => ' . $this->getImage() . '<br />';
        //$string .= '[imageFile] => ' . $this->getImageFile() . '<br />';
        if ($this->getInvited() != null && count($this->getInvited() > 0)) {
            foreach ($this->getInvited() as $invited) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= "[invited] => " . $invited->getObjectId() . "<br />";
            }
        } else {
            $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            $string .= '[invited] => NULL<br />';
        }
        $parseGeoPoint = $this->getLocation();
        if ($parseGeoPoint->lat != null && $parseGeoPoint->long) {
            $string .= '[location] => ' . $parseGeoPoint->lat . ', ' . $parseGeoPoint->long . '<br />';
        } else {
            $string .= '[location] => NULL<br />';
        }
        $string .= '[locationName] => ' . $this->getLocationName() . '<br />';
        $string .= '[loveCounter] => ' . $this->getLoveCounter() . '<br />';
        if ($this->getLovers() != null && count($this->getLovers() > 0)) {
            foreach ($this->getLovers() as $lover) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= "[lover] => " . $lover->getObjectId() . "<br />";
            }
        } else {
            $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            $string .= '[lovers] => NULL<br />';
        }
        if ($this->getRefused() != null && count($this->getRefused() > 0)) {
            foreach ($this->getRefused() as $refused) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= "[refused] => " . $refused->getObjectId() . "<br />";
            }
        } else {
            $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            $string .= '[refused] => NULL<br />';
        }
        if ($this->getTags() != null && count($this->getTags() > 0)) {
            foreach ($this->getTags() as $ta) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= '[tags] => ' . $ta . '<br />';
            }
        } else {
            $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            $string .= '[tags] => NULL<br />';
        }
        $string .= '[thumbnail] => ' . $this->getThumbnail() . '<br />';
        $string .= '[title] => ' . $this->getTitle() . '<br />';
        if (($createdAt = $this->getCreatedAt()))
            $string .= '[createdAt] => ' . $createdAt->format('d-m-Y H:i:s') . '<br />';
        if (($updatedAt = $this->getUpdatedAt()))
            $string .= '[updatedAt] => ' . $updatedAt->format('d-m-Y H:i:s') . '<br />';
        $string .= '[ACL] => ' . print_r($this->getACL(), true) . '<br />';
        return $string;
    }

}

?>
