<?php

/* ! \par		Info Generali:
 *  \author		Luca Gianneschi
 *  \version		0.3
 *  \date		2013
 *  \copyright		Jamyourself.com 2013
 *  \par		Info Classe:
 *  \brief		Servizio di inserimento nel DB
 *  \details		Servizio inserimento dei record nel DB
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
 * \fn	    createNode($nodeType, $nodeId)
 * \brief   Create node on the node4J DB
 * \param   $nodeType, $nodeId
 * \todo
 */
function createNode($nodeType, $nodeId) {
    $query = '
	MERGE (n:' . $nodeType . ' {id:' . $nodeId . '})
	RETURN count(n)
	';
    $connectionService = new ConnectionService();
    $res = $connectionService->curl($query, null);
    return $res['data'][0];
}

/**
 * \fn	    createRelation($fromNodeType, $fromNodeId, $toNodeType, $toNodeId, $relType)
 * \brief   Create relation between nodes on the node4J DB
 * \param   $nodeType, $nodeId
 * \todo
 */
function createRelation($fromNodeType, $fromNodeId, $toNodeType, $toNodeId, $relType) {
    $query = '
	MATCH (n:' . $fromNodeType . ' {id:' . $fromNodeId . '}), (m:' . $toNodeType . ' {id:' . $toNodeId . '})
	MERGE (n)-[r:' . $relType . ' {createdat:' . date('YmdHis') . '}]->(m)
	RETURN count(r)
	';
    $connectionService = new ConnectionService();
    $res = $connectionService->curl($query, null);
    return $res['data'][0];
}

/**
 * \fn	    insertAlbum($album)
 * \brief   Execute an insert operation of the $album
 * \param   $album object the user to insert
 * \todo
 */
function insertAlbum($connection, $album) {
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
	jam_log(__FILE__, __LINE__, 'Unable to execute insertAlbum');
	return false;
    } else {
	$insert_id = mysqli_insert_id($connection);
	if (is_array($album->getTag())) {
	    foreach ($album->getTag() as $tag) {
		$sql = "INSERT INTO album_tag (id,
						tag)
						VALUES (" . $insert_id . ",
							'" . $tag . "')";
		mysqli_query($connection, $sql);
	    }
	}
	return $insert_id;
    }
}

/**
 * \fn	    insertComment($connection,$comment)
 * \brief   Execute an insert operation of the $comment
 * \param   $comment object the user to insert
 * \todo
 */
function insertComment($connection, $comment) {
    require_once 'comment.class.php';
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
                                    text,
                                    title,
                                    touser,
                                    type,
                                    vote
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
                                  '" . $comment->getText() . "',
                                  '" . $comment->getTitle() . "',
                                  '" . (is_null($comment->getTouser()) ? 0 : $comment->getTouser()) . "',      
                                  '" . $comment->getType() . "',
                                  '" . (is_null($comment->getVote()) ? 0 : $comment->getVote()) . "',
                                  NOW(),
                                  NOW())";
    $result = mysqli_query($connection, $sql);
    if ($result === false) {
	jam_log(__FILE__, __LINE__, 'Unable to execute insertAlbum');
	return false;
    } else {
	$insert_id = mysqli_insert_id($connection);
	if (is_array($comment->getTag())) {
	    foreach ($comment->getTag() as $tag) {
		$sql = "INSERT INTO comment_tag (id,
						tag)
						VALUES (" . $insert_id . ",
							'" . $tag . "')";
		mysqli_query($connection, $sql);
	    }
	}
	return $insert_id;
    }
}

/**
 * \fn	    insertEvent($event)
 * \brief   Execute an insert operation of the $event
 * \param   $event object the user to insert
 * \todo
 */
function insertEvent($event) {
    $connectionService = new ConnectionService();
    $connectionService->connect();
    if (!$connectionService->active) {
	$error = new Error();
	$error->setErrormessage($connectionService->error);
	return $error;
    } else {
	require_once 'event.class.php';
	$sql = "INSERT INTO event ( id,
                                    active,
                                    address,
                                    comment,
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
                                  '" . $event->getActive() . "',
                                  '" . $event->getAddress() . "',  
                                  '" . $event->getComment() . "',      
                                  '" . $event->getAttendeecounter() . "',
                                  '" . $event->getCancelledcounter() . "',
                                  '" . $event->getCity() . "',   
                                  '" . $event->getCommentcounter() . "',
                                  '" . $event->getCounter() . "',
                                  '" . $event->getCover() . "',
                                  '" . $event->getDescription() . "',
                                  '" . $event->getEventdate() . "',  
                                  '" . $event->getFromuser() . "',       
                                  '" . $event->getInvitedcounter() . "',                                        
                                  '" . $event->getLatitude() . "',
                                  '" . $event->getLocationname() . "',                                      
                                  '" . $event->getLongitude() . "',
                                  '" . $event->getLovecounter() . "',
                                  '" . $event->getReviewcounter() . "',
                                  '" . $event->getRefusedcounter() . "', 
                                  '" . $event->getSharecounter() . "',
                                  '" . $event->getThumbnail() . "',
                                  '" . $event->getTitle() . "',   
                                  NOW(),
                                  NOW())";
	mysqli_query($connectionService->connection, $sql);
	$insert_id = mysqli_insert_id($connectionService->connection);
	foreach ($event->getGenre() as $genre) {
	    $sql = "INSERT INTO event_genre (id,
                                           genre)
                                   VALUES (" . $insert_id . ",
                                           '" . $genre . "')";
	    mysqli_query($connectionService->connection, $sql);
	}
	foreach ($event->getTag() as $tag) {
	    $sql = "INSERT INTO event_tag (id,
                                           tag)
                                   VALUES (" . $insert_id . ",
                                           '" . $tag . "')";
	    mysqli_query($connectionService->connection, $sql);
	}
	$connectionService->disconnect();
	return $insert_id;
    }
}

/**
 * \fn	    insertImage($image)
 * \brief   Execute an insert operation of the $image
 * \param   $image object the user to insert
 * \todo
 */
function insertImage($image) {
    $connectionService = new ConnectionService();
    $connectionService->connect();
    if (!$connectionService->active) {
	$error = new Error();
	$error->setErrormessage($connectionService->error);
	return $error;
    } else {
	require_once 'image.class.php';
	$sql = "INSERT INTO image ( id,
                                    active,
                                    commentcounter,
                                    counter,
                                    fromuser,
                                    latitude,
                                    longitude,
                                    lovecounter,
                                    sharecounter,
                                    thumbnail,
                                    createdat,
                                    updatedat)
                          VALUES (NULL,
                                  '" . $image->getActive() . "',
                                  '" . $image->getCommentcounter() . "',
                                  '" . $image->getCounter() . "',
                                  '" . $image->getFromuser() . "',                                              
                                  '" . $image->getLatitude() . "',                                     
                                  '" . $image->getLongitude() . "',
                                  '" . $image->getLovecounter() . "', 
                                  '" . $image->getSharecounter() . "',
                                  '" . $image->getThumbnail() . "',   
                                  NOW(),
                                  NOW())";
	mysqli_query($connectionService->connection, $sql);
	$insert_id = mysqli_insert_id($connectionService->connection);
	foreach ($image->getTag() as $tag) {
	    $sql = "INSERT INTO image_tag (id,
                                           tag)
                                   VALUES (" . $insert_id . ",
                                           '" . $tag . "')";
	    mysqli_query($connectionService->connection, $sql);
	}
	$connectionService->disconnect();
	return $insert_id;
    }
}

/**
 * \fn	    insertPlaylist($playlist)
 * \brief   Execute an insert operation of the $playlist
 * \param   $playlist object the user to insert
 * \todo
 */
function insertPlaylist($playlist) {
    $connectionService = new ConnectionService();
    $connectionService->connect();
    if (!$connectionService->active) {
	$error = new Error();
	$error->setErrormessage($connectionService->error);
	return $error;
    } else {
	require_once 'playlist.class.php';
	$sql = "INSERT INTO playlist ( id,
                                    active,
                                    fromuser,
                                    name,
                                    songcounter,
                                    createdat,
                                    updatedat)
                          VALUES (NULL,
                                  '" . $playlist->getActive() . "',
                                  '" . $playlist->getFromuser() . "',                                              
                                  '" . $playlist->getName() . "',
                                  '" . $playlist->getSongcounter() . "',   
                                  NOW(),
                                  NOW())";
	mysqli_query($connectionService->connection, $sql);
	$insert_id = mysqli_insert_id($connectionService->connection);
	$connectionService->disconnect();
	return $insert_id;
    }
}

/**
 * \fn	    insertRecord($record)
 * \brief   Execute an insert operation of the $record
 * \param   $record object the user to insert
 * \todo
 */
function insertRecord($record) {
    $connectionService = new ConnectionService();
    $connectionService->connect();
    if (!$connectionService->active) {
	$error = new Error();
	$error->setErrormessage($connectionService->error);
	return $error;
    } else {
	require_once 'record.class.php';
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
                                  '" . $record->getActive() . "',
                                  '" . $record->getBuylink() . "',                                              
                                  '" . $record->getCommentcounter() . "',
                                  '" . $record->getCounter() . "',
                                  '" . $record->getCover() . "',                                              
                                  '" . $record->getDescription() . "',
                                  '" . $record->getDuration() . "', 
                                  '" . $record->getFromuser() . "',                                              
                                  '" . $record->getLabel() . "',
                                  '" . $record->getLatitude() . "',                                      
                                  '" . $record->getLongitude() . "',   
                                  '" . $record->getLovecounter() . "',   
                                  '" . $record->getReviewcounter() . "',   
                                  '" . $record->getSharecounter() . "',   
                                  '" . $record->getSongcounter() . "',
                                  '" . $record->getThumbnail() . "',
                                  '" . $record->getTitle() . "',
                                  '" . $record->getYear() . "',
                                  NOW(),
                                  NOW())";
	mysqli_query($connectionService->connection, $sql);
	$insert_id = mysqli_insert_id($connectionService->connection);
	foreach ($record->getGenre() as $genre) {
	    $sql = "INSERT INTO record_genre (id,
                                           genre)
                                   VALUES (" . $insert_id . ",
                                           '" . $genre . "')";
	    mysqli_query($connectionService->connection, $sql);
	}
	foreach ($record->getTag() as $tag) {
	    $sql = "INSERT INTO record_tag (id,
                                           tag)
                                   VALUES (" . $insert_id . ",
                                           '" . $tag . "')";
	    mysqli_query($connectionService->connection, $sql);
	}
	$connectionService->disconnect();
	return $insert_id;
    }
}

/**
 * \fn	    insertSong($song)
 * \brief   Execute an insert operation of the $song
 * \param   $songobject the user to insert
 * \todo
 */
function insertSong($song) {
    $connectionService = new ConnectionService();
    $connectionService->connect();
    if (!$connectionService->active) {
	$error = new Error();
	$error->setErrormessage($connectionService->error);
	return $error;
    } else {
	require_once 'song.class.php';
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
                                  '" . $song->getActive() . "',                                              
                                  '" . $song->getCommentcounter() . "',
                                  '" . $song->getCounter() . "',
                                  '" . $song->getDuration() . "', 
                                  '" . $song->getFromuser() . "',                                              
                                  '" . $song->getLatitude() . "',                                      
                                  '" . $song->getLongitude() . "',   
                                  '" . $song->getLovecounter() . "',   
                                  '" . $song->getPath() . "',   
                                  '" . $song->getPosition() . "',   
                                  '" . $song->getRecord() . "',                                       
                                  '" . $song->getSharecounter() . "',
                                  '" . $song->getTitle() . "',
                                  '" . $song->getYear() . "',
                                  NOW(),
                                  NOW())";
	mysqli_query($connectionService->connection, $sql);
	$insert_id = mysqli_insert_id($connectionService->connection);
	$connectionService->disconnect();
	return $insert_id;
    }
}

/**
 * \fn	    insertSong($song)
 * \brief   Execute an insert operation of the $song
 * \param   $songobject the user to insert
 * \todo
 */
function insertSongInPlayslist($song) {
    $connectionService = new ConnectionService();
    $connectionService->connect();
    if (!$connectionService->active) {
	$error = new Error();
	$error->setErrormessage($connectionService->error);
	return $error;
    } else {
//	require_once 'song.class.php';
//	$sql = "INSERT INTO playlist_song ( id,
//                                    active,
//                                    commentcounter,
//                                    counter,
//                                    duration,
//                                    fromuser,
//                                    latitude,
//                                    longitude,
//                                    lovecounter,
//                                    path,
//                                    position,
//                                    record,
//                                    sharecounter,
//                                    title,
//                                    createdat,
//                                    updatedat)
//                          VALUES (NULL,
//                                  '" . $song->getActive() . "',                                              
//                                  '" . $song->getCommentcounter() . "',
//                                  '" . $song->getCounter() . "',
//                                  '" . $song->getDuration() . "', 
//                                  '" . $song->getFromuser() . "',                                              
//                                  '" . $song->getLatitude() . "',                                      
//                                  '" . $song->getLongitude() . "',   
//                                  '" . $song->getLovecounter() . "',   
//                                  '" . $song->getPath() . "',   
//                                  '" . $song->getPosition() . "',   
//                                  '" . $song->getRecord() . "',                                       
//                                  '" . $song->getSharecounter() . "',
//                                  '" . $song->getTitle() . "',
//                                  '" . $song->getYear() . "',
//                                  NOW(),
//                                  NOW())";
	mysqli_query($connectionService->connection, $sql);
	$insert_id = mysqli_insert_id($connectionService->connection);
	$connectionService->disconnect();
	return $insert_id;
    }
}

/**
 * \fn	    insertUser($user)
 * \brief   Execute an insert operation of the $user
 * \param   $user object the user to insert
 * \todo
 */
function insertUser($user) {
    $connectionService = new ConnectionService();
    $connectionService->connect();
    if (!$connectionService->active) {
	$error = new Error();
	$error->setErrormessage($connectionService->error);
	return $error;
    } else {
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
                                  '" . $user->getActive() . "',
                                  '" . $user->getAddress() . "',
                                  '" . $user->getAvatar() . "',
                                  '" . $user->getBackground() . "',
                                  '" . $user->getBirthday() . "',
                                  '" . $user->getCity() . "',
                                  '" . $user->getCollaborationcounter() . "',
                                  '" . $user->getCountry() . "',
                                  '" . $user->getDescription() . "',
                                  '" . $user->getEmail() . "',
                                  '" . $user->getFacebookId() . "',
                                  '" . $user->getFbPage() . "',
                                  '" . $user->getFirstname() . "',
                                  '" . $user->getFollowerscounter() . "',
                                  '" . $user->getFollowingcounter() . "',
                                  '" . $user->getFriendshipcounter() . "',
                                  '" . $user->getGooglepluspage() . "',
                                  '" . $user->getJammercounter() . "',
                                  '" . $user->getJammertype() . "',
                                  '" . $user->getLastname() . "',
                                  '" . $user->getLevel() . "',
                                  '" . $user->getLevelvalue() . "',
                                  '" . $user->getLatitude() . "',
                                  '" . $user->getLongitude() . "',
                                  '" . $user->getPremium() . "',
                                  '" . $user->getPremiumexpirationdate()->format('Y-m-d H:i:s') . "',
                                  '" . $user->getSex() . "',
                                  '" . $user->getThumbnail() . "',
                                  '" . $user->getTwitterpage() . "',
                                  '" . $user->getType() . "',
                                  '" . $user->getVenuecounter() . "',
                                  '" . $user->getWebsite() . "',
                                  '" . $user->getYoutubechannel() . "',
                                  NOW(),
                                  NOW())";
	mysqli_query($connectionService->connection, $sql);
	$insert_id = mysqli_insert_id($connectionService->connection);
	foreach ($user->getSettings() as $setting) {
	    $sql = "INSERT INTO user_setting (id,
                                           setting)
                                   VALUES (" . $insert_id . ",
                                           '" . $setting . "')";
	    mysqli_query($connectionService->connection, $sql);
	}
	foreach ($user->getMembers() as $member) {
	    $sql = "INSERT INTO user_members (id,
                                           member)
                                   VALUES (" . $insert_id . ",
                                           '" . $member . "')";
	    mysqli_query($connectionService->connection, $sql);
	}
	$connectionService->disconnect();
	return $insert_id;
    }
}

/**
 * \fn	    insertVideo($video) 
 * \brief   Execute an insert operation of the $video
 * \param   $video object the user to insert
 * \todo
 */
function insertVideo($video) {
    $connectionService = new ConnectionService();
    $connectionService->connect();
    if (!$connectionService->active) {
	$error = new Error();
	$error->setErrormessage($connectionService->error);
	return $error;
    } else {
	require_once 'video.class.php';
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
                                  '" . $video->getActive() . "',                                              
                                  '" . $video->getAuthor() . "',
                                  '" . $video->getCounter() . "',
                                  '" . $video->getDuration() . "', 
                                  '" . $video->getFromuser() . "',                                                
                                  '" . $video->getLovecounter() . "',                                         
                                  '" . $video->getThumbnail() . "',
                                  '" . $video->getTitle() . "',
                                  NOW(),
                                  NOW())";
	mysqli_query($connectionService->connection, $sql);
	$insert_id = mysqli_insert_id($connectionService->connection);
	foreach ($video->getTag() as $tag) {
	    $sql = "INSERT INTO video_tag (id,
                                           tag)
                                   VALUES (" . $insert_id . ",
                                           '" . $tag . "')";
	    mysqli_query($connectionService->connection, $sql);
	}
	$connectionService->disconnect();
	return $insert_id;
    }
}

?>