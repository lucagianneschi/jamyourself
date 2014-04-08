<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
?>
<div class="row">
    <div  class="large-12 columns formBlack-title">
        <h2><?php echo $views['uploadAlbum']['select']; ?></h2>										
    </div>	
</div>						
<div class="row formBlack-body" id="uploadAlbum-listAlbum">
    <div  class="large-12 columns ">

        <div  id="uploadAlbum-listAlbumTouch" class="touchcarousel grey-blue">
            <div id="albums_spinner"></div>
            <ul class="touchcarousel-container" id="albumList">            
            	<?php 
            	require_once BOXES_DIR . "album.box.php";
				$albumBox = new AlbumBox();
				$albumBox->init($_SESSION['id'], $limit = 10);
            	$albumList = array();
				$fileManager = new FileManagerService();
				if (is_null($albumBox->error) && count($albumBox->albumArray) > 0) {
				    foreach ($albumBox->albumArray as $album) {
						$thumbnail = file_exists($fileManager->getPhotoPath($_SESSION['id'], $album->getThumbnail())) ? $fileManager->getPhotoPath($_SESSION['id'], $album->getThumbnail()) : DEFALBUMTHUMB;
						$title = $album->getTitle();
						$images = $album->getImagecounter();
						$albumId = $album->getId();
            	?>
	            	<li class="touchcarousel-item">
					    <div class="item-block uploadAlbum-boxSingleAlbum" id="<?php echo $albumId?>">
						    <div class="row uploadAlbum-rowSingleAlbum">
							    <div  class="small-6 columns ">
							    	<img class="coverAlbum"  src="<?php echo $thumbnail?>"> 
							    </div>
							    <div  class="small-6 columns title">
								    <div class="sottotitle white"><?php echo $title?></div>
								    <div class="text white"><?php echo $images ?> photos</div>
							    </div>
						    </div>
					    </div>
				    </li>
			    <?php 
			    	}
			    }
			    ?>		
            </ul>

        </div>

    </div>		
</div>
<div class="row">
    <div  class="large-12 columns formBlack-title">
        <a type="button" class="buttonOrange _add sottotitle" id="uploadAlbum-new"><?php echo $views['uploadAlbum']['create']; ?></a>									
    </div>	
</div>