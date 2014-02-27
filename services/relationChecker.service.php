<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		0.3
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Funzione:
 * \brief		servizio di check sull'esistenza relazione tra 2 user
 * \details		
 * \par			Commenti:
 * \warning
 * \bug			
 * \todo		realizzare nuova versione per DB a grafo
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');
require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'debug.service.php';

/**
 * \fn	relationChecker($currentUserId, $currentUserType, $toUserId, $toUserType)
 * \brief	check if 2 users ara in a relationship (any kind)
 * \param	$currentUserId, $currentUserType, $toUserId, $toUserType
 * \return  true if there's a relation between users, false otherwise
 */
function relationChecker() {
    return;
}

?>