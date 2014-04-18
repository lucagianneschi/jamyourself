<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once CLASSES_DIR . 'error.class.php';
require_once SERVICES_DIR . 'connection.service.php';
require_once SERVICES_DIR . 'log.service.php';
require_once SERVICES_DIR . 'utils.service.php';

/**
 * SelectSerive class 
 * funzioni per il recupero dei dati 
 * 
 * @author		Luca Gianneschi
 * @author Daniele Caldelli
 * @author Maria Laura Fresu
 * @version		0.2
 * @since		2014-03-17
 * @copyright		Jamyourself.com 2013	
 * @warning
 * @bug
 * @todo                
 */

/**
 * Check if a relation exist between 2 nodes
 * 
 * @param $fromNodeType,
 * @param $fromNodeId, 
 * @param $toNodeType, 
 * @param $toNodeId, 
 * @param $relationType
 * @todo
 */
function existsRelation($connection, $fromNodeType, $fromNodeId, $toNodeType, $toNodeId, $relationType) {
    $startTimer = microtime();
    $query = '
	MATCH (n:' . $fromNodeType . ' {id:' . $fromNodeId . '})-[r:' . $relationType . ']->(m:' . $toNodeType . ' {id:' . $toNodeId . '})
	RETURN count(r)
	';
    $res = $connection->curl($query);
    if ($res === false) {
	$endTimer = microtime();
	jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute existsRelation => ' . $query);
	return false;
    } else {
	if ($connection->getAutocommit()) {
	    $endTimer = microtime();
	    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Quantity Relation => ' . $res['data'][0][0]);
	    return $res['data'][0][0];
	} else {
	    $endTimer = microtime();
	    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Quantity Relation => ' . $res['results'][0]['data'][0]['row'][0]);
	    return $res['results'][0]['data'][0]['row'][0];
	}
    }
}

/**
 * Get list of nodes in relation with the first node
 * 
 * @param  $connection,
 * @param  $fromNodeType,
 * @param  $fromNodeId
 * @param  $toNodeType 
 * @param  $relationType
 * @param  $skip
 * @param  $limit
 * @return 
 * @todo
 */
function getRelatedNodes($connection, $fromNodeType, $fromNodeId, $toNodeType, $relationType, $skip = null, $limit = null) {
    $startTimer = microtime();
    $query = '
	MATCH (n:' . $fromNodeType . ' {id:' . $fromNodeId . '})-[r:' . $relationType . ']->(m:' . $toNodeType . ')
	RETURN m
	ORDER BY r.createdat DESC
	';
    if (!is_null($skip))
	$query .= ' SKIP ' . $skip;
    if (!is_null($limit))
	$query .= ' LIMIT ' . $limit;
    $params = array(
	'fromNodeId' => $fromNodeId
    );
    $res = $connection->curl($query, $params);
    if ($res === false) {
	$endTimer = microtime();
	jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute getRelatedNodes => ' . $query);
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
	$endTimer = microtime();
	jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Node related => ' . $relatedNodes);
	return $relatedNodes;
    }
}

/**
 * Execute generic query
 * 
 * @param   $ql string for query
 * @todo
 */
function query($connection, $sql) {
    $startTimer = microtime();
    $results = mysqli_query($connection, $sql);
    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
	$rows[] = $row;
    $endTimer = microtime();
    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Returned ' . count($rows) . ' rows => ' . $sql);
    return $rows;
}

/**
 * Select on Album Class
 * 
 * @param $id = null, 
 * @param $where = null, 
 * @param $order = null, 
 * @param $limit = null, 
 * @param $skip = null
 * @todo
 */
function selectAlbums($connection, $id = null, $where = null, $order = null, $limit = null, $skip = null) {
    $startTimer = microtime();
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
	$endTimer = microtime();
	jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute query => ' . $sql);
	return false;
    }
    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
	$rows_album[] = $row;
    $albums = array();
    if (!is_array($rows_album)) {
	$endTimer = microtime();
	jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] No rows returned');
	return $albums;
    }
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
	    jamLog(__FILE__, __LINE__, 'Unable to execute query => ' . $sql);
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
    $endTimer = microtime();
    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] ' . count($albums) . ' rows returned');
    return $albums;
}

/**
 * Select on Comment Class
 * 
 * @param $id = null, 
 * @param $where = null, 
 * @param $order = null, 
 * @param $limit = null, 
 * @param $skip = null
 * @todo  
 */
function selectComments($connection, $id = null, $where = null, $order = null, $limit = null, $skip = null) {
    $startTimer = microtime();
    $sql = "SELECT c.id id_c,
                   c.active,
                   c.album,
                   c.comment,
                   c.commentcounter,
                   c.counter,
                   c.event,
                   c.fromuser,
                   c.image,
                   c.latitude,
                   c.longitude,
                   c.lovecounter,
                   c.record,
                   c.sharecounter,
                   c.song,
                   c.text,
                   c.title,
                   c.touser,
                   c.type type_c,
                   c.video,
                   c.vote,
                   c.createdat,
                   c.updatedat,    
                   u.id id_u,
                   u.thumbnail thumbnail_u,
                   u.type type_u,
                   u.username username_u                   
              FROM comment c, user u
             WHERE c.active = 1
               AND c.fromuser = u.id";
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
		$sql .= " AND c." . $key . " IN (" . $inSql . ")";
	    } else {
		$sql .= " AND c." . $key . " = '" . $value . "'";
	    }
	}
    }
    if (!is_null($order)) {
	$sql .= " ORDER BY ";
	$last = end($order);
	foreach ($order as $key => $value) {
	    if ($last == $value)
		$sql .= " c." . $key . " " . $value;
	    else
		$sql .= " c." . $key . " " . $value . ",";
	}
    }
    if (!is_null($skip) && !is_null($limit)) {
	$sql .= " LIMIT " . $skip . ", " . $limit;
    } elseif (is_null($skip) && !is_null($limit)) {
	$sql .= " LIMIT " . $limit;
    }
    $results = mysqli_query($connection, $sql);
    if (!$results) {
	$endTimer = microtime();
	jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute query => ' . $sql);
	return false;
    }
    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
	$rows[] = $row;
    $comments = array();
    if (!is_array($rows)) {
	$endTimer = microtime();
	jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] No rows returned');
	return $comments;
    }
    foreach ($rows as $row) {
	require_once CLASSES_DIR . 'comment.class.php';
	$comment = new Comment();
	$comment->setId($row['id_c']);
	$comment->setActive($row['active']);
	$comment->setAlbum($row['album']);
	$comment->setComment($row['comment']);
	$comment->setCommentcounter($row['commentcounter']);
	$comment->setCounter($row['counter']);
	$comment->setEvent($row['event']);
	require_once CLASSES_DIR . 'user.class.php';
	$fromuser = new User();
	$fromuser->setId($row['id_u']);
	$fromuser->setThumbnail($row['thumbnail_u']);
	$fromuser->setType($row['type_u']);
	$fromuser->setUsername($row['username_u']);
	$comment->setFromuser($fromuser);
	$comment->setImage($row['image']);
	$comment->setLatitude($row['latitude']);
	$comment->setLovecounter($row['lovecounter']);
	$comment->setRecord($row['lovecounter']);
	$comment->setSharecounter($row['sharecounter']);
	$comment->setSong($row['song']);
	$sql = "SELECT tag
                  FROM comment_tag
                 WHERE id = " . $row['id_c'];
	$results_comment_tag = mysqli_query($connection, $sql);
	if (!$results_comment_tag) {
	    jamLog(__FILE__, __LINE__, 'Unable to execute query => ' . $sql);
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
	$comment->setText($row['text']);
	$comment->setTitle($row['title']);
	$comment->setType($row['type_c']);
	$comment->setUpdatedat($row['updatedat']);
	$comment->setTouser($row['touser']);
	$comment->setVideo($row['video']);
	$comment->setVote($row['vote']);
	$comment->setCreatedat(new DateTime($row['createdat']));
	$comment->setUpdatedat(new DateTime($row['updatedat']));
	$comments[$row['id_c']] = $comment;
    }
    $endTimer = microtime();
    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] ' . count($comments) . ' rows returned');
    return $comments;
}

/**
 * Select on Event Class
 * 
 * @param $id = null, 
 * @param $where = null, 
 * @param $order = null, 
 * @param $limit = null, 
 * @param $skip = null
 * @todo
 */
function selectEvents($connection, $id = null, $where = null, $order = null, $limit = null, $skip = null) {
    $startTimer = microtime();
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
	$endTimer = microtime();
	jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute query => ' . $sql);
	return false;
    }
    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
	$rows[] = $row;
    $events = array();
    if (!is_array($rows)) {
	$endTimer = microtime();
	jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] No rows returned');
	return $events;
    }
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
	require_once CLASSES_DIR . 'user.class.php';
	$fromuser = new User();
	$fromuser->setId($row['id_u']);
	$fromuser->setThumbnail($row['thumbnail_u']);
	$fromuser->setUsername($row['username']);
	$fromuser->setType($row['type']);
	$event->setFromuser($fromuser);
	$sql = "SELECT id_genre
		  FROM event_genre
		 WHERE id_event = " . $row['id_e'];
	$results_genre_event = mysqli_query($connection, $sql);
	if (!$results_genre_event) {
	    jamLog(__FILE__, __LINE__, 'Unable to execute query => ' . $sql);
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
	    jamLog(__FILE__, __LINE__, 'Unable to execute query => ' . $sql);
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
    $endTimer = microtime();
    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] ' . count($events) . ' rows returned');
    return $events;
}

/**
 * Select on Post Class
 * 
 * @param $id = null, 
 * @param $where = null, 
 * @param $order = null, 
 * @param $limit = null, 
 * @param $skip = null
 * @todo
 */
function selectImages($connection, $id = null, $where = null, $order = null, $limit = null, $skip = null) {
    $startTimer = microtime();
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
	$endTimer = microtime();
	jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute query => ' . $sql);
	return false;
    }
    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
	$rows[] = $row;
    $images = array();
    if (!is_array($rows)) {
	$endTimer = microtime();
	jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] No rows returned');
	return $images;
    }
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
	    jamLog(__FILE__, __LINE__, 'Unable to execute query => ' . $sql);
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
    $endTimer = microtime();
    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] ' . count($images) . ' rows returned');
    return $images;
}

/**
 * Select on Comment Class, messages
 * 
 * @param $id = null, 
 * @param $where = null, 
 * @param $order = null, 
 * @param $limit = null, 
 * @param $skip = null
 * @todo
 */
function selectMessages($connection, $id = null, $where = null, $order = null, $limit = null, $skip = null) {
    $startTimer = microtime();
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
	$endTimer = microtime();
	jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute query => ' . $sql);
	return false;
    }
    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
	$rows[] = $row;
    $messages = array();
    if (!is_array($rows)) {
	$endTimer = microtime();
	jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] No rows returned');
	return $messages;
    }
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
	    jamLog(__FILE__, __LINE__, 'Unable to execute query => ' . $sql);
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
    $endTimer = microtime();
    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] ' . count($messages) . ' rows returned');
    return $messages;
}

/**
 * Select on Playlist Class
 * 
 * @param $id = null, 
 * @param $where = null, 
 * @param $order = null, 
 * @param $limit = null, 
 * @param $skip = null
 * @todo
 */
function selectPlaylists($connection, $id = null, $where = null, $order = null, $limit = null, $skip = null) {
    $startTimer = microtime();
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
	$endTimer = microtime();
	jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute query => ' . $sql);
	return false;
    }
    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
	$rows[] = $row;
    $playlists = array();
    if (!is_array($rows)) {
	$endTimer = microtime();
	jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] No rows returned');
	return $playlists;
    }
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
    $endTimer = microtime();
    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] ' . count($playlists) . ' rows returned');
    return $playlists;
}

/**
 * 
 * Select on Post Class
 * 
 * @param $id = null, 
 * @param $where = null, 
 * @param $order = null, 
 * @param $limit = null, 
 * @param $skip = null
 * @todo
 */
function selectPosts($connection, $id = null, $where = null, $order = null, $limit = null, $skip = null) {
    $startTimer = microtime();
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
                      AND p.fromuser = fu.id
                      AND p.touser = u.id
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
	$endTimer = microtime();
	jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute query => ' . $sql);
	return false;
    }
    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
	$rows[] = $row;
    $posts = array();
    if (!is_array($rows))
	return $posts;
    if (!is_array($rows)) {
	$endTimer = microtime();
	jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] No rows returned');
	return $posts;
    }
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
	    jamLog(__FILE__, __LINE__, 'Unable to execute query => ' . $sql);
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
    $endTimer = microtime();
    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] ' . count($posts) . ' rows returned');
    return $posts;
}

/**
 * Select on Record Class
 * 
 * @param $id = null, 
 * @param $where = null, 
 * @param $order = null, 
 * @param $limit = null, 
 * @param $skip = null
 * @todo
 */
function selectRecords($connection, $id = null, $where = null, $order = null, $limit = null, $skip = null) {
    $startTimer = microtime();
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
	$endTimer = microtime();
	jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute query => ' . $sql);
	return false;
    }
    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
	$rows[] = $row;
    $records = array();
    if (!is_array($rows)) {
	$endTimer = microtime();
	jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] No rows returned');
	return $records;
    }
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
	$fromuser->setType($row['type']);
	$record->setFromuser($fromuser);
	$sql = "SELECT g.genre
                          FROM record_genre rg, genre g
                         WHERE rg.id_record = " . $row['id_r'] . "
                           AND g.id = rg.id_genre";
	$results_genre = mysqli_query($connection, $sql);
	if (!$results_genre) {
	    jamLog(__FILE__, __LINE__, 'Unable to execute query => ' . $sql);
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
    $endTimer = microtime();
    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] ' . count($records) . ' rows returned');
    return $records;
}

/**
 * Select on Comment Class, Review Event
 * 
 * @param $id = null, 
 * @param $where = null, 
 * @param $order = null, 
 * @param $limit = null, 
 * @param $skip = null
 * @todo
 */
function selectReviewEvent($connection, $id = null, $where = null, $order = null, $limit = null, $skip = null) {
    $startTimer = microtime();
    $sql = "SELECT	   rw.id id_rw,
                           rw.active active_rw,
                           rw.commentcounter commentcounter_rw,
                           rw.counter counter_rw,
                           rw.fromuser,
                           rw.latitude latitude_rw,
                           rw.longitude longitude_rw,
                           rw.lovecounter lovecounter_rw,
                           rw.sharecounter sharecounter_rw,
                           rw.text text_rw,
                           rw.touser,
                           rw.type type_p,
                           rw.vote vote_rw,
                           rw.createdat createdat_rw,
                           rw.updatedat updatedat_rw,
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
                       	AND rw.fromuser = fu.id AND rw.touser = u.id AND e.id = rw.event
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
	$endTimer = microtime();
	jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute query => ' . $sql);
	return false;
    }
    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
	$rows[] = $row;
    $reviewEvents = array();
    if (!is_array($rows)) {
	$endTimer = microtime();
	jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] No rows returned');
	return $reviewEvents;
    }
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
	$sql = "SELECT id_genre
		  FROM event_genre
		 WHERE id_event = " . $row['id_e'];
	$results_genre_event = mysqli_query($connection, $sql);
	if (!$results_genre_event) {
	    jamLog(__FILE__, __LINE__, 'Unable to execute query => ' . $sql);
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
	    $error = new Error();
	    $error->setErrormessage($results_event->error);
	    return $error;
	}
	$tags_event = array();
	$rows_tag = array();
	while ($row_tag = mysqli_fetch_array($results_event, MYSQLI_ASSOC))
	    $rows_tag[] = $row_tag;
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
	    jamLog(__FILE__, __LINE__, 'Unable to execute query => ' . $sql);
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
	$reviewEvent->setText($row['text_rw']);
	$reviewEvent->setTitle($row['title_rw']);
	$touser = new User();
	$touser->setId($row['id_u']);
	$touser->setThumbnail($row['thumbnail_u']);
	$touser->setUsername($row['username_u']);
	$touser->setType($row['type_u']);
	$reviewEvent->setTouser($touser);
	$reviewEvent->setType($row['type_rw']);
	$reviewEvent->setVote($row['vote_rw']);
	$reviewEvent->setCreatedat($row['createdat_rw']);
	$reviewEvent->setUpdatedat($row['updatedat_rw']);
	$reviewEvents[$row['id_rw']] = $reviewEvent;
    }
    $endTimer = microtime();
    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] ' . count($reviewEvents) . ' rows returned');
    return $reviewEvents;
}

/**
 * Select on Comment Class, Review Record
 * 
 * @param $id = null, 
 * @param $where = null, 
 * @param $order = null, 
 * @param $limit = null, 
 * @param $skip = null
 * @todo
 */
function selectReviewRecord($connection, $id = null, $where = null, $order = null, $limit = null, $skip = null) {
    $startTimer = microtime();
    $sql = "SELECT	   rw.id id_rw,
                           rw.active active_rw,
                           rw.commentcounter commentcounter_rw,
                           rw.counter counter_rw,
                           rw.fromuser,
                           rw.latitude latitude_rw,
                           rw.longitude longitude_rw,
                           rw.lovecounter lovecounter_rw,
                           rw.sharecounter sharecounter_rw,
                           rw.text text_rw,
                           rw.touser touser_rw,
                           rw.type type_p,
                           rw.vote vote_rw,
                           rw.createdat createdat_rw,
                           rw.updatedat updatedat_rw,
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
                       AND rw.fromuser = fu.id AND rw.touser = u.id AND r.id = rw.record
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
	$endTimer = microtime();
	jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute query => ' . $sql);
	return false;
    }
    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
	$rows[] = $row;
    $reviewRecords = array();
    if (!is_array($rows)) {
	$endTimer = microtime();
	jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] No rows returned');
	return $reviewRecords;
    }
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
	    jamLog(__FILE__, __LINE__, 'Unable to execute query => ' . $sql);
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
	    jamLog(__FILE__, __LINE__, 'Unable to execute query => ' . $sql);
	    return false;
	}
	$tags = array();
	$rows_tag = array();
	while ($row_tag = mysqli_fetch_array($results, MYSQLI_ASSOC))
	    $rows_tag[] = $row_tag;
	foreach ($rows_tag as $row_tag) {
	    $tags[] = $row_tag;
	}
	$reviewRecord->setTag($tags);
	$reviewRecord->setText($row['text_rw']);
	$reviewRecord->setTitle($row['title_rw']);
	$touser = new User();
	$touser->setId($row['id_u']);
	$touser->setThumbnail($row['thumbnail_u']);
	$touser->setUsername($row['username_u']);
	$touser->setType($row['type_u']);
	$reviewRecord->setTouser($touser);
	$reviewRecord->setType($row['type_rw']);
	$reviewRecord->setVote($row['vote_rw']);
	$reviewRecord->setCreatedat($row['createdat_rw']);
	$reviewRecord->setUpdatedat($row['updatedat_rw']);
	$reviewRecords[$row['id_rw']] = $reviewRecord;
    }
    $endTimer = microtime();
    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] ' . count($reviewRecords) . ' rows returned');
    return $reviewRecords;
}

/**
 * Select on Song Class
 * 
 * @param $id = null, 
 * @param $where = null, 
 * @param $order = null, 
 * @param $limit = null, 
 * @param $skip = null
 * @todo
 */
function selectSongs($connection, $id = null, $where = null, $order = null, $limit = null, $skip = null) {
    $startTimer = microtime();
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
	$endTimer = microtime();
	jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute query => ' . $sql);
	return false;
    }
    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
	$rows[] = $row;
    $songs = array();
    if (!is_array($rows)) {
	$endTimer = microtime();
	jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] No rows returned');
	return $songs;
    }
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
	$sql = "SELECT g.genre
              FROM song_genre sg, genre g
             WHERE sg.id_song = " . $row['id_s'] . "
               AND g.id = sg.id_genre";
	$results_genre = mysqli_query($connection, $sql);
	if (!$results_genre) {
	    $endTimer = microtime();
	    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute query => ' . $sql);
	    return false;
	}
	$genres = array();
	$rows_genre = array();
	while ($row_genre = mysqli_fetch_array($results_genre, MYSQLI_ASSOC))
	    $rows_genre[] = $row_genre;
	foreach ($rows_genre as $row_genre) {
	    $genres[] = $row_genre;
	}
	$song->setGenre($genres);
	$song->setLatitude($row['latitude']);
	$song->setLongitude($row['longitude']);
	$song->setLovecounter($row['lovecounter']);
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
    $endTimer = microtime();
    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] ' . count($songs) . ' rows returned');
    return $songs;
}

/**
 * Select on Song in Playlist
 * 
 * @param $id = null, 
 * @param $where = null, 
 * @param $order = null, 
 * @param $limit = null, 
 * @param $skip = null
 * @todo
 */
function selectSongsInPlaylist($connection, $id = null, $limit = 20, $skip = 0) {
    $startTimer = microtime();
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
	$endTimer = microtime();
	jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute query => ' . $sql);
	return false;
    }
    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
	$rows[] = $row;
    $songs = array();
    if (!is_array($rows)) {
	$endTimer = microtime();
	jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] No rows returned');
	return $songs;
    }
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
    $endTimer = microtime();
    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] ' . count($songs) . ' rows returned');
    return $songs;
}

/**
 * Select on User Class
 * 
 * @param $id = null, 
 * @param $where = null, 
 * @param $order = null, 
 * @param $limit = null, 
 * @param $skip = null
 * @todo
 */
function selectUsers($connection, $id = null, $where = null, $order = null, $limit = null, $skip = null) {
    $startTimer = microtime();
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
	$endTimer = microtime();
	jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute query => ' . $sql);
	return false;
    }
    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
	$rows[] = $row;
    $users = array();
    if (!is_array($rows)) {
	$endTimer = microtime();
	jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] No rows returned');
	return $users;
    }
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
	$user->setFollowercounter($row['followerscounter']);
	$user->setFollowingcounter($row['followingcounter']);
	$user->setFriendshipcounter($row['friendshipcounter']);
	$user->setGooglepluspage($row['googlepluspage']);
	$user->setJammercounter($row['jammercounter']);
	$user->setJammertype($row['jammertype']);
	$user->setLastname($row['lastname']);
	$user->setLevel($row['level']);
	$user->setLevelvalue($row['levelvalue']);
	$user->setLatitude($row['latitude']);
	//$user->setLocaltype($row['localtype']);
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
//	    $sql = "SELECT music
//                          FROM user_music
//                         WHERE id = " . $row['id'];
//	    $results = mysqli_query($connectionService->getConnection(), $sql);
//	    if (!$results) {
//	jamLog (__FILE__, __LINE__, 'Unable to execute query');
//	return false;
//	    }
//	    while ($row_setting = mysqli_fetch_array($results, MYSQLI_ASSOC))
//		$rows_musics[] = $row_music;
//	    $music = array();
//	    foreach ($rows_musics as music) {
//		$musics[] = $music;
//	    }
//	    $user->setMusic($musics);
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
    $endTimer = microtime();
    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] ' . count($users) . ' rows returned');
    return $users;
}

/**
 * Select on Video Class
 * 
 * @param $id = null, 
 * @param $where = null, 
 * @param $order = null, 
 * @param $limit = null, 
 * @param $skip = null
 * @todo
 */
function selectVideos($connection, $id = null, $where = null, $order = null, $limit = null, $skip = null) {
    $startTimer = microtime();
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
	$endTimer = microtime();
	jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute query => ' . $sql);
	return false;
    }
    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
	$rows[] = $row;
    $videos = array();
    if (!is_array($rows)) {
	$endTimer = microtime();
	jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] No rows returned');
	return $videos;
    }
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
	    jamLog(__FILE__, __LINE__, 'Unable to execute query => ' . $sql);
	    return false;
	}
	$tags = array();
	$rows_tag = array();
	while ($row_tag = mysqli_fetch_array($results_tag, MYSQLI_ASSOC))
	    $rows_tag[] = $row_tag;
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
    $endTimer = microtime();
    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] ' . count($videos) . ' rows returned');
    return $videos;
}

?>