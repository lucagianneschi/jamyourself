<?php

require_once ROOT_DIR . 'config.php';
require_once CONTROLLERS_DIR . 'restController.php';
require_once SERVICES_DIR . 'cropImage.service.php';
require_once SERVICES_DIR . 'mp3.service.php';
require_once SERVICES_DIR . 'log.service.php';

/**
 * UploadController class
 * controller per upload di immagini e di file mp3
 * 
 * @author		Stefano Muscas
 * @version		0.2
 * @since		2013
 * @copyright		Jamyourself.com 2013	
 * @warning
 * @bug
 * @todo                
 */
class UploadController extends REST {

    private $config;

    /**
     * funzione per gestione delle impostazioni del controller
     */
    function __construct() {
	parent::__construct();
	$this->config = json_decode(file_get_contents(CONFIG_DIR . "uploadController.config.json"), false);
    }

    /**
     * funzione per upload immagine
     * imposta tempo di esecuzione massimo, crea la directory di destinazione se non esiste,
     * recupero il nome del file, abilità il Chunking, apre il file temporaneo,
     * Read binary input stream and append it to temp file,Verifico che il file sia stato caricato,
     * Strip the temp .part suffix off, effettuo il resize dell'immagine, prelevo gli attributi dell'immagine,
     * calcolo le proporzioni da mostrare a video,Restituisco successo or die
     * 
     */
    public function uploadImage() {
	$startTimer = microtime();
	try {
	    $this->setHeader();
	    if ($this->config->timeLimit > 0) {
		@set_time_limit($this->config->timeLimit);
	    }
	    $targetDir = CACHE_DIR;
	    if (!file_exists($targetDir)) {
		@mkdir($targetDir);
	    }
	    if (!file_exists(USERS_DIR)) {
		@mkdir(USERS_DIR);
	    }
	    if (isset($_REQUEST["name"])) {
		$fileName = $_REQUEST["name"];
	    } elseif (!empty($_FILES)) {
		$fileName = $_FILES["file"]["name"];
	    } else {
		$fileName = uniqid("file_");
	    }
	    $filePath = $targetDir . $fileName;
	    $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
	    $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;
	    if (!$out = @fopen("{$filePath}.part", $chunks ? "ab" : "wb")) {
		die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
	    }
	    if (!empty($_FILES)) {
		if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
		    die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
		}
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
	    if (!$chunks || $chunk == $chunks - 1) {
		rename("{$filePath}.part", $filePath);
		if (filesize($filePath) > MAX_IMG_UPLOAD_FILE_SIZE) {
		    unlink($filePath);
		    die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "File is too big."}, "id" : "id"}');
		}
		$ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
		$fileName = (md5(time() . rand())) . "." . $ext;
		$randomName = CACHE_DIR . $fileName;
		$resRename = rename($filePath, $randomName);
		if (!$resRename) {
		    die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Error renaming file."}, "id" : "id"}');
		}
		list($imgWidth, $imgHeight, $imgType, $imgAttr) = getimagesize($randomName);
		$prop = $this->calculateNewProperties($imgWidth, $imgHeight);
		die('{"jsonrpc" : "2.0", "src" : "' . $fileName . '", "width" : "' . $prop['width'] . '","height" : "' . $prop['height'] . '" }');
	    } else {
		die('{"jsonrpc" : "2.0"}');
	    }
	} catch (Exception $e) {
	    $endTimer = microtime();
	    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during uploadImage "Exception" => ' . $e->getMessage());
	}
    }

    /**
     * funzione per Mp3
     * imposta tempo di esecuzione massimo, crea la directory di destinazione se non esiste,
     * recupero l'estensione del file, abilità il Chunking, rimuovo i vecchi files, apre il file temporaneo,
     * Read binary input stream and append it to temp file,Verifico che il file sia stato caricato,
     * Strip the temp .part suffix off, effettuo il resize dell'immagine, prelevo gli attributi dell'immagine,
     * calcolo le proporzioni da mostrare a video,Restituisco successo or die
     * 
     */
    public function uploadMp3() {
	$startTimer = microtime();
	try {
	    $this->setHeader();
	    if ($this->config->timeLimit > 0) {
		@set_time_limit($this->config->timeLimit);
	    }
	    $targetDir = CACHE_DIR;
	    if (!file_exists($targetDir)) {
		@mkdir($targetDir);
	    }
	    if (!file_exists(USERS_DIR)) {
		@mkdir(USERS_DIR);
	    }
	    if (isset($_REQUEST["name"])) {
		$fileName = $_REQUEST["name"];
	    } elseif (!empty($_FILES)) {
		$fileName = $_FILES["file"]["name"];
	    } else {
		$fileName = uniqid("file_");
	    }
	    $filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;
	    $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
	    $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;
	    if ($this->config->cleanUpTargetDir) {
		if (!$this->cleanUpTargetDir($targetDir, $filePath)) {
		    die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
		}
	    }
	    if (!$out = @fopen("{$filePath}.part", $chunks ? "ab" : "wb")) {
		die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
	    }
	    if (!empty($_FILES)) {
		if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
		    die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
		}
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
	    if (!$chunks || $chunk == $chunks - 1) {
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
		    die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Error renaming file."}, "id" : "id"}');
		}
		$mp3Analysis = new Mp3file($randomName);
		$metadata = $mp3Analysis->get_metadata();
		die('{"jsonrpc" : "2.0", "src" : "' . $fileName . '", "duration" : "' . $metadata['Length mm:ss'] . '"}');
	    } else {
		die('{"jsonrpc" : "2.0"}');
	    }
	} catch (Exception $e) {
	    $endTimer = microtime();
	    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during uploadMp3 "Exception" => ' . $e->getMessage());
	}
    }

    /**
     * Per le immagini e' necessario mostrarle a video con una dimensione diversa
     * di default
     * 
     * @param type $width
     * @param type $height
     * @return array(0,0) in case of error, array(width,height) otherwise
     */
    private function calculateNewProperties($width, $height) {
	$startTimer = microtime();
	try {
	    $MAX_IMG_WIDTH = $this->config->maxImgWidth;
	    $MAX_IMG_HEIGHT = $this->config->maxImgHeight;
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
	    $endTimer = microtime();
	    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during calculateNewProperties "Exception" => ' . $e->getMessage());
	    return array(0, 0);
	}
    }

    /**
     * Per le immagini e' necessario mostrarle a video con una dimensione diversa
     * di default
     * 
     * @param type $width
     * @param type $height
     * @return array(0,0) in case of error, array(width,height) otherwise
     */
    private function cleanUpTargetDir($targetDir, $filePath) {
	$startTimer = microtime();
	try {
	    $maxFileAge = $this->config->maxFileAge; // Temp file age in seconds
	    if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
		return false;
	    }
	    while (($file = readdir($dir)) !== false) {
		$tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

		if ($tmpfilePath == "{$filePath}.part") {
		    continue;
		}
		if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge)) {
		    @unlink($tmpfilePath);
		}
	    }
	    closedir($dir);
	    return true;
	} catch (Exception $e) {
	    $endTimer = microtime();
	    jamLog(__FILE__, __LINE__, '[Execution time: ' . executionTime($startTimer, $endTimer) . '] Error during cleanUpTargetDir "Exception" => ' . $e->getMessage());
	    return false;
	}
    }

    /**
     * Setta header del file
     */
    private function setHeader() {
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
    }

}

?>