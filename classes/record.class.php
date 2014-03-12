<?php

/* ! \par		Info Generali:
 *  @author		Stefano Muscas
 *  @version		0.3
 *  @since		2013
 *  @copyright		Jamyourself.com 2013
 *  \par		Info Classe:
 *  \brief		Record 
 *  \details		Classe dedicata ad un album di brani musicali, puo' essere istanziata solo da Jammer
 *  \par		Commenti:
 *  @warning
 *  @bug
 *  @todo
 *
 *  <a href="https://github.com/lucagianneschi/jamyourself/wiki/Definizione-Classe:-Record">Descrizione della classe</a>
 *  <a href="https://github.com/lucagianneschi/jamyourself/wiki/API:-Record">API</a>
 */

class Record {

    private $id;
    private $createdat;
    private $updatedat;
    private $active;
    private $buylink;
    private $city;
    private $commentcounter;
    private $counter;
    private $cover;
    private $description;
    private $duration;
    private $fromuser;
    private $genre;
    private $label;
    private $latitude;
    private $longitude;
    private $lovecounter;
    private $reviewCounter;
    private $sharecounter;
    private $songcounter;
    private $thumbnail;
    private $title;
    private $tracklist;
    private $year;

    /**
     * \fn	int getId()
     * \brief	Return the id value
     * @return	int
     */
    public function getId() {
	return $this->id;
    }

    /**
     * \fn	DateTime getCreatedat()
     * \brief	Return the Record creation date
     * @return	DateTime
     */
    public function getCreatedat() {
	return $this->createdat;
    }

    /**
     * \fn	DateTime getUpdatedat()
     * \brief	Return the Record modification date
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
     * \fn	string getBuylink()
     * \brief	Return the buylink value
     * @return	string
     */
    public function getBuylink() {
	return $this->buylink;
    }

    /**
     * \fn	string getCity
     * \brief	Return the city value
     * @return	string
     */
    public function getCity() {
	return $this->city;
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
     * \fn	string getCover()
     * \brief	Return the cover (path file) value
     * @return	string
     */
    public function getCover() {
	return $this->cover;
    }

    /**
     * \fn	string getDescription()
     * \brief	Return the description value
     * @return	string
     */
    public function getDescription() {
	return $this->description;
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
     * \fn	getGenre()
     * \brief	Return the genre value 
     * @return	int
     */
    public function getGenre() {
	return $this->genre;
    }

    /**
     * \fn	string getLabel()
     * \brief	Return the label value
     * @return	string
     */
    public function getLabel() {
	return $this->label;
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
     * \brief	Return the loveCounter value, number of users who love the record
     * @return	int
     */
    public function getLovecounter() {
	return $this->lovecounter;
    }

    /**
     * \fn	int getReviewcounter()
     * \brief	Return the review counter value (number of review)
     * @return	int
     */
    public function getReviewcounter() {
	return $this->reviewCounter;
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
     * \fn	int getSongcounter()
     * \brief	Return the song counter value (number of songs)
     * @return	int
     */
    public function getSongcounter() {
	return $this->songcounter;
    }

    /**
     * \fn	string getThumbnail()
     * \brief	Return the thumbnail (path file) value
     * @return	string
     */
    public function getThumbnail() {
	return $this->thumbnail;
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
     * \fn	getTracklist()
     * \brief	Return the tracklist value,array of Ids of song
     * @return	int
     */
    public function getTracklist() {
	return $this->tracklist;
    }

    /**
     * \fn	string getYear()
     * \brief	Return the year value
     * @return	string
     */
    public function getYear() {
	return $this->year;
    }

    /**
     * \fn	void setId($id)
     * \brief	Sets the id value
     * @param	int
     */
    public function setId($id) {
	$this->id = $id;
    }

    /**
     * \fn	void setCreatedat($createdat)
     * \brief	Sets the Song creation date
     * @param	DateTime
     */
    public function setCreatedat($createdat) {
	$this->createdat = $createdat;
    }

    /**
     * \fn	void setUpdatedat($updatedat)
     * \brief	Sets the Song modification date
     * @param	DateTime
     */
    public function setUpdatedat($updatedat) {
	$this->updatedat = $updatedat;
    }

    /**
     * \fn	void setActive($active)
     * \brief	Sets the active  value
     * @param	BOOL
     */
    public function setActive($active) {
	$this->active = $active;
    }

    /**
     * \fn	void setbuylink($buylink)
     * \brief	Sets the buylink value
     * @param	string
     */
    public function setBuylink($buylink) {
	$this->buylink = $buylink;
    }

    /**
     * \fn	setCity($city)
     * \brief	Sets the city value
     * @param	string
     */
    public function setCity($city) {
	$this->city = $city;
    }

    /**
     * \fn	void setCommentcounter($commentcounter)
     * \brief	Sets the commnetCounter value
     * @param	int
     */
    public function setCommentcounter($commentcounter) {
	$this->commentcounter = $commentcounter;
    }

    /**
     * \fn	void setCounter($counter)
     * \brief	Sets the counter  value
     * @param	int
     */
    public function setCounter($counter) {
	$this->counter = $counter;
    }

    /**
     * \fn	void setCover($cover))
     * \brief	Sets the cover value
     * @param	string
     */
    public function setCover($cover) {
	$this->cover = $cover;
    }

    /**
     * \fn	void setDescription($description)
     * \brief	Sets the description value
     * @param	string
     */
    public function setDescription($description) {
	$this->description = $description;
    }

    /**
     * \fn	void setDuration($duration)
     * \brief	Sets the duration  value
     * @param	int
     */
    public function setDuration($duration) {
	$this->duration = $duration;
    }

    /**
     * \fn	void setFromuser($fromuser)
     * \brief	Sets the fromUser id  value
     * @param	int
     */
    public function setFromuser($fromuser) {
	$this->fromuser = $fromuser;
    }

    /**
     * \fn	void setGenre($genre) 
     * \brief	Sets the genre value
     * @param	int
     */
    public function setGenre($genre) {
	$this->genre = $genre;
    }

    /**
     * \fn	void setLabel($label) 
     * \brief	Sets the label value
     * @param	string
     */
    public function setLabel($label) {
	$this->label = $label;
    }

    /**
     * \fn	void setLatitude($latitude)
     * \brief	Sets the latitude value
     * @param	$longitude
     */
    public function setLatitude($latitude) {
	$this->latitude = $latitude;
    }

    /**
     * \fn	void setLongitude($longitude)
     * \brief	Sets the longitude value
     * @param	$longitude
     */
    public function setLongitude($longitude) {
	$this->longitude = $longitude;
    }

    /**
     * \fn	void setLovecounter($lovecounter)
     * \brief	Sets the LoveCounter  value
     * @param	int
     */
    public function setLovecounter($lovecounter) {
	$this->lovecounter = $lovecounter;
    }

    /**
     * \fn	void setReviewCounter($reviewCounter)
     * \brief	Sets the reviewCounter value
     * @param	int
     */
    public function setReviewCounter($reviewCounter) {
	$this->reviewCounter = $reviewCounter;
    }

    /**
     * \fn	void setCounter($sharecounter)
     * \brief	Sets the sharecounter value
     * @param	int
     */
    public function setSharecounter($sharecounter) {
	$this->sharecounter = $sharecounter;
    }

    /**
     * \fn	void  setSongcounter($songcounter)
     * \brief	Sets the songcounter value
     * @param	int
     */
    public function setSongcounter($songcounter) {
	$this->songcounter = $songcounter;
    }

    /**
     * \fn	void setThumbnail($thumbnail) 
     * \brief	Sets the thumbnail (path file) value
     * @param	string
     */
    public function setThumbnail($thumbnail) {
	$this->thumbnail = $thumbnail;
    }

    /**
     * \fn	void setTitle($title) 
     * \brief	Sets the title value
     * @param	string
     */
    public function setTitle($title) {
	$this->title = $title;
    }

    /**
     * \fn	void setTracklist($tracklist)
     * \brief	Sets the tracklist  value (list of id)
     * @param	array
     */
    public function setTracklist($tracklist) {
	$this->tracklist = $tracklist;
    }

    /**
     * \fn	void setYear($year) 
     * \brief	Sets the year value
     * @param	string
     */
    public function setYear($year) {
	$this->year = $year;
    }

    /**
     * \fn	string __toString()
     * \brief	Return a printable string representing the Record object
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
	$string .= '[buylink] => ' . $this->getBuylink() . '<br/>';
	$string .= '[city] => ' . $this->getCity() . '<br />';
	$string .= '[commentcounter] => ' . $this->getCommentcounter() . '<br />';
	$string .= '[counter] => ' . $this->getCounter() . '<br />';
	$string .= '[cover] => ' . $this->getCover() . '<br/>';
	$string .= '[description] => ' . $this->getDescription() . '<br/>';
	$string .= '[duration] => ' . $this->getDuration() . '<br/>';
	$string .= '[fromuser] => ' . $this->getFromuser() . '<br />';
	foreach ($this->getGenre() as $genre) {
	    $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	    $string .= '[genre] => ' . $genre . '<br />';
	}
	$string .= '[label] .= > ' . $this->getLabel() . '<br/>';
	$string .= '[latitude] => ' . $this->getLatitude() . '<br />';
	$string .= '[longitude] => ' . $this->getLongitude() . '<br />';
	$string .= '[lovecounter] .= > ' . $this->getLovecounter() . '<br/>';
	$string .= '[reviewCounter] => ' . $this->getReviewcounter() . '<br />';
	$string .= '[sharecounter] => ' . $this->getSharecounter() . '<br />';
	$string .= '[songcounter] => ' . $this->getSongcounter() . '<br />';
	$string .= '[thumbnailCover] .= > ' . $this->getThumbnail() . '<br/>';
	$string .= '[title] .= > ' . $this->getTitle() . '<br/>';
	$string .= '[tracklist] => ' . $this->getTracklist() . '<br />';
	$string .= '[year] .= > ' . $this->getYear() . '<br/>';
	return $string;
    }

}

?>
