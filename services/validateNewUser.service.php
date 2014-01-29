<?php

/* ! \par		Info Generali:
 * \author		Stafano Muscas
 * \version		1.0
 * \date		2013
 * \copyright		Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		servizio di validazione del nuovo utente in fase di registrazione
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'geocoder.service.php';
require_once CLASSES_DIR . 'userParse.class.php';
require_once CLASSES_DIR . 'user.class.php';

//Basato sul documento : http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:user

class ValidateNewUserService {

    private $isValid;
    private $errors;     //lista delle properties che sono errate
    private $config;     //puntatore al JSON di configurazione della registsrazione
    private $user;

    public function __construct($configFile) {
        if ($configFile == null)
            return null;
        $this->isValid = true;
        $this->errors = array();
        $this->config = $configFile;
    }

    /**
     * \fn	getIsValid()
     * \brief	get della property valid
     * \return
     * \todo
     */
    public function getIsValid() {
        return $this->isValid;
    }

    /**
     * \fn	getErrors()
     * \brief	get della property errors
     * \return
     * \todo
     */
    public function getErrors() {
        return $this->errors;
    }

    /**
     * \fn	setInvalid($invalidPropertyName)
     * \brief	set della property valid e errors in caso di utente non valido
     * \return
     * \todo
     */
    private function setInvalid($invalidPropertyName) {
        $this->isValid = false;
        $this->errors[] = $invalidPropertyName;
    }

    /**
     * \fn	checkBirthday($birthdayJSON)
     * \brief	check correttezza birthday
     * \return
     * \todo
     */
    public function checkBirthday($birthdayJSON) {
        $birthday = json_decode(json_encode($birthdayJSON), false);
        if (!isset($birthday->day) || is_null($birthday->day) || !isset($birthday->month) || is_null($birthday->month) || !isset($birthday->year) || is_null($birthday->year))
            return false;
        if (strlen($birthday->day) && strlen($birthday->month) && strlen($birthday->year))
            return checkdate($birthday->month, $birthday->day, $birthday->year);
        else
            return true;
    }

    /**
     * \fn	checkDescription($description)
     * \brief	check correttezza description
     * \return
     * \todo
     */
    public function checkDescription($description) {
        if (strlen($description) < 0 || strlen($description) > $this->config->maxDescriptionLength)
            return false;
        return true;
    }

    /**
     * \fn	checkEmail($email)
     * \brief	check correttezza email
     * \return
     * \todo
     */
    public function checkEmail($email) {
        if (strlen($email) > 50)
            return false;
        if (stripos($email, " ") !== false)
            return false;
        if (!(stripos($email, "@") !== false))
            return false;
        if (!(filter_var($email, FILTER_VALIDATE_EMAIL)))
            return false;
        $up = new UserParse();
        $up->whereEqualTo("email", $email);
        $res = $up->getCount();
        if ($res instanceof Error) {
            return false;
        }
        if ($res != 0)
            return false;
        return true;
    }

    /**
     * \fn	checkLocation($location)
     * \brief	check correttezza location
     * \return
     * \todo
     */
    public function checkLocation($location) {
        $gs = new GeocoderService();
        if (!$gs->getLocation($location))
            return false;
        else
            return true;
    }

    /**
     * \fn	checkMembers($members)
     * \brief	check correttezza members
     * \return
     * \todo
     */
    public function checkMembers($members) {
        if (!is_array($members))
            return false;
        else {
            if (count($members) > 0) {
                foreach ($members as $component) {
                    if (is_null($component) || !$this->checkBandComponent($component))
                        return false;
                }
            }
        }
        return true;
    }

    /**
     * \fn	checkNewSpotter($user)
     * \brief	check utente SPOTTER
     * \return
     * \todo
     */
    private function checkNewSpotter($user) {
        if (!isset($user->lastname) || is_null($user->lastname) || !$this->checkLastname($user->lastname))
            $this->setInvalid("lastname");
        if (!isset($user->firstname) || is_null($user->firstname) || !$this->checkFirstname($user->firstname))
            $this->setInvalid("firstname");
        if (!isset($user->birthday) && is_null($user->birthday) && !$this->checkBirthday($user->birthday)) {
            $this->setInvalid("birthday");
        }
        if (!isset($user->city) || is_null($user->city))
            $this->setInvalid("city");
        else {
            $infoLocation = GeocoderService::getCompleteLocationInfo($user->city);
            if (!isset($infoLocation["latitude"]) || is_null($infoLocation["latitude"]))
                $this->setInvalid("latitude");
            if (!isset($infoLocation["longitude"]) || is_null($infoLocation["longitude"]))
                $this->setInvalid("longitude");
            if (!isset($infoLocation["city"]) || is_null($infoLocation["city"]))
                $this->setInvalid("city");
            if (!isset($infoLocation["country"]) || is_null($infoLocation["country"]))
                $this->setInvalid("country");
        }
        if (!isset($user->genre) || is_null($user->genre) || !$this->checkMusic($user->genre, "SPOTTER"))
            $this->setInvalid("genre");
        if (!isset($user->sex) || is_null($user->sex) || !$this->checkSex($user->sex))
            $this->setInvalid("sex");
    }

    /**
     * \fn	checkNewUser($userJSON)
     * \brief	check utente property comuni
     * \return
     * \todo
     */
    public function checkNewUser($userJSON) {
        if (is_null($userJSON))
            return null;
        $user = json_decode(json_encode($userJSON), false);
        if (!isset($user->language) || is_null($user->language) || strlen($user->language) <= 0)
            $this->setInvalid("language");
        if (!isset($user->localTime) || is_null($user->localTime) || strlen($user->localTime) <= 0)
            $this->setInvalid("language");
        if (!isset($user->type) || is_null($user->type))
            $this->setInvalid("type");
        if (!isset($user->username) || is_null($user->username) || !$this->checkUsername($user->username))
            $this->setInvalid("username");
        if (!isset($user->password) || is_null($user->password) || !$this->checkPassword($user->password))
            $this->setInvalid("password");
        if (!isset($user->verifyPassword) || is_null($user->verifyPassword) || !$this->checkVerifyPassword($user->password, $user->verifyPassword))
            $this->setInvalid("verifyPassword");
        if (!isset($user->email) || is_null($user->email) || !$this->checkEmail($user->email))
            $this->setInvalid("email");
        if (!isset($user->description) || is_null($user->description) || !$this->checkDescription($user->description))
            $this->setInvalid("description");
        switch ($user->type) {
            case "SPOTTER":
                $this->checkNewSpotter($user);
                break;
            case "VENUE":
                $this->checkNewVenue($user);
                break;
            case "JAMMER":
                $this->checkNewJammer($user);
                break;
        }
        if (!isset($user->facebook) || is_null($user->facebook) || !$this->checkUrl($user->facebook))
            $this->setInvalid("facebook");
        if (!isset($user->twitter) || is_null($user->twitter) || !$this->checkUrl($user->twitter))
            $this->setInvalid("twitter");
        if (!isset($user->youtube) || is_null($user->youtube) || !$this->checkUrl($user->youtube))
            $this->setInvalid("youtube");
        if (!isset($user->google) || is_null($user->google) || !$this->checkUrl($user->google))
            $this->setInvalid("google");
        if (!isset($user->web) || is_null($user->web) || !$this->checkUrl($user->web))
            $this->setInvalid("web");
        return $this->isValid;
    }

    /**
     * \fn	checkNewVenue($user)
     * \brief	check utente VENUE
     * \return
     * \todo
     */
    private function checkNewVenue($user) {

        if (!isset($user->city) || is_null($user->city))
            $this->setInvalid("city");
        else {
            $infoLocation = GeocoderService::getCompleteLocationInfo($user->city);
            if (!isset($infoLocation["latitude"]) || is_null($infoLocation["latitude"]))
                $this->setInvalid("latitude");
            if (!isset($infoLocation["longitude"]) || is_null($infoLocation["longitude"]))
                $this->setInvalid("longitude");
            if (!isset($infoLocation["number"]) || is_null($infoLocation["number"]))
                $this->setInvalid("number");
            if (!isset($infoLocation["address"]) || is_null($infoLocation["address"]))
                $this->setInvalid("address");
            if (!isset($infoLocation["city"]) || is_null($infoLocation["city"]))
                $this->setInvalid("city");
            if (!isset($infoLocation["province"]) || is_null($infoLocation["province"]))
                $this->setInvalid("province");
            if (!isset($infoLocation["region"]) || is_null($infoLocation["region"]))
                $this->setInvalid("region");
            if (!isset($infoLocation["country"]) || is_null($infoLocation["country"]))
                $this->setInvalid("country");
            if (!isset($infoLocation["formattedAddress"]) || is_null($infoLocation["formattedAddress"]))
                $this->setInvalid("formattedAddress");
        }
        if (!isset($user->genre) || is_null($user->genre) || !$this->checkLocalType($user->genre))
            $this->setInvalid("genre");
    }

    /**
     * \fn	checkNewJammer($user)
     * \brief	check utente JAMMER
     * \return
     * \todo
     */
    private function checkNewJammer($user) {
        if (!isset($user->city) || is_null($user->city))
            $this->setInvalid("city");
        else {

            $infoLocation = GeocoderService::getCompleteLocationInfo($user->city);
            if (!isset($infoLocation["latitude"]) || is_null($infoLocation["latitude"]))
                $this->setInvalid("latitude");
            if (!isset($infoLocation["longitude"]) || is_null($infoLocation["longitude"]))
                $this->setInvalid("longitude");
            if (!isset($infoLocation["city"]) || is_null($infoLocation["city"]))
                $this->setInvalid("city");
            if (!isset($infoLocation["country"]) || is_null($infoLocation["country"]))
                $this->setInvalid("country");
        }
        if (!isset($user->genre) || is_null($user->genre) || !$this->checkMusic($user->genre, "JAMMER"))
            $this->setInvalid("genre");
        if (!isset($user->jammerType) || is_null($user->jammerType) || !$this->checkJammerType($user->jammerType))
            $this->setInvalid("jammerType");
        if ($user->jammerType == "band") {
            if (!isset($user->members) || is_null($user->members) || !$this->checkMembers($user->members))
                $this->setInvalid("members");
        }
    }

    /**
     * \fn	checkPassword($password)
     * \brief	check correttezza password
     * \return
     * \todo
     */
    public function checkPassword($password) {
        $strlen = strlen($password);
        if ($strlen < 8 || $strlen > 50)
            return false;
        if (strpos($password, ' ') !== false)
            return false;
        $this->checkSpecialChars($password);
        $boolCheckDiffChar = false;
        for ($i = 0; $i < $strlen; $i++) {
            for ($j = $i + 1; $j < $strlen; $j++) {
                if ($password[$i] != $password[$j]) {
                    $boolCheckDiffChar = true;
                    break;
                }
            }
            if ($boolCheckDiffChar)
                break;
        }
        if (!$boolCheckDiffChar)
            return false;
        return true;
    }

    /**
     * \fn	checkUsername($username)
     * \brief	check correttezza username
     * \return
     * \todo
     */
    public function checkUsername($username) {
        if (strlen($username) > 50) {
            return false;
        }
        $up = new UserParse();
        $up->whereEqualTo("username", $username);
        $res = $up->getCount();
        if (!($res instanceof Error)) {
            if ($res != 0)
                return false;
        }
        else
            return false;
        return true;
    }

    /**
     * \fn	checkVerifyPassword($verifyPassword, $password)
     * \brief	check correttezza password e retyper della password
     * \return
     * \todo
     */
    public function checkVerifyPassword($verifyPassword, $password) {
        return $verifyPassword == $password;
    }

    /**
     * \fn	checkJammerType($jammerType)
     * \brief	check correttezza jammerType
     * \return
     * \todo
     */
    public function checkJammerType($jammerType) {
        $jammerTypeList = $this->config->jammerType;
        if (!in_array($jammerType, $jammerTypeList))
            return false;
        else
            return true;
    }

    /**
     * \fn	checkBandComponent($componentJSON)
     * \brief	check correttezza array members
     * \return
     * \todo
     */
    private function checkBandComponent($componentJSON) {
        $component = json_decode(json_encode($componentJSON), false);
        if (!isset($component->name) || is_null($component->name) || !isset($component->instrument) || is_null($component->instrument))
            return false;
        if (strlen($component->name) > 50)
            return false;
        if ($this->checkSpecialChars($component->name))
            return false;
        if (strlen($component->instrument) <= 0)
            return false;
        return true;
    }

    /**
     * \fn	checkFirstname($firstname)
     * \brief	check correttezza firstname
     * \return
     * \todo
     */
    private function checkFirstname($firstname) {
        if (strlen($firstname) > 50)
            return false;
        if ($this->checkSpecialChars($firstname))
            return false;
        return true;
    }

    /**
     * \fn	checkLastname($lastname)
     * \brief	check correttezza lastname
     * \return
     * \todo
     */
    private function checkLastname($lastname) {
        if (strlen($lastname) > 50)
            return false;
        if ($this->checkSpecialChars($lastname))
            return false;
        return true;
    }

    /**
     * \fn	checkLocalType($localType)
     * \brief	check correttezza localType
     * \return
     * \todo
     */
    private function checkLocalType($localType) {
        if (!is_array($localType) || count($localType) <= 0 || count($localType) > $this->config->maxLocalTypeSize)
            return false;
        return true;
    }

    /**
     * \fn	checkMusic($music, $type)
     * \brief	check correttezza music
     * \return
     * \todo
     */
    private function checkMusic($music, $type) {
        $dim = 0;
        switch ($type) {
            case "JAMMER":
                $dim = $this->config->maxMusicSizeJammer;
                break;
            case "SPOTTER":
                $dim = $this->config->maxMusicSizeSpotter;
                break;
        }
        if (is_null($music) || !is_array($music) || count($music) <= 0 || count($music) > $dim)
            return false;

        return true;
    }

    /**
     * \fn	checkSex($sex)
     * \brief	check correttezza sex
     * \return
     * \todo
     */
    private function checkSex($sex) {
        switch ($sex) {
            case "M" : return true;
                break;
            case "F" : return true;
                break;
            case "ND" : return true;
                break;
            default : return false;
        }
    }

    /**
     * \fn	checkSpecialChars($string)
     * \brief	check esistenza caratteri speciali
     * \return
     * \todo
     */
    private function checkSpecialChars($string) {
        $charList = "!#$%&'()*+,-./:;<=>?[]^_`{|}~àèìòùáéíóúüñ¿¡";
        $strlen = strlen($charList);
        for ($i = 0; $i < $strlen; $i++) {
            $char = $charList[$i];
            if (stripos($string, $char) !== false)
                return true;
        }
        return false;
    }

    /**
     * \fn	checkSex($sex)
     * \brief	check correttezza url
     * \return
     * \todo
     */
    private function checkUrl($url) {
        if (strlen($url) > 0) {
            if (filter_var($url, FILTER_VALIDATE_URL)) {
                return true;
            }
            else
                return false;
        }
        else {
            return true;
        }
    }

}

?>
