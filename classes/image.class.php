<?php

/* ! \par Info Generali:
 *  \author    Maria Laura Fresu
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par Info Classe:
 *  \brief     Image
 *  \details   Classe per la singola immagine caricata dall'utente
 *  
 *  \par Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:image">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:image">API</a>
 */

class Image {

    private $objectId;
    private $active;
    private $album;
    private $commentators;
    private $comments;
    private $counter;
    private $description;
    private $featuring;
    private $file;
    private $filePath;
    private $fromUser;
    private $location;
    private $loveCounter;
    private $lovers;
    private $tags;
    private $createdAt;
    private $updatedAt;
    private $ACL;

    //costruttore
    public function __construct() {
        
    }

    //getters
    public function getObjectId() {
        return $this->objectId;
    }

    public function getActive() {
        return $this->active;
    }

    public function getAlbum() {
        return $this->album;
    }

    public function getCommentators() {
        return $this->commentators;
    }

    public function getComments() {
        return $this->comments;
    }

    public function getCounter() {
        return $this->counter;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getFeaturing() {
        return $this->featuring;
    }

    public function getFile() {
        return $this->file;
    }

    public function getFilePath() {
        return $this->filePath;
    }

    public function getFromUser() {
        return $this->fromUser;
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

    public function getTags() {
        return $this->tags;
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

    //setters
    public function setOjectId($objectId) {
        $this->objectId = $objectId;
    }

    public function setActive($active) {
        $this->active = $active;
    }

    public function setAlbum($album) {
        $this->album = $album;
    }

    public function setCommentators($commentators) {
        $this->commentators = $commentators;
    }

    public function setComments($comments) {
        $this->comments = $comments;
    }

    public function setCounter($counter) {
        $this->counter = $counter;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setFeaturing($featuring) {
        $this->featuring = $featuring;
    }

    public function setFile($file) {
        $this->file = $file;
    }

    public function setFilePath($filePath) {
        $this->filePath = $filePath;
    }

    public function setFromUser($fromUser) {
        $this->fromUser = $fromUser;
    }

    public function setLocation($location) {
        $this->location = $location;
    }

    public function setLoveCounter($loveCounter) {
        $this->loveCounter = $loveCounter;
    }

    public function setLovers($lovers) {
        $this->lovers = $lovers;
    }

    public function setTags($tags) {
        $this->tags = $tags;
    }

    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }

    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    public function setACL($ACL) {
        $this->ACL = $ACL;
    }

    public function __toString() {
        $string = '';
        $string .= '[objectId] => ' . $this->getObjectId() . '<br />';
        $string .= '[active] => ' . $this->getActive() . '<br />';
        $album = $this->getAlbum();
        $string.="[album] => " . $album->getObjectId() . "<br />";
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
        $string .= '[description] => ' . $this->getDescription() . '<br />';
        if ($this->getFeaturing() != null && count($this->getFeaturing() > 0)) {
            foreach ($this->getFeaturing() as $user) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= "[featuring] => " . $user->getObjectId() . "<br />";
            }
        }
        //$string .= '[file] => ' . $this->getFile() . '<br />';
        $string .= '[filePath] => ' . $this->getFilePath() . '<br />';
        $fromUser = $this->getFromUser();
        if ($fromUser != null) {
            $string.="[fromUser] => " . $fromUser->getObjectId() . "<br />";
        }
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
        if ($this->getTags() != null && count($this->getTags() > 0)) {
            foreach ($this->getTags() as $tag) {
                $string.="&nbsp&nbsp&nbsp&nbsp&nbsp";
                $string.="[tag] => " . $tag . "<br />";
            }
        }
        if (($createdAt = $this->getCreatedAt()))
            $string .= '[createdAt] => ' . $createdAt->format('d-m-Y H:i:s') . '<br />';
        if (($updatedAt = $this->getUpdatedAt()))
            $string .= '[updatedAt] => ' . $updatedAt->format('d-m-Y H:i:s') . '<br />';
        if ($this->getACL() != null) {
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
