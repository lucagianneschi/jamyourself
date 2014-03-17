<?php

/**
 * Comment class 
 * Classe dedicata a POST, REVIEW, COMMENT & MESSAGGI
 * 
 * @author		Daniele Caldelli 
 * @author              Stefano Muscas
 * @version		0.2
 * @since		2013
 * @copyright		Jamyourself.com 2013	
 * @warning
 * @bug
 * @todo                terminare commenti standard per le get
 * @link https://github.com/lucagianneschi/jamyourself/wiki/Definizione-Classe:-Comment definizione classe                
 */
class Comment {

    /**
     * @var int id istanza
     */
    private $id;

    /**
     * @var date data creazione istanza
     */
    private $createdat;

    /**
     * @var date data modifica istanza
     */
    private $updatedat;

    /**
     * @var int istanza attiva/non attiva
     */
    private $active;

    /**
     * @var int id dell'album associato
     */
    private $album;

    /**
     * @var int id del comment associato
     */
    private $comment;

    /**
     * @var int numero di commenti
     */
    private $commentcounter;

    /**
     * @var int indice di gradimento
     */
    private $counter;

    /**
     * @var int id del event associato
     */
    private $event;

    /**
     * @var int id dell'utente che fa upload dell'album
     */
    private $fromuser;

    /**
     * @var int id dell image associatas
     */
    private $image;

    /**
     * @var float latitudine
     */
    private $latitude;

    /**
     * @var float longitudine
     */
    private $longitude;

    /**
     * @var int contatore di azioni love
     */
    private $lovecounter;

    /**
     * @var int id del record associato
     */
    private $record;

    /**
     * @var int contatore di azioni share
     */
    private $sharecounter;

    /**
     * @var int id della song associata
     */
    private $song;

    /**
     * @var array di tag (int)
     */
    private $tag;

    /**
     * @var string testo del comment
     */
    private $text;

    /**
     * @var string testo del titolo (solo per review)
     */
    private $title;

    /**
     * @var int id del toser
     */
    private $touser;

    /**
     * @var string tipo di istanza di comment C = comment, P = post, M = message, RE = reviewEvent, RR = revieRecord
     */
    private $type;

    /**
     * @var int id del video associato
     */
    private $video;

    /**
     * @var int voto (valido solo in caso di review)
     */
    private $vote;

    /**
     * Return the id value
     * @return	int
     */
    public function getId() {
	return $this->id;
    }

    /**
     * Return the Comment creation date
     * @return	DateTime
     */
    public function getCreatedat() {
	return $this->createdat;
    }

    /**
     * Return the Comment modification date
     * @return	DateTime
     */
    public function getUpdatedat() {
	return $this->updatedat;
    }

    /**
     * Return the active valure
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
     * Return the related comment id
     * @return	int
     */
    public function getComment() {
	return $this->comment;
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
     * Return the related event id
     * @return	int
     */
    public function getEvent() {
	return $this->event;
    }

    /**
     * Return the id value for the fromUser
     * @return	int
     */
    public function getFromuser() {
	return $this->fromuser;
    }

    /**
     * Return the related image id
     * @return	int
     */
    public function getImage() {
	return $this->image;
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
     * Return the record value id
     * @return	string
     */
    public function getRecord() {
	return $this->record;
    }

    /**
     * Return the counter for sharing action
     * @return	int
     */
    public function getSharecounter() {
	return $this->sharecounter;
    }

    /**
     * Return the song value id
     * @return	int
     */
    public function getSong() {
	return $this->song;
    }

    /**
     * Return the tags value
     * @return	array of int
     */
    public function getTag() {
	return $this->tag;
    }

    /**
     * Return the text value
     * @return	string
     */
    public function getText() {
	return $this->text;
    }

    /**
     * Return the title value, NULL for any type but Review R
     * @return	string
     */
    public function getTitle() {
	return $this->title;
    }

    /**
     * Return the toUser value, id
     * @return	int
     */
    public function getTouser() {
	return $this->touser;
    }

    /**
     * Return the type value
     * @return	string
     */
    public function getType() {
	return $this->type;
    }

    /**
     * Return the video value id
     * @return	string
     */
    public function getVideo() {
	return $this->video;
    }

    /**
     * Return the vote, from 1 to 5
     * @return	int
     */
    public function getVote() {
	return $this->vote;
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
     * Sets the comment value
     * @param	int $comment comment id
     */
    public function setComment($comment) {
	$this->comment = $comment;
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
     * Sets the event id value
     * @param	int $event event id
     */
    public function setEvent($event) {
	$this->event = $event;
    }

    /**
     * Sets the fromUser value
     * @param	int $fromuser fromuser id
     */
    public function setFromuser($fromuser) {
	$this->fromuser = $fromuser;
    }

    /**
     * Sets the image id value
     * @param	int $image image id
     */
    public function setImage($image) {
	$this->image = $image;
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
     * Sets the record id value
     * @param	int $record record id
     */
    public function setRecord($record) {
	$this->record = $record;
    }

    /**
     * Sets the sharecounter value
     * @param	int $sharecounter number of share actions
     */
    public function setSharecounter($sharecounter) {
	$this->sharecounter = $sharecounter;
    }

    /**
     * Sets the song id value
     * @param	int $song song id
     */
    public function setSong($song) {
	$this->song = $song;
    }

    /**
     * Sets the tags value
     * @param	array $tag ids of tags
     */
    public function setTag($tag) {
	$this->tag = $tag;
    }

    /**
     * Sets the text value
     * @param	string $text text for every kind of comment instance
     */
    public function setText($text) {
	$this->text = $text;
    }

    /**
     * Sets the title
     * @param	string $title title of the review, null in other cases
     */
    public function setTitle($title) {
	$this->title = $title;
    }

    /**
     * Sets the toUser id value
     * @param	int $touser touser id
     */
    public function setTouser($touser) {
	$this->touser = $touser;
    }

    /**
     * Sets the type id value
     * @param	string $type C for comment, P for post, M for message, RE for review event, RR for review record
     */
    public function setType($type) {
	$this->type = $type;
    }

    /**
     * Sets the video id value
     * @param	int $video video id
     */
    public function setVideo($video) {
	$this->video = $video;
    }

    /**
     * Sets the vote value
     * @param int $vote vote for the review
     */
    public function setVote($vote) {
	$this->vote = $vote;
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