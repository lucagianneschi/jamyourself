<?php

/**
 * User Class
 *
 * @author		Stefano Muscas
 * @author		Daniele Caldelli
 * @version		0.2
 * @since		2013
 * @copyright		Jamyourself.com 2013
 * @warning
 * @bug
 * @todo
 * @link https://github.com/lucagianneschi/jamyourself/wiki/Definizione-Classe:-User
 */
class User {

    /**
     * @property int id istanza
     */
    private $id;

    /**
     * @property date data creazione istanza
     */
    private $createdat;

    /**
     * @property date data modifica istanza
     */
    private $updatedat;

    /**
     * @property string di password (con criptazione)
     */
    private $password;

    /**
     * @property int istanza attiva/non attiva
     */
    private $active;

    /**
     * @property string di indirizzo dello user
     */
    private $address;

    /**
     * @property string di indirizzo dell'avatar
     */
    private $avatar;

    /**
     * @property string di indirizzo del background
     */
    private $background;

    /**
     * @property array di int dei badge
     */
    private $badge;

    /**
     * @property string data nascita user
     */
    private $birthday;

    /**
     * @property string città dello user
     */
    private $city;

    /**
     * @property int numero di collaboratori dello user (solo JAMMER e VENUE)
     */
    private $collaborationcounter;

    /**
     * @property string country dello user
     */
    private $country;

    /**
     * @property string descrizione dello user
     */
    private $description;

    /**
     * @property string email dello user
     */
    private $email;

    /**
     * @property string id facebook dello user
     */
    private $facebookid;

    /**
     * @property string pagina facebook dello user
     */
    private $facebookpage;

    /**
     * @property string nome dello user
     */
    private $firstname;

    /**
     * @property int numero di followers dello user (solo JAMMER e VENUE)
     */
    private $followercounter;

    /**
     * @property int numero di following dello user (solo SPOTTER)
     */
    private $followingcounter;

    /**
     * @property int numero di friends dello user (solo SPOTTER)
     */
    private $friendshipcounter;

    /**
     * @property string pagina google+
     */
    private $googlepluspage;

    /**
     * @property int numero di jammer delle relazioni collaboration (JAMMER e VENUE) e followin (SPOTTER)
     */
    private $jammercounter;

    /**
     * @property string tipo di jammer (BAND/SINGOLO)
     */
    private $jammertype;

    /**
     * @property string cognome dell'utente
     */
    private $lastname;

    /**
     * @property float latitudine
     */
    private $latitude;

    /**
     * @property int contatore punti
     */
    private $level;

    /**
     * @property int levelvalue of the user -> 1 to 5
     */
    private $levelvalue;

    /**
     * @property int localtype
     */
    private $localtype;

    /**
     * @property float longitudine
     */
    private $longitude;

    /**
     * @property array di string
     */
    private $member;

    /**
     * @property array di int
     */
    private $music;

    /**
     * @property int 1 = PREMIUM, 0 = STANDARD
     */
    private $premium;

    /**
     * @property DateTime of the expitation if the user is PREMIUM
     */
    private $premiumexpirationdate;

    /**
     * @property string path per il thumb dell'utente
     */
    private $thumbnail;

    /**
     * @property array of ids of setting
     */
    private $settings;

    /**
     * @property string per il sesso dell'utente M/F/ND
     */
    private $sex;

    /**
     * @property string per la pagina di twitter
     */
    private $twitterpage;

    /**
     * @property string JAMMER/VENUE/SPOTTER
     */
    private $type;

    /**
     * @property string username
     */
    private $username;

    /**
     * @property int numero di venue delle relazioni collaboration (JAMMER e VENUE) e followin (SPOTTER)
     */
    private $venuecounter;

    /**
     * @property string link sito web utente
     */
    private $website;

    /**
     * @property string cancale youtube
     */
    private $youtubechannel;

    /**
     * Return the id value
     * @return	string
     */
    public function getId() {
	return $this->id;
    }

    /**
     * Return the User creation date
     * @return	DateTime
     */
    public function getCreatedat() {
	return $this->createdat;
    }

    /**
     * Return the User modification date
     * @return	DateTime
     */
    public function getUpdatedat() {
	return $this->updatedat;
    }

    /**
     * Return the activation state of the User
     * @return	boolean
     */
    public function getActive() {
	return $this->active;
    }

    /**
     * Return the address of the User
     * @return	string
     */
    public function getAddress() {
	return $this->address;
    }

    /**
     * Return the profile picture link of the User
     * @return	string
     */
    public function getAvatar() {
	return $this->avatar;
    }

    /**
     * Return the background link of the User
     * @return	string
     */
    public function getBackground() {
	return $this->background;
    }

    /**
     * Return the badge array of int of badge
     * @return	string
     */
    public function getBadge() {
	return $this->badge;
    }

    /**
     * Return the birthday of the User represented by a string with format YYYY-MM-DD
     * @return	string
     */
    public function getBirthday() {
	return $this->birthday;
    }

    /**
     * Return the city of the User
     * @return	string
     */
    public function getCity() {
	return $this->city;
    }

    /**
     * Return the number of User in collaboration with
     * @return	number
     */
    public function getCollaborationcounter() {
	return $this->collaborationcounter;
    }

    /**
     * Return the country of the User
     * @return	string
     */
    public function getCountry() {
	return $this->country;
    }

    /**
     * Return the description of the User
     * @return	string
     */
    public function getDescription() {
	return $this->description;
    }

    /**
     * Return the email of the User
     * @return	string
     */
    public function getEmail() {
	return $this->email;
    }

    /**
     * Return the facebook id of the User
     * @return	string
     */
    public function getFacebookid() {
	return $this->facebookid;
    }

    /**
     * Return the facebook page link of the User
     * @return	string
     */
    public function getFacebookpage() {
	return $this->facebookpage;
    }

    /**
     * Return the firstname of the User
     * @return	string
     */
    public function getFirstname() {
	return $this->firstname;
    }

    /**
     * Return the number of User followed
     * @return	number
     */
    public function getFollowerscounter() {
	return $this->followercounter;
    }

    /**
     * Return the number of User followed
     * @return	number
     */
    public function getFollowingcounter() {
	return $this->followingcounter;
    }

    /**
     * Return the number of User in friendship relation
     * @return	number
     */
    public function getFriendshipcounter() {
	return $this->friendshipcounter;
    }

    /**
     * Return the googlePlus page link of the User
     * @return	string
     */
    public function getGooglepluspage() {
	return $this->googlepluspage;
    }

    /**
     * Return the jammer counter, number of Jammer in collaboration
     * @return	number
     */
    public function getJammercounter() {
	return $this->jammercounter;
    }

    /**
     * Return the jammer type of the User
     * @return	string
     */
    public function getJammertype() {
	return $this->jammertype;
    }

    /**
     * Return the lastname of the User
     * @return	string
     */
    public function getLastname() {
	return $this->lastname;
    }

    /**
     * Return the latitude value
     * @return	latitude
     */
    public function getLatitude() {
	return $this->latitude;
    }

    /**
     * Return the level of the User
     * @return	number
     */
    public function getLevel() {
	return $this->level;
    }

    /**
     * Return the level value of the User
     * @return	number
     */
    public function getLevelvalue() {
	return $this->levelvalue;
    }

    /**
     * Return the localtype value
     * @return	long
     */
    public function getLocaltype() {
	return $this->localtype;
    }

    /**
     * Return the longitude value
     * @return	long
     */
    public function getLongitude() {
	return $this->longitude;
    }

    /**
     * Return the member value
     * @return	member
     */
    public function getMember() {
	return $this->member;
    }

    /**
     * Return the music value
     * @return	music
     */
    public function getMusic() {
	return $this->music;
    }

    /**
     * Return the password of the User
     * @return	string
     */
    public function getPassword() {
	return $this->password;
    }

    /**
     * Return if the User has a Premium account
     * @return	boolean
     */
    public function getPremium() {
	return $this->premium;
    }

    /**
     * Return the expiration date of the premium account of the User
     * @return	DateTime
     */
    public function getPremiumexpirationdate() {
	return $this->premiumexpirationdate;
    }

    /**
     * Return the thumbnail profile picture link of the User
     * @return	string
     */
    public function getThumbnail() {
	return $this->thumbnail;
    }

    /**
     * Return an array of the setting of the User
     * @return	array
     */
    public function getSettings() {
	return $this->settings;
    }

    /**
     * Return the sex of the User
     * @return	string
     */
    public function getSex() {
	return $this->sex;
    }

    /**
     * Return the twitter page link of the User
     * @return	string
     */
    public function getTwitterpage() {
	return $this->twitterpage;
    }

    /**
     * Return the type of the User
     * @return	string
     */
    public function getType() {
	return $this->type;
    }

    /**
     * Return the username of the User
     * @return	string
     */
    public function getUsername() {
	return $this->username;
    }

    /**
     * Return venue counter, number of venue in collaboration
     * @return	number
     */
    public function getVenuecounter() {
	return $this->venuecounter;
    }

    /**
     * Return the website link of the User
     * @return	string
     */
    public function getWebsite() {
	return $this->website;
    }

    /**
     * Return the youtube channel link of the User
     * @return	string
     */
    public function getYoutubechannel() {
	return $this->youtubechannel;
    }

    /**
     * Sets the id value
     * @param	string
     */
    public function setId($id) {
	$this->id = $id;
    }

    /**
     * Sets the User creation date
     * @param	DateTime
     */
    public function setUpdatedat(DateTime $updatedat) {
	$this->updatedat = $updatedat;
    }

    /**
     * Sets the User modification date
     * @param	DateTime
     */
    public function setCreatedat(DateTime $createdat) {
	$this->createdat = $createdat;
    }

    /**
     * Sets the active value of the User
     * @param	boolean
     */
    public function setActive($active) {
	$this->active = $active;
    }

    /**
     * Sets the address of the User
     * @param	string
     */
    public function setAddress($address) {
	$this->address = $address;
    }

    /**
     * Sets the avatar of the User
     * @param	string
     */
    public function setAvatar($avatar) {
	$this->avatar = $avatar;
    }

    /**
     * Sets the background value of the User
     * @param	string
     */
    public function setBackground($background) {
	$this->background = $background;
    }

    /**
     * Sets the badge array of the user
     * @param	string
     */
    public function setBadge($badge) {
	$this->badge = $badge;
    }

    /**
     * Sets the birthday of the User represented by a string with format YYYY-MM-DD
     * @param	string
     */
    public function setBirthday($birthday) {
	$this->birthday = $birthday;
    }

    /**
     * Sets the city value of the User
     * @param	string
     */
    public function setCity($city) {
	$this->city = $city;
    }

    /**
     * Sets the collaborationcounter of the User
     * @param	number
     */
    public function setCollaborationcounter($collaborationcounter) {
	$this->collaborationcounter = $collaborationcounter;
    }

    /**
     * Sets the country value of the User
     * @param	string
     */
    public function setCountry($country) {
	$this->country = $country;
    }

    /**
     * Sets the description value of the User
     * @param	string
     */
    public function setDescription($description) {
	$this->description = $description;
    }

    /**
     * Sets the email value of the User
     * @param	string
     */
    public function setEmail($email) {
	$this->email = $email;
    }

    /**
     * Sets the facebook id of the User
     * @param	string
     */
    public function setFacebookid($facebookid) {
	$this->facebookid = $facebookid;
    }

    /**
     * Sets the facebook page link of the User
     * @param	string
     */
    public function setFacebookpage($facebookpage) {
	$this->facebookpage = $facebookpage;
    }

    /**
     * Sets the firstname id of the User
     * @param	string
     */
    public function setFirstname($firstname) {
	$this->firstname = $firstname;
    }

    /**
     * Sets the followercounter of the User
     * @param	number
     */
    public function setFollowercounter($followercounter) {
	$this->followercounter = $followercounter;
    }

    /**
     * Sets the followingcounter of the User
     * @param	number
     */
    public function setFollowingcounter($followingcounter) {
	$this->followingcounter = $followingcounter;
    }

    /**
     * Sets the friendshipcounter of the User
     * @param	number
     */
    public function setFriendshipcounter($friendshipcounter) {
	$this->friendshipcounter = $friendshipcounter;
    }

    /**
     * Sets the google plus page link of the User
     * @param	string
     */
    public function setGooglepluspage($googlepluspage) {
	$this->googlepluspage = $googlepluspage;
    }

    /**
     * Sets the jammer counter
     * @param	number
     */
    public function setJammercounter($jammercounter) {
	$this->jammercounter = $jammercounter;
    }

    /**
     * Sets the jammer type of the User
     * @param	string
     */
    public function setJammertype($jammertype) {
	$this->jammertype = $jammertype;
    }

    /**
     * Sets the lastname id of the User
     * @param	string
     */
    public function setLastname($lastname) {
	$this->lastname = $lastname;
    }

    /**
     * Sets the latitude value
     * @param	$longitude
     */
    public function setLatitude($latitude) {
	$this->latitude = $latitude;
    }

    /**
     * Sets the level of the User
     * @param	number
     */
    public function setLevel($level) {
	$this->level = $level;
    }

    /**
     * Sets the level value of the User
     * @param	number
     */
    public function setLevelvalue($levelvalue) {
	$this->view = $levelvalue;
    }

    /**
     * Sets the localtype value
     * @param	$localtype
     */
    public function setLocaltype($localtype) {
	$this->localtype = $localtype;
    }

    /**
     * Sets the longitude value
     * @param	$longitude
     */
    public function setLongitude($longitude) {
	$this->longitude = $longitude;
    }

    /**
     * Sets an array of id of the User related with the User
     * @param	array
     */
    public function setMember($member) {
	$this->members = $member;
    }

    /**
     * Sets an array of int of the User musical tag
     * @param	array
     */
    public function setMusic($music) {
	$this->music = $music;
    }

    /**
     * Sets the password value of the User
     * @param	string
     */
    public function setPassword($password) {
	$this->password = $password;
    }

    /**
     * Sets if the User has a Premium account
     * @param	boolean
     */
    public function setPremium($premium) {
	$this->premium = $premium;
    }

    /**
     * Sets the expiration date of the User Premium account
     * @param	DateTime
     */
    public function setPremiumexpirationdate($premiumexpirationdate) {
	$this->premiumexpirationdate = $premiumexpirationdate;
    }

    /**
     * Sets the profile picture thumbnail link of the User
     * @param	string
     */
    public function setThumbnail($thumbnail) {
	$this->thumbnail = $thumbnail;
    }

    /**
     * Sets an array of settings of the User
     * @param	array
     */
    public function setSettings($settings) {
	$this->settings = $settings;
    }

    /**
     * Sets the sex id of the User
     * @param	string
     */
    public function setSex($sex) {
	$this->sex = $sex;
    }

    /**
     * Sets the twitter page link of the User
     * @param	string
     */
    public function setTwitterpage($twitterpage) {
	$this->twitterpage = $twitterpage;
    }

    /**
     * Sets the type of the User
     * @param	string
     */
    public function setType($type) {
	$this->type = $type;
    }

    /**
     * Sets the username value of the User
     * @param	string
     */
    public function setUsername($username) {
	$this->username = $username;
    }

    /**
     * Sets the venue counter
     * @param	number
     */
    public function setVenuecounter($venuecounter) {
	$this->venuecounter = $venuecounter;
    }

    /**
     * Sets the website link of the User
     * @param	string
     */
    public function setWebsite($website) {
	$this->website = $website;
    }

    /**
     * Sets the youtube channel link of the User
     * @param	string
     */
    public function setYoutubechannel($youtubechannel) {
	$this->youtubechannel = $youtubechannel;
    }

    /**
     * Return a printable string representing the User object
     * @return	string
     */
    public function __toString() {
	$string = '';
	$string .= '[id] => ' . $this->getId() . '<br />';
	$createdat = new DateTime($this->getCreatedat());
	$string .= '[createdat] => ' . $createdat->format('d-m-Y H:i:s') . '<br />';
	$updatedat = new DateTime($this->getUpdatedat());
	$string .= '[updatedat] => ' . $updatedat->format('d-m-Y H:i:s') . '<br />';
	$string .= '[active] => ' . $this->getActive() . '<br />';
	$string .= '[address] => ' . $this->getAddress() . '<br />';
	$string .= '[avatar] => ' . $this->getAvatar() . '<br />';
	$string .= '[background] => ' . $this->getBackground() . '<br />';
	foreach ($this->getBadge() as $badge) {
	    $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	    $string .= '[badge] => ' . $badge . '<br />';
	}
	$string .= '[birthday] => ' . $this->getBirthday() . '<br />';
	$string .= '[city] => ' . $this->getCity() . '<br />';
	$string .= '[collaborationcounter] => ' . $this->getCollaborationcounter() . '<br />';
	$string .= '[country] => ' . $this->getCountry() . '<br />';
	$string .= '[description] => ' . $this->getDescription() . '<br />';
	$string .= '[email] => ' . $this->getEmail() . '<br />';
	$string .= '[facebookid] => ' . $this->getFacebookid() . '<br />';
	$string .= '[facebookpage] => ' . $this->getFacebookpage() . '<br />';
	$string .= '[firstname] => ' . $this->getFirstname() . '<br />';
	$string .= '[followercounter] => ' . $this->getFollowerscounter() . '<br />';
	$string .= '[followingcounter] => ' . $this->getFollowingcounter() . '<br />';
	$string .= '[friendshipcounter] => ' . $this->getFriendshipcounter() . '<br />';
	$string .= '[googlepluspage] => ' . $this->getGooglepluspage() . '<br />';
	$string .= '[jammercounter] => ' . $this->getJammercounter() . '<br />';
	$string .= '[jammertype] => ' . $this->getJammertype() . '<br />';
	$string .= '[lastname] => ' . $this->getLastname() . '<br />';
	$string .= '[latitude] => ' . $this->getLatitude() . '<br />';
	$string .= '[localtype] => ' . $this->getLocaltype() . '<br />';
	$string .= '[longitude] => ' . $this->getLongitude() . '<br />';
	$string .= '[level] => ' . $this->getLevel() . '<br />';
	$string .= '[levelvalue] => ' . $this->getLevelvalue() . '<br />';
	foreach ($this->getMember() as $member) {
	    $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	    $string .= '[member] => ' . $member . '<br />';
	}
	foreach ($this->getMusic() as $music) {
	    $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	    $string .= '[music] => ' . $music . '<br />';
	}
	$string .= '[password] => ' . $this->getPassword() . '<br />';
	$string .= '[premium] => ' . $this->getPremium() . '<br />';
	$premiumexpirationdate = new DateTime($this->getPremiumexpirationdate());
	$string .= '[premiumexpirationdate] => ' . $premiumexpirationdate->format('d-m-Y H:i:s') . '<br />';
	$string .= '[thumbnail] => ' . $this->getThumbnail() . '<br />';
	foreach ($this->getSettings() as $settings) {
	    $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	    $string .= '[settings] => ' . $settings . '<br />';
	}
	$string .= '[sex] => ' . $this->getSex() . '<br />';
	$string .= '[twitterpage] => ' . $this->getTwitterpage() . '<br />';
	$string .= '[type] => ' . $this->getType() . '<br />';
	$string .= '[username] => ' . $this->getUsername() . '<br />';
	$string .= '[venuecounter] => ' . $this->getVenuecounter() . '<br />';
	$string .= '[website] => ' . $this->getWebsite() . '<br />';
	$string .= '[youtubechannel] => ' . $this->getYoutubechannel() . '<br />';
	return $string;
    }

}

?>