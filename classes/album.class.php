<?php

/**
 * Album  class
 * Classe raccoglitore per immagini
 *
 * @author		Maria Laura Fresu
 * @version		0.2
 * @since		2013
 * @copyright		Jamyourself.com 2013
 * @warning
 * @bug
 * @todo
 * @
 * @link https://github.com/lucagianneschi/jamyourself/wiki/Definizione-Classe:-Album
 */
class Album {

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
     * @property int numero di commenti
     */
    private $commentcounter;

    /**
     * @property int indice di gradimento
     */
    private $counter;

    /**
     * @property string per l'immagine di copertina
     */
    private $cover;

    /**
     * @property string per descrizione album
     */
    private $description;
	
	/**
     * @property array di id utenti che rappresentano le featuring 
     */
    private $featuring;
	
    /**
     * @property int id dell'utente che fa upload dell'album
     */
    private $fromuser;

    /**
     * @property int numero di immagini contenute
     */
    private $imagecounter;

    /**
     * @property array di id delle immagini
     */
    private $images;

    /**
     * @property float latitudine
     */
    private $latitude;

    /**
     * @property float longitudine
     */
    private $longitude;

    /**
     * @property int contatore di azioni love
     */
    private $lovecounter;

    /**
     * @property int contatore di azioni share
     */
    private $sharecounter;

    /**
     * @property array di tag (int)
     */
    private $tag;

    /**
     * @property string path al thumbnail della cover
     */
    private $thumbnail;

    /**
     * @property string titolo album
     */
    private $title;

    /**
     * Return the id value
     * @return	string
     */
    public function getId() {
	return $this->id;
    }

    /**
     * Return the Album creation date
     * @return	DateTime
     */
    public function getCreatedat() {
	return $this->createdat;
    }

    /**
     * Return the Album modification date
     * @return	DateTime
     */
    public function getUpdatedat() {
	return $this->updatedat;
    }

    /**
     * Return the active value
     * @return	int
     */
    public function getActive() {
	return $this->active;
    }

    /**
     * Return the comment counter value (number of comments)
     * @return	int
     */
    public function getCommentcounter() {
	return $this->commentcounter;
    }

    /**
     * Return the counter value
     * @return	int counter
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
     * Return the featuring array
     * @return	int
     */
    public function getFeaturing() {
	return $this->featuring;
    }

    /**
     * Return the id value for the fromUser
     * @return	int
     */
    public function getFromuser() {
	return $this->fromuser;
    }

    /**
     * Return the image counter value (number of images)
     * @return	int
     */
    public function getImagecounter() {
	return $this->imagecounter;
    }

    /**
     * Return the array of images
     * @return	int
     */
    public function getImages() {
	return $this->images;
    }

    /**
     * Return the latitude value
     * @return	long
     */
    public function getLatitude() {
	return $this->latitude;
    }

    /**
     * Return the longitude value
     * @return	long
     */
    public function getLongitude() {
	return $this->longitude;
    }

    /**
     * Return the int value of loveCounter, counting the love action on the album
     * @return	int
     */
    public function getLovecounter() {
	return $this->lovecounter;
    }

    /**
     * Return the counter for sharing action
     * @return	int
     */
    public function getSharecounter() {
	return $this->sharecounter;
    }

    /**
     * Return the tags value, array of string to categorize the album
     * @return	int
     */
    public function getTag() {
	return $this->tag;
    }

    /**
     * Return the thumbnail value
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
     * Sets the id value
     * @param	string
     */
    public function setId($id) {
	$this->id = $id;
    }

    /**
     * Sets the Album creation date
     * @param	DateTime
     */
    public function setCreatedat($createdat) {
	$this->createdat = $createdat;
    }

    /**
     * Sets the Album modification date
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
     * Sets the commnetCounter value
     * @param	int
     */
    public function setCommentcounter($commentcounter) {
	$this->commentcounter = $commentcounter;
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
     * Sets the fromUser value, int id
     * @param	int
     */
    public function setFeaturing($featuring) {
	$this->featuring = $featuring;
    }

    /**
     * Sets the fromUser value, int id
     * @param	int
     */
    public function setFromuser($fromuser) {
	$this->fromuser = $fromuser;
    }

    /**
     * Sets the imagetCounter value
     * @param	int
     */
    public function setImagecounter($imagecounter) {
	$this->imagecounter = $imagecounter;
    }

    /**
     * Sets the images value
     * @param	array
     */
    public function setImages($images) {
	$this->images = $images;
    }

    /**
     * Sets the latitude value
     * @param	$longitude
     */
    public function setLatitude($latitude) {
	$this->latitude = $latitude;
    }

    /**
     * Sets the longitude value
     * @param	$longitude
     */
    public function setLongitude($longitude) {
	$this->longitude = $longitude;
    }

    /**
     * Sets the loveCounter value
     * @param	int
     */
    public function setLovecounter($lovecounter) {
	$this->lovecounter = $lovecounter;
    }

    /**
     * Sets the sharecounter value
     * @param	int
     */
    public function setSharecounter($sharecounter) {
	$this->sharecounter = $sharecounter;
    }

    /**
     * Sets the tags value,array of strings
     * @param	array
     */
    public function setTag($tag) {
	$this->tag = $tag;
    }

    /**
     * Sets the title value
     * @param	string
     */
    public function setTitle($title) {
	$this->title = $title;
    }

    /**
     * Sets the thumbnail value
     * @param	string
     */
    public function setThumbnail($thumbnail) {
	$this->thumbnail = $thumbnail;
    }

    /**
     * Return a printable string representing the Album object
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
	$string .= '[cover] => ' . $this->getCover() . '<br />';
	$string .= '[description] => ' . $this->getDescription() . '<br />';
	$string .= '[featuring] => ' . $this->getFeaturing() . '<br />';
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