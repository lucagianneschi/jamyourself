<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

require_once '../../services/cropImage.service.php';


$source = "test.jpg";
$dest = "../../media/cache/test.jpg";        
copy($source,$dest);

$cis = new CropImageService();


$img = "../../media/cache/test.jpg";

$x = 720;
$y = 240;
$h = 99;
$w = 297;    

$res = $cis->cropImage($img, $x, $y, $w, $h);
unlink($img);


?>
<p> Immagine originale:</p>
<img src ="test.jpg" >
<br>
<br>
<p> Immagine ritagliata:</p>
<img src ="<?php echo "../../media/cache/".$res[0] ?>" >
<br>
<br>
<p> Immagine per il thumbnail:</p>
<img src ="<?php echo "../../media/cache/".$res[1] ?>" >


