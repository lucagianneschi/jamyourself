<?php

/* ! \par Info Generali:
 *  \author    Daniele Caldelli
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par Info Classe:
 *  \brief     Question
 *  \details   Classe dedicata alle domande e alle risposte tra utenti e amministrazione
 *  
 *  \par Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:question">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:question">API</a>
 */

class Question {

    private $objectId;
    private $answer;
    private $mailFrom;
    private $mailTo;
    private $name;
    private $replied;
    private $subject;
    private $text;
    private $createdAt;
    private $updatedAt;
    private $ACL;

    public function getObjectId() {
        return $this->objectId;
    }

    public function getAnswer() {
        return $this->answer;
    }

    public function getMailFrom() {
        return $this->mailFrom;
    }

    public function getMailTo() {
        return $this->mailTo;
    }

    public function getName() {
        return $this->name;
    }

    public function getReplied() {
        return $this->replied;
    }

    public function getSubject() {
        return $this->subject;
    }

    public function getText() {
        return $this->text;
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

    public function setObjectId($value) {
        $this->objectId = $value;
    }

    public function setAnswer($value) {
        $this->answer = $value;
    }

    public function setMailFrom($value) {
        $this->mailFrom = $value;
    }

    public function setMailTo($value) {
        $this->mailTo = $value;
    }

    public function setName($value) {
        $this->name = $value;
    }

    public function setReplied($value) {
        $this->replied = $value;
    }

    public function setSubject($value) {
        $this->subject = $value;
    }

    public function setText($value) {
        $this->text = $value;
    }

    public function setCreatedAt(DateTime $value) {
        $this->createdAt = $value;
    }

    public function setUpdatedAt(DateTime $value) {
        return $this->updatedAt = $value;
    }

    public function setACL($value) {
        return $this->ACL = $value;
    }

    public function __toString() {
        $string = '';
        $string .= '[objectId] => ' . $this->getObjectId() . '<br />';
        $string .= '[answer] => ' . $this->getAnswer() . '<br />';
        $string .= '[mailFrom] => ' . $this->getMailFrom() . '<br />';
        $string .= '[mailTo] => ' . $this->getMailTo() . '<br />';
        $string .= '[name] => ' . $this->getName() . '<br />';
        $string .= '[replied] => ' . $this->getReplied() . '<br />';
        $string .= '[subject] => ' . $this->getSubject() . '<br />';
        $string .= '[text] => ' . $this->getText() . '<br />';
        if (($createdAt = $this->getCreatedAt()))
            $string .= '[createdAt] => ' . $createdAt->format('d-m-Y H:i:s') . '<br />';
        if (($updatedAt = $this->getUpdatedAt()))
            $string .= '[updatedAt] => ' . $updatedAt->format('d-m-Y H:i:s') . '<br />';
        if ($this->getACL() != null) {
            foreach ($this->getACL()->acl as $key => $acl) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= '[key] => ' . $key . '<br />';
                foreach ($acl as $access => $value) {
                    $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    $string .= '[access] => ' . $access . ' -> ' . $value . '<br />';
                }
            }
        }
        return $string;
    }

}

?>