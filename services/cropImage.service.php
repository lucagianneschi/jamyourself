<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');
require_once ROOT_DIR . 'config.php';

class CropImageService {

    public function cropImage($img, $x, $y, $w, $h, $album_name) {
        try {
            list($width, $height, $type, $attr) = getimagesize($img); //prelevo il tipo di estensione del file

            $new_file_name = $_SESSION['user_id'] . "_" . $album_name . ".jpg";

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
                    throw new Exception('Il file deve essere in formato gif, jpeg/jpg, png ' . $type);
            }

            // CROP della cover
            $cover = $this->createThumbnail($image, 300, $x, $y, $w, $h);
            // creao thumbnail dalla cover
            $thumbnail = $this->createThumbnail($cover, 100, 0, 0, 300, 300);

            //SALVO LE IMMAGINI NELLE RISPETTIVE CARTELLE:

            $cover_url = "";

            $thumb_url = "";

            if (imagejpeg($cover, "cover/" . $new_file_name, 100)) {

                $cover_url = "cover/" . $new_file_name;
            }

            if (imagejpeg($thumbnail, "thumbnail_cover/" . $new_file_name, 100)) {

                $thumb_url = "thumbnail_cover/" . $new_file_name;
            }

            //elimino i file vecchi

            imagedestroy($cover);

            imagedestroy($thumbnail);


            return array($cover_url, $thumb_url);       //ritorno l'url in cui ho salvsato l'immagine
        } catch (Exception $e) {
            return null;
        }
    }

    public function createThumbnail($image, $dpi, $x, $y, $w, $h) {
        //dimensioni origine immagine
        $width_origine = ImageSX($image);
        $height_origine = ImageSY($image);
        //dimensioni della preview
        $x_preview = ($width_origine * $dpi) / $height_origine;
        $y_preview = $dpi;
        //se l'immagine originale ha una altezza > di 300 allora viene fatto il crop in porporzione all'originale
        //altrimenti viene fatto in porporzione alla preview, questo per permettere di effettuare uno crop mantenendo la risoluzione
        //originaria 
        if ($height_origine > 300) {
            //coordinate del CROP in porporzione all'immagine originale
            $x_co = $x * ($width_origine / $x_preview);
            $y_co = $y * ($height_origine / $y_preview);
            $w_co = $w * ($width_origine / $x_preview);
            $h_co = $h * ($height_origine / $y_preview);

            $dst_r = ImageCreateTrueColor($dpi, $dpi);
            imagecopyresampled($dst_r, $image, 0, 0, $x_co, $y_co, $dpi, $dpi, $w_co, $h_co);
        } else {
            //l'immagine viene ridimensionata, in quanto l'operazione di crop avviene sulla preview
            //(la preview ha lunghezza pari a 300 pixel -- vedi in formAlbumImmagini.php)   
            $img_r = $this->resizeImage($image, 300);
            $dst_r = ImageCreateTrueColor($dpi, $dpi);
            imagecopyresampled($dst_r, $img_r, 0, 0, $x, $y, $dpi, $dpi, $w, $h);
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