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
                           c.tag,
                           c.title,
                           c.text,
                           c.touser,
                           c.type type_c,
                           c.video,
                           c.vote,
                           c.createdat,
                           c.updatedat,
                           u.id id_u,
                           u.username,
                           u.thumbnail,
                           u.type type_u
                      FROM comment c, user u
                     WHERE c.fromuser = " . $id . "
                       AND c.fromuser = u.id
                  ORDER BY createdat DESC
                     LIMIT " . $skip . ", " . $limit;
            $results = mysqli_query($connectionService->connection, $sql);
            while ($row_comment = mysqli_fetch_array($results, MYSQLI_ASSOC))
                $rows[] = $row_comment;
            $posts = array();
            foreach ($rows as $row_comment) {
                require_once 'comment.class.php';
                require_once 'user.class.php';
                $post = new Comment();
                $post->setId($row_comment['id_c']);
                $post->setActive($row_comment['active']);
                $post->setAlbum($row_comment['album']);
                $post->setComment($row_comment['post']);
                $post->setCommentcounter($row_comment['commentcounter']);
                $post->setCounter($row_comment['counter']);
                $fromuser = new User($row_comment['type_u']);
                $fromuser->setId($row_comment['id_u']);
                $fromuser->setThumbnail($row_comment['thumbnail']);
                $fromuser->setUsername($row_comment['username']);
                $post->setFromuser($fromuser);
                $post->setImage($row_comment['image']);
                $post->setLatitude($row_comment['locationlat']);
                $post->setLongitude($row_comment['locationlon']);
                $post->setLovecounter($row_comment['lovecounter']);
                $post->setRecord($row_comment['record']);
                $post->setSong($row_comment['song']);
                $post->setSharecounter($row_comment['sharecounter']);
                $sql = "SELECT tag
                          FROM comment_tag
                         WHERE id = " . $row_comment['id_c'];
                $results = mysqli_query($connectionService->connection, $sql);
                while ($row_tag = mysqli_fetch_array($results, MYSQLI_ASSOC))
                    $rows_tag[] = $row_tag;
                $tags = array();
                foreach ($rows_tag as $row_tag) {
                    $tags[] = $row_tag;
                }
                $post->setTag($row_tag);
                $post->setText($row_comment['text']);
                $post->setTitle($row_comment['title']);
                $post->setTouser($row_comment['touser']);
                $post->setType($row_comment['type_c']);
                $post->setVideo($row_comment['video']);
                $post->setVote($row_comment['vote']);
                $post->setCreatedat($row_comment['createdat']);
                $post->setUpdatedat($row_comment['updatedat']);
                $posts[$row_comment['id']] = $post;
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