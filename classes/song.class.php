<?php

/* ! \par		Info Generali:
 *  @author		Stefano Muscas
 *  @version		0.3
 *  @since		2013
 *  @copyright		Jamyourself.com 2013
 *  \par		Info Classe:
 *  \brief		Song Class
 *  \details		Classe dedicata al singolo brano, puo' essere istanziata solo da Jammer
 *  \par		Commenti:
 *  @warning
 *  @bug
 *  @todo
 *
 *  <a href="https://github.com/lucagianneschi/jamyourself/wiki/Definizione-Classe:-Song">Descrizione della classe</a>
 *  <a href="https://github.com/lucagianneschi/jamyourself/wiki/API:-Song">API</a>
 */

class Song {

    private $id;
    private $createdat;
    private $updatedat;
    private $active;
    private $commentcounter;
    private $counter;
    private $duration;
    private $fromuser;
    private $genre;
    private $latitude;
    private $longitude;
    private $lovecounter;
    private $path;
    private $position;
    private $record;
    private $sharecounter;
    private $title;

    /**
     * \fn	int getId()
     * \brief	Return the id value
     * @return	string
     */
    public function getId() {
	return $this->id;
    }

    /**
     * \fn	DateTime getCreatedat()
     * \brief	Return the Song creation date
     * @return	DateTime
     */
    public function getCreatedat() {
	return $this->createdat;
    }

    /**
     * \fn	DateTime getUpdatedat()
     * \brief	Return the Song modification date
     * @return	DateTime
     */
    public function getUpdatedat() {
	return $this->updatedat;
    }

    /**
     * \fn	BOOL getId()
     * \brief	Return the active value
     * @return	BOOL
     */
    public function getActive() {
	return $this->active;
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
     * \fn	int getDuration()
     * \brief	Return the duration value in second
     * @return	int
     */
    public function getDuration() {
	return $this->duration;
    }

    /**
     * \fn	int getFromuser()
     * \brief	Return the id value for the fromUser
     * @return	int
     */
    public function getFromuser() {
	return $this->fromuser;
    }

    /**
     * \fn	string getGenre()
     * \brief	Return the genre value 
     * @return	string
     */
    public function getGenre() {
	return $this->genre;
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
     * \brief	Return the loveCounter value, number of users who love the song
     * @return	int
     */
    public function getLovecounter() {
	return $this->lovecounter;
    }

    /**
     * \fn	string getPath()
     * \brief	Return the path value
     * @return	string
     */
    public function getPath() {
	return $this->pathath;
    }

    /**
     * \fn	string getPosition()
     * \brief	Return the position value,number of the song in the tracklist of its record
     * @return	string
     */
    public function getPosition() {
	return $this->position;
    }

    /**
     * \fn	int getRecord()
     * \brief	Return the record value,string of the id of the related record
     * @return	int
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
     * \fn	string getTitle()
     * \brief	Return the title value
     * @return	string
     */
    public function getTitle() {
	return $this->title;
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
     * \fn	void setCreatedat($createdat)
     * \brief	Sets the Song creation date
     * \param	DateTime
     */
    public function setCreatedat($createdat) {
	$this->createdat = $createdat;
    }

    /**
     * \fn	void setUpdatedat($updatedat)
     * \brief	Sets the Song modification date
     * \param	DateTime
     */
    public function setUpdatedat($updatedat) {
	$this->updatedat = $updatedat;
    }

    /**
     * \fn	void setActive($active)
     * \brief	Sets the active  value
     * \param	BOOL
     */
    public function setActive($active) {
	$this->active = $active;
    }

    /**
     * \fn	void setCommentcounter($commentcounter)
     * \brief	Sets the commnetCounter value
     * \param	int
     */
    public function setCommentcounter($commentcounter) {
	$this->commentcounter = $commentcounter;
    }

    /**
     * \fn	void setCounter($counter)
     * \brief	Sets the counter  value
     * \param	int
     */
    public function setCounter($counter) {
	$this->counter = $counter;
    }

    /**
     * \fn	void setDuration($duration)
     * \brief	Sets the duration value
     * \param	int
     */
    public function setDuration($duration) {
	$this->duration = $duration;
    }

    /**
     * \fn	void setFromuser($fromuser)
     * \brief	Sets the fromUser id  value
     * \param	string
     */
    public function setFromuser($fromuser) {
	$this->fromuser = $fromuser;
    }

    /**
     * \fn	void setGenre($genre) 
     * \brief	Sets the genre value
     * \param	string
     */
    public function setGenre($genre) {
	$this->genre = $genre;
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
     * \brief	Sets the LoveCounter  value
     * \param	int
     */
    public function setLovecounter($lovecounter) {
	$this->lovecounter = $lovecounter;
    }

    /**
     * \fn	void setpath($pPath)
     * \brief	Sets the path value
     * \param	string
     */
    public function setPath($path) {
	$this->path = $path;
    }

    /**
     * \fn	setPosition($position)
     * \brief	Sets the position value
     * \param	string
     */
    public function setPosition($position) {
	$this->position = $position;
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
     * \fn	void setCounter($sharecounter)
     * \brief	Sets the sharecounter value
     * \param	int
     */
    public function setSharecounter($sharecounter) {
	$this->sharecounter = $sharecounter;
    }

    /**
     * \fn	void setTitle($title) 
     * \brief	Sets the title value
     * \param	string
     */
    public function setTitle($title) {
	$this->title = $title;
    }

    /**
     * \fn	string __toString()
     * \brief	Return a printable string representing the Song object
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
	$string .= '[commentcounter] => ' . $this->getCommentcounter() . '<br />';
	$string .= '[counter] => ' . $this->getCounter() . '<br />';
	$string .= '[duration] => ' . $this->getDuration() . '<br />';
	$string .= '[fromuser] => ' . $this->getFromuser() . '<br />';
	$string .= '[genre] => ' . $this->getGenre() . '<br />';
	$string .= '[latitude] => ' . $this->getLatitude() . '<br />';
	$string .= '[longitude] => ' . $this->getLongitude() . '<br />';
	$string .= '[lovecounter] => ' . $this->getLovecounter() . '<br />';
	$string .= '[path] => ' . $this->getPath() . '<br />';
	$string .= '[position] => ' . $this->getPosition() . '<br />';
	$string .= '[record] => ' . $this->getRecord() . '<br />';
	$string .= '[sharecounter] => ' . $this->getSharecounter() . '<br />';
	$string .= '[title] => ' . $this->getTitle() . '<br />';
	return $string;
    }

}

?>
