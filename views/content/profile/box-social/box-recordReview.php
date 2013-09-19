<?php
/* box review RECORD
 * box chiamato tramite load con:
 * data: {data,typeUser}
 * 
 * box 
 */
 
 $data = $_POST['data'];
 $typeUser = $_POST['typeUser'];

?>

<!------------------------------------- Reviews ------------------------------------>
<div class="row" id="social-recordReview">
	<div  class="large-12 columns">	
	<div class="row">
		<div  class="small-5 columns">
			<h3>Album Reviews</h3>
		</div>	
		<div  class="small-7 columns align-right">
			<?php if($data['recordReviewCounter'] > 0){ ?>
				<a class="icon-block _nextPage grey" onclick="royalSlideNext(this,'recordReview')" style="top: 5px !important; margin-top: 15px !important"></a>
			<a class="icon-block _prevPage grey text" onclick="royalSlidePrev(this,'recordReview')" style="top: 5px !important; margin-top: 15px !important"><span class="indexBox">1</span>/<?php echo $data['recordReviewCounter'] ?></a>
	 		
			<?php } ?>
		</div>	
	</div>	
	
	<div class="row">
		<div  class="large-12 columns ">
			<div class="box">
			<div class="royalSlider contentSlider  rsDefault" id="recordReviewSlide">				
				<?php 
				if($data['recordReviewCounter'] > 0){
				
					for ($i=0; $i<$data['recordReviewCounter'];$i++) {
						$recordReview_objectId = $data['recordReview'.$i]['objectId'];
						$recordReview_user_objectId = $data['recordReview'.$i]['user_objectId'];		
						$recordReview_user_thumbnail = $data['recordReview'.$i]['user_thumbnail'];						
						$recordReview_user_username = $data['recordReview'.$i]['user_username'];
						$recordReview_thumbnailCover = $data['recordReview'.$i]['thumbnailCover'];
						$recordReview_title = $data['recordReview'.$i]['title'];
						$recordReview_rating = $data['recordReview'.$i]['rating'];
						$recordReview_text = $data['recordReview'.$i]['text'];
						$recordReview_love = $data['recordReview'.$i]['counters']['loveCounter'];
						$recordReview_comment = $data['recordReview'.$i]['counters']['commentCounter'];
						$recordReview_shere = $data['recordReview'.$i]['counters']['shareCounter'];
				?>
				<div  class="rsContent">	
				<div id='recordReview_<?php echo $recordReview_objectId ?>'>
				<?php if($typeUser != "SPOTTER"){ ?>		
				
					<div class="row <?php echo $recordReview_user_objectId ?>">
											
						<div  class="small-1 columns ">
							<div class="userThumb">
								<img src="../media/<?php echo $recordReview_user_thumbnail ?>" onerror="this.src='../media/images/default/defaultProfilepicturethumb.jpg'">
							</div>
						</div>
						<div  class="small-11 columns">
							<div class="text grey" style="margin-left: 10px;"><strong><?php echo $recordReview_user_username ?></strong></div>
						</div>	
					
					</div>
					<div class="row">
						<div  class="large-12 columns"><div class="line"></div></div>
					</div>
					<?php }?>
					<div class="row">
						<div  class="small-2 columns ">
							<div class="coverThumb"><img src="../media/<?php echo $recordReview_thumbnailCover?>" onerror="this.src='../media/images/default/defaultRecordCoverThumb.jpg'"></div>						
						</div>
						<div  class="small-8 columns ">
							<div class="row ">							
								<div  class="small-12 columns ">
									<div class="sottotitle grey-dark"><?php echo $recordReview_title ?></div>
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
										if($index <= $recordReview_rating)
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
									<?php echo $recordReview_text; ?>
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
								<a class="note grey " onclick="setCounter(this,'<?php echo $recordReview_objectId; ?>','recordReview')">Love</a>
								<a class="note grey" onclick="setCounter(this,'<?php echo $recordReview_objectId; ?>','recordReview')">Comment</a>
								<a class="note grey" onclick="setCounter(this,'<?php echo $recordReview_objectId; ?>','recordReview')">Shere</a>
							</div>
							<div class="small-6 columns propriety ">					
								<a class="icon-propriety _unlove grey" ><?php echo $recordReview_love ?></a>
								<a class="icon-propriety _comment" ><?php echo $recordReview_comment ?></a>
								<a class="icon-propriety _shere" ><?php echo $recordReview_shere ?></a>
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
				<?php } ?>
			</div>
			</div>	
		</div>
	</div>
	</div>
</div>	