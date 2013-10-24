<?php

require_once ROOT_DIR . 'config.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once SERVICES_DIR . 'cropImage.service.php';

class UploadController extends REST {

    function __construct() {
        parent::__construct();
        $this->config = json_decode(file_get_contents(CONFIG_DIR . "controllers/upload.config.json"), false);
    }

    public function uploadImage() {
        try {
            $this->setHeader();

// imposto limite di tempo di esecuzione
            if ($this->config->timeLimit > 0) {
                @set_time_limit($this->config->timeLimit);
            }

// settings
            $targetDir = $this->config->targetDir;

//commentare per produzione
            $targetDir = MEDIA_DIR . "cache";
// creao la directory di destinazione se non esiste
            if (!file_exists($targetDir)) {
                @mkdir($targetDir);
            }

// recupero l'estensione del file
            if (isset($_REQUEST["name"])) {
                $fileName = $_REQUEST["name"];
            } elseif (!empty($_FILES)) {
                $fileName = $_FILES["file"]["name"];
            } else {
                $fileName = uniqid("file_");
            }

            $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

//nome file univoco            
            $fileName = md5(time() . rand()) . "." . $ext;

            $filePath = $targetDir . "/" . $fileName;

// Chunking might be enabled
            $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
            $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;


// rimuovo i vecchi files	
            if ($this->config->cleanUpTargetDir) {
                if (!$this->cleanUpTargetDir($targetDir, $filePath)) {
                    die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
                }
            }

// Apro il file temporaneo
            if (!$out = @fopen("{$filePath}.part", $chunks ? "ab" : "wb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
            }

            if (!empty($_FILES)) {
                if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
                    die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
                }

                // Read binary input stream and append it to temp file
                if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
                    die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
                }
            } else {
                if (!$in = @fopen("php://input", "rb")) {
                    die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
                }
            }

            while ($buff = fread($in, 4096)) {
                fwrite($out, $buff);
            }

            @fclose($out);
            @fclose($in);

// Verifico che il file sia stato caricato
            if (!$chunks || $chunk == $chunks - 1) {
                // Strip the temp .part suffix off 
                rename("{$filePath}.part", $filePath);
            }
//effettuo il resize dell'immagine
//prelevo gli attributi dell'immagine
            list($imgWidth, $imgHeight, $imgType, $imgAttr) = getimagesize($filePath);
//calcolo le proporzioni da mostrare a video
            $prop = $this->calculateNewProperties($imgWidth, $imgHeight);
// Restituisco successo         
            die('{"jsonrpc" : "2.0", "src" : "' . $fileName . '", "width" : "' . $prop['width'] . '","height" : "' . $prop['height'] . '" }');
        } catch (Exception $e) {
            
        }
    }

    private function setHeader() {
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
    }

    private function cleanUpTargetDir($targetDir, $filePath) {
        try {
            $maxFileAge = $this->config->maxFileAge; // Temp file age in seconds
            if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
                return false;
            }

            while (($file = readdir($dir)) !== false) {
                $tmpfilePath = $targetDir . "/" . $file;

                // If temp file is current file proceed to the next
                if ($tmpfilePath == "{$filePath}.part") {
                    continue;
                }

                // Remove temp file if it is older than the max age and is not the current file
                if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge)) {
                    @unlink($tmpfilePath);
                }
            }
            closedir($dir);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    private function calculateNewProperties($width, $height) {
        try {
            //modifico solo se almeno una delle dimensioni e' da ridurre
            if ($width > 700 || $height > 300) {

                if ($width >= $height) {
                    $newWidth = 700;
                    $newHeight = (700 * $height) / $width;
                    return array("width" => $newWidth, "height" => round($newHeight));
                } else {
                    $newHeight = 300;
                    $newWidth = (300 * $width) / $height;
                    return array("width" => round($newWidth), "height" => $newHeight);
                }
            } else {
                return array("width" => $width, "height" => $height);
            }
        } catch (Exception $e) {
            return false;
        }
    }

}

?>
