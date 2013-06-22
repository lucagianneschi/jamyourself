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
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:playlist">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:playlist">API</a>
 */

class Playlist {

    private $objectId;   //string: objectId Parse
    private $active;     //BOOL: classe attiva/non attiva
    private $fromUser;   //Pointer to Parse User, utente a cui appartiene la playlist
    private $name;    //string: nome della playlist
    private $songs;       //relation: lista delle canzoni inserite dall'utente nella playslit
    private $unlimited;   //BOOL: indica se il numero di canzoni da mettere nella playlist è illimitato o meno
    private $createdAt;   //DateTime: data e ora di creazione dell'istanza della playlist
    private $updatedAt;   //DateTime: data e ora di update dell'istanza della playlist
    private $ACL;    //Access Control List

    public function __construct() {
        
    }

    //getters
    //string: objectId Parse
    public function getObjectId() {
        return $this->objectId;
    }

    //BOOL: classe attiva/non attiva
    public function getActive() {
        return $this->active;
    }

    //Pointer to Parse User, utente a cui appartiene la playlist
    public function getFromUser() {
        return $this->fromUser;
    }

    //string: nome della playlist
    public function getName() {
        return $this->name;
    }

    //relation: lista delle canzoni inserite dall'utente nella playslit
    public function getSongs() {
        return $this->songs;
    }

    //BOOL: indica se il numero di canzoni da mettere nella playlist è illimitato o meno
    public function getUnlimited() {
        return $this->unlimited;
    }

    //DateTime: data e ora di creazione dell'istanza della playlist
    public function getCreatedAt() {
        return $this->createdAt;
    }

    //DateTime: data e ora di update dell'istanza della playlist
    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    //Access Control List
    public function getACL() {
        return $this->ACL;
    }

    //setters
    //string: objectId Parse
    public function setObjectId($objectId) {
        $this->objectId = $objectId;
    }

    //BOOL: classe attiva/non attiva
    public function setActive($active) {
        $this->active = $active;
    }

    //Pointer to Parse User, utente a cui appartiene la playlist
    public function setFromUser($fromUser) {
        $this->fromUser = $fromUser;
    }

    //string: nome della playlist
    public function setName($name) {
        $this->name = $name;
    }

    //relation: lista delle canzoni inserite dall'utente nella playslit
    public function setSongs($songs) {
        $this->songs = $songs;
    }

    //BOOL: indica se il numero di canzoni da mettere nella playlist è illimitato o meno
    public function setUnlimited($unlimited) {
        $this->unlimited = $unlimited;
    }

    //DateTime: data e ora di creazione dell'istanza della playlist
    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }

    //DateTime: data e ora di update dell'istanza della playlist
    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    //Access Control List
    public function setACL($ACL) {
        $this->ACL = $ACL;
    }

    public function __toString() {
        $string = '';
        $string .= '[objectId] => ' . $this->getObjectId() . '<br />';
        if (is_null($this->getActive())) {
            $string .= '[active] => NULL<br />';
        } else {
            $this->getActive() ? $string .= '[active] => 1<br />' : $string .= '[active] => 0<br />';
        }
        $string.="[fromUser] => " . $this->getFromUser() . "<br />";        
        $string.="[name] => " . $this->getName() . "<br />";
		if (count($this->getSongs()) != 0) {
			foreach ($this->getSongs() as $song) {
				$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				$string .= '[songs] => ' . $song . '<br />';
			}
		} else {
			$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$string .= '[songs] => NULL<br />';
		}
         if ($this->getUnlimited() === null) {
            $string .= '[unlimited] => NULL<br />';
        } else {
            $this->getUnlimited() ? $string .= '[unlimited] => 1<br />' : $string .= '[active] => 0<br />';
        }        
        if ($this->getCreatedAt() != null) {
			$string .= '[createdAt] => ' . $this->getCreatedAt()->format('d-m-Y H:i:s') . '<br />';
		} else {
			$string .= '[createdAt] => NULL<br />';
		}
		if ($this->getUpdatedAt() != null) {
			$string .= '[updatedAt] => ' . $this->getUpdatedAt()->format('d-m-Y H:i:s') . '<br />';
		} else {
			$string .= '[updatedAt] => NULL<br />';
		}
		$string .= '[ACL] => ' . print_r($this->getACL(), true) . '<br />';
        return $string;
    }

}

?>