<?php
/* box review RECORD
 * box chiamato tramite load con:
 * data: {data,typeUser}
 * 
 * box 
 */
 
  if (!defined('ROOT_DIR'))
	define('ROOT_DIR', '../../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';  
 
 $data = $_POST['data'];
 $typeUser = $_POST['typeUser'];

//numero di review 
$review_count = 4; 
// dati utente che ha generato la review 
$review_user_objectId = '011';
$review_user_thumbnail  = $default_img['DEFAVATARTHUMB'];
$review_user_username = 'Nome Cognome';
$review_user_type = 'Jammer';


//dati review
$review_data = 'Venerdì 16 maggio - ore 10.15';
$review_title = 'Reviw Title';
$review_text = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus eu est dui. Etiam eu elit at lacus eleifend consectetur. Curabitur dolor diam, fringilla quis dignissim eget, tempus et lectus. Quisque sollicitudin laoreet tincidunt. In pretium massa quis diam dignissim dapibus. Donec sed mi mauris, a mollis nibh. Mauris et arcu eu quam mollis convallis ultricies id lacus. Donec dignissim sollicitudin nunc ultrices consectetur. Quisque eu mauris nisl, sed accumsan dolor. Duis mauris odio, semper eget convallis vel, tristique sit amet elit. Vestibulum id est velit. Nulla gravida, eros eu feugiat mollis, ante dui mollis augue, eu ullamcorper elit leo luctus augue. Donec quis tellus a ante rhoncus interdum non sed justo. Pellentesque suscipit pretium fringilla.';


?>

<div class="row" id="social-RecordReview">
	<div  class="large-12 columns">
		<div class="row">
			<div  class="large-12 columns">
				<h3>Reviews</h3>
			</div>			
		</div>	
		
		<?php 
		
		$review_3count = $review_count > 3 ? 3 : $review_count;
		$review_other = $review_3count > $review_count ? 0 : ($review_count - $review_3count);  
		for($i = 0; $i < $review_3count; $i++){ ?>
		
		<div class="row">
			<div  class="large-12 columns ">
				<div class="box">				
					<div id='recordReview_<?php echo $i ?>'>					
						<div class="row <?php echo $review_user_objectId ?>">											
							<div  class="small-1 columns ">
								<div class="userThumb">
									<img src="../media/<?php echo $review_user_thumbnail ?>" onerror="this.src='../media/<?php echo $default_img['DEFAVATARTHUMB']; ?>'">
								</div>
							</div>
							<div  class="small-5 columns">
								<div class="text grey" style="margin-left: 20px; margin-bottom: 0px !important;"><strong><?php echo $review_user_username ?></strong></div>
								<small class="orange" style="margin-left: 20px;"><?php echo $review_user_type ?></small>
							</div>
							<div  class="small-6 columns propriety">
								<div class="note grey-light">
									<?php echo $review_data ?>
								</div>
							</div>	
						</div>
						<div class="row">
							<div  class="large-12 columns"><div class="line"></div></div>
						</div>
						
						<div class="row">							
							<div  class="small-12 columns ">
								<div class="row ">							
									<div  class="small-12 columns ">
										<div class="sottotitle grey-dark"><?php echo $review_title ?></div>
									</div>	
								</div>								
								<div class="row ">						
									<div  class="small-12 columns ">
										<div class="note grey">Rating
										<a class="icon-propriety _star-orange"></a>
										<a class="icon-propriety _star-orange"></a>	
										<a class="icon-propriety _star-orange"></a>		
										<a class="icon-propriety _star-grey"></a>
										<a class="icon-propriety _star-grey"></a>
										</div>								
									</div>
								</div>													
							</div>									
						</div>
						<div class="row " style=" margin-top:10px;">						
							<div  class="small-12 columns ">
								<div class="text grey cropText inline" style="line-height: 18px !important;">
									<?php echo $review_text ?>									
								</div>
								<a href="#" class="orange viewText"><strong onclick="toggleText(this,'recordReview_<?php echo $i ?>','<?php echo $review_text ?>')">View All</strong></a>
								<a href="#" class="orange no-display closeText"><strong onclick="toggleText(this,'recordReview_<?php echo $i ?>','<?php echo $review_text ?>')">Close</strong></a>
							</div>
						</div>					
						
						<div class="row">
							<div  class="large-12 columns">
								<div class="line"></div>
							</div>
						</div>
						<div class="row recordReview-propriety">
							<div class="box-propriety">
								<div class="small-6 columns ">
									<a class="note grey " onclick="setCounter(this,'<?php echo $recordReview_objectId; ?>','RecordReview')"><?php echo $views['LOVE'];?></a>
									<a class="note grey" onclick="setCounter(this,'<?php echo $recordReview_objectId; ?>','RecordReview')"><?php echo $views['COMM'];?></a>
									<a class="note grey" onclick="setCounter(this,'<?php echo $recordReview_objectId; ?>','RecordReview')"><?php echo $views['SHARE'];?></a>
								</div>
								<div class="small-6 columns propriety ">					
									<a class="icon-propriety _unlove grey" >15</a>
									<a class="icon-propriety _comment" >20</a>
									<a class="icon-propriety _share" >2</a>
								</div>	
							</div>		
						</div>
						
						
					</div>					
				</div>						
			</div> 
			
			
		</div>
		<?php }
		if($review_other > 0){
		?>
		<div class="row otherSet">
			<div class="large-12 colums">
				<div class="text">Other <?php echo $review_other;?> Review</div>	
			</div>	
		</div>
		<?php }
		if($review_count == 0){
		?>
		<!---------------------------------------- comment ------------------------------------------------->
		<div class="box-comment no-display"></div>
		<div class="row">
			<div  class="large-12 columns ">
				<div class="box">						
					<div class="row">
						<div  class="large-12 columns"><p class="grey"><?php echo $views['RecordReview']['NODATA'];?></p></div>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
		
	</div> <!--- 24 -->
</div> <!--- <div class="row" id="social-EventReview"> -->
	
