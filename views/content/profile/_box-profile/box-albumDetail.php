<?php
/* 
 * box album detail
 * box chiamato tramite load con:
 * data: {data: data, typeUser: objectId}
 * 
 * box per tutti gli utenti
 */

if (!defined('ROOT_DIR'))
	define('ROOT_DIR', '../../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
require_once VIEWS_DIR . 'utilities/share.php'; 

$data = $_POST['data'];
$detail = $_POST['detail']; 
$objectIdUser  = $_POST['objectIdUser'];
$typeUser = $_POST['typeUser'];
$numerDetail = $_POST['numerDetail'];

$dataPrec = isset($_POST['dataPrec']) ? $_POST['dataPrec'] : Array();

$data = array_merge($dataPrec, $_POST['data']); 

//----------------------------------- thumbnail ------------------------------------------

if($detail == 0){
  ?>
  <ul class="small-block-grid-3 small-block-grid-2 " >	
  <?php		
  foreach ($data['image'] as $key => $value) {   
  ?>
  
  <li><a class="photo-colorbox-group" href="#<?php echo $value['objectId']; ?>"><img class="photo" src="../media/<?php $value['thumbnail']?>" onerror="this.src='../media/<?php echo DEFIMAGE; ?>'"></a></li>

<?php 
  }
  $counterImage = count($data['image']); 
 ?>
</ul>

<div class="row">
	<div class="small-12 columns">
		<a class="text orange otherObject no-display" onclick="getOtherObject(<?php echo $data?>,<?php echo $numerDetail ?> )" style="padding-bottom: 15px;float: right;">Other <span></span> photo</a>	
	</div>
</div>

<script>	
	
	function getOtherString(tot, limit){
		if(limit < tot){
			$('.otherObject').removeClass('no-display');		
			$('.otherObject span').text(tot-limit);
		}
		
	}
	getOtherString(<?php echo $numerDetail ?>,<?php echo $counterImage ?>);
</script>
<?php
}

//----------------------------------- lightbox ------------------------------------------
else{
 ?> 

<div class="row no-display box" id="profile-Image">
	<div class="large-12 columns">
		 <?php foreach ($data['image'] as $key => $value) {   
		 			if($value['showLove'] == 'true'){
						$css_love = '_unlove grey';
						$text_love = $views['LOVE'];
					}
					elseif($value['showLove'] == 'false'){
						$css_love = '_love orange';
						$text_love = $views['UNLOVE'];
					}
		 	
		 	?>				 	
			<div id="<?php echo $value['objectId']; ?>" class="lightbox-photo <?php echo $value['filePath']; ?>">
				<div class="row " style="max-width: none;">
					<div class="large-12 columns lightbox-photo-box"   >
						<div class="album-photo-box" onclick="nextLightBox()"><img class="album-photo"  src="../media/images/image/<?php echo $value['filePath']; ?>" onerror="this.src='../media/<?php echo DEFIMAGE; ?>'"/></div>
			 			<div class="row">
			 				<div  class="large-12 columns" style="padding-top: 15px;padding-bottom: 15px"><div class="line"></div></div>
			 			</div>
			 			<div class="row" style="margin-bottom: 10px">
			 				<div  class="small-6 columns">
			 					<a class="note grey " onclick="love(this, 'Image', '<?php echo $value['objectId']; ?>', '<?php echo $objectIdUser; ?>')"><?php echo $text_love;?></a>
								<a class="note grey" onclick="setCounter(this,'<?php echo $value['objectId']; ?>','Image')"><?php echo $views['COMM'];?></a>
								<a class="note grey" onclick="share(this,'<?php echo $value['objectId']; ?>','profile-Image')"><?php echo $views['SHARE'];?></a>
			 				</div>
			 				<div  class="small-6 columns propriety">
			 					<a class="icon-propriety <?php echo $css_love ?>"><?php echo $value['counters']['loveCounter']; ?></a>
								<a class="icon-propriety _comment"><?php echo $value['counters']['commentCounter']; ?></a>
								<a class="icon-propriety _share"><?php echo $value['counters']['shareCounter']; ?></a>	
			 				</div>
			 			</div>
			 			<div class="row">
			 				<div  class="small-5 columns">
			 					<div class="sottotitle white"><?php echo $data['album' . $i]['title']; ?></div>
			 					<?php if($value['description'] != ""){?>
			 					<div class="text grey"><?php echo $value['description']; ?></div>
			 					
			 					<?php }if($value['location'] != ""){?>
			 						
			 					<div class="text grey"><?php echo $value['location'];?></div>
			 					
			 					<?php
								} 
			 						$tag = "";
			 						if(is_array ($value['tags'])){					 							
			 							foreach ($value['tags'] as $key => $value) {
											 $tag = $tag + ' ' + $value;
										 }
			 						?>
									<div class="text grey"><?php echo $tag; ?></div>
								<?php	} 
			 						?>
			 				</div>
			 				<div  class="small-7 columns">
			 					<!---------------------------------------- COMMENT ------------------------------------------------->
								<div class="box-comment no-display" ></div>
								<!---------------------------------------- SHARE ---------------------------------------------------->
									<?php
									$paramsImage = getShareParameters('Image', '', $value['filePath']);
									?>
									<!-- AddThis Button BEGIN -->
									<div class="addthis_toolbox">
										<div class="hover_menu">
										        <div class="addthis_toolbox addthis_default_style"
													addThis:url="http://www.socialmusicdiscovering.com/views/share.php?classType=Image&objectId=&imgPath=<?php echo $value['filePath']; ?>"
													addThis:title="<?php echo $paramsImage['title']; ?>"
													onclick="addShare('<?php echo $objectIdUser; ?>', 'Image', '<?php echo $value['objectId']; ?>')">
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
			 	</div>
			 	
			</div>
			
		<?php } ?>
		
	</div>	
</div>


<?php
}
?>