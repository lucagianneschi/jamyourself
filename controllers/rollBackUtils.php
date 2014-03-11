<?php

/* ! \par		Info Generali:
 * @author		Luca Gianneschi
 * @version		1.0
 * \date		2013
 * \copyright	        Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		controller di gestione delle rollback dei controller
 * \details		gestisce le azioni in caso di fallimento di alcune azioni dei controller
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		aggiornare al momento in cui vengono messe nuove rollback per i controller, fare API su Wiki
 *
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';

/**
 * \fn	    rollbackAcceptRelation($operation, $activityObjectId, $activityField, $activityValue, $currentUserObjectId, $currentUserType, $toUserObjectId, $toUserType)
 * \brief   rollback for accept Relation in relation.controller.php
 * \param   $operation, $activityObjectId, $activityField, $activityValue, $currentUserObjectId, $currentUserType, $toUserObjectId, $toUserType
 */
function rollbackAcceptRelation($operation, $activityObjectId, $activityField, $activityValue, $currentUserObjectId, $currentUserType, $toUserObjectId, $toUserType) {
    global $controllers;
    switch ($operation) {
	case 'rollbackActivityStatus':
	    require_once CLASSES_DIR . 'activityParse.class.php';
	    $activityParse = new ActivityParse();
	    $resStatus = $activityParse->updateField($activityObjectId, $activityField, $activityValue);
	    $message = ($resStatus instanceof Error) ? $controllers['ROLLKO'] : $controllers['ROLLOK'];
	    break;
	case 'rollbackActivityRead':
	    require_once CLASSES_DIR . 'activityParse.class.php';
	    $activityParse = new ActivityParse();
	    $resRead = $activityParse->updateField($activityObjectId, $activityField, $activityValue);
	    $message = ($resRead instanceof Error) ? $controllers['ROLLKO'] : $controllers['ROLLOK'];
	    break;
	case 'rollbackRelation':
	    require_once CLASSES_DIR . 'userParse.class.php';
	    $userParse = new UserParse();
	    if ($currentUserType == 'SPOTTER' && $toUserType == 'SPOTTER') {
		$resToUserF = $userParse->updateField($toUserObjectId, 'friendship', array($currentUserObjectId), true, 'remove', '_User');
		$resFromUserF = $userParse->updateField($currentUserObjectId, 'friendship', array($toUserObjectId), true, 'remove', '_User');
	    } elseif ($currentUserType != 'SPOTTER' && $toUserType != 'SPOTTER') {
		$resToUserF = $userParse->updateField($toUserObjectId, 'collaboration', array($currentUserObjectId), true, 'remove', '_User');
		$resFromUserF = $userParse->updateField($currentUserObjectId, 'collaboration', array($toUserObjectId), true, 'remove', '_User');
	    }
	    $message = ($resToUserF instanceof Error || $resFromUserF instanceof Error) ? $controllers['ROLLKO'] : $controllers['ROLLOK'];
	    break;
	case 'rollbackIncrementToUser':
	    require_once CLASSES_DIR . 'userParse.class.php';
	    $userParse = new UserParse();
	    if ($currentUserType == 'SPOTTER' && $toUserType == 'SPOTTER') {
		$resToUserFC = $userParse->decrementUser($toUserObjectId, 'friendshipCounter', 1);
	    } elseif ($currentUserType != 'SPOTTER' && $toUserType != 'SPOTTER') {
		if ($currentUserType == 'JAMMER' && $toUserType == 'JAMMER') {
		    $resToUserFC = $userParse->decrementUser($toUserObjectId, 'jammerCounter', 1);
		} elseif ($currentUserType == 'JAMMER' && $toUserType == 'VENUE') {
		    $resToUserFC = $userParse->decrementUser($toUserObjectId, 'venueCounter', 1);
		} elseif ($currentUserType == 'VENUE' && $toUserType == 'JAMMER') {
		    $resToUserFC = $userParse->decrementUser($toUserObjectId, 'jammerCounter', 1);
		} elseif ($currentUserType == 'VENUE' && $toUserType == 'VENUE') {
		    $resToUserFC = $userParse->decrementUser($toUserObjectId, 'venueCounter', 1);
		}
	    }
	    $message = ($resToUserFC instanceof Error) ? $controllers['ROLLKO'] : $controllers['ROLLOK'];
	    break;
    }
    return $message;
}

/**
 * \fn	    rollbackCommentController($id, $classType)
 * \brief   rollback for comment.controller.php
 * \param   $id, $classType
 */
function rollbackCommentController($id, $classType) {
    global $controllers;
    require_once CLASSES_DIR . 'commentParse.class.php';
    $commentParse = new CommentParse();
    $resCmt = $commentParse->deleteComment($id);
    switch ($classType) {
	case 'Album':
	    require_once CLASSES_DIR . 'albumParse.class.php';
	    $albumParse = new AlbumParse();
	    $res = $albumParse->decrementAlbum($id, 'commentCounter', 1);
	    break;
	case 'Comment':
	    $res = $commentParse->decrementComment($id, 'commentCounter', 1);
	    break;
	case 'Event':
	    require_once CLASSES_DIR . 'eventParse.class.php';
	    $eventParse = new EventParse();
	    $res = $eventParse->decrementEvent($id, 'commentCounter', 1);
	    break;
	case 'Image':
	    require_once CLASSES_DIR . 'imageParse.class.php';
	    $imageParse = new ImageParse();
	    $res = $imageParse->decrementImage($id, 'commentCounter', 1);
	    break;
	case 'Record':
	    require_once CLASSES_DIR . 'recordParse.class.php';
	    $recordParse = new RecordParse();
	    $res = $recordParse->decrementRecord($id, 'commentCounter', 1);
	    break;
	case 'Video':
	    require_once CLASSES_DIR . 'videoParse.class.php';
	    $videoParse = new VideoParse();
	    $res = $videoParse->incrementVideo($id, 'commentCounter', 1);
	    break;
    }
    $message = ($res instanceof Error || $resCmt instanceof Error) ? $controllers['ROLLKO'] : $controllers['ROLLOK'];
    return $message;
}

/**
 * \fn	    rollbackDeclineRelation($activityObjectId, $activityField, $activityValue)
 * \brief   rollback for Decline function of relation.controller.php
 * \param   $activityObjectId, $activityField, $activityValue
 */
function rollbackDeclineRelation($activityObjectId, $activityField, $activityValue) {
    global $controllers;
    require_once CLASSES_DIR . 'activityParse.class.php';
    $activityParse = new ActivityParse();
    $resStatus = $activityParse->updateField($activityObjectId, $activityField, $activityValue);
    $message = ($resStatus instanceof Error) ? $controllers['ROLLKO'] : $controllers['ROLLOK'];
    return $message;
}

/**
 * \fn	rollbackDeleteController($classType, $id)
 * \brief   rollback for DeleteController
 * \param   $id dell'oggetto su cui fare rollback della delete, $classType
 */
function rollbackDeleteController($classType, $id) {
    global $controllers;
    switch ($classType) {
	case 'Activity':
	    require_once CLASSES_DIR . 'activityParse.class.php';
	    $activityParse = new ActivityParse();
	    $res = $activityParse->updateField($id, 'active', true);
	    break;
	case 'Album':
	    require_once CLASSES_DIR . 'albumParse.class.php';
	    $albumParse = new AlbumParse();
	    $res = $albumParse->updateField($id, 'active', true);
	    break;
	case 'Comment':
	    require_once CLASSES_DIR . 'commentParse.class.php';
	    $commentParse = new CommentParse();
	    $res = $commentParse->updateField($id, 'active', true);
	    break;
	case 'Event':
	    require_once CLASSES_DIR . 'eventParse.class.php';
	    $eventParse = new EventParse();
	    $res = $eventParse->updateField($id, 'active', true);
	    break;
	case 'Image':
	    require_once CLASSES_DIR . 'imageParse.class.php';
	    $imageParse = new ImageParse();
	    $res = $imageParse->updateField($id, 'active', true);
	    break;
	case 'Playlist':
	    require_once CLASSES_DIR . 'playlistParse.class.php';
	    $playlistParse = new PlaylistParse();
	    $res = $playlistParse->updateField($id, 'active', true);
	    break;
	case 'Record':
	    require_once CLASSES_DIR . 'recordParse.class.php';
	    $recordParse = new RecordParse();
	    $res = $recordParse->updateField($id, 'active', true);
	    break;
	case 'Song':
	    require_once CLASSES_DIR . 'songParse.class.php';
	    $songParse = new SongParse();
	    $res = $songParse->updateField($id, 'active', true);
	    break;
	case 'Video':
	    require_once CLASSES_DIR . 'videoParse.class.php';
	    $videoParse = new VideoParse();
	    $res = $videoParse->updateField($id, 'active', true);
	    break;
    }
    $message = ($res instanceof Error) ? $controllers['ROLLKO'] : $controllers['ROLLOK'];
    return $message;
}

/**
 * \fn	    rollbackEventController($id, $operation)
 * \brief   EventManagementController
 * \param   $id dell'oggetto su cui fare rollback della eventmanagement, operation -> sendInvitation, accept, refuse o maybe
 */
function rollbackEventController($activityId, $operation, $userId = null, $eventId = null) {
    global $controllers;
    require_once CLASSES_DIR . 'activityParse.class.php';
    require_once CLASSES_DIR . 'eventParse.class.php';
    $activityParse = new ActivityParse();
    switch ($operation) {
	case 'acceptInvitation':
	    $res1 = $activityParse->updateField($activityId, 'status', 'P');
	    $res2 = $activityParse->updateField($activityId, 'read', false);
	    $eventP = new EventParse();
	    $res3 = $eventP->updateField($eventId, 'attendee', array($userId), true, 'remove', '_User');
	    $res = $res1 || $res2 || $res3;
	    break;
	case 'attendEvent':
	    $eventP = new EventParse();
	    $res = $eventP->updateField($eventId, 'attendee', array($userId), true, 'remove', '_User');
	    break;
	case 'declineInvitation':
	    $res1 = $activityParse->deleteActivity($activityId);
	    $eventP = new EventParse();
	    $res2 = $eventP->updateField($eventId, 'attendee', $userId, true, 'remove', '_User');
	    $res = $res1 || $res2;
	    break;
	case 'removeAttendee':
	    $res1 = $activityParse->updateField($activityId, 'status', 'A');
	    $eventP = new EventParse();
	    $res2 = $eventP->updateField($eventId, 'attendee', array($userId), true, 'add', '_User');
	    $res3 = $eventP->updateField($eventId, 'refused', array($userId), true, 'remove', '_User');
	    $res = $res1 || $res2 || $res3;
	    break;
	case 'sendInvitation':
	    break;
    }
    $message = ($res instanceof Error) ? $controllers['ROLLKO'] : $controllers['ROLLOK'];
    return $message;
}

/**
 * \fn	rollbackLoveController($classType, $id, $operation, $fromuser)
 * \brief   rollback for LoveController
 * \param   $id dell'oggetto su cui fare rollback della love, $classType, operation (love or unlove), $fromuser
 */
function rollbackLoveController($classType, $id, $operation, $fromuser) {
    global $controllers;
    switch ($classType) {
	case 'Album':
	    require_once CLASSES_DIR . 'albumParse.class.php';
	    $albumParse = new AlbumParse();
	    if ($operation == 'increment') {
		$res = $albumParse->incrementAlbum($id, 'loveCounter', 1, true, 'lovers', array($fromuser->getId()));
	    } elseif ($operation == 'decrement') {
		$res = $albumParse->decrementAlbum($id, 'loveCounter', 1, true, 'lovers', array($fromuser->getId()));
	    }
	    break;
	case 'Comment':
	    require_once CLASSES_DIR . 'commentParse.class.php';
	    $commentParse = new CommentParse();
	    if ($operation == 'increment') {
		$res = $commentParse->incrementComment($id, 'loveCounter', 1, true, 'lovers', array($fromuser->getId()));
	    } elseif ($operation == 'decrement') {
		$res = $commentParse->decrementComment($id, 'loveCounter', 1, true, 'lovers', array($fromuser->getId()));
	    }
	    break;
	case 'Event':
	    require_once CLASSES_DIR . 'eventParse.class.php';
	    $eventParse = new EventParse();
	    if ($operation == 'increment') {
		$res = $eventParse->incrementEvent($id, 'loveCounter', 1, true, 'lovers', array($fromuser->getId()));
	    } elseif ($operation == 'decrement') {
		$res = $eventParse->decrementEvent($id, 'loveCounter', 1, true, 'lovers', array($fromuser->getId()));
	    }
	    break;
	case 'Image':
	    require_once CLASSES_DIR . 'imageParse.class.php';
	    $imageParse = new ImageParse();
	    if ($operation == 'increment') {
		$res = $imageParse->incrementImage($id, 'loveCounter', 1, true, 'lovers', array($fromuser->getId()));
	    } elseif ($operation == 'decrement') {
		$res = $imageParse->decrementImage($id, 'loveCounter', 1, true, 'lovers', array($fromuser->getId()));
	    }
	    break;
	case 'Record':
	    require_once CLASSES_DIR . 'recordParse.class.php';
	    $recordParse = new RecordParse();
	    if ($operation == 'increment') {
		$res = $recordParse->incrementRecord($id, 'loveCounter', 1, true, 'lovers', array($fromuser->getId()));
	    } elseif ($operation == 'decrement') {
		$res = $recordParse->decrementRecord($id, 'loveCounter', 1, true, 'lovers', array($fromuser->getId()));
	    }
	    break;
	case 'Song':
	    require_once CLASSES_DIR . 'songParse.class.php';
	    $songParse = new SongParse();
	    if ($operation == 'increment') {
		$res = $songParse->incrementSong($id, 'loveCounter', 1, true, 'lovers', array($fromuser->getId()));
	    } elseif ($operation == 'decrement') {
		$res = $songParse->decrementSong($id, 'loveCounter', 1, true, 'lovers', array($fromuser->getId()));
	    }
	    break;
	case 'Video':
	    require_once CLASSES_DIR . 'videoParse.class.php';
	    $videoParse = new VideoParse();
	    if ($operation == 'increment') {
		$res = $videoParse->incrementVideo($id, 'loveCounter', 1, true, 'lovers', array($fromuser->getId()));
	    } elseif ($operation == 'decrement') {
		$res = $videoParse->decrementVideo($id, 'loveCounter', 1, true, 'lovers', array($fromuser->getId()));
	    }
	    break;
    }
    $message = ($res instanceof Error) ? $controllers['ROLLKO'] : $controllers['ROLLOK'];
    return $message;
}

/**
 * \fn	rollbackMessageController($id, $function)
 * \brief   rollback for MessageController
 * \param   $id dell'oggetto su cui fare rollback della message, function (sendMessage or readMessage)
 */
function rollbackMessageController($id, $function) {
    global $controllers;
    if ($function == 'sendMessage') {
	require_once CLASSES_DIR . 'commentParse.class.php';
	$commentParse = new CommentParse();
	$res = $commentParse->deleteComment($id);
    } else {
	require_once CLASSES_DIR . 'activityParse.class.php';
	$activityParse = new ActivityParse();
	$res = $activityParse->updateField($id, 'read', true);
    }
    $message = ($res instanceof Error) ? $controllers['ROLLKO'] : $controllers['ROLLOK'];
    return $message;
}

/**
 * \fn	rollbackPlaylistController($playlistId, $songId, $operation, $premium, $limit)
 * \brief   rollback for addSong() e removeSong()
 * \param   $playslitId-> playlist id, $songId -> song id , $operation -> add, if you are calling rollback from addSong() or remove if are calling rollback from removeSong())$premium, $limit for the currentUser
 * \todo    
 */
function rollbackPlaylistController($playlistId, $songId, $operation, $premium, $limit) {
    global $controllers;
    require_once CLASSES_DIR . 'playlistParse.class.php';
    $playlistP = new PlaylistParse();
    $playlist = $playlistP->getPlaylist($playlistId);
    if ($playlist instanceof Error) {
	$this->response(array('status' => $controllers['ROLLKO']), 503);
    } elseif ($operation == 'add') {
	$res = $playlistP->updateField($playlistId, 'songs', array($songId), true, 'remove', 'Song');
	$res1 = $playlistP->removeObjectIdFromArray($playlistId, 'songsArray', $songId);
    } else {
	$res = $playlistP->updateField($playlistId, 'songs', array($songId), true, 'add', 'Song');
	$res1 = $playlistP->addOjectIdToArray($playlistId, 'songsArray', $songId, $premium, $limit);
    }
    $message = ($res1 instanceof Error || $res instanceof Error) ? $controllers['ROLLKO'] : $controllers['ROLLOK'];
    return $message;
}

/**
 * \fn	rollbackPostController($id)
 * \brief   rollback for PostController
 * \param   $id dell'oggetto su cui fare delete
 */
function rollbackPostController($id) {
    global $controllers;
    require_once CLASSES_DIR . 'commentParse.class.php';
    $postParse = new CommentParse();
    $res = $postParse->deleteComment($id);
    $message = ($res instanceof Error) ? $controllers['ROLLKO'] : $controllers['ROLLOK'];
    return $message;
}

/**
 * \fn	    rollbackRemoveRelation($operation, $activityObjectId, $activityField, $activityValue, $currentUserObjectId, $currentUserType, $toUserObjectId, $toUserType)
 * \brief   rollback for relation.controller.php for Remove Relation
 * \param   $operation, $activityObjectId, $activityField, $activityValue, $currentUserObjectId, $currentUserType, $toUserObjectId, $toUserType
 */
function rollbackRemoveRelation($operation, $activityObjectId, $activityField, $activityValue, $currentUserObjectId, $currentUserType, $toUserObjectId, $toUserType) {
    global $controllers;
    switch ($operation) {
	case 'rollbackActivityStatus':
	    require_once CLASSES_DIR . 'activityParse.class.php';
	    $activityParse = new ActivityParse();
	    $resStatus = $activityParse->updateField($activityObjectId, $activityField, $activityValue);
	    $message = ($resStatus instanceof Error) ? $controllers['ROLLKO'] : $controllers['ROLLOK'];
	    break;
	case 'rollbackActivityRead':
	    require_once CLASSES_DIR . 'activityParse.class.php';
	    $activityParse = new ActivityParse();
	    $resRead = $activityParse->updateField($activityObjectId, $activityField, $activityValue);
	    $message = ($resRead instanceof Error) ? $controllers['ROLLKO'] : $controllers['ROLLOK'];
	    break;
	case 'rollbackRelation':
	    require_once CLASSES_DIR . 'userParse.class.php';
	    $userParse = new UserParse();
	    if ($currentUserType == 'SPOTTER' && $toUserType == 'SPOTTER') {
		$resToUserF = $userParse->updateField($toUserObjectId, 'friendship', array($currentUserObjectId), true, 'add', '_User');
		$resFromUserF = $userParse->updateField($currentUserObjectId, 'friendship', array($toUserObjectId), true, 'add', '_User');
	    } elseif ($currentUserType != 'SPOTTER' && $toUserType != 'SPOTTER') {
		$resToUserF = $userParse->updateField($toUserObjectId, 'collaboration', array($currentUserObjectId), true, 'add', '_User');
		$resFromUserF = $userParse->updateField($currentUserObjectId, 'collaboration', array($toUserObjectId), true, 'add', '_User');
	    }
	    $message = ($resToUserF instanceof Error || $resFromUserF instanceof Error) ? $controllers['ROLLKO'] : $controllers['ROLLOK'];
	    break;
	case 'rollbackDecrementToUser':
	    require_once CLASSES_DIR . 'userParse.class.php';
	    $userParse = new UserParse();
	    if ($currentUserType == 'SPOTTER' && $toUserType == 'SPOTTER') {
		$resToUserFC = $userParse->incrementUser($toUserObjectId, 'friendshipCounter', 1);
	    } elseif ($currentUserType != 'SPOTTER' && $toUserType != 'SPOTTER') {
		if ($currentUserType == 'JAMMER' && $toUserType == 'JAMMER') {
		    $resToUserFC = $userParse->incrementUser($toUserObjectId, 'jammerCounter', 1);
		} elseif ($currentUserType == 'JAMMER' && $toUserType == 'VENUE') {
		    $resToUserFC = $userParse->incrementUser($toUserObjectId, 'venueCounter', 1);
		} elseif ($currentUserType == 'VENUE' && $toUserType == 'JAMMER') {
		    $resToUserFC = $userParse->incrementUser($toUserObjectId, 'jammerCounter', 1);
		} elseif ($currentUserType == 'VENUE' && $toUserType == 'VENUE') {
		    $resToUserFC = $userParse->incrementUser($toUserObjectId, 'venueCounter', 1);
		}
	    }
	    $message = ($resToUserFC instanceof Error) ? $controllers['ROLLKO'] : $controllers['ROLLOK'];
	    break;
    }
    return $message;
}

/**
 * \fn	    rollbackSendRelation($toUserObjectId)
 * \brief   rollback for relation.controller.php send relation 
 * \param   $toUserObjectId
 */
function rollbackSendRelation($toUserObjectId) {
    global $controllers;
    require_once CLASSES_DIR . 'userParse.class.php';
    $userParse = new UserParse();
    $resToUser = $userParse->updateField($toUserObjectId, 'followers', array(currentUserObjectId), true, 'remove', '_User');
    $message = ($resToUser instanceof Error) ? $controllers['ROLLKO'] : $controllers['ROLLOK'];
    return $message;
}

/**
 * \fn	rollbackSocialController($classType, $id)
 * \brief   rollback for SocialController
 * \param   $classType, $id 
 */
function rollbackSocialController($classType, $id) {
    global $controllers;
    switch ($classType) {
	case 'Album':
	    require_once CLASSES_DIR . 'albumParse.class.php';
	    $albumParse = new AlbumParse();
	    $res = $albumParse->decrementAlbum($id, 'sharecounter', 1);
	    break;
	case 'AlbumReview':
	    require_once CLASSES_DIR . 'commentParse.class.php';
	    $commentParse = new CommentParse();
	    $res = $commentParse->decrementComment($id, 'sharecounter', 1);
	    break;
	case 'Event':
	    require_once CLASSES_DIR . 'eventParse.class.php';
	    $eventParse = new EventParse();
	    $res = $eventParse->decrementEvent($id, 'sharecounter', 1);
	    break;
	case 'EventReview':
	    require_once CLASSES_DIR . 'commentParse.class.php';
	    $commentParse = new CommentParse();
	    $res = $commentParse->decrementComment($id, 'sharecounter', 1);
	    break;
	case 'Image':
	    require_once CLASSES_DIR . 'imageParse.class.php';
	    $imageParse = new ImageParse();
	    $res = $imageParse->decrementImage($id, 'sharecounter', 1);
	    break;
	case 'Record':
	    require_once CLASSES_DIR . 'recordParse.class.php';
	    $recordParse = new RecordParse();
	    $res = $recordParse->decrementRecord($id, 'sharecounter', 1);
	    break;
	case 'Song':
	    require_once CLASSES_DIR . 'songParse.class.php';
	    $songParse = new SongParse();
	    $res = $songParse->decrementSong($id, 'sharecounter', 1);
	    break;
    }
    $message = ($res instanceof Error) ? $controllers['ROLLKO'] : $controllers['ROLLOK'];
    return $message;
}

/**
 * \fn	rollbackUploadReviewController($id)
 * \brief   rollback for UploadReviewController
 * \param   $id 
 */
function rollbackUploadReviewController($id) {
    global $controllers;
    require_once CLASSES_DIR . 'commentParse.class.php';
    $commentParse = new CommentParse();
    $res = $commentParse->deleteComment($id);
    $message = ($res instanceof Error) ? $controllers['ROLLKO'] : $controllers['ROLLOK'];
    return $message;
}

/**
 * \fn	rollbackUploadRecordPublishSongController($id)
 * \brief   rollback for UploadRecordController
 * \param   $id 
 */
function rollbackUploadRecordController($id, $classType) {
    global $controllers;
    $message = null;
    switch ($classType) {
	case "Song":
	    require_once CLASSES_DIR . 'songParse.class.php';
	    $songParse = new SongParse();
	    $res = $songParse->deleteSong($id);
	    $message = ($res instanceof Error) ? $controllers['ROLLKO'] : $controllers['ROLLOK'];

	    break;
	case "Record":
	    require_once CLASSES_DIR . 'recordParse.class.php';
	    $recordParse = new SongParse();
	    $res = $recordParse->deleteSong($id);
	    $message = ($res instanceof Error) ? $controllers['ROLLKO'] : $controllers['ROLLOK'];
	    break;

	default:
	    break;
    }

    return $message;
}

/**
 * \fn      rollbackUploadEventController($id)
 * \brief   rollback for UploadEventController
 * \param   $id 
 */
function rollbackUploadEventController($id) {
    global $controllers;
    require_once CLASSES_DIR . 'eventParse.class.php';
    $eventParse = new EventParse();
    $res = $eventParse->deleteEvent($id);
    $message = ($res instanceof Error) ? $controllers['ROLLKO'] : $controllers['ROLLOK'];
    return $message;
}

function rollbackUploadAlbumController($id, $classType) {
    global $controllers;
    $message = null;
    switch ($classType) {
	case "Album":
	    $albumParse = new AlbumParse();
	    $res = $albumParse->deleteAlbum($id);
	    $message = ($res instanceof Error) ? $controllers['ROLLKO'] : $controllers['ROLLOK'];
	    break;
	case "Image" :
	    $imageParse = new ImageParse();
	    $res = $imageParse->deleteImage($id);
	    $message = ($res instanceof Error) ? $controllers['ROLLKO'] : $controllers['ROLLOK'];
	    break;
    }
    return $message;
}

?>