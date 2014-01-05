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
					<div class="user grey"><?php echo $views['FOOTER']['STAYTUNEDON']; ?></div>
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
							<div class="user"><a class="user" onclick="location.href='profile.php?user=<?php echo $objectId ?>'"><?php echo $username; ?></a></div>									
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
							<h5><?php echo $views['FOOTER']['ABOUTJAM']; ?></h5>
							<a href="#"><?php echo $views['FOOTER']['ABOUTUS']; ?></a><br>
							<a href="#"><?php echo $views['FOOTER']['VIRTUALTOUR']; ?></a><br>
							<a href="#"><?php echo $views['FOOTER']['CAREER']; ?></a><br>
							<a href="#"><?php echo $views['FOOTER']['TERMSCONDITION']; ?></a><br>
							<a href="#"><?php echo $views['FOOTER']['LICENSES']; ?></a><br>
							<a href="#"><?php echo $views['FOOTER']['PRINCINGPOLICY']; ?></a><br>
						</div>
						<div class="small-3 columns">
							<h5><?php echo $views['FOOTER']['SUPPORT']; ?></h5>
							<a href="#"><?php echo $views['FOOTER']['GUIDE']; ?></a><br>
							<a href="#"><?php echo $views['FOOTER']['FAQ']; ?></a><br>
							<a href="#"><?php echo $views['FOOTER']['PLUGIN']; ?></a><br>
							<a href="#"><?php echo $views['FOOTER']['REFOUNDPOLICY']; ?></a><br>
						</div>	
						<div class="small-3 columns">
							<h5><?php echo $views['FOOTER']['RESOURCES']; ?></h5>							
							<a href="#"><?php echo $views['FOOTER']['API']; ?></a><br>
							<a href="#"><?php echo $views['FOOTER']['MOBILE']; ?></a><br>
							<a href="#"><?php echo $views['FOOTER']['LOGOSBADGE']; ?></a><br>
							<a href="#"><?php echo $views['FOOTER']['PRESRESOURCES']; ?></a><br>
							<a href="#"><?php echo $views['FOOTER']['ADVRESOURCES']; ?></a><br>
						</div>	
						<div class="small-3 columns">
							<h5><?php echo $views['FOOTER']['CONTACT']; ?></h5>
							<a href="#"><?php echo $views['FOOTER']['REPORTABUSE']; ?></a><br>
							<a href="#"><?php echo $views['FOOTER']['WRITEUS']; ?></a><br>
							<a href="#"><?php echo $views['FOOTER']['NEWSLETTER']; ?></a>
						</div>		
					</div>
					
				</div>
			</div>
		</div>	
	</footer>
	
</body>

</html>