<?php

/* ! \par Info Generali:
 *  \author    Maria Laura Fresu
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par Info Classe:
 *  \brief     Album
 *  \details   Classe raccoglitore per immagini
 *  
 *  \par Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:album">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:album">API</a>
 */

class AlbumParse {

    private $parseQuery;

    function __construct() {

        $this->parseQuery = new ParseQuery("Album");
    }

    function save(Album $album) {

        //creo un'istanza dell'oggetto della libreria ParseLib
        $parseObj = new parseObject("Album");

        //inizializzo le properties
        $parseObj->active = $album->getActive();
        $parseObj->counter = $album->getCounter();
        $parseObj->cover = $album->getCover();
        //$parseObj->coverFile = $album->getCoverFile();
        $parseObj->description = $album->getDescription();

        //array di utenti

        if ($album->getFeaturing() != null && count($album->getFeaturing()) > 0) {

            $parseObj->featuring = array();

            foreach ($album->getFeaturing() as $user) {
                array_push($parseObj->featuring, $user->getObjectId());
            }
        }
        else
            $parseObj->featuring = null;


        if ($album->getFromUser() != null && count($album->getFromUser()) > 0) {

            $fromUser = $album->getFromUser();

            $parseObj->fromUser = array("__type" => "Pointer", "className" => "_User", "objectId" => $fromUser->getObjectId());
        }
        else
            $parseObj->fromUser = null;

        if ($album->getLocation() != null) {
            $geoPoint = $album->getLocation();
            $parseObj->location = $geoPoint->location;
        }
        else
            $parseObj->location = null;

        $parseObj->loveCounter = $album->getLoveCounter();

        if (count($parseObj->tag) > 0)
            $parseObj->tag = $album->getTags();
        else
            $parseObj->tag = null;

        $parseObj->thumbnailCover = $album->getThumbnailCover();
        $parseObj->title = $album->getTitle();

        if ($album->getObjectId() != null) {

            try {
                //aggiornamento
                $ret = $parseObj->update($album->getObjectId());

                $album->setUpdatedAt($ret->updatedAt, new DateTimeZone("America/Los_Angeles"));
            } catch (ParseLibraryException $e) {

                return false;
            }
        } else {
            //salvataggio
            try {

                $ret = $parseObj->save();

                $album->setObjectId($ret->objectId);

                $album->setCreatedAt(new DateTime($ret->createdAt, new DateTimeZone("America/Los_Angeles")));

                $album->setUpdatedAt(new DateTime($ret->createdAt, new DateTimeZone("America/Los_Angeles")));
            } catch (ParseLibraryException $e) {

                return false;
            }
        }

        return $album;
    }

    /**
     * 
     * @param Album $album
     * @return boolean
     */
    function delete(Album $album) {
        if ($album) {
            $album->setActive(false);

            if ($this->save($album))
                return true;
            else
                return false;
        }
        else
            return false;
    }

    function getAlbum($albumId) {

        $album = null;

        $this->parseQuery->where('objectId', $albumId);

        $result = $this->parseQuery->find();

        if (is_array($result->results) && count($result->results) > 0) {

            $ret = $result->results[0];

            if ($ret) {

                //recupero l'utente
                $album = $this->parseToAlbum($ret);
            }
        }

        return $album;
    }

    function parseToAlbum(stdClass $parseObj) {

        $album = new Album();

        if (isset($parseObj->objectId))
            $album->setObjectId($parseObj->objectId);
        if (isset($parseObj->active))
            $album->setActive($parseObj->active);
        if (isset($parseObj->counter))
            $album->setCounter($parseObj->counter);
        if (isset($parseObj->cover))
            $album->setCover($parseObj->cover);
        /*
        if (isset($parseObj->coverFile))
            $album->setCoverFile($parseObj->coverFile);
        */
        if (isset($parseObj->description))
            $album->setDescription($parseObj->description);
        
        if (isset($parseObj->featuring)) {

            $parseUser = new UserParse();

            $featuring = $parseUser->getUserArrayById($parseObj->featuring);

            $album->setFeaturing($featuring);
        }

        if (isset($parseObj->fromUser)) {
            $parseUser = new UserParse();
            $pointer = $parseObj->fromUser;
            $fromUser = $parseUser->getUserById($pointer->getObjectId());
            $album->setFromUser($fromUser);
        }

        if (isset($parseObj->location)) {
            //recupero il GeoPoint
            $geoParse = $parseObj->location;
            $geoPoint = new parseGeoPoint($geoParse->latitude, $geoParse->longitude);
            $album->setLocation($geoPoint);
        }

        if (isset($parseObj->loveCounter))
            $album->setLoveCounter($parseObj->loveCounter);

        
        if (isset($parseObj->thumbnailCover))
            $album->setThumbnailCover($parseObj->thumbnailCover);
 
        if (isset($parseObj->tag))
            $album->setTag($parseObj->tag);
        
        if (isset($parseObj->title))
            $album->setTitle($parseObj->title);

        if (isset($parseObj->createdAt)) {

            $createdAt = new DateTime($parseObj->createdAt);

            $album->setCreatedAt($createdAt);
        }

        if (isset($parseObj->updatedAt)) {
            $updatedAt = new DateTime($parseObj->updatedAt);

            $album->setUpdatedAt($updatedAt);
        }
        if (isset($parseObj->ACL)) {
            $ACL = null;
            $album->setACL($ACL);
        }

        return $album;
    }

}

?>
