<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Funzione:
 * \brief		servizio di check sulla presenza di uno user in quella relazione
 * \details		
 * \par			Commenti:
 * \warning
 * \bug			
 * \todo		
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');
require_once ROOT_DIR . 'config.php';

/**
 * \fn	checkUserInEventRelation($userId, $eventId, $field)
 * \brief   check if user is in a sort of relation with event
 * \return  true if the user is in that property, false otherwise
 */
function checkUserInEventRelation($userId, $eventId, $field) {
    require_once CLASSES_DIR . 'eventParse.class.php';
    $eventP = new EventParse();
    $eventP->where('id', $eventId);
    $eventP->where('active', true);
    $eventP->whereRelatedTo($field, '_User', $userId);
    $check = $eventP->getCount();
    return ($check != 0) ? true : false;
}

?>