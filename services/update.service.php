<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'connection.service.php';
require_once SERVICES_DIR . 'log.service.php';

/**
 * Funzioni di update delle istanze delle classi
 * 
 * @author Daniele Caldelli 
 * @version		0.2
 * @since		2014-03-11
 * @copyright		Jamyourself.com 2014	
 * @warning
 * @bug
 * @todo terminare le funzioni per ogni classe                
 */

/**
 * update generic function
 * @param   $connection
 * @param   $class for the instance of the class to be updated
 * @param   $set,
 * @param   $increment
 * @param   $decrement
 * @param   $id
 * @param   $where
 * @return BOOL true if update OK, false otherwise
 */
function update($connection, $class, $set, $increment = null, $decrement = null, $id = null, $where = null) {
    $sql = "
	UPDATE " . $class . "
	   SET 
	";
    foreach ($set as $key => $value) {
	$sql .= $key . " = '" . $value . "',";
    }
    if (is_null($increment) && is_null($decrement)) {
	$sql = substr($sql, 0, strlen($sql) - 1);
    }
    if (!is_null($increment)) {
	foreach ($increment as $key => $value) {
	    $sql .= $key . " = " . $key . " + " . $value . ",";
	}
	if (is_null($decrement)) {
	    $sql = substr($sql, 0, strlen($sql) - 1);
	}
    }
    if (!is_null($decrement)) {
	foreach ($decrement as $key => $value) {
	    $sql .= $key . " = " . $key . " - " . $value . ",";
	}
	$sql = substr($sql, 0, strlen($sql) - 1);
    }
    $sql .= " WHERE 1 = 1 ";

    if (!is_null($id)) {
	$sql .= " AND id = " . $id;
    }
    if (!is_null($where)) {
	foreach ($where as $key => $value) {
	    $sql .= " AND " . $key . " = '" . $value . "'";
	}
    }
    $results = mysqli_query($connection, $sql);
    if ($results === false) {
	jamLog(__FILE__, __LINE__, 'Unable to execute update');
	return false;
    }
    return true;
}

/**
 * updateAlbum function 
 * @param   $connection
 * @param Album $album Album class instance
 * @return BOOL true if update OK, false otherwise
 */
function updateAlbum($connection, $album) {
    $autocommit = 0;
    $result = mysqli_query($connection, "SELECT @@autocommit");
    if ($result === false) {
	jamLog(__FILE__, __LINE__, 'Unable to define autocommit');
	return false;
    } else {
	$row = mysqli_fetch_row($result);
	$autocommit = $row[0];
    }
    mysqli_autocommit($connection, false);
    $sql = "UPDATE album SET ";
    $sql .= "active = '" . $album->getActive() . "',";
    $sql .= "commentcounter = '" . $album->getCommentcounter() . "',";
    $sql .= "counter = '" . $album->getCounter() . "',";
    $sql .= "cover = '" . $album->getCover() . "',";
    $sql .= "description = '" . $album->getDescription() . "',";
    $sql .= "fromuser = '" . $album->getFromuser() . "',";
    $sql .= "imagecounter = '" . $album->getImagecounter() . "',";
    $sql .= "latitude = '" . $album->getLatitude() . "',";
    $sql .= "longitude = '" . $album->getLongitude() . "',";
    $sql .= "lovecounter = '" . $album->getLovecounter() . "',";
    $sql .= "sharecounter = '" . $album->getSharecounter() . "',";
    $sql .= "thumbnail = '" . $album->getThumbnail() . "',";
    $sql .= "title = '" . $album->getTitle() . "',";
    $sql .= "updatedat = '" . date('Y-m-d H:i:s') . "'";
    $sql .= " WHERE id = " . $album->getId();
    $resultsUpdate = mysqli_query($connection, $sql);
    $sql = "DELETE FROM album_tag WHERE id = " . $album->getId();
    $resultsDelete = mysqli_query($connection, $sql);
    $resultsInsert = true;
    foreach ($album->getTag() as $tag) {
	$sql = "INSERT INTO album_tag (id, tag) VALUES (" . $album->getId() . ", '" . $tag . "')";
	$results = mysqli_query($connection, $sql);
	if ($results === false) {
	    $resultsInsert = false;
	}
    }
    if ($resultsUpdate === false || $resultsDelete === false || $resultsInsert === false) {
	mysqli_rollback($connection);
	$autocommit ? mysqli_autocommit($connection, true) : mysqli_autocommit($connection, false);
	return false;
    } else {
	mysqli_commit($connection);
	$autocommit ? mysqli_autocommit($connection, true) : mysqli_autocommit($connection, false);
	return true;
    }
}

/**
 * updateComment function 
 * @param   $connection
 * @param Comment $comment Comment class instance
 * @return BOOL true if update OK, false otherwise
 */
function updateComment($connection, $comment) {
    $autocommit = 0;
    $result = mysqli_query($connection, "SELECT @@autocommit");
    if ($result === false) {
	jamLog(__FILE__, __LINE__, 'Unable to define autocommit');
	return false;
    } else {
	$row = mysqli_fetch_row($result);
	$autocommit = $row[0];
    }
    mysqli_autocommit($connection, false);
    $sql = "UPDATE comment SET ";
    $sql .= "active = '" . $comment->getActive() . "',";
    $sql .= "album = '" . $comment->getAlbum() . "',";
    $sql .= "comment = '" . $comment->getComment() . "',";
    $sql .= "commentcounter = '" . $comment->getCommentcounter() . "',";
    $sql .= "counter = '" . $comment->getCounter() . "',";
    $sql .= "event = '" . $comment->getEvent() . "',";
    $sql .= "fromuser = '" . $comment->getFromuser() . "',";
    $sql .= "image = '" . $comment->getImage() . "',";
    $sql .= "latitude = '" . $comment->getLatitude() . "',";
    $sql .= "longitude = '" . $comment->getLongitude() . "',";
    $sql .= "lovecounter = '" . $comment->getLovecounter() . "',";
    $sql .= "record = '" . $comment->getRecord() . "',";
    $sql .= "sharecounter = '" . $comment->getSharecounter() . "',";
    $sql .= "song = '" . $comment->getSong() . "',";
    $sql .= "text = '" . $comment->getText() . "',";
    $sql .= "title = '" . $comment->getTitle() . "',";
    $sql .= "touser = '" . $comment->getTouser() . "',";
    $sql .= "type = '" . $comment->getType() . "',";
    $sql .= "video = '" . $comment->getVideo() . "',";
    $sql .= "vote = '" . $comment->getVote() . "',";
    $sql .= "updatedat = '" . date('Y-m-d H:i:s') . "'";
    $sql .= " WHERE id = " . $comment->getId();
    $resultsUpdate = mysqli_query($connection, $sql);
    $sql = "DELETE FROM comment_tag WHERE id = " . $comment->getId();
    $resultsDelete = mysqli_query($connection, $sql);
    $resultsInsert = true;
    foreach ($comment->getTag() as $tag) {
	$sql = "INSERT INTO comment_tag (id, tag) VALUES (" . $comment->getId() . ", '" . $tag . "')";
	$results = mysqli_query($connection, $sql);
	if ($results === false) {
	    $resultsInsert = false;
	}
    }
    if ($resultsUpdate === false || $resultsDelete === false || $resultsInsert === false) {
	mysqli_rollback($connection);
	$autocommit ? mysqli_autocommit($connection, true) : mysqli_autocommit($connection, false);
	return false;
    } else {
	mysqli_commit($connection);
	$autocommit ? mysqli_autocommit($connection, true) : mysqli_autocommit($connection, false);
	return true;
    }
}

/**
 * updateEvent function 
 * @param   $connection
 * @param Event $event Event class instance
 * @return BOOL true if update OK, false otherwise
 */
function updateEvent($connection, $event) {
    $autocommit = 0;
    $result = mysqli_query($connection, "SELECT @@autocommit");
    if ($result === false) {
	jamLog(__FILE__, __LINE__, 'Unable to define autocommit');
	return false;
    } else {
	$row = mysqli_fetch_row($result);
	$autocommit = $row[0];
    }
    mysqli_autocommit($connection, false);
    $sql = "UPDATE event SET ";
    $sql .= "active = '" . $event->getActive() . "',";
    $sql .= "album = '" . $event->getAlbum() . "',";
    $sql .= "address = '" . $event->getAddress() . "',";
    $sql .= "attendeecounter = '" . $event->getAttendeecounter() . "',";
    $sql .= "cancelledcounter = '" . $event->getCancelledcounter() . "',";
    $sql .= "city = '" . $event->getCity() . "',";
    $sql .= "commentcounter = '" . $event->getCommentcounter() . "',";
    $sql .= "counter = '" . $event->getCounter() . "',";
    $sql .= "cover = '" . $event->getCover() . "',";
    $sql .= "description = '" . $event->getDescription() . "',";
    $sql .= "eventdate = '" . $event->getEventdate() . "',";
    $sql .= "fromuser = '" . $event->getFromuser() . "',";
    $sql .= "invitedcounter = '" . $event->getInvitedcounter() . "',";
    $sql .= "latitude = '" . $event->getLatitude() . "',";
    $sql .= "locationname = '" . $event->getLocationname() . "',";
    $sql .= "longitude = '" . $event->getLongitude() . "',";
    $sql .= "lovecounter = '" . $event->getLovecounter() . "',";
    $sql .= "reviewcounter = '" . $event->getReviewcounter() . "',";
    $sql .= "refusedcounter = '" . $event->getRefusedCounter() . "',";
    $sql .= "sharecounter = '" . $event->getSharecounter() . "',";
    $sql .= "thumbnail = '" . $event->getThumbnail() . "',";
    $sql .= "title = '" . $event->getTitle() . "',";
    $sql .= "updatedat = '" . date('Y-m-d H:i:s') . "'";
    $sql .= " WHERE id = " . $event->getId();
    $resultsUpdate = mysqli_query($connection, $sql);
    $sql = "DELETE FROM event_tag WHERE id = " . $event->getId();
    $resultsDelete = mysqli_query($connection, $sql);
    $resultsInsert = true;
    foreach ($event->getGenre() as $genre) {
	$sql = "INSERT INTO event_genre (id, genre) VALUES (" . $event->getId() . ", '" . $genre . "')";
	$results = mysqli_query($connection, $sql);
	if ($results === false) {
	    $resultsInsert = false;
	}
    }
    foreach ($event->getTag() as $tag) {
	$sql = "INSERT INTO event_tag (id, tag) VALUES (" . $event->getId() . ", '" . $tag . "')";
	$results = mysqli_query($connection, $sql);
	if ($results === false) {
	    $resultsInsert = false;
	}
    }
    if ($resultsUpdate === false || $resultsDelete === false || $resultsInsert === false) {
	mysqli_rollback($connection);
	$autocommit ? mysqli_autocommit($connection, true) : mysqli_autocommit($connection, false);
	return false;
    } else {
	mysqli_commit($connection);
	$autocommit ? mysqli_autocommit($connection, true) : mysqli_autocommit($connection, false);
	return true;
    }
}

/**
 * updateImage function 
 * @param   $connection
 * @param Image $image Image class instance
 * @return BOOL true if update OK, false otherwise
 */
function updateImage($connection, $image) {
    $autocommit = 0;
    $result = mysqli_query($connection, "SELECT @@autocommit");
    if ($result === false) {
	jamLog(__FILE__, __LINE__, 'Unable to define autocommit');
	return false;
    } else {
	$row = mysqli_fetch_row($result);
	$autocommit = $row[0];
    }
    mysqli_autocommit($connection, false);
    $sql = "UPDATE comment SET ";
    $sql .= "active = '" . $image->getActive() . "',";
    $sql .= "album = '" . $image->getAlbum() . "',";
    $sql .= "commentcounter = '" . $image->getCommentcounter() . "',";
    $sql .= "counter = '" . $image->getCounter() . "',";
    $sql .= "description = '" . $image->getDescription() . "',";
    $sql .= "fromuser = '" . $image->getFromuser() . "',";
    $sql .= "latitude = '" . $image->getLatitude() . "',";
    $sql .= "longitude = '" . $image->getLongitude() . "',";
    $sql .= "lovecounter = '" . $image->getLovecounter() . "',";
    $sql .= "path = '" . $image->getPath() . "',";
    $sql .= "sharecounter = '" . $image->getSharecounter() . "',";
    $sql .= "thumbnail = '" . $image->getThumbnail() . "',";
    $sql .= "updatedat = '" . date('Y-m-d H:i:s') . "'";
    $sql .= " WHERE id = " . $image->getId();
    $resultsUpdate = mysqli_query($connection, $sql);
    $sql = "DELETE FROM image_tag WHERE id = " . $image->getId();
    $resultsDelete = mysqli_query($connection, $sql);
    $resultsInsert = true;
    foreach ($image->getTag() as $tag) {
	$sql = "INSERT INTO image_tag (id, tag) VALUES (" . $image->getId() . ", '" . $tag . "')";
	$results = mysqli_query($connection, $sql);
	if ($results === false) {
	    $resultsInsert = false;
	}
    }
    if ($resultsUpdate === false || $resultsDelete === false || $resultsInsert === false) {
	mysqli_rollback($connection);
	$autocommit ? mysqli_autocommit($connection, true) : mysqli_autocommit($connection, false);
	return false;
    } else {
	mysqli_commit($connection);
	$autocommit ? mysqli_autocommit($connection, true) : mysqli_autocommit($connection, false);
	return true;
    }
}

/**
 * updatePlaylist function 
 * @param   $connection
 * @param Playlist $playlist Playlist class instance
 * @return BOOL true if update OK, false otherwise
 */
function updatePlaylist($connection, $playlist) {
    $autocommit = 0;
    $result = mysqli_query($connection, "SELECT @@autocommit");
    if ($result === false) {
	jamLog(__FILE__, __LINE__, 'Unable to define autocommit');
	return false;
    } else {
	$row = mysqli_fetch_row($result);
	$autocommit = $row[0];
    }
    mysqli_autocommit($connection, false);
    $sql = "UPDATE comment SET ";
    $sql .= "active = '" . $playlist->getActive() . "',";
    $sql .= "fromuser = '" . $playlist->getFromuser() . "',";
    $sql .= "name = '" . $playlist->getName() . "',";
    $sql .= "songcounter = '" . $playlist->getSongcounter() . "',";
    $sql .= "lovecounter = '" . $playlist->getLovecounter() . "',";
    $sql .= "unlimited = '" . $playlist->getUnlimited() . "',";
    $sql .= "updatedat = '" . date('Y-m-d H:i:s') . "'";
    $sql .= " WHERE id = " . $playlist->getId();
    $resultsUpdate = mysqli_query($connection, $sql);
    $sql = "DELETE FROM image_tag WHERE id = " . $playlist->getId();
    $resultsDelete = mysqli_query($connection, $sql);
    $resultsInsert = true;
    foreach ($playlist->getSongs() as $song) {
	$sql = "INSERT INTO playlist_song (id, song) VALUES (" . $playlist->getId() . ", '" . $song . "')";
	$results = mysqli_query($connection, $sql);
	if ($results === false) {
	    $resultsInsert = false;
	}
    }
    if ($resultsUpdate === false || $resultsDelete === false || $resultsInsert === false) {
	mysqli_rollback($connection);
	$autocommit ? mysqli_autocommit($connection, true) : mysqli_autocommit($connection, false);
	return false;
    } else {
	mysqli_commit($connection);
	$autocommit ? mysqli_autocommit($connection, true) : mysqli_autocommit($connection, false);
	return true;
    }
}

?>