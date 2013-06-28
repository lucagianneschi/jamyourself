<?php

/* ! \par Info Generali:
 *  \author    Daniele Caldelli
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par Info Classe:
 *  \brief     classe per invio Mail
 *
 *  \par Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:mail">API</a>
 */

class Mail {

    private $to;
    private $subject;
    private $message;
    private $header;

    /**
     * \fn	void construct($isHtml)
     * \brief	The constructor instantiate the type of the Mail
     * \param	$isHtml is a string
     */
    public function __construct($isHtml) {
        if ($isHtml) {
            $this->header = "MIME-Version: 1.0" . "\r\n" .
                    "Content-type: text/html; charset=iso-8859-1" . "\r\n" .
                    "From: JamYourself <noreply@jamyourself.it>";
        } else {
            $this->header = "From: JamYourself <noreply@jamyourself.it>";
        }
    }

    /**
     * \fn	string getHeader()
     * \brief	Return the header value
     * \return	string
     */
    public function getHeader() {
        return $this->header;
    }

    /**
     * \fn	string getMessage()
     * \brief	Return the message value
     * \return	string
     */
    public function getMessage() {
        return $this->message;
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
     * \fn	string getTo()
     * \brief	Return the to value, the receiver of the mail
     * \return	string
     */
    public function getTo() {
        return $this->to;
    }

    /**
     * \fn	void  sendMail()
     * \brief	Send the email with the set parametert
     * \param	string
     */
    public function sendMail() {
        $ret = mail(
                $this->getTo(), $this->getSubject(), $this->getMessage(), $this->getHeader()
        );

        return $ret;
    }

    /**
     * \fn	void  setHeader($value)
     * \brief	Sets the header value
     * \param	string
     */
    public function setHeader($value) {
        $this->header = $value;
    }

    /**
     * \fn	void  setMessage($value)
     * \brief	Sets the meddage value
     * \param	string
     */
    public function setMessage($value) {
        $this->message = $value;
    }

    /**
     * \fn	void  setSubject($value)
     * \brief	Sets the subject value
     * \param	string
     */
    public function setSubject($value) {
        $this->subject = $value;
    }

    /**
     * \fn	void  setTo($value)
     * \brief	Sets the to value
     * \param	string
     */
    public function setTo($value) {
        $this->to = $value;
    }

    /**
     * \fn		string __toString()
     * \brief	Return a printable string representing the Mail object
     * \return	string
     */
    public function __toString() {
        $string = '';
        $string.="[to] => " . $this->getTo() . '<br />';
        $string.="[subject] => " . $this->getSubject() . '<br />';
        $string.="[message] => " . $this->getMessage() . '<br />';
        $string.="[header] => " . $this->getHeader() . '<br />';
        return $string;
    }

}

?>