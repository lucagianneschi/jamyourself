<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'connection.service.php';
require_once SERVICES_DIR . 'log.service.php';

/**
 * Servizio inserimento dei record nel DB
 *
 * @author Daniele Caldelli
 * @author Maria Laura Fresu
 * @author Luca Gianneschi
 * @version		0.2
 * @since		2014-03-12
 * @copyright		Jamyourself.com 2013
 * @warning
 * @bug
 * @todo
 */

/**
 * Create node on the node4J DB
 * 
 * @param $connection
 * @param $nodeType,
 * @param $nodeId
 * @todo
 */
function createNode($connection, $nodeType, $nodeId) {
    $query = '
	MERGE (n:' . $nodeType . ' {id:' . $nodeId . '})
	RETURN count(n)
	';
    $res = $connection->curl($query);
    if ($res === false) {
	return false;
    } else {
	if ($connection->getAutocommit()) {
	    $num = $res['data'][0][0];
	    return ($num ? $num : false);
	} else {
	    $num = $res['results'][0]['data'][0]['row'][0];
	    return ($num ? $num : false);
	}
    }
}

/**
 * Create relation between nodes on the node4J DB
 * 
 * @param $connection
 * @param $fromNodeType
 * @param $fromNodeId
 * @param $otNodeType,
 * @param $toNodeId
 * @param $relType
 * @todo
 */
function createRelation($connection, $fromNodeType, $fromNodeId, $toNodeType, $toNodeId, $relType) {
    $query = '
	MATCH (n:' . $fromNodeType . ' {id:' . $fromNodeId . '}), (m:' . $toNodeType . ' {id:' . $toNodeId . '})
	MERGE (n)-[r:' . $relType . ']->(m)
	ON CREATE SET r.createdat = ' . date('YmdHis') . '
	ON MATCH SET r.createdat = ' . date('YmdHis') . '
	RETURN count(r)
	';
    $res = $connection->curl($query);
    if ($res === false) {
	return false;
    } else {
	if ($connection->getAutocommit()) {
	    $num = $res['data'][0][0];
	    return ($num ? $num : false);
	} else {
	    $num = $res['results'][0]['data'][0]['row'][0];
	    return ($num ? $num : false);
	}
    }
}

/**
 * Execute an insert operation of the $album
 * 
 * @param $connection
 * @param  $album object the user to insert
 * @todo
 */
function insertAlbum($connection, $album) {
    $startTimer = microtime();
    $sql = "INSERT INTO album (id,
			active,
			commentcounter,
			counter,
			cover,
			description,
			fromuser,
			imagecounter,
			latitude,
			longitude,
			lovecounter,
			sharecounter,
			thumbnail,
			title,
			createdat,
			updatedat)
			VALUES (NULL,
				  '" . (is_null($album->getActive()) ? 0 : $album->getActive()) . "',
                                  '" . (is_null($album->getCommentcounter()) ? 0 : $album->getCommentcounter()) . "',
                                  '" . (is_null($album->getCounter()) ? 0 : $album->getCounter()) . "',
                                  '" . $album->getCover() . "',
                                  '" . $album->getDescription() . "',
                                  '" . (is_null($album->getFromuser()) ? 0 : $album->getFromuser()) . "',
                                  '" . (is_null($album->getImagecounter()) ? 0 : $album->getImagecounter()) . "',
                                  '" . (is_null($album->getLatitude()) ? 0 : $album->getLatitude()) . "',
                                  '" . (is_null($album->getLongitude()) ? 0 : $album->getLongitude()) . "',
                                  '" . (is_null($album->getLovecounter()) ? 0 : $album->getLovecounter()) . "',
                                  '" . (is_null($album->getSharecounter()) ? 0 : $album->getSharecounter()) . "',
                                  '" . $album->getThumbnail() . "',
                                  '" . $album->getTitle() . "',
                                  NOW(),
                                  NOW())";
    $result = mysqli_query($connection, $sql);
    if ($result === false) {
	$endTimer = microtime();
	jamLog(__FILE__, __LINE__, ' [Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute insertAlbum => ' . $sql);
	return false;
    } else {
	$insert_id = mysqli_insert_id($connection);
	if (is_array($album->getTag())) {
	    foreach ($album->getTag() as $tag) {
		$sql = "INSERT INTO album_tag (id,
						tag)
						VALUES (" . $insert_id . ",
							'" . $tag . "')";
		$result_tag = mysqli_query($connection, $sql);
		if ($result_tag === false) {
		    $endTimer = microtime();
		    jamLog(__FILE__, __LINE__, ' [Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute insertAlbum - album_tag => ' . $sql);
		    return false;
		}
	    }
	}
	$endTimer = microtime();
	jamLog(__FILE__, __LINE__, ' [Execution time: ' . executionTime($startTimer, $endTimer) . '] ' . $insert_id . 'ID returned');
	return $insert_id;
    }
}

/**
 * Execute an insert operation of the $comment
 * 
 * @param $connection
 * @param  $comment object the user to insert
 * @todo
 */
function insertComment($connection, $comment) {
    $startTimer = microtime();
    require_once CLASSES_DIR . 'comment.class.php';
    $sql = "INSERT INTO comment (id,
                                    active,
                                    album,
                                    comment,
                                    commentcounter,
                                    counter,
                                    event,
                                    fromuser,
                                    image,
                                    latitude,
                                    longitude,
                                    lovecounter,
                                    record,
                                    sharecounter,                                    
                                    title,
                                    text,
                                    touser,
                                    type,
                                    vote,
                                    createdat,
                                    updatedat)
                          VALUES (NULL,
                                  '" . (is_null($comment->getActive()) ? 0 : $comment->getActive()) . "',
                                  '" . (is_null($comment->getAlbum()) ? 0 : $comment->getAlbum()) . "',
                                  '" . (is_null($comment->getComment()) ? 0 : $comment->getComment()) . "',  
                                  '" . (is_null($comment->getCommentcounter()) ? 0 : $comment->getCommentcounter()) . "',      
                                  '" . (is_null($comment->getCounter()) ? 0 : $comment->getCounter()) . "',
                                  '" . (is_null($comment->getEvent()) ? 0 : $comment->getEvent()) . "',
                                  '" . (is_null($comment->getFromuser()) ? 0 : $comment->getFromuser()) . "',  
                                  '" . (is_null($comment->getImage()) ? 0 : $comment->getImage()) . "',
                                  '" . (is_null($comment->getLatitude()) ? 0 : $comment->getLatitude()) . "',
                                  '" . (is_null($comment->getLongitude()) ? 0 : $comment->getLongitude()) . "',
                                  '" . (is_null($comment->getLovecounter()) ? 0 : $comment->getLovecounter()) . "',
                                  '" . (is_null($comment->getRecord()) ? 0 : $comment->getRecord()) . "',
                                  '" . (is_null($comment->getSharecounter()) ? 0 : $comment->getSharecounter()) . "',
                                  '" . $comment->getTitle() . "',                                    
                                  '" . $comment->getText() . "',                                  
                                  '" . (is_null($comment->getTouser()) ? 0 : $comment->getTouser()) . "',      
                                  '" . $comment->getType() . "',
                                  '" . (is_null($comment->getVote()) ? 0 : $comment->getVote()) . "',
                                  NOW(),
                                  NOW())";
    $result = mysqli_query($connection, $sql);
    if ($result === false) {
	$endTimer = microtime();
	jamLog(__FILE__, __LINE__, ' [Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute insertComment => ' . $sql);
	return false;
    } else {
	$insert_id = mysqli_insert_id($connection);
	if (is_array($comment->getTag())) {
	    foreach ($comment->getTag() as $tag) {
		$sql = "INSERT INTO comment_tag (id,
						tag)
						VALUES (" . $insert_id . ",
							'" . $tag . "')";
		$result_tag = mysqli_query($connection, $sql);
		if ($result_tag === false) {
		    $endTimer = microtime();
		    jamLog(__FILE__, __LINE__, ' [Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute insertComment - comment_tag => ' . $sql);
		    return false;
		}
	    }
	}
	$endTimer = microtime();
	jamLog(__FILE__, __LINE__, ' [Execution time: ' . executionTime($startTimer, $endTimer) . '] ' . $insert_id . 'ID returned');
	return $insert_id;
    }
}

/**
 * Execute an insert operation of the $event
 * 
 * @param $connection
 * @param  $event object the user to insert
 * @todo
 */
function insertEvent($connection, $event) {
    $startTimer = microtime();
    require_once CLASSES_DIR . 'event.class.php';
    $sql = "INSERT INTO event ( id,
                                    active,
                                    address,
                                    attendeecounter,
                                    cancelledcounter,
                                    city,
                                    commentcounter,
                                    counter,
                                    cover,
                                    description,
                                    eventdate,
                                    fromuser,
                                    invitedcounter,
                                    latitude,
                                    locationname,
                                    longitude,
                                    lovecounter,
                                    reviewcounter,
                                    refusedcounter,
                                    sharecounter,
                                    thumbnail,
                                    title,
                                    createdat,
                                    updatedat)
                          VALUES (NULL,
			  	  			'" . (is_null($event->getActive()) ? 0 : $event->getActive()) . "',
							'" . $event->getAddress() . "',    
				  			'" . (is_null($event->getAttendeecounter()) ? 0 : $event->getAttendeecounter()) . "',
				  			'" . (is_null($event->getCancelledcounter()) ? 0 : $event->getCancelledcounter()) . "',
						        '" . $event->getCity() . "',   
				  			'" . (is_null($event->getCommentcounter()) ? 0 : $event->getCommentcounter()) . "',
                            '" . (is_null($event->getCounter()) ? 0 : $event->getCounter()) . "',
                            '" . $event->getCover() . "',
                            '" . $event->getDescription() . "',
			    '" . (is_null($event->getEventdate()) ? 0 : $event->getEventdate()->format('Y-m-d H:i:s')) . "',
				  			'" . (is_null($event->getFromuser()) ? 0 : $event->getFromuser()) . "', 
				  			'" . (is_null($event->getInvitedcounter()) ? 0 : $event->getInvitedcounter()) . "',       
				  			'" . (is_null($event->getLatitude()) ? 0 : $event->getLatitude()) . "',                                         
                            '" . $event->getLocationname() . "',                                      
				  			'" . (is_null($event->getLongitude()) ? 0 : $event->getLongitude()) . "',
				  			'" . (is_null($event->getLovecounter()) ? 0 : $event->getLovecounter()) . "',
				  			'" . (is_null($event->getReviewcounter()) ? 0 : $event->getReviewcounter()) . "',
				  			'" . (is_null($event->getRefusedcounter()) ? 0 : $event->getRefusedcounter()) . "',
				  			'" . (is_null($event->getSharecounter()) ? 0 : $event->getSharecounter()) . "',
                            '" . $event->getThumbnail() . "',
                            '" . $event->getTitle() . "',   
                            NOW(),
                            NOW())";
    $result = mysqli_query($connection, $sql);
    if ($result === false) {
	$endTimer = microtime();
	jamLog(__FILE__, __LINE__, ' [Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute insertEvent => ' . $sql);
	return false;
    } else {
	$insert_id = mysqli_insert_id($connection);
	if (is_array($event->getGenre())) {
	    foreach ($event->getGenre() as $genre) {
		$sql = "INSERT INTO event_genre (id_event,
							id_genre)
							VALUES (" . $insert_id . ",
								'" . $genre . "')";
		$result = mysqli_query($connection, $sql);
		if ($result === false) {
		    $endTimer = microtime();
		    jamLog(__FILE__, __LINE__, ' [Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute insertEvent - event_genre => ' . $sql);
		    return false;
		}
	    }
	}
	if (is_array($event->getTag())) {
	    foreach ($event->getTag() as $tag) {
		$sql = "INSERT INTO event_tag (id,
						tag)
						VALUES (" . $insert_id . ",
							'" . $tag . "')";
		$result = mysqli_query($connection, $sql);
		if ($result === false) {
		    $endTimer = microtime();
		    jamLog(__FILE__, __LINE__, ' [Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute insertEvent - event_tag => ' . $sql);
		    return false;
		}
	    }
	}
    }
    $endTimer = microtime();
    jamLog(__FILE__, __LINE__, ' [Execution time: ' . executionTime($startTimer, $endTimer) . '] ' . $insert_id . 'ID returned');
    $event->setId($insert_id);
    return ($event);
}

/**
 * Execute an insert operation of the $image
 * 
 * @param $connection
 * @param  $image object the user to insert
 * @todo
 */
function insertImage($connection, $image) {
    $startTimer = microtime();
    require_once CLASSES_DIR . 'image.class.php';
    $sql = "INSERT INTO image ( id,
                                    active,
                                    album,
                                    commentcounter,
                                    counter,
                                    description,
                                    fromuser,
                                    latitude,
                                    longitude,
                                    lovecounter,
				    path,
                                    sharecounter,
                                    thumbnail,
                                    createdat,
                                    updatedat)
                          VALUES (NULL,
				  			'" . (is_null($image->getActive()) ? 0 : $image->getActive()) . "',
				  			'" . (is_null($image->getAlbum()) ? 0 : $image->getAlbum()) . "',
                            '" . (is_null($image->getCommentcounter()) ? 0 : $image->getCommentcounter()) . "',
                            '" . (is_null($image->getCounter()) ? 0 : $image->getCounter()) . "',
                            '" . (is_null($image->getDescription()) ? 0 : $image->getDescription()) . "',
                            '" . (is_null($image->getFromuser()) ? 0 : $image->getFromuser()) . "',
                            '" . (is_null($image->getLatitude()) ? 0 : $image->getLatitude()) . "',                                             
                            '" . (is_null($image->getLongitude()) ? 0 : $image->getLongitude()) . "',                                    
                            '" . (is_null($image->getLovecounter()) ? 0 : $image->getLovecounter()) . "',
				  			'" . $image->getPath() . "',
                            '" . (is_null($image->getSharecounter()) ? 0 : $image->getSharecounter()) . "', 
                            '" . $image->getThumbnail() . "',   
                            NOW(),
                            NOW())";
    $result = mysqli_query($connection, $sql);
    if ($result === false) {
	$endTimer = microtime();
	jamLog(__FILE__, __LINE__, ' [Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute insertImage => ' . $sql);
	return false;
    } else {
	$insert_id = mysqli_insert_id($connection);
	if (is_array($image->getTag())) {
	    foreach ($image->getTag() as $tag) {
		$sql = "INSERT INTO image_tag (id,
						tag)
						VALUES (" . $insert_id . ",
							'" . $tag . "')";
		$result_tag = mysqli_query($connection, $sql);
		if ($result_tag === false) {
		    $endTimer = microtime();
		    jamLog(__FILE__, __LINE__, ' [Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute insertImage - image_tag => ' . $sql);
		    return false;
		}
	    }
	}
    }
    $endTimer = microtime();
    jamLog(__FILE__, __LINE__, ' [Execution time: ' . executionTime($startTimer, $endTimer) . '] ' . $insert_id . 'ID returned');
    $image->setId($insert_id);
    return $image;
}

/**
 * Execute an insert operation of the $playlist
 * 
 * 
 * @param $connection
 * @param  $playlist object the user to insert
 * @todo
 */
function insertPlaylist($connection, $playlist) {
    $startTimer = microtime();
    require_once CLASSES_DIR . 'playlist.class.php';
    $sql = "INSERT INTO playlist ( id,
                                    active,
                                    fromuser,
                                    name,
                                    songcounter,
                                    createdat,
                                    updatedat)
                          VALUES (NULL,
			  	  '" . (is_null($playlist->getActive()) ? 0 : $playlist->getActive()) . "',
                                  '" . (is_null($playlist->getFromuser()) ? 0 : $playlist->getFromuser()) . "',
                                  '" . $playlist->getFromuser() . "',                                              
                                  '" . $playlist->getName() . "',
				  '" . (is_null($playlist->getSongcounter()) ? 0 : $playlist->getSongcounter()) . "',  
                                  NOW(),
                                  NOW())";
    $result = mysqli_query($connection, $sql);
    if ($result === false) {
	$endTimer = microtime();
	jamLog(__FILE__, __LINE__, ' [Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute insertPlaylist => ' . $sql);
	return false;
    } else {
	$insert_id = mysqli_insert_id($connection);
	$endTimer = microtime();
	jamLog(__FILE__, __LINE__, ' [Execution time: ' . executionTime($startTimer, $endTimer) . '] ' . $insert_id . 'ID returned');
	return $insert_id;
    }
}

/**
 * Execute an insert operation of the $record
 * 
 * @param $connection
 * @param  $record object the user to insert
 * @todo
 */
function insertRecord($connection, $record) {
    $startTimer = microtime();
    require_once CLASSES_DIR . 'record.class.php';
    $sql = "INSERT INTO record ( id,
                                    active,
                                    buylink,
                                    commentcounter,
                                    counter,
                                    cover,
                                    description,
                                    duration,
                                    fromuser,
                                    label,
                                    latitude,
                                    longitude,
                                    lovecounter,
                                    reviewCounter,
                                    sharecounter,
                                    songCounter,
                                    thumbnail,
                                    title,
                                    year,
                                    createdat,
                                    updatedat)
                          VALUES (NULL,
			  	  '" . (is_null($record->getActive()) ? 0 : $record->getActive()) . "',
                                  '" . $record->getActive() . "',
                                  '" . $record->getBuylink() . "', 
				  '" . (is_null($record->getCommentcounter()) ? 0 : $record->getCommentcounter()) . "',
                                  '" . (is_null($record->getCounter()) ? 0 : $record->getCounter()) . "',
                                  '" . $record->getCover() . "',                                              
                                  '" . $record->getDescription() . "',
				  '" . (is_null($record->getDuration()) ? 0 : $record->getDuration()) . "',
				  '" . (is_null($record->getFromuser()) ? 0 : $record->getFromuser()) . "',                                             
                                  '" . $record->getLabel() . "',
				  '" . (is_null($record->getLatitude()) ? 0 : $record->getLatitude()) . "',
				  '" . (is_null($record->getLongitude()) ? 0 : $record->getLongitude()) . "',
				  '" . (is_null($record->getLovecounter()) ? 0 : $record->getLovecounter()) . "',
				  '" . (is_null($record->getReviewcounter()) ? 0 : $record->getReviewcounter()) . "',
				  '" . (is_null($record->getSharecounter()) ? 0 : $record->getSharecounter()) . "',
                                  '" . (is_null($record->getSongcounter()) ? 0 : $record->getSongcounter()) . "', 
                                  '" . $record->getThumbnail() . "',
                                  '" . $record->getTitle() . "',
				  '" . (is_null($record->getYear()) ? 0 : $record->getYear()) . "',
                                  NOW(),
                                  NOW())";
    $result = mysqli_query($connection, $sql);
    if ($result === false) {
	$endTimer = microtime();
	jamLog(__FILE__, __LINE__, ' [Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute insertPlaylist => ' . $sql);
	return false;
    } else {
	$insert_id = mysqli_insert_id($connection);
	if (is_array($record->getGenre())) {
	    foreach ($record->getGenre() as $genre) {
		$sql = "INSERT INTO record_genre (id,
						genre)
						VALUES (" . $insert_id . ",
							'" . $genre . "')";
		$result_genre = mysqli_query($connection, $sql);
		if ($result_genre === false) {
		    $endTimer = microtime();
		    jamLog(__FILE__, __LINE__, ' [Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute insertRecord - record_genre => ' . $sql);
		    return false;
		}
	    }
	}
	if (is_array($record->getTag())) {
	    foreach ($record->getTag() as $tag) {
		$sql = "INSERT INTO record_tag (id,
						tag)
						VALUES (" . $insert_id . ",
							'" . $tag . "')";
		$result_tag = mysqli_query($connection, $sql);
		if ($result_tag === false) {
		    $endTimer = microtime();
		    jamLog(__FILE__, __LINE__, ' [Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute insertRecord - record_tag => ' . $sql);
		    return false;
		}
	    }
	}
    }
    $endTimer = microtime();
    jamLog(__FILE__, __LINE__, ' [Execution time: ' . executionTime($startTimer, $endTimer) . '] ' . $insert_id . 'ID returned');
    return ($insert_id);
}

/**
 * Execute an insert operation of the $song
 * 
 * @param $connection
 * @param  $songobject the user to insert
 * @todo
 */
function insertSong($connection, $song) {
    $startTimer = microtime();
    require_once CLASSES_DIR . 'song.class.php';
    $sql = "INSERT INTO song( id,
                                    active,
                                    commentcounter,
                                    counter,
                                    duration,
                                    fromuser,
                                    latitude,
                                    longitude,
                                    lovecounter,
                                    path,
                                    position,
                                    record,
                                    sharecounter,
                                    title,
                                    createdat,
                                    updatedat)
                          VALUES (NULL,  
				  '" . (is_null($song->getActive()) ? 0 : $song->getActive()) . "',
				  '" . (is_null($song->getCommentcounter()) ? 0 : $song->getCommentcounter()) . "',
                                  '" . (is_null($song->getCounter()) ? 0 : $song->getCounter()) . "',
				  '" . (is_null($song->getDuration()) ? 0 : $song->getDuration()) . "',
				  '" . (is_null($song->getFromuser()) ? 0 : $song->getFromuser()) . "',                                             
				  '" . (is_null($song->getLatitude()) ? 0 : $song->getLatitude()) . "',
				  '" . (is_null($song->getLongitude()) ? 0 : $song->getLongitude()) . "',
				  '" . (is_null($song->getLovecounter()) ? 0 : $song->getLovecounter()) . "',
				  '" . $song->getPath() . "', 
				  '" . (is_null($song->getPosition()) ? 0 : $song->getPosition()) . "',
				  '" . (is_null($song->getRecord()) ? 0 : $song->getRecord()) . "',  
				  '" . (is_null($song->getSharecounter()) ? 0 : $song->getSharecounter()) . "', 
                                  '" . $song->getThumbnail() . "',
                                  '" . $song->getTitle() . "',
				  '" . (is_null($song->getYear()) ? 0 : $song->getYear()) . "',
                                  NOW(),
                                  NOW())";
    $result = mysqli_query($connection, $sql);
    if ($result === false) {
	$endTimer = microtime();
	jamLog(__FILE__, __LINE__, ' [Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute insertSong => ' . $sql);
	return false;
    } else {
	$insert_id = mysqli_insert_id($connection);
	$endTimer = microtime();
	jamLog(__FILE__, __LINE__, ' [Execution time: ' . executionTime($startTimer, $endTimer) . '] ' . $insert_id . 'ID returned');
	return $insert_id;
    }
}

/**
 * Execute an insert operation of the $song
 * 
 * @param $connection
 * @param  $songobject the user to insert
 * @todo
 */
function insertSongInPlayslist($connection, $song, $playlist) {
    $startTimer = microtime();
    require_once CLASSES_DIR . 'song.class.php';
    require_once CLASSES_DIR . 'playlist.class.php';
    $sql = "INSERT INTO playlist_song ( id,
                                    id_playlist,
                                    id_song,
                          VALUES (NULL,
                          	  '" . (is_null($song->getId()) ? 0 : $song->getId()) . "',
                                  '" . (is_null($playlist->getId()) ? 0 : $playlist->getId()) . "'";
    $result = mysqli_query($connection, $sql);
    if ($result === false) {
	$endTimer = microtime();
	jamLog(__FILE__, __LINE__, ' [Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute insertSongInPlaylist => ' . $sql);
	return false;
    } else {
	$insert_id = mysqli_insert_id($connection);
	$endTimer = microtime();
	jamLog(__FILE__, __LINE__, ' [Execution time: ' . executionTime($startTimer, $endTimer) . '] ' . $insert_id . 'ID returned');
	return $insert_id;
    }
}

/**
 * Execute an insert operation of the $user
 * 
 * @param $connection
 * @param  $user object the user to insert
 * @todo
 */
function insertUser($connection, $user) {
    $startTimer = microtime();
    $sql = "INSERT INTO user (id,
                                  username,
                                  password,
                                  active,
                                  address,
                                  avatar,
                                  background,
                                  birthday,
                                  city,
                                  collaborationcounter,
                                  country,
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
                                  membres,
                                  premium,
                                  premiumexpirationdate,
                                  sex,
                                  thumbnail,                                                                    
                                  twitterpage,
                                  type,
                                  venuecounter,
                                  website,
                                  youtubechannel,
                                  createdat,
                                  updatedat)
                          VALUES (NULL,
				  '" . $user->getUsername() . "',
                                  '" . $user->getPassword() . "',
                                  '" . (is_null($user->getActive()) ? 0 : $user->getActive()) . "',    
                                  '" . $user->getAddress() . "',
                                  '" . $user->getAvatar() . "',
                                  '" . $user->getBackground() . "',
                                  '" . (is_null($user->getBirthday()) ? 0 : $user->getBirthday()) . "',
                                  '" . $user->getCity() . "',
                                  '" . (is_null(getCollaborationcounter()) ? 0 : getCollaborationcounter()) . "',
                                  '" . $user->getCountry() . "',
                                  '" . $user->getDescription() . "',
                                  '" . $user->getEmail() . "',
                                  '" . $user->getFacebookId() . "',
                                  '" . $user->getFbPage() . "',
                                  '" . $user->getFirstname() . "',
                                  '" . (is_null(getFollowerscounter()) ? 0 : getFollowerscounter()) . "',
                                  '" . (is_null(getFollowingcounter()) ? 0 : getFollowingcounter()) . "',
                                  '" . (is_null(getFriendshipcounter()) ? 0 : getFriendshipcounter()) . "',
                                  '" . $user->getGooglepluspage() . "',
                                  '" . (is_null(getJammercounter()) ? 0 : getJammercounter()) . "',
                                  '" . $user->getJammertype() . "',
                                  '" . $user->getLastname() . "',
                                  '" . (is_null(getLevel()) ? 0 : getLevel()) . "',   
                                  '" . (is_null(getLevelvalue()) ? 0 : getLevelvalue()) . "', 
                                  '" . (is_null($user->getLatitude()) ? 0 : $user->getLatitude()) . "',
				  '" . (is_null($user->getLongitude()) ? 0 : $user->getLongitude()) . "',    
				  '" . (is_null($user->getPremium()) ? 0 : $user->getPremium()) . "', 
				  '" . (is_null($user->getPremiumexpirationdate()) ? 0 : $user->getPremiumexpirationdate()) . "', 
                                  '" . $user->getSex() . "',
                                  '" . $user->getThumbnail() . "',
                                  '" . $user->getTwitterpage() . "',
                                  '" . $user->getType() . "',
                                  '" . (is_null(getVenuecounter()) ? 0 : getVenuecounter()) . "',    
                                  '" . $user->getVenuecounter() . "',
                                  '" . $user->getWebsite() . "',
                                  '" . $user->getYoutubechannel() . "',
                                  NOW(),
                                  NOW())";

    $result = mysqli_query($connection, $sql);
    if ($result === false) {
	$endTimer = microtime();
	jamLog(__FILE__, __LINE__, ' [Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute insertSongInPlaylist => ' . $sql);
	return false;
    } else {
	$insert_id = mysqli_insert_id($connection);
	if (is_array($user->getMember())) {
	    foreach ($user->getMember() as $member) {
		$sql = "INSERT INTO user_member (id,
						member)
						VALUES (" . $insert_id . ",
							'" . $member . "')";
		$result_member = mysqli_query($connection, $sql);
	    }
	}
	if ($result_member === false) {
	    $endTimer = microtime();
	    jamLog(__FILE__, __LINE__, ' [Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute insertUser - member => ' . $sql);
	    return false;
	}
	if (is_array($user->getSetting())) {
	    foreach ($user->getSetting() as $setting) {
		$sql = "INSERT INTO user_setting (id,
						setting)
						VALUES (" . $insert_id . ",
							'" . $setting . "')";
		$result_setting = mysqli_query($connection, $sql);
	    }
	}
	if ($result_setting === false) {
	    $endTimer = microtime();
	    jamLog(__FILE__, __LINE__, ' [Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute insertUser - setting => ' . $sql);
	    return false;
	}
    }
    $endTimer = microtime();
    jamLog(__FILE__, __LINE__, ' [Execution time: ' . executionTime($startTimer, $endTimer) . '] ' . $insert_id . 'ID returned');
    return $insert_id;
}

/**
 * Execute an insert operation of the $video
 * 
 * @param $connection
 * @param  $video object the user to insert
 * @todo
 */
function insertVideo($connection, $video) {
    $startTimer = microtime();
    require_once CLASSES_DIR . 'video.class.php';
    $sql = "INSERT INTO video ( id,
                                    active,
                                    author,
                                    counter,
                                    duration,
                                    fromuser,
                                    lovecounter,
                                    thumbnail,
                                    title,
                                    createdat,
                                    updatedat)
                          VALUES (NULL,
                                  '" . (is_null($video->getActive()) ? 0 : $video->getActive()) . "',                                                 
                                  '" . $video->getAuthor() . "',
                                  '" . (is_null($video->getCounter()) ? 0 : $video->getCounter()) . "', 
                                  '" . (is_null($video->getDuration()) ? 0 : $video->getDuration()) . "', 
                                  '" . (is_null($video->getFromuser()) ? 0 : $video->getFromuser()) . "',    
                                  '" . (is_null($video->getLovecounter()) ? 0 : $video->getLovecounter()) . "',                                                                                     
                                  '" . $video->getThumbnail() . "',
                                  '" . $video->getTitle() . "',
                                  NOW(),
                                  NOW())";
    $result = mysqli_query($connection, $sql);
    if ($result === false) {
	jamLog(__FILE__, __LINE__, 'Unable to execute insertVideo => ' . $sql);
	return false;
    } else {
	$insert_id = mysqli_insert_id($connection);
	if (is_array($video->getTag())) {
	    foreach ($video->getTag() as $tag) {
		$sql = "INSERT INTO video_tag (id,
						tag)
						VALUES (" . $insert_id . ",
							'" . $tag . "')";
		$result_tag = mysqli_query($connection, $sql);
		if ($result_tag === false) {
		    $endTimer = microtime();
		    jamLog(__FILE__, __LINE__, ' [Execution time: ' . executionTime($startTimer, $endTimer) . '] Unable to execute insertVideo - video_tag => ' . $sql);
		    return false;
		}
	    }
	}
    }
    $endTimer = microtime();
    jamLog(__FILE__, __LINE__, ' [Execution time: ' . executionTime($startTimer, $endTimer) . '] ' . $insert_id . 'ID returned');
    return $insert_id;
}

?>