<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');
require_once ROOT_DIR . 'config.php';

class CropImageService {

    public function cropImage($img, $x, $y, $w, $h, $dim) {
        try {
			//prelevo il tipo di estensione del file
            list($width, $height, $type, $attr) = getimagesize($img);

			//recupero l'estensione del file
            $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));

			//nome file univoco            
            $profileImgName = md5(time() . rand()) . ".jpg";

			//Controllo tipo di file: se è un file immagine (GIF, JPG o PNG), Altrimenti genera eccezione.
            switch ($type) {
                case IMAGETYPE_GIF:
                    $image = imagecreatefromgif($img);
                    break;
                case IMAGETYPE_JPEG:
                    $image = imagecreatefromjpeg($img);
                    break;
                case IMAGETYPE_PNG:
                    $image = imagecreatefrompng($img);
                    break;
                default:
                    return null;
            }

            // CROP della cover
            $cover = $this->createThumbnail($image, $dim, $x, $y, $w, $h);
          
            //SALVO L' IMMAGINE NELLA RISPETTIVE CARTELLA:
            $cover_url = "";

            if (imagejpeg($cover, MEDIA_DIR."cache/".$profileImgName, 100)) {
                $cover_url = $profileImgName;
            }  

            //elimino i file vecchi
            imagedestroy($image);
            imagedestroy($cover);
			
            //ritorno l'url in cui ho salvsato l'immagine
            return $cover_url;
        } catch (Exception $e) {
            return null;
        }
    }

    public function createThumbnail($image, $dim, $x, $y, $w, $h) {
        //dimensioni origine immagine
        $width_origine = ImageSX($image);
        $height_origine = ImageSY($image);
       
        //se l'immagine originale ha una altezza > di 300 allora viene fatto il crop in porporzione all'originale
        //altrimenti viene fatto in porporzione alla preview, questo per permettere di effettuare uno crop mantenendo la risoluzione
        //originaria 
        if ($height_origine > $dim) {
            $dst_r = ImageCreateTrueColor($dim, $dim);
            imagecopyresampled($dst_r, $image, 0, 0, $x, $y, $dim, $dim, $w, $h);
        } else {
            //l'immagine viene ridimensionata, in quanto l'operazione di crop avviene sulla preview
            //(la preview ha lunghezza pari a 300 pixel -- vedi in formAlbumImmagini.php)   
            $img_r = $this->resizeImage($image, 300);
            $dst_r = ImageCreateTrueColor($dim, $dim);
            imagecopyresampled($dst_r, $img_r, 0, 0, $x, $y, $dim, $dim, $w, $h);
        }

        return $dst_r;
    }

    /*
     * Ridimensiona l'immagine $image in proporzione alla lunghezza pari a $dpi
     */

    public function resizeImage($image, $dpi) {
        #Get image width / height
        $x = ImageSX($image);
        $y = ImageSY($image);

        $x_prop = ($x * $dpi) / $y;

//    #Format a number with grouped thousands
        $x_prop = number_format($x_prop, 0, ',', ' ');
        //creo immagine di supporto
        $prop = ImageCreateTrueColor($x_prop, $dpi);
        imagecopyresampled($prop, $image, 0, 0, 0, 0, $x_prop, $dpi, $x, $y);

        return $prop;
    }

}

?>