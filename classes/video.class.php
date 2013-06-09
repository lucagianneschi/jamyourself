<?php

/* ! \par Info Generali:
 *  \author    Stefano Muscas
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par Info Classe:
 *  \brief     Video Class
 *  \details   Classe che contiene i video presi da Vimeo e Youtube e segnalati dagli utenti 
 *  
 *  \par Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:video">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php??id=documentazione:api:video">API</a>
 */

class Video {

    private $objectId;    //string: objectId su Parse  								
    private $active;      //BOOL: segnala se l'istanza della classe è attiva o no 	
    private $author;   //string: Utente che ha girato il video 					
    private $commentators;      //relation: array di puntatori ad User che hanno commentator
    private $comments;          //relation: array di puntatori a Comment
    private $counter;   //number: Contatore per il gradimento 						
    private $description;  //string: Descrizione del video data dall'utente  			
    private $duration;   //number: Durata del video in secondi	
    private $featuring;   //Relation (with Parse User): segnala presenza altri utenti 
    private $fromUser;     //User: Punta allo user che effettua l'embed del video  
    private $loveCounter;  //number: Contatore per il numero di azioni love 			
    private $lovers;            //relation: array di puntatori ad User che hanno effettuato azioni love 
    private $tags;    //array: stringhe per la categorizzazione del video 	
    private $thumbnail;    //string: Percorso immagine del thumbnail del video 		
    private $title;    //string:Titolo del video  									
    private $URL;       //string: URL del video  									
    private $createdAt;   //DataTime: data di creazione del video						
    private $updatedAt;   //DataTime: data di update del video						
    private $ACL;    //Access Control List										

    public function __construct() {
        
    }

    /** FUNZIONI GET */
    //string: objectId su Parse  								
    public function getObjectId() {
        return $this->objectId;
    }

    //BOOL: segnala se l'istanza della classe è attiva o no 	
    public function getActive() {
        return $this->active;
    }

    //string: Utente che ha girato il video 					
    public function getAuthor() {
        return $this->author;
    }

    //relation: array di puntatori ad User che hanno commentators 
    public function getCommentators() {
        return $this->commentators;
    }

    //relation: array di puntatori a Comments
    public function getComments() {
        return $this->comments;
    }

    //number: Contatore per il gradimento 						
    public function getCounter() {
        return $this->counter;
    }

    //string: Descrizione del video data dall'utente  			
    public function getDescription() {
        return $this->description;
    }

    //number: Durata del video									
    public function getDuration() {
        return $this->duration;
    }

    //Relation (with Parse User): segnala presenza altri utenti 			
    public function getFeaturing() {
        return $this->featuring;
    }

    //User: Punta allo user che effettua l'embed del video  	
    public function getFromUser() {
        return $this->fromUser;
    }

    //number: Contatore per il numero di azioni love 			
    public function getLoveCounter() {
        return $this->loveCounter;
    }

    //relation: array di puntatori ad User che hanno effettuato azioni love
    public function getLovers() {
        return $this->lovers;
    }

    //array: stringhe per la categorizzazione del video 		
    public function getTags() {
        return $this->tags;
    }

    //string:Titolo del video  									
    public function getTitle() {
        return $this->title;
    }

    //string: Percorso immagine del thumbnail del video 		
    public function getThumbnail() {
        return $this->thumbnail;
    }

    //string: URL del video  									
    public function getURL() {
        return $this->URL;
    }

    //DataTime: data di creazione del video						
    public function getCreatedAt() {
        return $this->createdAt;
    }

    //DataTime: data di update del video						
    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    //Access Control List										
    public function getACL() {
        return $this->ACL;
    }

    /** FUNZIONI SET */
    //string: objectId su Parse  								
    public function setObjectId($objecId) {
        $this->objectId = $objecId;
    }

    //BOOL: segnala se l'istanza della classe è attiva o no 	
    public function setActive($active) {
        $this->active = $active;
    }

    //string: Utente che ha girato il video 					
    public function setAuthor($author) {
        $this->author = $author;
    }

    //relation: array di User che hanno commentators 
    public function setCommentators(array $commentators) {
        $this->commentators = $commentators;
    }

    //relation: array di Comment 
    public function setComments(array $comments) {
        $this->comments = $comments;
    }

    //number: Contatore per il gradimento 					
    public function setCounter($counter) {
        $this->counter = $counter;
    }

    //string: Descrizione del video data dall'utente  			
    public function setDescription($description) {
        $this->description = $description;
    }

    //number: Durata del video									
    public function setDuration($duration) {
        $this->duration = $duration;
    }

    //Relation (with Parse User): segnala presenza altri utenti			
    public function setFeaturing(array $featuring) {
        $this->featuring = $featuring;
    }

    //User: Punta allo user che effettua l'embed del video  	
    public function setFromUser(User $fromUser) {
        $this->fromUser = $fromUser;
    }

    //relation: array di puntatori ad User che hanno effettuato azioni love  
    public function setLovers(array $lovers) {
        $this->lovers = $lovers;
    }

    //number: Contatore per il numero di azioni love 			
    public function setLoveCounter($loveCounter) {
        $this->loveCounter = $loveCounter;
    }

    //array: stringhe per la categorizzazione del video 	
    public function setTags(array $tags) {
        $this->tags = $tags;
    }

    //string:Titolo del video  									
    public function setTitle($title) {
        $this->title = $title;
    }

    //string: Percorso immagine del thumbnail del video 		
    public function setThumbnail($thumbnail) {
        $this->thumbnail = $thumbnail;
    }

    //string: URL del video  									
    public function setURL($URL) {
        $this->URL = $URL;
    }

    //DataTime: data di creazione del video						
    public function setCreatedAt(DateTime $createdAt) {
        $this->createdAt = $createdAt;
    }

    //DataTime: data di update del video						
    public function setUpdatedAt(DateTime $updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    //Access Control List										
    public function setACL($ACL) {
        $this->ACL = $ACL;
    }

    public function __toString() {
        $string = '';
        $string .= '[objectId] => ' . $this->getObjectId() . '<br />';
        $string .= '[active] => ' . $this->getActive() . '<br />';
        $string .= '[author] => ' . $this->getAuthor() . '<br />';
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
        $string.="[counter] => " . $this->getCounter() . "<br />";
        $string.="[description] => " . $this->getDescription() . "<br />";
        $string.="[duration] => " . $this->getDuration() . "<br />";
        if ($this->getFeaturing() != null && count($this->getFeaturing() > 0)) {
            foreach ($this->getFeaturing() as $user) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= "[featuring] => " . $user->getObjectId() . "<br />";
            }
        }
        $fromUser = $this->getFromUser();
        if ($fromUser->getObjectId() != null) {
            $string.="[fromUser] => " . $fromUser->getObjectId() . "<br />";
        }
        $string.="[loveCounter] => " . $this->getLoveCounter() . "<br />";
        if ($this->getLovers() != null && count($this->getLovers() > 0)) {
            foreach ($this->getLovers() as $lover) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= "[lover] => " . $lover->getObjectId() . "<br />";
            }
        }
        if ($this->getTags() != null && count($this->getTags() > 0)) {
            foreach ($this->getTags() as $tag) {
                $string.="&nbsp&nbsp&nbsp&nbsp&nbsp";
                $string.="[tag] => " . $tag . "<br />";
            }
        }
        $string.="[thumbnail] => " . $this->getThumbnail() . "<br />";
        $string.="[title] => " . $this->getTitle() . "<br />";
        $string.="[URL] => " . $this->getURL() . "<br />";
        $string .= '[createdAt] => ' . $this->getCreatedAt()->format('d-m-Y H:i:s') . '<br />';
        $string .= '[updatedAt] => ' . $this->getUpdatedAt()->format('d-m-Y H:i:s') . '<br />';
        foreach ($this->getACL()->acl as $key => $acl) {
            $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            $string .= '[key] => ' . $key . '<br />';
            foreach ($acl as $access => $value) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= '[access] => ' . $access . ' -> ' . $value . '<br />';
            }
        }
        return $string;
    }

}

?>