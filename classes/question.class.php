<?php

/* ! \par		Info Generali:
 *  \author		Daniele Caldelli
 *  \version		0.3
 *  \date		2013
 *  \copyright		Jamyourself.com 2013
 *  \par		Info Classe:
 *  \brief		Question
 *  \details		Classe dedicata alle domande e alle risposte tra utenti e amministrazione
 *  \par		Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="https://github.com/lucagianneschi/jamyourself/wiki/Definizione-Classe:-Question">Descrizione della classe</a>
 *  <a href="https://github.com/lucagianneschi/jamyourself/wiki/API:-Question">API</a>
 */

class Question {

    private $id;
    private $createdat;
    private $updatedat;
    private $answer;
    private $mailFrom;
    private $mailTo;
    private $name;
    private $replied;
    private $subject;
    private $text;

    /**
     * \fn		string getId()
     * \brief	Return the id value
     * \return	string
     */
    public function getId() {
	return $this->id;
    }

    /**
     * \fn		DateTime getCreatedat()
     * \brief	Return the Question creation date
     * \return	DateTime
     */
    public function getCreatedat() {
	return $this->createdat;
    }

    /**
     * \fn		DateTime getUpdatedat()
     * \brief	Return the Question modification date
     * \return	DateTime
     */
    public function getUpdatedat() {
	return $this->updatedat;
    }

    /**
     * \fn		string getAnswer()
     * \brief	Return the answer value
     * \return	string
     */
    public function getAnswer() {
	return $this->answer;
    }

    /**
     * \fn		string getMailFrom()
     * \brief	Return the mailFrom value
     * \return	string
     */
    public function getMailFrom() {
	return $this->mailFrom;
    }

    /**
     * \fn		string getMailTo()
     * \brief	Return the mailTo value
     * \return	string
     */
    public function getMailTo() {
	return $this->mailTo;
    }

    /**
     * \fn		string getName()
     * \brief	Return the name value
     * \return	string
     */
    public function getName() {
	return $this->name;
    }

    /**
     * \fn		BOOL getReplied()
     * \brief	Return the replied value
     * \return	BOOL
     */
    public function getReplied() {
	return $this->replied;
    }

    /**
     * \fn		string getSubject()
     * \brief	Return the subject value
     * \return	string
     */
    public function getSubject() {
	return $this->subject;
    }

    /**
     * \fn		string getText()
     * \brief	Return the text value
     * \return	string
     */
    public function getText() {
	return $this->text;
    }

    /**
     * \fn		void setId($id)
     * \brief	Sets the id value
     * \param	string
     */
    public function setId($id) {
	$this->id = $id;
    }

    /**
     * \fn		void setCreatedat($createdat)
     * \brief	Sets the Question creation date
     * \param	DateTime
     */
    public function setCreatedat($createdat) {
	$this->createdat = $createdat;
    }

    /**
     * \fn		void setUpdatedat($updatedat)
     * \brief	Sets the Question modification date
     * \param	DateTime
     */
    public function setUpdatedat($updatedat) {
	$this->updatedat = $updatedat;
    }

    /**
     * \fn		void setAnswer($value)
     * \brief	Sets the answer value
     * \param	string
     */
    public function setAnswer($value) {
	$this->answer = $value;
    }

    /**
     * \fn		void setMailFrom($value)
     * \brief	Sets the mailFrom value
     * \param	string
     */
    public function setMailFrom($value) {
	$this->mailFrom = $value;
    }

    /**
     * \fn		void setMailTo($value)
     * \brief	Sets the mailTo value
     * \param	string
     */
    public function setMailTo($value) {
	$this->mailTo = $value;
    }

    /**
     * \fn		void setName($value)
     * \brief	Sets the name value
     * \param	string
     */
    public function setName($value) {
	$this->name = $value;
    }

    /**
     * \fn		void setReplied($value)
     * \brief	Sets the replied value
     * \param	BOOL
     */
    public function setReplied($value) {
	$this->replied = $value;
    }

    /**
     * \fn		void setSubject($value)
     * \brief	Sets the subject value
     * \param	string
     */
    public function setSubject($value) {
	$this->subject = $value;
    }

    /**
     * \fn		void setText($value)
     * \brief	Sets the text value
     * \param	string
     */
    public function setText($value) {
	$this->text = $value;
    }

    /**
     * \fn		string __toString()
     * \brief	Return a printable string representing the Question object
     * \return	string
     */
    public function __toString() {
	$string = '';
	$string .= '[id] => ' . $this->getId() . '<br />';
	$createdAt = new DateTime($this->getCreatedat());
	$string .= '[createdat] => ' . $createdAt->format('d-m-Y H:i:s') . '<br />';
	$updatedAt = new DateTime($this->getUpdatedat());
	$string .= '[updatedat] => ' . $updatedAt->format('d-m-Y H:i:s') . '<br />';
	$string .= '[answer] => ' . $this->getAnswer() . '<br />';
	$string .= '[mailFrom] => ' . $this->getMailFrom() . '<br />';
	$string .= '[mailTo] => ' . $this->getMailTo() . '<br />';
	$string .= '[name] => ' . $this->getName() . '<br />';
	$string .= '[replied] => ' . $this->getReplied() . '<br />';
	$string .= '[subject] => ' . $this->getSubject() . '<br />';
	$string .= '[text] => ' . $this->getText() . '<br />';
	return $string;
    }

}

?>
