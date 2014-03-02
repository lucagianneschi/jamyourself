<?php

/* ! \par		Info Generali:
 *  \author		Maria Laura Fresu
 *  \version		0.3
 *  \date		2013
 *  \copyright		Jamyourself.com 2013
 *  \par		Info Classe:
 *  \brief		Album
 *  \details		Classe raccoglitore per immagini
 *  \par		Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="https://github.com/lucagianneschi/jamyourself/wiki/Definizione-Classe:-Album">Descrizione della classe</a>
 *  <a href="https://github.com/lucagianneschi/jamyourself/wiki/API:-Album">API</a>
 */

class Album {

    private $id;
    private $createdat;
    private $updatedat;
    private $active;
    private $commentcounter;
    private $counter;
    private $cover;
    private $description;
    private $fromuser;
    private $imagecounter;
    private $images;
    private $latitude;
    private $longitude;
    private $lovecounter;
    private $sharecounter;
    private $tag;
    private $thumbnail;
    private $title;

    /**
     * \fn	getId()
     * \brief	Return the id value
     * \return	string
     */
    public function getId() {
	return $this->id;
    }

    /**
     * \fn	DateTime getCreatedat()
     * \brief	Return the Album creation date
     * \return	DateTime
     */
    public function getCreatedat() {
	return $this->createdat;
    }

    /**
     * \fn	DateTime getUpdatedat()
     * \brief	Return the Album modification date
     * \return	DateTime
     */
    public function getUpdatedat() {
	return $this->updatedat;
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
     * \fn	getCommentcounter()
     * \brief	Return the comment counter value (number of comments)
     * \return	int
     */
    public function getCommentcounter() {
	return $this->commentcounter;
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
     * \fn      getCover()
     * \brief	Return the cover (path file) value
     * \return	string
     */
    public function getCover() {
	return $this->cover;
    }

    /**
     * \fn	getDescription()
     * \brief	Return the description value
     * \return	string
     */
    public function getDescription() {
	return $this->description;
    }

    /**
     * \fn	getFromuser()
     * \brief	Return the id value for the fromUser
     * \return	int
     */
    public function getFromuser() {
	return $this->fromuser;
    }

    /**
     * \fn	int getImagecounter()
     * \brief	Return the image counter value (number of images)
     * \return	int
     */
    public function getImagecounter() {
	return $this->imagecounter;
    }

    /**
     * \fn	int getImages()
     * \brief	Return the array of images
     * \return	int
     */
    public function getImages() {
	return $this->images;
    }

    /**
     * \fn	getLatitude()
     * \brief	Return the latitude value
     * \return	long
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
     * \fn	getLovecounter()
     * \brief	Return the int value of loveCounter, counting the love action on the album
     * \return	int
     */
    public function getLovecounter() {
	return $this->lovecounter;
    }

    /**
     * \fn	getSharecounter()
     * \brief	Return the counter for sharing action
     * \return	int
     */
    public function getSharecounter() {
	return $this->sharecounter;
    }

    /**
     * \fn	getTag()
     * \brief	Return the tags value, array of string to categorize the album
     * \return	int
     */
    public function getTag() {
	return $this->tag;
    }

    /**
     * \fn	getThumbnail()
     * \brief	Return the thumbnail value
     * \return	string
     */
    public function getThumbnail() {
	return $this->thumbnail;
    }

    /**
     * \fn	getTitle()
     * \brief	Return the title value
     * \return	string
     */
    public function getTitle() {
	return $this->title;
    }

    /**
     * \fn	void setId($id)
     * \brief	Sets the id value
     * \param	string
     */
    public function setId($id) {
	$this->id = $id;
    }

    /**
     * \fn	void setCreatedat($createdat)
     * \brief	Sets the Album creation date
     * \param	DateTime
     */
    public function setCreatedat($createdat) {
	$this->createdat = $createdat;
    }

    /**
     * \fn		void setUpdatedat($updatedat)
     * \brief	Sets the Album modification date
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
     * \fn	void setCommentcounter($commentcounter)
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
     * \fn	void setCover($cover)
     * \brief	Sets the cover value
     * \param	string
     */
    public function setCover($cover) {
	$this->cover = $cover;
    }

    /**
     * \fn	void setDescription($description)
     * \brief	Sets the description value
     * \param	string
     */
    public function setDescription($description) {
	$this->description = $description;
    }

    /**
     * \fn	setFromuser($fromuser))
     * \brief	Sets the fromUser value, int id
     * \param	int
     */
    public function setFromuser($fromuser) {
	$this->fromuser = $fromuser;
    }

    /**
     * \fn	void setImagecounter($imagecounter)
     * \brief	Sets the imagetCounter value
     * \param	int
     */
    public function setImagecounter($imagecounter) {
	$this->imagecounter = $imagecounter;
    }

    /**
     * \fn	void setImages($images)
     * \brief	Sets the images value
     * \param	array
     */
    public function setImages($images) {
	$this->images = $images;
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
     * \fn	void setCounter($sharecounter)
     * \brief	Sets the sharecounter value
     * \param	int
     */
    public function setSharecounter($sharecounter) {
	$this->sharecounter = $sharecounter;
    }

    /**
     * \fn	void setTag($tag)
     * \brief	Sets the tags value,array of strings
     * \param	array
     */
    public function setTag($tag) {
	$this->tag = $tag;
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
     * \fn	void setThumbnail($thumbnail)
     * \brief	Sets the thumbnail value
     * \param	string
     */
    public function setThumbnail($thumbnail) {
	$this->thumbnail = $thumbnail;
    }

    /**
     * \fn		string __toString()
     * \brief	Return a printable string representing the Album object
     * \return	string
     */
    public function __toString() {
	$string = '';
	$string .= '[id] => ' . $this->getId() . '<br />';
	$string .= '[createdat] => ' . $this->getCreatedat()->format('d-m-Y H:i:s') . '<br />';
	$string .= '[updatedat] => ' . $this->getUpdatedat()->format('d-m-Y H:i:s') . '<br />';
	$string .= '[active] => ' . $this->getActive() . '<br />';
	$string .= '[commentcounter] => ' . $this->getCommentcounter() . '<br />';
	$string .= '[counter] => ' . $this->getCounter() . '<br />';
	$string .= '[cover] => ' . $this->getCover() . '<br />';
	$string .= '[description] => ' . $this->getDescription() . '<br />';
	$string .= '[fromuser] => ' . $this->getFromuser() . '<br />';
	$string .= '[imagecounter] => ' . $this->getImagecounter() . '<br />';
	$string .= '[images] => ' . $this->getImages() . '<br />';
	$string .= '[latitude] => ' . $this->getLatitude() . '<br />';
	$string .= '[longitude] => ' . $this->getLongitude() . '<br />';
	$string .= '[lovecounter] => ' . $this->getLovecounter() . '<br />';
	$string .= '[sharecounter] => ' . $this->getSharecounter() . '<br />';
	foreach ($this->getTag() as $tag) {
	    $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	    $string .= '[tag] => ' . $tag . '<br />';
	}
	$string .= '[thumbnail] => ' . $this->getThumbnail() . '<br />';
	$string .= '[title] => ' . $this->getTitle() . '<br />';
	return $string;
    }

}

?>