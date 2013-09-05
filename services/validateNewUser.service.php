<?php

require_once SERVICES_DIR . 'geocoder.service.php';

//Basato sul documento : http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:user

class ValidateNewUserService {

    private $isValid;
    private $errors;            //lista delle properties che sono errate

    public function __construct($configFile) {
        $this->isValid = true;
        $this->errors = array();
        $this->config = $configFile;
    }

    public function getIsValid() {
        return $this->isValid;
    }

    public function getErrors() {
        return $this->errors;
    }

    private function setInvalid($invalidPropertyName) {
        $this->isValid = false;
        $this->errors[] = $invalidPropertyName;
    }

////////////////////////////////////////////////////////////////////////////////
//
//        Funzioni per la validazione del nuovo utente (che � un json)
//        
//////////////////////////////////////////////////////////////////////////////// 
    public function checkNewUser($userJSON) {

//verifico la presenza dei campi obbligatori per tutti gli utenti
        if (is_null($userJSON))
            return null;

        $user = json_decode(json_encode($userJSON));

        if (!isset($user->username) || is_null($user->username) || !$this->checkUsername($user->username))
            $this->setInvalid("username");
        if (!isset($user->password) || is_null($user->password) || !$this->checkPassword($user->password))
            $this->setInvalid("password");
        if (!isset($user->verifyPassword) || is_null($user->verifyPassword) || !$this->checkVerifyPassword($user->password, $user->verifyPassword))
            $this->setInvalid("verifyPassword");
        if (!isset($user->email) || is_null($user->email) || !$this->checkEmail($user->email) || !$this->checkEmail($user->email))
            $this->setInvalid("email");
        if (!isset($user->type) || is_null($user->type))
            $this->setInvalid("type");

//verifico i campi specifici per tipologia di utente
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

//verifico la correttezza dei campi social (comuni a tutti e 3 i profili)
//se sono stati definiti e non sono null controllo...
        if (isset($user->facebook) && !is_null($user->facebook) && !$this->checkURL($user->facebook))
            $this->setInvalid("facebook");
        if (isset($user->twitter) && !is_null($user->twitter) && !$this->checkURL($user->twitter))
            $this->setInvalid("twitter");
        if (isset($user->youtube) && !is_null($user->youtube) && !$this->checkURL($user->youtube))
            $this->setInvalid("youtube");
        if (isset($user->google) && !is_null($user->google) && !$this->checkURL($user->google))
            $this->setInvalid("google");
        if (isset($user->web) && !is_null($user->web) && !$this->checkURL($user->web))
            $this->setInvalid("web");

        //restituisco il risultato dell'analisi
        return $this->isValid;
    }

////////////////////////////////////////////////////////////////////////////////
//
//        Funzioni per la validazione specifiche per profilo
//        
////////////////////////////////////////////////////////////////////////////////  
    private function checkNewVenue($user) {

        if (!isset($user->country) || is_null($user->country))
            $this->setInvalid("country");
        if (!isset($user->city) || is_null($user->city))
            $this->setInvalid("city");
        if (!isset($user->province) || is_null($user->province))
            $this->setInvalid("province");
        if (!isset($user->address) || is_null($user->address))
            $this->setInvalid("address");
        if (!isset($user->number) || is_null($user->number))
            $this->setInvalid("number");
        if (!isset($user->description) || is_null($user->description) || $this->checkDescription($user->description))
            $this->setInvalid("description");
        if (!isset($user->genre) || is_null($user->genre) || $this->checkLocalType($user->genre))
            $this->setInvalid("genre");

        if ($this->isValid) {
            $venueLocation = $user->address . " , " . $user->number . " , ";
            $venueLocation .= $user->city + " , " . $user->province . " , ";
            $venueLocation .= $user->country;
            if (!$this->checkLocation($venueLocation))
                $this->setInvalid("location");
        }
    }

    private function checkNewSpotter($user) {

        //@stefano : continua da qui
        if (!isset($user->lastname) || !$this->checkFirstName($user->lastname))
            $this->setInvalid("lastname");
        if (!isset($user->firstname) || !$this->checkFirstName($user->firstname))
            $this->setInvalid("firstname");
        if (!isset($user->birthday) || !$this->checkBirthday($user->sex)) {
            $this->setInvalid("birthday");
        } else {
            
        }
        if (!isset($user->city))
            $this->setInvalid("city");
        if (!isset($user->country))
            $this->setInvalid("country");
        if (!isset($user->description) || !$this->checkDescription($user->sex))
            $this->setInvalid("description");
        if (!isset($user->genre) || !$this->checkMusic($user->sex))
            $this->setInvalid("genre");
        if (!isset($user->sex) || !$this->checkSex($user->sex))
            $this->setInvalid("sex");
    }

    private function checkNewJammer($user) {

        if (!isset($user->city))
            $this->setInvalid("city");
        if (!isset($user->country))
            $this->setInvalid("country");
        if (!isset($user->description) || !$this->checkDescription($user->description))
            $this->setInvalid("description");
        if (!isset($user->genre) || !$this->checkMusic($user->genre))
            $this->setInvalid("genre");
        if (!isset($user->jammerType) || !$this->checkJammerType($user->jammerType))
            $this->setInvalid("jammerType");
        if (!isset($user->members) || !$this->checkMembers($user->members))
            $this->setInvalid("members");
    }

////////////////////////////////////////////////////////////////////////////////
//
//        Funzioni per la validazione specifiche per property
//        
//////////////////////////////////////////////////////////////////////////////// 



    public function checkUsername($username) {
//        if(preg_match('/^\w{5,}$/', $username)) { // \w equals "[0-9A-Za-z_]"
//        // valid username, alphanumeric & longer than or equals 5 chars
//        }
//        if(preg_match('/^[a-zA-Z0-9]{5,}$/', $username)) { // for english chars + numbers only
//            // valid username, alphanumeric & longer than or equals 5 chars
//        }

        if (preg_match('/^\w{5,}$/', $username) || preg_match('/^[a-zA-Z0-9]{5,}$/', $username)) {
            return true;
        }
        else
            return false;
    }

    /**
     * http://www.cafewebmaster.com/check-password-strength-safety-php-and-regex
     * @param type $password
     * @return boolean
     */
    public function checkPassword($password) {
//    Numbers, letters, CAPS:
//    Remember most users dont like passwords with 
//    symbols(because of keyboard differences), 
//    you can exclude symbol-check. 
//    Just check length, letters, caps and numbers.

        if (preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $password)) {
            return true;
        } else {
            return false;
        }
    }

    public function checkVerifyPassword($verifyPassword, $password) {
        if ($verifyPassword != $password)
            return false;
        else
            return true;
    }

    public function checkBirthday($birthdayJSON) {
        $birthday = json_decode(json_encode($birthdayJSON));
        if (
                is_null($birthday) ||
                !isset($birthday->day) || is_null($birthday->day) ||
                !isset($birthday->month) || is_null($birthday->month) ||
                !isset($birthday->year) || is_null($birthday->year)
        )
            return false;
        else
            return checkdate($birthday->month, $birthday->day, $birthday->year);
    }

    public function checkDescription($description) {
        define("MAX_DESCRIPTION_LENGTH", 1000);
        if (
                is_null($description) ||
                count($description) <= 0 ||
                count($description) > MAX_DESCRIPTION_LENGTH
        )
            return false;
    }

    public function checkEmail($email) {

// First, we check that there's one @ symbol, 
// and that the lengths are right.
        if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
// Email invalid because wrong number of characters 
// in one section or wrong number of @ symbols.
            return false;
        }
// Split it into sections to make life easier
        $email_array = explode("@", $email);
        $local_array = explode(".", $email_array[0]);
        for ($i = 0; $i < sizeof($local_array); $i++) {
            if
            (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&
?'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])) {
                return false;
            }
        }
// Check if domain is IP. If not, 
// it should be valid domain name
        if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) {
            $domain_array = explode(".", $email_array[1]);
            if (sizeof($domain_array) < 2) {
                return false; // Not enough parts to domain
            }
            for ($i = 0; $i < sizeof($domain_array); $i++) {
                if
                (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|
?([A-Za-z0-9]+))$", $domain_array[$i])) {
                    return false;
                }
            }
        }
        return true && filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public function checkFirstName($firstname) {
        if (preg_match("/^(?:[A-Za-z]+(?:\s+|$)){2,3}$/", $firstname)) {
            return true;
        }
        else
            return false;
    }

    public function checkJammerType($jammerType) {
        $jammerTypeList = array('Musician', 'Band');
        if (!is_null($jammerType) || !in_array($jammerType, $jammerTypeList))
            return false;
        else
            return true;
    }

    public function checkLastname($lastname) {
        if (preg_match("/^(?:[A-Za-z]+(?:\s+|$)){2,3}$/", $lastname)) {
            return true;
        }
        else
            return false;
    }

    public function checkLocalType($localType) {
        define("MAX_LOCALTYPE_SIZE", 5);
        $localTypeList = array("happy_hour-appetizer",
            "dinner",
            "live_music",
            "contest_Area",
            "pub",
            "happy_hour-appetizer",
            "dinner",
            "pub",
            "live_music");

        if (is_null($localType) || !is_array($localType) || count($localType) <= 0 || count($localType) > MAX_LOCALTYPE_SIZE)
            return false;

        foreach ($localType as $val) {
            if (!in_array($val, $localTypeList))
                return false;
        }

        return true;
    }

    public function checkLocation($location) {
//direi di usare il reverse geocoding qua...
        if (!geocoder::getLocation($location))
            return false;
        else
            return true;
    }

    public function checkMembers($members) {
        if (is_null($members) || !is_array($members) || count($members) <= 0)
            return false;
        else
            return true;
    }

    private function checkMusic($music) {
        define("MAX_MUSIC_SIZE", 10);

        $musicList = array(
            "rock",
            "indie-rock",
            "metal",
            "songwriter",
            "punk",
            "rap_hip-hop",
            "ska",
            "pop",
            "instrumental",
            "electronic",
            "dance",
            "jazz-blues",
            "esperimental",
            "folk",
            "ambient",
            "acoustic",
            "hard-core",
            "house",
            "techno",
            "punk",
            "grounge",
            "progessive",
            "dark"
        );

        if (is_null($music) || !is_array($music) || count($music) <= 0 || count($musicList) > MAX_MUSIC_SIZE)
            return false;

        foreach ($music as $val) {
            if (!in_array($val, $musicList))
                return false;
        }

        return true;
    }

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

    private function checkURL($url) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_exec($ch);
        $retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if (200 == $retcode) {
            return true;
        } else {
            return false;
        }
    }

}

?>
