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
                           a.thumbnail thumbnail_a,
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
	    $album->setFromuser($fromuser);
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
	    $album->setThumbnail($row_album['thumbnail_a']);
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
	$sql = "SELECT     e.id id_e,
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
	while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
	    $rows[] = $row;
	$events = array();
	foreach ($rows as $row) {
	    require_once 'event.class.php';
	    $event = new Event();
	    $event->setId($row['id_e']);
	    $event->setActive($row['active']);
	    $event->setAddress($row['address']);
	    $event->setAttendeecounter($row['attendeecounter']);
	    $event->setCancelledcounter($row['cancelledcounter']);
	    $event->setCity($row['city']);
	    $event->setCommentcounter($row['commentcounter']);
	    $event->setCounter($row['counter']);
	    $event->setCover($row['cover']);
	    $event->setDescription($row['description']);
	    $event->setEventdate($row['eventdate']);
	    $fromuser = new User($row['type']);
	    $fromuser->setId($row['id_u']);
	    $fromuser->setThumbnail($row['thumbnail_u']);
	    $fromuser->setUsername($row['username']);
	    $event->setFromuser($fromuser);
	    $sql = "SELECT tag
                          FROM event_genre
                         WHERE id = " . $row['genre'];
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
	    $event->setGenre($genres);
	    $event->setInvitedCounter($row['invitedCounter']);
	    $event->setLatitude($row['latitude']);
	    $event->setLocationname($row['locationname']);
	    $event->setLongitude($row['longitude']);
	    $event->setLovecounter($row['lovecounter']);
	    $event->setRefusedcounter($row['refusedcounter']);
	    $event->setReviewcounter($row['reviewcounter']);
	    $event->setSharecounter($row['sharecounter']);
	    $sql = "SELECT tag
                          FROM event_tag
                         WHERE id = " . $row['id'];
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
	    $event->setThumbnail($row['thumbnail_e']);
	    $event->setTitle($row['title']);
	    $event->setCreatedat($row['createdat']);
	    $event->setUpdatedat($row['updatedat']);
	    $events[$row['id']] = $event;
	}
	$connectionService->disconnect();
	return $events;
    }
}

function selectImages($id = null, $where = null, $order = null, $limit = null, $skip = null) {
    //TODO
}

/**
 * \fn	    selectPlaylists($id = null, $where = null, $order = null, $limit = null, $skip = null)
 * \brief   Select on Playlist Class
 * \param   $id = null, $where = null, $order = null, $limit = null, $skip = null
 * \todo    
 */
function selectPlaylists($id = null, $where = null, $order = null, $limit = null, $skip = null) {
    $connectionService = new ConnectionService();
    $connectionService->connect();
    if (!$connectionService->active) {
	$this->error = $connectionService->error;
	return;
    } else {
	$sql = "SELECT     p.id id_p,
		           p.createdat,
		           p.updatedat,
		           p.active,
		           p.fromuser,
		           p.name,
		           p.songcounter,
		           p.songs,
		           p.unlimited,
			   u.id id_u,
			   u.username
		     FROM playlist p, user u
                     WHERE p.id = " . $id . "
                       AND p.fromuser = u.id
		       AND p.active = 1";
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
	while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
	    $rows[] = $row;
	$playlists = array();
	foreach ($rows as $row) {
	    require_once 'playlist.class.php';
	    $playlist = new Playlist();
	    $playlist->setId($row['id']);
	    $playlist->setActive($row['active']);
	    $playlist->setCreatedat($row['createdat']);
	    $fromuser = new User($row['type']);
	    $fromuser->setId($row['id_u']);
	    $fromuser->setUsername($row['username']);
	    $playlist->setFromuser($fromuser);
	    $playlist->setName($row['name']);
	    $playlist->setSongcounter($row['songcounter']);
	    $playlist->setUnlimited($row['unlimited']);
	    $playlist->setUpdatedat($row['updatedat']);
	    $playlists[$row['id']] = $playlist;
	}
	$connectionService->disconnect();
	return $playlists;
    }
}

/**
 * \fn	    selectPosts($id = null, $where = null, $order = null, $limit = null, $skip = null)
 * \brief   Select on Post Class
 * \param   $id = null, $where = null, $order = null, $limit = null, $skip = null
 * \todo    
 */
function selectPosts($id = null, $where = null, $order = null, $limit = null, $skip = null) {
    $connectionService = new ConnectionService();
    $connectionService->connect();
    if (!$connectionService->active) {
	$this->error = $connectionService->error;
	return;
    } else {
	$sql = "SELECT	   p.id id_p,
                           p.active,
                           p.commentcounter,
                           p.counter,
                           p.fromuser,
                           p.latitude,
                           p.longitude,
                           p.lovecounter,
                           p.sharecounter,
                           p.tag,
                           p.text,
                           p.touser,
                           p.type type_c,
                           p.vote,
                           p.createdat,
                           p.updatedat,
                           u.id id_u,
                           u.username,
                           u.thumbnail,
                           u.type type_u
                      FROM comment c, user u
                     WHERE p.fromuser = " . $id . "
                       AND p.fromuser = u.id
		       AND p.type = 'C'
                  ORDER BY createdat DESC
                     LIMIT " . $skip . ", " . $limit;
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
	while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
	    $rows[] = $row;
	$posts = array();
	foreach ($rows as $row) {
	    require_once 'comment.class.php';
	    require_once 'user.class.php';
	    $post = new Comment();
	    $post->setId($row['id_p']);
	    $post->setActive($row['active']);
	    $post->setCommentcounter($row['commentcounter']);
	    $post->setCounter($row['counter']);
	    $fromuser = new User($row['type_u']);
	    $fromuser->setId($row['id_u']);
	    $fromuser->setThumbnail($row['thumbnail_u']);
	    $fromuser->setUsername($row['username']);
	    $post->setFromuser($fromuser);
	    $post->setLatitude($row['latitude']);
	    $post->setLongitude($row['longitude']);
	    $post->setLovecounter($row['lovecounter']);
	    $post->setSharecounter($row['sharecounter']);
	    $sql = "SELECT tag
                          FROM comment_tag
                         WHERE id = " . $row['id_c'];
	    $results = mysqli_query($connectionService->connection, $sql);
	    while ($row_tag = mysqli_fetch_array($results, MYSQLI_ASSOC))
		$rows_tag[] = $row_tag;
	    $tags = array();
	    foreach ($rows_tag as $row_tag) {
		$tags[] = $row_tag;
	    }
	    $post->setTag($tags);
	    $post->setText($row['text']);
	    $post->setTitle($row['title']);
	    $post->setTouser($row['touser']);
	    $post->setType($row['type_c']);
	    $post->setVote($row['vote']);
	    $post->setCreatedat($row['createdat']);
	    $post->setUpdatedat($row['updatedat']);
	    $posts[$row['id']] = $post;
	}
	$connectionService->disconnect();
	if (!$results) {
	    return;
	} else {
	    return $posts;
	}
    }
}

/**
 * \fn	    selectRecords($id = null, $where = null, $order = null, $limit = null, $skip = null)
 * \brief   Select on Post Class
 * \param   $id = null, $where = null, $order = null, $limit = null, $skip = null
 * \todo    
 */
function selectRecords($id = null, $where = null, $order = null, $limit = null, $skip = null) {
    $connectionService = new ConnectionService();
    $connectionService->connect();
    if (!$connectionService->active) {
	$this->error = $connectionService->error;
	return;
    } else {
	$sql = "SELECT r.id id_r,
                           r.active,
                           r.buylink,
                           r.city,
                           r.commentcounter,
                           r.counter,
                           r.cover,
                           r.description,
                           r.duration,
                           r.fromuser,
                           r.genre,
                           r.label,
                           r.latitude,
                           r.longitude,
                           r.lovecounter,
                           r.reviewCounter,
                           r.sharecounter,
                           r.songCounter,
                           r.thumbnail,
                           r.title,
                           r.tracklist,
                           r.year,
                           r.createdat,
                           r.updatedat,
                           u.id id_u,
                           u.username,
                           u.thumbnail thumbnail_u,
                           u.type
                      FROM record r, user u
                     WHERE r.id = " . $id . "
                       AND r.fromuser = u.id
		       AND r.active = 1";
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
	while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
	    $rows[] = $row;
	$records = array();
	foreach ($rows as $row) {
	    require_once 'record.class.php';
	    $record = new Record();
	    $record->setId($row['id']);
	    $record->setActive($row['active']);
	    $record->setBuylink($row['buylink']);
	    $record->setCity($row['city']);
	    $record->setCommentcounter($row['commentcounter']);
	    $record->setCounter($row['counter']);
	    $record->setCover($row['cover']);
	    $record->setDescription($row['description']);
	    $record->setDuration($row['duration']);
	    $fromuser = new User($row['type']);
	    $fromuser->setId($row['id_u']);
	    $fromuser->setThumbnail($row['thumbnail_u']);
	    $fromuser->setUsername($row['username']);
	    $record->setFromuser($fromuser);
	    $record->setGenre($row['genre']);
	    $record->setLabel($row['label']);
	    $record->setLatitude($row['latitude']);
	    $record->setLongitude($row['longitude']);
	    $record->setLovecounter($row['lovecounter']);
	    $record->setReviewCounter($row['reviewCounter']);
	    $record->setSharecounter($row['sharecounter']);
	    $record->setSongCounter($row['songCounter']);
	    $record->setThumbnail($row['thumbnail']);
	    $record->setTitle($row['title']);
	    $record->setTracklist($row['tracklist']);
	    $record->setYear($row['year']);
	    $record->setCreatedat($row['createdat']);
	    $record->setUpdatedat($row['updatedat']);
	    $records[$row['id']] = $record;
	}
	$connectionService->disconnect();
	if (!$results) {
	    return;
	} else {
	    return $records;
	}
    }
}

/**
 * \fn	    selectSongs($id = null, $where = null, $order = null, $limit = null, $skip = null)
 * \brief   Select on Post Class
 * \param   $id = null, $where = null, $order = null, $limit = null, $skip = null
 * \todo    
 */
function selectSongs($id = null, $where = null, $order = null, $limit = null, $skip = null) {
    $connectionService = new ConnectionService();
    $connectionService->connect();
    if (!$connectionService->active) {
	$this->error = $connectionService->error;
	return;
    } else {
	$sql = "SELECT     s.id id_s,
		               s.createdat,
		               s.updatedat,
		               s.active,
		               s.commentcounter,
		               s.counter,
		               s.duration,
		               s.fromuser,
		               s.genre,
		               s.latitude,
		               s.longitude,
		               s.lovecounter,
		               s.path,
		               s.position,
		               s.record,
		               s.sharecounter,
		               s.title title_s,
			       u.id id_u,
			       u.thumbnail thumbnail_u,
			       u.type,
			       u.username,
			       r.id id_r,
			       r.thumbnail thumbnail_r,
			       r.title title_r
                 FROM song s, user u, record r,
                WHERE s.id  = " . $id . "
                  AND s.fromuser = u.id
                LIMIT " . 0 . ", " . 20;
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
	while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
	    $rows[] = $row;
	$songs = array();
	foreach ($rows as $row) {
	    require_once 'record.class.php';
	    require_once 'song.class.php';
	    require_once 'user.class.php';
	    $song = new Song();
	    $song->setId($row['id']);
	    $song->setActive($row['active']);
	    $song->setCommentcounter($row['commentcounter']);
	    $song->setCounter($row['counter']);
	    $song->setCreatedat($row['createdat']);
	    $song->setDuration($row['duration']);
	    $fromuser = new User($row['type']);
	    $fromuser->setId($row['id_u']);
	    $fromuser->setThumbnail($row['thumbnail_u']);
	    $fromuser->setType($row['type']);
	    $fromuser->setUsername($row['username']);
	    $song->setFromuser($fromuser);
	    $song->setGenre($row['genre']);
	    $song->setLatitude($row['latitude']);
	    $song->setLongitude($row['longitude']);
	    $song->getLovecounter($row['lovecounter']);
	    $song->setPath($row['path']);
	    $song->setPosition($row['position']);
	    $record = new Record();
	    $record->setId($row['id_r']);
	    $record->setThumbnail($row['thumbnail_r']);
	    $record->setTitle($row['title_r']);
	    $song->setSharecounter($row['sharecounter']);
	    $song->setTitle($row['title_s']);
	    $song->setUpdatedat($row['updatedat']);
	    $songs[$row['id']] = $song;
	}
	$connectionService->disconnect();
	return $songs;
    }
}

/**
 * \fn	    selectUsers($id = null, $where = null, $order = null, $limit = null, $skip = null)
 * \brief   Select on Post Class
 * \param   $id = null, $where = null, $order = null, $limit = null, $skip = null
 * \todo    
 */
function selectUsers($id = null, $where = null, $order = null, $limit = null, $skip = null) {
    $connectionService = new ConnectionService();
    $connectionService->connect();
    if (!$connectionService->active) {
	$this->error = $connectionService->error;
	return;
    } else {
	$sql = "SELECT     id,
                           active,
                           address,
                           avatar,
                           background,
                           birthday,
                           city,
                           collaborationcounter,
                           country,
                           createdat,
                           description,
                           email,
                           facebookid,
                           facebookpage,
                           firstname,
                           followerscounter,
                           followingcounter,
                           friendshipcounter,
                           googlepluspage,
                           jammercounter,
                           jammertype,
                           lastname,
                           level,
                           levelvalue,
                           latitude,
                           longitude,
                           members,
                           premium,
                           premiumexpirationdate,
                           settings,
                           sex,
                           thumbnail,
                           twitterpage,
                           type,
                           updatedat,
                           username,
                           venuecounter,
                           website,
                           youtubechannel
                      FROM user
                     WHERE id = " . $id;
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
	while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
	    $rows[] = $row;
	$users = array();
	foreach ($rows as $row) {
	    require_once 'user.class.php';
	    $user = new User($row['type']);
	    $user->setId($row['id']);
	    $user->setActive($row['active']);
	    $user->setAddress($row['address']);
	    $user->setAvatar($row['avatar']);
	    $user->setBackground($row['background']);
	    $user->setBirthday($row['birthday']);
	    $user->setCity($row['city']);
	    $user->setCollaborationcounter($row['collaborationcounter']);
	    $user->setCountry($row['country']);
	    $user->setCreatedat($row['createdat']);
	    $user->setDescription($row['description']);
	    $user->setEmail($row['email']);
	    $user->setFacebookId($row['facebookid']);
	    $user->setFbPage($row['facebookpage']);
	    $user->setFirstname($row['firstname']);
	    $user->setFollowerscounter($row['followerscounter']);
	    $user->setFollowingcounter($row['followingcounter']);
	    $user->setFriendshipcounter($row['friendshipcounter']);
	    $user->setGooglepluspage($row['googlepluspage']);
	    $user->setJammercounter($row['jammercounter']);
	    $user->setJammertype($row['jammertype']);
	    $user->setLastname($row['lastname']);
	    $user->setLevel($row['level']);
	    $user->setLevelvalue($row['levelvalue']);
	    $user->setLatitude($row['latitude']);
	    $user->setLongitude($row['longitude']);
	    $user->setMembers($row['members']);
	    $user->setPremium($row['premium']);
	    $user->setPremiumexpirationdate($row['premiumexpirationdate']);
	    $user->setSettings($row['settings']);
	    $user->setSex($row['sex']);
	    $user->setThumbnail($row['thumbnail']);
	    $user->setTwitterpage($row['twitterpage']);
	    $user->setUpdatedat($row['updatedat']);
	    $user->setUsername($row['username']);
	    $user->setVenuecounter($row['venuecounter']);
	    $user->setWebsite($row['website']);
	    $user->setYoutubechannel($row['youtubechannel']);
	    $users[$row['id']] = $user;
	}
	$connectionService->disconnect();
	return $users;
    }
}

function selectVideos($id = null, $where = null, $order = null, $limit = null, $skip = null) {
    $connectionService = new ConnectionService();
    $connectionService->connect();
    if (!$connectionService->active) {
	$this->error = $connectionService->error;
	return;
    } else {
	$sql = "SELECT         v.id id_v,
		               v.createdat,
		               v.updatedat,
		               v.active,
			       v.author,
		               v.counter,
			       v.cover,
		               v.duration,
		               v.fromuser,
		               v.genre,
		               v.lovecounter,
			       v.thumbnail thumbnail_v,
			       v.title title_v,
			       v.URL,
			       u.id id_u,
			       u.thumbnail thumbnail_u,
			       u.type,
			       u.username,
                 FROM video v, user u
                WHERE v.id  = " . $id . "
                  AND v.fromuser = u.id
                LIMIT " . $skip . ", " . $limit;
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
	while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
	    $rows[] = $row;
	$videos = array();
	foreach ($rows as $row) {
	    require_once 'video.class.php';
	    $video = new Video();
	    $video->setId($row['id_v']);
	    $video->setActive($row['active']);
	    $video->setAuthor($row['author']);
	    $video->setCounter($row['counter']);
	    $video->setCover($row['cover']);
	    $video->setCreatedat($row['createdat']);
	    $video->setDescription($row['description']);
	    $video->setDuration($row['duration']);
	    $fromuser = new User($row['type']);
	    $fromuser->setId($row['id_u']);
	    $fromuser->setThumbnail($row['thumbnail_u']);
	    $fromuser->setType($row['type']);
	    $fromuser->setUsername($row['username']);
	    $video->setFromuser($fromuser);
	    $video->setLovecounter($row['lovecounter']);
	    $sql = "SELECT tag
                          FROM comment_tag
                         WHERE id = " . $row['id_c'];
	    $results = mysqli_query($connectionService->connection, $sql);
	    while ($row_tag = mysqli_fetch_array($results, MYSQLI_ASSOC))
		$rows_tag[] = $row_tag;
	    $tags = array();
	    foreach ($rows_tag as $row_tag) {
		$tags[] = $row_tag;
	    }
	    $video->setTag($tags);
	    $video->setThumbnail($row['thumbnail_v']);
	    $video->setTitle($row['title_v']);
	    $video->setURL($row['URL']);
	    $video->setUpdatedat($row['updatedat']);
	    $videos[$row['id']] = $video;
	}
	$connectionService->disconnect();
	return $videos;
    }
}

?>