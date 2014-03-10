<?php

/* ! \par		Info Generali:
 *  \author		Luca Gianneschi
 *  \version		0.3
 *  \date		2013
 *  \copyright		Jamyourself.com 2013
 *  \par		Info Classe:
 *  \brief		Servizio  DB
 *  \details		Servizio esecuzione principali query
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
 * \fn	    existsRelation($fromNodeType, $fromNodeId, $toNodeType, $toNodeId, $relationType)
 * \brief   Check if a relation exist between 2 nodes
 * \param   $fromNodeType, $fromNodeId, $toNodeType, $toNodeId, $relationType
 * \todo
 */
function existsRelation($connection, $fromNodeType, $fromNodeId, $toNodeType, $toNodeId, $relationType) {
    $query = '
	MATCH (n:' . $fromNodeType . ')-[r:' . $relationType . ']->(m:' . $toNodeType . ')
	WHERE n.id = {fromNodeId} AND m.id = {toNodeId}
	RETURN count(n)
	';
    $params = array(
	'fromNodeId' => $fromNodeId,
	'toNodeId' => $toNodeId
    );
    $res = $connection->curl($query, $params);
    if ($res === false) {
	return false;
    } else {
	if ($connection->getAutocommit()) {
	    return $res['data'][0][0];
	} else {
	    return $res['results'][0]['data'][0]['row'][0];
	}
    }
}

/**
 * \fn	    getRelatedNodes($connection, $fromNodeType, $fromNodeId, $toNodeType, $relationType)
 * \brief   Get list of nodes in relation with the first node
 * \param   $fromNodeType, $fromNodeId, $toNodeType, $relationType
 * \todo
 */
function getRelatedNodes($connection, $fromNodeType, $fromNodeId, $toNodeType, $relationType) {
    $query = '
	MATCH (n:' . $fromNodeType . ')-[r:' . $relationType . ']->(m:' . $toNodeType . ')
	WHERE n.id = {fromNodeId}
	RETURN m
	ORDER BY r.createdat DESC
	';
    $params = array(
	'fromNodeId' => $fromNodeId
    );
    $res = $connection->curl($query, $params);
    if ($res === false) {
	return false;
    } else {
	$relatedNodes = array();
	if ($connection->getAutocommit()) {
	    foreach ($res['data'] as $value) {
		if ($fromNodeId != $value[0]['data']['id']) {
		    $relatedNodes[] = $value[0]['data']['id'];
		}
	    }
	} else {
	    foreach ($res['results'][0]['data'] as $value) {
		if ($fromNodeId != $value['row'][0]['id']) {
		    $relatedNodes[] = $value['row'][0]['id'];
		}
	    }
	}
	return $relatedNodes;
    }
    $connectionService = new ConnectionService();
    $res = $connectionService->curl($query, $params);
    $list = array();
    if (is_array($res['data'])) {
	foreach ($res['data'] as $value) {
	    if ($fromNodeId != $value[0]['data']['id']) {
		$list[] = $value[0]['data']['id'];
	    }
	}
    }
    return $list;
}

/**
 * \fn	    query($sql)
 * \brief   Execute generic query
 * \param   $ql string for query
 * \todo
 */
function query($connection, $sql) {
    $results = mysqli_query($connection, $sql);
    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
	$rows[] = $row;
    return $rows;
}

/**
 * \fn	    selectAlbums($connection, $id, $where = null, $order = null, $limit = null, $skip = null)
 * \brief   Select on Album Class
 * \param   $id = null, $where = null, $order = null, $limit = null, $skip = null
 * \todo
 */
function selectAlbums($connection, $id = null, $where = null, $order = null, $limit = null, $skip = null) {
    $sql = "SELECT a.id id_a,
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
              FROM album a,
                   user u
             WHERE a.active = 1
               AND a.fromuser = u.id";
    if (!is_null($id)) {
	$sql .= " AND a.id = " . $id . "";
    }
    if (!is_null($where)) {
	foreach ($where as $key => $value) {
	    if (is_array($value)) {
		$inSql = '';
		foreach ($value as $val) {
		    $inSql .= "'" . $val . "',";
		}
		$inSql = substr($inSql, 0, strlen($inSql) - 1);
		$sql .= " AND a." . $key . " IN (" . $inSql . ")";
	    } else {
		$sql .= " AND a." . $key . " = '" . $value . "'";
	    }
	}
    }
    if (!is_null($order)) {
	$sql .= " ORDER BY ";
	$last = end($order);
	foreach ($order as $key => $value) {
	    if ($last == $value)
		$sql .= " a." . $key . " " . $value;
	    else
		$sql .= " a." . $key . " " . $value . ",";
	}
    }
    if (!is_null($skip) && !is_null($limit)) {
	$sql .= " LIMIT " . $skip . ", " . $limit;
    } elseif (is_null($skip) && !is_null($limit)) {
	$sql .= " LIMIT " . $limit;
    }
    $results = mysqli_query($connection, $sql);
    if (!$results) {
	jamLog(__FILE__, __LINE__, 'Unable to execute query');
	return false;
    }
    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
	$rows_album[] = $row;
    $albums = array();
    foreach ($rows_album as $row) {
	require_once CLASSES_DIR . 'album.class.php';
	$album = new Album();
	$album->setId($row['id_a']);
	$album->setActive($row['active']);
	$album->setCommentcounter($row['commentcounter']);
	$album->setCounter($row['counter']);
	$album->setCover($row['cover']);
	$album->setDescription($row['description']);
	require_once CLASSES_DIR . 'user.class.php';
	$fromuser = new User();
	$fromuser->setId($row['id_u']);
	$fromuser->setThumbnail($row['thumbnail_u']);
	$fromuser->setUsername($row['username']);
	$fromuser->setType($row['type']);
	$album->setFromuser($fromuser);
	$album->setImagecounter($row['imagecounter']);
	$album->setLatitude($row['latitude']);
	$album->setLongitude($row['longitude']);
	$album->setLovecounter($row['lovecounter']);
	$album->setSharecounter($row['sharecounter']);
	$sql = "SELECT tag
		  FROM album_tag
		 WHERE id = " . $row['id_a'];
	$results = mysqli_query($connection, $sql);
	if (!$results) {
	    jamLog(__FILE__, __LINE__, 'Unable to execute query');
	    return false;
	}
	$tags = array();
	$rows_tag = array();
	while ($row_tag = mysqli_fetch_array($results, MYSQLI_ASSOC))
	    $rows_tag[] = $row_tag;
	foreach ($rows_tag as $row_tag) {
	    $tags[] = $row_tag;
	}
	$album->setTag($tags);
	$album->setThumbnail($row['thumbnail_a']);
	$album->setTitle($row['title']);
	$album->setCreatedat(new DateTime($row['createdat']));
	$album->setUpdatedat(new DateTime($row['updatedat']));
	$albums[$row['id_a']] = $album;
    }
    return $albums;
}

/**
 * \fn	    selectComments($connection, $id = null, $where = null, $order = null, $limit = null, $skip = null)
 * \brief   Select on Event Class
 * \param   $id, $where = null, $order = null, $limit = null, $skip = null
 * \todo    prendere soltanto i parametri di interesse in base a confronto con box esistente
 */
function selectComments($connection, $id = null, $where = null, $order = null, $limit = null, $skip = null) {
    $sql = "SELECT cmt.id id_cmt,
                   cmt.active active_cmt,
                   cmt.createdat createdat_cmt,
                   cmt.updatedat updatedat_cmt,
                   cmt.album album_cmt,
                   cmt.comment comment_cmt,
                   cmt.commentcounter commentcounter_cmt,
                   cmt.counter counter_cmt,
                   cmt.event event_cmt,
                   cmt.fromuser fromuser_cmt,
                   cmt.image image_cmt,
                   cmt.latitude latitude_cmt,
                   cmt.longitude longitude_cmt,
                   cmt.lovecounter lovecounter_cmt,
                   cmt.record record_cmt,
                   cmt.sharecounter sharecounter_cmt,
                   cmt.text text_cmt,
                   cmt.title title_cmt,
                   cmt.touser touser_cmt,
                   cmt.type type_cmt,
                   cmt.vote vote_cmt,
                   a.id id_a,
                   a.createdat createdat_a,
                   a.updatedat updatedat_a,
                   a.active active_a,
                   a.commentcounter commentcounter_a,
                   a.counter counter_a,
                   a.cover cover_a,
                   a.description description_a,
                   a.fromuser fromuser_a,
                   a.imagecounter,
                   a.latitude latitude_a,
                   a.longitude longitude_a,
                   a.lovecounter lovecounter_a,
                   a.sharecounter sharecounter_a,
                   a.thumbnail thumbnail_a,
                   a.title title_a,
                   c.id id_cmt,
                   c.active active_c,
                   c.createdat createdat_c,
                   c.updatedat updatedat_c,
                   c.album album_c,
                   c.comment comment_c,
                   c.commentcounter commentcounter_c,
                   c.counter counter_c,
                   c.event event_c,
                   c.fromuser fromuser_c,
                   c.image image_c,
                   c.latitude latitude_c,
                   c.longitude longitude_c,
                   c.lovecounter lovecounter_c,
                   c.record record_c,
                   c.sharecounter sharecounter_c,
                   c.text text_c,
                   c.title title_c,
                   c.touser touser_c,
                   c.type type_c,
                   c.vote vote_c,
                   e.id id_e,
                   e.createdat createdat_e,
                   e.updatedat updatedat_e,
                   e.active active_e,
                   e.address,
                   e.attendeecounter,
                   e.cancelledcounter,
                   e.city,
                   e.commentcounter commentcounter_e,
                   e.counter counter_e,
                   e.cover cover_e,
                   e.description description_e,
                   e.eventdate,
                   e.fromuser fromuser_e,
                   e.invitedcounter,
                   e.latitude latitude_e,
                   e.longitude longitude_e,
                   e.locationname,
                   e.lovecounter lovecounter_e,
                   e.reviewcounter reviewcounter_e,
                   e.refusedcounter,
                   e.sharecounter sharecounter_e,
                   e.thumbnail thumbnail_e,
                   e.title title_e,
                   i.id id_i,
	           i.createdat createdat_i,
                   i.updatedat updatedat_i,
                   i.active active_i,
                   i.commentcounter commentcounter_i,
                   i.counter counter_i,
                   i.fromuser fromuser_i,
                   i.latitude latitude_i,
                   i.longitude longitude_i,
                   i.lovecounter lovecounter_i,
		   i.path path_i,
                   i.sharecounter sharecounter_i,
	           i.thumbnail thumbnail_i,
                   r.id id_r,
                   r.createdat createdat_r,
                   r.updatedat updatedat_r,
                   r.active active_r,
                   r.buylink,
                   r.city,
                   r.commentcounter commentcounter_r,
                   r.counter counter_r,
                   r.cover cover_r,
                   r.description description_r,
                   r.duration duration_r,
                   r.fromuser fromuser_r,
                   r.label,
                   r.latitude latitude_r,
                   r.longitude longitude_r,
                   r.lovecounter lovecounter_r,
                   r.reviewCounter reviewCounter_r,
                   r.sharecounter sharecounter_r,
                   r.songCounter,
                   r.thumbnail thumbnail_r,
                   r.title title_r,
                   r.year,
                   s.id id_s,
		   s.createdat createdat_s,
		   s.updatedat updatedat_s,
		   s.active active_s,
		   s.commentcounter commentcounter_s,
		   s.counter counter_s,
		   s.duration duration_s,
		   s.fromuser fromuser_s,
		   s.latitude latitude_s,
		   s.longitude longitude_s,
		   s.lovecounter lovecounter_s,
		   s.path path_s,
		   s.position,
		   s.record record_s,
		   s.sharecounter sharecounter_s,
		   s.title title_s,
           v.id id_v,
		   v.createdat createdat_v,
		   v.updatedat updatedat_v,
		   v.active active_v,
		   v.author,
		   v.counter counter_v,
	       v.cover cover_v,
		   v.duration duration_v,
		   v.fromuser fromuser_v,
		   v.lovecounter lovecounter_v,
		   v.thumbnail thumbnail_v,
		   v.title title_v,
		   v.URL,       
                   fu.id id_fu,
                   fu.username username_fu,
                   fu.thumbnail thumbnail_fu,
                   fu.type type_fu,
                   tu.id id_tu,
                   tu.username username_tu,
                   tu.thumbnail thumbnail_tu,
                   tu.type type_tu
                   FROM comment cmt
                   LEFT JOIN album a   ON (a.id = cmt.album)
                   LEFT JOIN comment c ON (c.id = cmt.comment)
                   LEFT JOIN event e   ON (e.id = cmt.event)
                   LEFT JOIN image i   ON (i.id = cmt.image)
                   LEFT JOIN record r  ON (r.id = cmt.record)		   
	           	   LEFT JOIN song s  ON (s.id = cmt.song)		   
                   LEFT JOIN user fu   ON (fu.id = cmt.fromuser)
                   LEFT JOIN user tu   ON (tu.id = cmt.touser)
                   LEFT JOIN video v   ON (v.id = cmt.video)		  
             WHERE cmt.active = 1";
    if (!is_null($id)) {
	$sql .= " AND c.id = " . $id . "";
    }
    if (!is_null($where)) {
	foreach ($where as $key => $value) {
	    if (is_array($value)) {
		$inSql = '';
		foreach ($value as $val) {
		    $inSql .= "'" . $val . "',";
		}
		$inSql = substr($inSql, 0, strlen($inSql) - 1);
		$sql .= " AND cmt." . $key . " IN (" . $inSql . ")";
	    } else {
		$sql .= " AND cmt." . $key . " = '" . $value . "'";
	    }
	}
    }
    if (!is_null($order)) {
	$sql .= " ORDER BY ";
	$last = end($order);
	foreach ($order as $key => $value) {
	    if ($last == $value)
		$sql .= " cmt." . $key . " " . $value;
	    else
		$sql .= " cmt." . $key . " " . $value . ",";
	}
    }
    if (!is_null($skip) && !is_null($limit)) {
	$sql .= " LIMIT " . $skip . ", " . $limit;
    } elseif (is_null($skip) && !is_null($limit)) {
	$sql .= " LIMIT " . $limit;
    }
    $results = mysqli_query($connection, $sql);
    if (!$results) {
	jamLog(__FILE__, __LINE__, 'Unable to execute query');
	return false;
    }
    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
	$rows[] = $row;
    $comment = array();
    if (!is_array($rows))
	return $comment;
    foreach ($rows as $row) {
	require_once CLASSES_DIR . 'comment.class.php';
	require_once CLASSES_DIR . 'user.class.php';
	$comment = new Comment();
	$comment->setId($row['id_cmt']);
	$comment->setActive($row['active_cmt']);
	require_once CLASSES_DIR . 'album.class.php';
	$album = new Album();
	$album->setId($row['id_a']);
	$album->setActive($row['active_a']);
	$album->setCommentcounter($row['commentcounter_a']);
	$album->setCounter($row['counter_a']);
	$album->setCover($row['cover_a']);
	$album->setDescription($row['description_a']);
	$album->setImagecounter($row['imagecounter_a']);
	$album->setLatitude($row['latitude_a']);
	$album->setLongitude($row['longitude_a']);
	$album->setLovecounter($row['lovecounter_a']);
	$album->setSharecounter($row['sharecounter_a']);
	$sql = "SELECT tag
		  FROM album_tag
		 WHERE id = " . $row['id_a'];
	$results_album_tag = mysqli_query($connection, $sql);
	if (!$results_album_tag) {
	    jamLog(__FILE__, __LINE__, 'Unable to execute query');
	    return false;
	}
	$tags_album = array();
	$rows_tag = array();
	while ($row_tag = mysqli_fetch_array($results_album_tag, MYSQLI_ASSOC))
	    $rows_tag[] = $row_tag;
	foreach ($rows_tag as $row_tag) {
	    $tags_album[] = $row_tag;
	}
	$album->setTag($tags_album);
	$album->setThumbnail($row['thumbnail_a']);
	$album->setTitle($row['title']);
	$album->setCreatedat($row['createdat_a']);
	$album->setUpdatedat($row['updatedat_a']);
	$comment->setAlbum($album);
	$comment->setComment($comment);
	$comment->setCommentcounter($row['commentcounter_cmt']);
	$comment->setCounter($row['counter_cmt']);
	$comment->setCreatedat($row['createdat_cmt']);
	require_once CLASSES_DIR . 'event.class.php';
	$event = new Event();
	$event->setId($row['id_e']);
	$event->setCreatedat($row['createdat_e']);
	$event->setUpdatedat($row['updatedat_e']);
	$event->setActive($row['active_e']);
	$event->setAddress($row['address']);
	$event->setAttendeecounter($row['attendeecounter']);
	$event->setCancelledcounter($row['cancelledcounter']);
	$event->setCity($row['city_e']);
	$event->setCommentcounter($row['commentcounter_e']);
	$event->setCounter($row['counter_e']);
	$event->setCover($row['cover_e']);
	$event->setDescription($row['description_e']);
	$event->setEventdate($row['eventdate']);
	$sql = "SELECT genre
		  FROM event_genre
		 WHERE id = " . $row['genre_e'];
	$results_genre_event = mysqli_query($connection, $sql);
	if (!$results_genre_event) {
	    jamLog(__FILE__, __LINE__, 'Unable to execute query');
	    return false;
	}
	$genres = array();
	$rows_genre = array();
	while ($row_genre = mysqli_fetch_array($results_genre_event, MYSQLI_ASSOC))
	    $rows_genre[] = $row_genre;
	foreach ($rows_genre as $row_genre) {
	    $genres[] = $row_genre;
	}
	$event->setGenre($genres);
	$event->setInvitedCounter($row['invitedCounter']);
	$event->setLatitude($row['latitude_e']);
	$event->setLocationname($row['locationname']);
	$event->setLongitude($row['longitude_e']);
	$event->setLovecounter($row['lovecounter_e']);
	$event->setRefusedcounter($row['refusedcounter']);
	$event->setReviewcounter($row['reviewcounter_e']);
	$event->setSharecounter($row['sharecounter_e']);
	$sql = "SELECT tag
		  FROM event_tag
		 WHERE id = " . $row['id_e'];
	$results_tag_event = mysqli_query($connection, $sql);
	if (!$results_tag_event) {
	    jamLog(__FILE__, __LINE__, 'Unable to execute query');
	    return false;
	}
	$tags_event = array();
	$rows_tag_event = array();
	while ($row_tag_event = mysqli_fetch_array($results_tag_event, MYSQLI_ASSOC))
	    $rows_tag_event[] = $row_tag_event;
	foreach ($rows_tag_event as $row_tag_event) {
	    $tags_event[] = $row_tag_event;
	}
	$event->setTag($tags_event);
	$event->setThumbnail($row['thumbnail_e']);
	$event->setTitle($row['title_e']);
	$comment->setEvent($event);
	$fromuser = new User();
	$fromuser->setId($row['id_fu']);
	$fromuser->setThumbnail($row['thumbnail_fu']);
	$fromuser->setUsername($row['username_fu']);
	$fromuser->setType($row['type_fu']);
	$comment->setFromuser($fromuser);
	require_once CLASSES_DIR . 'album.class.php';
	require_once CLASSES_DIR . 'image.class.php';
	$image = new Image();
	$image->setId($row['id_i']);
	$image->setCreatedat($row['createdat_i']);
	$image->setUpdatedat($row['updatedat_i']);
	$image->setActive($row['active_i']);
	$albumImage = new Album();
	$albumImage->setTitle($row['title_ai']);
	$albumImage->setId($row['id_ai']);
	$image->setAlbum($albumImage);
	$image->setCommentcounter($row['commentcounter_i']);
	$image->setCounter($row['counter_i']);
	$image->setLatitude($row['latitude_i']);
	$image->setLongitude($row['longitude_i']);
	$image->setLovecounter($row['lovecounter_i']);
	$image->setPath($row['path_i']);
	$image->setSharecounter($row['sharecounter_i']);
	$sql = "SELECT tag
		  FROM image_tag
		 WHERE id = " . $row['id_ai'];
	$results_image_tag = mysqli_query($connection, $sql);
	if (!$results_image_tag) {
	    jamLog(__FILE__, __LINE__, 'Unable to execute query');
	    return false;
	}
	$tags_image = array();
	$rows_tag_image = array();
	while ($row_tag_image = mysqli_fetch_array($results_image_tag, MYSQLI_ASSOC))
	    $rows_tag_image[] = $row_tag_image;
	foreach ($rows_tag_image as $row_tag_image) {
	    $tags_image[] = $row_tag_image;
	}
	$image->setTag($tags_image);
	$image->setThumbnail($row['thumbnail_i']);
	$comment->setImage($image);
	$comment->setLatitude($row['latitude_cmt']);
	$comment->setLovecounter($row['lovecounter_cmt']);
	require_once CLASSES_DIR . 'record.class.php';
	$record = new Record();
	$record->setId($row['id_r']);
	$record->setCreatedat($row['createdat_r']);
	$record->setUpdatedat($row['updatedat_r']);
	$record->setActive($row['active_r']);
	$record->setBuylink($row['buylink']);
	$record->setCity($row['city']);
	$record->setCommentcounter($row['commentcounter_r']);
	$record->setCounter($row['counter_r']);
	$record->setCover($row['cover_r']);
	$record->setDescription($row['description_r']);
	$record->setDuration($row['duration_r']);
	$sql = "SELECT genre
		  FROM record_genre
		 WHERE id = " . $row['genre_r'];
	$results_genre_record = mysqli_query($connection, $sql);
	if (!$results_genre_record) {
	    jamLog(__FILE__, __LINE__, 'Unable to execute query');
	    return false;
	}
	$genres_record = array();
	$rows_genres_record = array();
	while ($row_genres_record = mysqli_fetch_array($results_genre_record, MYSQLI_ASSOC))
	    $rows_genres_record[] = $row_genres_record;
	foreach ($rows_record_event as $row_genres_record) {
	    $genres_record[] = $row_genres_record;
	}
	$record->setGenre($genres_record);
	$record->setLabel($row['label']);
	$record->setLatitude($row['latitude_r']);
	$record->setLongitude($row['longitude_r']);
	$record->setLovecounter($row['lovecounter_r']);
	$record->setReviewCounter($row['reviewCounter_r']);
	$record->setSharecounter($row['sharecounter_r']);
	$record->setSongCounter($row['songCounter_r']);
	$record->setThumbnail($row['thumbnail_r']);
	$record->setTitle($row['title_r']);
	$record->setYear($row['year_r']);
	$comment->setRecord($record);
	$comment->setSharecounter($row['sharecounter_cmt']);
	require_once CLASSES_DIR . 'record.class.php';
	require_once CLASSES_DIR . 'song.class.php';
	$song = new Song();
	$song->setId($row['id_s']);
	$song->setActive($row['active_s']);
	$song->setCommentcounter($row['commentcounter_s']);
	$song->setCounter($row['counter_s']);
	$song->setCreatedat($row['createdat_s']);
	$song->setDuration($row['duration_s']);
	$song->setGenre($row['genre_s']);
	$song->setLatitude($row['latitude_s']);
	$song->setLongitude($row['longitude_s']);
	$song->getLovecounter($row['lovecounter_s']);
	$song->setPath($row['path_s']);
	$song->setPosition($row['position_s']);
	$song->setSharecounter($row['sharecounter']);
	$song->setTitle($row['title_s']);
	$song->setUpdatedat(new DateTime($row['updatedat']));
	$sql = "SELECT tag
		  FROM song_tag
		 WHERE id = " . $row['id_s'];
	$results_song_tag = mysqli_query($connection, $sql);
	if (!$results_song_tag) {
	    jamLog(__FILE__, __LINE__, 'Unable to execute query');
	    return false;
	}
	$tags_song = array();
	$rows_tag_song = array();
	while ($row_tag_song = mysqli_fetch_array($results_song_tag, MYSQLI_ASSOC))
	    $rows_tag_song[] = $row_tag_song;
	foreach ($rows_tag_song as $row_tag_song) {
	    $tags_song[] = $row_tag_song;
	}
	$comment->setSong($song);
	$sql = "SELECT tag
		  FROM comment_tag
		 WHERE id = " . $row['id_cmt'];
	$results_comment_tag = mysqli_query($connection, $sql);
	if (!$results_comment_tag) {
	    jamLog(__FILE__, __LINE__, 'Unable to execute query');
	    return false;
	}
	$tags_comment = array();
	$rows_tag_comment = array();
	while ($row_tag_comment = mysqli_fetch_array($results_comment_tag, MYSQLI_ASSOC))
	    $rows_tag_comment[] = $row_tag_comment;
	foreach ($rows_tag_comment as $row_tag_comment) {
	    $tags_comment[] = $row_tag_comment;
	}
	$comment->setTag($tags_comment);
	$comment->setText($row['text_cmt']);
	$comment->setTitle($row['title_cmt']);
	$comment->setUpdatedat($row['updatedat_cmt']);
	$touser = new User();
	$touser->setId($row['id_tu']);
	$touser->setThumbnail($row['thumbnail_tu']);
	$touser->setUsername($row['username_tu']);
	$touser->setType($row['type_tu']);
	$comment->setTouser($touser);
	require_once CLASSES_DIR . 'video.class.php';
	$video = new Video();
	$video->setId($row['id_v']);
	$video->setActive($row['active']);
	$video->setAuthor($row['author']);
	$video->setCounter($row['counter_v']);
	$video->setCover($row['cover_v']);
	$video->setCreatedat($row['createdat_v']);
	$video->setDescription($row['description_v']);
	$video->setDuration($row['duration_v']);
	$video->setLovecounter($row['lovecounter_v']);
	$sql = "SELECT tag
		  FROM video_tag
		 WHERE id = " . $row['id_v'];
	$results_video_tag = mysqli_query($connection, $sql);
	if (!$results_video_tag) {
	    jamLog(__FILE__, __LINE__, 'Unable to execute query');
	    return false;
	}
	$tags_video = array();
	$rows_tag_video = array();
	while ($row_tag_video = mysqli_fetch_array($results_video_tag, MYSQLI_ASSOC))
	    $rows_tag_video[] = $row_tag_video;
	foreach ($rows_tag_video as $row_tag_video) {
	    $tags_video[] = $row_tag_video;
	}
	$video->setTag($tags_video);
	$video->setThumbnail($row['thumbnail_v']);
	$video->setTitle($row['title_v']);
	$video->setURL($row['URL']);
	$video->setUpdatedat($row['updatedat_v']);
	$comment->setVideo($video);
	$comment->setVote($row['vote_cmt']);
	$comments[$row['id_cmt']] = $comment;
    }
    return $comments;
}

/**
 * \fn	    selectEvents($connection, $id, $where = null, $order = null, $limit = null, $skip = null)
 * \brief   Select on Event Class
 * \param   $id, $where = null, $order = null, $limit = null, $skip = null
 * \todo
 */
function selectEvents($connection, $id = null, $where = null, $order = null, $limit = null, $skip = null) {
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
                     WHERE e.active = 1
                       AND e.fromuser = u.id";
    if (!is_null($id)) {
	$sql .= " AND e.id = " . $id . "";
    }
    if (!is_null($where)) {
	foreach ($where as $key => $value) {
	    if (is_array($value)) {
		$inSql = '';
		foreach ($value as $val) {
		    $inSql .= "'" . $val . "',";
		}
		$inSql = substr($inSql, 0, strlen($inSql) - 1);
		$sql .= " AND e." . $key . " IN (" . $inSql . ")";
	    } else {
		$sql .= " AND e." . $key . " = '" . $value . "'";
	    }
	}
    }
    if (!is_null($order)) {
	$sql .= " ORDER BY ";
	$last = end($order);
	foreach ($order as $key => $value) {
	    if ($last == $value)
		$sql .= " e." . $key . " " . $value;
	    else
		$sql .= " e." . $key . " " . $value . ",";
	}
    }
    if (!is_null($skip) && !is_null($limit)) {
	$sql .= " LIMIT " . $skip . ", " . $limit;
    } elseif (is_null($skip) && !is_null($limit)) {
	$sql .= " LIMIT " . $limit;
    }
    $results = mysqli_query($connection, $sql);
    if (!$results) {
	jamLog(__FILE__, __LINE__, 'Unable to execute query');
	return false;
    }
    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
	$rows[] = $row;
    $events = array();
    if (!is_array($rows))
	return $events;
    foreach ($rows as $row) {
	require_once CLASSES_DIR . 'event.class.php';
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
	$fromuser = new User();
	$fromuser->setId($row['id_u']);
	$fromuser->setThumbnail($row['thumbnail_u']);
	$fromuser->setUsername($row['username']);
	$fromuser->setType($row['type']);
	$event->setFromuser($fromuser);
	$sql = "SELECT genre
		  FROM event_genre
		 WHERE id = " . $row['genre'];
	$results_genre_event = mysqli_query($connection, $sql);
	if (!$results_genre_event) {
	    jamLog(__FILE__, __LINE__, 'Unable to execute query');
	    return false;
	}
	$genres = array();
	$rows_genre = array();
	while ($row_genre = mysqli_fetch_array($results_genre_event, MYSQLI_ASSOC))
	    $rows_genre[] = $row_genre;
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
		 WHERE id = " . $row['id_e'];
	$results_tag = mysqli_query($connection, $sql);
	if (!$results_tag) {
	    jamLog(__FILE__, __LINE__, 'Unable to execute query');
	    return false;
	}
	$tags_event = array();
	$rows_tag_event = array();
	while ($row_tag_event = mysqli_fetch_array($results_tag, MYSQLI_ASSOC))
	    $rows_tag_event[] = $row_tag_event;
	foreach ($rows_tag_event as $row_tag_event) {
	    $tags_event[] = $row_tag_event;
	}
	$event->setTag($tags_event);
	$event->setThumbnail($row['thumbnail_e']);
	$event->setTitle($row['title']);
	$event->setCreatedat(new DateTime($row['createdat']));
	$event->setUpdatedat(new DateTime($row['updatedat']));
	$events[$row['id_e']] = $event;
    }
    return $events;
}

/**
 * \fn	    selectImages($connection, $id = null, $where = null, $order = null, $limit = null, $skip = null)
 * \brief   Select on Post Class
 * \param   $id = null, $where = null, $order = null, $limit = null, $skip = null
 * \todo
 */
function selectImages($connection, $id = null, $where = null, $order = null, $limit = null, $skip = null) {
    $sql = "SELECT	i.id id_i,
					i.createdat,
					i.updatedat,
					i.active,
					i.commentcounter,
					i.counter,
					i.fromuser,
					i.latitude,
					i.longitude,
					i.lovecounter,
					i.path,
					i.sharecounter,
					i.thumbnail thumbnail_i,
					a.id ia_a,
					a.cover,
					a.title,
					a.fromuser,
					u.id id_u,
					u.username,
					u.thumbnail thumbnail_u,
					u.type
			FROM	image i, user u, album a
			WHERE	i.active = 1
			AND		i.fromuser = u.id
			AND		i.album = a.id
			AND		i.fromuser = a.fromuser";
    if (!is_null($id)) {
	$sql .= " AND i.id = " . $id . "";
    }
    if (!is_null($where)) {
	foreach ($where as $key => $value) {
	    if (is_array($value)) {
		$inSql = '';
		foreach ($value as $val) {
		    $inSql .= "'" . $val . "',";
		}
		$inSql = substr($inSql, 0, strlen($inSql) - 1);
		$sql .= " AND i." . $key . " IN (" . $inSql . ")";
	    } else {
		$sql .= " AND i." . $key . " = '" . $value . "'";
	    }
	}
    }
    if (!is_null($order)) {
	$sql .= " ORDER BY ";
	$last = end($order);
	foreach ($order as $key => $value) {
	    if ($last == $value)
		$sql .= " i." . $key . " " . $value;
	    else
		$sql .= " i." . $key . " " . $value . ",";
	}
    }
    if (!is_null($skip) && !is_null($limit)) {
	$sql .= " LIMIT " . $skip . ", " . $limit;
    } elseif (is_null($skip) && !is_null($limit)) {
	$sql .= " LIMIT " . $limit;
    }
    $results = mysqli_query($connection, $sql);
    if (!$results) {
	jamLog(__FILE__, __LINE__, 'Unable to execute query');
	return false;
    }
    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
	$rows[] = $row;
    $images = array();
    foreach ($rows as $row) {
	require_once CLASSES_DIR . 'album.class.php';
	require_once CLASSES_DIR . 'image.class.php';
	require_once CLASSES_DIR . 'user.class.php';
	$image = new Image();
	$image->setId($row['id_i']);
	$image->setCreatedat(new DateTime($row['createdat']));
	$image->setUpdatedat(new DateTime($row['updatedat']));
	$image->setActive($row['active']);
	$album = new Album();
	$album->setTitle($row['title']);
	$album->setCover($row['cover']);
	$image->setAlbum($album);
	$image->setCommentcounter($row['commentcounter']);
	$image->setCounter($row['counter']);
	$fromuser = new User();
	$fromuser->setId($row['id_u']);
	$fromuser->setThumbnail($row['thumbnail_u']);
	$fromuser->setUsername($row['username']);
	$fromuser->setType($row['type']);
	$image->setFromuser($fromuser);
	$image->setLatitude($row['latitude']);
	$image->setLongitude($row['longitude']);
	$image->setLovecounter($row['lovecounter']);
	$image->setPath($row['path']);
	$image->setSharecounter($row['sharecounter']);
	$sql = "SELECT tag
		  FROM image_tag
		 WHERE id = " . $row['id_i'];
	$results_tag = mysqli_query($connection, $sql);
	if (!$results_tag) {
	    jamLog(__FILE__, __LINE__, 'Unable to execute query');
	    return false;
	}
	$tags = array();
	$rows_tag = array();
	while ($row_tag = mysqli_fetch_array($results_tag, MYSQLI_ASSOC))
	    $rows_tag[] = $row_tag;
	foreach ($rows_tag as $row_tag) {
	    $tags[] = $row_tag;
	}
	$image->setTag($tags);
	$image->setThumbnail($row['thumbnail_i']);
	$images[$row['id_i']] = $image;
    }
    return $images;
}

/**
 * \fn	    selectMessages($connection, $id = null, $where = null, $order = null, $limit = null, $skip = null)
 * \brief   Select on Comment Class, messages
 * \param   $id = null, $where = null, $order = null, $limit = null, $skip = null
 * \todo
 */
function selectMessages($connection, $id = null, $where = null, $order = null, $limit = null, $skip = null) {
    $sql = "SELECT	   m.id id_m,
                           m.active,
                           m.commentcounter,
                           m.counter,
                           m.fromuser,
                           m.latitude,
                           m.longitude,
                           m.lovecounter,
                           m.sharecounter,
                           mt.id_tag,
                           m.text,
                           m.touser,
                           m.type type_p,
                           m.vote,
                           m.createdat,
                           m.updatedat,
                           fu.id id_fu,
                           fu.username username_u,
                           fu.thumbnail thumbnail_u,
                           fu.type type_u,
			   tu.id id_tu,
                           tu.username username_tu,
                           tu.thumbnail thumbnail_tu,
                           tu.type type_tu
                      FROM comment m, user fu, user tu, comment_tag mt                
                      WHERE m.active = 1
		       	AND m.type = 'M'
                       	AND (m.fromuser = fu.id
		        OR m.touser = fu.id)
		        AND mt.id_comment = id_m";
    if (!is_null($id)) {
	$sql .= " AND m.id = " . $id . "";
    }
    if (!is_null($where)) {
	foreach ($where as $key => $value) {
	    if (is_array($value)) {
		$inSql = '';
		foreach ($value as $val) {
		    $inSql .= "'" . $val . "',";
		}
		$inSql = substr($inSql, 0, strlen($inSql) - 1);
		$sql .= " AND m." . $key . " IN (" . $inSql . ")";
	    } else {
		$sql .= " AND m." . $key . " = '" . $value . "'";
	    }
	}
    }
    if (!is_null($order)) {
	$sql .= " ORDER BY ";
	$last = end($order);
	foreach ($order as $key => $value) {
	    if ($last == $value)
		$sql .= " m." . $key . " " . $value;
	    else
		$sql .= " m." . $key . " " . $value . ",";
	}
    }
    if (!is_null($skip) && !is_null($limit)) {
	$sql .= " LIMIT " . $skip . ", " . $limit;
    } elseif (is_null($skip) && !is_null($limit)) {
	$sql .= " LIMIT " . $limit;
    }
    $results = mysqli_query($connection, $sql);
    if (!$results) {
	jamLog(__FILE__, __LINE__, 'Unable to execute query');
	return false;
    }
    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
	$rows[] = $row;
    $messages = array();
    foreach ($rows as $row) {
	require_once CLASSES_DIR . 'comment.class.php';
	require_once CLASSES_DIR . 'user.class.php';
	$message = new Comment();
	$message->setId($row['id_m']);
	$message->setActive($row['active']);
	$message->setCommentcounter($row['commentcounter']);
	$message->setCounter($row['counter']);
	$fromuser = new User();
	$fromuser->setId($row['id_fu']);
	$fromuser->setThumbnail($row['thumbnail_fu']);
	$fromuser->setUsername($row['username_fu']);
	$fromuser->setType($row['type_fu']);
	$message->setFromuser($fromuser);
	$message->setLatitude($row['latitude']);
	$message->setLongitude($row['longitude']);
	$message->setLovecounter($row['lovecounter']);
	$message->setSharecounter($row['sharecounter']);
	$sql = "SELECT tag
		  FROM comment_tag
		 WHERE id = " . $row['id_m'];
	$results_tag = mysqli_query($connection, $sql);
	if (!$results_tag) {
	    jamLog(__FILE__, __LINE__, 'Unable to execute query');
	    return false;
	}
	$tags = array();
	$rows_tag = array();
	while ($row_tag = mysqli_fetch_array($results_tag, MYSQLI_ASSOC))
	    $rows_tag[] = $row_tag;
	foreach ($rows_tag as $row_tag) {
	    $tags[] = $row_tag;
	}
	$message->setTag($tags);
	$message->setText($row['text']);
	$message->setTitle($row['title']);
	$touser = new User();
	$touser->setId($row['id_tu']);
	$touser->setThumbnail($row['thumbnail_tu']);
	$touser->setUsername($row['username_tu']);
	$touser->setType($row['type_tu']);
	$message->setTouser($touser);
	$message->setType($row['type_m']);
	$message->setVote($row['vote']);
	$message->setCreatedat(new DateTime($row['createdat']));
	$message->setUpdatedat(new DateTime($row['updatedat']));
	$messages[$row['id_m']] = $message;
    }
    return $messages;
}

/**
 * \fn	    selectPlaylists($connection, $id = null, $where = null, $order = null, $limit = null, $skip = null)
 * \brief   Select on Playlist Class
 * \param   $id = null, $where = null, $order = null, $limit = null, $skip = null
 * \todo
 */
function selectPlaylists($connection, $id = null, $where = null, $order = null, $limit = null, $skip = null) {
    $sql = "SELECT p.id id_p,
		           p.createdat,
		           p.updatedat,
		           p.active,
		           p.fromuser,
		           p.name,
		           p.songcounter,
		           p.unlimited,
			   	   u.id id_u,
			   	   u.username,
			   	   u.type
		     FROM playlist p, user u
             WHERE p.active = 1 AND p.fromuser = u.id";
    if (!is_null($id)) {
	$sql .= " AND p.id = " . $id . "";
    }
    if (!is_null($where)) {
	foreach ($where as $key => $value) {
	    if (is_array($value)) {
		$inSql = '';
		foreach ($value as $val) {
		    $inSql .= "'" . $val . "',";
		}
		$inSql = substr($inSql, 0, strlen($inSql) - 1);
		$sql .= " AND p." . $key . " IN (" . $inSql . ")";
	    } else {
		$sql .= " AND p." . $key . " = '" . $value . "'";
	    }
	}
    }
    if (!is_null($order)) {
	$sql .= " ORDER BY ";
	$last = end($order);
	foreach ($order as $key => $value) {
	    if ($last == $value)
		$sql .= " p." . $key . " " . $value;
	    else
		$sql .= " p." . $key . " " . $value . ",";
	}
    }
    if (!is_null($skip) && !is_null($limit)) {
	$sql .= " LIMIT " . $skip . ", " . $limit;
    } elseif (is_null($skip) && !is_null($limit)) {
	$sql .= " LIMIT " . $limit;
    }
    $results = mysqli_query($connection, $sql);
    if (!$results) {
	require_once SERVICES_DIR . 'log.service.php';
	jamLog(__FILE__, __LINE__, 'Unable to execute query');
	return false;
    }
    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
	$rows[] = $row;
    $playlists = array();
    foreach ($rows as $row) {
	require_once CLASSES_DIR . 'playlist.class.php';
	require_once CLASSES_DIR . 'user.class.php';
	$playlist = new Playlist();
	$playlist->setId($row['id_p']);
	$playlist->setActive($row['active']);
	$playlist->setCreatedat(new DateTime($row['createdat']));
	$fromuser = new User();
	$fromuser->setId($row['id_u']);
	$fromuser->setUsername($row['username']);
	$playlist->setFromuser($fromuser);
	$playlist->setName($row['name']);
	$playlist->setSongcounter($row['songcounter']);
	$playlist->setUnlimited($row['unlimited']);
	$playlist->setUpdatedat(new DateTime($row['updatedat']));
	$playlists[$row['id_p']] = $playlist;
    }
    return $playlists;
}

/**
 * \fn	    selectPosts($connection,$id = null, $where = null, $order = null, $limit = null, $skip = null)
 * \brief   Select on Post Class
 * \param   $id = null, $where = null, $order = null, $limit = null, $skip = null
 * \todo
 */
function selectPosts($connection, $id = null, $where = null, $order = null, $limit = null, $skip = null) {
    $sql = "SELECT	   p.id id_p,
                           p.active,
                           p.commentcounter,
                           p.counter,
                           p.fromuser,
                           p.latitude,
                           p.longitude,
                           p.lovecounter,
                           p.sharecounter,
                           p.text,
                           p.touser,
                           p.type type_p,
                           p.vote,
                           p.createdat,
                           p.updatedat,
                           u.id id_u,
                           u.username,
                           u.thumbnail,
                           u.type type_u,
			   			   fu.id id_fu,
                           fu.username username_fu,
                           fu.thumbnail thumbnail_fu,
                           fu.type type_fu
                     FROM comment p, user u, user fu
                     WHERE p.active = 1
                       	AND p.fromuser = u.id
		       	AND p.type = 'P'";
    if (!is_null($id)) {
	$sql .= " AND p.id = " . $id . "";
    }
    if (!is_null($where)) {
	foreach ($where as $key => $value) {
	    if (is_array($value)) {
		$inSql = '';
		foreach ($value as $val) {
		    $inSql .= "'" . $val . "',";
		}
		$inSql = substr($inSql, 0, strlen($inSql) - 1);
		$sql .= " AND p." . $key . " IN (" . $inSql . ")";
	    } else {
		$sql .= " AND p." . $key . " = '" . $value . "'";
	    }
	}
    }
    if (!is_null($order)) {
	$sql .= " ORDER BY ";
	$last = end($order);
	foreach ($order as $key => $value) {
	    if ($last == $value)
		$sql .= " p." . $key . " " . $value;
	    else
		$sql .= " p." . $key . " " . $value . ",";
	}
    }
    if (!is_null($skip) && !is_null($limit)) {
	$sql .= " LIMIT " . $skip . ", " . $limit;
    } elseif (is_null($skip) && !is_null($limit)) {
	$sql .= " LIMIT " . $limit;
    }
    $results = mysqli_query($connection, $sql);
    if (!$results) {
	jamLog(__FILE__, __LINE__, 'Unable to execute query');
	return false;
    }
    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
	$rows[] = $row;
    $posts = array();
    if (!is_array($rows))
	return $posts;
    foreach ($rows as $row) {
	require_once CLASSES_DIR . 'comment.class.php';
	require_once CLASSES_DIR . 'user.class.php';
	$post = new Comment();
	$post->setId($row['id_p']);
	$post->setActive($row['active']);
	$post->setCommentcounter($row['commentcounter']);
	$post->setCounter($row['counter']);
	$fromuser = new User();
	$fromuser->setId($row['id_u']);
	$fromuser->setThumbnail($row['thumbnail_u']);
	$fromuser->setUsername($row['username']);
	$fromuser->setType($row['type_u']);
	$post->setFromuser($fromuser);
	$post->setLatitude($row['latitude']);
	$post->setLongitude($row['longitude']);
	$post->setLovecounter($row['lovecounter']);
	$post->setSharecounter($row['sharecounter']);
	$sql = "SELECT tag
		  FROM comment_tag
		 WHERE id = " . $row['id_p'];
	$results_tag = mysqli_query($connection, $sql);
	if (!$results_tag) {
	    jamLog(__FILE__, __LINE__, 'Unable to execute query');
	    return false;
	}
	$tags = array();
	$rows_tag = array();
	while ($row_tag = mysqli_fetch_array($results_tag, MYSQLI_ASSOC))
	    $rows_tag[] = $row_tag;
	foreach ($rows_tag as $row_tag) {
	    $tags[] = $row_tag;
	}
	$post->setTag($tags);
	$post->setText($row['text']);
	$post->setTitle($row['title']);
	$touser = new User();
	$touser->setId($row['id_fu']);
	$touser->setThumbnail($row['thumbnail_fu']);
	$touser->setUsername($row['username_fu']);
	$touser->setType($row['type_fu']);
	$post->setFromuser($touser);
	$post->setType($row['type_p']);
	$post->setVote($row['vote']);
	$post->setCreatedat(new DateTime($row['createdat']));
	$post->setUpdatedat(new DateTime($row['updatedat']));
	$posts[$row['id_p']] = $post;
    }

    return $posts;
}

/**
 * \fn	    selectRecords($connection, $id = null, $where = null, $order = null, $limit = null, $skip = null)
 * \brief   Select on Post Class
 * \param   $id = null, $where = null, $order = null, $limit = null, $skip = null
 * \todo
 */
function selectRecords($connection, $id = null, $where = null, $order = null, $limit = null, $skip = null) {
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
                           r.label,
                           r.latitude,
                           r.longitude,
                           r.lovecounter,
                           r.reviewCounter,
                           r.sharecounter,
                           r.songCounter,
                           r.thumbnail thumbnail_r,
                           r.title,
                           r.year,
                           r.createdat,
                           r.updatedat,
                           u.id id_u,
                           u.username,
                           u.thumbnail thumbnail_u,
                           u.type
                      FROM record r, user u
                     WHERE r.active = 1
                       AND r.fromuser = u.id";
    if (!is_null($id)) {
	$sql .= " AND r.id = " . $id . "";
    }
    if (!is_null($where)) {
	foreach ($where as $key => $value) {
	    if (is_array($value)) {
		$inSql = '';
		foreach ($value as $val) {
		    $inSql .= "'" . $val . "',";
		}
		$inSql = substr($inSql, 0, strlen($inSql) - 1);
		$sql .= " AND r." . $key . " IN (" . $inSql . ")";
	    } else {
		$sql .= " AND r." . $key . " = '" . $value . "'";
	    }
	}
    }
    if (!is_null($order)) {
	$sql .= " ORDER BY ";
	$last = end($order);
	foreach ($order as $key => $value) {
	    if ($last == $value)
		$sql .= " r." . $key . " " . $value;
	    else
		$sql .= " r." . $key . " " . $value . ",";
	}
    }
    if (!is_null($skip) && !is_null($limit)) {
	$sql .= " LIMIT " . $skip . ", " . $limit;
    } elseif (is_null($skip) && !is_null($limit)) {
	$sql .= " LIMIT " . $limit;
    }
    $results = mysqli_query($connection, $sql);
    if (!$results) {
	jamLog(__FILE__, __LINE__, 'Unable to execute query');
	return false;
    }
    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
	$rows[] = $row;
    $records = array();
    foreach ($rows as $row) {
	require_once CLASSES_DIR . 'record.class.php';
	$record = new Record();
	$record->setId($row['id_r']);
	$record->setActive($row['active']);
	$record->setBuylink($row['buylink']);
	$record->setCity($row['city']);
	$record->setCommentcounter($row['commentcounter']);
	$record->setCounter($row['counter']);
	$record->setCover($row['cover']);
	$record->setDescription($row['description']);
	$record->setDuration($row['duration']);
	require_once CLASSES_DIR . 'user.class.php';
	$fromuser = new User();
	$fromuser->setId($row['id_u']);
	$fromuser->setThumbnail($row['thumbnail_u']);
	$fromuser->setUsername($row['username']);
	$record->setFromuser($fromuser);
	$sql = "SELECT g.genre
                          FROM record_genre rg, genre g
                         WHERE rg.id_record = " . $row['id_r'] . "
                           AND g.id = rg.id_genre";
	$results_genre = mysqli_query($connection, $sql);
	if (!$results_genre) {
	    jamLog(__FILE__, __LINE__, 'Unable to execute query');
	    return false;
	}
	$genres = array();
	$rows_genre = array();
	while ($row_genre = mysqli_fetch_array($results_genre, MYSQLI_ASSOC))
	    $rows_genre[] = $row_genre;
	foreach ($rows_genre as $row_genre) {
	    $genres[] = $row_genre;
	}
	$record->setGenre($genres);
	$record->setLabel($row['label']);
	$record->setLatitude($row['latitude']);
	$record->setLongitude($row['longitude']);
	$record->setLovecounter($row['lovecounter']);
	$record->setReviewCounter($row['reviewCounter']);
	$record->setSharecounter($row['sharecounter']);
	$record->setSongCounter($row['songCounter']);
	$record->setThumbnail($row['thumbnail_r']);
	$record->setTitle($row['title']);
	//$record->setTracklist($row['tracklist']);
	$record->setYear($row['year']);
	$record->setCreatedat(new DateTime($row['createdat']));
	$record->setUpdatedat(new DateTime($row['updatedat']));
	$records[$row['id_r']] = $record;
    }
    return $records;
}

/**
 * \fn	    selectReviewEvent($connection,$id = null, $where = null, $order = null, $limit = null, $skip = null)
 * \brief   Select on Comment Class
 * \param   $id = null, $where = null, $order = null, $limit = null, $skip = null
 * \todo
 */
function selectReviewEvent($connection, $id = null, $where = null, $order = null, $limit = null, $skip = null) {
    $sql = "SELECT	   rw.id id_rw,
                           rw.active,
                           rw.commentcounter,
                           rw.counter,
                           rw.fromuser,
                           rw.latitude,
                           rw.longitude,
                           rw.lovecounter,
                           rw.sharecounter,
                           rw.text,
                           rw.touser,
                           rw.type type_p,
                           rw.vote,
                           rw.createdat,
                           rw.updatedat,
                           fu.id id_fu,
                           fu.username username_fu,
                           fu.thumbnail thumbnail_fu,
                           fu.type type_fu,
			   e.id id_e,
                           e.active active_e,
                           e.address,
                           e.attendeecounter,
                           e.cancelledcounter,
                           e.city,
                           e.commentcounter commentcounter_e,
                           e.counter counter_e,
                           e.cover,
                           e.description,
                           e.eventdate,
                           e.fromuser fromuser_e,
                           e.invitedcounter,
                           e.latitude latitude_e,
                           e.longitude longitude_e,
                           e.locationname,
                           e.lovecounter lovecounter_e,
                           e.reviewcounter,
                           e.refusedcounter,
                           e.sharecounter sharecounter_e,
                           e.thumbnail thumbnail_e,
                           e.title,
                           e.createdat,
                           e.updatedat,
                           u.id id_u,
                           u.username,
                           u.thumbnail thumbnail_u,
                           u.type type_u
                     FROM comment rw, user u, user fu, event e
                     WHERE rw.active = 1
                       	AND rw.fromuser = fu.id
		       	AND rw.type = 'RE'";
    if (!is_null($id)) {
	$sql .= " AND rw.id = " . $id . "";
    }
    if (!is_null($where)) {
	foreach ($where as $key => $value) {
	    if (is_array($value)) {
		$inSql = '';
		foreach ($value as $val) {
		    $inSql .= "'" . $val . "',";
		}
		$inSql = substr($inSql, 0, strlen($inSql) - 1);
		$sql .= " AND rw." . $key . " IN (" . $inSql . ")";
	    } else {
		$sql .= " AND rw." . $key . " = '" . $value . "'";
	    }
	}
    }
    if (!is_null($order)) {
	$sql .= " ORDER BY ";
	$last = end($order);
	foreach ($order as $key => $value) {
	    if ($last == $value)
		$sql .= " rw." . $key . " " . $value;
	    else
		$sql .= " rw." . $key . " " . $value . ",";
	}
    }
    if (!is_null($skip) && !is_null($limit)) {
	$sql .= " LIMIT " . $skip . ", " . $limit;
    } elseif (is_null($skip) && !is_null($limit)) {
	$sql .= " LIMIT " . $limit;
    }
    $results = mysqli_query($connection, $sql);
    if (!$results) {
	jamLog(__FILE__, __LINE__, 'Unable to execute query');
	return false;
    }
    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
	$rows[] = $row;
    $reviewEvents = array();
    if (!is_array($rows))
	return $reviewEvents;
    foreach ($rows as $row) {
	require_once CLASSES_DIR . 'comment.class.php';
	require_once CLASSES_DIR . 'event.class.php';
	require_once CLASSES_DIR . 'user.class.php';
	$reviewEvent = new Comment();
	$reviewEvent->setId($row['id_rw']);
	$reviewEvent->setActive($row['active_rw']);
	$reviewEvent->setCommentcounter($row['commentcounter_rw']);
	$reviewEvent->setCounter($row['counter_rw']);
	$event = new Event();
	$event->setId($row['id_e']);
	$event->setActive($row['active_e']);
	$event->setAddress($row['address']);
	$event->setAttendeecounter($row['attendeecounter']);
	$event->setCancelledcounter($row['cancelledcounter']);
	$event->setCity($row['city']);
	$event->setCommentcounter($row['commentcounter_e']);
	$event->setCounter($row['counter_e']);
	$event->setCover($row['cover']);
	$event->setDescription($row['description']);
	$event->setEventdate($row['eventdate']);
	$sql = "SELECT genre
		  FROM event_genre
		 WHERE id = " . $row['genre'];
	$results_genre_event = mysqli_query($connection, $sql);
	if (!$results_genre_event) {
	    jamLog(__FILE__, __LINE__, 'Unable to execute query');
	    return false;
	}
	$genres = array();
	$rows_genre = array();
	while ($row_genre = mysqli_fetch_array($results_genre_event, MYSQLI_ASSOC))
	    $rows_genre[] = $row_genre;
	foreach ($rows_genre as $row_genre) {
	    $genres[] = $row_genre;
	}
	$event->setGenre($genres);
	$event->setInvitedCounter($row['invitedCounter']);
	$event->setLatitude($row['latitude_e']);
	$event->setLocationname($row['locationname']);
	$event->setLongitude($row['longitude_e']);
	$event->setLovecounter($row['lovecounter']);
	$event->setRefusedcounter($row['refusedcounter']);
	$event->setReviewcounter($row['reviewcounter']);
	$event->setSharecounter($row['sharecounter_e']);
	$sql = "SELECT tag
                          FROM event_tag
                         WHERE id = " . $row['id_e'];
	$results_event = mysqli_query($connection, $sql);
	if (!$results) {
	    jamLog(__FILE__, __LINE__, 'Unable to execute query');
	    return false;
	}
	while ($row_tag = mysqli_fetch_array($results_event, MYSQLI_ASSOC))
	    $rows_tag[] = $row_tag;
	$tags_event = array();
	foreach ($rows_tag as $row_tag) {
	    $tags_event[] = $row_tag;
	}
	$event->setTag($tags_event);
	$event->setThumbnail($row['thumbnail_e']);
	$event->setTitle($row['title']);
	$event->setCreatedat($row['createdat_e']);
	$event->setUpdatedat($row['updatedat_e']);
	$reviewEvent->setEvent($event);
	$fromuser = new User();
	$fromuser->setId($row['id_fu']);
	$fromuser->setThumbnail($row['thumbnail_fu']);
	$fromuser->setUsername($row['username_fu']);
	$fromuser->setType($row['type_fu']);
	$reviewEvent->setFromuser($fromuser);
	$reviewEvent->setLatitude($row['latitude_rw']);
	$reviewEvent->setLongitude($row['longitude_rw']);
	$reviewEvent->setLovecounter($row['lovecounter_rw']);
	$reviewEvent->setSharecounter($row['sharecounter_rw']);
	$sql = "SELECT tag
		  FROM comment_tag
		 WHERE id = " . $row['id_rw'];
	$results_tag = mysqli_query($connection, $sql);
	if (!$results_tag) {
	    jamLog(__FILE__, __LINE__, 'Unable to execute query');
	    return false;
	}
	$tags_review = array();
	$rows_tag_review = array();
	while ($row_tag_review = mysqli_fetch_array($results_tag, MYSQLI_ASSOC))
	    $rows_tag_review[] = $row_tag_review;
	foreach ($rows_tag_review as $row_tag_review) {
	    $tags_review[] = $row_tag_review;
	}
	$reviewEvent->setTag($tags_event);
	$reviewEvent->setText($row['text']);
	$reviewEvent->setTitle($row['title']);
	$touser = new User();
	$touser->setId($row['id_u']);
	$touser->setThumbnail($row['thumbnail_u']);
	$touser->setUsername($row['username_u']);
	$touser->setType($row['type_u']);
	$reviewEvent->setTouser($touser);
	$reviewEvent->setType($row['type_rw']);
	$reviewEvent->setVote($row['vote']);
	$reviewEvent->setCreatedat($row['createdat_rw']);
	$reviewEvent->setUpdatedat($row['updatedat_rw']);
	$reviewEvents[$row['id_rw']] = $reviewEvent;
    }
    return $reviewEvents;
}

/**
 * \fn	    selectReviewRecord($connection, $id = null, $where = null, $order = null, $limit = null, $skip = null)
 * \brief   Select on Comment Class
 * \param   $id = null, $where = null, $order = null, $limit = null, $skip = null
 * \todo
 */
function selectReviewRecord($connection, $id = null, $where = null, $order = null, $limit = null, $skip = null) {
    $sql = "SELECT	   rw.id id_rw,
                           rw.active,
                           rw.commentcounter,
                           rw.counter,
                           rw.fromuser,
                           rw.latitude,
                           rw.longitude,
                           rw.lovecounter,
                           rw.sharecounter,
                           rw.text,
                           rw.touser,
                           rw.type type_p,
                           rw.vote,
                           rw.createdat,
                           rw.updatedat,
                           fu.id id_fu,
                           fu.username username_fu,
                           fu.thumbnail thumbnail_fu,
                           fu.type type_fu,
			   r.id id_r,
                           r.active active_r,
                           r.buylink,
                           r.city,
                           r.commentcounter commentcounter_r,
                           r.counter counter_r,
                           r.cover,
                           r.description,
                           r.duration,
                           r.fromuser fromuser_r,
                           r.label,
                           r.latitude latitude_r,
                           r.longitude longitude_r,
                           r.lovecounter lovecounter_r,
                           r.reviewCounter,
                           r.sharecounter sharecounter_r,
                           r.songCounter,
                           r.thumbnail thumbnail_r,
                           r.title,
                           r.year,
                           r.createdat createdat_r,
                           r.updatedat updatedat_r,
                           u.id id_u,
                           u.username username_u,
                           u.thumbnail thumbnail_u,
                           u.type type_u
                     FROM comment rw, user u, user fu, record r
                     WHERE rw.active = 1
                       AND rw.fromuser = fu.id
		       AND rw.type = 'RR'";
    if (!is_null($id)) {
	$sql .= " AND rw.id = " . $id . "";
    }
    if (!is_null($where)) {
	foreach ($where as $key => $value) {
	    if (is_array($value)) {
		$inSql = '';
		foreach ($value as $val) {
		    $inSql .= "'" . $val . "',";
		}
		$inSql = substr($inSql, 0, strlen($inSql) - 1);
		$sql .= " AND rw." . $key . " IN (" . $inSql . ")";
	    } else {
		$sql .= " AND rw." . $key . " = '" . $value . "'";
	    }
	}
    }
    if (!is_null($order)) {
	$sql .= " ORDER BY ";
	$last = end($order);
	foreach ($order as $key => $value) {
	    if ($last == $value)
		$sql .= " rw." . $key . " " . $value;
	    else
		$sql .= " rw." . $key . " " . $value . ",";
	}
    }
    if (!is_null($skip) && !is_null($limit)) {
	$sql .= " LIMIT " . $skip . ", " . $limit;
    } elseif (is_null($skip) && !is_null($limit)) {
	$sql .= " LIMIT " . $limit;
    }
    $results = mysqli_query($connection, $sql);
    if (!$results) {
	jamLog(__FILE__, __LINE__, 'Unable to execute query');
	return false;
    }
    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
	$rows[] = $row;
    $reviewRecords = array();
    if (!is_array($rows))
	return $reviewRecords;
    foreach ($rows as $row) {
	require_once CLASSES_DIR . 'comment.class.php';
	require_once CLASSES_DIR . 'record.class.php';
	require_once CLASSES_DIR . 'user.class.php';
	$reviewRecord = new Comment();
	$reviewRecord->setId($row['id_rw']);
	$reviewRecord->setActive($row['active_rw']);
	$reviewRecord->setCommentcounter($row['commentcounter_rw']);
	$reviewRecord->setCounter($row['counter_rw']);
	$fromuser = new User();
	$fromuser->setId($row['id_fu']);
	$fromuser->setThumbnail($row['thumbnail_fu']);
	$fromuser->setUsername($row['username_fu']);
	$fromuser->setType($row['type_fu']);
	$reviewRecord->setFromuser($fromuser);
	$reviewRecord->setLatitude($row['latitude_rw']);
	$reviewRecord->setLongitude($row['longitude_rw']);
	$reviewRecord->setLovecounter($row['lovecounter_rw']);
	$record = new Record();
	$record->setId($row['id_r']);
	$record->setActive($row['active_r']);
	$record->setBuylink($row['buylink']);
	$record->setCity($row['city']);
	$record->setCommentcounter($row['commentcounter_r']);
	$record->setCounter($row['counter_r']);
	$record->setCover($row['cover']);
	$record->setDescription($row['description']);
	$record->setDuration($row['duration']);
	$sql = "SELECT g.genre
                          FROM record_genre rg, genre g
                         WHERE rg.id_record = " . $row['id_r'] . "
                           AND g.id = rg.id_genre";
	$results_genre = mysqli_query($connection, $sql);
	if (!$results_genre) {
	    jamLog(__FILE__, __LINE__, 'Unable to execute query');
	    return false;
	}
	$genres = array();
	$rows_genre = array();
	while ($row_genre = mysqli_fetch_array($results_genre, MYSQLI_ASSOC))
	    $rows_genre[] = $row_genre;
	foreach ($rows_genre as $row_genre) {
	    $genres[] = $row_genre;
	}
	$record->setGenre($genres);
	$record->setLabel($row['label']);
	$record->setLatitude($row['latitude_r']);
	$record->setLongitude($row['longitude_r']);
	$record->setLovecounter($row['lovecounter_r']);
	$record->setReviewCounter($row['reviewCounter']);
	$record->setSharecounter($row['sharecounter_r']);
	$record->setSongCounter($row['songCounter']);
	$record->setThumbnail($row['thumbnail_r']);
	$record->setTitle($row['title']);
	$record->setYear($row['year']);
	$record->setCreatedat($row['createdat_r']);
	$record->setUpdatedat($row['updatedat_r']);
	$reviewRecord->setRecord($record);
	$reviewRecord->setSharecounter($row['sharecounter_rw']);
	$sql = "SELECT tag
                          FROM comment_tag
                         WHERE id = " . $row['id_rw'];
	$results = mysqli_query($connection, $sql);
	if (!$results) {
	    jamLog(__FILE__, __LINE__, 'Unable to execute query');
	    return false;
	}
	while ($row_tag = mysqli_fetch_array($results, MYSQLI_ASSOC))
	    $rows_tag[] = $row_tag;
	$tags = array();
	foreach ($rows_tag as $row_tag) {
	    $tags[] = $row_tag;
	}
	$reviewRecord->setTag($tags);
	$reviewRecord->setText($row['text']);
	$reviewRecord->setTitle($row['title']);
	$touser = new User();
	$touser->setId($row['id_u']);
	$touser->setThumbnail($row['thumbnail_u']);
	$touser->setUsername($row['username_u']);
	$touser->setType($row['type_u']);
	$reviewRecord->setTouser($touser);
	$reviewRecord->setType($row['type_rw']);
	$reviewRecord->setVote($row['vote']);
	$reviewRecord->setCreatedat($row['createdat_rw']);
	$reviewRecord->setUpdatedat($row['updatedat_rw']);
	$reviewRecords[$row['id_rw']] = $reviewRecord;
    }
    return $reviewRecords;
}

/**
 * \fn	    selectSongs($connection, $id = null, $where = null, $order = null, $limit = null, $skip = null)
 * \brief   Select on Post Class
 * \param   $id = null, $where = null, $order = null, $limit = null, $skip = null
 * \todo
 */
function selectSongs($connection, $id = null, $where = null, $order = null, $limit = null, $skip = null) {
    $sql = "SELECT     s.id id_s,
		               s.createdat,
		               s.updatedat,
		               s.active,
		               s.commentcounter,
		               s.counter,
		               s.duration,
		               s.fromuser,
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
			       r.title title_r,
			       r.updatedat
                 FROM song s, user u, record r
                WHERE s.active  = 1
                  AND s.fromuser = u.id
                  AND s.record = r.id";
    if (!is_null($id)) {
	$sql .= " AND s.id = " . $id . "";
    }
    if (!is_null($where)) {
	foreach ($where as $key => $value) {
	    if (is_array($value)) {
		$inSql = '';
		foreach ($value as $val) {
		    $inSql .= "'" . $val . "',";
		}
		$inSql = substr($inSql, 0, strlen($inSql) - 1);
		$sql .= " AND s." . $key . " IN (" . $inSql . ")";
	    } else {
		$sql .= " AND s." . $key . " = '" . $value . "'";
	    }
	}
    }
    if (!is_null($order)) {
	$sql .= " ORDER BY ";
	$last = end($order);
	foreach ($order as $key => $value) {
	    if ($last == $value)
		$sql .= " s." . $key . " " . $value;
	    else
		$sql .= " s." . $key . " " . $value . ",";
	}
    }
    if (!is_null($skip) && !is_null($limit)) {
	$sql .= " LIMIT " . $skip . ", " . $limit;
    } elseif (is_null($skip) && !is_null($limit)) {
	$sql .= " LIMIT " . $limit;
    }
    $results = mysqli_query($connection, $sql);
    if (!$results) {
	jamLog(__FILE__, __LINE__, 'Unable to execute query');
	return false;
    }
    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
	$rows[] = $row;
    $songs = array();
    if (!is_array($rows))
	return $songs;
    foreach ($rows as $row) {
	require_once CLASSES_DIR . 'record.class.php';
	require_once CLASSES_DIR . 'song.class.php';
	require_once CLASSES_DIR . 'user.class.php';
	$song = new Song();
	$song->setId($row['id_s']);
	$song->setActive($row['active']);
	$song->setCommentcounter($row['commentcounter']);
	$song->setCounter($row['counter']);
	$song->setCreatedat(new DateTime($row['createdat']));
	$song->setDuration($row['duration']);
	$fromuser = new User();
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
	$song->setRecord($record);
	$song->setSharecounter($row['sharecounter']);
	$song->setTitle($row['title_s']);
	$song->setUpdatedat(new DateTime($row['updatedat']));
	$songs[$row['id_s']] = $song;
    }
    return $songs;
}

/**
 * \fn	    selectSongs($connection,$id = null, $where = null, $order = null, $limit = null, $skip = null)
 * \brief   Select on Post Class
 * \param   $id = null, $where = null, $order = null, $limit = null, $skip = null
 * \todo
 */
function selectSongsInPlaylist($connection, $id = null, $limit = 20, $skip = 0) {
    $sql = "SELECT s.id id_s,
		       s.createdat,
		       s.updatedat,
		       s.active,
		       s.commentcounter,
		       s.counter,
		       s.duration,
		       s.fromuser,
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
		  FROM playlist pl, playlist_song ps, record r, song s, user u
		  WHERE s.id = ps.id_song 
		  AND pl.fromuser = u.id 
		  AND s.record = r.id 
		  AND ps.playlist = pl.id s.active = 1";
    if (!is_null($id)) {
	$sql .= " AND pl.id = " . $id . "";
    }
    if (!is_null($skip) && !is_null($limit)) {
	$sql .= " LIMIT " . $skip . ", " . $limit;
    } elseif (is_null($skip) && !is_null($limit)) {
	$sql .= " LIMIT " . $limit;
    }
    $results = mysqli_query($connection, $sql);
    if (!$results) {
	jamLog(__FILE__, __LINE__, 'Unable to execute query');
	return false;
    }
    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
	$rows[] = $row;
    $songs = array();
    foreach ($rows as $row) {
	require_once CLASSES_DIR . 'record.class.php';
	require_once CLASSES_DIR . 'song.class.php';
	require_once CLASSES_DIR . 'user.class.php';
	$song = new Song();
	$song->setId($row['id_s']);
	$song->setActive($row['active']);
	$song->setCommentcounter($row['commentcounter']);
	$song->setCounter($row['counter']);
	$song->setCreatedat(new DateTime($row['createdat']));
	$song->setDuration($row['duration']);
	$fromuser = new User();
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
	$song->setRecord($record);
	$song->setSharecounter($row['sharecounter']);
	$song->setTitle($row['title_s']);
	$song->setUpdatedat(new DateTime($row['updatedat']));
	$songs[$row['id_s']] = $song;
    }
    return $songs;
}

/**
 * \fn	    selectUsers($connection,$id = null, $where = null, $order = null, $limit = null, $skip = null)
 * \brief   Select on Post Class
 * \param   $id = null, $where = null, $order = null, $limit = null, $skip = null
 * \todo
 */
function selectUsers($connection, $id = null, $where = null, $order = null, $limit = null, $skip = null) {
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
			premium,
			premiumexpirationdate,
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
			WHERE active = 1";
    if (!is_null($id)) {
	$sql .= " AND id = " . $id . "";
    }
    if (!is_null($where)) {
	foreach ($where as $key => $value) {
	    if (is_array($value)) {
		$inSql = '';
		foreach ($value as $val) {
		    $inSql .= "'" . $val . "',";
		}
		$inSql = substr($inSql, 0, strlen($inSql) - 1);
		$sql .= " AND " . $key . " IN (" . $inSql . ")";
	    } else {
		$sql .= " AND " . $key . " = '" . $value . "'";
	    }
	}
    }
    if (!is_null($order)) {
	$sql .= " ORDER BY ";
	$last = end($order);
	foreach ($order as $key => $value) {
	    if ($last == $value)
		$sql .= " " . $key . " " . $value;
	    else
		$sql .= " " . $key . " " . $value . ",";
	}
    }
    if (!is_null($skip) && !is_null($limit)) {
	$sql .= " LIMIT " . $skip . ", " . $limit;
    } elseif (is_null($skip) && !is_null($limit)) {
	$sql .= " LIMIT " . $limit;
    }
    $results = mysqli_query($connection, $sql);
    if (!$results) {
	jamLog(__FILE__, __LINE__, 'Unable to execute query');
	return false;
    }
    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
	$rows[] = $row;
    $users = array();
    foreach ($rows as $row) {
	require_once CLASSES_DIR . 'user.class.php';
	$user = new User();
	$user->setId($row['id']);
	$user->setActive($row['active']);
	$user->setAddress($row['address']);
	$user->setAvatar($row['avatar']);
	$user->setBackground($row['background']);
	$user->setBirthday($row['birthday']);
	$user->setCity($row['city']);
	$user->setCollaborationcounter($row['collaborationcounter']);
	$user->setCountry($row['country']);
	$user->setCreatedat(new DateTime($row['createdat']));
	$user->setDescription($row['description']);
	$user->setEmail($row['email']);
	$user->setFacebookId($row['facebookid']);
	$user->setFacebookpage($row['facebookpage']);
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
//	    $sql = "SELECT members
//                          FROM user_members
//                         WHERE id = " . $row['id'];
//	    $results_members = mysqli_query($connectionService->getConnection(), $sql);
//	    if (!$results_members) {
//		$error = new Error();
//		$error->setErrormessage($results_members->error);
//		return $error;
//	    }
//	    while ($row_members = mysqli_fetch_array($results_members, MYSQLI_ASSOC))
//		$rows_members[] = $row_members;
//	    $members = array();
//	    foreach ($rows_members as $row_members) {
//		$members[] = $row_members;
//	    }
//	    $user->setMembers($members);
	$user->setPremium($row['premium']);
	$user->setPremiumexpirationdate($row['premiumexpirationdate']);
//	    $sql = "SELECT setting
//                          FROM user_setting
//                         WHERE id = " . $row['id'];
//	    $results = mysqli_query($connectionService->getConnection(), $sql);
//	    if (!$results) {
//	jamLog (__FILE__, __LINE__, 'Unable to execute query');
//	return false;
//	    }
//	    while ($row_setting = mysqli_fetch_array($results, MYSQLI_ASSOC))
//		$rows_setting[] = $row_setting;
//	    $settings = array();
//	    foreach ($rows_setting as $row_setting) {
//		$settings[] = $row_setting;
//	    }
//	    $user->setSettings($settings);
	$user->setSex($row['sex']);
	$user->setThumbnail($row['thumbnail']);
	$user->setType($row['type']);
	$user->setTwitterpage($row['twitterpage']);
	$user->setUpdatedat(new DateTime($row['updatedat']));
	$user->setUsername($row['username']);
	$user->setVenuecounter($row['venuecounter']);
	$user->setWebsite($row['website']);
	$user->setYoutubechannel($row['youtubechannel']);
	$users[$row['id']] = $user;
    }
    return $users;
}

/**
 * \fn	    selectVideos($connection, $id = null, $where = null, $order = null, $limit = null, $skip = null)
 * \brief   Select on Post Class
 * \param   $id = null, $where = null, $order = null, $limit = null, $skip = null
 * \todo
 */
function selectVideos($connection, $id = null, $where = null, $order = null, $limit = null, $skip = null) {

    $sql = "SELECT          v.id id_v,
			    v.createdat,
			    v.updatedat,
			    v.active,
			    v.author,
			    v.counter,
			    v.cover,
			    v.duration,
			    v.fromuser,
			    v.lovecounter,
			    v.thumbnail thumbnail_v,
			    v.title title_v,
			    v.URL,
			    u.id id_u,
			    u.thumbnail thumbnail_u,
			    u.type,
			    u.username
			    FROM video v, user u
			    WHERE v.active = 1
			    AND v.fromuser = u.id";
    if (!is_null($id)) {
	$sql .= " AND v.id = " . $id . "";
    }
    if (!is_null($where)) {
	foreach ($where as $key => $value) {
	    if (is_array($value)) {
		$inSql = '';
		foreach ($value as $val) {
		    $inSql .= "'" . $val . "',";
		}
		$inSql = substr($inSql, 0, strlen($inSql) - 1);
		$sql .= " AND v." . $key . " IN (" . $inSql . ")";
	    } else {
		$sql .= " AND v." . $key . " = '" . $value . "'";
	    }
	}
    }
    if (!is_null($order)) {
	$sql .= " ORDER BY ";
	$last = end($order);
	foreach ($order as $key => $value) {
	    if ($last == $value)
		$sql .= " v." . $key . " " . $value;
	    else
		$sql .= " v." . $key . " " . $value . ",";
	}
    }
    if (!is_null($skip) && !is_null($limit)) {
	$sql .= " LIMIT " . $skip . ", " . $limit;
    } elseif (is_null($skip) && !is_null($limit)) {
	$sql .= " LIMIT " . $limit;
    }
    $results = mysqli_query($connection, $sql);
    if (!$results) {
	jamLog(__FILE__, __LINE__, 'Unable to execute query');
	return false;
    }
    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
	$rows[] = $row;
    $videos = array();
    foreach ($rows as $row) {
	require_once CLASSES_DIR . 'video.class.php';
	$video = new Video();
	$video->setId($row['id_v']);
	$video->setActive($row['active']);
	$video->setAuthor($row['author']);
	$video->setCounter($row['counter']);
	$video->setCover($row['cover']);
	$video->setCreatedat(new DateTime($row['createdat']));
	$video->setDescription($row['description']);
	$video->setDuration($row['duration']);
	$fromuser = new User();
	$fromuser->setId($row['id_u']);
	$fromuser->setThumbnail($row['thumbnail_u']);
	$fromuser->setType($row['type']);
	$fromuser->setUsername($row['username']);
	$video->setFromuser($fromuser);
	$video->setLovecounter($row['lovecounter']);
	$sql = "SELECT tag
                          FROM video_tag
                         WHERE id = " . $row['id_v'];
	$results_tag = mysqli_query($connection, $sql);
	if (!$results_tag) {
	    jamLog(__FILE__, __LINE__, 'Unable to execute query');
	    return false;
	}
	while ($row_tag = mysqli_fetch_array($results_tag, MYSQLI_ASSOC))
	    $rows_tag[] = $row_tag;
	$tags = array();
	foreach ($rows_tag as $row_tag) {
	    $tags[] = $row_tag;
	}
	$video->setTag($tags);
	$video->setThumbnail($row['thumbnail_v']);
	$video->setTitle($row['title_v']);
	$video->setURL($row['URL']);
	$video->setUpdatedat(new DateTime($row['updatedat']));
	$videos[$row['id_v']] = $video;
    }
    return $videos;
}

?>