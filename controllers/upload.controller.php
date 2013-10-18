<?php

require_once ROOT_DIR . 'config.php';
require_once CONTROLLERS_DIR . 'restController.php';

class UploadController extends REST {

    function __construct() {
        parent::__construct();
        $this->config = json_decode(file_get_contents(CONFIG_DIR . "controllers/upload.config.json"), false);
    }

    public function upload() {
        try {
            $this->setHeader();

// imposto limite di tempo di esecuzione
            if ($this->config->timeLimit > 0) {
                @set_time_limit($this->config->timeLimit);
            }

// Uncomment this one to fake upload time
// usleep(5000);
// settings
            $targetDir = $this->config->targetDir;
// creao la directory di destinazione se non esiste
            if (!file_exists($targetDir)) {
                @mkdir($targetDir);
            }

// recupero il nome del file
            if (isset($_REQUEST["name"])) {
                $fileName = $_REQUEST["name"];
            } elseif (!empty($_FILES)) {
                $fileName = $_FILES["file"]["name"];
            } else {
                $fileName = uniqid("file_");
            }

            $filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;

// Chunking might be enabled
            $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
            $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;


// rimuovo i vecchi files	
            if ($this->config->cleanUpTargetDir) {
                if(!$this->cleanUpTargetDir($targetDir, $filePath)){
                    $this->response(array("Failed to open temp directory."),100);
                }
            }

// Apro il file temporaneo
            if (!$out = @fopen("{$filePath}.part", $chunks ? "ab" : "wb")) {
                $this->response(array("Failed to open output stream."), 102);
            }

            if (!empty($_FILES)) {
                if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
                    $this->response(array("Failed to move uploaded file."), 103);
                }

                // Read binary input stream and append it to temp file
                if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
                    $this->response(array("Failed to open input stream."), 101);
                }
            } else {
                if (!$in = @fopen("php://input", "rb")) {
                    $this->response(array("Failed to open input stream."), 101);
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

// Restituisco successo
            $this->response(array($filePath), 200);
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
                $tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

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

}

?>
