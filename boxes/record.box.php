<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		0.3
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box caricamento info event
 * \details		Recupera le informazioni dell'evento, le inserisce in un array da passare alla view
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
require_once SERVICES_DIR . 'debug.service.php';

/**
 * \brief	RecordBox class
 * \details	box class to pass info to the view for personal page, media page & uploadRecord page
 */
class RecordBox {

    public $error = null;
    public $recordArray = array();

    /**
     * \fn	init($id)
     * \brief	init for recordBox for personal Page
     * \param	$id of the user who owns the page
     * \todo
     */
    public function init($id, $limit = 3, $skip = 0, $upload = false) {
        if ($upload == true) {
            require_once SERVICES_DIR . 'utils.service.php';
            $currentUserId = sessionChecker();
            if (is_null($currentUserId)) {
                $this->error = ONLYIFLOGGEDIN;
                return;
            }
        }
        $connectionService = new ConnectionService();
        $connectionService->connect();
        if (!$connectionService->active) {
            $this->error = $connectionService->error;
            return;
        } else {
            $sql = "SELECT id,
                           active,
                           buylink,
                           city,
                           commentcounter,
                           counter,
                           cover,
                           description,
                           duration,
                           fromuser,
                           genre,
                           label,
                           latitude,
                           longitude,
                           lovecounter,
                           reviewCounter,
                           sharecounter,
                           songCounter,
                           thumbnail,
                           title,
                           tracklist,
                           year,
                           createdat,
                           updatedat,
                      FROM record
                     WHERE fromuser = " . $id . "
                  ORDER BY createdat DESC
                     LIMIT " . $skip . ", " . $limit;
            $results = mysqli_query($connectionService->connection, $sql);
            while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
                $rows[] = $row;
            $records = array();
            foreach ($rows as $row) {
                require_once 'record.class.php';
                $record = new Record();
                $record->setId($row['id']);
                $record->setActive($row['active']);
                $record->setBuylink($row['buylink']);
                $record->setCity($row['city']);
                $record->setCommentcounter($row['commentcounter']);
                $record->setCounter($row['counter']);
                $record->setCover($row['cover']);
                $record->setDescription($row['description']);
                $record->setDuration($row['duration']);
                $record->setFromuser($row['fromuser']);
                $record->setGenre($row['genre']);
                $record->setLabel($row['label']);
                $record->setLatitude($row['latitude']);
                $record->setLongitude($row['longitude']);
                $record->setLovecounter($row['lovecounter']);
                $record->setReviewCounter($row['reviewCounter']);
                $record->setSharecounter($row['sharecounter']);
                $record->setSongCounter($row['songCounter']);
                $record->setThumbnail($row['thumbnail']);
                $record->setTitle($row['title']);
                $record->setTracklist($row['tracklist']);
                $record->setYear($row['year']);
                $record->setCreatedat($row['createdat']);
                $record->setUpdatedat($row['updatedat']);
                $records[$row['id']] = $record;
            }
            $connectionService->disconnect();
            if (!$results) {
                return;
            } else {
                $this->recordArray = $results;
            }
        }
    }

    /**
     * \fn	initForMediaPage($id)
     * \brief	init for Media Page
     * \param	$id of the record to display in Media Page
     * \todo
     */
    public function initForMediaPage($id) {
        $connectionService = new ConnectionService();
        $connectionService->connect();
        if (!$connectionService->active) {
            $this->error = $connectionService->error;
            return;
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
                           r.genre,
                           r.label,
                           r.latitude,
                           r.longitude,
                           r.lovecounter,
                           r.reviewCounter,
                           r.sharecounter,
                           r.songCounter,
                           r.thumbnail thumbnail_r,
                           r.title,
                           r.tracklist,
                           r.year,
                           r.createdat,
                           r.updatedat,
                           u.id id_u,
                           u.username,
                           u.thumbnail thumbnail_u,
                           u.type
                      FROM record r, user u
                     WHERE r.id = " . $id . "
                       AND r.fromuser = u.id";
            $results = mysqli_query($connectionService->connection, $sql);
            while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
                $rows[] = $row;
            $records = array();
            foreach ($rows as $row) {
                require_once 'record.class.php';
                require_once 'user.class.php';
                $record = new Record();
                $record->setId($row['id_r']);
                $record->setActive($row['active']);
                $record->setBuylink($row['buylink']);
                $record->setCity($row['city']);
                $record->setCommentcounter($row['commentcounter']);
                $record->setCounter($row['counter']);
                $record->setCover($row['cover']);
                $record->setCreatedat($row['createdat']);
                $record->setDescription($row['description']);
                $record->setDuration($row['duration']);
                $fromuser = new User($row_user['type']);
                $fromuser->setId($row_user['id_u']);
                $fromuser->setThumbnail($row_user['thumbnail_u']);
                $fromuser->setUsername($row_user['username']);
                $record->setFromuser($fromuser);
                $sql = "SELECT g.genre
                          FROM record_genre rg, genre g
                         WHERE rg.id_record = " . $row['id_r'] . "
                           AND rg.id_genre = g.id";
                $results = mysqli_query($connectionService->connection, $sql);
                while ($row_genre = mysqli_fetch_array($results, MYSQLI_ASSOC))
                    $rows_genre[] = $row_genre;
                $genres = array();
                foreach ($rows_genre as $row_genre) {
                    $genres[] = $row_genre;
                }
                $record->setGenre($genres);
                $record->setLabel($row['label']);
                $record->setLatitude($row['locationlat']);
                $record->setLongitude($row['locationlon']);
                $record->setLovecounter($row['lovecounter']);
                $record->setReviewCounter($row['reviewCounter']);
                $record->setSharecounter($row['sharecounter']);
                $record->setSongCounter($row['songCounter']);
                $record->setThumbnail($row['thumbnail_r']);
                $record->setTitle($row['title']);
                $record->setTracklist($row['tracklist']);
                $record->setUpdatedat($row['updatedat']);
                $record->setYear($row['year']);
                $records[$row['id_r']] = $record;
            }
            $connectionService->disconnect();
            if (!$results) {
                return;
            } else {
                $this->recordArray = $results;
            }
        }
    }

    /**
     * \fn	init($genre = null, $limit = null, $skip = null)
     * \brief	Init RecordFilter instance for TimeLine
     * \param	$genre = null, $limit = null, $skip = null
     * \todo
     */
    public function initForStream($lat = null, $long = null, $city = null, $country = null, $genre = null, $limit = null, $skip = null, $distance = null, $unit = 'km', $field = 'loveCounter') {
        require_once SERVICES_DIR . 'utils.service.php';
        $currentUserId = sessionChecker();
        if (is_null($currentUserId)) {
            $this->error = ONLYIFLOGGEDIN;
            return;
        }
    }

    /**
     * \fn	initForTracklist($id)
     * \brief	init for Tracklist
     * \param	$id of the record to display 
     * \todo
     */
    public function initForTracklist($id) {
        $connectionService = new ConnectionService();
        $connectionService->connect();
        if (!$connectionService->active) {
            $this->error = $connectionService->error;
            return;
        } else {
            $sql = "SELECT s.id id_s,
                           s.active,
                           s.commentcounter,
                           s.counter,
                           s.duration,
                           s.fromuser,
                           s.genre,
                           s.latitude,
                           s.longitude,
                           s.lovecounter,
                           s.path,
                           s.position,
                           s.record,
                           s.sharecounter,
                           s.title,
                           s.createdat,
                           s.updatedat,
                           u.id id_u,
                           u.username,
                           u.thumbnail,
                           u.type
                      FROM song s, user u
                     WHERE s.record = " . $id . "
                       AND s.fromuser = u.id
                     LIMIT 0, 50";
            $results = mysqli_query($connectionService->connection, $sql);
            while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC))
            $rows[] = $row;
            $songs = array();
            foreach ($rows as $row) {
                require_once 'song.class.php';
                require_once 'user.class.php';
                $song = new Song();
                $song->setId($row['id_s']);
                $song->setActive($row['active']);
                $song->setCommentcounter($row['commentcounter']);
                $song->setCounter($row['counter']);
                $song->setDuration($row['duration']);
                $fromuser = new User($row['type']);
                $fromuser->setId($row['id_u']);
                $fromuser->setThumbnail($row['thumbnail']);
                $fromuser->setUsername($row['username']);
                $$song->setFromuser($fromuser);
                $song->setGenre($row['genre']);
                $song->setLatitude($row['latitude']);
                $song->setLongitude($row['longitude']);
                $song->getLovecounter($row['lovecounter']);
                $song->setPath($row['path']);
                $song->setPosition($row['position']);
                $song->setSharecounter($row['sharecounter']);
                $song->setTitle($row['title']);
                $song->setCreatedat($row['createdat']);
                $song->setUpdatedat($row['updatedat']);
                $songs[$row['id_s']] = $song;
            }
            $connectionService->disconnect();
            if (!$results) {
                return;
            } else {
                $this->songArray = $songs;
            }
        }
    }

}

?>