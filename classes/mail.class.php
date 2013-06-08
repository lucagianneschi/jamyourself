<?php
/*! \par Info Generali:
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
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:mail">API</a>
 */

class Mail {
	
	private $to;
	private $subject;
	private $message;
	private $header;
	
	public function __construct($isHtml) {
		if ($isHtml) {
			$this->header = "MIME-Version: 1.0" . "\r\n" .
							"Content-type: text/html; charset=iso-8859-1" . "\r\n" .
							"From: JamYourself <noreply@jamyourself.it>";
		} else {
			$this->header = "From: JamYourself <noreply@jamyourself.it>";
		}
	}
	
	public function getTo() {
		return $this->to;
	}
	
	public function getSubject() {
		return $this->subject;
	}
	
	public function getMessage() {
		return $this->message;
	}
	
	public function getHeader() {
		return $this->header;
	}
	
	public function printMail() {
		echo '[to] => ' . $this->getTo() . '<br />';
		echo '[subject] => ' . $this->getSubject() . '<br />';
		echo '[message] => ' . $this->getMessage() . '<br />';
		echo '[header] => ' . $this->getHeader() . '<br />';
	}
	
	public function sendMail() {
		$ret = mail(
			$this->getTo(),
			$this->getSubject(),
			$this->getMessage(),
			$this->getHeader()
		);
		
		return $ret;		
	}
	
	public function setTo($value) {
		$this->to = $value;
	}
	
	public function setSubject($value) {
		$this->subject = $value;
	}
	
	public function setMessage($value) {
		$this->message = $value;
	}
	
	public function setHeader($value) {
		$this->header = $value;
	}
	
}

?>