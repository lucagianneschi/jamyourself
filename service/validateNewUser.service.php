<?php

require_once SERVICES_DIR.'geocoder.service.php';

//Basato sul documento : http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:user

class ValidateNewUserService {

////////////////////////////////////////////////////////////////////////////////
//
//        Funzioni per la validazione del nuovo utente (che � un json)
//        
////////////////////////////////////////////////////////////////////////////////  

    public function checkNewUser($user) {

//verifico la presenza dei campi obbligatori per tutti gli utenti
        if (
                is_null($user) ||
                !isset($user->username) || is_null($user->username) ||
                !isset($user->password) || is_null($user->password) ||
                !isset($user->verifyPassword) || is_null($user->verifyPassword) ||
                !isset($user->email) || is_null($user->email) ||
                !isset($user->type) || is_null($user->type)
        )
            return false;

//verifico la correttezza dei campi obbligatori per tutti gli utenti
        if (
                !$this->checkUsername($user->username) ||
                !$this->checkPassword($user->password) ||
                !$this->checkVerifyPassword($user->password) ||
                !$this->checkPassword($user->verifyPassword, $user->password) ||
                !$this->checkEmail($user->email)
        )
            return false;

//verifico i campi specifici per tipologia di utente

        switch ($user->type) {
            case "SPOTTER" :
                if ($this->checkNewSpotter($user))
                    return false;
                break;
            case "VENUE" :
                if ($this->checkNewVenue($user))
                    return false;
                break;
            case "JAMMER" :
                if (!$this->checkNewJammer($user))
                    return false;
                break;
            default :
                return false;
        }



        //verifico la correttezza dei campi social (comuni a tutti e 3 i profili)
        //se sono stati definiti e non sono null controllo...
        if(isset($user->fbPage) &&!is_null($user->fbPage) &&!$this->checkURL($user->fbPage)) return false;
        if(isset($user->twitterPage) &&!is_null($user->twitterPage) &&!$this->checkURL($user->twitterPage)) return false;
        if(isset($user->youtubeChannel) &&!is_null($user->youtubeChannel) &&!$this->checkURL($user->youtubeChannel)) return false;
        if(isset($user->google) &&!is_null($user->google) &&!$this->checkURL($user->google)) return false;
        if(isset($user->webSite) &&!is_null($user->webSite) &&!$this->checkURL($user->webSite)) return false;

        //tutto ok
        return true;
    }

////////////////////////////////////////////////////////////////////////////////
//
//        Funzioni per la validazione specifiche per profilo
//        
////////////////////////////////////////////////////////////////////////////////  
    private function checkNewVenue($user) {
        if (
                !isset($user->country) || is_null($user->country) ||
                !isset($user->city) || is_null($user->city) ||
                !isset($user->provence) || is_null($user->provence) ||
                !isset($user->address) || is_null($user->address) ||
                !isset($user->number) || is_null($user->number) ||
                !isset($user->description) || is_null($user->description) || $this->checkDescription($user->description) ||
                !isset($user->localType) || is_null($user->localType) || $this->checkLocalType($user->localType)
        )
            return false;
        else {
            $venueLocation = $user->address . " , " . $user->number . " , ";
            $venueLocation .= $user->city + "( " . $user->provence . " ) , ";
            $venueLocation .= $user->country;

            if (!$this->checkLocation($venueLocation))
                return false;
            else
                return true;
        }
    }

    private function checkNewSpotter($user) {
        if (
                !isset($user->music) || is_null($user->music) || !$this->checkMusic($user->music) ||
                !isset($user->description) || is_null($user->description) || !$this->checkDescription($user->description)
        )
            return false;
        else {
            //verifica specifica dei campi
            if (isset($user->firstname) && !is_null($user->firstname) && !$this->checkFirstName($user->firstname))
                return false;
            if (isset($user->lastname) && !is_null($user->lastname) && !$this->checkLastname($user->lastname))
                return false;
            if (isset($user->location) && !is_null($user->location) && !$this->checkLocation($user->location))
                return false;
            if (isset($user->sex) && !is_null($user->sex) && !$this->checkSex($user->sex))
                return false;
            if (isset($user->birthday) && !is_null($user->birthday) && !$this->checkBirthday($user->birthday))
                return false;
        }
        return true;
    }

    private function checkNewJammer($user) {
        if (
                !isset($user->jammerType) || is_null($user->jammerType) || !$this->checkJammerType($user->jammerType) ||
                !isset($user->description) || is_null($user->description) || !$this->checkDescription($user->description) ||
                !isset($user->music) || is_null($user->music) || !$this->checkMusic($user->music) ||
                !isset($user->location) || is_null($user->location) || !$this->checkLocation($user->location)
        )
            return false;
        else {
            //controllo dei parametri non obbligatori

            if (isset($user->members) && !is_null($user->members) && !$this->checkMembers($user->members))
                return false;
            else
                return true;
        }
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

    public function checkBirthday($birthday) {
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

    public function checkMusic($music) {
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

    public function checkSex($sex) {
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

    public function checkURL($url) {
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
