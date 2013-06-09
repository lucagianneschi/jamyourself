<?php

/* ! \par Info Generali:
 *  \author    Daniele Caldelli, Stefano Muscas
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par Info Classe:
 *  \brief     Comment 
 *  \details   Classe dedicata a POST, REVIEW, COMMENT & MESSAGGI 
 *  
 *  \par Commenti:
 *  \warning
 *  \bug
 *  \todo
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:comment">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:comment">API</a>
 */

define('CLASS_DIR', './');

class Comment {

    private $objectId;
    private $active;
    private $album;
    private $comment;
    private $commentators;
    private $comments;
    private $counter;
    private $event;
    private $fromUser;
    private $image;
    private $location;
    private $loveCounter;
    private $lovers;
    private $opinions;
    private $record;
    private $song;
    private $status;
    private $tags;
    private $text;
    private $toUser;
    private $type;
    private $video;
    private $vote;
    private $createdAt;
    private $updatedAt;
    private $ACL;

    public function __construct() {
        
    }

    public function getObjectId() {
        return $this->objectId;
    }

    public function getActive() {
        return $this->active;
    }

    public function getAlbum() {
        return $this->album;
    }

    public function getComment() {
        return $this->comment;
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

    public function getEvent() {
        return $this->event;
    }

    public function getFromUser() {
        return $this->fromUser;
    }

    public function getImage() {
        return $this->image;
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

    public function getOpinions() {
        return $this->opinions;
    }

    public function getRecord() {
        return $this->record;
    }

    public function getSong() {
        return $this->song;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getTags() {
        return $this->tags;
    }

    public function getText() {
        return $this->text;
    }

    public function getToUser() {
        return $this->toUser;
    }

    public function getType() {
        return $this->type;
    }

    public function getVideo() {
        return $this->video;
    }

    public function getVote() {
        return $this->vote;
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

    public function setObjectId($objectId) {
        $this->objectId = $objectId;
    }

    public function setActive($active) {
        $this->active = $active;
    }

    public function setAlbum(Album $album) {
        $this->album = $album;
    }

    public function setComment(Comment $comment) {
        $this->comment = $comment;
    }

    public function setCommentators(User $commentators) {
        $this->commentators = $commentators;
    }

    public function setComments(array $comments) {
        $this->comments = $comments;
    }

    public function setCounter($counter) {
        $this->counter = $counter;
    }

    public function setEvent(Event $event) {
        $this->event = $event;
    }

    public function setFromUser(User $fromUser) {
        $this->fromUser = $fromUser;
    }

    public function setImage(Image $image) {
        $this->image = $image;
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

    public function setOpinions(array $opinions) {
        $this->opinions = $opinions;
    }

    public function setRecord(Record $record) {
        $this->record = $record;
    }

    public function setSong(Song $song) {
        $this->song = $song;
    }

    public function setStatus(Status $status) {
        $this->status = $status;
    }

    public function setTags(array $tags) {
        $this->tags = $tags;
    }

    public function setText($text) {
        $this->text = $text;
    }

    public function setToUser(User $toUser) {
        $this->toUser = $toUser;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function setVideo(Video $video) {
        $this->video = $video;
    }

    public function setVote($vote) {
        $this->vote = $vote;
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
        if ($this->getAlbum() != null) {
            $album = $this->getAlbum();
            $string .= '[album] => ' . $album->getObjectId() . '<br />';
        }

        if ($this->getComment() != null) {
            $comment = $this->getComment();
            $string .= '[comment] => ' . $comment->getObjectId() . '<br />';
        }

        if ($this->getCommentators() != null && count($this->getCommentators()) > 0) {
            foreach ($this->getCommentators() as $commentator) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= '[commentators] => ' . $commentator->getObjectId() . '<br />';
            }
        }

        if ($this->getComments() != null && count($this->getComments()) > 0) {
            foreach ($this->getComments() as $comm) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= '[comments] => ' . $comm->getObjectId() . '<br />';
            }
        }

        $string .= '[counter] => ' . $this->getCounter() . '<br />';

        if ($this->getEvent() != null && count($this->getEvent()) > 0) {
            foreach ($this->getEvent() as $event) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= '[comments] => ' . $event->getObjectId() . '<br />';
            }
        }

        if (($fromUser = $this->getFromUser()) != null)
            $string .= '[fromUser] => ' . $fromUser->getObjectId() . '<br />';


        if (($image = $this->getImage() ) != null)
            $string .= '[image] => ' . $image->getObjectId() . '<br />';


        if (($parseGeoPoint = $this->getLocation() ) != null)
            $string .= '[geoCoding] => ' . $parseGeoPoint->lat . ', ' . $parseGeoPoint->long . '<br />';

        $string .= '[loveCounter] => ' . $this->getLoveCounter() . '<br />';

        if ($this->getLovers() != null)
            $string .= '[lovers] => ' . $this->getLovers() . '<br />';

        if ($this->getLovers() != null && count($this->getLovers()) > 0) {
            foreach ($this->getLovers() as $lover) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= '[lovers] => ' . $lover->getObjectId() . '<br />';
            }
        }

        $string .= '[opinions] => ' . $this->getOpinions() . '<br />';

        if ($this->getOpinions() != null && count($this->getOpinions()) > 0) {
            foreach ($this->getOpinions() as $opinion) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= '[opinions] => ' . $opinion->getObjectId() . '<br />';
            }
        }

        if (($record = $this->getRecord() ) != null)
            $string .= '[record] => ' . $record->getObjectId() . '<br />';
        if (($song = $this->getSong() ) != null)
            $string .= '[song] => ' . $song->getObjectId() . '<br />';
        if (($status = $this->getStatus() ) != null)
            $string .= '[status] => ' . $status->getObjectId() . '<br />';


        if ($this->getTags() != null && count($this->getTags()) > 0) {
            foreach ($this->getOpinions() as $opinion) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= '[tags] => ' . $opinion->getTags() . '<br />';
            }
        }


        $string .= '[text] => ' . $this->getText() . '<br />';
        if (($toUser = $this->getToUser() ) != null)
            $string .= '[toUser] => ' . $toUser->getObjectId() . '<br />';
        $string .= '[type] => ' . $this->getType() . '<br />';
        if (($video = $this->getVideo() ) != null)
            $string .= '[video] => ' . $video->getObjectId() . '<br />';
        $string .= '[vote] => ' . $this->getVote() . '<br />';
        if (($createdAt = $this->getCreatedAt()))
            $string .= '[createdAt] => ' . $createdAt->format('d-m-Y H:i:s') . '<br />';
        if (($updatedAt = $this->getUpdatedAt()))
            $string .= '[updatedAt] => ' . $updatedAt->format('d-m-Y H:i:s') . '<br />';
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