<?php

require_once SERVICES_DIR . 'geocoder.service.php';

//Basato sul documento : http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:user

class ValidateNewUserService {

    private $isValid;
    private $errors;            //lista delle properties che sono errate
    private $config;            //puntatore al JSON di configurazione della registsrazione

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
        if (isset($user->facebook) || is_null($user->facebook) || $this->checkUrl($user->facebook))
            $this->setInvalid("facebook");
        if (isset($user->twitter) || is_null($user->twitter) || $this->checkUrl($user->twitter))
            $this->setInvalid("twitter");
        if (isset($user->youtube) || is_null($user->youtube) || $this->checkUrl($user->youtube))
            $this->setInvalid("youtube");
        if (isset($user->google) || is_null($user->google) || $this->checkUrl($user->google))
            $this->setInvalid("google");
        if (isset($user->web) || is_null($user->web) || $this->checkUrl($user->web))
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
        if (!isset($user->lastname) || is_null($user->lastname) || !$this->checkLastname($user->lastname))
            $this->setInvalid("lastname");
        if (!isset($user->firstname) || is_null($user->firstname) || !$this->checkFirstname($user->firstname))
            $this->setInvalid("firstname");
        if (!isset($user->birthday) || is_null($user->birthday) || !$this->checkBirthday($user->sex)) {
            $this->setInvalid("birthday");
        } else {
            
        }
        if (!isset($user->city) || is_null($user->city))
            $this->setInvalid("city");
        if (!isset($user->country) || is_null($user->country))
            $this->setInvalid("country");
        if (!isset($user->genre) || is_null($user->genre) || !$this->checkMusic($user->genre))
            $this->setInvalid("genre");
        if (!isset($user->sex) || is_null($user->sex) || !$this->checkSex($user->sex))
            $this->setInvalid("sex");
    }

    private function checkNewJammer($user) {

        if (!isset($user->city) || is_null($user->city))
            $this->setInvalid("city");
        if (!isset($user->country) || is_null($user->country))
            $this->setInvalid("country");
        if (!isset($user->genre) || is_null($user->genre) || !$this->checkMusic($user->genre))
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
//Campo ‘Artist/Group Name’. (campo DB: username - string) A) Max numero caratteri pari a 50 B)
//Controllo che non sia presente spazio alla fine dell’ultima parola; Gli spazi interni sono consentiti Es.
//‘Modena City Ramblers’ C) Controllare che non siano presenti caratteri speciali non stampabili (vedi
//lista allegata a mail) D) Gestione lettere accentate E) Case Sensitive attivo per distinzione
//maiuscole/minuscole e non creare problemi su DB F) Controllare che Username non sia già presente nel
//DB
        return true;
    }

    /**
     * http://www.cafewebmaster.com/check-password-strength-safety-php-and-regex
     * @param type $password
     * @return boolean
     */
    public function checkPassword($password) {
//Campo ‘Password’ (campo DB: password - string ) A) Max numero caratteri pari a 50 B) Controllo che
//nel campo non siano presenti spazi sia all’interno della password che alla fine C) Controllare che nel
//campo non siano presenti caratteri speciali non stampabili (vedi lista allegata a mail) D) Controllare che
//nel campo non siano presenti lettere accentate E) Controllo che password non sia composta da un solo
//ed unico carattere F) Controllo che dimensione minima password 8 caratteri G) Case Sensitive attivo
//per la password (distinzione maiuscole minuscole)
        if(count($password) > 50) return false;
        
        return true;
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
                !isset($birthday->day) || is_null($birthday->day) ||
                !isset($birthday->month) || is_null($birthday->month) ||
                !isset($birthday->year) || is_null($birthday->year)
        )
            return false;
        else
            return checkdate($birthday->month, $birthday->day, $birthday->year);
    }

    public function checkDescription($description) {
//Campo ‘Description’ (campo DB: description - string) A) Max Caratteri pari a 800 B) Controllo che non
//sia presente spazio alla fine dell’ultima parola; Gli spazi interni sono consentiti Es. ‘Modena City
//Ramblers’ C) Gestione lettere accentate da impostare E) Case Sensitive attivo per distinzione
//maiuscole/minuscole e non creaare problemi su DB F) Unico carattere speciale per il momento non
//consentito “ (vedere mail Mari)
        if (
                count($description) <= 0 ||
                count($description) > $this->config->maxDescriptionLength
        )
            return false;
    }

    public function checkEmail($email) {
//Campo ‘mail’ (campo DB: email – string) A) Max numero caratteri pari a 50 B) Controllo che nel campo
//non siano presenti spazi sia all’interno della mail che alla fine C) Controllo che nel campo sia presente
//‘@’ D) Controllo che nel campo sia presente il . (punto) D) Controllare che non siano presenti nel
//campo caratteri speciali non stampabili (vedi lista allegata a mail) E) Controllare che non siano presenti
//nel campo lettere accentate F) Controllare che indirizzo mail inserito sia un indirizzo mail valido G)
//Controllare che indirizzo mail non sia già presente nel DB H) Validazione indirizzo mail anche se presenti
//caratteri Underscore _ o -
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
        if (!geocoder::getLocation($location))
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

    private function checkMusic($music) {
//Campo ‘Genre’ (campo DB: music - array ) A) Controllo che almeno 1 Genere sia indicato dall’utente B)
//Max numero selezioni da utente pari a 5. Controllare che selezioni dell’utente siano pari o inferiori a 5
        if (is_null($music) || !is_array($music) || count($music) <= 0 || count($music) > $this->config->maxMusicSize)
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
        $component = json_decode(json_encode($componentJSON));
//Campo ‘Components’ (campo DB: members - array) si compone di due campi: ‘name’ a compilazione
//libera da parte dell’utente A) Max numero caratteri pari a 50 B) Controllo che non sia presente spazio
//alla fine dell’ultima parola; Gli spazi interni sono consentiti Es. ‘Dino Baggio’ C) Controllare che non
//siano presenti caratteri speciali non stampabili (vedi lista allegata a mail) D) Gestione lettere accentate
//E) Case Sensitive attivo per distinzione maiuscole/minuscole e non creare problemi su DB. Per Campo
//“Instrument” utilizziamo lista strumenti fornita da Pinni (allegato file .txt)
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

        return true;
    }

    private function checkFirstname($firstname) {
//Campo “First Name” (campo DB: firstname - string) A) Max numero caratteri pari a 50 B) Controllo che
//non sia presente spazio alla fine dell’ultima parola; Gli spazi interni sono consentiti Es. “Gian Maria” C)
//Controllare che non siano presenti caratteri speciali non stampabili (vedi lista allegata a mail) D)
//Gestione lettere accentate E) Case Sensitive attivo per distinzione maiuscole/minuscole e non creare
//problemi su DB

        return true;
    }

    private function checkLastname($lastname) {
//Campo “Last Name” (campo DB: lastname - string) A) Max numero caratteri pari a 50 B) Controllo che
//non sia presente spazio alla fine dell’ultima parola; Gli spazi interni sono consentiti Es. “Gian Maria” C)
//Controllare che non siano presenti caratteri speciali non stampabili (vedi lista allegata a mail) D)
//Gestione lettere accentate E) Case Sensitive attivo per distinzione maiuscole/minuscole e non creare
//problemi su DB 

        return true;
    }

}

?>
