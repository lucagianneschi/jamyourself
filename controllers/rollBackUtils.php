<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	        Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		controller di gestione delle rollback dei controller
 * \details		gestisce le azioni in caso di fallimento di alcune azioni dei controller
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		aggiornare al momento in cui vengono messe nuove rollback per i controller
 *
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'controllers/' . getLanguage() . '.controllers.lang.php';
require_once SERVICES_DIR . 'debug.service.php';

function rollbackCommentController($objectId, $classType) {
    global $controllers;
    require_once CLASSES_DIR . 'commentParse.class.php';
    $commentParse = new CommentParse();
    $resCmt = $commentParse->deleteComment($objectId);
    switch ($classType) {
        case 'Album':
            require_once CLASSES_DIR . 'albumParse.class.php';
            $albumParse = new AlbumParse();
            $res = $albumParse->decrementAlbum($objectId, 'commentCounter', 1);
            break;
        case 'Comment':
            $res = $commentParse->decrementComment($objectId, 'commentCounter', 1);
            break;
        case 'Event':
            require_once CLASSES_DIR . 'eventParse.class.php';
            $eventParse = new EventParse();
            $res = $eventParse->decrementEvent($objectId, 'commentCounter', 1);
            break;
        case 'Image':
            require_once CLASSES_DIR . 'imageParse.class.php';
            $imageParse = new ImageParse();
            $res = $imageParse->decrementImage($objectId, 'commentCounter', 1);
            break;
        case 'Status':
            require_once CLASSES_DIR . 'statusParse.class.php';
            $statusParse = new StatusParse();
            $res = $statusParse->decrementStatus($objectId, 'commentCounter', 1);
            break;
        case 'Record':
            require_once CLASSES_DIR . 'recordParse.class.php';
            $recordParse = new RecordParse();
            $res = $recordParse->decrementRecord($objectId, 'commentCounter', 1);
            break;
        case 'Video':
            require_once CLASSES_DIR . 'videoParse.class.php';
            $videoParse = new VideoParse();
            $res = $videoParse->incrementVideo($objectId, 'commentCounter', 1);
            break;
    }
    $message = ($res instanceof Error || $resCmt instanceof Error) ? $controllers['ROLLKO'] : $controllers['ROLLOK'];
    return $message;
}

/**
 * \fn	rollbackDeleteController($classType, $objectId)
 * \brief   rollback for DeleteController
 * \param   $objectId dell'oggetto su cui fare rollback della delete, $classType
 */
function rollbackDeleteController($classType, $objectId) {
    global $controllers;
    switch ($classType) {
        case 'Activity':
            require_once CLASSES_DIR . 'activityParse.class.php';
            $activityParse = new ActivityParse();
            $res = $activityParse->updateField($objectId, 'active', true);
            break;
        case 'Album':
            require_once CLASSES_DIR . 'albumParse.class.php';
            $albumParse = new AlbumParse();
            $res = $albumParse->updateField($objectId, 'active', true);
            break;
        case 'Comment':
            require_once CLASSES_DIR . 'commentParse.class.php';
            $commentParse = new CommentParse();
            $res = $commentParse->updateField($objectId, 'active', true);
            break;
        case 'Event':
            require_once CLASSES_DIR . 'eventParse.class.php';
            $eventParse = new EventParse();
            $res = $eventParse->updateField($objectId, 'active', true);
            break;
        case 'Image':
            require_once CLASSES_DIR . 'imageParse.class.php';
            $imageParse = new ImageParse();
            $res = $imageParse->updateField($objectId, 'active', true);
            break;
        case 'Playlist':
            require_once CLASSES_DIR . 'playlistParse.class.php';
            $playlistParse = new PlaylistParse();
            $res = $playlistParse->updateField($objectId, 'active', true);
            break;
        case 'Record':
            require_once CLASSES_DIR . 'recordParse.class.php';
            $recordParse = new RecordParse();
            $res = $recordParse->updateField($objectId, 'active', true);
            break;
        case 'Song':
            require_once CLASSES_DIR . 'songParse.class.php';
            $songParse = new SongParse();
            $res = $songParse->updateField($objectId, 'active', true);
            break;
        case 'Status':
            require_once CLASSES_DIR . 'statusParse.class.php';
            $statusParse = new StatusParse();
            $res = $statusParse->updateField($objectId, 'active', true);
            break;
        case 'Video':
            require_once CLASSES_DIR . 'videoParse.class.php';
            $videoParse = new VideoParse();
            $res = $videoParse->updateField($objectId, 'active', true);
            break;
    }
    $message = ($res instanceof Error) ? $controllers['ROLLKO'] : $controllers['ROLLOK'];
    return $message;
}

/**
 * \fn	rollbackEventManagementController($objectId, $operation)
 * \brief   EventManagementController
 * \param   $objectId dell'oggetto su cui fare rollback della eventmanagement, operation -> sendInvitation, accept, refuse o maybe
 */
function rollbackEventManagementController($objectId, $operation) {
    global $controllers;
    require_once CLASSES_DIR . 'activityParse.class.php';
    $activityParse = new ActivityParse();
    if ($operation == 'sendRequest') {
        $res = $activityParse->deleteActivity($objectId);
    } else {
        $res = $activityParse->updateField($objectId, 'status', 'P');
        $res1 = $activityParse->updateField($objectId, 'read', false);
    }
    $message = ((isset($res1) && $res instanceof Error) || $res instanceof Error) ? $controllers['ROLLKO'] : $controllers['ROLLOK'];
    return $message;
}

/**
 * \fn	rollbackLoveController($classType, $objectId, $operation, $fromUser)
 * \brief   rollback for LoveController
 * \param   $objectId dell'oggetto su cui fare rollback della love, $classType, operation (love or unlove), $fromUser
 */
function rollbackLoveController($classType, $objectId, $operation, $fromUser) {
    global $controllers;
    switch ($classType) {
        case 'Album':
            require_once CLASSES_DIR . 'albumParse.class.php';
            $albumParse = new AlbumParse();
            if ($operation == 'increment') {
                $res = $albumParse->incrementAlbum($objectId, 'loveCounter', 1, true, 'lovers', array($fromUser->getObjectId()));
            } elseif ($operation == 'decrement') {
                $res = $albumParse->decrementAlbum($objectId, 'loveCounter', 1, true, 'lovers', array($fromUser->getObjectId()));
            }
            break;
        case 'Comment':
            require_once CLASSES_DIR . 'commentParse.class.php';
            $commentParse = new CommentParse();
            if ($operation == 'increment') {
                $res = $commentParse->incrementComment($objectId, 'loveCounter', 1, true, 'lovers', array($fromUser->getObjectId()));
            } elseif ($operation == 'decrement') {
                $res = $commentParse->decrementComment($objectId, 'loveCounter', 1, true, 'lovers', array($fromUser->getObjectId()));
            }
            break;
        case 'Event':
            require_once CLASSES_DIR . 'eventParse.class.php';
            $eventParse = new EventParse();
            if ($operation == 'increment') {
                $res = $eventParse->incrementEvent($objectId, 'loveCounter', 1, true, 'lovers', array($fromUser->getObjectId()));
            } elseif ($operation == 'decrement') {
                $res = $eventParse->decrementEvent($objectId, 'loveCounter', 1, true, 'lovers', array($fromUser->getObjectId()));
            }
            break;
        case 'Image':
            require_once CLASSES_DIR . 'imageParse.class.php';
            $imageParse = new ImageParse();
            if ($operation == 'increment') {
                $res = $imageParse->incrementImage($objectId, 'loveCounter', 1, true, 'lovers', array($fromUser->getObjectId()));
            } elseif ($operation == 'decrement') {
                $res = $imageParse->decrementImage($objectId, 'loveCounter', 1, true, 'lovers', array($fromUser->getObjectId()));
            }
            break;
        case 'Record':
            require_once CLASSES_DIR . 'recordParse.class.php';
            $recordParse = new RecordParse();
            if ($operation == 'increment') {
                $res = $recordParse->incrementRecord($objectId, 'loveCounter', 1, true, 'lovers', array($fromUser->getObjectId()));
            } elseif ($operation == 'decrement') {
                $res = $recordParse->decrementRecord($objectId, 'loveCounter', 1, true, 'lovers', array($fromUser->getObjectId()));
            }
            break;
        case 'Song':
            require_once CLASSES_DIR . 'songParse.class.php';
            $songParse = new SongParse();
            if ($operation == 'increment') {
                $res = $songParse->incrementSong($objectId, 'loveCounter', 1, true, 'lovers', array($fromUser->getObjectId()));
            } elseif ($operation == 'decrement') {
                $res = $songParse->decrementSong($objectId, 'loveCounter', 1, true, 'lovers', array($fromUser->getObjectId()));
            }
            break;
        case 'Status':
            require_once CLASSES_DIR . 'statusParse.class.php';
            $statusParse = new StatusParse();
            if ($operation == 'increment') {
                $res = $statusParse->incrementStatus($objectId, 'loveCounter', 1, true, 'lovers', array($fromUser->getObjectId()));
            } elseif ($operation == 'decrement') {
                $res = $statusParse->decrementStatus($objectId, 'loveCounter', 1, true, 'lovers', array($fromUser->getObjectId()));
            }
            break;
        case 'Video':
            require_once CLASSES_DIR . 'videoParse.class.php';
            $videoParse = new VideoParse();
            if ($operation == 'increment') {
                $res = $videoParse->incrementVideo($objectId, 'loveCounter', 1, true, 'lovers', array($fromUser->getObjectId()));
            } elseif ($operation == 'decrement') {
                $res = $videoParse->decrementVideo($objectId, 'loveCounter', 1, true, 'lovers', array($fromUser->getObjectId()));
            }
            break;
    }
    $message = ($res instanceof Error) ? $controllers['ROLLKO'] : $controllers['ROLLOK'];
    return $message;
}

/**
 * \fn	rollbackMessageController($objectId, $function)
 * \brief   rollback for MessageController
 * \param   $objectId dell'oggetto su cui fare rollback della message, function (sendMessage or readMessage)
 */
function rollbackMessageController($objectId, $function) {
    global $controllers;
    if ($function == 'sendMessage') {
        require_once CLASSES_DIR . 'commentParse.class.php';
        $commentParse = new CommentParse();
        $res = $commentParse->deleteComment($objectId);
    } else {
        require_once CLASSES_DIR . 'activityParse.class.php';
        $activityParse = new ActivityParse();
        $res = $activityParse->updateField($objectId, 'read', true);
    }
    $message = ($res instanceof Error) ? $controllers['ROLLKO'] : $controllers['ROLLOK'];
    return $message;
}

/**
 * \fn	rollbackPlaylistController($playlistId, $songId, $operation, $premium, $limit)
 * \brief   rollback for addSong() e removeSong()
 * \param   $playslitId-> playlist objectId, $songId -> song objectId , $operation -> add, if you are calling rollback from addSong() or remove if are calling rollback from removeSong())$premium, $limit for the currentUser
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
 * \fn	rollbackPostController($objectId)
 * \brief   rollback for PostController
 * \param   $objectId dell'oggetto su cui fare delete
 */
function rollbackPostController($objectId) {
    global $controllers;
    require_once CLASSES_DIR . 'commentParse.class.php';
    $postParse = new CommentParse();
    $res = $postParse->deleteComment($objectId);
    $message = ($res instanceof Error) ? $controllers['ROLLKO'] : $controllers['ROLLOK'];
    return $message;
}

/**
 * \fn	rollbackSocialController($classType, $objectId)
 * \brief   rollback for SocialController
 * \param   $classType, $objectId 
 */
function rollbackSocialController($classType, $objectId) {
    global $controllers;
    switch ($classType) {
        case 'Album':
            require_once CLASSES_DIR . 'albumParse.class.php';
            $albumParse = new AlbumParse();
            $res = $albumParse->decrementAlbum($objectId, 'shareCounter', 1);
            break;
        case 'AlbumReview':
            require_once CLASSES_DIR . 'commentParse.class.php';
            $commentParse = new CommentParse();
            $res = $commentParse->decrementComment($objectId, 'shareCounter', 1);
            break;
        case 'Event':
            require_once CLASSES_DIR . 'eventParse.class.php';
            $eventParse = new EventParse();
            $res = $eventParse->decrementEvent($objectId, 'shareCounter', 1);
            break;
        case 'EventReview':
            require_once CLASSES_DIR . 'commentParse.class.php';
            $commentParse = new CommentParse();
            $res = $commentParse->decrementComment($objectId, 'shareCounter', 1);
            break;
        case 'Image':
            require_once CLASSES_DIR . 'imageParse.class.php';
            $imageParse = new ImageParse();
            $res = $imageParse->decrementImage($objectId, 'shareCounter', 1);
            break;
        case 'Record':
            require_once CLASSES_DIR . 'recordParse.class.php';
            $recordParse = new RecordParse();
            $res = $recordParse->decrementRecord($objectId, 'shareCounter', 1);
            break;
        case 'Song':
            require_once CLASSES_DIR . 'songParse.class.php';
            $songParse = new SongParse();
            $res = $songParse->decrementSong($objectId, 'shareCounter', 1);
            break;
    }
    $message = ($res instanceof Error) ? $controllers['ROLLKO'] : $controllers['ROLLOK'];
    return $message;
}

/**
 * \fn	rollbackUploadReviewController($objectId)
 * \brief   rollback for UploadReviewController
 * \param   $objectId 
 */
function rollbackUploadReviewController($objectId) {
    global $controllers;
    $commentParse = new CommentParse();
    $res = $commentParse->deleteComment($objectId);
    $message = ($res instanceof Error) ? $controllers['ROLLKO'] : $controllers['ROLLOK'];
    return $message;
}

?>