<?php

/* ! \par		Info Generali:
 *  \author		Maria Laura Fresu
 *  \version		0.3
 *  \date		2013
 *  \copyright		Jamyourself.com 2013
 *  \par		Info Classe:
 *  \brief		Image
 *  \details		Classe per la singola immagine caricata dall'utente
 *  \par		Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="https://github.com/lucagianneschi/jamyourself/wiki/Definizione-Classe:-Image">Descrizione della classe</a>
 *  <a href="https://github.com/lucagianneschi/jamyourself/wiki/API:-Image">API</a>
 */

class Image {

    private $id;
    private $createdat;
    private $updatedat;
    private $active;
    private $album;
    private $commentcounter;
    private $counter;
    private $description;
    private $fromuser;
    private $latitude;
    private $longitude;
    private $lovecounter;
    private $path;
    private $sharecounter;
    private $tag;
    private $thumbnail;

    /**
     * \fn	int getId()
     * \brief	Return the id value
     * \return	int
     */
    public function getId() {
	return $this->id;
    }

    /**
     * \fn	DateTime getCreatedat()
     * \brief	Return the Image creation date
     * \return	DateTime
     */
    public function getCreatedat() {
	return $this->createdat;
    }

    /**
     * \fn	DateTime getUpdatedat()
     * \brief	Return the Image modification date
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
     * \fn	int getAlbum()
     * \brief	Return the album value
     * \return	int
     */
    public function getAlbum() {
	return $this->album;
    }

    /**
     * \fn	int getCommentcounter()
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
     * \fn	string getDescription()
     * \brief	Return the description value
     * \return	string
     */
    public function getDescription() {
	return $this->description;
    }

    /**
     * \fn	int getFromuser()
     * \brief	Return the id value for the fromUser
     * \return	int
     */
    public function getFromuser() {
	return $this->fromuser;
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
     * \fn	int getLovecounter()
     * \brief	Return the int value of loveCounter, counting the love action on the image
     * \return	int
     */
    public function getLovecounter() {
	return $this->lovecounter;
    }

    /**
     * \fn	string getPath()
     * \brief	Return the path value
     * \return	string
     */
    public function getPath() {
	return $this->path;
    }

    /**
     * \fn	int getSharecounter()
     * \brief	Return the counter for sharing action
     * \return	int
     */
    public function getSharecounter() {
	return $this->sharecounter;
    }

    /**
     * \fn	getTag()
     * \brief	Return the tags value
     * \return	int
     */
    public function getTag() {
	return $this->tag;
    }

    /**
     * \fn	string getThumbnail()
     * \brief	Return the thumbnail value, path for the thumnail
     * \return	string
     */
    public function getThumbnail() {
	return $this->thumbnail;
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
     * \brief	Sets the Image creation date
     * \param	DateTime
     */
    public function setCreatedat($createdat) {
	$this->createdat = $createdat;
    }

    /**
     * \fn	void setUpdatedat($updatedat)
     * \brief	Sets the Image modification date
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
     * \fn	void setCommentcounter($commentcounter)
     * \brief	Sets the commentCounter value
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
     * \fn	void setDescription($description)
     * \brief	Sets the description value
     * \param	string
     */
    public function setDescription($description) {
	$this->description = $description;
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
     * \fn	void setpath($pPath)
     * \brief	Sets the path value
     * \param	string
     */
    public function setPath($path) {
	$this->path = $path;
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
     * \brief	Sets the tags value
     * \param	int
     */
    public function setTag($tag) {
	$this->tag = $tag;
    }

    /**
     * \fn	void setThumbnail($thumbnail)
     * \brief	Sets the thumbnail value,string fot the thumbnail
     * \param	array
     */
    public function setThumbnail($thumbnail) {
	$this->thumbnail = $thumbnail;
    }

    /**
     * \fn	string __toString()
     * \brief	Return a printable string representing the Image object
     * \return	string
     */
    public function __toString() {
	$string = '';
	$string .= '[id] => ' . $this->getId() . '<br />';
	$string .= '[createdat] => ' . $this->getCreatedat()->format('d-m-Y H:i:s') . '<br />';
	$string .= '[updatedat] => ' . $this->getUpdatedat()->format('d-m-Y H:i:s') . '<br />';
	$string .= '[active] => ' . $this->getActive() . '<br />';
	$string .= '[album] => ' . $this->getAlbum() . '<br />';
	$string .= '[commentcounter] => ' . $this->getCommentcounter() . '<br />';
	$string .= '[counter] => ' . $this->getCounter() . '<br />';
	$string .= '[description] => ' . $this->getDescription() . '<br />';
	$string .= '[fromuser] => ' . $this->getFromuser() . '<br />';
	$string .= '[latitude] => ' . $this->getLatitude() . '<br />';
	$string .= '[longitude] => ' . $this->getLongitude() . '<br />';
	$string .= '[lovecounter] => ' . $this->getLovecounter() . '<br />';
	$string .= '[path] => ' . $this->getPath() . '<br />';
	$string .= '[sharecounter] => ' . $this->getSharecounter() . '<br />';
	$string .= '[tags] => ' . $this->getTag() . '<br />';
	$string .= '[thumbnail] => ' . $this->getThumbnail() . '<br />';
	return $string;
    }

}

?>