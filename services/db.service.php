<?php

/* ! \par		Info Generali:
 *  \author		Luca Gianneschi
 *  \version		0.3
 *  \date		2013
 *  \copyright		Jamyourself.com 2013
 *  \par		Info Classe:
 *  \brief		Servizio commessione DB
 *  \details		Servizio commessione DB
 *  \par		Commenti:
 *  \warning
 *  \bug
 *  \todo		terminare funzioni per ogni classe
 *
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once CLASSES_DIR . 'error.class.php';
require_once SERVICES_DIR . 'connection.service.php';

/**
 * \fn	    query($sql)
 * \brief   Execute generic query
 * \param   $ql string for query
 * \todo    
 */
function query($sql) {
    $connectionService = new ConnectionService();
    $connectionService->connect();
    if (!$connectionService->active) {
	return $connectionService->error;
    } else {
	$results = mysqli_query($connectionService->connection, $sql);
	while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
	    $rows[] = $row;
	$connectionService->disconnect();
	return $rows;
    }
}

/**
 * \fn	    selectAlbums($id, $where = null, $order = null, $limit = null, $skip = null)
 * \brief   Select on Album Class
 * \param   $id = null, $where = null, $order = null, $limit = null, $skip = null
 * \todo    
 */
function selectAlbums($id = null, $where = null, $order = null, $limit = null, $skip = null) {
    $connectionService = new ConnectionService();
    $connectionService->connect();
    if (!$connectionService->active) {
	$error = new Error();
	$error->setErrormessage($connectionService->error);
	return $error;
    } else {
	$sql = "SELECT	   a.id id_a,
                           a.active,
                           a.commentcounter,
                           a.counter,
                           a.cover,
                           a.description,
                           a.fromuser,
                           a.imagecounter,
                           a.latitude,
                           a.longitude,
                           a.lovecounter,
                           a.sharecounter,
                           a.thumbnail,
                           a.title,
                           a.createdat,
                           a.updatedat,
	                   u.id id_u,
                           u.username,
                           u.thumbnail thumbnail_u,
                           u.type
                      FROM album a, user u
                     WHERE a.id = " . $id . "
                       AND a.fromuser = u.id
		       AND a.active = 1";
	if (!is_null($where)) {
	    foreach ($where as $key => $value)
		$sql .= " AND " . $key . " = '" . $value . "'";
	}
	if (!is_null($order)) {
	    $sql .= " ORDER BY ";
	    foreach ($order as $key => $value)
		$sql .= " " . $key . " " . $value . ",";
	}
	if (!is_null($skip) && !is_null($limit)) {
	    $sql .= " LIMIT " . $skip . ", " . $limit;
	} elseif (is_null($skip) && !is_null($limit)) {
	    $sql .= " LIMIT " . $limit;
	}
	$results = mysqli_query($connectionService->connection, $sql);
	if (!$results) {
	    $error = new Error();
	    $error->setErrormessage($results->error);
	    return $error;
	}
	while ($row_album = mysqli_fetch_array($results, MYSQLI_ASSOC))
	    $rows_album[] = $row_album;
	$albums = array();
	foreach ($rows_album as $row_album) {
	    require_once 'album.class.php';
	    $album = new Album();
	    $album->setId($row_album['id']);
	    $album->setActive($row_album['active']);
	    $album->setCommentcounter($row_album['commentcounter']);
	    $album->setCounter($row_album['counter']);
	    $album->setCover($row_album['cover']);
	    $album->setDescription($row_album['description']);
	    $fromuser = new User($row_album['type']);
	    $fromuser->setId($row_album['id_u']);
	    $fromuser->setThumbnail($row_album['thumbnail_u']);
	    $fromuser->setUsername($row_album['username']);	    
	    $album->setFromuser($row_album['fromuser']);
	    $album->setImagecounter($row_album['imagecounter']);
	    $album->setLatitude($row_album['latitude']);
	    $album->setLongitude($row_album['longitude']);
	    $album->setLovecounter($row_album['lovecounter']);
	    $album->setSharecounter($row_album['sharecounter']);
	    $sql = "SELECT tag
                          FROM album_tag
                         WHERE id = " . $row_album['id'];
	    $results = mysqli_query($connectionService->connection, $sql);
	    if (!$results) {
		$error = new Error();
		$error->setErrormessage($results->error);
		return $error;
	    }
	    while ($row_tag = mysqli_fetch_array($results, MYSQLI_ASSOC))
		$rows_tag[] = $row_tag;
	    $tags = array();
	    foreach ($rows_tag as $row_tag) {
		$tags[] = $row_tag;
	    }
	    $album->setTag($row_tag);
	    $album->setThumbnail($row_album['thumbnail']);
	    $album->setTitle($row_album['title']);
	    $album->setCreatedat($row_album['createdat']);
	    $album->setUpdatedat($row_album['updatedat']);
	    $albums[$row_album['id']] = $album;
	}
	$connectionService->disconnect();
	return $albums;
    }
}

function selectComments($id = null, $where = null, $order = null, $limit = null, $skip = null) {
    //TODO
}

/**
 * \fn	    selectEvents($id, $where = null, $order = null, $limit = null, $skip = null)
 * \brief   Select on Event Class
 * \param   $id, $where = null, $order = null, $limit = null, $skip = null
 * \todo    
 */
function selectEvents($id = null, $where = null, $order = null, $limit = null, $skip = null) {
    $connectionService = new ConnectionService();
    $connectionService->connect();
    if (!$connectionService->active) {
	return $connectionService->error;
    } else {
	$sql = "SELECT e.id id_e,
                           e.active,
                           e.address,
                           e.attendeecounter,
                           e.cancelledcounter,
                           e.city,
                           e.commentcounter,
                           e.counter,
                           e.cover,
                           e.description,
                           e.eventdate,
                           e.fromuser,
                           e.genre,
                           e.invitedcounter,
                           e.latitude,
                           e.longitude,
                           e.locationname,
                           e.lovecounter,
                           e.reviewcounter,
                           e.refusedcounter,
                           e.sharecounter,
                           e.thumbnail thumbnail_e,
                           e.title,
                           e.createdat,
                           e.updatedat,
                           u.id id_u,
                           u.username,
                           u.thumbnail thumbnail_u,
                           u.type
                      FROM event e, user u
                     WHERE e.id = " . $id . "
                       AND e.fromuser = u.id
		       AND e.active = 1";
	if (!is_null($where)) {
	    foreach ($where as $key => $value)
		$sql .= " AND " . $key . " = '" . $value . "'";
	}
	if (!is_null($order)) {
	    $sql .= " ORDER BY ";
	    foreach ($order as $key => $value)
		$sql .= " " . $key . " " . $value . ",";
	}
	if (!is_null($skip) && !is_null($limit)) {
	    $sql .= " LIMIT " . $skip . ", " . $limit;
	} elseif (is_null($skip) && !is_null($limit)) {
	    $sql .= " LIMIT " . $limit;
	}
	$results = mysqli_query($connectionService->connection, $sql);
	if (!$results) {
	    return $results->error;
	}
	while ($row_event = mysqli_fetch_array($results, MYSQLI_ASSOC))
	    $rows_event[] = $row_event;
	$events = array();
	foreach ($rows_event as $row_event) {
	    require_once 'event.class.php';
	    
	    $event = new Event();
	    $event->setId($row_event['id_e']);
	    $event->setActive($row_event['active']);
	    $event->setAddress($row_event['address']);
	    $event->setAttendeecounter($row_event['attendeecounter']);
	    $event->setCancelledcounter($row_event['cancelledcounter']);
	    $event->setCity($row_event['city']);
	    $event->setCommentcounter($row_event['commentcounter']);
	    $event->setCounter($row_event['counter']);
	    $event->setCover($row_event['cover']);
	    $event->setDescription($row_event['description']);
	    $event->setEventdate($row_event['eventdate']);
	    $fromuser = new User($row_event['type']);
	    $fromuser->setId($row_event['id_u']);
	    $fromuser->setThumbnail($row_event['thumbnail_u']);
	    $fromuser->setUsername($row_event['username']);
	    $event->setFromuser($row_event['fromuser']);
	    $sql = "SELECT tag
                          FROM event_genre
                         WHERE id = " . $row_event['genre'];
	    $results_genre = mysqli_query($connectionService->connection, $sql);
	    if (!$results_genre) {
		return $results_genre->error;
	    }
	    while ($row_genre = mysqli_fetch_array($results, MYSQLI_ASSOC))
		$rows_genre[] = $row_genre;
	    $genres = array();
	    foreach ($rows_genre as $row_genre) {
		$genres[] = $row_genre;
	    }
	    $event->setGenre($row_event['genre']);
	    $event->setInvitedCounter($row_event['invitedCounter']);
	    $event->setLatitude($row_event['latitude']);
	    $event->setLocationname($row_event['locationname']);
	    $event->setLongitude($row_event['longitude']);
	    $event->setLovecounter($row_event['lovecounter']);
	    $event->setRefusedcounter($row_event['refusedcounter']);
	    $event->setReviewcounter($row_event['reviewcounter']);
	    $event->setSharecounter($row_event['sharecounter']);
	    $sql = "SELECT tag
                          FROM event_tag
                         WHERE id = " . $row_event['id'];
	    $results = mysqli_query($connectionService->connection, $sql);
	    if (!$results) {
		return $results->error;
	    }
	    while ($row_tag = mysqli_fetch_array($results, MYSQLI_ASSOC))
		$rows_tag[] = $row_tag;
	    $tags = array();
	    foreach ($rows_tag as $row_tag) {
		$tags[] = $row_tag;
	    }
	    $event->setTag($tags);
	    $event->setThumbnail($row_event['thumbnail']);
	    $event->setTitle($row_event['title']);
	    $event->setCreatedat($row_event['createdat']);
	    $event->setUpdatedat($row_event['updatedat']);
	    $events[$row_event['id']] = $event;
	}
	$connectionService->disconnect();
	return $events;
    }
}

function selectImages($id = null, $where = null, $order = null, $limit = null, $skip = null) {
    //TODO
}

function selectPlaylists($id = null, $where = null, $order = null, $limit = null, $skip = null) {
    //TODO
}

function selectRecords($id = null, $where = null, $order = null, $limit = null, $skip = null) {
    //TODO
}

function selectSongs($id = null, $where = null, $order = null, $limit = null, $skip = null) {
    //TODO
}

function selectUsers($id = null, $where = null, $order = null, $limit = null, $skip = null) {
    //TODO
}

function selectVideos($id = null, $where = null, $order = null, $limit = null, $skip = null) {
    //TODO
}

?>