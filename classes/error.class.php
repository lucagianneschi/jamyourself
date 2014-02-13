<?php

/* ! \par		Info Generali:
 *  \author		Daniele Caldelli
 *  \version		0.3
 *  \date		2013
 *  \copyright		Jamyourself.com 2013
 *  \par		Info Classe:
 *  \brief		Error
 *  \details		Classe Error per la gestione degli errori
 *  \par		Commenti:
 *  \warning
 *  \bug
 *  \todo
 * 
 *  <a href="https://github.com/lucagianneschi/jamyourself/wiki/Definizione-Classe:-Error">Definizione Classe</a>
 *  <a href="https://github.com/lucagianneschi/jamyourself/wiki/API:-Error">API</a>
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

    /**
     * \fn	int getObjectId()
     * \brief	Return the objectId value
     * \return	int
     */
    public function getObjectId() {
	return $this->objectId;
    }

    /**
     * \fn	int getErrorClass()
     * \brief	Return the class which raise the Error
     * \return	int
     */
    public function getErrorClass() {
	return $this->errorClass;
    }

    /**
     * \fn	number getErrorCode()
     * \brief	Return the Error code
     * \return	number
     */
    public function getErrorCode() {
	return $this->errorCode;
    }

    /**
     * \fn	int getErrorFunction()
     * \brief	Return the function which raise the Error
     * \return	int
     */
    public function getErrorFunction() {
	return $this->errorFunction;
    }

    /**
     * \fn	array getErrorFunctionParameter()
     * \brief	Returns an array containing the parameters of the function
     * \return	array
     */
    public function getErrorFunctionParameter() {
	return $this->errorFunctionParameter;
    }

    /**
     * \fn	int getErrorMessage()
     * \brief	Return the Error message
     * \return	int
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
     * \fn	DateTime getUpdatedAt()
     * \brief	Return the Error modification date
     * \return	DateTime
     */
    public function getUpdatedAt() {
	return $this->updatedAt;
    }

    /**
     * \fn	void setObjectId($objectId)
     * \brief	Sets the objectId value
     * \param	int
     */
    public function setObjectId($objectId) {
	$this->objectId = $objectId;
    }

    /**
     * \fn	void setErrorClass($errorClass)
     * \brief	Sets the class which raise the Error
     * \param	int
     */
    public function setErrorClass($errorClass) {
	$this->errorClass = $errorClass;
    }

    /**
     * \fn	void setErrorCode($errorCode)
     * \brief	Sets the Error code
     * \param	int
     */
    public function setErrorCode($errorCode) {
	$this->errorCode = $errorCode;
    }

    /**
     * \fn		void setErrorFunction($errorFunction)
     * \brief	Sets the function which raise the Error
     * \param	int
     */
    public function setErrorFunction($errorFunction) {
	$this->errorFunction = $errorFunction;
    }

    /**
     * \fn	void setErrorFunctionParameter($errorFunctionParameter)
     * \brief	Sets an array containing the parameters of the function
     * \param	array
     */
    public function setErrorFunctionParameter($errorFunctionParameter) {
	$this->errorFunctionParameter = $errorFunctionParameter;
    }

    /**
     * \fn	void setErrorMessage($errorMessage)
     * \brief	Sets the Error message
     * \param	int
     */
    public function setErrorMessage($errorMessage) {
	$this->errorMessage = $errorMessage;
    }

    /**
     * \fn	void setCreatedAt($createdAt)
     * \brief	Sets the Error creation date
     * \param	DateTime
     */
    public function setCreatedAt($createdAt) {
	$this->createdAt = $createdAt;
    }

    /**
     * \fn	void setUpdatedAt($updatedAt)
     * \brief	Sets the Error modification date
     * \param	DateTime
     */
    public function setUpdatedAt($updatedAt) {
	$this->updatedAt = $updatedAt;
    }

    /**
     * \fn	string __toString()
     * \brief	Return a printable int representing the Error object
     * \return	int
     */
    public function __toString() {
	$int = '';
	$int .= '[objectId] => ' . $this->getObjectId() . '<br />';
	$int .= '[errorClass] => ' . $this->getErrorClass() . '<br />';
	$int .= '[errorCode] => ' . $this->getErrorCode() . '<br />';
	$int .= '[errorFunction] => ' . $this->getErrorFunction() . '<br />';
	$int .= '[errorFunctionParameter] => <br />';
	if ($this->getErrorFunctionParameter() && count($this->getErrorFunctionParameter()) > 0) {
	    foreach ($this->getErrorFunctionParameter() as $key => $value) {
		$int .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		$int .= '[param] => ' . $key . ' -> ' . $value . '<br />';
	    }
	}
	else
	    $int .= 'NULL <br/>';
	$int .= '[errorMessage] => ' . $this->getErrorMessage() . '<br />';
	if ($this->getCreatedAt() != null) {
	    $int .= '[createdAt] => ' . $this->getCreatedAt()->format('d-m-Y H:i:s') . '<br />';
	} else {
	    $int .= '[createdAt] => NULL<br />';
	}
	if ($this->getUpdatedAt() != null) {
	    $int .= '[updatedAt] => ' . $this->getUpdatedAt()->format('d-m-Y H:i:s') . '<br />';
	} else {
	    $int .= '[updatedAt] => NULL<br />';
	}
	return $int;
    }

}

?>