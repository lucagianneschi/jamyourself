<?php

class GeocoderService {

    static private $url = "http://maps.google.com/maps/api/geocode/json?sensor=false&address=";
    static private $url_reverse = "http://maps.googleapis.com/maps/api/geocode/json?sensor=false&latlng=";

    static public function getLocation($address) {
	$url = self::$url . urlencode($address);

	$resp_json = self::curl_file_get_contents($url);
	$resp = json_decode($resp_json, true);
	if ($resp['status'] == 'OK') {
	    return $resp['results'][0]['geometry']['location'];
	} else {
	    return false;
	}
    }

    static public function getAddress($lat, $lng) {
	$location = $lat . ',' . $lng;
	$url_reverse = self::$url_reverse . urlencode($location);

	$resp_json = self::curl_file_get_contents($url_reverse);
	$resp = json_decode($resp_json, true);

	$address = array();

	if ($resp['status'] == 'OK') {

	    $address['street_number'] = $resp['results'][0]['address_components'][0]['long_name'];
	    $address['route'] = $resp['results'][0]['address_components'][1]['long_name'];
	    $address['locality'] = $resp['results'][0]['address_components'][2]['long_name'];
	    $address['province'] = $resp['results'][0]['address_components'][4]['long_name'];
	    $address['regione'] = $resp['results'][0]['address_components'][5]['long_name'];
	    $address['country'] = $resp['results'][0]['address_components'][6]['long_name'];
	    $address['postal_code'] = $resp['results'][0]['address_components'][7]['long_name'];
	}

	return $address;
    }

    static private function curl_file_get_contents($URL) {
	$c = curl_init();
	curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($c, CURLOPT_URL, $URL);
	$contents = curl_exec($c);
	curl_close($c);

	if ($contents)
	    return $contents;
	else
	    return FALSE;
    }

}

?>