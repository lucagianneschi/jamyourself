<?php
/* box status utente 
 * 
 */
 
$connectionService = new ConnectionService();
if(existsRelation($connectionService,'user', $_SESSION['id'], 'event', $event->getId(), 'LOVE')){
    $css_love = '_love orange';
    $text_love = $views['unlove'];
} else {
    $css_love = '_unlove grey';
    $text_love = $views['love'];
}
?>
<div id="social-status">
    <!-- div class="row">
	    <div class="small-8 columns">
		    <h3><strong><?php echo $event->getReviewcounter(); ?> <?php echo $views['review']; ?></strong></h3>
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
    </div -->

    <div class="row">
	<div  class="large-12 columns"><div class="line"></div></div>
    </div>

    <div class="row recordReview-propriety">
	<div class="box-propriety">
	    <div class="small-7 columns ">
		<a class="note grey" onclick="love(this, 'Event', '<?php echo $event->getId(); ?>', '<?php echo $_SESSION['id']; ?>');"><?php echo $text_love; ?></a>
		<a class="note grey" onclick="setCounter()"><?php echo $views['comm']; ?></a>
		<a class="note grey" onclick="share()"><?php echo $views['share']; ?></a>
	    </div>
	    <div class="small-5 columns propriety ">					
		<a class="icon-propriety <?php echo $css_love; ?>"><?php echo $event->getLovecounter(); ?></a>
		<a id="commentCounter" class="icon-propriety _comment"><?php echo $event->getCommentcounter(); ?></a>
		<a class="icon-propriety _share"><?php echo $event->getSharecounter(); ?></a>
	    </div>	
	</div>		
    </div>

    <div class="row">
	<div  class="large-12 columns"><div class="line"></div></div>
    </div>
</div>

<?php
if (strtoupper($_SESSION['type']) == 'SPOTTER') {
    ?>
    <div class="row ">
        <div  class="large-12 columns">
    	<div class="status-button">
    	    <a href="uploadReview.php?rewiewId=<?php echo $event->getId() ?>&type=Event" class="button bg-orange">
    		<div class="icon-button _follower_status"><?php echo $views['media']['addreview']; ?></div>
    	    </a>
    	</div>
        </div>
    </div>
    <?php
}