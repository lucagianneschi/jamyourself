<?php
$username = '';
$objectId = '';
if (isset($_SESSION['currentUser'])) {
    $currentUser = $_SESSION['currentUser'];
    $username = $currentUser->getUsername();
    $objectId = $currentUser->getObjectId();
}
?>
<footer id="footer" >
    <div id="footer-header">
	<div class="row">

	    <div class="large-2 columns hide-for-small" onclick="footerShow()">
		<div class="user grey"><?php echo $views['footer']['staytunedon']; ?></div>
	    </div>
	    <div class="large-5 small-6 columns" onclick="footerShow()">
		<a class="ico-label _facebook"></a>
		<a class="ico-label _twitter"></a>
		<a class="ico-label _google"></a>
		<a class="ico-label _youtube"></a>
		<a class="ico-label _web"></a>				
	    </div>

	    <div class="large-5 small-1 columns align-right">
		<div class="row">
		    <div class="large-1 small-1 columns" style="float: right; padding: 0px">
			<a class="ico-label _off" onclick="access(null, null, 'logout', null)"></a>
		    </div>
		    <div class="large-11 columns hide-for-small align-right" style="padding: 0px">						
			<div class="user"><a class="user" onclick="location.href = 'profile.php?user=<?php echo $objectId ?>'"><?php echo $username; ?></a></div>									
		    </div>		
		</div>						
	    </div>
	</div>
    </div>
    <div id="footer-body" class="no-display">
	<div class="row">
	    <div class="large-12 columns">					
		<br>	
		<div class="row">
		    <div class="small-3 columns">
			<h5><?php echo $views['footer']['aboutjam']; ?></h5>
			<a href="#"><?php echo $views['footer']['aboutus']; ?></a><br>
			<a href="#"><?php echo $views['footer']['virtualtour']; ?></a><br>
			<a href="#"><?php echo $views['footer']['CAREER']; ?></a><br>
			<a href="#"><?php echo $views['footer']['term_cond']; ?></a><br>
			<a href="#"><?php echo $views['footer']['licenses']; ?></a><br>
			<a href="#"><?php echo $views['footer']['pricing']; ?></a><br>
		    </div>
		    <div class="small-3 columns">
			<h5><?php echo $views['footer']['support']; ?></h5>
			<a href="#"><?php echo $views['footer']['guide']; ?></a><br>
			<a href="#"><?php echo $views['footer']['faq']; ?></a><br>
			<a href="#"><?php echo $views['footer']['plugin']; ?></a><br>
			<a href="#"><?php echo $views['footer']['refpolicy']; ?></a><br>
		    </div>	
		    <div class="small-3 columns">
			<h5><?php echo $views['footer']['resources']; ?></h5>							
			<a href="#"><?php echo $views['footer']['api']; ?></a><br>
			<a href="#"><?php echo $views['footer']['mobile']; ?></a><br>
			<a href="#"><?php echo $views['footer']['logos_badge']; ?></a><br>
			<a href="#"><?php echo $views['footer']['pressres']; ?></a><br>
			<a href="#"><?php echo $views['footer']['advres']; ?></a><br>
		    </div>	
		    <div class="small-3 columns">
			<h5><?php echo $views['footer']['contact']; ?></h5>
			<a href="#"><?php echo $views['footer']['abuse']; ?></a><br>
			<a href="#"><?php echo $views['footer']['writeus']; ?></a><br>
			<a href="#"><?php echo $views['footer']['newsletter']; ?></a>
		    </div>		
		</div>

	    </div>
	</div>
    </div>	
</footer>

</body>

</html>