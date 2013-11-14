<?php
/* box review eventi
 * box chiamato tramite load con:
 * data: {data: data, typeUser: typeUser},
 * 
 * box per tutti gli utenti, su spotter non viene visualizzato l'autore 
 */
 
 
if (!defined('ROOT_DIR'))
	define('ROOT_DIR', '../../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';  
 
$data = $_POST['data'];

$objectIdUser  = $_POST['objectIdUser'];
$typeUser = $_POST['typeUser'];	

?>
<!------------------------------------- Reviews ------------------------------------>
<div class="row" id="social-EventReview">
	<div  class="large-12 columns">
	<div class="row">
		<div  class="large-5 columns">
			<h3><?php echo $views['EventReview']['TITLE'];?></h3>
		</div>	
		<div  class="large-7 columns align-right">
			<?php if($data['eventReviewCounter'] > 1){ ?>
				<a class="icon-block _nextPage grey" onclick="royalSlideNext('EventReview')" style="top: 5px !important; margin-top: 15px !important"></a>
			    <a class="icon-block _prevPage grey text" onclick="royalSlidePrev('EventReview')" style="top: 5px !important; margin-top: 15px !important; "><span class="indexBox">1</span>/<?php echo $data['eventReviewCounter'] ?></a>
	 		
			<?php } ?>
		</div>	
	</div>	
	<div class="row  ">
		<div  class="large-12 columns ">
			<div class="box">
				<div class="royalSlider contentSlider  rsDefault" id="eventReviewSlide">
				<?php 
				if($data['eventReviewCounter'] > 0){
				
					for ($i = 0; $i < $data['eventReviewCounter']; $i++) {
						$eventReview_objectId = $data['eventReview'.$i]['objectId'];
						$eventReview_user_objectId = $data['eventReview'.$i]['user_objectId'];		
						$eventReview_user_thumbnail = $data['eventReview'.$i]['user_thumbnail'];						
						$eventReview_user_username = $data['eventReview'.$i]['user_username'];
						$eventReview_thumbnailCover = $data['eventReview'.$i]['thumbnailCover'];
						$eventReview_title = $data['eventReview'.$i]['title'];
						$eventReview_rating = $data['eventReview'.$i]['rating'];
						$eventReview_text = $data['eventReview'.$i]['text'];
						$eventReview_love = $data['eventReview'.$i]['counters']['loveCounter'];
						$eventReview_comment = $data['eventReview'.$i]['counters']['commentCounter'];
						$eventReview_share = $data['eventReview'.$i]['counters']['shareCounter'];
						if($data['eventReview' . $i]['showLove'] == 'true'){
							$css_love = '_unlove grey';
							$text_love = $views['LOVE'];
						}
						elseif($data['eventReview' . $i]['showLove'] == 'false'){
							$css_love = '_love orange';
							$text_love = $views['UNLOVE'];
						}
						
						?>
						<div  class="rsContent">	
						<div id='eventReview_<?php echo $eventReview_objectId ?>'>	
						<?php if($typeUser != "SPOTTER"){ ?>
							<div class="row <?php echo $eventReview_user_objectId ?>">
													
								<div  class="small-1 columns ">
									<div class="userThumb">
										<img src="../media/<?php echo $eventReview_user_thumbnail ?>" onerror="this.src='../media/<?php echo $default_img['DEFAVATARTHUMB']; ?>'">
									</div>
								</div>
								<div  class="small-11 columns">
									<div class="text grey" style="margin-left: 10px;"><strong><?php echo $eventReview_user_username ?></strong></div>
								</div>	
							
							</div>
							<div class="row">
								<div  class="large-12 columns"><div class="line"></div></div>
							</div>
							<?php }?>
							<div class="row">
								<div  class="small-2 columns ">
									<div class="coverThumb"><img src="../media/<?php echo $eventReview_thumbnailCover?>" onerror="this.src='../media/<?php echo $default_img['DEFEVENTTHUMB']; ?>'"></div>						
								</div>
								<div  class="small-8 columns ">
									<div class="row ">							
										<div  class="small-12 columns ">
											<div class="sottotitle grey-dark"><?php echo $eventReview_title ?></div>
										</div>	
									</div>	
									<div class="row">						
										<div  class="small-12 columns ">
											<div class="note grey"><?php echo $views['EventReview']['RATING'];?></div>
										</div>
									</div>
									<div class="row ">						
										<div  class="small-12 columns ">
											<?php for($index=0; $index < 5;$index++){ 
												if($index <= $eventReview_rating)
												 echo '<a class="icon-propriety _star-orange"></a>';
												else echo '<a class="icon-propriety _star-grey"></a>';	
											 } ?>
										</div>
									</div>													
								</div>
								<div  class="small-2 columns align-right viewAlbumReview">
									<a href="#" class="orange"><strong onclick="toggleTextEventReview(this,'eventReview_<?php echo $eventReview_objectId ?>')"><?php echo $views['EventReview']['READ'];?></strong></a>
								</div>				
							</div>
							
							<div class="textReview no-display">
								<div class="row ">						
									<div  class="small-12 columns ">
										<div class="text grey" style="line-height: 18px !important;">
											<?php echo $eventReview_text; ?>
										</div>
									</div>
								</div>					
							</div>
							<div class="row">
								<div  class="large-12 columns">
									<div class="line"></div>
								</div>
							</div>
							<div class="row recordReview-propriety">
								<div class="box-propriety">
									<div class="small-7 columns ">
										<a class="note grey" onclick="love(this, 'Comment', '<?php echo $eventReview_objectId; ?>', '<?php echo $objectIdUser; ?>')"><?php echo $text_love ?></a>
										<a class="note grey" onclick="setCounter(this,'<?php echo $eventReview_objectId; ?>','EventReview')"><?php echo $views['COMM'];?></a>
										<a class="note grey" onclick="share(this,'<?php echo $eventReview_objectId; ?>','social-EventReview')"><?php echo $views['SHARE'];?></a>
											
										
									</div>
									<div class="small-5 columns propriety ">					
										<a class="icon-propriety <?php echo $css_love ?>" ><?php echo $eventReview_love ?></a>
										<a class="icon-propriety _comment" ><?php echo $eventReview_comment ?></a>
										<a class="icon-propriety _share" ><?php echo $eventReview_share ?></a>
									</div>	
								</div>		
							</div>
							
							
						</div>
						
					</div>
					
					<?php
					}
				} else{
					?>
					<div  class="rsContent">	
						<div class="row">
							<div  class="large-12 columns"><p class="grey"><?php echo $views['EventReview']['NODATA'];?></p></div>
						</div>
					</div>
					<?php
				}
				?>
			</div>	
		</div>
						
		</div>
	</div>
	<!---------------------------------------- comment ------------------------------------------------->
	<div class="box-comment no-display" ></div>
	<!---------------------------------------- SHARE ---------------------------------------------------->
	<!-- AddThis Button BEGIN -->
	<div class="addthis_toolbox">   
	    <div class="hover_menu">
	        <div class="addthis_toolbox addthis_default_style addthis_32x32_style"
		addThis:url="http://socialmusicdiscovering.com/tests/controllers/share/testShare2.controller.php?classe=Album"
		addThis:title="Titolo della pagina di un album">
	        <a class="addthis_button_twitter"></a>
	        <a class="addthis_button_facebook"></a>
	        <a class="addthis_button_google_plusone_share"></a>
	       </div>
	        
	    </div>
    </div>
	<!-- AddThis Button END -->
	</div>
</div>
	
