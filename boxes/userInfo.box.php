<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		0.3
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box caricamento info utente
 * \details		Recupera le informazioni dell'utente, le inserisce in un array da passare alla view
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
 * \brief	UserInfoBox class 
 * \details	box class to pass info to the view 
 */
class UserInfoBox {

    public $user = null;
    public $error = null;

    /**
     * \fn	init($id)
     * \brief	Init InfoBox instance for Personal Page
     * \param	$id for user that owns the page
     * \return  instance of UserInfoBox
     */
    public function init($id) {
        $connectionService = new ConnectionService();
        $connectionService->connect();
        if (!$connectionService->active) {
            $this->error = $connectionService->error;
            return;
        } else {
            $sql = "SELECT id,
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
                           members,
                           premium,
                           premiumexpirationdate,
                           settings,
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
                     WHERE id = " . $id;
            $results = mysqli_query($connectionService->connection, $sql);
            $row = mysqli_fetch_array($results, MYSQLI_ASSOC);
            require_once 'user.class.php';
            $user = new User($row['type']);
            $user->setId($row['id']);
            $user->setActive($row['active']);
            $user->setAddress($row['address']);
            $user->setAvatar($row['avatar']);
            $user->setBackground($row['background']);
            $user->setBirthday($row['birthday']);
            $user->setCity($row['city']);
            $user->setCollaborationcounter($row['collaborationcounter']);
            $user->setCountry($row['country']);
            $user->setCreatedat($row['createdat']);
            $user->setDescription($row['description']);
            $user->setEmail($row['email']);
            $user->setFacebookId($row['facebookid']);
            $user->setFbPage($row['facebookpage']);
            $user->setFirstname($row['firstname']);
            $user->setFollowerscounter($row['followerscounter']);
            $user->setFollowingcounter($row['followingcounter']);
            $user->setFriendshipcounter($row['friendshipcounter']);
            $user->setGooglepluspage($row['googlepluspage']);
            $user->setJammercounter($row['jammercounter']);
            $user->setJammertype($row['jammertype']);
            $user->setLastname($row['lastname']);
            $user->setLevel($row['level']);
            $user->setLevelvalue($row['levelvalue']);
            $user->setLatitude($row['latitude']);
            $user->setLongitude($row['longitude']);
            $user->setMembers($row['members']);
            $user->setPremium($row['premium']);
            $user->setPremiumexpirationdate($row['premiumexpirationdate']);
            $user->setSettings($row['settings']);
            $user->setSex($row['sex']);
            $user->setThumbnail($row['thumbnail']);
            $user->setTwitterpage($row['twitterpage']);
            $user->setUpdatedat($row['updatedat']);
            $user->setUsername($row['username']);
            $user->setVenuecounter($row['venuecounter']);
            $user->setWebsite($row['website']);
            $user->setYoutubechannel($row['youtubechannel']);
            $connectionService->disconnect();
            if (!$results) {
                return;
            } else {
                $this->user = $user;
            }
        }
    }

}

?>
