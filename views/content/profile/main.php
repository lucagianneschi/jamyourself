<?php

$userType = $_GET['userType'];
$currentUserType = $_GET['currentType'];

?>
<div class="bg-double">	
		<div id='scroll-profile' class='hcento' style="width: 50%;float: left;">						
			<div id="profile" style="max-width:500px; float:right">
				<div class="row">
					<div class="large-12 columns">
						<div id='box-userinfo' ></div>	
						<div id='box-information' ></div>
						<div id="box-record"></div>
						<div id='box-event' ></div>	
						<div id='box-friends' ></div>	
						<div id='box-following' ></div>	
						<div id='box-album' ></div>
					</div>
				</div>
			</div>
		</div>
		<div id='scroll-social' class='hcento' style="width: 50%;float: right;">
			<div id="social" style="max-width:500px; float:left">
				<div class="row">
					<div class="large-12 columns">
						<div id='box-status' ></div>
						<div id="box-recordReview"></div>	
						<div id="box-recordEvent"></div>	
						<div id="box-activity"></div>
						<div id="box-collaboration"></div>
						<div id="box-followers"></div>
						<div id="box-post"></div>
					</div>
				</div>			
			</div>
		</div>	
	</div>		
</div>