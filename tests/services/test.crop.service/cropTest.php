<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../');

require_once '../../../services/cropImage.service.php';


$source = "test.jpg";
$dest = "../../../media/cache/test.jpg";        
copy($source,$dest);

$cis = new CropImageService();


$img = "../../../media/cache/test.jpg";

$x = 170;
$y = 675;
$h = 244;
$w = 244;    

$cover = $cis->cropImage($img, $x, $y, $w, $h,300);

$pathCover = MEDIA_DIR."cache/".$cover;

$thum = $cis->cropImage($pathCover, 0, 0, 300, 300,150);

unlink($img);


?>
<p> Immagine originale:</p>
<img src ="test.jpg" >
<br>
<br>
<p> Immagine ritagliata:</p>
<img src ="<?php echo "../../media/cache/".$cover ?>" >
<br>
<br>
<p> Immagine per il thumbnail:</p>
<img src ="<?php echo "../../media/cache/".$thum ?>" >


