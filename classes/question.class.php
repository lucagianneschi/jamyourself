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

    /**
     * \fn	string getObjectId()
     * \brief	Return the objectId value
     * \return	string
     */
    public function getObjectId() {
        return $this->objectId;
    }

        /**
     * \fn	string getAnswer()
     * \brief	Return the answer value
     * \return	string
     */
    public function getAnswer() {
        return $this->answer;
    }

        /**
     * \fn	string getMailFrom()
     * \brief	Return the mailFrom value
     * \return	string
     */
    public function getMailFrom() {
        return $this->mailFrom;
    }

        /**
     * \fn	string getMailTo()
     * \brief	Return the mailTo value
     * \return	string
     */
    public function getMailTo() {
        return $this->mailTo;
    }

        /**
     * \fn	string getName()
     * \brief	Return the name value
     * \return	string
     */
    public function getName() {
        return $this->name;
    }

        /**
     * \fn	BOOL getReplied()
     * \brief	Return the replied value
     * \return	BOOL
     */
    public function getReplied() {
        return $this->replied;
    }

        /**
     * \fn	string getSubject()
     * \brief	Return the subject value
     * \return	string
     */
    public function getSubject() {
        return $this->subject;
    }

        /**
     * \fn	string getText()
     * \brief	Return the text value
     * \return	string
     */
    public function getText() {
        return $this->text;
    }

    /**
     * \fn	DateTime getCreatedAt()
     * \brief	Return the Question creation date
     * \return	DateTime
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * \fn	DateTime getUpdatedAt()
     * \brief	Return the Question modification date
     * \return	DateTime
     */
    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    /**
     * \fn	parseACL getACL()
     * \brief	Return the parseACL object representing the Question ACL 
     * \return	parseACL
     */
    public function getACL() {
        return $this->ACL;
    }

    /**
     * \fn	void setObjectId($objectId)
     * \brief	Sets the objectId value
     * \param	string
     */
    public function setObjectId($objectId) {
        $this->objectId = $objectId;
    }

        /**
     * \fn	void setAnswer($value)
     * \brief	Sets the answer value
     * \param	string
     */
    public function setAnswer($value) {
        $this->answer = $value;
    }

        /**
     * \fn	void setMailFrom($value)
     * \brief	Sets the mailFrom value
     * \param	string
     */
    public function setMailFrom($value) {
        $this->mailFrom = $value;
    }

        /**
     * \fn	void setMailTo($value)
     * \brief	Sets the mailTo value
     * \param	string
     */
    public function setMailTo($value) {
        $this->mailTo = $value;
    }

        /**
     * \fn	void setName($value)
     * \brief	Sets the name value
     * \param	string
     */
    public function setName($value) {
        $this->name = $value;
    }

        /**
     * \fn	void setReplied($value)
     * \brief	Sets the replied value
     * \param	BOOL
     */
    public function setReplied($value) {
        $this->replied = $value;
    }

        /**
     * \fn	void setSubject($value)
     * \brief	Sets the subject value
     * \param	string
     */
    public function setSubject($value) {
        $this->subject = $value;
    }

        /**
     * \fn	void setText($value)
     * \brief	Sets the text value
     * \param	string
     */
    public function setText($value) {
        $this->text = $value;
    }

    /**
     * \fn	void setCreatedAt($createdAt)
     * \brief	Sets the Question creation date
     * \param	DateTime
     */
    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }

    /**
     * \fn	void setUpdatedAt($updatedAt)
     * \brief	Sets the Question modification date
     * \param	DateTime
     */
    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    /**
     * \fn	void setACL($ACL)
     * \brief	Sets the parseACL object representing the Question ACL
     * \param	parseACL
     */
    public function setACL($ACL) {
        $this->ACL = $ACL;
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
        if ($this->getACL() != null) {
            foreach ($this->getACL()->acl as $key => $acl) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= '[ACL] => ' . $key . '<br />';
                foreach ($acl as $access => $value) {
                    $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    $string .= '[access] => ' . $access . ' -> ' . $value . '<br />';
                }
            }
        } else {
            $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            $string .= '[ACL] => NULL<br />';
        }
        return $string;
    }
}
?>