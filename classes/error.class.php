<?php

/* ! \par Info Generali:
 *  \author    Daniele Caldelli
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par Info Classe:
 *  \brief     Error
 *  \details   Classe Error per la gestione degli errori
 *  
 *  \par Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
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

    public function getObjectId() {
        return $this->objectId;
    }

    public function getErrorClass() {
        return $this->errorClass;
    }

    public function getErrorCode() {
        return $this->errorCode;
    }

    public function getErrorFunction() {
        return $this->errorFunction;
    }

    public function getErrorFunctionParameter() {
        return $this->errorFunctionParameter;
    }

    public function getErrorMessage() {
        return $this->errorMessage;
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

    public function setErrorClass($errorClass) {
        $this->errorClass = $errorClass;
    }

    public function setErrorCode($errorCode) {
        $this->errorCode = $errorCode;
    }

    public function setErrorFunction($errorFunction) {
        $this->errorFunction = $errorFunction;
    }

    public function setErrorFunctionParameter($errorFunctionParameter) {
        $this->errorFunctionParameter = $errorFunctionParameter;
    }

    public function setErrorMessage($errorMessage) {
        $this->errorMessage = $errorMessage;
    }

    public function setCreatedAt(DateTime $createdAt) {
        $this->createdAt = $createdAt;
    }

    public function setUpdatedAt(DateTime $updatedAt) {
        return $this->updatedAt = $updatedAt;
    }

    public function setACL($ACL) {
        return $this->ACL = $ACL;
    }

    public function __toString() {
        $string = '';
        $string .= '[objectId] => ' . $this->getObjectId() . '<br />';
        $string .= '[errorClass] => ' . $this->getErrorClass() . '<br />';
        $string .= '[errorCode] => ' . $this->getErrorCode() . '<br />';
        $string .= '[errorFunction] => ' . $this->getErrorFunction() . '<br />';
        $string .= '[errorFunctionParameter] => <br />';
        if( $this->getErrorFunctionParameter() && count($this->getErrorFunctionParameter())>0 ){
                foreach ($this->getErrorFunctionParameter() as $key => $value) {
                    $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    $string .= '[param] => ' . $key . ' -> ' . $value . '<br />';
                }
        }
        else $string .= 'NULL <br/>';
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