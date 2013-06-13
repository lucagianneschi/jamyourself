<?php

/* ! \par Info Generali:
 *  \author    Daniele Caldelli, Stefano Muscas
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par Info Classe:
 *  \brief     Comment 
 *  \details   Classe dedicata a POST, REVIEW, COMMENT & MESSAGGI 
 *  
 *  \par Commenti:
 *  \warning
 *  \bug
 *  \todo
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:comment">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:comment">API</a>
 */

class Comment {

    private $objectId;
    private $active;
    private $album;
    private $comment;
    private $commentators;
    private $comments;
    private $counter;
    private $event;
    private $fromUser;
    private $image;
    private $location;
    private $loveCounter;
    private $lovers;
    private $opinions;
    private $record;
    private $song;
    private $status;
    private $tags;
    private $text;
    private $toUser;
    private $type;
    private $video;
    private $vote;
    private $createdAt;
    private $updatedAt;
    private $ACL;
	
	// TODO - da eliminare
	private $testDate;
	public function getTestDate() {
		return $this->testDate;
    }
	public function setTestdate($testDate) {
        $this->testDate = $testDate;
    }
	// TODO

    public function __construct() {        
    }

    public function getObjectId() {
        return $this->objectId;
    }

    public function getActive() {
        return $this->active;
    }

    public function getAlbum() {
        return $this->album;
    }

    public function getComment() {
        return $this->comment;
    }

    public function getCommentators() {
        return $this->commentators;
    }

    public function getComments() {
        return $this->comments;
    }

    public function getCounter() {
        return $this->counter;
    }

    public function getEvent() {
        return $this->event;
    }

    public function getFromUser() {
        return $this->fromUser;
    }

    public function getImage() {
        return $this->image;
    }

    public function getLocation() {
        return $this->location;
    }

    public function getLoveCounter() {
        return $this->loveCounter;
    }

    public function getLovers() {
        return $this->lovers;
    }

    public function getOpinions() {
        return $this->opinions;
    }

    public function getRecord() {
        return $this->record;
    }

    public function getSong() {
        return $this->song;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getTags() {
        return $this->tags;
    }

    public function getText() {
        return $this->text;
    }

    public function getToUser() {
        return $this->toUser;
    }

    public function getType() {
        return $this->type;
    }

    public function getVideo() {
        return $this->video;
    }

    public function getVote() {
        return $this->vote;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    public function getACL() {
        return $this->ACL;
    }

    public function setObjectId($objectId) {
        $this->objectId = $objectId;
    }

    public function setActive($active) {
        $this->active = $active;
    }

    public function setAlbum(Album $album) {
        $this->album = $album;
    }

    public function setComment(Comment $comment) {
        $this->comment = $comment;
    }

    public function setCommentators(array $commentators) {
        $this->commentators = $commentators;
    }

    public function setComments(array $comments) {
        $this->comments = $comments;
    }

    public function setCounter($counter) {
        $this->counter = $counter;
    }

    public function setEvent(Event $event) {
        $this->event = $event;
    }

    public function setFromUser(User $fromUser) {
        $this->fromUser = $fromUser;
    }

    public function setImage(Image $image) {
        $this->image = $image;
    }

    public function setLocation($location) {
        $this->location = $location;
    }

    public function setLoveCounter($loveCounter) {
        $this->loveCounter = $loveCounter;
    }

    public function setLovers(array $lovers) {
        $this->lovers = $lovers;
    }

    public function setOpinions(array $opinions) {
        $this->opinions = $opinions;
    }

    public function setRecord(Record $record) {
        $this->record = $record;
    }

    public function setSong(Song $song) {
        $this->song = $song;
    }

    public function setStatus(Status $status) {
        $this->status = $status;
    }

    public function setTags(array $tags) {
        $this->tags = $tags;
    }

    public function setText($text) {
        $this->text = $text;
    }

    public function setToUser(User $toUser) {
        $this->toUser = $toUser;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function setVideo(Video $video) {
        $this->video = $video;
    }

    public function setVote($vote) {
        $this->vote = $vote;
    }

    public function setCreatedAt(DateTime $createdAt) {
        $this->createdAt = $createdAt;
    }

    public function setUpdatedAt(DateTime $updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    public function setACL($ACL) {
        $this->ACL = $ACL;
    }

    public function __toString() {
        $string = '';
        $string .= '[objectId] => ' . $this->getObjectId() . '<br />';
        $string .= '[active] => ' . $this->getActive() . '<br />';
		if ($this->getAlbum() != null) {
			$string .= '[album] => ' . $this->getAlbum()->getObjectId() . '<br />';
		} else {
			$string .= '[album] => NULL<br />';
		}
		if ($this->getComment() != null) {
			$string .= '[comment] => ' . $this->getComment()->getObjectId() . '<br />';
		} else {
			$string .= '[comment] => NULL<br />';
		}
		if (count($this->getCommentators()) != 0) {
			foreach ($this->getCommentators() as $commentators) {
				$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				$string .= '[commentators] => ' . $commentators . '<br />';
			}
		} else {
			$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$string .= '[commentators] => NULL<br />';
		}
		if (count($this->getComments()) != 0) {
			foreach ($this->getComments() as $comments) {
				$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				$string .= '[comments] => ' . $comments . '<br />';
			}
		} else {
			$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$string .= '[comments] => NULL<br />';
		}
		$string .= '[counter] => ' . $this->getCounter() . '<br />';
		if ($this->getEvent() != null) {
			$string .= '[event] => ' . $this->getEvent()->getObjectId() . '<br />';
		} else {
			$string .= '[event] => NULL<br />';
		}
		if ($this->getFromUser() != null) {
			$string .= '[fromUser] => ' . $this->getFromUser()->getObjectId() . '<br />';
		} else {
			$string .= '[fromUser] => NULL<br />';
		}
		if ($this->getImage() != null) {
			$string .= '[image] => ' . $this->getImage()->getObjectId() . '<br />';
		} else {
			$string .= '[image] => NULL<br />';
		}
		if ($this->getLocation() != null) {
			$location = $this->getLocation();
			$string .= '[location] => ' . $location[latitude] . ', ' . $location[longitude] . '<br />';
		} else {
			$string .= '[location] => NULL<br />';
		}
		$string .= '[loveCounter] => ' . $this->getLoveCounter() . '<br />';
		if (count($this->getLovers()) != 0) {
			foreach ($this->getLovers() as $lovers) {
				$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				$string .= '[lovers] => ' . $lovers . '<br />';
			}
		} else {
			$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$string .= '[lovers] => NULL<br />';
		}
		if (count($this->getOpinions()) != 0) {
			foreach ($this->getOpinions() as $opinions) {
				$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				$string .= '[opinions] => ' . $opinions . '<br />';
			}
		} else {
			$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$string .= '[opinions] => NULL<br />';
		}
		if ($this->getRecord() != null) {
			$string .= '[record] => ' . $this->getRecord()->getObjectId() . '<br />';
		} else {
			$string .= '[record] => NULL<br />';
		}
		if ($this->getSong() != null) {
			$string .= '[song] => ' . $this->getSong()->getObjectId() . '<br />';
		} else {
			$string .= '[song] => NULL<br />';
		}
		if ($this->getStatus() != null) {
			$string .= '[status] => ' . $this->getStatus()->getObjectId() . '<br />';
		} else {
			$string .= '[status] => NULL<br />';
		}
		if (count($this->getTags()) != 0) {
			foreach ($this->getTags() as $tags) {
				$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				$string .= '[tags] => ' . $tags . '<br />';
			}
			
		} else {
			$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$string .= '[tags] => NULL<br />';
		}
		$string .= '[text] => ' . $this->getText() . '<br />';
		if ($this->getToUser() != null) {
			$string .= '[toUser] => ' . $this->getToUser()->getObjectId() . '<br />';
		} else {
			$string .= '[toUser] => NULL<br />';
		}
		$string .= '[type] => ' . $this->getType() . '<br />';
		if ($this->getVideo() != null) {
			$string .= '[video] => ' . $this->getVideo()->getObjectId() . '<br />';
		} else {
			$string .= '[video] => NULL<br />';
		}
		$string .= '[vote] => ' . $this->getVote() . '<br />';
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