<?php

/* ! \par Info Generali:
 *  \author    Daniele Caldelli
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par Info Classe:
 *  \brief     geoPointParse
 *  \details   Classe che serve per accogliere latitudine e longitudine di un 
 *  
 *  \par Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 * <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:faq">Descrizione della classe</a>
 * <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:faq">API</a>
 */

class Faq {

    private $objectId;
    private $answer;
    private $area;
    private $position;
    private $question;
    private $tags;
    private $createdAt;
    private $updatedAt;
    private $ACL;

    public function getObjectId() {
        return $this->objectId;
    }

    public function getAnswer() {
        return $this->answer;
    }

    public function getArea() {
        return $this->area;
    }

    public function getPosition() {
        return $this->position;
    }

    public function getQuestion() {
        return $this->question;
    }

    public function getTags() {
        return $this->tags;
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

    public function setAnswer($answer) {
        $this->answer = $answer;
    }

    public function setArea($area) {
        $this->area = $area;
    }

    public function setPosition($position) {
        $this->position = $position;
    }

    public function setQuestion($question) {
        $this->question = $question;
    }

    public function setTags($tags) {
        $this->tag = $tags;
    }

    public function setCreatedAt(DateTime $createdAt) {
        $this->createdAt = $createdAt;
    }

    public function setUpdatedAt(DateTime $updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    public function setACL($ACL) {
        return $this->ACL = $ACL;
    }

    public function __toString() {
        $string = '';
        $string .= '[objectId] => ' . $this->getObjectId() . '<br />';
        $string .= '[answer] => ' . $this->getAnswer() . '<br />';
        $string .= '[area] => ' . $this->getArea() . '<br />';
        $string .= '[position] => ' . $this->getPosition() . '<br />';
        $string .= '[question] => ' . $this->getQuestion() . '<br />';
		if (count($this->getTags()) != 0) {
			foreach ($this->getTags() as $tag) {
				$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				$string .= '[tag] => ' . $tag . '<br />';
			}
		} else {
			$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$string .= '[tags] => NULL<br />';
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