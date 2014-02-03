<?php

require_once ROOT_DIR . 'config.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once SERVICES_DIR . 'cropImage.service.php';
require_once SERVICES_DIR . 'debug.service.php';
require_once SERVICES_DIR . 'mp3.service.php';

class UploadController extends REST {

    function __construct() {
	parent::__construct();
	$this->config = json_decode(file_get_contents(CONFIG_DIR . "controllers/upload.config.json"), false);
    }

    public function uploadImage() {
	try {
	    $this->debug("uploadImage", "START");
	    $this->setHeader();

// imposto limite di tempo di esecuzione
	    if ($this->config->timeLimit > 0) {
		$this->debug("uploadImage", "time_limit is : " . $this->config->timeLimit);
		@set_time_limit($this->config->timeLimit);
	    }

	    $targetDir = CACHE_DIR;
	    $this->debug("uploadImage", "targetDir is : " . $targetDir);

// creao la directory di destinazione se non esiste
	    if (!file_exists($targetDir)) {
		$this->debug("uploadImage", "targetDir does not exists.. creating.");
		@mkdir($targetDir);
	    }
            
            if(!file_exists(USERS_DIR)){
               @mkdir(USERS_DIR); 
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
	    $this->debug("uploadImage", "filePath is: " . $filePath);

// Chunking might be enabled
	    $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
	    $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;

	    $this->debug("uploadImage", "chunk  is: " . $chunk . " of " . $chunks . " chunks");

// Apro il file temporaneo
	    if (!$out = @fopen("{$filePath}.part", $chunks ? "ab" : "wb")) {
		$this->debug("uploadImage", "ERROR: Failed to open output stream - END");
		die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
	    }

	    if (!empty($_FILES)) {
		if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
		    $this->debug("uploadImage", "ERROR: Failed to move uploaded file - END");
		    die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
		}

		// Read binary input stream and append it to temp file
		if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
		    $this->debug("uploadImage", "ERROR: Failed to open input stream - END");
		    die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
		}
	    } else {
		if (!$in = @fopen("php://input", "rb")) {
		    $this->debug("uploadImage", "ERROR: Failed to open input stream - END");
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
		$this->debug("uploadImage", "Renaming {$filePath}.part in : " . $filePath);
		rename("{$filePath}.part", $filePath);

		$this->debug("uploadImage", "file size is : " . filesize($filePath) . " - MAX_IMG_UPLOAD_FILE_SIZE : " . MAX_IMG_UPLOAD_FILE_SIZE);

		if (filesize($filePath) > MAX_IMG_UPLOAD_FILE_SIZE) {
		    $this->debug("uploadImage", "ERROR: File is too big - END");
		    unlink($filePath);
		    die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "File is too big."}, "id" : "id"}');
		}


		$ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
		$fileName = (md5(time() . rand())) . "." . $ext;
		$randomName = CACHE_DIR . DIRECTORY_SEPARATOR . $fileName;
		$resRename = rename($filePath, $randomName);
		if (!$resRename) {
		    $this->debug("uploadImage", "ERROR: Error renaming file - END");
		    die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Error renaming file."}, "id" : "id"}');
		}

//effettuo il resize dell'immagine
//prelevo gli attributi dell'immagine
		list($imgWidth, $imgHeight, $imgType, $imgAttr) = getimagesize($randomName);
//calcolo le proporzioni da mostrare a video
		$prop = $this->calculateNewProperties($imgWidth, $imgHeight);
// Restituisco successo    
		$this->debug("uploadImage", "Returning : src : " . $fileName . ", width : " . $prop['width'] . ",height : " . $prop['height'] . " - END");
		die('{"jsonrpc" : "2.0", "src" : "' . $fileName . '", "width" : "' . $prop['width'] . '","height" : "' . $prop['height'] . '" }');
	    } else {
		die('{"jsonrpc" : "2.0"}');
	    }
	} catch (Exception $e) {
	    $this->debug("uploadImage", "Exception : " . var_export($e, true));
	}
    }

    public function uploadMp3() {
	try {
	    $this->setHeader();

// imposto limite di tempo di esecuzione
	    if ($this->config->timeLimit > 0) {
		@set_time_limit($this->config->timeLimit);
	    }

// settings
	    $targetDir = CACHE_DIR;
// creao la directory di destinazione se non esiste
	    if (!file_exists($targetDir)) {
		@mkdir($targetDir);
	    }
            
            if(!file_exists(USERS_DIR)){
               @mkdir(USERS_DIR); 
            }

// recupero l'estensione del file
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
		$this->debug("uploadImage", "Renaming {$filePath}.part in : " . $filePath);
		rename("{$filePath}.part", $filePath);

		if (filesize($filePath) > MAX_MP3_UPLOAD_FILE_SIZE) {
		    unlink($filePath);
		    die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "File is too big."}, "id" : "id"}');
		}

		$ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
		$fileName = (md5(time() . rand())) . "." . $ext;
		$randomName = CACHE_DIR . DIRECTORY_SEPARATOR . $fileName;
		$resRename = rename($filePath, $randomName);
		if (!$resRename) {
		    $this->debug("uploadImage", "ERROR: Error renaming file - END");
		    die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Error renaming file."}, "id" : "id"}');
		}

		//Analizzo l'mp3
		$mp3Analysis = new Mp3file($randomName);
		$metadata = $mp3Analysis->get_metadata();
		die('{"jsonrpc" : "2.0", "src" : "' . $fileName . '", "duration" : "' . $metadata['Length mm:ss'] . '"}');
	    } else {
		die('{"jsonrpc" : "2.0"}');
	    }


// Restituisco successo            
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

    /**
     * Per le immagini e' necessario mostrarle a video con una dimensione diversa
     * di default
     * @param type $width
     * @param type $height
     * @return type
     */
    private function calculateNewProperties($width, $height) {
	try {
	    $MAX_IMG_WIDTH = $this->config->maxImgWidth;
	    $MAX_IMG_HEIGHT = $this->config->maxImgHeight;
	    //modifico solo se almeno una delle dimensioni e' da ridurre
	    if ($width <= $MAX_IMG_WIDTH && $height <= $MAX_IMG_HEIGHT) {
		return array("width" => $width, "height" => $height);
	    } else {
		if ($width >= $height && $width > $MAX_IMG_WIDTH) {
		    $newWidth = $MAX_IMG_WIDTH;
		    $newHeight = round(($newWidth * $height) / $width);
		    return $this->calculateNewProperties($newWidth, $newHeight);
		} else {
		    $newHeight = $MAX_IMG_HEIGHT;
		    $newWidth = round(($newHeight * $width) / $height);
		    return $this->calculateNewProperties($newWidth, $newHeight);
		}
	    }
	} catch (Exception $e) {
	    return array(0, 0);
	}
    }

    private function debug($function, $msg) {
	$path = "upload.controller/";
	$file = date("Ymd"); //today
	debug($path, $file, $function . " | " . $msg);
    }

}

?>
