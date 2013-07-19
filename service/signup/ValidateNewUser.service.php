<?php

//Basato sul documento : http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:user

class ValidateNewUserService {

////////////////////////////////////////////////////////////////////////////////
//
//        Funzioni per la validazione del nuovo utente (che è un json)
//        
////////////////////////////////////////////////////////////////////////////////  

    public static function checkNewUser($user) {

//verifico la presenza dei campi obbligatori per tutti gli utenti
        if (is_null($user) ||
                !isset($user->username) || is_null($user->username) ||
                !isset($user->password) || is_null($user->password) ||
                !isset($user->city) || is_null($user->city) ||
                !isset($user->country) || is_null($user->country) ||
                !isset($user->email) || is_null($user->email) ||
                !isset($user->type) || is_null($user->type)
        )
            return false;

//verifico la correttezza dei campi obbligatori per tutti gli utenti
        if (
                !$this::checkUsername($user->username) ||
                !$this::checkPassword($user->password) ||
                !$this::checkEmail($user->email)
        )
            return false;

//verifico i campi specifici per tipologia di utente

        switch ($user->type) {
            case "SPOTTER" :
                return $this::checkNewSpotter($user);
                break;
            case "VENUE" :
                return $this::checkNewVenue($user);
                break;
            case "JAMMER" :
                return $this::checkNewJammer($user);
                break;
            default :
                return false;
        }
    }

////////////////////////////////////////////////////////////////////////////////
//
//        Funzioni per la validazione specifiche per profilo
//        
////////////////////////////////////////////////////////////////////////////////  
    private static function checkNewVenue($user) {
        if (
                !isset($user->address) || is_null($user->address) ||
                !isset($user->description) || is_null($user->description) ||
                !isset($user->localType) || is_null($user->localType)
        )
            return false;
        else
            return true;
    }

    private static function checkNewSpotter($user) {
        if (
                !isset($user->music) || is_null($user->music)
        )
            return false;
        else
            return true;
    }

    private static function checkNewJammer($user) {
        if (
                !isset($user->description) || is_null($user->description) ||
                !isset($user->music) || is_null($user->music)
        )
            return false;
        else
            return true;
    }

    
////////////////////////////////////////////////////////////////////////////////
//
//        Funzioni per la validazione specifiche per property
//        
//////////////////////////////////////////////////////////////////////////////// 
    
    private static function checkEmail($email) {
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
        return true;
    }

    private static function checkUsername($username) {
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
    private static function checkPassword($password) {
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

    private static function checkAddress(){
        
    }
    
    private static function checkMusic(){
        
    }
    
    private static function checkDescription(){

    }
    
    private static function checkBirthday(){
        
    }
}
?>
