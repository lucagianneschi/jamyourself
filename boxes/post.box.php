<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		0.3
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box Post
 * \details		Recupera gli ultimi post attivi
 * \par			Commenti:
 * \warning
 * \bug
 * \todo
 *
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'connection.service.php';

/**
 * \brief	PostBox class 
 * \details	box class to pass info to the view for personal page
 */
class PostBox {

    public $error = null;
    public $postArray = array();

    /**
     * \fn	init($id)
     * \brief	Init PostBox instance for Personal Page
     * \param	$id for user that owns the page,$limit number of objects to retreive, $skip number of objects to skip, $currentUserId
     * \return	postBox
     * \todo
     */
    public function init($id, $limit = 5, $skip = 0) {
	$connectionService = new ConnectionService();
	$connectionService->connect();
	if (!$connectionService->active) {
	    $this->error = $connectionService->error;
	    return;
	} else {
	    $sql = "SELECT id,
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
	    $posts = array();
	    foreach ($rows as $row) {
		require_once 'comment.class.php';
		$post = new Comment();
		$post->setId($row['id']);
		$post->setActive($row['active']);
		$post->setAlbum($row['album']);
		$post->setComment($row['post']);
		$post->setCommentcounter($row['commentcounter']);
		$post->setCounter($row['counter']);
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
		$post->setFromuser($row['fromuser']);
		$post->setImage($row['image']);
		$post->setLatitude($row['locationlat']);
		$post->setLongitude($row['locationlon']);
		$post->setLovecounter($row['lovecounter']);
		$post->setRecord($row['record']);
		$post->setSong($row['song']);
		$post->setSharecounter($row['sharecounter']);
		$post->setTag($row['tag']);
		$post->setText($row['text']);
		$post->setTitle($row['title']);
		$post->setTouser($row['touser']);
		$post->setType($row['type']);
		$post->setUpdatedat($row['updatedat']);
		$post->setVideo($row['video']);
		$post->setVote($row['vote']);
		$posts[$row['id']] = $post;
	    }
	    $connectionService->disconnect();
	    if (!$results) {
		return;
	    } else {
		$this->postArray = $posts;
	    }
	}
    }

    /**
     * \fn	initForPersonalPage($id, $limit, $skip, $currentUserId)
     * \brief	Init PostBox instance for Personal Page
     * \param	$id for user that owns the page,$limit number of objects to retreive, $skip number of objects to skip, $currentUserId
     * \return	postBox
     * \todo
     */
    public function initForStream($id, $limit) {
	$this->config = null;
	$this->error = null;
	$this->postArray = array();
    }

}

?>