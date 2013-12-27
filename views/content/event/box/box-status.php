<?php
/* box status utente 
 * box chiamato tramite load con:
 * data: {data,typeCurrentUser}, 
 * 
 * 
 */
?>
<!------------------------------------------- STATUS ----------------------------------->
<div id="social-status">
	<div class="row">
		<div class="small-8 columns">			
			<h3><strong><?php echo $event->getReviewCounter(); ?> review</strong></h3>
		</div>
		<div class="small-4 columns">
			<p class="grey" style="float: right;">Spotter Rating</p>		
			<form id="rating" style="float: right;">
			    <input class="star required" type="radio" name="test-1-rating-5" value="1" checked="checked"/>
			    <input class="star" type="radio" name="test-1-rating-5" value="2" checked="checked"/>
			    <input class="star" type="radio" name="test-1-rating-5" value="3" checked="checked"/>
			    <input class="star" type="radio" name="test-1-rating-5" value="4"/>
			    <input class="star" type="radio" name="test-1-rating-5" value="5"/>
			</form>
		</div>
	</div>
	
	<div class="row">
		<div  class="large-12 columns"><div class="line"></div></div>
	</div>
	
	<div class="row recordReview-propriety">
		<div class="box-propriety">
			<div class="small-7 columns ">
				<a class="note grey" onclick="love()">Love</a>
				<a class="note grey" onclick="setCounter()">Comment</a>
				<a class="note grey" onclick="share()">Share</a>
			</div>
			<div class="small-5 columns propriety ">					
				<a class="icon-propriety _unlove grey"><?php echo $event->getLoveCounter(); ?></a>
				<a id="commentCounter" class="icon-propriety _comment"><?php echo $event->getCommentCounter(); ?></a>
				<a class="icon-propriety _share"><?php echo $event->getShareCounter(); ?></a>
			</div>	
		</div>		
	</div>
	
	<div class="row">
		<div  class="large-12 columns"><div class="line"></div></div>
	</div>
</div>

<div class="row ">
	<div  class="large-12 columns">
	<div class="status-button">
		<a href="#" class="button bg-orange"><div class="icon-button _follower_status">Add a review</div></a>
	</div>
	</div>
</div>
