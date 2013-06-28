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

    /**
     * \fn	string getObjectId()
     * \brief	Return the objectId value
     * \return	string
     */
    public function getObjectId() {
        return $this->objectId;
    }

    /**
     * \fn	BOOL getActive()
     * \brief	Return the active vvalure
     * \return	BOOL
     */
    public function getActive() {
        return $this->active;
    }

    /**
     * \fn	string getAlbum()
     * \brief	Return the string value objectId to parseAlbum
     * \return	BOOL
     */
    public function getAlbum() {
        return $this->album;
    }

    /**
     * \fn	string getComment()
     * \brief	Return the related comment objectId
     * \return	string
     */
    public function getComment() {
        return $this->comment;
    }

    /**
     * \fn	array getCommentators()
     * \brief	Return an array of objectId of istances of _User class who commented on the video
     * \return	array
     */
    public function getCommentators() {
        return $this->commentators;
    }

    /**
     * \fn	array getComments()
     * \brief	Return an array of objectId of istances of the Comment class; comments on the comment istance
     * \return	array
     */
    public function getComments() {
        return $this->comments;
    }

    /**
     * \fn	int getCounter()
     * \brief	Return the counter value
     * \return	int
     */
    public function getCounter() {
        return $this->counter;
    }

    /**
     * \fn	string getEvent()
     * \brief	Return the related event objectId
     * \return	string
     */
    public function getEvent() {
        return $this->event;
    }

    /**
     * \fn	string getFromUser()
     * \brief	Return the objectId value for the fromUser
     * \return	string
     */
    public function getFromUser() {
        return $this->fromUser;
    }

    /**
     * \fn	string getImage()
     * \brief	Return the related image objectId
     * \return	string
     */
    public function getImage() {
        return $this->image;
    }

    /**
     * \fn	geopoint getLocation()
     * \brief	Return the location  value
     * \return	geopoint
     */
    public function getLocation() {
        return $this->location;
    }

    /**
     * \fn	int getLoveCounter()
     * \brief	Return the int value of loveCounter, counting the love action on the comment
     * \return	int
     */
    public function getLoveCounter() {
        return $this->loveCounter;
    }

    /**
     * \fn	array  getLovers()
     * \brief	Return the lovers value, array of objectId to istances of the _User, people ho love the comment
     * \return	array
     */
    public function getLovers() {
        return $this->lovers;
    }

    /**
     * \fn	array  getOpinions()
     * \brief	Return the opinions value, array of string
     * \return	array
     */
    public function getOpinions() {
        return $this->opinions;
    }

    /**
     * \fn	string getRecord()
     * \brief	Return the record value objectId
     * \return	string
     */
    public function getRecord() {
        return $this->record;
    }

    /**
     * \fn	string getSong()
     * \brief	Return the song value objectId
     * \return	string
     */
    public function getSong() {
        return $this->song;
    }

    /**
     * \fn	string getStatus()
     * \brief	Return the status valued objectId
     * \return	string
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * \fn	array getTags()
     * \brief	Return the tags value, array of string to categorize the comment
     * \return	array
     */
    public function getTags() {
        return $this->tags;
    }

    /**
     * \fn	string getText()
     * \brief	Return the text value
     * \return	string
     */
    public function getText() {
        return $this->text;
    }

    /**
     * \fn	string getToUser()
     * \brief	Return the toUser value, objectId
     * \return	string
     */
    public function getToUser() {
        return $this->toUser;
    }

    /**
     * \fn	string getType()
     * \brief	Return the type value
     * \return	string
     */
    public function getType() {
        return $this->type;
    }

    /**
     * \fn	string getVideo()
     * \brief	Return the video value objectId
     * \return	string
     */
    public function getVideo() {
        return $this->video;
    }

    /**
     * \fn	int getVote()
     * \brief	Return the vote, from 1 to 5
     * \return	int
     */
    public function getVote() {
        return $this->vote;
    }

    /**
     * \fn	DateTime getCreatedAt()
     * \brief	Return the Comment creation date
     * \return	DateTime
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * \fn	DateTime getUpdatedAt()
     * \brief	Return the Comment modification date
     * \return	DateTime
     */
    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    /**
     * \fn	parseACL getACL()
     * \brief	Return the parseACL object representing the Comment ACL 
     * \return	parseACL
     */
    public function getACL() {
        return $this->ACL;
    }

    /**
     * \fn	void setObjectId($objectId)
     * \brief	Sets the objectId value
     * \param	string
     */
    public function setObjectId($objectId) {
        $this->objectId = $objectId;
    }

    /**
     * \fn	void setActive($active)
     * \brief	Sets the active value
     * \param	BOOL
     */
    public function setActive($active) {
        $this->active = $active;
    }

    /**
     * \fn	void setAlbum($album)
     * \brief	Sets the album value
     * \param	string
     */
    public function setAlbum($album) {
        $this->album = $album;
    }

    /**
     * \fn	void setComment($comment)
     * \brief	Sets the comment value, objectId
     * \param	string
     */
    public function setComment($comment) {
        $this->comment = $comment;
    }

    /**
     * \fn	void setCommentators($commentators)
     * \brief	Sets the commentators value,array of pointer to ParseUser
     * \param	array
     */
    public function setCommentators($commentators) {
        $this->commentators = $commentators;
    }

    /**
     * \fn	void setComments($comments)
     * \brief	Sets the comments value,array of pointer to ParseComment
     * \param	array
     */
    public function setComments($comments) {
        $this->comments = $comments;
    }

    /**
     * \fn	void setCounter($counter)
     * \brief	Sets the counter value
     * \param	int
     */
    public function setCounter($counter) {
        $this->counter = $counter;
    }

    /**
     * \fn	void setEvent($event)
     * \brief	Sets the event objectId value
     * \param	string
     */
    public function setEvent($event) {
        $this->event = $event;
    }

    /**
     * \fn	void setFromUser($fromUser))
     * \brief	Sets the fromUser value,pointer to ParseUser
     * \param	string
     */
    public function setFromUser($fromUser) {
        $this->fromUser = $fromUser;
    }

    /**
     * \fn	void setImage($image)
     * \brief	Sets the image objectId value
     * \param	string
     */
    public function setImage($image) {
        $this->image = $image;
    }

    /**
     * \fn	void setLocation($location)
     * \brief	Sets the location value
     * \param	parseGeopoint
     */
    public function setLocation($location) {
        $this->location = $location;
    }

    /**
     * \fn	void setLoveCounter($loveCounter)
     * \brief	Sets the loveCounter value
     * \param	int
     */
    public function setLoveCounter($loveCounter) {
        $this->loveCounter = $loveCounter;
    }

    /**
     * \fn	void setLovers($lovers)
     * \brief	Sets the lovers value,array of pointer to ParseUser
     * \param	array
     */
    public function setLovers($lovers) {
        $this->lovers = $lovers;
    }

    /**
     * \fn	void setOpinions($opinions)
     * \brief	Sets the opinios, array of string
     * \param	array
     */
    public function setOpinions($opinions) {
        $this->opinions = $opinions;
    }

    /**
     * \fn	void setRecord($record)
     * \brief	Sets the record objectId value
     * \param	string
     */
    public function setRecord($record) {
        $this->record = $record;
    }

    /**
     * \fn	void setSong($song)
     * \brief	Sets the song objectId value
     * \param	string
     */
    public function setSong($song) {
        $this->song = $song;
    }

    /**
     * \fn	void setStatus($status)
     * \brief	Sets the status value objectId
     * \param	string
     */
    public function setStatus($status) {
        $this->status = $status;
    }

    /**
     * \fn	void setTags($tags)
     * \brief	Sets the tags value,array of strings
     * \param	array
     */
    public function setTags($tags) {
        $this->tags = $tags;
    }

    /**
     * \fn	void setText($text)
     * \brief	Sets the text value
     * \param	string
     */
    public function setText($text) {
        $this->text = $text;
    }

    /**
     * \fn	void setToUser($toUser)
     * \brief	Sets the toUser objectId value
     * \param	string
     */
    public function setToUser($toUser) {
        $this->toUser = $toUser;
    }

    /**
     * \fn	void setType($type)
     * \brief	Sets the type objectId value
     * \param	string
     */
    public function setType($type) {
        $this->type = $type;
    }

    /**
     * \fn	void setVideo($video)
     * \brief	Sets the video objectId value
     * \param	string
     */
    public function setVideo($video) {
        $this->video = $video;
    }

    /**
     * \fn	void setVote($vote)
     * \brief	Sets the vote value
     * \param	int
     */
    public function setVote($vote) {
        $this->vote = $vote;
    }

    /**
     * \fn	void setCreatedAt($createdAt)
     * \brief	Sets the Comment creation date
     * \param	DateTime
     */
    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }

    /**
     * \fn	void setUpdatedAt($updatedAt)
     * \brief	Sets the Comment modification date
     * \param	DateTime
     */
    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    /**
     * \fn	void setACL($ACL)
     * \brief	Sets the parseACL object representing the Comment ACL
     * \param	parseACL
     */
    public function setACL($ACL) {
        $this->ACL = $ACL;
    }

    /**
     * \fn	string __toString()
     * \brief	Return a printable string representing the Comment object
     * \return	string
     */
    public function __toString() {
        $string = '';
        $string .= '[objectId] => ' . $this->getObjectId() . '<br />';
        if (is_null($this->getActive())) {
            $string .= '[active] => NULL<br />';
        } else {
            $this->getActive() ? $string .= '[active] => 1<br />' : $string .= '[active] => 0<br />';
        }
        if ($this->getAlbum() != null) {
            $string .= '[album] => ' . $this->getAlbum() . '<br />';
        } else {
            $string .= '[album] => NULL<br />';
        }
        if ($this->getComment() != null) {
            $string .= '[comment] => ' . $this->getComment() . '<br />';
        } else {
            $string .= '[comment] => NULL<br />';
        }
        if (count($this->getCommentators()) != 0) {
            foreach ($this->getCommentators() as $commentators) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= '[commentators] => ' . $commentators . '<br />';
            }
        } else {
            $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            $string .= '[commentators] => NULL<br />';
        }
        if (count($this->getComments()) != 0) {
            foreach ($this->getComments() as $comments) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= '[comments] => ' . $comments . '<br />';
            }
        } else {
            $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            $string .= '[comments] => NULL<br />';
        }
        $string .= '[counter] => ' . $this->getCounter() . '<br />';
        if ($this->getEvent() != null) {
            $string .= '[event] => ' . $this->getEvent() . '<br />';
        } else {
            $string .= '[event] => NULL<br />';
        }
        if ($this->getFromUser() != null) {
            $string .= '[fromUser] => ' . $this->getFromUser() . '<br />';
        } else {
            $string .= '[fromUser] => NULL<br />';
        }
        if ($this->getImage() != null) {
            $string .= '[image] => ' . $this->getImage() . '<br />';
        } else {
            $string .= '[image] => NULL<br />';
        }
        if (($geoPoint = $this->getLocation()) != null) {
            $string .= '[location] => ' . $geoPoint->location->lat . ', ' . $geoPoint->location->long . '<br />';
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
        if (count($this->getOpinions()) != 0) {
            foreach ($this->getOpinions() as $opinions) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= '[opinions] => ' . $opinions . '<br />';
            }
        } else {
            $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            $string .= '[opinions] => NULL<br />';
        }
        if ($this->getRecord() != null) {
            $string .= '[record] => ' . $this->getRecord() . '<br />';
        } else {
            $string .= '[record] => NULL<br />';
        }
        if ($this->getSong() != null) {
            $string .= '[song] => ' . $this->getSong() . '<br />';
        } else {
            $string .= '[song] => NULL<br />';
        }
        if ($this->getStatus() != null) {
            $string .= '[status] => ' . $this->getStatus() . '<br />';
        } else {
            $string .= '[status] => NULL<br />';
        }
        if (count($this->getTags()) != 0) {
            foreach ($this->getTags() as $tags) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= '[tags] => ' . $tags . '<br />';
            }
        } else {
            $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            $string .= '[tags] => NULL<br />';
        }
        $string .= '[text] => ' . $this->getText() . '<br />';
        if ($this->getToUser() != null) {
            $string .= '[toUser] => ' . $this->getToUser() . '<br />';
        } else {
            $string .= '[toUser] => NULL<br />';
        }
        $string .= '[type] => ' . $this->getType() . '<br />';
        if ($this->getVideo() != null) {
            $string .= '[video] => ' . $this->getVideo() . '<br />';
        } else {
            $string .= '[video] => NULL<br />';
        }
        $string .= '[vote] => ' . $this->getVote() . '<br />';
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
        if ($this->getACL() != null) {
            foreach ($this->getACL()->acl as $key => $acl) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= '[ACL] => ' . $key . '<br />';
                foreach ($acl as $access => $value) {
                    $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    $string .= '[access] => ' . $access . ' -> ' . $value . '<br />';
                }
            }
        } else {
            $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            $string .= '[ACL] => NULL<br />';
        }
        return $string;
    }

}

?>