<?php

/* ! \par		Info Generali:
 *  @author		Stefano Muscas
 *  @version		0.3
 *  @since		2013
 *  @copyright		Jamyourself.com 2013
 *  \par		Info Classe:
 *  \brief		Video 
 *  \details		Classe che contiene i video presi da Vimeo e Youtube e segnalati dagli utenti 
 *  \par		Commenti:
 *  @warning
 *  @bug
 *  @todo
 *
 *  <a href="https://github.com/lucagianneschi/jamyourself/wiki/Definizione-Classe:-Video">Descrizione della classe</a>
 *  <a href="https://github.com/lucagianneschi/jamyourself/wiki/API:-Video">API</a>
 */

class Video {

    private $id;
    private $createdat;
    private $updatedat;
    private $active;
    private $author;
    private $counter;
    private $cover;
    private $description;
    private $duration;
    private $fromuser;
    private $lovecounter;
    private $tag;
    private $thumbnail;
    private $title;
    private $URL;

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
     * \brief	Return the Video creation date
     * @return	DateTime
     */
    public function getCreatedat() {
	return $this->createdat;
    }

    /**
     * \fn	DateTime getUpdatedat()
     * \brief	Return the Video modification date
     * @return	DateTime
     */
    public function getUpdatedat() {
	return $this->updatedat;
    }

    /**
     * \fn	boolean getActive()
     * \brief	Return the active value
     * @return	boolean
     */
    public function getActive() {
	return $this->active;
    }

    /**
     * \fn	string getAuthor()
     * \brief	Return the author value; author is the uploader on YouTube or Vimeo
     * @return	string
     */
    public function getAuthor() {
	return $this->author;
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
     * \fn	int getLovecounter()
     * \brief	Return the int value of loveCounter, counting the love action on the video
     * @return	int
     */
    public function getLovecounter() {
	return $this->lovecounter;
    }

    /**
     * \fn	int getTag()
     * \brief	Return the tags value, array of string to categorize the video
     * @return	int
     */
    public function getTag() {
	return $this->tag;
    }

    /**
     * \fn	string getThumbnail()
     * \brief	Return the thumbnail value, URL of the video cover image
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
     * \fn	string getURL()
     * \brief	Return the URL value
     * @return	string
     */
    public function getURL() {
	return $this->URL;
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
     * \brief	Sets the Video creation date
     * @param	DateTime
     */
    public function setCreatedat($createdat) {
	$this->createdat = $createdat;
    }

    /**
     * \fn	void setUpdatedat($updatedat)
     * \brief	Sets the Video modification date
     * @param	DateTime
     */
    public function setUpdatedat($updatedat) {
	$this->updatedat = $updatedat;
    }

    /**
     * \fn	void setActive($active)
     * \brief	Sets the active value
     * @param	BOOL
     */
    public function setActive($active) {
	$this->active = $active;
    }

    /**
     * \fn	void setAuthor($author)
     * \brief	Sets the author value
     * @param	string
     */
    public function setAuthor($author) {
	$this->author = $author;
    }

    /**
     * \fn	void setCounter($counter)
     * \brief	Sets the counter value
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
     * \brief	Sets the duration value
     * @param	int
     */
    public function setDuration($duration) {
	$this->duration = $duration;
    }

    /**
     * \fn	void setFromuser($fromuser))
     * \brief	Sets the fromUser value
     * @param	int
     */
    public function setFromuser($fromuser) {
	$this->fromuser = $fromuser;
    }

    /**
     * \fn	void setLovecounter($lovecounter)
     * \brief	Sets the loveCounter value
     * @param	int
     */
    public function setLovecounter($lovecounter) {
	$this->lovecounter = $lovecounter;
    }

    /**
     * \fn	void setTag($tag)
     * \brief	Sets the tags value,array of strings
     * @param	int
     */
    public function setTag($tag) {
	$this->tag = $tag;
    }

    /**
     * \fn	void setThumbnail($thumbnail)
     * \brief	Sets the thumbnail value, url of the cover image of the video
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
     * \fn	void setURL($URL)
     * \brief	Sets the URL value, url of the video
     * @param	string
     */
    public function setURL($URL) {
	$this->URL = $URL;
    }

    /**
     * \fn	string __toString()
     * \brief	Return a printable string representing the Video object
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
	$string .= '[author] => ' . $this->getAuthor() . '<br />';
	$string .= '[counter] => ' . $this->getCounter() . '<br />';
	$string .= '[cover] => ' . $this->getCover() . '<br />';
	$string .= '[description] => ' . $this->getDescription() . '<br />';
	$string .= '[duration] => ' . $this->getDuration() . '<br />';
	$string .= '[fromuser] => ' . $this->getFromuser() . '<br />';
	$string .= '[lovecounter] => ' . $this->getLovecounter() . '<br />';
	foreach ($this->getTag() as $tag) {
	    $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	    $string .= '[tag] => ' . $tag . '<br />';
	}
	$string .= '[thumbnail] => ' . $this->getThumbnail() . '<br />';
	$string .= '[title] => ' . $this->getTitle() . '<br />';
	$string .= '[URL] => ' . $this->getURL() . '<br />';
	return $string;
    }

}

?>
