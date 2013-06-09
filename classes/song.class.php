<?php

/* ! \par Info Generali:
 *  \author    Stefano Muscas
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par Info Classe:
 *  \brief     Song Class
 *  \details   Classe dedicata al singolo brano, pu� essere istanziata solo da Jammer
 *  
 *  \par Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:song">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:song">API</a>
 */

class Song {

    private $objectId;  //string: objectId su Parse									   
    private $active;  //BOOL: attiva/disattiva l'istanza della classe 
    private $commentators;      //relation: array di puntatori ad User che hanno commentator
    private $comments;      //relation: puntatori ad oggetti Comment
    private $counter;  //number: Contatore di gradimento 								
    private $duration;  //number: Durata della Song										
    private $featuring;  //array: presenza di altri Utenti								
    private $filePath;  //string: Indirizzo del file									
    private $fromUser;  //User: Utente che effettua la creazione della Song				
    private $genre;   //string: Genere della Song										
    private $location;      //geoPoint: coordinate di localizzazione della canzone			
    private $loveCounter;   //number: per tenere conto del numero di azioni love
    private $lovers;     //relation: array di puntatori ad User che hanno fatto  azioni love
    private $record;  //Record (Parse Object): disco di appartenenza della song       
    private $title;   //string: titolo della song  											
    private $createdAt;  //DateTime: data e tempo di upload								
    private $updatedAt;  //DateTime: data e tempo di ultima modifica						
    private $ACL;   //Access Control list										    

    //GETTERS
    //string: objectId su Parse									    

    public function getObjectId() {
        return $this->objectId;
    }

    //BOOL: attiva/disattiva l'istanza della classe  			
    public function getActive() {
        return $this->active;
    }

    //relation: array di puntatori ad User che hanno commentators 
    public function getCommentators() {
        return $this->commentators;
    }

    //relation: puntatori ad oggetti Comment 								
    public function getComments() {
        return $this->comments;
    }

    //number: Contatore di gradimento 								
    public function getCounter() {
        return $this->counter;
    }

    //number: Durata della Song										
    public function getDuration() {
        return $this->duration;
    }

    //array: presenza di altri Utenti								
    public function getFeaturing() {
        return $this->featuring;
    }

    //string: Indirizzo del file									
    public function getFilePath() {
        return $this->filePath;
    }

    //User: Utente che effettua la creazione della Song				
    public function getFromUser() {
        return $this->fromUser;
    }

    //string: Genere della Song										
    public function getGenre() {
        return $this->genre;
    }

    //geoPoint: coordinate di localizzazione della canzone			
    public function getLocation() {
        return $this->location;
    }

    //number: per tenere conto del numero di azioni love			
    public function getLoveCounter() {
        return $this->loveCounter;
    }

    public function getLovers() {
        return $this->lovers;
    }

    //Record (Parse Object): disco di appartenenza della song       
    public function getRecord() {
        return $this->record;
    }

    //string: titolo della song  									
    public function getTitle() {
        return $this->title;
    }

    //DateTime: data e tempo di upload								
    public function getCreatedAt() {
        return $this->createdAt;
    }

    //DateTime: data e tempo di ultima modifica					    
    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    //Access Control list										    
    public function getACL() {
        return $this->ACL;
    }

    //SETTERS
    //string: objectId su Parse									    
    public function setObjectId($objectId) {
        $this->objectId = $objectId;
    }

    //BOOL: attiva/disattiva l'istanza della classe  				
    public function setActive($active) {
        $this->active = $active;
    }

    //relation: array di User che hanno commentators 
    public function setCommentators(array $commentators) {
        $this->commentators = $commentators;
    }

    //relation: puntatori ad oggetti Comment
    public function setComments(array $comments) {
        $this->comments = $comments;
    }

    //number: Contatore di gradimento 								
    public function setCounter($counter) {
        $this->counter = $counter;
    }

    //number: Durata della Song										
    public function setDuration($duration) {
        $this->duration = $duration;
    }

    //array: presenza di altri Utenti								
    public function setFeaturing(array $featuring) {
        $this->featuring = $featuring;
    }

    //string: Indirizzo del file									
    public function setFilePath($filePath) {
        $this->filePath = $filePath;
    }

    //User: Utente che effettua la creazione della Song				
    public function setFromUser(User $fromUser) {
        $this->fromUser = $fromUser;
    }

    //string: Genere della Song									
    public function setGenre($genre) {
        $this->genre = $genre;
    }

    //geoPoint: coordinate di localizzazione della canzone			
    public function setLocation($location) {
        $this->location = $location;
    }

    //number: per tenere conto del numero di azioni love			
    public function setLoveCounter($loveCounter) {
        $this->loveCounter = $loveCounter;
    }

    //number: per tenere conto del numero di azioni love			
    public function setLovers(array $lovers) {
        $this->lovers = $lovers;
    }

    //Record (Parse Object): disco di appartenenza della song       
    public function setRecord(Record $record) {
        $this->album = $record;
    }

    //string: titolo della song  									
    public function setTitle($title) {
        $this->title = $title;
    }

    //DateTime: data e tempo di upload								
    public function setCreatedAt(DateTime $createdAt) {
        $this->createdAt = $createdAt;
    }

    //DateTime: data e tempo di ultima modifica					    
    public function setUpdatedAt(DateTime $updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    //Access Control list										    
    public function setACL($ACL) {
        $this->ACL = $ACL;
    }

    public function __toString() {
        $string = '';
        $string .= '[objectId] => ' . $this->getObjectId() . '<br />';
        $string .= '[active] => ' . $this->getActive() . '<br />';
        if ($this->getCommentators() != null && count($this->getCommentators() > 0)) {
            foreach ($this->getCommentators() as $commentator) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= "[commentator] => " . $commentator->getObjectId() . "<br />";
            }
        }
        if ($this->getComments() != null && count($this->getComments() > 0)) {
            foreach ($this->getComments() as $comment) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= "[comment] => " . $comment->getObjectId() . "<br />";
            }
        }
        $string .= '[counter] => ' . $this->getCounter() . '<br />';
        $string .= '[duration] => ' . $this->getDuration() . '<br />';
        if ($this->getFeaturing() != null && count($this->getFeaturing() > 0)) {
            foreach ($this->getFeaturing() as $user) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= "[featuring] => " . $user->getObjectId() . "<br />";
            }
        }
        $string.="[filePath] => " . $this->getFilePath() . "<br />";
        $fromUser = $this->getFromUser();
        if ($fromUser != null) {
            $string.="[fromUser] => " . $fromUser->getObjectId() . "<br />";
        }
        $string.="[genre] => " . $this->getGenre() . "<br />";
        $parseGeoPoint = $this->getLocation();
        if ($parseGeoPoint->lat != null && $parseGeoPoint->long) {
            $string .= '[location] => ' . $parseGeoPoint->lat . ', ' . $parseGeoPoint->long . '<br />';
        }
        $string .= '[loveCounter] => ' . $this->getLoveCounter() . '<br />';
        if ($this->getLovers() != null && count($this->getLovers() > 0)) {
            foreach ($this->getLovers() as $lover) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= "[lover] => " . $lover->getObjectId() . "<br />";
            }
        }
        $record = $this->getRecord();
        if ($record != null) {
            $string .= "[record] => " . $record->getObjectId() . "<br />";
        }
        $string .= "[title] => " . $this->getTitle() . "<br />";
        if (($createdAt = $this->getCreatedAt()))
            $string .= '[createdAt] => ' . $createdAt->format('d-m-Y H:i:s') . '<br />';
        if (($updatedAt = $this->getUpdatedAt()))
            $string .= '[updatedAt] => ' . $updatedAt->format('d-m-Y H:i:s') . '<br />';
        if($this->getACL() != null){
           foreach ($this->getACL()->acl as $key => $acl) {
            $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            $string .= '[key] => ' . $key . '<br />';
            foreach ($acl as $access => $value) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= '[access] => ' . $access . ' -> ' . $value . '<br />';
            }
        } 
        }
        return $string;
    }

}

?>
