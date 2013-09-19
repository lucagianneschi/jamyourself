<?php
/* box review eventi
 * box chiamato tramite ajax con:
 * data: {user: objectId}, 
 * data-type: html,
 * type: POST o GET
 * 
 * box per tutti gli utenti, su spotter non viene visualizzato l'autore 
 */
 
$data = $_POST['data'];
$typeUser = $_POST['typeUser'];	

?>
<!------------------------------------- Reviews ------------------------------------>
<div class="row" id="social-eventReview">
	<div  class="large-12 columns">
	<div class="row">
		<div  class="large-5 columns">
			<h3>Event Reviews</h3>
		</div>	
		<div  class="large-7 columns align-right">
			<?php if($data['eventReviewCounter'] > 0){ ?>
				<a class="icon-block _nextPage grey" onclick="royalSlideNext(this,'eventReview')" style="top: 5px !important; margin-top: 15px !important"></a>
			<a class="icon-block _prevPage grey text" onclick="royalSlidePrev(this,'eventReview')" style="top: 5px !important; margin-top: 15px !important; "><span class="indexBox">1</span>/<?php echo $data['eventReviewCounter'] ?></a>
	 		
			<?php } ?>
		</div>	
	</div>	
	<div class="row  ">
		<div  class="large-12 columns ">
			<div class="box">
				<div class="royalSlider contentSlider  rsDefault" id="eventReviewSlide">
				<?php 
				if($data['eventReviewCounter'] > 0){
				
					for ($i=0; $i<$data['eventReviewCounter'];$i++) {
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
						$eventReview_shere = $data['eventReview'.$i]['counters']['shareCounter'];
				?>
				<div  class="rsContent">	
				<div id='eventReview_<?php echo $eventReview_objectId ?>'>	
				<?php if($typeUser != "SPOTTER"){ ?>
					<div class="row <?php echo $eventReview_user_objectId ?>">
											
						<div  class="small-1 columns ">
							<div class="userThumb">
								<img src="../media/<?php echo $eventReview_user_thumbnail ?>" onerror="this.src='../media/images/default/defaultProfilepicturethumb.jpg'">
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
							<div class="coverThumb"><img src="../media/<?php echo $eventReview_thumbnailCover?>" onerror="this.src='../media/images/default/defaultRecordCoverThumb.jpg'"></div>						
						</div>
						<div  class="small-8 columns ">
							<div class="row ">							
								<div  class="small-12 columns ">
									<div class="sottotitle grey-dark"><?php echo $eventReview_title ?></div>
								</div>	
							</div>	
							<div class="row">						
								<div  class="small-12 columns ">
									<div class="note grey">Rating</div>
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
							<a href="#" class="orange"><strong onclick="toggleText(this)">Read</strong></a>
						</div>				
					</div>
					
					<div class="textAlbumReview no-display">
						<div class="row ">						
							<div  class="small-12 columns ">
								<div class="text grey">
									<?php echo $eventReview_text; ?>
								</div>
							</div>
						</div>					
					</div>
					<div class="row">
						<div  class="large-12 columns"><div class="line"></div></div>
					</div>
					<div class="row recordReview-propriety">
						<div class="box-propriety">
							<div class="small-6 columns ">
								<a class="note grey " onclick="setCounter(this,'<?php echo $eventReview_objectId; ?>','recordReview')">Love</a>
								<a class="note grey" onclick="setCounter(this,'<?php echo $eventReview_objectId; ?>','recordReview')">Comment</a>
								<a class="note grey" onclick="setCounter(this,'<?php echo $eventReview_objectId; ?>','recordReview')">Shere</a>
							</div>
							<div class="small-6 columns propriety ">					
								<a class="icon-propriety _unlove grey" ><?php echo $eventReview_love ?></a>
								<a class="icon-propriety _comment" ><?php echo $eventReview_comment ?></a>
								<a class="icon-propriety _shere" ><?php echo $eventReview_shere ?></a>
							</div>	
						</div>		
					</div>
				</div>
			</div>	
				<?php } }
					else{
					?>
				<div  class="rsContent">	
					<div class="row">
						<div  class="large-12 columns"><p class="grey">There are no reviews</p></div>
					</div>
				</div>
			</div>				
		<?php } ?>
		</div>			
		</div>
	</div>
	</div>
</div>	