<?php
/*! \par Info Generali:
 *  \author    Stefano Muscas
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par Info Classe:
 *  \brief     Settings
 *  \details   Definisce un array di settings da impostare per i vari tipi di User
 *  
 *  \par Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  
 *  
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'classes/' . getLanguage() . '.classes.lang.php';

/**
 * Inizializza la variabile in funzione dell'utente: chiamare questa per inizializzare tutto l'array settings
 */
 
function defineSettings($user_type,$language,$localTime,$imgProfile){

	$settings = array();

	if($user_type && $language && $localTime){

		$common = init_common_settings($language,$localTime,$imgProfile);

		$settings = array_merge($settings, $common);

		switch($user_type){

			case "SPOTTER" :

				$spot=init_spotter_settings($settings);

				$settings = array_merge($settings, $spot);

				break;

			case "JAMMER" :

				$jam=init_jammer_settings($settings);

				$settings = array_merge($settings, $jam);

				break;

			case "VENUE" :

				$ven=init_venue_settings($settings);

				$settings = array_merge($settings, $ven);

				break;
		}

	}

	return $settings;

}

/**
 * Inizializza con le impostazioni di default alcuni valori comuni a tutti gli utenti
 * per le corrispondenze tra numero e valore si fa riferimento al file "Properties utenti.xls"
 *
 */
function init_common_settings($language,$localTime,$imgProfile){

	$settings = array();

	$settings[0] = $language;//questi vanno recuperati via javascript
	$settings[1] = $localTime;//
	$settings[2] = $imgProfile;
	for($i=3; $i<=10; $i++){

		$settings[$i] = "PUBLIC";

	}
	$settings[11] = "YES";

	$settings[13] = "PUBLIC";


	for($i=15; $i<=26; $i++){

		$settings[$i] = true;

	}
	for($i=30; $i<=33; $i++){

		$settings[$i] = false;

	}
	return $settings;
}

/**
 * Inizializza con le impostazioni di default alcuni valori dell'account SPOTTER
 * per le corrispondenze tra numero e valore si fa riferimento al file "Properties utenti.xls"
 *
 */
function init_spotter_settings(){

	$settings = array();

	$settings[12] = "FOLLOWERS" ;

	$settings[14] = "YES";

	for($i=27; $i<=29; $i++){

		$settings[$i] = false;

	}

	$settings[34] = true ;

	$settings[35] = false ;

	$settings[36] = true ;

	$settings[37] = true ;

	$settings[38] = false ;

	return $settings;

}

/**
 * Inizializza con le impostazioni di default alcuni valori dell'account JAMMER
 * per le corrispondenze tra numero e valore si fa riferimento al file "Properties utenti.xls"
 *
 */
function init_jammer_settings(){

	$settings = array();

	$settings[12] = "FandC" ;

	$settings[14] = true;

	for($i=27; $i<=29; $i++){

		$settings[$i] = true;

	}
	$settings[34] = false ;

	$settings[35] = false ;

	$settings[36] = false ;

	$settings[37] = true  ;

	$settings[38] = false ;

	$settings[39] = true  ;

	$settings[40] = false ;

	$settings[41] = false ;

	$settings[42] = true  ;

	$settings[43] = true  ;

	$settings[44] = true  ;

	return $settings;
}


/**
 * Inizializza con le impostazioni di default alcuni valori dell'account VENUE
 * per le corrispondenze tra numero e valore si fa riferimento al file "Properties utenti.xls"
 *
 */
function init_venue_settings($settings){

	$settings = array();

	$settings[12] = "FandC" ;

	$settings[14] = true;

	$settings[27] = true  ;

	$settings[28] = false ;

	$settings[29] = false ;

	$settings[34] = false ;

	$settings[35] = true  ;

	$settings[36] = false ;

	$settings[37] = false ;

	$settings[38] = true  ;

	$settings[39] = true  ;

	$settings[40] = true  ;

	return $settings;

}

/**
 * Serve per compilare il form per verificare
 * i settaggi attuali dell'utente e
 * impostarli nel form della modifica
 *
 * @param unknown $set array dei settings dell'utente
 * @param unknown $index indice di cui si vuole controllare se � "checked"
 * @param unknown $value valore da confrontare
 */
function checked($set, $index, $value){
	if($set[$index] == $value) echo "checked";
	else echo "";
}

/**
 * Serve per compilare il form per verificare
 * i settaggi attuali dell'utente e
 * impostarli nel form della modifica
 *
 * @param unknown $set array dei settings dell'utente
 * @param unknown $index indice di cui si vuole controllare se � "selected"
 * @param unknown $value valore da confrontare
 */
function selected($set, $index, $value){
	if($set[$index] == $value) echo "selected";
	else echo "";
}

//*********************** Array descrittivi specifici ***********************************************//

//******************* JAMMER ************************************************//
$jammer_set = array();
$jammer_set[0] =  $settings_strings['JAMMER_SETTING_0'];
$jammer_set[1] =  $settings_strings['JAMMER_SETTING_1'];
$jammer_set[2] =  $settings_strings['JAMMER_SETTING_2'];
$jammer_set[3] =  $settings_strings['JAMMER_SETTING_3'];
$jammer_set[4] =  $settings_strings['JAMMER_SETTING_4'];
$jammer_set[5] =  $settings_strings['JAMMER_SETTING_5'];
$jammer_set[6] =  $settings_strings['JAMMER_SETTING_6'];
$jammer_set[7] =  $settings_strings['JAMMER_SETTING_7'];
$jammer_set[8] =  $settings_strings['JAMMER_SETTING_8'];
$jammer_set[9] =  $settings_strings['JAMMER_SETTING_9'];
$jammer_set[10] = $settings_strings['JAMMER_SETTING_10'];
$jammer_set[11] = $settings_strings['JAMMER_SETTING_11'];
$jammer_set[12] = $settings_strings['JAMMER_SETTING_12'];
$jammer_set[13] = $settings_strings['JAMMER_SETTING_13'];
$jammer_set[14] = $settings_strings['JAMMER_SETTING_14'];
$jammer_set[15] = $settings_strings['JAMMER_SETTING_15'];
$jammer_set[16] = $settings_strings['JAMMER_SETTING_16'];
$jammer_set[17] = $settings_strings['JAMMER_SETTING_17'];
$jammer_set[18] = $settings_strings['JAMMER_SETTING_18'];
$jammer_set[19] = $settings_strings['JAMMER_SETTING_19'];
$jammer_set[20] = $settings_strings['JAMMER_SETTING_20'];
$jammer_set[21] = $settings_strings['JAMMER_SETTING_21'];
$jammer_set[22] = $settings_strings['JAMMER_SETTING_22'];
$jammer_set[23] = $settings_strings['JAMMER_SETTING_23'];
$jammer_set[24] = $settings_strings['JAMMER_SETTING_24'];
$jammer_set[25] = $settings_strings['JAMMER_SETTING_25'];
$jammer_set[26] = $settings_strings['JAMMER_SETTING_26'];
$jammer_set[27] = $settings_strings['JAMMER_SETTING_27'];
$jammer_set[28] = $settings_strings['JAMMER_SETTING_28'];
$jammer_set[29] = $settings_strings['JAMMER_SETTING_29'];
$jammer_set[30] = $settings_strings['JAMMER_SETTING_30'];
$jammer_set[31] = $settings_strings['JAMMER_SETTING_31'];
$jammer_set[32] = $settings_strings['JAMMER_SETTING_32'];
$jammer_set[33] = $settings_strings['JAMMER_SETTING_33'];
$jammer_set[34] = $settings_strings['JAMMER_SETTING_34'];
$jammer_set[35] = $settings_strings['JAMMER_SETTING_35'];
$jammer_set[36] = $settings_strings['JAMMER_SETTING_36'];
$jammer_set[37] = $settings_strings['JAMMER_SETTING_37'];
$jammer_set[38] = $settings_strings['JAMMER_SETTING_38'];
$jammer_set[39] = $settings_strings['JAMMER_SETTING_39'];
$jammer_set[40] = $settings_strings['JAMMER_SETTING_40'];
$jammer_set[41] = $settings_strings['JAMMER_SETTING_41'];
$jammer_set[42] = $settings_strings['JAMMER_SETTING_42'];
$jammer_set[43] = $settings_strings['JAMMER_SETTING_43'];
$jammer_set[44] = $settings_strings['JAMMER_SETTING_44'];

//************************************* SPOTTER ********************//
$spotter_set = array();
$spotter_set[0] = $settings_strings['SPOTTER_SETTING_0'] ;
$spotter_set[1] = $settings_strings['SPOTTER_SETTING_1'] ;
$spotter_set[2] = $settings_strings['SPOTTER_SETTING_2'] ;
$spotter_set[3] = $settings_strings['SPOTTER_SETTING_3'] ;
$spotter_set[4] = $settings_strings['SPOTTER_SETTING_4'] ;
$spotter_set[5] = $settings_strings['SPOTTER_SETTING_5'] ;
$spotter_set[6] = $settings_strings['SPOTTER_SETTING_6'] ;
$spotter_set[7] = $settings_strings['SPOTTER_SETTING_7'] ;
$spotter_set[8] = $settings_strings['SPOTTER_SETTING_8'] ;
$spotter_set[9] = $settings_strings['SPOTTER_SETTING_9'] ;
$spotter_set[10] = $settings_strings['SPOTTER_SETTING_10'];
$spotter_set[11] = $settings_strings['SPOTTER_SETTING_11'];
$spotter_set[12] = $settings_strings['SPOTTER_SETTING_12'];
$spotter_set[13] = $settings_strings['SPOTTER_SETTING_13'];
$spotter_set[14] = $settings_strings['SPOTTER_SETTING_14'];
$spotter_set[15] = $settings_strings['SPOTTER_SETTING_15'];
$spotter_set[16] = $settings_strings['SPOTTER_SETTING_16'];
$spotter_set[17] = $settings_strings['SPOTTER_SETTING_17'];
$spotter_set[18] = $settings_strings['SPOTTER_SETTING_18'];
$spotter_set[19] = $settings_strings['SPOTTER_SETTING_19'];
$spotter_set[20] = $settings_strings['SPOTTER_SETTING_20'];
$spotter_set[21] = $settings_strings['SPOTTER_SETTING_21'];
$spotter_set[22] = $settings_strings['SPOTTER_SETTING_22'];
$spotter_set[23] = $settings_strings['SPOTTER_SETTING_23'];
$spotter_set[24] = $settings_strings['SPOTTER_SETTING_24'];
$spotter_set[25] = $settings_strings['SPOTTER_SETTING_25'];
$spotter_set[26] = $settings_strings['SPOTTER_SETTING_26'];
$spotter_set[27] = $settings_strings['SPOTTER_SETTING_27'];
$spotter_set[28] = $settings_strings['SPOTTER_SETTING_28'];
$spotter_set[29] = $settings_strings['SPOTTER_SETTING_29'];
$spotter_set[30] = $settings_strings['SPOTTER_SETTING_30'];
$spotter_set[31] = $settings_strings['SPOTTER_SETTING_31'];
$spotter_set[32] = $settings_strings['SPOTTER_SETTING_32'];
$spotter_set[33] = $settings_strings['SPOTTER_SETTING_33'];
$spotter_set[34] = $settings_strings['SPOTTER_SETTING_34'];
$spotter_set[35] = $settings_strings['SPOTTER_SETTING_35'];
$spotter_set[36] = $settings_strings['SPOTTER_SETTING_36'];
$spotter_set[37] = $settings_strings['SPOTTER_SETTING_37'];
$spotter_set[38] = $settings_strings['SPOTTER_SETTING_38'];

//*********************************** VENUE *********************************************//
$venue_set = array();
$venue_set[0] =   $settings_strings['VENUE_SETTING_0'];
$venue_set[1] =   $settings_strings['VENUE_SETTING_1'];
$venue_set[2] =   $settings_strings['VENUE_SETTING_2'];
$venue_set[3] =   $settings_strings['VENUE_SETTING_3'];
$venue_set[4] =   $settings_strings['VENUE_SETTING_4'];
$venue_set[5] =   $settings_strings['VENUE_SETTING_5'];
$venue_set[6] =   $settings_strings['VENUE_SETTING_6'];
$venue_set[7] =   $settings_strings['VENUE_SETTING_7'];
$venue_set[8] =   $settings_strings['VENUE_SETTING_8'];
$venue_set[9] =   $settings_strings['VENUE_SETTING_9'];
$venue_set[10] =  $settings_strings['VENUE_SETTING_10'];
$venue_set[11] =  $settings_strings['VENUE_SETTING_11'];
$venue_set[12] =  $settings_strings['VENUE_SETTING_12'];
$venue_set[13] =  $settings_strings['VENUE_SETTING_13'];
$venue_set[14] =  $settings_strings['VENUE_SETTING_14'];
$venue_set[15] =  $settings_strings['VENUE_SETTING_15'];
$venue_set[16] =  $settings_strings['VENUE_SETTING_16'];
$venue_set[17] =  $settings_strings['VENUE_SETTING_17'];
$venue_set[18] =  $settings_strings['VENUE_SETTING_18'];
$venue_set[19] =  $settings_strings['VENUE_SETTING_19'];
$venue_set[20] =  $settings_strings['VENUE_SETTING_20'];
$venue_set[21] =  $settings_strings['VENUE_SETTING_21'];
$venue_set[22] =  $settings_strings['VENUE_SETTING_22'];
$venue_set[23] =  $settings_strings['VENUE_SETTING_23'];
$venue_set[24] =  $settings_strings['VENUE_SETTING_24'];
$venue_set[25] =  $settings_strings['VENUE_SETTING_25'];
$venue_set[26] =  $settings_strings['VENUE_SETTING_26'];
$venue_set[27] =  $settings_strings['VENUE_SETTING_27'];
$venue_set[28] =  $settings_strings['VENUE_SETTING_28'];
$venue_set[29] =  $settings_strings['VENUE_SETTING_29'];
$venue_set[30] =  $settings_strings['VENUE_SETTING_30'];
$venue_set[31] =  $settings_strings['VENUE_SETTING_31'];
$venue_set[32] =  $settings_strings['VENUE_SETTING_32'];
$venue_set[33] =  $settings_strings['VENUE_SETTING_33'];
$venue_set[34] =  $settings_strings['VENUE_SETTING_34'];
$venue_set[35] =  $settings_strings['VENUE_SETTING_35'];
$venue_set[36] =  $settings_strings['VENUE_SETTING_36'];
$venue_set[37] =  $settings_strings['VENUE_SETTING_37'];
$venue_set[38] =  $settings_strings['VENUE_SETTING_38'];
$venue_set[39] =  $settings_strings['VENUE_SETTING_39'];
$venue_set[40] =  $settings_strings['VENUE_SETTING_40'];

//*********************** Fine Array descrittivi specifici ***********************************************//

//*********************** Array delle possibili scelte ***************************************************//
//******************* JAMMER ************************************************//

/**
 * Restituisce un array di possibili valori per un determinato indice
 * @param unknown $type il tipo dell'utente: JAMMER, VENUE, SETTINGS
 * @param unknown $index indice del valore di array_val
 */
function getValues($type, $index){
	$jammer_val = array();
	$jammer_val[3] = "PUBLIC";
	$jammer_val[4] = "PUBLIC";
	$jammer_val[5] = "PUBLIC";
	$jammer_val[6] = "PUBLIC";
	$jammer_val[7] = "PUBLIC";
	$jammer_val[8] = "PUBLIC";
	$jammer_val[9] = "PUBLIC";
	$jammer_val[10] = "PUBLIC";
	$jammer_val[11] = "YES;CofC;NO";
	$jammer_val[12] = "PUBLIC;FOLLOWERS;FandC;COLLABORATORS ;NONE";
	$jammer_val[13] = "PUBLIC;FOLLOWERS;FandC;COLLABORATORS;NONE";
	$jammer_val[14] = "true;false";
	$jammer_val[15] = "true;false";
	$jammer_val[16] = "true;false";
	$jammer_val[17] = "true;false";
	$jammer_val[18] = "true;false";
	$jammer_val[19] = "true;false";
	$jammer_val[20] = "true;false";
	$jammer_val[21] = "true;false";
	$jammer_val[22] = "true;false";
	$jammer_val[23] = "true;false";
	$jammer_val[24] = "true;false";
	$jammer_val[25] = "true;false";
	$jammer_val[26] = "true;false";
	$jammer_val[27] = "true;false";
	$jammer_val[28] = "true;false";
	$jammer_val[29] = "true;false";
	$jammer_val[30] = "true;false";
	$jammer_val[31] = "true;false";
	$jammer_val[32] = "true;false";
	$jammer_val[33] = "true;false";
	$jammer_val[34] = "true;false";
	$jammer_val[35] = "true;false";
	$jammer_val[36] = "true;false";
	$jammer_val[37] = "true;false";
	$jammer_val[38] = "true;false";
	$jammer_val[39] = "true;false";
	$jammer_val[40] = "true;false";
	$jammer_val[41] = "true;false";
	$jammer_val[42] = "true;false";
	$jammer_val[43] = "true;false";
	$jammer_val[44] = "true;false";


	//************************************* SPOTTER ********************//
	$spotter_val = array();
	$spotter_val[3] = "PUBLIC;FRIENDS;SELECTED" ;
	$spotter_val[4] = "PUBLIC;FRIENDS;SELECTED" ;
	$spotter_val[5] = "PUBLIC;FRIENDS;SELECTED" ;
	$spotter_val[6] = "PUBLIC;FRIENDS;SELECTED" ;
	$spotter_val[7] = "PUBLIC;FRIENDS;SELECTED" ;
	$spotter_val[8] = "PUBLIC;FRIENDS;SELECTED" ;
	$spotter_val[9] = "PUBLIC;FRIENDS;SELECTED" ;
	$spotter_val[10] = "ALL;CofC;NONE" ;
	$spotter_val[11] = "YES;CofC;NONE" ;
	$spotter_val[12] = "PUBLIC;FRIENDS;SELECTED;NONE" ;
	$spotter_val[13] = "PUBLIC;FRIENDS;SELECTED;NONE" ;
	$spotter_val[14] = "YES;PRIVATE_USERS;NO" ;
	$spotter_val[15] = "true;false" ;
	$spotter_val[16] = "true;false" ;
	$spotter_val[17] = "true;false" ;
	$spotter_val[18] = "true;false" ;
	$spotter_val[19] = "true;false" ;
	$spotter_val[20] = "true;false" ;
	$spotter_val[21] = "true;false" ;
	$spotter_val[22] = "true;false" ;
	$spotter_val[23] = "true;false" ;
	$spotter_val[24] = "true;false" ;
	$spotter_val[25] = "true;false" ;
	$spotter_val[26] = "true;false" ;
	$spotter_val[27] = "true;false" ;
	$spotter_val[28] = "true;false" ;
	$spotter_val[29] = "true;false" ;
	$spotter_val[30] = "true;false" ;
	$spotter_val[31] = "true;false" ;
	$spotter_val[32] = "true;false" ;
	$spotter_val[33] = "true;false" ;
	$spotter_val[34] = "true;false" ;
	$spotter_val[35] = "true;false" ;
	$spotter_val[36] = "true;false" ;
	$spotter_val[37] = "true;false" ;
	$spotter_val[38] = "true;false" ;

	//*********************************** VENUE *********************************************//
	$venue_val = array();
	$venue_val[3] = "PUBLIC" ;
	$venue_val[4] = "PUBLIC" ;
	$venue_val[5] = "PUBLIC" ;
	$venue_val[6] = "PUBLIC" ;
	$venue_val[7] = "PUBLIC" ;
	$venue_val[8] = "PUBLIC" ;
	$venue_val[9] = "PUBLIC" ;
	$venue_val[10] = "PUBLIC" ;
	$venue_val[11] = "YES;COLLABORATORS;NO" ;
	$venue_val[12] = "PUBLIC;FOLLORERS;FandC;COLLABORATORS;NONE" ;
	$venue_val[13] = "PUBLIC;FOLLOWERS;FandC;COLLABORATORS;NONE" ;
	$venue_val[14] = "true;false" ;
	$venue_val[15] = "true;false" ;
	$venue_val[16] = "true;false" ;
	$venue_val[17] = "true;false" ;
	$venue_val[18] = "true;false" ;
	$venue_val[19] = "true;false" ;
	$venue_val[20] = "true;false" ;
	$venue_val[21] = "true;false" ;
	$venue_val[22] = "true;false" ;
	$venue_val[23] = "true;false" ;
	$venue_val[24] = "true;false" ;
	$venue_val[25] = "true;false" ;
	$venue_val[26] = "true;false" ;
	$venue_val[27] = "true;false" ;
	$venue_val[28] = "true;false" ;
	$venue_val[29] = "true;false" ;
	$venue_val[30] = "true;false" ;
	$venue_val[31] = "true;false" ;
	$venue_val[32] = "true;false" ;
	$venue_val[33] = "true;false" ;
	$venue_val[34] = "true;false" ;
	$venue_val[35] = "true;false" ;
	$venue_val[36] = "true;false" ;
	$venue_val[37] = "true;false" ;
	$venue_val[38] = "true;false" ;
	$venue_val[39] = "true;false" ;
	$venue_val[40] = "true;false" ;

	$ret;
	switch ($type){
		case "JAMMER":
			$ret = explode(";", $jammer_val[$index]);
			break;

		case "SPOTTER":
			$ret = explode(";", $spotter_val[$index]);
			break;

		case "VENUE":
			$ret = explode(";", $venue_val[$index]);
			break;

	}
	return $ret;
}
?>
