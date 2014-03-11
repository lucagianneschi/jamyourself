<?php

/* ! \par		Info Generali:
 *  @author		Daniele Caldelli, Stefano Muscas
 *  @version		0.3
 *  @since		2013
 *  @copyright		Jamyourself.com 2013
 *  \par		Info Classe:
 *  \brief		Comment 
 *  \details		Classe dedicata a POST, REVIEW, COMMENT & MESSAGGI 
 *  \par		Commenti:
 *  @warning
 *  @bug
 *  @todo
 * 
 *  <a href="https://github.com/lucagianneschi/jamyourself/wiki/Definizione-Classe:-Comment">Descrizione della classe</a>
 *  <a href="https://github.com/lucagianneschi/jamyourself/wiki/API:-Comment">API</a>
 */

class Comment {

    private $id;
    private $createdat;
    private $updatedat;
    private $active;
    private $album;
    private $comment;
    private $commentcounter;
    private $counter;
    private $event;
    private $fromuser;
    private $image;
    private $latitude;
    private $longitude;
    private $lovecounter;
    private $record;
    private $sharecounter;
    private $song;
    private $tag;
    private $title;
    private $text;
    private $touser;
    private $type;
    private $video;
    private $vote;

    /**
     * \fn	getId()
     * \brief	Return the id value
     * @return	int
     */
    public function getId() {
	return $this->id;
    }

    /**
     * \fn	DateTime getCreatedat()
     * \brief	Return the Comment creation date
     * @return	DateTime
     */
    public function getCreatedat() {
	return $this->createdat;
    }

    /**
     * \fn	DateTime getUpdatedat()
     * \brief	Return the Comment modification date
     * @return	DateTime
     */
    public function getUpdatedat() {
	return $this->updatedat;
    }

    /**
     * \fn	BOOL getActive()
     * \brief	Return the active valure
     * @return	BOOL
     */
    public function getActive() {
	return $this->active;
    }

    /**
     * \fn	getAlbum()
     * \brief	Return the int value id to album
     * @return	int
     */
    public function getAlbum() {
	return $this->album;
    }

    /**
     * \fn	getComment()
     * \brief	Return the related comment id
     * @return	int
     */
    public function getComment() {
	return $this->comment;
    }

    /**
     * \fn	int getCommentcounter()
     * \brief	Return the comment counter value (number of comments)
     * @return	int
     */
    public function getCommentcounter() {
	return $this->commentcounter;
    }

    /**
     * \fn	int getCounter()
     * \brief	Return the counter value
     * @return	int
     */
    public function getCounter() {
	return $this->counter;
    }

    /**
     * \fn	getEvent()
     * \brief	Return the related event id
     * @return	int
     */
    public function getEvent() {
	return $this->event;
    }

    /**
     * \fn	getFromuser()
     * \brief	Return the id value for the fromUser
     * @return	int
     */
    public function getFromuser() {
	return $this->fromuser;
    }

    /**
     * \fn	getImage()
     * \brief	Return the related image id
     * @return	int
     */
    public function getImage() {
	return $this->image;
    }

    /**
     * \fn	getLatitude()
     * \brief	Return the latitude value
     * @return	latitude
     */
    public function getLatitude() {
	return $this->latitude;
    }

    /**
     * \fn	getLongitude()
     * \brief	Return the longitude value
     * @return	long
     */
    public function getLongitude() {
	return $this->longitude;
    }

    /**
     * \fn	int getLovecounter()
     * \brief	Return the int value of loveCounter, counting the love action on the comment
     * @return	int
     */
    public function getLovecounter() {
	return $this->lovecounter;
    }

    /**
     * \fn	getRecord()
     * \brief	Return the record value id
     * @return	string
     */
    public function getRecord() {
	return $this->record;
    }

    /**
     * \fn	int getSharecounter()
     * \brief	Return the counter for sharing action
     * @return	int
     */
    public function getSharecounter() {
	return $this->sharecounter;
    }

    /**
     * \fn	getSong()
     * \brief	Return the song value id
     * @return	int
     */
    public function getSong() {
	return $this->song;
    }

    /**
     * \fn	getTag()
     * \brief	Return the tags value
     * @return	int
     */
    public function getTag() {
	return $this->tag;
    }

    /**
     * \fn	getText()
     * \brief	Return the text value
     * @return	string
     */
    public function getText() {
	return $this->text;
    }

    /**
     * \fn	getTitle()
     * \brief	Return the title value, NULL for any type but Review R
     * @return	array
     */
    public function getTitle() {
	return $this->title;
    }

    /**
     * \fn	getTouser()
     * \brief	Return the toUser value, id
     * @return	int
     */
    public function getTouser() {
	return $this->touser;
    }

    /**
     * \fn	getType()
     * \brief	Return the type value
     * @return	string
     */
    public function getType() {
	return $this->type;
    }

    /**
     * \fn	getVideo()
     * \brief	Return the video value id
     * @return	string
     */
    public function getVideo() {
	return $this->video;
    }

    /**
     * \fn	getVote()
     * \brief	Return the vote, from 1 to 5
     * @return	int
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
     * \fn		void setCreatedat($createdat)
     * \brief	Sets the Comment creation date
     * \param	DateTime
     */
    public function setCreatedat($createdat) {
	$this->createdat = $createdat;
    }

    /**
     * \fn		void setUpdatedat($updatedat)
     * \brief	Sets the Comment modification date
     * \param	DateTime
     */
    public function setUpdatedat($updatedat) {
	$this->updatedat = $updatedat;
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
     * \fn		void setCommentcounter($commentcounter)
     * \brief	Sets the commnetCounter value
     * \param	int
     */
    public function setCommentcounter($commentcounter) {
	$this->commentcounter = $commentcounter;
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
     * \fn	void setFromuser($fromuser))
     * \brief	Sets the fromUser value
     * \param	int
     */
    public function setFromuser($fromuser) {
	$this->fromuser = $fromuser;
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
     * \fn	void setLovecounter($lovecounter)
     * \brief	Sets the loveCounter value
     * \param	int
     */
    public function setLovecounter($lovecounter) {
	$this->lovecounter = $lovecounter;
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
     * \fn		void setCounter($sharecounter)
     * \brief	Sets the sharecounter value
     * \param	int
     */
    public function setSharecounter($sharecounter) {
	$this->sharecounter = $sharecounter;
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
	$this->tag = $tag;
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
     * \fn	void setTouser($touser)
     * \brief	Sets the toUser id value
     * \param	int
     */
    public function setTouser($touser) {
	$this->touser = $touser;
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
     * @return	string
     */
    public function __toString() {
	$string = '';
	$string .= '[id] => ' . $this->getId() . '<br />';
	$createdAt = new DateTime($this->getCreatedat());
	$string .= '[createdat] => ' . $createdAt->format('d-m-Y H:i:s') . '<br />';
	$updatedAt = new DateTime($this->getUpdatedat());
	$string .= '[updatedat] => ' . $updatedAt->format('d-m-Y H:i:s') . '<br />';
	$string .= '[active] => ' . $this->getActive() . '<br />';
	$string .= '[album] => ' . $this->getAlbum() . '<br />';
	$string .= '[comment] => ' . $this->getComment() . '<br />';
	$string .= '[commentcounter] => ' . $this->getCommentcounter() . '<br />';
	$string .= '[counter] => ' . $this->getCounter() . '<br />';
	$string .= '[event] => ' . $this->getEvent() . '<br />';
	$string .= '[fromuser] => ' . $this->getFromuser() . '<br />';
	$string .= '[image] => ' . $this->getImage() . '<br />';
	$string .= '[latitude] => ' . $this->getLatitude() . '<br />';
	$string .= '[longitude] => ' . $this->getLongitude() . '<br />';
	$string .= '[lovecounter] => ' . $this->getLovecounter() . '<br />';
	$string .= '[record] => ' . $this->getRecord() . '<br />';
	$string .= '[sharecounter] => ' . $this->getSharecounter() . '<br />';
	$string .= '[song] => ' . $this->getSong() . '<br />';
	foreach ($this->getTag() as $tag) {
	    $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	    $string .= '[tag] => ' . $tag . '<br />';
	}
	$string .= '[text] => ' . $this->getText() . '<br />';
	$string .= '[title] => ' . $this->getTitle() . '<br />';
	$string .= '[touser] => ' . $this->getTouser() . '<br />';
	$string .= '[type] => ' . $this->getType() . '<br />';
	$string .= '[video] => ' . $this->getVideo() . '<br />';
	$string .= '[vote] => ' . $this->getVote() . '<br />';
	return $string;
    }

}

?>
