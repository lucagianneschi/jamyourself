<?php
/*
 * box album detail
 * box chiamato tramite load con:
 * data: {data: data, typeUser: id}
 * 
 * box per tutti gli utenti
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'log.service.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once SERVICES_DIR . 'geocoder.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
require_once SERVICES_DIR . 'fileManager.service.php';
require_once VIEWS_DIR . 'utilities/share.php';
require_once BOXES_DIR . 'album.box.php';
require_once CLASSES_DIR . 'user.class.php';
require_once SERVICES_DIR . 'select.service.php';

$userId = $_POST['userId'];
$id = $_POST['id'];
$countImage = $_POST['countImage'];
$limit = intval($_POST['limit']);
$skip = intval($_POST['skip']);
if (session_id() == '')
    session_start();
if (isset($_SESSION['id']))
    $currentUserId = $_SESSION['id'];
$albumDetail = new AlbumBox();
$albumDetail->initForDetail($id, $limit, $skip);
$css_other = 'no-display';
$other = 0;
if (($limit + $skip) < $countImage) {
    $css_other = '';
    $other = $countImage - ($limit + $skip);
}
$fileManagerService = new FileManagerService();
?>
<ul class="small-block-grid-3 small-block-grid-2 " >	
    <?php
    foreach ($albumDetail->imageArray as $key => $value) {
	$thumbImage = $value->getThumbnail();
	?>
        <!------------------------------ THUMBNAIL ---------------------------------->
        <li><a class="photo-colorbox-group" href="#<?php echo $value->getId(); ?>"><img class="photo" src="<?php echo $fileManagerService->getPhotoPath($userId, $value->getThumbnail()); ?>" onerror="this.src='<?php echo DEFIMAGE; ?>'" alt></a></li>
    <?php } ?>
</ul>
<div class="row">
    <div class="small-12 columns">
	<a class="text orange otherObject <?php echo $css_other; ?>" onclick="loadBoxAlbumDetail('<?php echo $id ?>',<?php echo $countImage ?>, 30,<?php echo $limit + $skip ?>)" style="padding-bottom: 15px;float: right;"><?php echo $views['other']; ?><span><?php echo $other; ?></span><?php echo $views['PHOTOS']; ?></a>	
    </div>
</div>
<div class='spinnerDetail'></div>
<?php if (count($albumDetail->imageArray) == 0) { ?>
    <div class="row  ">
        <div  class="large-12 columns ">
    	<p class="grey"><?php echo $views['album']['nodata']; ?></p>
        </div>
    </div>
<?php } ?>
<!----------------------------------- lightbox ------------------------------------------>
<div class="row no-display box" id="profile-Image">
    <div class="large-12 columns">
	<?php
	foreach ($albumDetail->imageArray as $key => $value) {
	    $connectionService = new ConnectionService();
	    if (existsRelation($connectionService, 'user', $currentUserId, 'image', $value->getId(), 'LOVE')) {
		$css_love = '_love orange';
		$text_love = $views['unlove'];
	    } else {
		$css_love = '_unlove grey';
		$text_love = $views['love'];
	    }
	    ?>				 	
    	<div id="<?php echo $value->getId(); ?>" class="lightbox-photo <?php echo $fileManagerService->getPhotoPath($userId, $value->getPath()); ?>">
    	    <div class="row " style="max-width: none;">
    		<div class="large-12 columns lightbox-photo-box">
    		    <div class="album-photo-box" onclick="nextLightBox()"><img class="album-photo"  src="<?php echo $pathImage . $value->getPath(); ?>" onerror="this.src='<?php echo DEFIMAGE; ?>'" alt/></div>
    		    <div class="row">
    			<div  class="large-12 columns" style="padding-top: 15px;padding-bottom: 15px"><div class="line"></div></div>
    		    </div>
    		    <div class="row" style="margin-bottom: 10px">
    			<div  class="small-6 columns">
    			    <a class="note grey " onclick="love(this, 'Image', '<?php echo $value->getId(); ?>', '<?php echo $objectIdUser; ?>')"><?php echo $text_love; ?></a>
    			    <a class="note grey" onclick="loadBoxOpinion('<?php echo $value->getId(); ?>', '<?php echo $value->getFromuser()->getId(); ?>', 'Image', '#<?php echo $value->getId(); ?> .box-opinion', 10, 0)"><?php echo $views['comm']; ?></a>
    			    <a class="note grey" onclick="share(this, '<?php echo $value->getId(); ?>', 'profile-Image')"><?php echo $views['share']; ?></a>
    			</div>
    			<div  class="small-6 columns propriety">
    			    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getLovecounter(); ?></a>
    			    <a class="icon-propriety _comment"><?php echo $value->getCommentcounter(); ?></a>
    			    <a class="icon-propriety _share"><?php echo $value->getSharecounter(); ?></a>	
    			</div>
    		    </div>
    		    <div class="row">
    			<div  class="small-5 columns">
    			    <div class="sottotitle white"><?php echo $album_title; ?></div>
				<?php if ($value->getDescription() != "") { ?>
				    <div class="text grey"><?php echo $value->getDescription(); ?></div>		
				    <?php
				}
				if ($value->getLatitude() && $value->getLongitude()) {
				    $lat = $value->getLatitude();
				    $lng = $value->getLongitude();
				    $geocode = new GeocoderService();
				    $addressCode = $geocode->getAddress($lat, $lng);
				    if (count($addressCode) > 0) {
					$address = $addressCode['locality'] . " - " . $addressCode['country'];
				    }
				    ?>
				    <div class="text grey"><?php echo $address; ?></div>			
				    <?php
				}
				$tag = "";
				if (is_array($value->getTag())) {
				    foreach ($value->getTag() as $key => $value) {
					$tag = $tag + ' ' + $value;
				    }
				    ?>
				    <div class="text grey"><?php echo $tag; ?></div>
				<?php }
				?>
    			</div>
    			<div  class="small-7 columns">
    			    <!---------------------------------------- COMMENT ------------------------------------------------->
    			    <div class="box-opinion no-display" ></div>
    			    <!---------------------------------------- SHARE ---------------------------------------------------->
    			</div>
			    <?php
			    //	$paramsImage = getShareParameters('Image', '', $value->getPath());
			    ?>		    			    
    		    </div>
    		    <!-- AddThis Button BEGIN -->
    		    <div class="addthis_toolbox">
    			<div class="hover_menu">
    			    <div class="addthis_toolbox addthis_default_style"
    				 addThis:url="http://www.socialmusicdiscovering.com/views/share.php?classType=Image&id=&imgPath=<?php echo $value->getPath(); ?>"
    				 addThis:title="<?php //echo $paramsImage['title'];        ?>"
    				 onclick="addShare('<?php echo $objectIdUser; ?>', 'Image', '<?php echo $value->getId(); ?>')">
    				<a class="addthis_button_twitter"></a>
    				<a class="addthis_button_facebook"></a>
    				<a class="addthis_button_google_plusone_share"></a>
    			    </div>	        
    			</div>
    		    </div>
    		    <!-- AddThis Button END -->	
    		</div>			
    	    </div>
    	</div>
	<?php } ?>
    </div>	
</div>