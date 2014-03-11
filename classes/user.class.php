<?php

/* ! \par 		Info Generali:
 *  @author		Stefano Muscas
 *  @version		0.3
 *  \date		2013
 *  \copyright		Jamyourself.com 2013
 *  \par		Info Classe:
 *  \brief		User Class
 *  \details		Classe utente
 *  \par		Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="https://github.com/lucagianneschi/jamyourself/wiki/Definizione-Classe:-User">Descrizione della classe</a>
 *  <a href="https://github.com/lucagianneschi/jamyourself/wiki/API:-User">API</a>
 */

class User {

    private $id;
    private $createdat;
    private $updatedat;
    private $password;
    private $active;
    private $address;
    private $avatar;
    private $background;
    private $birthday;
    private $city;
    private $collaborationcounter;
    private $country;
    private $description;
    private $email;
    private $facebookid;
    private $facebookpage;
    private $firstname;
    private $followerscounter;
    private $followingcounter;
    private $friendshipcounter;
    private $googlepluspage;
    private $jammercounter;
    private $jammertype;
    private $lastname;
    private $latitude;
    private $level;
    private $levelvalue;
    private $longitude;
    private $premium;
    private $premiumexpirationdate;
    private $thumbnail;
    private $settings;
    private $sex;
    private $twitterpage;
    private $type;
    private $username;
    private $venuecounter;
    private $website;
    private $youtubechannel;

    /**
     * \fn	int getId()
     * \brief	Return the id value
     * @return	string
     */
    public function getId() {
	return $this->id;
    }

    /**
     * \fn		DateTime getCreatedat()
     * \brief	Return the User creation date
     * @return	DateTime
     */
    public function getCreatedat() {
	return $this->createdat;
    }

    /**
     * \fn		DateTime getUpdatedat()
     * \brief	Return the User modification date
     * @return	DateTime
     */
    public function getUpdatedat() {
	return $this->updatedat;
    }

    /**
     * \fn		boolean getActive()
     * \brief	Return the activation state of the User
     * @return	boolean
     */
    public function getActive() {
	return $this->active;
    }

    /**
     * \fn		string getAddress()
     * \brief	Return the address of the User
     * @return	string
     */
    public function getAddress() {
	return $this->address;
    }

    /**
     * \fn	string getAvatar()
     * \brief	Return the profile picture link of the User
     * @return	string
     */
    public function getAvatar() {
	return $this->avatar;
    }

    /**
     * \fn		string getBackground()
     * \brief	Return the background link of the User
     * @return	string
     */
    public function getBackground() {
	return $this->background;
    }

    /**
     * \fn		string getBirthday()
     * \brief	Return the birthday of the User represented by a string with format YYYY-MM-DD
     * @return	string
     */
    public function getBirthday() {
	return $this->birthday;
    }

    /**
     * \fn		string getCity()
     * \brief	Return the city of the User
     * @return	string
     */
    public function getCity() {
	return $this->city;
    }

    /**
     * \fn		number getCollaborationcounter()
     * \brief	Return the number of User in collaboration with
     * @return	number
     */
    public function getCollaborationcounter() {
	return $this->collaborationcounter;
    }

    /**
     * \fn		string getCountry()
     * \brief	Return the country of the User
     * @return	string
     */
    public function getCountry() {
	return $this->country;
    }

    /**
     * \fn		string getDescription()
     * \brief	Return the description of the User
     * @return	string
     */
    public function getDescription() {
	return $this->description;
    }

    /**
     * \fn		string getEmail()
     * \brief	Return the email of the User
     * @return	string
     */
    public function getEmail() {
	return $this->email;
    }

    /**
     * \fn		string getFacebookId()
     * \brief	Return the facebook id of the User
     * @return	string
     */
    public function getFacebookid() {
	return $this->facebookid;
    }

    /**
     * \fn		string getFbPage()
     * \brief	Return the facebook page link of the User
     * @return	string
     */
    public function getFacebookpage() {
	return $this->facebookpage;
    }

    /**
     * \fn		string getFirstname()
     * \brief	Return the firstname of the User
     * @return	string
     */
    public function getFirstname() {
	return $this->firstname;
    }

    /**
     * \fn		number getLevel()
     * \brief	Return the number of User followed
     * @return	number
     */
    public function getFollowerscounter() {
	return $this->followerscounter;
    }

    /**
     * \fn		number getFollowingcounter()
     * \brief	Return the number of User followed
     * @return	number
     */
    public function getFollowingcounter() {
	return $this->followingcounter;
    }

    /**
     * \fn		number getLevel()
     * \brief	Return the number of User in friendship relation
     * @return	number
     */
    public function getFriendshipcounter() {
	return $this->friendshipcounter;
    }

    /**
     * \fn		string getGooglepluspage()
     * \brief	Return the googlePlus page link of the User
     * @return	string
     */
    public function getGooglepluspage() {
	return $this->googlepluspage;
    }

    /**
     * \fn		number getJammercounter()
     * \brief	Return the jammer counter, number of Jammer in collaboration
     * @return	number
     */
    public function getJammercounter() {
	return $this->jammercounter;
    }

    /**
     * \fn		string getJammertype()
     * \brief	Return the jammer type of the User
     * @return	string
     */
    public function getJammertype() {
	return $this->jammertype;
    }

    /**
     * \fn		string getLastname()
     * \brief	Return the lastname of the User
     * @return	string
     */
    public function getLastname() {
	return $this->lastname;
    }

    /**
     * \fn	getLatitude()
     * \brief	Return the latitude value
     * @return	latitude
     */
    public function getLatitude() {
	return $this->latitude;
    }

    /**
     * \fn		number getLevel()
     * \brief	Return the level of the User
     * @return	number
     */
    public function getLevel() {
	return $this->level;
    }

    /**
     * \fn		number getLevelvalue()
     * \brief	Return the level value of the User
     * @return	number
     */
    public function getLevelvalue() {
	return $this->levelvalue;
    }

    /**
     * \fn	getLongitude()
     * \brief	Return the longitude value
     * @return	long
     */
    public function getLongitude() {
	return $this->longitude;
    }

    /**
     * \fn	string getPassword()
     * \brief	Return the password of the User
     * @return	string
     */
    public function getPassword() {
	return $this->password;
    }

    /**
     * \fn		boolean getPremium()
     * \brief	Return if the User has a Premium account
     * @return	boolean
     */
    public function getPremium() {
	return $this->premium;
    }

    /**
     * \fn		DateTime getPremiumexpirationdate()
     * \brief	Return the expiration date of the premium account of the User
     * @return	DateTime
     */
    public function getPremiumexpirationdate() {
	return $this->premiumexpirationdate;
    }

    /**
     * \fn	string getThumbnail()
     * \brief	Return the thumbnail profile picture link of the User
     * @return	string
     */
    public function getThumbnail() {
	return $this->thumbnail;
    }

    /**
     * \fn		array getSettings()
     * \brief	Return an array of the setting of the User
     * @return	array
     */
    public function getSettings() {
	return $this->settings;
    }

    /**
     * \fn		string getSex()
     * \brief	Return the sex of the User
     * @return	string
     */
    public function getSex() {
	return $this->sex;
    }

    /**
     * \fn		string getTwitterpage()
     * \brief	Return the twitter page link of the User
     * @return	string
     */
    public function getTwitterpage() {
	return $this->twitterpage;
    }

    /**
     * \fn		string getType()
     * \brief	Return the type of the User
     * @return	string
     */
    public function getType() {
	return $this->type;
    }

    /**
     * \fn		string getUsername()
     * \brief	Return the username of the User
     * @return	string
     */
    public function getUsername() {
	return $this->username;
    }

    /**
     * \fn		number getVenuecounter()
     * \brief	Return venue counter, number of venue in collaboration
     * @return	number
     */
    public function getVenuecounter() {
	return $this->venuecounter;
    }

    /**
     * \fn		string getWebsite()
     * \brief	Return the website link of the User
     * @return	string
     */
    public function getWebsite() {
	return $this->website;
    }

    /**
     * \fn		string getYoutubechannel()
     * \brief	Return the youtube channel link of the User
     * @return	string
     */
    public function getYoutubechannel() {
	return $this->youtubechannel;
    }

    /**
     * \fn		void setId($id)
     * \brief	Sets the id value
     * \param	string
     */
    public function setId($id) {
	$this->id = $id;
    }

    /**
     * \fn	void setCreatedat($createdat)
     * \brief	Sets the User creation date
     * \param	DateTime
     */
    public function setUpdatedat(DateTime $updatedat) {
	$this->updatedat = $updatedat;
    }

    /**
     * \fn	void setUpdatedat($updatedat)
     * \brief	Sets the User modification date
     * \param	DateTime
     */
    public function setCreatedat(DateTime $createdat) {
	$this->createdat = $createdat;
    }

    /**
     * \fn		void setActive($active)
     * \brief	Sets the active value of the User
     * \param	boolean
     */
    public function setActive($active) {
	$this->active = $active;
    }

    /**
     * \fn		void setAddress($address)
     * \brief	Sets the address of the User
     * \param	string
     */
    public function setAddress($address) {
	$this->address = $address;
    }

    /**
     * \fn	void setAvatar($avatar)
     * \brief	Sets the avatar of the User
     * \param	string
     */
    public function setAvatar($avatar) {
	$this->avatar = $avatar;
    }

    /**
     * \fn		void setBackground($background)
     * \brief	Sets the background value of the User
     * \param	string
     */
    public function setBackground($background) {
	$this->background = $background;
    }

    /**
     * \fn	string setBirthday($birthday)
     * \brief	Sets the birthday of the User represented by a string with format YYYY-MM-DD
     * \param	string
     */
    public function setBirthday($birthday) {
	$this->birthday = $birthday;
    }

    /**
     * \fn	void setCity($city)
     * \brief	Sets the city value of the User
     * \param	string
     */
    public function setCity($city) {
	$this->city = $city;
    }

    /**
     * \fn	void setLevel($collaborationcounter)
     * \brief	Sets the collaborationcounter of the User
     * \param	number
     */
    public function setCollaborationcounter($collaborationcounter) {
	$this->collaborationcounter = $collaborationcounter;
    }

    /**
     * \fn	void setCountry($country)
     * \brief	Sets the country value of the User
     * \param	string
     */
    public function setCountry($country) {
	$this->country = $country;
    }

    /**
     * \fn	void setDescription($description)
     * \brief	Sets the description value of the User
     * \param	string
     */
    public function setDescription($description) {
	$this->description = $description;
    }

    /**
     * \fn	void setEmail($email)
     * \brief	Sets the email value of the User
     * \param	string
     */
    public function setEmail($email) {
	$this->email = $email;
    }

    /**
     * \fn	string setFacebookid($facebookId)
     * \brief	Sets the facebook id of the User
     * \param	string
     */
    public function setFacebookid($facebookid) {
	$this->facebookid = $facebookid;
    }

    /**
     * \fn	void setFacebookpage($facebookpage)
     * \brief	Sets the facebook page link of the User
     * \param	string
     */
    public function setFacebookpage($facebookpage) {
	$this->facebookpage = $facebookpage;
    }

    /**
     * \fn	string setFirstname($firstname)
     * \brief	Sets the firstname id of the User
     * \param	string
     */
    public function setFirstname($firstname) {
	$this->firstname = $firstname;
    }

    /**
     * \fn	void setFollowerscounter($followerscounter)
     * \brief	Sets the followerscounter of the User
     * \param	number
     */
    public function setFollowerscounter($followerscounter) {
	$this->followerscounter = $followerscounter;
    }

    /**
     * \fn	void setFollowingcounter($followingcounter)
     * \brief	Sets the followingcounter of the User
     * \param	number
     */
    public function setFollowingcounter($followingcounter) {
	$this->followingcounter = $followingcounter;
    }

    /**
     * \fn	void setFriendshipcounter($friendshipcounter)
     * \brief	Sets the friendshipcounter of the User
     * \param	number
     */
    public function setFriendshipcounter($friendshipcounter) {
	$this->friendshipcounter = $friendshipcounter;
    }

    /**
     * \fn	void setGooglepluspage($googlepluspage)
     * \brief	Sets the google plus page link of the User
     * \param	string
     */
    public function setGooglepluspage($googlepluspage) {
	$this->googlepluspage = $googlepluspage;
    }

    /**
     * \fn	void setJammercounter($jammercounter)
     * \brief	Sets the jammer counter 
     * \param	number
     */
    public function setJammercounter($jammercounter) {
	$this->jammercounter = $jammercounter;
    }

    /**
     * \fn	void setJammertype($jammertype)
     * \brief	Sets the jammer type of the User
     * \param	string
     */
    public function setJammertype($jammertype) {
	$this->jammertype = $jammertype;
    }

    /**
     * \fn	string setLastname($lastname)
     * \brief	Sets the lastname id of the User
     * \param	string
     */
    public function setLastname($lastname) {
	$this->lastname = $lastname;
    }

    /**
     * \fn	void setLatitude($latitude)
     * \brief	Sets the latitude value
     * \param	$longitude
     */
    public function setLatitude($latitude) {
	$this->latitude = $latitude;
    }

    /**
     * \fn		void setLevel($level)
     * \brief	Sets the level of the User
     * \param	number
     */
    public function setLevel($level) {
	$this->level = $level;
    }

    /**
     * \fn		void setLevelvalue($levelvalue)
     * \brief	Sets the level value of the User
     * \param	number
     */
    public function setLevelvalue($levelvalue) {
	$this->view = $levelvalue;
    }

    /**
     * \fn	void setLongitude($longitude)
     * \brief	Sets the longitude value
     * \param	$longitude
     */
    public function setLongitude($longitude) {
	$this->longitude = $longitude;
    }

    /**
     * \fn		void setMembers($members)
     * \brief	Sets an array of id of the User related with the User
     * \param	array
     */
    public function setMembers($members) {
	$this->members = $members;
    }

    /**
     * \fn		void setPassword($password)
     * \brief	Sets the password value of the User
     * \param	string
     */
    public function setPassword($password) {
	$this->password = $password;
    }

    /**
     * \fn		void setPremium($premium)
     * \brief	Sets if the User has a Premium account
     * \param	boolean
     */
    public function setPremium($premium) {
	$this->premium = $premium;
    }

    /**
     * \fn		void setPremiumexpirationdate($premiumexpirationdate)
     * \brief	Sets the expiration date of the User Premium account
     * \param	DateTime
     */
    public function setPremiumexpirationdate($premiumexpirationdate) {
	$this->premiumexpirationdate = $premiumexpirationdate;
    }

    /**
     * \fn	void setThumbnail($thumbnail)
     * \brief	Sets the profile picture thumbnail link of the User
     * \param	string
     */
    public function setThumbnail($thumbnail) {
	$this->thumbnail = $thumbnail;
    }

    /**
     * \fn	void setSettings($settings)
     * \brief	Sets an array of settings of the User
     * \param	array
     */
    public function setSettings($settings) {
	$this->settings = $settings;
    }

    /**
     * \fn	string setSex($sex)
     * \brief	Sets the sex id of the User
     * \param	string
     */
    public function setSex($sex) {
	$this->sex = $sex;
    }

    /**
     * \fn	void setTwitterpage($twitterpage)
     * \brief	Sets the twitter page link of the User
     * \param	string
     */
    public function setTwitterpage($twitterpage) {
	$this->twitterpage = $twitterpage;
    }

    /**
     * \fn	void setType($type)
     * \brief	Sets the type of the User
     * \param	string
     */
    public function setType($type) {
	$this->type = $type;
    }

    /**
     * \fn		void setUsername($username)
     * \brief	Sets the username value of the User
     * \param	string
     */
    public function setUsername($username) {
	$this->username = $username;
    }

    /**
     * \fn	void setVenuecounter($venuecounter)
     * \brief	Sets the venue counter 
     * \param	number
     */
    public function setVenuecounter($venuecounter) {
	$this->venuecounter = $venuecounter;
    }

    /**
     * \fn	void setWebsite($website)
     * \brief	Sets the website link of the User
     * \param	string
     */
    public function setWebsite($website) {
	$this->website = $website;
    }

    /**
     * \fn	void setYoutubechannel($youtubechannel)
     * \brief	Sets the youtube channel link of the User
     * \param	string
     */
    public function setYoutubechannel($youtubechannel) {
	$this->youtubechannel = $youtubechannel;
    }

    /**
     * \fn	string __toString()
     * \brief	Return a printable string representing the User object
     * @return	string
     */
    public function __toString() {
	$string = '';
	$string .= '[id] => ' . $this->getId() . '<br />';
	$data = new DateTime($this->getCreatedat());
	$string .= '[createdat] => ' . $data->format('d-m-Y H:i:s') . '<br />';
	$data = new DateTime($this->getUpdatedat());
	$string .= '[updatedat] => ' . $data->format('d-m-Y H:i:s') . '<br />';
	$string .= '[active] => ' . $this->getActive() . '<br />';
	$string .= '[address] => ' . $this->getAddress() . '<br />';
	$string .= '[avatar] => ' . $this->getAvatar() . '<br />';
	$string .= '[background] => ' . $this->getBackground() . '<br />';
	$string .= '[birthday] => ' . $this->getBirthday() . '<br />';
	$string .= '[city] => ' . $this->getCity() . '<br />';
	$string .= '[collaborationcounter] => ' . $this->getCollaborationcounter() . '<br />';
	$string .= '[country] => ' . $this->getCountry() . '<br />';
	$string .= '[description] => ' . $this->getDescription() . '<br />';
	$string .= '[email] => ' . $this->getEmail() . '<br />';
	$string .= '[facebookid] => ' . $this->getFacebookid() . '<br />';
	$string .= '[facebookpage] => ' . $this->getFacebookpage() . '<br />';
	$string .= '[firstname] => ' . $this->getFirstname() . '<br />';
	$string .= '[followerscounter] => ' . $this->getFollowerscounter() . '<br />';
	$string .= '[followingcounter] => ' . $this->getFollowingcounter() . '<br />';
	$string .= '[friendshipcounter] => ' . $this->getFriendshipcounter() . '<br />';
	$string .= '[googlepluspage] => ' . $this->getGooglepluspage() . '<br />';
	$string .= '[jammercounter] => ' . $this->getJammercounter() . '<br />';
	$string .= '[jammertype] => ' . $this->getJammertype() . '<br />';
	$string .= '[lastname] => ' . $this->getLastname() . '<br />';
	$string .= '[latitude] => ' . $this->getLatitude() . '<br />';
	$string .= '[longitude] => ' . $this->getLongitude() . '<br />';
	$string .= '[level] => ' . $this->getLevel() . '<br />';
	$string .= '[levelvalue] => ' . $this->getLevelvalue() . '<br />';
	$string .= '[password] => ' . $this->getPassword() . '<br />';
	$string .= '[premium] => ' . $this->getPremium() . '<br />';
	$data = new DateTime($this->getPremiumexpirationdate());
	$string .= '[premiumexpirationdate] => ' . $data->format('d-m-Y H:i:s') . '<br />';
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
