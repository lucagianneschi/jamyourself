<?php
/*
 * File che esegue la chimata diretta a PARSE e che simula pertanto il comportamento della classe parse.php
 */

//faccio la query su Comment -> FIEm6BFFxl e devo ottenere Comment -> M8Abw83aVG, nJr1ulgfVo

//inizializzo il curl
$c = curl_init();

//setto i parametri di base del curl
curl_setopt($c, CURLOPT_TIMEOUT, 30);
curl_setopt($c, CURLOPT_USERAGENT, 'parse.com-php-library/2.0');
curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
curl_setopt($c, CURLINFO_HEADER_OUT, true);
curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false); //<-------------------------- DISATTIVA CERTIFICATO SSL

//eseguo il curl NON sullo USER
curl_setopt($c, CURLOPT_HTTPHEADER, array(
	'Content-Type: application/json',
	'X-Parse-Application-Id: ' . 'QucRailaZOOtazewquHVdfMK1dZEJAFqzQpBHBmB', //$this->_appid,
	'X-Parse-REST-API-Key: ' . 'fMDDSr7UOUXsU9JMMzszJ1fFJCG00PNGZurwjJ9V', //$this->_restkey,
	'X-Parse-Master-Key: ' . 'ZmsqajMfNC6lEk6KcRPoaRH6go63Q8MESQ3s9zPT' //$this->_masterkey
));
/*
if (substr($args['requestUrl'], 0, 5) == 'files') {
	curl_setopt($c, CURLOPT_HTTPHEADER, array(
		'Content-Type: ' . $args['contentType'],
		'X-Parse-Application-Id: ' . $this->_appid,
		'X-Parse-Master-Key: ' . $this->_masterkey
	));
	$isFile = true;
} else if (substr($args['requestUrl'], 0, 5) == 'users' && isset($args['sessionToken'])) {
	curl_setopt($c, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',
		'X-Parse-Application-Id: ' . $this->_appid,
		'X-Parse-REST-API-Key: ' . $this->_restkey,
		'X-Parse-Session-Token: ' . $args['sessionToken']
	));
} else {
	curl_setopt($c, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',
		'X-Parse-Application-Id: ' . $this->_appid,
		'X-Parse-REST-API-Key: ' . $this->_restkey,
		'X-Parse-Master-Key: ' . $this->_masterkey
	));
}
*/

// ??
curl_setopt($c, CURLOPT_CUSTOMREQUEST, 'GET'); //$args['method']);

//preparo la url su cui fare la query
//$url = 'https://api.parse.com/1/' . 'classes/Comment/FIEm6BFFxl'; //'classes/Comment/FIEm6BFFxl'; //$url = $this->_parseurl . $args['requestUrl'];
$url = 'https://api.parse.com/1/classes/Activity/k85PHqTBZf';

//dato che eseguo la GET allora eseguo sempre questo codice (che non mi dovrebbe servire perchè è una chiamata GET)
/*
$postData = json_encode($args['data']);
curl_setopt($c, CURLOPT_POSTFIELDS, $postData);
*/
/*
if ($args['method'] == 'PUT' || $args['method'] == 'POST') {
	if ($isFile) {
		$postData = $args['data'];
	} else {
		$postData = json_encode($args['data']);
	}

	curl_setopt($c, CURLOPT_POSTFIELDS, $postData);
}
*/

//per adesso non credo che mi serva
/*
if ($args['requestUrl'] == 'login') {
	$urlParams = http_build_query($args['data'], '', '&');
	$url = $url . '?' . $urlParams;
}
if (array_key_exists('urlParams', $args)) {
	$urlParams = http_build_query($args['urlParams'], '', '&');
	$url = $url . '?' . $urlParams;
}
*/

//devo creare la url con i parametri

//$param['limit'] = '2';
//$param['skip'] = '1';

//$param['where'] = array('objectId' => 'GSi62CaysF');

//$param['where'] = json_encode(array('objectId' => array('$in' => array('GSi62CaysF', 'FIEm6BFFxl'))));

$param['include'] = 'fromUser';

//questo qui ci vuole sempre!
$args['urlParams'] = $param;
$urlParams = http_build_query($args['urlParams'], '', '&');
$url = $url . '?' . $urlParams;

curl_setopt($c, CURLOPT_URL, $url);

echo '<br />DEBUG<br />';
echo 'url=' . $url . '<br />';
echo 'args=';
print_r($args);
echo '<br />DEBUG<br />';

$response = curl_exec($c);
$responseCode = curl_getinfo($c, CURLINFO_HTTP_CODE);

//stampo il risultato
print_r($response);
print_r($args);
/*
$expectedCode = '200';
if ($args['method'] == 'POST' && substr($args['requestUrl'], 0, 4) != 'push') {
	// checking if it is not cloud code - it returns code 200
	if (substr($args['requestUrl'], 0, 9) != 'functions')
		$expectedCode = '201';
}

if ($expectedCode != $responseCode) {
	//BELOW HELPS WITH DEBUGGING
	//print_r($response);
	//print_r($args);		
}

return $this->checkResponse($response, $responseCode, $expectedCode);
*/
?>