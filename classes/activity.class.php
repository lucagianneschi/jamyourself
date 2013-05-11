<?php

class Activity{

	private $objectId; 	//String
	private $event;		//Event
	private $fromUser;	//User
	private $status;	//Status
	private $toUser;	//User
	private $type;		//string
	private $album;
	private $song;
	private $photoAlbum;
	private $photo;
	private $read;
	private $createdAt;	//DateTime
	private $updatedAt;	//DateTime
	private $ACL;		//ACL

	//COSTRUTTORE

	public function __construct(){
	}

	//FUNZIONI SET
	/**
	 *
	 * @param Date $objectId
	 */
	public function setObjectId($objectId){
		$this->objectId = $objectId;
	}

	/**
	 *
	 * @param Event $event
	 */
	public function setEvent(Event $event){
		$this->event = $event;
	}

	/**
	 *
	 * @param User $fromUser
	 */
	public function setFromUser(User $fromUser){
		$this->fromUser = $fromUser;
	}


	public function setAlbum(Album $album){

		$this->album = $album;

	}
	public function setSong(Song $song){

		$this->song = $song;

	}
	public function setPhotoAlbum(PhotoAlbum $photoAlbum){

		$this->photoAlbum = $photoAlbum;

	}

	public function setPhoto(Photo $photo){

		$this->photo = $photo;

	}

	/**
	 *
	 * @param Status $status
	 */
	public function setStatus(Status $status){
		$this->status = $status;
	}

	/**
	 *
	 * @param User $toUser
	 */
	public function setToUser(User $toUser){
		$this->toUser = $toUser;
	}

	public function setRead($read){
		$this->read = $read;
	}
	
	/**
	 *
	 * @param string $type
	 */
	public function setType($type){
		$this->type = $type;
	}

	/**
	 *
	 * @param DateTime $createdAt
	 */
	public function setCreatedAt(DateTime $createdAt){

		$this->createdAt = $createdAt;
	}

	/**
	 *
	 * @param DateTime $updatedAt
	 */
	public function setUpdatedAt(DateTime $updatedAt){
		$this->updatedAt = $updatedAt;

	}

	/**
	 *
	 * @param ACL $ACL
	 */
	public function setACL( $ACL){
		$this->ACL = $ACL;
	}

	//FUNZIONI GET


	public function getObjectId(){
		return $this->objectId;
	}

	public function getEvent(){
		return $this->event;
	}

	public function getFromUser(){
		return $this->fromUser;
	}

	public function getStatus(){
		return $this->status;
	}

	public function getToUser(){
		return $this->toUser;
	}

	public function getType(){
		return $this->type;
	}

	public function getAlbum(){

		return $this->album;

	}

	public function getSong(){

		return $this->song;

	}

	public function getPhotoAlbum(){

		return $this->photoAlbum;

	}
	
	public function getRead(){
		return $this->read;
	}

	public function getPhoto(){

		return $this->photo;

	}

	public function getCreatedAt(){

		return $this->createdAt;
	}

	public function getUpdatedAt(){
		return $this->updatedAt;

	}

	public function getACL(){
		return $this->ACL;
	}

}