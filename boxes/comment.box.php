<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		0.3
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box commenti
 * \details		Recupera le informazioni del commento e le mette in oggetto commentBox
 * \par			Commenti:
 * \warning
 * \bug
 * \todo	        discutere se necessario fare check su correttezza della classe commentata
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'connection.service.php';
require_once SERVICES_DIR . 'debug.service.php';

/**
 * \brief	CommentBox class 
 * \details	box class to pass info to the view 
 * \todo	
 */
class CommentBox {

    public $commentArray = array();
    public $error = null;

    /**
     * \fn	init($className, $id, $limit, $skip)
     * \brief	Init CommentBox instance all over the website
     * \param	$className for the instance of the class that has been commented, $id for object that has been commented,
     * \param   $limit number of objects to retreive, $skip number of objects to skip
     */
    public function init($id, $className, $limit = DEFAULTQUERY, $skip = 0) {
	$connectionService = new ConnectionService();
	$connectionService->connect();
	if (!$connectionService->active) {
	    $this->error = $connectionService->error;
	    return;
	} else {
	    $sql = "SELECT     id,
		               createdat,
		               updatedat,
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
		               song,
		               tag,
		               title,
		               text,
		               touser,
		               type,
		               video,
		               vote
                  FROM album a, user_album ua
                 WHERE ua.id_user = " . $id . "
                   AND ua.id_album = a.id
                 LIMIT " . $skip . ", " . $limit;
	    $results = mysqli_query($connectionService->connection, $sql);
	    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
		$rows[] = $row;
	    $comments = array();
	    foreach ($rows as $row) {
		require_once 'comment.class.php';
		$comment = new Comment();
		$comment->setId($row['id']);
		$comment->setActive($row['active']);
		$comment->setCommentcounter($row['commentcounter']);
		$comment->setCounter($row['counter']);
		$sql = "SELECT id,
			       username,
			       thumbnail,
			       type
                          FROM user
                         WHERE id = " . $row['fromuser'];
		$res = mysqli_query($connectionService->connection, $sql);
		$row_user = mysqli_fetch_array($res, MYSQLI_ASSOC);
		require_once 'user.class.php';
		$fromuser = new User($row_user['type']);
		$fromuser->setId($row_user['id']);
		$fromuser->setThumbnail($row_user['thumbnail']);
		$fromuser->setUsername($row_user['username']);
		$comment->setFromuser($fromuser);
		$comment->setLatitude($row['latitude']);
		$comment->setLongitude($row['longitude']);
		$comment->setLovecounter($row['lovecounter']);
		$comment->setSharecounter($row['sharecounter']);
		$comment->setTag($row['tag']);
		$comment->setText($row['text']);
		$comment->setTitle($row['title']);
		$comment->setType($row['type']);
		$comment->setUpdatedat($row['updatedat']);
		$comment->setVote($row['vote']);
		switch ($className) {
		    case 'Album':
			$sql = "SELECT id,
			       title,
			       thumbnail,
                          FROM comment
                         WHERE id = " . $row[$table];
			break;
		    case 'Event':
			$sql = "SELECT id,
			       title,
			       thumbnail,
                          FROM comment
                         WHERE id = " . $row[$table];
			break;
		    case 'EventReview':
			$sql = "SELECT id,
			       title,
			       thumbnail,
                          FROM comment
                         WHERE id = " . $row[$table];
			break;
		    case 'Image':
			$sql = "SELECT id,
			       title,
			       thumbnail,
                          FROM comment
                         WHERE id = " . $row[$table];
			break;
		    case 'Record':
			$sql = "SELECT id,
			       title,
			       thumbnail,
                          FROM comment
                         WHERE id = " . $row[$table];
			break;
		    case 'RecordReview':
			$sql = "SELECT id,
			       title,
			       thumbnail,
                          FROM comment
                         WHERE id = " . $row[$table];
			break;
		    case 'Song':
			$sql = "SELECT id,
			       title,
			       thumbnail,
                          FROM comment
                         WHERE id = " . $row[$table];
			break;
		    case 'Video':
			$sql = "SELECT id,
			       title,
			       thumbnail,
                          FROM comment
                         WHERE id = " . $row[$table];
			break;
		}
		$resClass = mysqli_query($connectionService->connection, $sql);
		$row_class = mysqli_fetch_array($resClass, MYSQLI_ASSOC);
		require_once strtolower($className) . 'class.php';
		switch ($className) {
		    case 'Album':
			$comment->setAlbum($row_class['album']);
			break;
		    case 'Event':
			$comment->setEvent($row_class['event']);
			break;
		    case 'EventReview':
			$comment->setComment($row_class['comment']);
			break;
		    case 'Image':
			$comment->setImage($row_class['image']);
			break;
		    case 'Record':
			$comment->setRecord($row_class['record']);
			break;
		    case 'RecordReview':
			$comment->setComment($row_class['comment']);
			break;
		    case 'Song':
			$comment->setSong($row_class['song']);
			break;
		    case 'Video':
			$comment->setVideo($row_class['video']);
			break;
		}
		$comments[$row['id']] = $comment;
	    }
	    $connectionService->disconnect();
	    if (!$results) {
		return;
	    } else {
		$this->commentArray = $comments;
	    }
	}
    }

}

?>