<?php

/* ! \par		Info Generali:
 *  @author		Maria Laura Fresu
 *  @version		0.3
 *  @since		2013
 *  @copyright		Jamyourself.com 2013
 *  \par		Info Classe:
 *  \brief		Image
 *  \details		Classe per la singola immagine caricata dall'utente
 *  \par		Commenti:
 *  @warning
 *  @bug
 *  @todo
 *
 *  <a href="https://github.com/lucagianneschi/jamyourself/wiki/Definizione-Classe:-Image">Descrizione della classe</a>
 *  <a href="https://github.com/lucagianneschi/jamyourself/wiki/API:-Image">API</a>
 */

class Image {

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
     * @property int istanza attiva/non attiva
     */
    private $album;

    /**
     * @property int numero di commenti
     */
    private $commentcounter;

    /**
     * @property int indice di gradimento
     */
    private $counter;

    /**
     * @property string descrizione del video
     */
    private $description;
	
	/**
     * @property int id del featuring
     */
    private $featuring;

    /**
     * @property int id del formuser
     */
    private $fromuser;

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
     * @property string path all'immagine
     */
    private $path;

    /**
     * @property int contatore di azioni share
     */
    private $sharecounter;

    /**
     * @property array di id di tag
     */
    private $tag;

    /**
     * @property string path al thumbnail della cover
     */
    private $thumbnail;

    /**
     * Return the id value
     * @return	int
     */
    public function getId() {
	return $this->id;
    }

    /**
     * Return the Event creation date
     * @return	DateTime
     */
    public function getCreatedat() {
	return $this->createdat;
    }

    /**
     * Return the Event modification date
     * @return	DateTime
     */
    public function getUpdatedat() {
	return $this->updatedat;
    }

    /**
     * Return the active value
     * @return	BOOL
     */
    public function getActive() {
	return $this->active;
    }

    /**
     * Return the int value id to album
     * @return	int
     */
    public function getAlbum() {
	return $this->album;
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
     * @return	int
     */
    public function getCounter() {
	return $this->counter;
    }

    /**
     * Return the description value
     * @return	string
     */
    public function getDescription() {
	return $this->description;
    }
	
	/**
     * Return the id value for the featuring
     * @return	array
     */
    public function getFeaturing() {
	return $this->featuring;
    }
	
    /**
     * Return the id value for the fromUser
     * @return	string
     */
    public function getFromuser() {
	return $this->fromuser;
    }

    /**
     * Return the latitude value
     * @return	latitude
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
     * Return the int value of loveCounter, counting the love action on the comment
     * @return	int
     */
    public function getLovecounter() {
	return $this->lovecounter;
    }

    /**
     * Return the path value
     * @return	string
     */
    public function getPath() {
	return $this->pathath;
    }

    /**
     * Return the counter for sharing action
     * @return	int
     */
    public function getSharecounter() {
	return $this->sharecounter;
    }

    /**
     * Return the tags value
     * @return	array of int
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
     * Sets the id value
     * @param	int object id
     */
    public function setId($id) {
	$this->id = $id;
    }

    /**
     * Sets the Comment creation date
     * @param	DateTime $createdat date of creation
     */
    public function setCreatedat($createdat) {
	$this->createdat = $createdat;
    }

    /**
     * Sets the Comment modification date
     * @param	DateTime $updatedat date of last update
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
     * Sets the album value
     * @param	int $album album id
     */
    public function setAlbum($album) {
	$this->album = $album;
    }

    /**
     * Sets the commnetCounter value
     * @param	int $commentcounter numero di commenti
     */
    public function setCommentcounter($commentcounter) {
	$this->commentcounter = $commentcounter;
    }

    /**
     * Sets the counter value
     * @param	int $counter counter di gradimento media
     */
    public function setCounter($counter) {
	$this->counter = $counter;
    }

    /**
     * Sets the description value
     * @param	string
     */
    public function setDescription($description) {
	$this->description = $description;
    }

	/**
     * Sets the featuring value
     * @param	array
     */
    public function setFeaturing($featuring) {
	$this->featuring = $featuring;
    }

    /**
     * Sets the fromUser value
     * @param	int $fromuser fromuser id
     */
    public function setFromuser($fromuser) {
	$this->fromuser = $fromuser;
    }

    /**
     * Sets the latitude value
     * @param	float $latitude latitude
     */
    public function setLatitude($latitude) {
	$this->latitude = $latitude;
    }

    /**
     * Sets the longitude value
     * @param	float $longitude longitude
     */
    public function setLongitude($longitude) {
	$this->longitude = $longitude;
    }

    /**
     * Sets the loveCounter value
     * @param	int $lovecounter number of love actions
     */
    public function setLovecounter($lovecounter) {
	$this->lovecounter = $lovecounter;
    }

    /**
     * Sets the path value
     * @param	string
     */
    public function setPath($path) {
	$this->path = $path;
    }

    /**
     * Sets the sharecounter value
     * @param	int $sharecounter number of share actions
     */
    public function setSharecounter($sharecounter) {
	$this->sharecounter = $sharecounter;
    }

    /**
     * Sets the tags value
     * @param	array $tag ids of tags
     */
    public function setTag($tag) {
	$this->tag = $tag;
    }

    /**
     * Sets the thumbnail value
     * @param	string
     */
    public function setThumbnail($thumbnail) {
	$this->thumbnail = $thumbnail;
    }

    /**
     * Return a printable string representing the Image object
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
	$string .= '[commentcounter] => ' . $this->getCommentcounter() . '<br />';
	$string .= '[counter] => ' . $this->getCounter() . '<br />';
	$string .= '[description] => ' . $this->getDescription() . '<br />';
	$string .= '[fromuser] => ' . $this->getFromuser() . '<br />';
	$string .= '[latitude] => ' . $this->getLatitude() . '<br />';
	$string .= '[longitude] => ' . $this->getLongitude() . '<br />';
	$string .= '[lovecounter] => ' . $this->getLovecounter() . '<br />';
	$string .= '[path] => ' . $this->getPath() . '<br />';
	$string .= '[sharecounter] => ' . $this->getSharecounter() . '<br />';
	foreach ($this->getTag() as $tag) {
	    $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	    $string .= '[tag] => ' . $tag . '<br />';
	}
	$string .= '[thumbnail] => ' . $this->getThumbnail() . '<br />';
	return $string;
    }

}

?>