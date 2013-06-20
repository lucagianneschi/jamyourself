<?php

/* ! \par Info Generali:
 *  \author    Maria Laura Fresu
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par Info Classe:
 *  \brief     Album
 *  \details   Classe raccoglitore per immagini
 *  
 *  \par Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:album">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:album">API</a>
 */

class Album {

    private $objectId;
    private $active;
    private $commentators;
    private $comments;
    private $counter;
    private $cover;
    private $coverFile;
    private $description;
    private $featuring;
    private $fromUser;
    private $images;
    private $location;
    private $loveCounter;
    private $lovers;
    private $tags;
    private $thumbnailCover;
    private $title;
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

    public function getCommentators() {
        return $this->commentators;
    }

    public function getComments() {
        return $this->comments;
    }

    public function getCover() {
        return $this->cover;
    }

    public function getCoverFile() {
        return $this->coverFile;
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

    public function getFromUser() {
        return $this->fromUser;
    }

    public function getImages() {
        return $this->images;
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

    public function getThumbnailCover() {
        return $this->thumbnailCover;
    }

    public function getTitle() {
        return $this->title;
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

    public function setObjectId($objectId) {
        $this->objectId = $objectId;
    }

    public function setActive($active) {
        $this->active = $active;
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

    public function setCover($cover) {
        $this->cover = $cover;
    }

    public function setCoverFile($coverFile) {
        $this->cover = $coverFile;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setFeaturing($featuring) {
        $this->featuring = $featuring;
    }

    public function setFromUser($fromUser) {
        $this->fromUser = $fromUser;
    }

    public function setImages($images) {
        $this->images = $images;
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

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setThumbnailCover($thumbnailCover) {
        $this->thumbnailCover = $thumbnailCover;
    }

    public function setTags($tags) {
        $this->tag = $tags;
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
        $string = "";

        if ($this->objectId != null)
            $string .= "[ objectId ] => " . $this->objectId . "</br>";
        if ($this->active != null)
            $string .= "[ active ] => " . $this->active . "</br>";
        if ($this->commentators != null && count($this->commentators) > 0) {
            $string .= "[ commentators	] => </br>";
            foreach ($this->commentators as $commentator) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= '[$commentator] => ' . $commentator . '<br />';
            }
        }
        if ($this->comments != null && count($this->comments) > 0) {
            $string .= "[ comments ] => </br>";
            foreach ($this->comments as $comment) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= '[$comment] => ' . $comment . '<br />';
            }
        }
        if ($this->counter != null)
            $string .= "[ counter ] => " . $this->counter . "</br>";
        if ($this->cover != null)
            $string .= "[ cover	] => " . $this->cover . "</br>";
//        if ($this->coverFile != null)
//            $string .= "[ coverFile ] => " . $this->coverFile . "</br>";
        if ($this->description != null)
            $string .= "[ description ] => " . $this->description . "</br>";
        if ($this->featuring != null && count($this->featuring) > 0) {
            $string .= "[ featuring ] => </br>";
            foreach ($this->featuring as $user) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= '[featuring] => ' . $user . '<br />';
            }            
        }
        if ($this->fromUser != null)
            $string .= "[ fromUser ] => " . $this->fromUser . "</br>";
        
        if ($this->images != null) {
            $string .= "[ images ] => " . $this->images . "</br>";
            foreach ($this->images as $image) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= '[image] => ' . $image . '<br />';
            }             
        }
        if ($this->location != null)
            $string .= "[location] => " . $this->location[latitude] . ", " . $this->location[longitude] . "<br />";
        if ($this->loveCounter != null)
            $string .= "[ loveCounter ] => " . $this->loveCounter . "</br>";
        if ($this->lovers != null && count($this->lovers) > 0) {
            $string .= "[ lovers ] => </br>";
            foreach ($this->lovers as $lover) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= '[lover] => ' . $lover . '<br />';
            }              
        }

        if ($this->tags != null && count($this->tags) > 0) {
            $string .= "[ tags ] => </br>";
            foreach ($this->tags as $tag) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= '[tag] => ' . $tag . '<br />';
            }             
        }

        if ($this->thumbnailCover != null)
            $string .= "[ thumbnailCover ] => " . $this->thumbnailCover . "</br>";
        if ($this->title != null)
            $string .= "[ title	] => " . $this->title . "</br>";
        if ($this->createdAt != null)
            $string .= "[ createdAt ] => " . $this->createdAt->format('d/m/Y H:i:s') . "</br>";
        if ($this->updatedAt != null)
            $string .= "[ updatedAt ] => " . $this->updatedAt->format('d/m/Y H:i:s') . "</br>";
        if ($this->ACL != null) {
            $string .= "[ ACL ] => </br>";
            foreach ($this->ACL->acl as $key => $acl) {
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