<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');
require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
?>
<!DOCTYPE HTML>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--><html class="no-js"><!--<![endif]-->
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale = 1.0, user-scalable = no">
	<title><?php echo HOME_TITLE; ?></title>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,600' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="resources/stylesheets/normalize.css" type="text/css" media="screen">
	<link rel="stylesheet" href="resources/stylesheets/grid.css" type="text/css" media="screen">
	<link rel="stylesheet" href="resources/stylesheets/home.css" type="text/css" media="screen">
	<!----------------- colorbox ---------------------------->
	<link rel="stylesheet" href="resources/stylesheets/plugins/colorbox/colorbox.css"></link>
	<!-- <link rel="stylesheet" href="css/style.min.css" type="text/css" media="screen"> -->
	<!--[if IE]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    </head>

    <body>
	<div id="logo" onclick="scrollto('top');"><img src="resources/images/home/logo.png" alt ="Jamyourself: Meritocratic Social Music Discovering"></div>
	<div class="menu">
	    <div class="facebook" onclick="window.open('<?php echo FACEBOOK; ?>');"></div>
	    <div class="twitter" onclick="window.open('<?php echo TWITTER; ?>');"></div>
	<!--<div class="blog" onclick="window.open('<?php echo BLOG; ?>')" ><?php echo $views['home']['blog']; ?></div>-->
	    <div class="subscribe" onclick="scrollto('subscribe');"><?php echo $views['home']['subscribe']; ?></div>
	    <div class="login"><a class="loginLB" href="#login_content"><?php echo $views['home']['login']; ?></a></div>

	</div>
	<div style="display: none">
	    <div id="login_content">
		<div id="title">LOGIN</div>
		<form action="javascript:access($('#user').val(), $('#pass').val(), 'login', null)">
		    <div class="loginInput">
			<input type="text" id="user" placeholder="username" /><br />
			<input type="password" id="pass" placeholder="password" /><br />
			<input type="submit" value="Login" style="width: 205px;"/>
		    </div>				

		</form>
	    </div>
	</div>
	<div id="top" class="slide top" data-stellar-background-ratio="0.7">
	    <div class="container clearfix">

		<div class="grid_12">
		    <img src="resources/images/home/logo-big.png" alt ="Jamyourself: Meritocratic Social Music Discovering">
		    <h1><?php echo $views['home']['stand_out']; ?></h1>
		    <h2><?php echo $views['home']['be_the_first']; ?><br><?php echo $views['home']['and_take']; ?></h2>
		</div>

	    </div>
	</div>

	<div id="start" class="slide spot-slide" data-stellar-background-ratio="0.3">
	    <div class="container clearfix">
		<div class="grid_1">&nbsp;</div>
		<div class="grid_5">
		    <img src="resources/images/home/rank-spot.png" alt>
		    <h2><?php echo $views['home']['top']; ?></h2>
		    <p><?php echo $views['home']['points']; ?><br><?php echo $views['home']['best']; ?></p>
		</div>
		<div class="grid_5">
		    <img src="resources/images/home/badge-spot.png" alt>
		    <h2><?php echo $views['home']['talents']; ?></h2>
		    <p><?php echo $views['home']['badge']; ?><br><?php echo $views['home']['worth']; ?></p>
		</div>
		<div class="grid_1 omega">&nbsp;</div>
	    </div>
	</div>

	<div class="slide spot-link" data-stellar-background-ratio="0.7">
	    <div class="container clearfix">
		<div class="grid_4">
		    <div class="spot" onclick="scrollto('spotter');">
			<img src="resources/images/home/spotter-spot.png" alt>
			<h2><?php echo $views['home']['are_you']; ?><br><?php echo $views['home']['music_lover']; ?></h2>
		    </div>
		</div>
		<div class="grid_4">
		    <div class="spot" onclick="scrollto('jammer');">
			<img src="resources/images/home/jammer-spot.png" alt>
			<h2><?php echo $views['home']['are_you']; ?><br><?php echo $views['home']['emerging_artist']; ?></h2>
		    </div>
		</div>
		<div class="grid_4 omega">
		    <div class="spot" onclick="scrollto('venue');">
			<img src="resources/images/home/venue-spot.png" alt>
			<h2><?php echo $views['home']['own']; ?><br><?php echo $views['home']['venue']; ?></h2>
		    </div>
		</div>
	    </div>
	</div>

	<div class="slide slide-img" style="background-image: url(resources/images/home/1.jpg)" data-slide="2" data-stellar-background-ratio="0.5"></div>


	<div class="slide" id="jammer" data-stellar-background-ratio="0.7">
	    <div class="container clearfix">

		<div class="grid_5 jam-user">
		    <img src="resources/images/home/jammer.png" alt>
		</div>
		<div class="grid_6 omega">
		    <h1><?php echo $views['home']['cool']; ?><br><?php echo $views['home']['sing']; ?></h1>
		    <h2><?php echo $views['home']['star']; ?></h2>
		    <p><?php echo $views['home']['start_sharing1']; ?><br><?php echo $views['home']['start_sharing2']; ?></p>
		</div>

	    </div>
	</div>

	<div class="slide slide-img" style="background-image: url(resources/images/home/2.jpg)" data-slide="2" data-stellar-background-ratio="0.5"></div>


	<div class="slide" id="spotter" data-stellar-background-ratio="0.7">
	    <div class="container clearfix">

		<div class="grid_5 jam-user">
		    <img src="resources/images/home/spotter.png" alt>
		</div>
		<div class="grid_6 omega">
		    <h1><?php echo $views['home']['you_told']; ?><br><?php echo $views['home']['before']; ?></h1>
		    <h2><?php echo $views['home']['talent_scout']; ?></h2>
		    <p><?php echo $views['home']['next_star']; ?></p>
		</div>

	    </div>
	</div>

	<div class="slide slide-img" style="background-image: url(resources/images/home/3.jpg)" data-slide="2" data-stellar-background-ratio="0.5"></div>

	<div class="slide" id="venue" data-stellar-background-ratio="0.7">
	    <div class="container clearfix">

		<div class="grid_5 jam-user">
		    <img src="resources/images/home/venue.png" alt>
		</div>
		<div class="grid_6 omega">
		    <h1><?php echo $views['home']['tomorrow']; ?><br><?php echo $views['home']['remember']; ?></h1>
		    <h2><?php echo $views['home']['venue_start']; ?></h2>
		    <p><?php echo $views['home']['find_next']; ?></p>
		</div>

	    </div>
	</div>

	<div class="slide footer" id="subscribe" data-stellar-background-ratio="0.5">
	    <div class="container clearfix">
		<div class="grid_1">&nbsp;</div>
		<div class="grid_5">
		    <h2><?php echo $views['home']['subscribe_lc']; ?></h2>
		    <p><?php echo $views['home']['private_beta1']; ?><br><?php echo $views['home']['private_beta2']; ?><br>
			<a href="#"><?php echo $views['home']['key']; ?></a>
		    </p>
		</div>
		<div class="grid_5">
		    <form action="javascript:subscribe()">
			<input placeholder="yourname@mail.com" type="email" id="mail"/>
			<input type="submit" name="submit" value="<?php echo $views['send']; ?>" id="submit" />
		    </form>
		</div>
		<div class="grid_1 omega">&nbsp;</div>
	    </div>
	</div>

	<div class="slide footer" data-stellar-background-ratio="0.5">
	    <div class="container clearfix">
		<div class="grid_1">&nbsp;</div>
		<div class="grid_10" style="text-align: center">
		    <p>Jamyourself &copy; 2014 &middot; <a href="mailto:info@jamyourself.com">info@jamyourself.com</a><br>
		    </p>
		</div>
		<div class="grid_1 omega">&nbsp;</div>
	    </div>
	</div>

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript" src="resources/javascripts/plugins/jquery/jquery.stellar.min.js"></script>
	<script type="text/javascript" src="resources/javascripts/plugins/jquery/waypoints.min.js"></script>
	<script type="text/javascript" src="resources/javascripts/plugins/jquery/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="resources/javascripts/customs/home.js"></script>
	<!----------- colorbox // lightbox foto ---------------------------------------------------->
	<script type="text/javascript" src="resources/javascripts/plugins/colorbox/jquery.colorbox.js"></script>
	<script>
	    function scrollto(id)
	    {
		$('html,body').animate({scrollTop: $('#' + id).offset().top - 140}, 800);
	    }
	    ;

	    $(window).scroll(function() {
		scrollPosition = $(window).scrollTop();
		if (scrollPosition <= 590) {
		    //$("#logo").animate({ top: "-120" }, 800 );
		    $("#logo").fadeOut('fast');
		} else {
		    //$("#logo").animate({ top: "0" }, 800 );
		    $("#logo").fadeIn();
		}


	    });
	    $(document).ready(function() {
		$(".loginLB").colorbox({inline: true, width: "30%"});
	    });
	</script>

    </body>
</html>