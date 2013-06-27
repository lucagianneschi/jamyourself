<?php

/* ! \par Info Generali:
 *  \author    Stefano Muscas
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par Info Classe:
 *  \brief     Playslist
 *  \details   Classe che accoglie le canzoni che andranno nel player della pagina utente
 *  
 *  \par Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:activity">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:activity">API</a>
 */

class Activity {

    private $objectId;
    private $accepted;
    private $active;
    private $album;
    private $comment;
    private $event;
    private $fromUser;
    private $image;
    private $playlist;
    private $question;
    private $read;
    private $song;
    private $status;
    private $toUser;
    private $type;
    private $userStatus;
    private $video;
    private $createdAt;
    private $updatedAt;
    private $ACL;

    /**
     * \fn	string getObjectId()
     * \brief	Return the objectId value
     * \return	string
     */
    public function getObjectId() {
        return $this->objectId;
    }

    /**
     * \fn	BOOL getAccepted()
     * \brief	Return the active value
     * \return	BOOL
     */
    public function getAccepted() {
        return $this->accepted;
    }

    /**
     * \fn	BOOL getActive()
     * \brief	Return the active value
     * \return	BOOL
     */
    public function getActive() {
        return $this->active;
    }

    /**
     * \fn	BOOL getActive()
     * \brief	Return the active vvalure
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
     * \fn	string getEvent()
     * \brief	Return the related event objectId
     * \return	string
     */
    public function getEvent() {
        return $this->event;
    }

    /**
     * \fn	string getFromUser()
     * \brief	Return the related fromUser objectId
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
     * \fn	string getPlaylist()
     * \brief	Return the related playlist objectId
     * \return	string
     */
    public function getPlaylist() {
        return $this->playlist;
    }

    /**
     * \fn	string getQuestion()
     * \brief	Return the related question objectId
     * \return	string
     */
    public function getQuestion() {
        return $this->question;
    }

    /**
     * \fn	BOOL getRead()
     * \brief	Return the read value, used for notification
     * \return	BOOL
     */
    public function getRead() {
        return $this->read;
    }

    /**
     * \fn	string getStatus()
     * \brief	Return the status value, P for pending, A for accepted & R for refused
     * \return	string
     */
    public function getStatus() {
        return $this->status;
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
     * \fn	string getUserStatus()
     * \brief	Return the userStatus value,objectId
     * \return	string
     */
    public function getUserStatus() {
        return $this->userStatus;
    }

    /**
     * \fn	string getFromUser()
     * \brief	Return the objectId value for the fromUser
     * \return	string
     */
    public function getVideo() {
        return $this->video;
    }

    /**
     * \fn	DateTime getCreatedAt()
     * \brief	Return the Video creation date
     * \return	DateTime
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * \fn	DateTime getUpdatedAt()
     * \brief	Return the Video modification date
     * \return	DateTime
     */
    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    /**
     * \fn	parseACL getACL()
     * \brief	Return the parseACL object representing the Video ACL 
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
     * \fn	void setAccepted($accepted)
     * \brief	Sets the active value
     * \param	BOOL
     */
    public function setAccepted($accepted) {
        $this->accepted = $accepted;
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
     * \fn	void setEvent($event)
     * \brief	Sets the event objectId value
     * \param	string
     */
    public function setEvent($event) {
        $this->event = $event;
    }

    /**
     * \fn	void setFromUser($fromUser)
     * \brief	Sets the fromUser objectId value
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
     * \fn	void setPlaylist($playlist)
     * \brief	Sets the playlist objectId value
     * \param	string
     */
    public function setPlaylist($playlist) {
        $this->playlist = $playlist;
    }

    /**
     * \fn	void setQuestion($question)
     * \brief	Sets the question objectId value
     * \param	string
     */
    public function setQuestion($question) {
        $this->question = $question;
    }

    /**
     * \fn	void setRead($read)
     * \brief	Sets the read value
     * \param	BOOL
     */
    public function setRead($read) {
        $this->read = $read;
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
     * \fn	void setStatus($status)
     * \brief	Sets the status value, P for pending, A for accepted, R for refused
     * \param	string
     */
    public function setStatus($status) {
        $this->status = $status;
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
     * \fn	void setUserStatus($userStatus)
     * \brief	Sets the userStatus objectId value
     * \param	string
     */
    public function setUserStatus($userStatus) {
        $this->userStatus = $userStatus;
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
     * \fn	void setCreatedAt($createdAt)
     * \brief	Sets the Video creation date
     * \param	DateTime
     */
    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }

    /**
     * \fn	void setUpdatedAt($updatedAt)
     * \brief	Sets the Video modification date
     * \param	DateTime
     */
    public function setUpdatedAt($updatedAt) {
        return $this->updatedAt = $updatedAt;
    }

    /**
     * \fn	void setACL($ACL)
     * \brief	Sets the parseACL object representing the Video ACL
     * \param	parseACL
     */
    public function setACL($ACL) {
        return $this->ACL = $ACL;
    }

    /**
     * \fn	string __toString()
     * \brief	Return a printable string representing the Activity object
     * \return	string
     */
    public function __toString() {

        $string = "";

        if ($this->objectId != null)
            $string .= "[ objectId ] => " . $this->objectId . "<br />";
        else
            $string .= "[ objectId ] => NULL<br />";
        if (is_bool($this->accepted)) {
            $bool = ($this->accepted) ? 'TRUE' : 'FALSE';
            $string .= "[ accepted ] => " . $bool . "<br />";
        }
        else
            $string .= "[ accepted ] => NULL<br />";
        if (is_bool($this->active)) {
            $bool = ($this->active) ? 'TRUE' : 'FALSE';
            $string .= "[ active ] => " . $bool . "<br />";
        }
        else
            $string .= "[ active ] => NULL<br />";
        if ($this->album != null)
            $string .= " [ album ] => " . $this->album . "<br />";
        else
            $string .= "[ album ] => NULL<br />";
        if ($this->comment != null)
            $string .= " [ comment ] => " . $this->comment . "<br />";
        else
            $string .= "[ comment ] => NULL<br />";
        if ($this->event != null)
            $string .= " [ event ] => " . $this->event . "<br />";
        else
            $string .= "[ event ] => NULL<br />";
        if ($this->fromUser != null)
            $string .= " [ fromUser ] => " . $this->fromUser . "<br />";
        else
            $string .= "[ fromUser ] => NULL<br />";
        if ($this->image != null)
            $string .= " [ image ] => " . $this->image . "<br />";
        else
            $string .= "[ image ] => NULL<br />";
        if ($this->playlist != null)
            $string .= " [ playlist ] => " . $this->playlist . "<br />";
        else
            $string .= "[ playlist ] => NULL<br />";
        if ($this->question != null)
            $string .= " [ question ] => " . $this->question . "<br />";
        else
            $string .= "[ question ] => NULL<br />";
        if (is_bool($this->read)) {
            $bool = ($this->read) ? 'TRUE' : 'FALSE';
            $string .= " [ read ] => " . $bool . "<br />";
        }
        else
            $string .= "[ read ] => NULL<br />";
        if ($this->record != null)
            $string .= " [ record ] => " . $this->record . "<br />";
        else
            $string .= "[ record ] => NULL<br />";
        if ($this->song != null)
            $string .= " [ song ] => " . $this->song . "<br />";
        else
            $string .= "[ song ] => NULL<br />";
        if ($this->status != null)
            $string .= " [ status ] => " . $this->status . "<br />";
        else
            $string .= "[ status ] => NULL<br />";
        if ($this->toUser != null)
            $string .= " [ toUser ] => " . $this->toUser . "<br />";
        else
            $string .= "[ toUser ] => NULL<br />";
        if ($this->type != null)
            $string .= " [ type ] => " . $this->type . "<br />";
        else
            $string .= "[ type ] => NULL<br />";
        if ($this->userStatus != null)
            $string .= " [ userStatus ] => " . $this->userStatus . "<br />";
        else
            $string .= "[ userStatus ] => NULL<br />";
        if ($this->video != null)
            $string .= " [ video ] => " . $this->video . "<br />";
        else
            $string .= "[ video ] => NULL<br />";
        if ($this->createdAt != null)
            $string.="[ updatedAt ] => " . $this->createdAt->format('d/m/Y H:i:s') . "<br />";
        else
            $string .= "[ updatedAt ] => NULL<br />";
        if ($this->updatedAt != null)
            $string.="[ createdAt ] => " . $this->updatedAt->format('d/m/Y H:i:s') . "<br />";
        else
            $string .= "[ createdAt ] => NULL<br />";
        if ($this->getACL() != null) {
            $string .= '[ ACL ] => <br />';
            foreach ($this->getACL()->acl as $key => $acl) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= '[ key ] => ' . $key . '<br />';
                foreach ($acl as $access => $value) {
                    $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    $string .= '[ access ] => ' . $access . ' -> ' . $value . '<br />';
                }
            }
        }
        else
            $string .= "[ ACL ] => NULL<br />";
        return $string;
    }

}

?>
