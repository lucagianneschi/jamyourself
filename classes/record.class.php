<?php

/* ! \par Info Generali:
 *  \author    Stefano Muscas
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par Info Classe:
 *  \brief     Record Class
 *  \details   Classe dedicata ad un album di brani musicali, pu� essere istanziata solo da Jammer
 *  
 *  \par Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:record">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:record">API</a>
 */

define('CLASS_DIR', './');

class Record {

    private $objectId;
    private $active;
    private $buyLink;
    private $commentators;
    private $comments;
    private $counter;
    private $cover;
    private $coverFile;
    private $description;
    private $duration;
    private $featuring;
    private $fromUser;
    private $genre;
    private $label;
    private $location;
    private $loveCounter;
    private $lovers;
    private $thumbnailCover;
    private $title;
    private $tracklist;
    private $year;
    private $createdAt;
    private $updatedAt;
    private $ACL;

    //FUNZIONI GETTER

    public function getObjectId() {
        return $this->objectId;
    }

    public function getActive() {
        return $this->active;
    }

    public function getBuyLink() {
        return $this->buyLink;
    }

    //relation: puntatori ad oggetti Comment 								
    public function getCommentators() {
        return $this->commentators;
    }

    //relation: puntatori ad oggetti Comment 								
    public function getComments() {
        return $this->comments;
    }

    public function getCounter() {
        return $this->counter;
    }

    public function getCover() {
        return $this->cover;
    }

    public function getCoverFile() {
        return $this->coverFile;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getDuration() {
        return $this->duration;
    }

    public function getFeaturing() {
        return $this->featuring;
    }

    public function getFromUser() {
        return $this->fromUser;
    }

    public function getGenre() {
        return $this->genre;
    }

    public function getLabel() {
        return $this->label;
    }

    public function getLocation() {
        return $this->location;
    }

    public function getLoveCounter() {
        return $this->loveCounter;
    }

    public function getLovers() {
        return $this->lovers;
    }

    public function getThumbnailCover() {
        return $this->thumbnailCover;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getTracklist() {
        return $this->tracklist;
    }

    public function getYear() {
        return $this->year;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    public function getACL() {
        return $this->ACL;
    }

    //FUNZIONI SETTER

    public function setObjectId($objectId) {
        $this->objectId = $objectId;
    }

    public function setActive($active) {
        $this->active = $active;
    }

    public function setBuyLink($buyLink) {
        $this->buyLink = $buyLink;
    }

    //relation: puntatori ad oggetti Comment
    public function setCommentators(array $commentators) {
        $this->comments = $commentators;
    }

    //relation: puntatori ad oggetti Comment
    public function setComments(array $comments) {
        $this->comments = $comments;
    }

    public function setCounter($counter) {
        $this->counter = $counter;
    }

    public function setCover($cover) {
        $this->cover = $cover;
    }

    public function setCoverFile($coverFile) {
        $this->coverFile = $coverFile;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setDuration($duration) {
        $this->duration = $duration;
    }

    public function setFeaturing(array $featuring) {
        $this->featuring = $featuring;
    }

    public function setFromUser(User $fromUser) {
        $this->fromUser = $fromUser;
    }

    public function setGenre($genre) {
        $this->genre = $genre;
    }

    public function setLabel($label) {
        $this->label = $label;
    }

    public function setLocation($location) {
        $this->location = $location;
    }

    public function setLoveCounter($loveCounter) {
        $this->loveCounter = $loveCounter;
    }

    public function setLovers(array $lovers) {
        $this->lovers = $lovers;
    }

    public function setThumbnailCover($thumbnailCover) {
        $this->thumbnailCover = $thumbnailCover;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setTracklist(array $tracklist) {
        $this->tracklist = $tracklist;
    }

    public function setYear($year) {
        $this->year = $year;
    }

    public function setCreatedAt(DateTime $createdAt) {
        $this->createdAt = $createdAt;
    }

    public function setUpdatedAt(DateTime $updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    public function setACL($ACL) {
        $this->ACL = $ACL;
    }

    public function __toString() {
        $string = '';
        $string .= '[objectId] => ' . $this->getObjectId() . '<br />';
        $string .= '[active] => ' . $this->getActive() . '<br />';
        $string .= '[buyLink] => ' . $this->getBuyLink() . '<br />';
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
        $string .= '[cover] => ' . $this->getCover() . '<br />';
        //$string .= '[coverFile] => ' . $this->getCoverFile() . '<br />';
        $string .= '[description] => ' . $this->getDescription() . '<br />';
        $string .= '[duration] => ' . $this->getDuration() . '<br />';
        if ($this->getFeaturing() != null && count($this->getFeaturing() > 0)) {
            foreach ($this->getFeaturing() as $user) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= "[featuring] => " . $user->getObjectId() . "<br />";
            }
        }
        $fromUser = $this->getFromUser();
        if ($fromUser != null) {
            $string.="[fromUser] => " . $fromUser->getObjectId() . "<br />";
        }
        $string.="[genre] => " . $this->getGenre() . "<br />";
        $string.="[label] => " . $this->getLabel() . "<br />";
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
        $string .= "[thumbnailCover] => " . $this->getThumbnailCover() . "<br />";
        $string .= "[title] => " . $this->getTitle() . "<br />";
        if ($this->getTracklist() != null && count($this->getTracklist() > 0)) {
            foreach ($this->getTracklist() as $song) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= "[tracklist] => " . $song->getObjectId() . "<br />";
            }
        }
        $string .= "[year] => " . $this->getYear() . "<br />";
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