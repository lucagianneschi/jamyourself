<?php

/* ! \par		Info Generali:
 *  \author		Daniele Caldelli
 *  \version		1.0
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

    private $errormessage;

    /**
     * \fn	string getErrormessage()
     * \brief	Return the Error message
     * \return	string
     */
    public function getErrormessage() {
	return $this->errormessage;
    }

    /**
     * \fn	void setErrorMessage($errorMessage)
     * \brief	Sets the Error message
     * \param	string
     */
    public function setErrormessage($errormessage) {
	$this->errormessage = $errormessage;
    }

    /**
     * \fn	string __toString()
     * \brief	Return a printable string representing the Error object
     * \return	string
     */
    public function __toString() {
	$string = '';
	$string .= '[errormessage] => ' . $this->getErrormessage() . '<br />';
	return $string;
    }

}

?>