<?php

//array dei settings

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
$jammer_set[0] = "lingua generale del sito";
$jammer_set[1] = "orario indicato negli oggetti del sito";
$jammer_set[2] = "immagine rappresentativa dell'utente";
$jammer_set[3] = "visualizzazione informazioni personali da parte di altri account";
$jammer_set[4] = "visualizzazione avatar da parte di altri account";
$jammer_set[5] = "visualizzazione da parte di altri utenti degli aggiornamenti di stato pubblicati e dei materiali condivisi sul proprio profilo";
$jammer_set[6] = "visualizzazione immagini caricate su proprio profilo";
$jammer_set[7] = "visualizzazione video caricati su proprio profilo";
$jammer_set[8] = "visualizzazione contenuti pubblicati da altri utenti su proprio profilo";
$jammer_set[9] = "visualizzazione contenuti pubblicati su altri profili";
$jammer_set[10] = "visualizzazione profilo all'interno delle ricerche di altri utenti";
$jammer_set[11] = "ricezione proposte di contatto";
$jammer_set[12] = "autorizzazione a commentare gli elementi presenti nel proprio profilo";
$jammer_set[13] = "autorizzazione a commentare gli elementi presenti in altri profili";
$jammer_set[14] = "ricezione messaggi privati";
$jammer_set[15] = "nuovo post pubblicato su proprio profilo";
$jammer_set[16] = "nuovi commenti a post precedentemente commentato";
$jammer_set[17] = "nuovi commenti a post pubblicato su altro profilo";
$jammer_set[18] = "nuovi tag da approvare";
$jammer_set[19] = "nuovi tag approvati";
$jammer_set[20] = "nuovi commenti ai propri materiali (immagini/video/eventi)";
$jammer_set[21] = "nuovi commenti a materiali precedentemente commentati";
$jammer_set[22] = "nuove richieste di contatto approvate";
$jammer_set[23] = "nuovi commenti a un evento precedentemente commentato";
$jammer_set[24] = "nuova recensione ricevuta a un album";
$jammer_set[25] = "nuovo rating a un album";
$jammer_set[26] = "nuovo rating a un evento";
$jammer_set[27] = "nuovo evento pubblicato di cui si &egrave; protagonista";
$jammer_set[28] = "nuovo livello di autorit&agrave; raggiunto/perso";
$jammer_set[29] = "nuovi badge conquistati";
$jammer_set[30] = "nuovo post pubblicato su proprio profilo";
$jammer_set[31] = "nuovi commenti a post precedentemente commentato";
$jammer_set[32] = "nuovi commenti a post pubblicato su altro profilo";
$jammer_set[33] = "nuovi tag da approvare";
$jammer_set[34] = "nuovi tag approvati";
$jammer_set[35] = "nuovi commenti ai propri materiali (immagini/video/eventi)";
$jammer_set[36] = "nuovi commenti a materiali precedentemente commentati";
$jammer_set[37] = "nuove richieste di contatto approvate";
$jammer_set[38] = "nuovi commenti a un evento precedentemente commentato";
$jammer_set[39] = "nuova recensione ricevuta a un album";
$jammer_set[40] = "nuovo rating a un album";
$jammer_set[41] = "nuovo rating a un evento";
$jammer_set[42] = "nuovo evento pubblicato di cui si &egrave; protagonista";
$jammer_set[43] = "nuovo livello di autorit&agrave; raggiunto/perso";
$jammer_set[44] = "nuovi badge conquistati";

//************************************* SPOTTER ********************//
$spotter_set = array();
$spotter_set[0] = "lingua generale del sito" ;
$spotter_set[1] = "orario indicato negli oggetti del sito" ;
$spotter_set[2] = "immagine rappresentativa dell'utente" ;
$spotter_set[3] = "visualizzazione informazioni personali da parte di altri account" ;
$spotter_set[4] = "visualizzazione avatar da parte di altri account" ;
$spotter_set[5] = "visualizzazione da parte di altri utenti degli aggiornamenti di stato pubblicati e dei materiali condivisi sul proprio profilo" ;
$spotter_set[6] = "visualizzazione immagini caricate su proprio profilo" ;
$spotter_set[7] = "visualizzazione video caricati su proprio profilo" ;
$spotter_set[8] = "visualizzazione contenuti pubblicati da altri utenti su proprio profilo" ;
$spotter_set[9] = "visualizzazione contenuti pubblicati su altri profili" ;
$spotter_set[10] = "visualizzazione profilo all'interno delle ricerche di altri utenti" ;
$spotter_set[11] = "ricezione proposte di contatto" ;
$spotter_set[12] = "autorizzazione a commentare gli elementi presenti nel proprio profilo" ;
$spotter_set[13] = "autorizzazione a commentare gli elementi presenti in altri profili" ;
$spotter_set[14] = "ricezione messaggi privati" ;
$spotter_set[15] = "nuovo post pubblicato su proprio profilo" ;
$spotter_set[16] = "nuovi commenti a post precedentemente commentato" ;
$spotter_set[17] = "nuovi commenti a post pubblicato su altro profilo" ;
$spotter_set[18] = "nuovi tag da approvare" ;
$spotter_set[19] = "nuovi tag approvati" ;
$spotter_set[20] = "nuovi commenti ai propri materiali (immagini/video)" ;
$spotter_set[21] = "nuovi commenti a materiali precedentemente commentati" ;
$spotter_set[22] = "nuove richieste di contatto approvate" ;
$spotter_set[23] = "nuovi commenti a un evento precedentemente commentato" ;
$spotter_set[24] = "nuovi badge conquistati" ;
$spotter_set[25] = "nuovo livello di autorit&agrave; raggiunto/perso" ;
$spotter_set[26] = "nuovo rating a una recensione pubblicata" ;
$spotter_set[27] = "nuovo post pubblicato su proprio profilo" ;
$spotter_set[28] = "nuovi commenti a post precedentemente commentato" ;
$spotter_set[29] = "nuovi commenti a post pubblicato su altro profilo" ;
$spotter_set[30] = "nuovi tag da approvare" ;
$spotter_set[31] = "nuovi tag approvati" ;
$spotter_set[32] = "nuovi commenti ai propri materiali (immagini/video)" ;
$spotter_set[33] = "nuovi commenti a materiali precedentemente commentati" ;
$spotter_set[34] = "nuove richieste di contatto approvate" ;
$spotter_set[35] = "nuovi commenti a un evento precedentemente commentato" ;
$spotter_set[36] = "nuovi badge conquistati" ;
$spotter_set[37] = "nuovo livello di autorit&agrave; raggiunto/perso" ;
$spotter_set[38] = "nuovo rating a una recensione pubblicata" ;

//*********************************** VENUE *********************************************//
$venue_set = array();
$venue_set[0] = "lingua generale del sito" ;
$venue_set[1] = "orario indicato negli oggetti del sito" ;
$venue_set[2] = "immagine rappresentativa dell'utente" ;
$venue_set[3] = "visualizzazione informazioni personali da parte di altri account" ;
$venue_set[4] = "visualizzazione avatar da parte di altri account" ;
$venue_set[5] = "visualizzazione da parte di altri utenti degli aggiornamenti di stato pubblicati e dei materiali condivisi sul proprio profilo" ;
$venue_set[6] = "visualizzazione immagini caricate su proprio profilo" ;
$venue_set[7] = "visualizzazione video caricati su proprio profilo" ;
$venue_set[8] = "visualizzazione contenuti pubblicati da altri utenti su proprio profilo" ;
$venue_set[9] = "visualizzazione contenuti pubblicati su altri profili" ;
$venue_set[10] = "visualizzazione profilo all'interno delle ricerche di altri utenti" ;
$venue_set[11] = "ricezione proposte di contatto" ;
$venue_set[12] = "autorizzazione a commentare gli elementi presenti nel proprio profilo" ;
$venue_set[13] = "autorizzazione a commentare gli elementi presenti in altri profili" ;
$venue_set[14] = "ricezione messaggi privati" ;
$venue_set[15] = "nuovo post pubblicato su proprio profilo" ;
$venue_set[16] = "nuovi commenti a post precedentemente commentato" ;
$venue_set[17] = "nuovi commenti a post pubblicato su altro profilo" ;
$venue_set[18] = "nuovi tag da approvare" ;
$venue_set[19] = "nuovi tag approvati" ;
$venue_set[20] = "nuovi commenti ai propri materiali (immagini/video/eventi)" ;
$venue_set[21] = "nuovi commenti a materiali precedentemente commentati" ;
$venue_set[22] = "nuove richieste di contatto approvate" ;
$venue_set[23] = "nuovi commenti a un evento precedentemente commentato" ;
$venue_set[24] = "nuovo rating a un evento" ;
$venue_set[25] = "nuovo evento pubblicato di cui si &egrave; ospitante" ;
$venue_set[26] = "nuovo livello di autorit&agrave; raggiunto/perso" ;
$venue_set[27] = "nuovi badge conquistati" ;
$venue_set[28] = "nuovo post pubblicato su proprio profilo" ;
$venue_set[29] = "nuovi commenti a post precedentemente commentato" ;
$venue_set[30] = "nuovi commenti a post pubblicato su altro profilo" ;
$venue_set[31] = "nuovi tag da approvare" ;
$venue_set[32] = "nuovi tag approvati" ;
$venue_set[33] = "nuovi commenti ai propri materiali (immagini/video/eventi)" ;
$venue_set[34] = "nuovi commenti a materiali precedentemente commentati" ;
$venue_set[35] = "nuove richieste di contatto approvate" ;
$venue_set[36] = "nuovi commenti a un evento precedentemente commentato" ;
$venue_set[37] = "nuovo rating a un evento" ;
$venue_set[38] = "nuovo evento pubblicato di cui si &egrave; ospitante" ;
$venue_set[39] = "nuovo livello di autorit&agrave; raggiunto/perso" ;
$venue_set[40] = "nuovi badge conquistati" ;

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
