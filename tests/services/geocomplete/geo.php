
<?php
 
 if (isset($_POST['location'])) {
 
     $json = json_decode(json_encode($_POST['location'], JSON_FORCE_OBJECT));
 
     $geo = new GeoCoder($json);
     echo json_encode((array) $geo);
 }
 
 class GeoCoder {
 
     public $latitude;
     public $longitude;
     public $number;
     public $address;
     public $city;
     public $province;
     public $region;
     public $country;
     public $formattedAddress;
 
 
 }
 
 ?>

