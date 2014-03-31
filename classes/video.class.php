<?php

/**
 * Classe che contiene i video presi da Vimeo e Youtube e segnalati dagli utenti
 *
 * @author		Stefano Muscas
 * @version		0.2
 * @since		2013
 * @copyright		Jamyourself.com 2013
 * @warning
 * @bug
 * @todo
 * @link https://github.com/lucagianneschi/jamyourself/wiki/Definizione-Classe:-Video
 */
class Video {

    /**
     * @property int id istanza
     */
    private $id;

    /**
     * @property date data creazione istanza
     */
    private $createdat;

    /**
     * @property date data modifica istanza
     */
    private $updatedat;

    /**
     * @property int istanza attiva/non attiva
     */
    private $active;

    /**
     * @property string the author of the video (outside jamyourself)
     */
    private $author;

    /**
     * @property int contatore di gradimento
     */
    private $counter;

    /**
     * @property string alla cover del video (in hosting)
     */
    private $cover;

    /**
     * @property string descrizione del video
     */
    private $description;

    /**
     * @property int durata in secondi
     */
    private $duration;

    /**
     * @property int id del formuser
     */
    private $fromuser;

    /**
     * @property int contatore azioni love
     */
    private $lovecounter;

    /**
     * @property array di id di tag
     */
    private $tag;

    /**
     * @property string indirizzo del thumb (in hosting)
     */
    private $thumbnail;

    /**
     * @property string titolo del video
     */
    private $title;

    /**
     * @property string URL video
     */
    private $URL;

    /**
     * Return the id value
     * @return	int
     */
    public function getId() {
	return $this->id;
    }

    /**
     * Return the Video creation date
     * @return	DateTime
     */
    public function getCreatedat() {
	return $this->createdat;
    }

    /**
     * Return the Video modification date
     * @return	DateTime
     */
    public function getUpdatedat() {
	return $this->updatedat;
    }

    /**
     * Return the active value
     * @return	boolean
     */
    public function getActive() {
	return $this->active;
    }

    /**
     * Return the author value; author is the uploader on YouTube or Vimeo
     * @return	string
     */
    public function getAuthor() {
	return $this->author;
    }

    /**
     * Return the counter value
     * @return	int
     */
    public function getCounter() {
	return $this->counter;
    }

    /**
     * Return the cover (path file) value
     * @return	string
     */
    public function getCover() {
	return $this->cover;
    }

    /**
     * Return the description value
     * @return	string
     */
    public function getDescription() {
	return $this->description;
    }

    /**
     * Return the duration value in second
     * @return	int
     */
    public function getDuration() {
	return $this->duration;
    }

    /**
     * Return the id value for the fromUser
     * @return	int
     */
    public function getFromuser() {
	return $this->fromuser;
    }

    /**
     * Return the int value of loveCounter, counting the love action on the video
     * @return	int
     */
    public function getLovecounter() {
	return $this->lovecounter;
    }

    /**
     * Return the tags value, array of string to categorize the video
     * @return	int
     */
    public function getTag() {
	return $this->tag;
    }

    /**
     * Return the thumbnail value, URL of the video cover image
     * @return	string
     */
    public function getThumbnail() {
	return $this->thumbnail;
    }

    /**
     * Return the title value
     * @return	string
     */
    public function getTitle() {
	return $this->title;
    }

    /**
     * Return the URL value
     * @return	string
     */
    public function getURL() {
	return $this->URL;
    }

    /**
     * Sets the id value
     * @param	int
     */
    public function setId($id) {
	$this->id = $id;
    }

    /**
     * Sets the Video creation date
     * @param	DateTime
     */
    public function setCreatedat($createdat) {
	$this->createdat = $createdat;
    }

    /**
     * Sets the Video modification date
     * @param	DateTime
     */
    public function setUpdatedat($updatedat) {
	$this->updatedat = $updatedat;
    }

    /**
     * Sets the active value
     * @param	BOOL
     */
    public function setActive($active) {
	$this->active = $active;
    }

    /**
     * Sets the author value
     * @param	string
     */
    public function setAuthor($author) {
	$this->author = $author;
    }

    /**
     * Sets the counter value
     * @param	int
     */
    public function setCounter($counter) {
	$this->counter = $counter;
    }

    /**
     * Sets the cover value
     * @param	string
     */
    public function setCover($cover) {
	$this->cover = $cover;
    }

    /**
     * Sets the description value
     * @param	string
     */
    public function setDescription($description) {
	$this->description = $description;
    }

    /**
     * Sets the duration value
     * @param	int
     */
    public function setDuration($duration) {
	$this->duration = $duration;
    }

    /**
     * Sets the fromUser value
     * @param	int
     */
    public function setFromuser($fromuser) {
	$this->fromuser = $fromuser;
    }

    /**
     * Sets the loveCounter value
     * @param	int
     */
    public function setLovecounter($lovecounter) {
	$this->lovecounter = $lovecounter;
    }

    /**
     * Sets the tags value,array of strings
     * @param	int
     */
    public function setTag($tag) {
	$this->tag = $tag;
    }

    /**
     * Sets the thumbnail value, url of the cover image of the video
     * @param	string
     */
    public function setThumbnail($thumbnail) {
	$this->thumbnail = $thumbnail;
    }

    /**
     * Sets the title value
     * @param	string
     */
    public function setTitle($title) {
	$this->title = $title;
    }

    /**
     * Sets the URL value, url of the video
     * @param	string
     */
    public function setURL($URL) {
	$this->URL = $URL;
    }

    /**
     * Return a printable string representing the Video object
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