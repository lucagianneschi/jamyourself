<?php
/* box status utente 
 * box chiamato tramite load con:
 * data: {data,typeCurrentUser}, 
 * 
 * 
 */

 if (!defined('ROOT_DIR'))
	define('ROOT_DIR', '../../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php'; 
 
 $data = $_POST['data'];
 $currentUserType = $_POST['typeCurrentUser'];

 $status_level = $data['level'];
 $status_namelevel = $data['levelValue'];
 $userType = $data['type'];

 //achievement array -------- DA DEFINIRE -----------------
 $status_achievement1 = '_target1';
 $status_achievement2 = '_target2';
 $status_achievement3 = '_target3';
?>
<!------------------------------------------- STATUS ----------------------------------->

<script src='resources/javascripts/plugins/rating/jquery.rating.js' type="text/javascript" language="javascript"></script>

<div id="social-status">
	<div class="row">
		<div class="small-8 columns">			
			<h3><strong>4 review</strong></h3>					
		</div>
		<div class="small-4 columns">
			<p class="grey">Spotter Rating</p>		
			<form id="rating">
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
				<a class="icon-propriety _unlove grey">72</a>
				<a class="icon-propriety _comment">0</a>
				<a class="icon-propriety _share">0</a>
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
