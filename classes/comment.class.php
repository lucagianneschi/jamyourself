<?php

/* ! \par		Info Generali:
 *  \author		Daniele Caldelli, Stefano Muscas
 *  \version		0.3
 *  \date		2013
 *  \copyright		Jamyourself.com 2013
 *  \par		Info Classe:
 *  \brief		Comment 
 *  \details		Classe dedicata a POST, REVIEW, COMMENT & MESSAGGI 
 *  \par		Commenti:
 *  \warning
 *  \bug
 *  \todo
 * 
 *  <a href="https://github.com/lucagianneschi/jamyourself/wiki/Definizione-Classe:-Comment">Descrizione della classe</a>
 *  <a href="https://github.com/lucagianneschi/jamyourself/wiki/API:-Comment">API</a>
 */

class Comment {

    private $id;
    private $createdAt;
    private $updatedAt;
    private $active;
    private $album;
    private $comment;
    private $commentCounter;
    private $counter;
    private $event;
    private $fromUser;
    private $image;
    private $latitude;
    private $longitude;
    private $loveCounter;
    private $record;
    private $shareCounter;
    private $song;
    private $tag;
    private $title;
    private $text;
    private $toUser;
    private $type;
    private $video;
    private $vote;

    /**
     * \fn	getId()
     * \brief	Return the id value
     * \return	int
     */
    public function getId() {
	return $this->id;
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
     * \fn	BOOL getActive()
     * \brief	Return the active valure
     * \return	BOOL
     */
    public function getActive() {
	return $this->active;
    }

    /**
     * \fn	getAlbum()
     * \brief	Return the int value id to album
     * \return	int
     */
    public function getAlbum() {
	return $this->album;
    }

    /**
     * \fn	getComment()
     * \brief	Return the related comment id
     * \return	int
     */
    public function getComment() {
	return $this->comment;
    }

    /**
     * \fn	int getCommentCounter()
     * \brief	Return the comment counter value (number of comments)
     * \return	int
     */
    public function getCommentCounter() {
	return $this->commentCounter;
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
     * \fn	getEvent()
     * \brief	Return the related event id
     * \return	int
     */
    public function getEvent() {
	return $this->event;
    }

    /**
     * \fn	getFromUser()
     * \brief	Return the id value for the fromUser
     * \return	int
     */
    public function getFromUser() {
	return $this->fromUser;
    }

    /**
     * \fn	getImage()
     * \brief	Return the related image id
     * \return	int
     */
    public function getImage() {
	return $this->image;
    }

    /**
     * \fn	getLatitude()
     * \brief	Return the latitude value
     * \return	latitude
     */
    public function getLatitude() {
	return $this->latitude;
    }

    /**
     * \fn	getLongitude()
     * \brief	Return the longitude value
     * \return	long
     */
    public function getLongitude() {
	return $this->longitude;
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
     * \fn	getRecord()
     * \brief	Return the record value id
     * \return	string
     */
    public function getRecord() {
	return $this->record;
    }

    /**
     * \fn	int getShareCounter()
     * \brief	Return the counter for sharing action
     * \return	int
     */
    public function getShareCounter() {
	return $this->shareCounter;
    }

    /**
     * \fn	getSong()
     * \brief	Return the song value id
     * \return	int
     */
    public function getSong() {
	return $this->song;
    }

    /**
     * \fn	getTag()
     * \brief	Return the tags value
     * \return	int
     */
    public function getTag() {
	return $this->tags;
    }

    /**
     * \fn	getText()
     * \brief	Return the text value
     * \return	string
     */
    public function getText() {
	return $this->text;
    }

    /**
     * \fn	getTitle()
     * \brief	Return the title value, NULL for any type but Review R
     * \return	array
     */
    public function getTitle() {
	return $this->title;
    }

    /**
     * \fn	getToUser()
     * \brief	Return the toUser value, id
     * \return	int
     */
    public function getToUser() {
	return $this->toUser;
    }

    /**
     * \fn	getType()
     * \brief	Return the type value
     * \return	string
     */
    public function getType() {
	return $this->type;
    }

    /**
     * \fn	getVideo()
     * \brief	Return the video value id
     * \return	string
     */
    public function getVideo() {
	return $this->video;
    }

    /**
     * \fn	getVote()
     * \brief	Return the vote, from 1 to 5
     * \return	int
     */
    public function getVote() {
	return $this->vote;
    }

    /**
     * \fn	void setId($id)
     * \brief	Sets the id value
     * \param	int
     */
    public function setId($id) {
	$this->id = $id;
    }

    /**
     * \fn		void setCreatedAt($createdAt)
     * \brief	Sets the Comment creation date
     * \param	DateTime
     */
    public function setCreatedAt($createdAt) {
	$this->createdAt = $createdAt;
    }

    /**
     * \fn		void setUpdatedAt($updatedAt)
     * \brief	Sets the Comment modification date
     * \param	DateTime
     */
    public function setUpdatedAt($updatedAt) {
	$this->updatedAt = $updatedAt;
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
     * \param	int
     */
    public function setAlbum($album) {
	$this->album = $album;
    }

    /**
     * \fn	void setComment($comment)
     * \brief	Sets the comment value
     * \param	int
     */
    public function setComment($comment) {
	$this->comment = $comment;
    }

    /**
     * \fn		void setCommentCounter($commentCounter)
     * \brief	Sets the commnetCounter value
     * \param	int
     */
    public function setCommentCounter($commentCounter) {
	$this->commentCounter = $commentCounter;
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
     * \brief	Sets the event id value
     * \param	int
     */
    public function setEvent($event) {
	$this->event = $event;
    }

    /**
     * \fn	void setFromUser($fromUser))
     * \brief	Sets the fromUser value,pointer to ParseUser
     * \param	int
     */
    public function setFromUser($fromUser) {
	$this->fromUser = $fromUser;
    }

    /**
     * \fn	void setImage($image)
     * \brief	Sets the image id value
     * \param	int
     */
    public function setImage($image) {
	$this->image = $image;
    }

    /**
     * \fn	void setLatitude($latitude)
     * \brief	Sets the latitude value
     * \param	$longitude
     */
    public function setLatitude($latitude) {
	$this->latitude = $latitude;
    }

    /**
     * \fn	void setLongitude($longitude)
     * \brief	Sets the longitude value
     * \param	$longitude
     */
    public function setLongitude($longitude) {
	$this->longitude = $longitude;
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
     * \fn	void setRecord($record)
     * \brief	Sets the record id value
     * \param	int
     */
    public function setRecord($record) {
	$this->record = $record;
    }

    /**
     * \fn		void setCounter($shareCounter)
     * \brief	Sets the shareCounter value
     * \param	int
     */
    public function setShareCounter($shareCounter) {
	$this->shareCounter = $shareCounter;
    }

    /**
     * \fn	void setSong($song)
     * \brief	Sets the song id value
     * \param	int
     */
    public function setSong($song) {
	$this->song = $song;
    }

    /**
     * \fn	void setTag($tag)
     * \brief	Sets the tags value
     * \param	int
     */
    public function setTag($tag) {
	$this->tags = $tag;
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
     * \fn	void setTitle($title)
     * \brief	Sets the title
     * \param	string
     */
    public function setTitle($title) {
	$this->title = $title;
    }

    /**
     * \fn	void setToUser($toUser)
     * \brief	Sets the toUser id value
     * \param	int
     */
    public function setToUser($toUser) {
	$this->toUser = $toUser;
    }

    /**
     * \fn	void setType($type)
     * \brief	Sets the type id value
     * \param	string
     */
    public function setType($type) {
	$this->type = $type;
    }

    /**
     * \fn	void setVideo($video)
     * \brief	Sets the video id value
     * \param	int
     */
    public function setVideo($video) {
	$this->video = $video;
    }

    /**
     * \fn		void setVote($vote)
     * \brief	Sets the vote value
     * \param	int
     */
    public function setVote($vote) {
	$this->vote = $vote;
    }

    /**
     * \fn	string __toString()
     * \brief	Return a printable string representing the Comment object
     * \return	string
     */
    public function __toString() {
	$string = '';
	$string .= '[id] => ' . $this->getId() . '<br />';
	$string .= '[createdAt] => ' . $this->getCreatedAt()->format('d-m-Y H:i:s') . '<br />';
	$string .= '[updatedAt] => ' . $this->getUpdatedAt()->format('d-m-Y H:i:s') . '<br />';
	$string .= '[active] => ' . $this->getActive() . '<br />';
	$string .= '[album] => ' . $this->getAlbum() . '<br />';
	$string .= '[comment] => ' . $this->getComment() . '<br />';
	$string .= '[commentCounter] => ' . $this->getCommentCounter() . '<br />';
	$string .= '[counter] => ' . $this->getCounter() . '<br />';
	$string .= '[event] => ' . $this->getEvent() . '<br />';
	$string .= '[fromUser] => ' . $this->getFromUser() . '<br />';
	$string .= '[image] => ' . $this->getImage() . '<br />';
	$string .= '[latitude] => ' . $this->getLatitude() . '<br />';
	$string .= '[longitude] => ' . $this->getLongitude() . '<br />';
	$string .= '[loveCounter] => ' . $this->getLoveCounter() . '<br />';
	$string .= '[record] => ' . $this->getRecord() . '<br />';
	$string .= '[shareCounter] => ' . $this->getShareCounter() . '<br />';
	$string .= '[song] => ' . $this->getSong() . '<br />';
	$string .= '[tags] => ' . $this->getTag() . '<br />';
	$string .= '[text] => ' . $this->getText() . '<br />';
	$string .= '[title] => ' . $this->getTitle() . '<br />';
	$string .= '[toUser] => ' . $this->getToUser() . '<br />';
	$string .= '[type] => ' . $this->getType() . '<br />';
	$string .= '[video] => ' . $this->getVideo() . '<br />';
	$string .= '[vote] => ' . $this->getVote() . '<br />';
	return $string;
    }

}

?>