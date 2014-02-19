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
		require_once 'album.class.php';
		$comment = new Comment();
		$comment->setId($row['id']);
		$comment->setActive($row['active']);
		$comment->setAlbum($row['album']);
		$comment->setComment($row['comment']);
		$comment->setCommentcounter($row['commentcounter']);
		$comment->setCounter($row['counter']);
		$comment->setFromuser($row['fromuser']);
		$comment->setImage($row['image']);
		$comment->setLatitude($row['latitude']);
		$comment->setLongitude($row['longitude']);
		$comment->setLovecounter($row['lovecounter']);
		$comment->setRecord($row['record']);
		$comment->setSong($row['song']);
		$comment->setSharecounter($row['sharecounter']);
		$comment->setTag($row['tag']);
		$comment->setText($row['text']);
		$comment->setTitle($row['title']);
		$comment->setTouser($row['touser']);
		$comment->setType($row['type']);
		$comment->setUpdatedat($row['updatedat']);
		$comment->setVideo($row['video']);
		$comment->setVote($row['vote']);
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