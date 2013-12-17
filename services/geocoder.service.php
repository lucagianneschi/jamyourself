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

    static function getCompleteLocationInfo($json) {
        $info = array();
        $info["latitude"] = 0;
        $info["longitude"] = 0;
        $info["number"] = null;
        $info["address"] = null;
        $info["city"] = null;
        $info["province"] = null;
        $info["region"] = null;
        $info["country"] = null;
        $info["formattedAddress"] = null;

        if (isset($json) && !is_null($json)) {
            if (isset($json->address_components) && !is_null($json->address_components) && count($json->address_components) > 0) {
                foreach ($json->address_components as $address_component) {
                    if (isset($address_component->types) && !is_null($address_component->types) && count($address_component->types) > 0 && in_array("street_number", (array) $address_component->types)) {
                        $info["number"] = $address_component->long_name;
                    } elseif (isset($address_component->types) && !is_null($address_component->types) && count($address_component->types) > 0 && in_array("route", (array) $address_component->types)) {
                        $info["address"] = $address_component->long_name;
                    } elseif (isset($address_component->types) && !is_null($address_component->types) && count($address_component->types) > 0 && in_array("locality", (array) $address_component->types)) {
                        $info["city"] = $address_component->long_name;
                    } elseif (isset($address_component->types) && !is_null($address_component->types) && count($address_component->types) > 0 && in_array("administrative_area_level_1", (array) $address_component->types)) {
                        $info["region"] = $address_component->long_name;
                    } elseif (isset($address_component->types) && !is_null($address_component->types) && count($address_component->types) > 0 && in_array("administrative_area_level_2", (array) $address_component->types)) {
                        $info["province"] = $address_component->long_name;
                    } elseif (isset($address_component->types) && !is_null($address_component->types) && count($address_component->types) > 0 && in_array("country", (array) $address_component->types)) {
                        $info["country"] = $address_component->long_name;
                    }
                }
            }

            if (isset($json->formatted_address) && !is_null($json->formatted_address) && strlen($json->formatted_address) > 0) {
                $info["formattedAddress"] = $json->formatted_address;
            }

            if (isset($json->latitude) && !is_null($json->latitude) && isset($json->longitude) && !is_null($json->longitude)) {
                $info["latitude"] = intval($json->latitude);
                $info["longitude"] = intval($json->longitude);
            }
        }
    }

}

?>