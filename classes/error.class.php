<?php

/* ! \par		Info Generali:
 *  \author		Daniele Caldelli
 *  \version	1.0
 *  \date		2013
 *  \copyright	Jamyourself.com 2013
 *  \par		Info Classe:
 *  \brief		Error
 *  \details	Classe Error per la gestione degli errori
 *  \par		Commenti:
 *  \warning
 *  \bug
 *  \todo
 * 
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:error:faq">API</a>
 */

class Error {

    private $objectId;
    private $errorClass;
    private $errorCode;
    private $errorMessage;
    private $errorFunction;
    private $errorFunctionParameter;
    private $createdAt;
    private $updatedAt;
    private $ACL;

    /**
     * \fn		string getObjectId()
     * \brief	Return the objectId value
     * \return	string
     */
    public function getObjectId() {
	return $this->objectId;
    }

    /**
     * \fn		string getErrorClass()
     * \brief	Return the class which raise the Error
     * \return	string
     */
    public function getErrorClass() {
	return $this->errorClass;
    }

    /**
     * \fn		number getErrorCode()
     * \brief	Return the Error code
     * \return	number
     */
    public function getErrorCode() {
	return $this->errorCode;
    }

    /**
     * \fn		string getErrorFunction()
     * \brief	Return the function which raise the Error
     * \return	string
     */
    public function getErrorFunction() {
	return $this->errorFunction;
    }

    /**
     * \fn		array getErrorFunctionParameter()
     * \brief	Returns an array containing the parameters of the function
     * \return	array
     */
    public function getErrorFunctionParameter() {
	return $this->errorFunctionParameter;
    }

    /**
     * \fn		string getErrorMessage()
     * \brief	Return the Error message
     * \return	string
     */
    public function getErrorMessage() {
	return $this->errorMessage;
    }

    /**
     * \fn		DateTime getCreatedAt()
     * \brief	Return the Error creation date
     * \return	DateTime
     */
    public function getCreatedAt() {
	return $this->createdAt;
    }

    /**
     * \fn		DateTime getUpdatedAt()
     * \brief	Return the Error modification date
     * \return	DateTime
     */
    public function getUpdatedAt() {
	return $this->updatedAt;
    }

    /**
     * \fn		parseACL getACL()
     * \brief	Return the parseACL object representing the Error ACL 
     * \return	parseACL
     */
    public function getACL() {
	return $this->ACL;
    }

    /**
     * \fn		void setObjectId($objectId)
     * \brief	Sets the objectId value
     * \param	string
     */
    public function setObjectId($objectId) {
	$this->objectId = $objectId;
    }

    /**
     * \fn		void setErrorClass($errorClass)
     * \brief	Sets the class which raise the Error
     * \param	string
     */
    public function setErrorClass($errorClass) {
	$this->errorClass = $errorClass;
    }

    /**
     * \fn		void setErrorCode($errorCode)
     * \brief	Sets the Error code
     * \param	string
     */
    public function setErrorCode($errorCode) {
	$this->errorCode = $errorCode;
    }

    /**
     * \fn		void setErrorFunction($errorFunction)
     * \brief	Sets the function which raise the Error
     * \param	string
     */
    public function setErrorFunction($errorFunction) {
	$this->errorFunction = $errorFunction;
    }

    /**
     * \fn		void setErrorFunctionParameter($errorFunctionParameter)
     * \brief	Sets an array containing the parameters of the function
     * \param	array
     */
    public function setErrorFunctionParameter($errorFunctionParameter) {
	$this->errorFunctionParameter = $errorFunctionParameter;
    }

    /**
     * \fn		void setErrorMessage($errorMessage)
     * \brief	Sets the Error message
     * \param	string
     */
    public function setErrorMessage($errorMessage) {
	$this->errorMessage = $errorMessage;
    }

    /**
     * \fn		void setCreatedAt($createdAt)
     * \brief	Sets the Error creation date
     * \param	DateTime
     */
    public function setCreatedAt($createdAt) {
	$this->createdAt = $createdAt;
    }

    /**
     * \fn		void setUpdatedAt($updatedAt)
     * \brief	Sets the Error modification date
     * \param	DateTime
     */
    public function setUpdatedAt($updatedAt) {
	$this->updatedAt = $updatedAt;
    }

    /**
     * \fn		void setACL($ACL)
     * \brief	Sets the parseACL object representing the Error ACL
     * \param	parseACL
     */
    public function setACL($ACL) {
	$this->ACL = $ACL;
    }

    /**
     * \fn		string __toString()
     * \brief	Return a printable string representing the Error object
     * \return	string
     */
    public function __toString() {
	$string = '';
	$string .= '[objectId] => ' . $this->getObjectId() . '<br />';
	$string .= '[errorClass] => ' . $this->getErrorClass() . '<br />';
	$string .= '[errorCode] => ' . $this->getErrorCode() . '<br />';
	$string .= '[errorFunction] => ' . $this->getErrorFunction() . '<br />';
	$string .= '[errorFunctionParameter] => <br />';
	if ($this->getErrorFunctionParameter() && count($this->getErrorFunctionParameter()) > 0) {
	    foreach ($this->getErrorFunctionParameter() as $key => $value) {
		$string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		$string .= '[param] => ' . $key . ' -> ' . $value . '<br />';
	    }
	}
	else
	    $string .= 'NULL <br/>';
	$string .= '[errorMessage] => ' . $this->getErrorMessage() . '<br />';
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