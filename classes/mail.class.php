<?php

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