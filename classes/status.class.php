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

class Status {

    private $objectId;      //string: object ID Parse      
    private $active;      //BOOL: indica se la classe è attiva o meno
    private $commentators;    //relation: array di puntatori a Parse Users
    private $comments;     //relation: array di puntatori a Comment
    private $counter;      //number: contatore che serve per gradimento dello status
    private $event;        //Parse Object Event: evento associato allo status
    private $fromUser;      //Parse User: utente che pubblica lo status
    private $image;      //Parse Object Image: image associata allo status
    private $imageFile;      //Parse Object File: file associata allo status
    private $location;      //GeoPoint: lat e long per localizzazione dello status (inutilizzato)
    private $loveCounter;      //number: counter per tenere conto delle sole azioni di love
    private $lovers;      //relation: array di puntatori a Parse Users
    private $song;      //Parse Object Song: song associata allo status
    private $taggedUsers;    //relation: array di puntatori a Parse Users
    private $text;      //string: testo inserito dall'utente per il proprio status
    private $createdAt;     //DataTime: data di creazione dello status						
    private $updatedAt;     //DataTime: data di update dello status						
    private $ACL;      //Access Control List										

    //public function __construct(){}
    //FUNZIONI SET	
    //string: object ID Parse 

    public function setObjectId($objectId) {
        $this->objectId = $objectId;
    }

    //BOOL: indica se la classe è attiva o meno
    public function setActive($active) {
        $this->active = $active;
    }

    //relation: array di puntatori a Parse Users
    public function setCommentators(array $commentators) {
        $this->commentators = $commentators;
    }

    //relation: array di puntatori a Parse Comment
    public function setComments(array $comments) {
        $this->comments = $comments;
    }

    //number: contatore che serve per gradimento dello status
    public function setCounter($counter) {
        $this->counter = $counter;
    }

    //Parse Object Event: evento associato allo status
    public function setEvent($event) {
        $this->events = $event;
    }

    //Parse User: utente che pubblica lo status
    public function setFromUser($fromUser) {
        $this->fromUser = $fromUser;
    }

    //Parse Object Image: image associata allo status
    public function setImage($image) {
        $this->image = $image;
    }

    ////Parse Object Image: image associata allo status
    public function setImageFile($imageFile) {
        $this->image = $imageFile;
    }

    //GeoPoint: lat e long per localizzazione dello status (inutilizzato)
    public function setLocation($location) {
        $this->location = $location;
    }

    //number: counter per tenere conto delle sole azioni di love
    public function setLoveCounter($loveCounter) {
        $this->loveCounter = $loveCounter;
    }

    //relation: array di puntatori a Parse Users
    public function setLovers(array $lovers) {
        $this->lovers = $lovers;
    }

    //Parse Object Song: song associata allo status
    public function setSong($song) {
        $this->song = $song;
    }

    //relation: array di puntatori a Parse Users
    public function setTaggedUsers(array $taggedUsers) {
        $this->taggedUsers = $taggedUsers;
    }

    //string: testo inserito dall'utente per il proprio status
    public function setText($text) {
        $this->text = $text;
    }

    //DataTime: data di creazione dello status
    public function setCreatedAt(DateTime $createdAt) {
        $this->createdAt = $createdAt;
    }

    //DataTime: data di update dello status	
    public function setUpdatedAt(DateTime $updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    //Access Control List
    public function setACL($ACL) {
        $this->ACL = $ACL;
    }

    //FUNZIONI GET
    //string: object ID Parse 
    public function getObjectId() {
        return $this->objectId;
    }

    //BOOL: indica se la classe è attiva o meno
    public function getActive() {
        return $this->active;
    }

    //relation: array di puntatori a Parse Users
    public function getCommentators() {
        return $this->commentators;
    }

    //relation: array di puntatori a Parse Users
    public function getComments() {
        return $this->comments;
    }

    //number: contatore che serve per gradimento dello status
    public function getCounter() {
        return $this->counter;
    }

    //Parse Object Event: evento associato allo status
    public function getEvent() {
        return $this->event;
    }

    //Parse User: utente che pubblica lo status
    public function getFromUser() {
        return $this->fromUser;
    }

    //Parse Object Image: image associata allo status
    public function getImage() {
        return $this->image;
    }

    //Parse Object Image: image associata allo status
    public function getImageFile() {
        return $this->imageFile;
    }

    //GeoPoint: lat e long per localizzazione dello status (inutilizzato)
    public function getLocation() {
        return $this->location;
    }

    //number: counter per tenere conto delle sole azioni di love
    public function getLoveCounter() {
        return $this->loveCounter;
    }

    //relation: array di puntatori a Parse Users
    public function getLovers() {
        return $this->lovers;
    }

    //Parse Object Song: song associata allo status
    public function getSong() {
        return $this->song;
    }

    //relation: array di puntatori a Parse Users
    public function getTaggedUsers() {
        return $this->taggedUsers;
    }

    //string: testo inserito dall'utente per il proprio status
    public function getText() {
        return $this->text;
    }

    //DataTime: data di creazione dello status
    public function getCreatedAt() {
        return $this->createdAt;
    }

    //DataTime: data di update dello status
    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    //Access Control List
    public function getACL() {
        return $this->ACL;
    }

    public function __toString() {

        $string = '';
        $string .= '[objectId] => ' . $this->getObjectId() . '<br />';
        if ($this->getActive() === null) {
            $string .= '[active] => NULL<br />';
        } else {
            $this->getActive() ? $string .= '[active] => 1<br />' : $string .= '[active] => 0<br />';
        }
        if (count($this->getCommentators()) != 0) {
            foreach ($this->getCommentators() as $commentator) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= '[commentators] => ' . $commentator . '<br />';
            }
        } else {
            $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            $string .= '[commentators] => NULL<br />';
        }
        if (count($this->getComments()) != 0) {
            foreach ($this->getComments() as $comment) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= '[comments] => ' . $comment . '<br />';
            }
        } else {
            $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            $string .= '[comments] => NULL<br />';
        }
        $string .= '[counter] => ' . $this->getCounter() . '<br />';
        if ($this->getEvent() != null) {
            $string .= '[event] => ' . $this->getEvent()->getObjectId() . '<br />';
        } else {
            $string .= '[event] => NULL<br />';
        }
        if ($this->getFromUser() != null) {
            $string .= '[fromUser] => ' . $this->getFromUser()->getObjectId() . '<br />';
        } else {
            $string .= '[fromUser] => NULL<br />';
        }
        if ($this->getImage() != null) {
            $string .= '[image] => ' . $this->getImage()->getObjectId() . '<br />';
        } else {
            $string .= '[image] => NULL<br />';
        }
        //$imageFile = $this->getImageFile();
        //$string.="[imageFile] => " . $imageFile->getObjectId() . "<br />";
        if ($this->getLocation() != null) {
            $location = $this->getLocation();
            $string .= '[location] => ' . $location[latitude] . ', ' . $location[longitude] . '<br />';
        } else {
            $string .= '[location] => NULL<br />';
        }
        $string .= '[loveCounter] => ' . $this->getLoveCounter() . '<br />';
        if (count($this->getLovers()) != 0) {
            foreach ($this->getLovers() as $lovers) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= '[lovers] => ' . $lovers . '<br />';
            }
        } else {
            $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            $string .= '[lovers] => NULL<br />';
        }
        if ($this->getSong() != null) {
            $string .= '[song] => ' . $this->getSong()->getObjectId() . '<br />';
        } else {
            $string .= '[song] => NULL<br />';
        }
        if (count($this->getTaggedUsers()) != 0) {
            foreach ($this->getTaggedUsers() as $taggedUser) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= '[taggedUser] => ' . $taggedUser . '<br />';
            }
        } else {
            $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            $string .= '[taggedUser] => NULL<br />';
        }
        $string.= '[text] => ' . $this->getText() . '<br />';
        if ($this->getCreatedAt() != null) {
            $string .= '[createdAt] => ' . $this->getCreatedAt()->format('d-m-Y H:i:s') . '<br />';
        } else {
            $string .= '[createdAt] => NULL<br />';
        }
        if ($this->getUpdatedAt() != null) {
            $string .= '[updatedAt] => ' . $this->getUpdatedAt()->format('d-m-Y H:i:s') . '<br />';
        } else {
            $string .= '[updatedAt] => NULL<br />';
        }
        $string .= '[ACL] => ' . print_r($this->getACL(), true) . '<br />';
        return $string;
    }

}

?>