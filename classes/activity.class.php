<?php

/* ! \par Info Generali:
 *  \author    Stefano Muscas
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par Info Classe:
 *  \brief     Playslist
 *  \details   Classe che accoglie le canzoni che andranno nel player della pagina utente
 *  
 *  \par Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:activity">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:activity">API</a>
 */

class Activity {

    private $objectId;  //String:objectId su Parse 															
    private $accepted;      //BOOL: da definire																	
    private $active;  //BOOL:Indica se l'istanza della classe è attiva 									
    private $album;         //Album (Parse Object): Istanza della classe Album associata all'activity 			
    private $comment;   //Comment (Parse Object): Istanza della classe Comment associata all'activity		
    private $event;   //Event (Parse Object): Istanza della classe Event associata all'activity           
    private $fromUser;  //User:Utente che effettua l'azione 												
    private $image;   //Image (Parse Object): Istanza della classe Image associata all'activity           	
    private $playlist;      //Playlist (Parse Object): Istanza della classe Playlist associata all'activity     
    private $question;      //Question (Parse Object): Istanza della classe Question associata all'activity 
    private $read;   //BOOL:Indica se l'istanza della classe è stata letta o meno 						
    private $record;        //Record (Parse Object): Istanza della classe Record associata all'activity
    private $song;          //Song (Parse Object): Istanza della classe Song associata all'activity
    private $status;  //string:Indica lo status di un'attività del tipo richiesta-accettazione/rifiuto
    private $toUser;  //User:Utente che riceve l'azione 												
    private $type;   //string:Indica la tipologia di attività 											
    private $userStatus;    //Status(Parse Object): Istanza della classe Status associata all'activity 			
    private $video;         //Video (Parse Object):Istanza della classe Video associata all'activity            
    private $createdAt;  //DateTime:Data di inserimento attività 											
    private $updatedAt;  //DateTime:Data di ultimo update attività 											
    private $ACL;   //ACL:access control list, determina le politiche di accesso alla classe 			

    //COSTRUTTORE

    public function __construct() {
        
    }

    //FUNZIONI SET
    /**
     *
     * @param string $objectId	
     */
    public function setObjectId($objectId) {
        $this->objectId = $objectId;
    }

    /**
     *
     * @param BOOL $accepted	
     */
    public function setAccepted($accepted) {
        $this->accepted = $accepted;
    }

    /**
     *
     * @param BOOL $active	
     */
    public function setActive($active) {
        $this->active = $active;
    }

    /**
     *
     * @param Album $album	
     */
    public function setAlbum($album) {
        $this->album = $album;
    }

    /**
     *
     * @param Comment $comment	
     */
    public function setComment($comment) {
        $this->comment = $comment;
    }

    /**
     *
     * @param Event $event	
     */
    public function setEvent($event) {
        $this->event = $event;
    }

    /**
     *
     * @param User $fromUser	
     */
    public function setFromUser($fromUser) {
        $this->fromUser = $fromUser;
    }

    /**
     *
     * @param Image $image	
     */
    public function setImage($image) {
        $this->image = $image;
    }

    /**
     *
     * @param Playlist $playlist	
     */
    public function setPlaylist($playlist) {
        $this->playlist = $playlist;
    }

    /**
     *
     * @param Question question	
     */
    public function setQuestion($question) {
        $this->question = $question;
    }

    /**
     *
     * @param BOOL $read	
     */
    public function setRead($read) {
        $this->read = $read;
    }

    /**
     *
     * @param Record $record	
     */
    public function setRecord($record) {
        $this->record = $record;
    }

    /**
     *
     * @param string $status	
     */
    public function setStatus($status) {
        $this->status = $status;
    }

    /**
     *
     * @param Song $song	
     */
    public function setSong($song) {
        $this->song = $song;
    }

    /**
     *
     * @param User $toUser	
     */
    public function setToUser($toUser) {
        $this->toUser = $toUser;
    }

    /**
     *
     * @param string $type	
     */
    public function setType($type) {
        $this->type = $type;
    }

    /**
     *
     * @param Status $status	
     */
    public function setUserStatus($userStatus) {
        $this->userStatus = $userStatus;
    }

    /**
     *
     * @param Video $video	
     */
    public function setVideo($video) {
        $this->video = $video;
    }

    /**
     *
     * @param DateTime $createdAt	
     */
    public function setCreatedAt($createdAt) {

        $this->createdAt = $createdAt;
    }

    /**
     *
     * @param DateTime $updatedAt	
     */
    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    /**
     *
     * @param ACL $ACL	
     */
    public function setACL($ACL) {
        $this->ACL = $ACL;
    }

    //FUNZIONI GET
    /**
     *
     * @param string $objectId	
     */
    public function getObjectId() {
        return $this->objectId;
    }

    /**
     *
     * @param BOOL $active	
     */
    public function getActive() {
        return $this->active;
    }

    /**
     *
     * @param BOOL $accepted	
     */
    public function getAccepted() {
        return $this->accepted;
    }

    /**
     *
     * @param Album $album	
     */
    public function getAlbum() {
        return $this->album;
    }

    /**
     *
     * @param Comment $comment	
     */
    public function getComment() {
        return $this->comment;
    }

    /**
     *
     * @param Event $event	
     */
    public function getEvent() {
        return $this->event;
    }

    /**
     *
     * @param User $fromUser	
     */
    public function getFromUser() {
        return $this->fromUser;
    }

    /**
     *
     * @param Image $image	
     */
    public function getImage() {
        return $this->image;
    }

    /**
     *
     * @param Playlist $playlist	
     */
    public function getPlaylist() {
        return $this->playlist;
    }

    /**
     *
     * @param Question $question	
     */
    public function getQuestion() {
        return $this->question;
    }

    /**
     *
     * @param BOOL $read	
     */
    public function getRead() {
        return $this->read;
    }

    /**
     *
     * @param string $status	
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     *
     * @param Record $record	
     */
    public function getRecord() {
        return $this->record;
    }

    /**
     *
     * @param Song $song	
     */
    public function getSong() {
        return $this->song;
    }

    /**
     *
     * @param User $toUser
     */
    public function getToUser() {
        return $this->toUser;
    }

    /**
     *
     * @param string $type	
     */
    public function getType() {
        return $this->type;
    }

    /**
     *
     * @param Status $status	
     */
    public function getUserStatus() {
        return $this->userStatus;
    }

    /**
     *
     * @param Video $video	
     */
    public function getVideo() {
        return $this->video;
    }

    /**
     *
     * @param DateTime $createdAt	
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     *
     * @param DateTime $updatedAt	
     */
    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    /**
     *
     * @param ACL $ACL	
     */
    public function getACL() {
        return $this->ACL;
    }

    public function __toString() {

        $string = "";

        if ($this->objectId != null)
            $string .= "[ objectId ] => " . $this->objectId . "<br />";
        else
            $string .= "[ objectId ] => NULL<br />";
        if (is_bool($this->accepted)) {
            $bool = ($this->accepted) ? 'TRUE' : 'FALSE';
            $string .= "[ accepted ] => " . $bool . "<br />";
        }
        else
            $string .= "[ accepted ] => NULL<br />";
        if (is_bool($this->active)) {
            $bool = ($this->active) ? 'TRUE' : 'FALSE';
            $string .= "[ active ] => " . $bool . "<br />";
        }
        else
            $string .= "[ active ] => NULL<br />";
        if ($this->album != null)
            $string .= " [ album ] => " . $this->album . "<br />";
        else
            $string .= "[ album ] => NULL<br />";
        if ($this->comment != null)
            $string .= " [ comment ] => " . $this->comment . "<br />";
        else
            $string .= "[ comment ] => NULL<br />";
        if ($this->event != null)
            $string .= " [ event ] => " . $this->event . "<br />";
        else
            $string .= "[ event ] => NULL<br />";
        if ($this->fromUser != null)
            $string .= " [ fromUser ] => " . $this->fromUser . "<br />";
        else
            $string .= "[ fromUser ] => NULL<br />";
        if ($this->image != null)
            $string .= " [ image ] => " . $this->image . "<br />";
        else
            $string .= "[ image ] => NULL<br />";
        if ($this->playlist != null)
            $string .= " [ playlist ] => " . $this->playlist . "<br />";
        else
            $string .= "[ playlist ] => NULL<br />";
        if ($this->question != null)
            $string .= " [ question ] => " . $this->question . "<br />";
        else
            $string .= "[ question ] => NULL<br />";
        if (is_bool($this->read)) {
            $bool = ($this->read) ? 'TRUE' : 'FALSE';
            $string .= " [ read ] => " . $bool . "<br />";
        }
        else
            $string .= "[ read ] => NULL<br />";
        if ($this->record != null)
            $string .= " [ record ] => " . $this->record . "<br />";
        else
            $string .= "[ record ] => NULL<br />";
        if ($this->song != null)
            $string .= " [ song ] => " . $this->song . "<br />";
        else
            $string .= "[ song ] => NULL<br />";
        if ($this->status != null)
            $string .= " [ status ] => " . $this->status . "<br />";
        else
            $string .= "[ status ] => NULL<br />";
        if ($this->toUser != null)
            $string .= " [ toUser ] => " . $this->toUser . "<br />";
        else
            $string .= "[ toUser ] => NULL<br />";
        if ($this->type != null)
            $string .= " [ type ] => " . $this->type . "<br />";
        else
            $string .= "[ type ] => NULL<br />";
        if ($this->userStatus != null)
            $string .= " [ userStatus ] => " . $this->userStatus . "<br />";
        else
            $string .= "[ userStatus ] => NULL<br />";
        if ($this->video != null)
            $string .= " [ video ] => " . $this->video . "<br />";
        else
            $string .= "[ video ] => NULL<br />";
        if ($this->createdAt != null)
            $string.="[ updatedAt ] => " . $this->createdAt->format('d/m/Y H:i:s') . "<br />";
        else
            $string .= "[ updatedAt ] => NULL<br />";
        if ($this->updatedAt != null)
            $string.="[ createdAt ] => " . $this->updatedAt->format('d/m/Y H:i:s') . "<br />";
        else
            $string .= "[ createdAt ] => NULL<br />";
        if ($this->getACL() != null) {
            $string .= '[ ACL ] => <br />';
            foreach ($this->getACL()->acl as $key => $acl) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= '[ key ] => ' . $key . '<br />';
                foreach ($acl as $access => $value) {
                    $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    $string .= '[ access ] => ' . $access . ' -> ' . $value . '<br />';
                }
            }
        }
        else
            $string .= "[ ACL ] => NULL<br />";
        return $string;
    }

}

?>
