<?php

/* ! \par Info Generali:
 *  \author    Luca Gianneschi
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par Info Classe:
 *  \brief     Location
 *  \details   Classe che accoglie i dati di latitudine e longitudine delle citta da impostre per JAMMER  e SPOTTER
 *  
 *  \par Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:location">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:location">API</a>
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'utils.class.php';

class ErrorController {

    /**
     * \fn	alertMessage($index)
     * \brief	Set the message to be shown in the view in case of error
     * \param   $index, used in the switch structure
     * \return	error in case of exception; string to be showned in the view
     */
    public function errorMessage($index) {
        if (is_null($index))
            return throwError(new Exception('index parameter is unset'), __CLASS__, __FUNCTION__, func_get_args());
        switch ($index) {
            case 0:
                $message = 'Errore login';
                return $message;
                break;
            case 1:
                $message = 'Errore inserimento dato 1';
                return $message;
                break;
            case 2:
                $message = 'Errore inserimento dato 2';
                return $message;
                break;
            case 3:
                $message = 'Errore inserimento dato 3';
                return $message;
                break;
            case 4:
                $message = 'Errore inserimento dato 6';
                return $message;
                break;
            case 5:
                $message = 'Errore inserimento dato 7';
                return $message;
                break;
            case 6:
                $message = 'Errore inserimento dato 8';
                return $message;
                break;
            default:
                $message = 'Errore';
                return $message;
        }
    }

}

?>
