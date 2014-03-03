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

function existsRelation($fromNodeType, $fromNodeId, $toNodeType, $toNodeId, $relationType) {
	$query = '
	MATCH (n:' . $fromNodeType . ')-[r:' . $relationType . ']->(m:' . $toNodeType . ')
	WHERE n.id = {fromNodeId} AND m.id = {toNodeId}
	RETURN count(n)
	';
	$params = array(
		'fromNodeId'	=> $fromNodeId,
		'toNodeId' 		=> $toNodeId
	);
	$connectionService = new ConnectionService();
	$res = $connectionService->curl($query, $params);
	return $res['data'][0];
}

function getList($fromNodeType, $fromNodeId, $toNodeType, $relationType) {
	$query = '
	MATCH (n:' . $fromNodeType . ')-[r:' . $relationType . ']->(m:' . $toNodeType . ')
	WHERE n.id = {fromNodeId}
	RETURN m
	';
	$params = array(
		'fromNodeId'	=> $fromNodeId
	);
	$connectionService = new ConnectionService();
	$res = $connectionService->curl($query, $params);
	$list = array();
	foreach($res['data'] as $value) {
		$list[] = $value[0]['data']['id'];
	}
	return $list;
}

/**
 * \fn	    query($sql)
 * \brief   Execute generic query
 * \param   $ql string for query
 * \todo
 */
function query($sql) {
    $connectionService = new ConnectionService();
    $connectionService->connect();
    if (!$connectionService->getActive()) {
	return $connectionService->error;
    } else {
	$results = mysqli_query($connectionService->getConnection(), $sql);
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
    if (!$connectionService->getActive()) {
	$error = new Error();
	$error->setErrormessage($connectionService->error);
	return $error;
    } else {
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
		$sql .= " AND " . $key . " = '" . $value . "'";
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
    $results = mysqli_query($connectionService->getConnection(), $sql);
	if (!$results) {
        $error = new Error();
	    $error->setErrormessage($results->error);
	    return $error;
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
	    $results = mysqli_query($connectionService->getConnection(), $sql);
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
	    $album->setTag($tags);
		$album->setThumbnail($row['thumbnail_a']);
	    $album->setTitle($row['title']);
	    $album->setCreatedat($row['createdat']);
	    $album->setUpdatedat($row['updatedat']);
	    $albums[$row['id_a']] = $album;
	}
	$connectionService->disconnect();
	return $albums;
    }
}

/**
 * \fn	    selectComments($id = null, $where = null, $order = null, $limit = null, $skip = null)
 * \brief   Select on Event Class
 * \param   $id, $where = null, $order = null, $limit = null, $skip = null
 * \todo    prendere soltanto i parametri di interesse in base a confronto con box esistente
 */
function selectComments($id = null, $where = null, $order = null, $limit = null, $skip = null) {
    $connectionService = new ConnectionService();
    $connectionService->connect();
    if (!$connectionService->getActive()) {
	$error = new Error();
	$error->setErrormessage($connectionService->error);
	return $error;
    } else {
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
                   rg.id_genre genre_r,
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
				   sg.id_genre genre_s,
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
				   vg.id_genre genre_v,
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
				   LEFT JOIN record_genre rg ON (rg.id_record = r.id)
				   LEFT JOIN song s  ON (s.id = cmt.song)
				   LEFT JOIN song_genre sg ON (sg.id_song = s.id)
                   LEFT JOIN user fu   ON (fu.id = cmt.fromuser)
                   LEFT JOIN user tu   ON (tu.id = cmt.touser)
                   LEFT JOIN video v   ON (v.id = cmt.video)
				   LEFT JOIN video_genre vg ON (vg.id_video = v.id)
             WHERE cmt.active = 1";
	if (!is_null($id)) {
	    $sql .= " AND c.id = " . $id . "";
	}
	if (!is_null($where)) {
	    foreach ($where as $key => $value) {
		$sql .= " AND " . $key . " = '" . $value . "'";
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
	$results = mysqli_query($connectionService->getConnection(), $sql);
	if (!$results) {
	    $error = new Error();
	    $error->setErrormessage($results->error);
	    return $error;
	}
	while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
	    $rows[] = $row;
	$comment = array();
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
	    $results_tag = mysqli_query($connectionService->getConnection(), $sql);
	    if (!$results) {
		$error = new Error();
		$error->setErrormessage($results_tag->error);
		return $error;
	    }
	    while ($row_tag = mysqli_fetch_array($results_tag, MYSQLI_ASSOC))
		$rows_tag[] = $row_tag;
	    $tags_album = array();
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
	    $results_genre = mysqli_query($connectionService->getConnection(), $sql);
	    if (!$results_genre) {
		$error = new Error();
		$error->setErrormessage($results_genre->error);
		return $error;
	    }
	    while ($row_genre = mysqli_fetch_array($results_genre, MYSQLI_ASSOC))
		$rows_genre[] = $row_genre;
	    $genres = array();
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
	    $results_tag_event = mysqli_query($connectionService->getConnection(), $sql);
	    if (!$results_tag_event) {
		$error = new Error();
		$error->setErrormessage($results_tag_event->error);
		return $error;
	    }
	    while ($row_tag = mysqli_fetch_array($results_tag_event, MYSQLI_ASSOC))
		$rows_tag[] = $row_tag;
	    $tags_event = array();
	    foreach ($rows_tag as $row_tag) {
		$tags_event[] = $row_tag;
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
                         WHERE id = " . $row['id_i'];
	    $results_tag_image = mysqli_query($connectionService->getConnection(), $sql);
	    if (!$results_tag_image) {
		$error = new Error();
		$error->setErrormessage($results_tag_image->error);
		return $error;
	    }
	    while ($row_tag = mysqli_fetch_array($results_tag_image, MYSQLI_ASSOC))
		$rows_tag[] = $row_tag;
	    $tags_image = array();
	    foreach ($rows_tag as $row_tag) {
		$tags_image[] = $row_tag;
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
	    $results_genre_record = mysqli_query($connectionService->getConnection(), $sql);
	    if (!$results_genre_record) {
		$error = new Error();
		$error->setErrormessage($results_genre_record->error);
		return $error;
	    }
	    while ($row_genre = mysqli_fetch_array($results_genre, MYSQLI_ASSOC))
		$rows_genre[] = $row_genre;
	    $genres_record = array();
	    foreach ($rows_genre as $row_genre) {
		$genres_record[] = $row_genre;
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
	    $song->setUpdatedat($row['updatedat']);
	    $comment->setSong($song);
	    $sql = "SELECT tag
                          FROM comment_tag
                         WHERE id = " . $row['id_s'];
	    $results_tag_song = mysqli_query($connectionService->getConnection(), $sql);
	    if (!$results_tag_song) {
		$error = new Error();
		$error->setErrormessage($results_tag_song->error);
		return $error;
	    }
	    while ($row_tag = mysqli_fetch_array($results_tag_song, MYSQLI_ASSOC))
		$rows_tag[] = $row_tag;
	    $tags_song = array();
	    foreach ($rows_tag as $row_tag) {
		$tags_song[] = $row_tag;
	    }
	    $comment->setTag($tags_song);
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
                          FROM comment_tag
                         WHERE id = " . $row['id_v'];
	    $results_tag_video = mysqli_query($connectionService->getConnection(), $sql);
	    if (!$results_tag_video) {
		$error = new Error();
		$error->setErrormessage($results_tag_video->error);
		return $error;
	    }
	    while ($row_tag = mysqli_fetch_array($results_tag_video, MYSQLI_ASSOC))
		$rows_tag[] = $row_tag;
	    $tags_video = array();
	    foreach ($rows_tag as $row_tag) {
		$tags_video[] = $row_tag;
	    }
	    $video->setTag($tags_video);
	    $video->setThumbnail($row['thumbnail_v']);
	    $video->setTitle($row['title_v']);
	    $video->setURL($row['URL']);
	    $video->setUpdatedat($row['updatedat_v']);
	    $comment->setVideo($video);
	    $comment->setVote($row['vote_cmt']);
	    $comments[$row['id']] = $comment;
	}
	$connectionService->disconnect();
	return $comments;
    }
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
    if (!$connectionService->getActive()) {
	$error = new Error();
	$error->setErrormessage($connectionService->error);
	return $error;
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
                     WHERE e.active = 1
                       AND e.fromuser = u.id";
	if (!is_null($id)) {
	    $sql .= " AND a.id = " . $id . "";
	}
	if (!is_null($where)) {
	    foreach ($where as $key => $value) {
		$sql .= " AND " . $key . " = '" . $value . "'";
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
	$results = mysqli_query($connectionService->getConnection(), $sql);
	if (!$results) {
	    $error = new Error();
	    $error->setErrormessage($results->error);
	    return $error;
	}
	while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
	    $rows[] = $row;
	$events = array();
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
	    $results_genre = mysqli_query($connectionService->getConnection(), $sql);
	    if (!$results_genre) {
		$error = new Error();
		$error->setErrormessage($results_genre->error);
		return $error;
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
	    $results = mysqli_query($connectionService->getConnection(), $sql);
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

/**
 * \fn	    selectImages($id = null, $where = null, $order = null, $limit = null, $skip = null)
 * \brief   Select on Post Class
 * \param   $id = null, $where = null, $order = null, $limit = null, $skip = null
 * \todo
 */
function selectImages($id = null, $where = null, $order = null, $limit = null, $skip = null) {
    $connectionService = new ConnectionService();
    $connectionService->connect();
    if (!$connectionService->getActive()) {
	$error = new Error();
	$error->setErrormessage($connectionService->error);
	return $error;
    } else {
	$sql = "SELECT     i.id id_i,
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
                      FROM image i, user u, album a
                     WHERE i.active = 1
                       AND i.fromuser = u.id
		       AND i.fromuser = a.fromuser";
	if (!is_null($id)) {
	    $sql .= " AND i.id = " . $id . "";
	}
	if (!is_null($where)) {
	    foreach ($where as $key => $value) {
		$sql .= " AND " . $key . " = '" . $value . "'";
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
	$results = mysqli_query($connectionService->getConnection(), $sql);
	if (!$results) {
	    $error = new Error();
	    $error->setErrormessage($results->error);
	    return $error;
	}
	while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
	    $rows[] = $row;
	$images = array();
	foreach ($rows as $row) {
	    require_once CLASSES_DIR . 'album.class.php';
	    require_once CLASSES_DIR . 'image.class.php';
	    $image = new Image();
	    $image->setId($row['id_i']);
	    $image->setCreatedat($row['createdat']);
	    $image->setUpdatedat($row['updatedat']);
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
	    $results = mysqli_query($connectionService->getConnection(), $sql);
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
	    $image->setTag($tags);
	    $image->setThumbnail($row['thumbnail_i']);
	    $images[$row['id_i']] = $image;
	}
	$connectionService->disconnect();
	return $images;
    }
}

/**
 * \fn	    selectMessages($id = null, $where = null, $order = null, $limit = null, $skip = null)
 * \brief   Select on Comment Class, messages
 * \param   $id = null, $where = null, $order = null, $limit = null, $skip = null
 * \todo
 */
function selectMessages($id = null, $where = null, $order = null, $limit = null, $skip = null) {
    $connectionService = new ConnectionService();
    $connectionService->connect();
    if (!$connectionService->getActive()) {
	$error = new Error();
	$error->setErrormessage($connectionService->error);
	return $error;
	return;
    } else {
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
	    $sql .= " AND a.id = " . $id . "";
	}
	if (!is_null($where)) {
	    foreach ($where as $key => $value) {
		$sql .= " AND " . $key . " = '" . $value . "'";
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
	$results = mysqli_query($connectionService->getConnection(), $sql);
	if (!$results) {
	    $error = new Error();
	    $error->setErrormessage($results->error);
	    return $error;
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
	    $results = mysqli_query($connectionService->getConnection(), $sql);
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
	    $message->setCreatedat($row['createdat']);
	    $message->setUpdatedat($row['updatedat']);
	    $messages[$row['id']] = $message;
	}
	$connectionService->disconnect();
	return $messages;
    }
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
    if (!$connectionService->getActive()) {
	$error = new Error();
	$error->setErrormessage($connectionService->error);
	return $error;
	return;
    } else {
	$sql = "SELECT p.id id_p,
		           p.createdat,
		           p.updatedat,
		           p.active,
		           p.fromuser,
		           p.name,
		           p.songcounter,
		           p.unlimited,
			   	   u.id id_u,
			       u.username
			       u.type
		     FROM playlist p, user u
             WHERE p.active = 1 AND p.fromuser = u.id";
	if (!is_null($id)) {
	    $sql .= " AND p.id = " . $id . "";
	}
	if (!is_null($where)) {
	    foreach ($where as $key => $value) {
		$sql .= " AND " . $key . " = '" . $value . "'";
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
	$results = mysqli_query($connectionService->getConnection(), $sql);
	if (!$results) {
	    $error = new Error();
	    $error->setErrormessage($results->error);
	    return $error;
	}
	while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
	    $rows[] = $row;
	$playlists = array();
	foreach ($rows as $row) {
	    require_once CLASSES_DIR . 'playlist.class.php';
	    $playlist = new Playlist();
	    $playlist->setId($row['id_p']);
	    $playlist->setActive($row['active']);
	    $playlist->setCreatedat($row['createdat']);
	    $fromuser = new User();
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
    if (!$connectionService->getActive()) {
	$error = new Error();
	$error->setErrormessage($connectionService->error);
	return $error;
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
                           pt.id_tag,
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
                     FROM comment p, user u, user fu, comment_tag pt
                     WHERE p.active = 1
                       	AND p.fromuser = u.id
		       			AND p.type = 'P'
		       			AND pt.id_comment = p.id";
	if (!is_null($id)) {
	    $sql .= " AND a.id = " . $id . "";
	}
	if (!is_null($where)) {
	    foreach ($where as $key => $value) {
		$sql .= " AND " . $key . " = '" . $value . "'";
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
	$results = mysqli_query($connectionService->getConnection(), $sql);
	if (!$results) {
	    $error = new Error();
	    $error->setErrormessage($results->error);
	    return $error;
	}
	while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
	    $rows[] = $row;
	$posts = array();
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
                         WHERE id = " . $row['id_c'];
	    $results = mysqli_query($connectionService->getConnection(), $sql);
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
	    $post->setCreatedat($row['createdat']);
	    $post->setUpdatedat($row['updatedat']);
	    $posts[$row['id']] = $post;
	}
	$connectionService->disconnect();
	return $posts;
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
    if (!$connectionService->getActive()) {
	$error = new Error();
	$error->setErrormessage($connectionService->error);
	return $error;
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
		$sql .= " AND " . $key . " = '" . $value . "'";
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
	$results = mysqli_query($connectionService->getConnection(), $sql);
	if (!$results) {
	    $error = new Error();
	    $error->setErrormessage($results->error);
	    return $error;
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
	    $results_genre = mysqli_query($connectionService->getConnection(), $sql);
	    if (!$results_genre) {
		$error = new Error();
		$error->setErrormessage($results_genre->error);
		return $error;
	    }
	    while ($row_genre = mysqli_fetch_array($results_genre, MYSQLI_ASSOC))
		$rows_genre[] = $row_genre;
	    $genres = array();
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
	    $record->setTracklist($row['tracklist']);
	    $record->setYear($row['year']);
	    $record->setCreatedat($row['createdat']);
	    $record->setUpdatedat($row['updatedat']);
	    $records[$row['id_r']] = $record;
	}
	$connectionService->disconnect();
	return $records;
    }
}

/**
 * \fn	    selectReviewEvent($id = null, $where = null, $order = null, $limit = null, $skip = null)
 * \brief   Select on Comment Class
 * \param   $id = null, $where = null, $order = null, $limit = null, $skip = null
 * \todo
 */
function selectReviewEvent($id = null, $where = null, $order = null, $limit = null, $skip = null) {
    $connectionService = new ConnectionService();
    $connectionService->connect();
    if (!$connectionService->getActive()) {
	$error = new Error();
	$error->setErrormessage($connectionService->error);
	return $error;
    } else {
	$sql = "SELECT	   rw.id id_rw,
                           rw.active,
                           rw.commentcounter,
                           rw.counter,
                           rw.fromuser,
                           rw.latitude,
                           rw.longitude,
                           rw.lovecounter,
                           rw.sharecounter,
                           rwt.id_tag,
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
                     FROM comment rw, user u, user fu, event e, comment_tag rwt
                     WHERE rw.active = 1
                       	AND rw.fromuser = fu.id
		       			AND rw.type = 'RE'
		       			AND rwt.id_comment = rw.id";
	if (!is_null($id)) {
	    $sql .= " AND a.id = " . $id . "";
	}
	if (!is_null($where)) {
	    foreach ($where as $key => $value) {
		$sql .= " AND " . $key . " = '" . $value . "'";
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
	$results = mysqli_query($connectionService->getConnection(), $sql);
	if (!$results) {
	    $error = new Error();
	    $error->setErrormessage($results->error);
	    return $error;
	}
	while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
	    $rows[] = $row;
	$reviewEvents = array();
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
	    $results_genre = mysqli_query($connectionService->getConnection(), $sql);
	    if (!$results_genre) {
		$error = new Error();
		$error->setErrormessage($results_genre->error);
		return $error;
	    }
	    while ($row_genre = mysqli_fetch_array($results, MYSQLI_ASSOC))
		$rows_genre[] = $row_genre;
	    $genres = array();
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
                         WHERE id = " . $row['id'];
	    $results_event = mysqli_query($connectionService->getConnection(), $sql);
	    if (!$results) {
		$error = new Error();
		$error->setErrormessage($results_event->error);
		return $error;
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
	    $results = mysqli_query($connectionService->getConnection(), $sql);
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
	    $reviewEvent->setTag($tags);
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
	$connectionService->disconnect();
	return $reviewEvents;
    }
}

/**
 * \fn	    selectReviewRecord($id = null, $where = null, $order = null, $limit = null, $skip = null)
 * \brief   Select on Comment Class
 * \param   $id = null, $where = null, $order = null, $limit = null, $skip = null
 * \todo
 */
function selectReviewRecord($id = null, $where = null, $order = null, $limit = null, $skip = null) {
    $connectionService = new ConnectionService();
    $connectionService->connect();
    if (!$connectionService->getActive()) {
	$error = new Error();
	$error->setErrormessage($connectionService->error);
	return $error;
    } else {
	$sql = "SELECT	   rw.id id_rw,
                           rw.active,
                           rw.commentcounter,
                           rw.counter,
                           rw.fromuser,
                           rw.latitude,
                           rw.longitude,
                           rw.lovecounter,
                           rw.sharecounter,
                           rwt.id_tag,
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
                     FROM comment rw, user u, user fu, record r, comment_tag rwt
                     WHERE rw.active = 1
                       AND rw.fromuser = fu.id
				       AND rw.type = 'RR'
				       AND rwt.id_comment = rw.id";
	if (!is_null($id)) {
	    $sql .= " AND a.id = " . $id . "";
	}
	if (!is_null($where)) {
	    foreach ($where as $key => $value) {
		$sql .= " AND " . $key . " = '" . $value . "'";
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
	$results = mysqli_query($connectionService->getConnection(), $sql);
	if (!$results) {
	    $error = new Error();
	    $error->setErrormessage($results->error);
	    return $error;
	}
	while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
	    $rows[] = $row;
	$reviewRecords = array();
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
	    $sql = "SELECT genre
                          FROM record_genre
                         WHERE id = " . $row['genre'];
	    $results_genre = mysqli_query($connectionService->getConnection(), $sql);
	    if (!$results_genre) {
		$error = new Error();
		$error->setErrormessage($results_genre->error);
		return $error;
	    }
	    while ($row_genre = mysqli_fetch_array($results_genre, MYSQLI_ASSOC))
		$rows_genre[] = $row_genre;
	    $genres = array();
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
	    $results = mysqli_query($connectionService->getConnection(), $sql);
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
	$connectionService->disconnect();
	return $reviewRecords;
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
    if (!$connectionService->getActive()) {
	$error = new Error();
	$error->setErrormessage($connectionService->error);
	return $error;
    } else {
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
			       r.title title_r
                 FROM song s, user u, record r
                WHERE s.active  = 1
                  AND s.fromuser = u.id";
	if (!is_null($id)) {
	    $sql .= " AND a.id = " . $id . "";
	}
	if (!is_null($where)) {
	    foreach ($where as $key => $value) {
		$sql .= " AND " . $key . " = '" . $value . "'";
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
	$results = mysqli_query($connectionService->getConnection(), $sql);
	if (!$results) {
	    $error = new Error();
	    $error->setErrormessage($results->error);
	    return $error;
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
	    $song->setCreatedat($row['createdat']);
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
	    $song->setUpdatedat($row['updatedat']);
	    $songs[$row['id']] = $song;
	}
	$connectionService->disconnect();
	return $songs;
    }
}

/**
 * \fn	    selectSongs($id = null, $where = null, $order = null, $limit = null, $skip = null)
 * \brief   Select on Post Class
 * \param   $id = null, $where = null, $order = null, $limit = null, $skip = null
 * \todo
 */
function selectSongsInPlaylist($id = null, $limit = 20, $skip = 0) {
    $connectionService = new ConnectionService();
    $connectionService->connect();
    if (!$connectionService->getActive()) {
	$error = new Error();
	$error->setErrormessage($connectionService->error);
	return $error;
    } else {
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
		  WHERE s.id = ps.id_song AND pl.fromuser = u.id AND s.record = r.id AND ps.playlist = pl.id s.active = 1";
	if (!is_null($id)) {
	    $sql .= " AND pl.id = " . $id . "";
	}
	if (!is_null($skip) && !is_null($limit)) {
	    $sql .= " LIMIT " . $skip . ", " . $limit;
	} elseif (is_null($skip) && !is_null($limit)) {
	    $sql .= " LIMIT " . $limit;
	}
	$results = mysqli_query($connectionService->getConnection(), $sql);
	if (!$results) {
	    $error = new Error();
	    $error->setErrormessage($results->error);
	    return $error;
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
	    $song->setCreatedat($row['createdat']);
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
	    $song->setUpdatedat($row['updatedat']);
	    $songs[$row['id_s']] = $song;
	}
    }
    $connectionService->disconnect();
    return $songs;
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
    if (!$connectionService->getActive()) {
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
		$sql .= " AND " . $key . " = '" . $value . "'";
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
	$results = mysqli_query($connectionService->getConnection(), $sql);
	if (!$results) {
	    $error = new Error();
	    $error->setErrormessage($results->error);
	    return $error;
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
	    #TODO vuole un datime 
//	    $user->setCreatedat($row['createdat']); 
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
//		$error = new Error();
//		$error->setErrormessage($results->error);
//		return $error;
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
	    #TODO vuole un datime 
//	    $user->setUpdatedat($row['updatedat']);
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

/**
 * \fn	    selectVideos($id = null, $where = null, $order = null, $limit = null, $skip = null)
 * \brief   Select on Post Class
 * \param   $id = null, $where = null, $order = null, $limit = null, $skip = null
 * \todo
 */
function selectVideos($id = null, $where = null, $order = null, $limit = null, $skip = null) {
    $connectionService = new ConnectionService();
    $connectionService->connect();
    if (!$connectionService->getActive()) {
	$error = new Error();
	$error->setErrormessage($connectionService->error);
	return $error;
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
	    $sql .= " AND a.id = " . $id . "";
	}
	if (!is_null($where)) {
	    foreach ($where as $key => $value) {
		$sql .= " AND " . $key . " = '" . $value . "'";
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
	$results = mysqli_query($connectionService->getConnection(), $sql);
	if (!$results) {
	    $error = new Error();
	    $error->setErrormessage($results->error);
	    return $error;
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
	    $video->setCreatedat($row['createdat']);
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
	    $results = mysqli_query($connectionService->getConnection(), $sql);
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
	    $video->setTag($tags);
	    $video->setThumbnail($row['thumbnail_v']);
	    $video->setTitle($row['title_v']);
	    $video->setURL($row['URL']);
	    $video->setUpdatedat($row['updatedat']);
	    $videos[$row['id_v']] = $video;
	}
	$connectionService->disconnect();
	return $videos;
    }
}

?>