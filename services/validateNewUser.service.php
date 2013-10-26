<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');
require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'geocoder.service.php';
require_once CLASSES_DIR . 'userParse.class.php';
require_once CLASSES_DIR . 'user.class.php';

//Basato sul documento : http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:user

class ValidateNewUserService {

    private $isValid;
    private $errors;            //lista delle properties che sono errate
    private $config;            //puntatore al JSON di configurazione della registsrazione
    private $user;

    public function __construct($configFile) {
        if ($configFile == null)
            return null;
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

        $user = json_decode(json_encode($userJSON), false);


        if (!isset($user->language) || is_null($user->language) || !$this->checkUsername($user->language) || strlen($user->language) <= 0)
            $this->setInvalid("language");
        if (!isset($user->localTime) || is_null($user->localTime) || !$this->checkUsername($user->localTime) || strlen($user->localTime) <= 0)
            $this->setInvalid("language");
        if (!isset($user->type) || is_null($user->type))
            $this->setInvalid("type");
        if (!isset($user->username) || is_null($user->username) || !$this->checkUsername($user->username))
            $this->setInvalid("username");
        if (!isset($user->password) || is_null($user->password) || !$this->checkPassword($user->password))
            $this->setInvalid("password");
        if (!isset($user->verifyPassword) || is_null($user->verifyPassword) || !$this->checkVerifyPassword($user->password, $user->verifyPassword))
            $this->setInvalid("verifyPassword");
        if (!isset($user->email) || is_null($user->email) || !$this->checkEmail($user->email) || !$this->checkEmail($user->email))
            $this->setInvalid("email");

//verifico i campi specifici per tipologia di utente
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

//verifico la correttezza dei campi social (comuni a tutti e 3 i profili)
//se sono stati definiti e non sono null controllo...
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
        if (!isset($user->genre) || is_null($user->genre) || !$this->checkLocalType($user->genre))
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

        if (!isset($user->lastname) || is_null($user->lastname) || !$this->checkLastname($user->lastname))
            $this->setInvalid("lastname");
        if (!isset($user->firstname) || is_null($user->firstname) || !$this->checkFirstname($user->firstname))
            $this->setInvalid("firstname");
        if (!isset($user->birthday) && is_null($user->birthday) && !$this->checkBirthday($user->birthday)) {
            $this->setInvalid("birthday");
        } else {
            
        }
        if (!isset($user->city) || is_null($user->city))
            $this->setInvalid("city");
        if (!isset($user->country) || is_null($user->country))
            $this->setInvalid("country");
        if (!isset($user->genre) || is_null($user->genre) || !$this->checkMusic($user->genre, "SPOTTER"))
            $this->setInvalid("genre");
        if (!isset($user->sex) || is_null($user->sex) || !$this->checkSex($user->sex))
            $this->setInvalid("sex");
    }

    private function checkNewJammer($user) {

        if (!isset($user->city) || is_null($user->city))
            $this->setInvalid("city");
        if (!isset($user->country) || is_null($user->country))
            $this->setInvalid("country");
        if (!isset($user->genre) || is_null($user->genre) || !$this->checkMusic($user->genre, "JAMMER"))
            $this->setInvalid("genre");
        if (!isset($user->jammerType) || is_null($user->jammerType) || !$this->checkJammerType($user->jammerType))
            $this->setInvalid("jammerType");
        if (!isset($user->members) || is_null($user->members) || !$this->checkMembers($user->members))
            $this->setInvalid("members");
    }

////////////////////////////////////////////////////////////////////////////////
//
//        Funzioni per la validazione specifiche per property
//        
//////////////////////////////////////////////////////////////////////////////// 

    public function checkUsername($username) {

        //Max numero caratteri pari a 50
        if (count($username) > 50)
            return false;

        //Controllare che Username non sia già presente nel DB
        $up = new UserParse();
        $up->whereEqualTo("username", $username);
        $res = $up->getCount();

        if (!is_a($res, "Error")) {
            if ($res != 0)
                return false;
        }
        else
            return false;

        //nessun errore
        return true;
    }

    public function checkPassword($password) {


        //A) Max numero caratteri pari a 50
        //F) Controllo che dimensione minima password 8 caratteri 
        if (strlen($password) < 8 || strlen($password) > 50)
            return false;

        // B) Controllo che nel campo non siano presenti spazi sia all’interno della password che alla fine
        if (strpos($password, ' ') !== false)
            return false;

        //C) Controllare che nel campo non siano presenti caratteri speciali non stampabili (vedi lista allegata a mail)
        //D) Controllare che nel campo non siano presenti lettere accentate 
        $this->checkSpecialChars($password);
        //E) Controllo che password non sia composta da un solo ed unico carattere
        $boolCheckDiffChar = false;
        for ($i = 0; $i < strlen($password); $i++) {
            for ($j = $i + 1; $j < strlen($password); $j++) {
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

    public function checkVerifyPassword($verifyPassword, $password) {
        return $verifyPassword == $password;
    }

    public function checkBirthday($birthdayJSON) {
        $birthday = json_decode(json_encode($birthdayJSON), false);
        if (!isset($birthday->day) || is_null($birthday->day) || !isset($birthday->month) || is_null($birthday->month) || !isset($birthday->year) || is_null($birthday->year))
            return false;
        if (strlen($birthday->day) && strlen($birthday->month) && strlen($birthday->year))
            return checkdate($birthday->month, $birthday->day, $birthday->year);
        else
            return true;
    }

    public function checkDescription($description) {
//Campo ‘Description’ (campo DB: description - string) A) Max Caratteri pari a 800 B) Controllo che non
//sia presente spazio alla fine dell’ultima parola; Gli spazi interni sono consentiti Es. ‘Modena City
//Ramblers’ C) Gestione lettere accentate da impostare E) Case Sensitive attivo per distinzione
//maiuscole/minuscole e non creaare problemi su DB F) Unico carattere speciale per il momento non
//consentito “ (vedere mail Mari)
        if (strlen($description) < 0 || strlen($description) > $this->config->maxDescriptionLength)
            return false;

        return true;
    }

    public function checkEmail($email) {
//Campo ‘mail’ (campo DB: email – string) 
//A) Max numero caratteri pari a 50 
        if (strlen($email) > 50)
            return false;
//B) Controllo che nel campo non siano presenti spazi sia all’interno della mail che alla fine 
        if (stripos($email, " ") !== false)
            return false;
//C) Controllo che nel campo sia presente ‘@’ D) Controllo che nel campo sia presente il . (punto) 
        if (!(stripos($email, "@") !== false))
            return false;
//D) Controllare che non siano presenti nel campo caratteri speciali non stampabili (vedi lista allegata a mail) 
//E) Controllare che non siano presenti nel campo lettere accentate 

//        if ($this->checkSpecialChars($email))
//            return false;

//F) Controllare che indirizzo mail inserito sia un indirizzo mail valido 
        if (!(filter_var($email, FILTER_VALIDATE_EMAIL)))
            return false;
//G)Controllare che indirizzo mail non sia già presente nel DB 
        $up = new UserParse();
        $up->whereEqualTo("email", $email);
        $res = $up->getCount();

        if (is_a($res, "Error")) {
            //result è un errore e contiene il motivo dell'errore
            return false;
        }
        if ($res != 0)
            return false;
//H) Validazione indirizzo mail anche se presenti caratteri Underscore _ o -
        return true;
    }

    public function checkJammerType($jammerType) {
        $jammerTypeList = $this->config->jammerType;
        if (!in_array($jammerType, $jammerTypeList))
            return false;
        else
            return true;
    }

    public function checkLocation($location) {
//direi di usare il reverse geocoding qua...
        $gs = new GeocoderService();
        $result = $gs->getLocation($location);
        if (!$gs->getLocation($location))
            return false;
        else
            return true;
    }

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

    private function checkMusic($music,$type) {
//Campo ‘Genre’ (campo DB: music - array ) A) Controllo che almeno 1 Genere sia indicato dall’utente B)
//Max numero selezioni da utente pari a 5. Controllare che selezioni dell’utente siano pari o inferiori a 5
        $dim = 0;
        switch($type){
            case "JAMMER":
                $dim = $this->config->maxMusicSizeJammer;
                break;
            case "SPOTTER":
                $dim = $this->config->maxMusicSizeSpotter;
                break;
        }

        if (is_null($music) || !is_array($music) || count($music) <= 0 || count($music) > $dim)
            return false;
        //controllo se sono numeri perché i valori nel form sono mappati come numeri (indici del corrispondente array)
        foreach ($music as $val) {
            if (!is_numeric($val))
                return false;
        }

        return true;
    }

    private function checkLocalType($localType) {
        if (!is_array($localType) || count($localType) <= 0 || count($localType) > $this->config->maxLocalTypeSize)
            return false;
        //controllo se sono numeri perché i valori nel form sono mappati come numeri (indici del corrispondente array)
        foreach ($localType as $val) {
            if (!is_numeric($val))
                return false;
        }

        return true;
    }

    private function checkBandComponent($componentJSON) {
//Campo ‘Components’ (campo DB: members - array) si compone di due campi: ‘name’ a compilazione
//libera da parte dell’utente  B) Controllo che non sia presente spazio
//alla fine dell’ultima parola; Gli spazi interni sono consentiti Es. ‘Dino Baggio’ C) Controllare che non
//siano presenti caratteri speciali non stampabili (vedi lista allegata a mail) D) Gestione lettere accentate
//E) Case Sensitive attivo per distinzione maiuscole/minuscole e non creare problemi su DB. Per Campo
//“Instrument” utilizziamo lista strumenti fornita da Pinni (allegato file .txt)
        $component = json_decode(json_encode($componentJSON), false);
        if (!isset($component->name) || is_null($component->name) || !isset($component->instrument) || is_null($component->instrument))
            return false;

        if (strlen($component->name) > 50)
            return false;
        if ($this->checkSpecialChars($component->name))
            return false;

        if (strlen($component->instrument) <= 0)
            return false;

        $instrumentList = $this->config->instruments;
        if (!in_array($component->instrument, $instrumentList))
            return false;

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

    private function checkUrl($url) {
//Campo ‘I’m also on’ (campo DB: fbPage – string ; twitterPage – string ; youtubeChannel – string ;
//website - string ) A) Controllo che campo sia una URL
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

    private function checkFirstname($firstname) {
//Campo “Last Name” (campo DB: lastname - string) 
//A) Max numero caratteri pari a 50 B) 
        if (strlen($firstname) > 50)
            return false;

//Controllo che non sia presente spazio alla fine dell’ultima parola; Gli spazi interni sono consentiti Es. “Gian Maria” 
//C)Controllare che non siano presenti caratteri speciali non stampabili (vedi lista allegata a mail)
        if ($this->checkSpecialChars($firstname))
            return false;

//D)Gestione lettere accentate 
//E) Case Sensitive attivo per distinzione maiuscole/minuscole e non creare problemi su DB 

        return true;
    }

    private function checkLastname($lastname) {
//Campo “Last Name” (campo DB: lastname - string) 
//A) Max numero caratteri pari a 50 B) 
        if (strlen($lastname) > 50)
            return false;

//Controllo che non sia presente spazio alla fine dell’ultima parola; Gli spazi interni sono consentiti Es. “Gian Maria” 
//C)Controllare che non siano presenti caratteri speciali non stampabili (vedi lista allegata a mail)
        if ($this->checkSpecialChars($lastname))
            return false;

//D)Gestione lettere accentate 
//E) Case Sensitive attivo per distinzione maiuscole/minuscole e non creare problemi su DB 

        return true;
    }

    private function checkSpecialChars($string) {
        $charList = "!#$%&'()*+,-./:;<=>?[]^_`{|}~àèìòùáéíóúüñ¿¡";
        for ($i = 0; $i < strlen($charList); $i++) {
            $char = $charList[$i];
            if (stripos($string, $char) !== false)
                return true;
        }
        return false;
    }

}

?>
