
<!--   *** JQUERY *** -->
<script>
    document.write('<script src=' +
            ('__proto__' in {} ? 'resources/javascripts/plugins/vendor/zepto' : 'resources/javascripts/plugins/vendor/jquery') +
            '.js><\/script>')
</script>
<script src="resources/javascripts/plugins/jquery/jquery-1.8.3.min.js"></script>
<script src="resources/javascripts/plugins/jquery/jquery.easing.1.3.js"></script>	
<script src="resources/javascripts/plugins/jquery/jquery-ui-1.10.3.custom.min.js"></script>

<!--   /// JQUERY /// -->

<script src="resources/javascripts/plugins/foundation/foundation.js"></script>
<script src="resources/javascripts/plugins/foundation/foundation.section.js"></script>
<script src="resources/javascripts/plugins/foundation/foundation.clearing.js"></script>
<script src="resources/javascripts/plugins/foundation/foundation.reveal.js"></script>
<script src="resources/javascripts/plugins/foundation/foundation.abide.js"></script>

<script src="resources/javascripts/plugins/touchCarousel/jquery.touchcarousel-1.1.min.js"></script> 
<!--
<script src="javascripts/foundation/foundation.alerts.js"></script>

<script src="javascripts/foundation/foundation.cookie.js"></script>
<script src="javascripts/foundation/foundation.dropdown.js"></script>
<script src="javascripts/foundation/foundation.forms.js"></script>
<script src="javascripts/foundation/foundation.joyride.js"></script>
<script src="javascripts/foundation/foundation.magellan.js"></script>
<script src="javascripts/foundation/foundation.orbit.js"></script>
<script src="javascripts/foundation/foundation.placeholder.js"></script>
<script src="javascripts/foundation/foundation.reveal.js"></script>

<script src="javascripts/foundation/foundation.tooltips.js"></script>
<script src="javascripts/foundation/foundation.topbar.js"></script>
-->
<script>
    $(document).foundation();
</script>
<!-------------- plugin JCrop ------------>
<script type="text/javascript" src="resources/javascripts/plugins/jcrop/jquery.Jcrop.js"></script>  

<!----------- plugin nicescroll ---------->
<script type="text/javascript" src="resources/javascripts/plugins/nicescroll/jquery.nicescroll.js"></script>	
<!--------------- royalslider ------------->
<script src="resources/javascripts/plugins/royalslider/jquery.royalslider.min.js"></script>
<!--------------- colorbox ---------------->
<script src="resources/javascripts/plugins/colorbox/jquery.colorbox.js"></script>
<!--------------- scrollbar --------------->
<script src="resources/javascripts/plugins/scrollbar/jquery.mCustomScrollbar.js"></script>
<!--------------- spinner ----------------->
<script type="text/javascript" src="http://fgnass.github.io/spin.js/dist/spin.js"></script>
<!--------------- plupload ---------------->
<script src="resources/javascripts/plugins/plupload/plupload.full.min.js"></script>
<!----------- JAMYOURSELF --------------->
<script type="text/javascript" src="resources/javascripts/customs/layout.js"></script>

<script type="text/javascript" src="resources/javascripts/customs/headerCallBox.js"></script>

<script type="text/javascript" src="resources/javascripts/customs/player.js"></script>
<!--------------- FCBKAutocmplete ---------------->
<script src="resources/javascripts/plugins/FCBKcomplete/jquery.fcbkcomplete.min.js"></script>
<link rel="stylesheet" href="resources/javascripts/plugins/FCBKcomplete/style.css" type="text/css" media="screen" charset="utf-8" />

<!--------------- share ------------------->
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=ra-522dd258579a55ca"></script>
<script type="text/javascript" src="resources/javascripts/customs/share.js"></script>


<?php
switch (basename($_SERVER['PHP_SELF'])) {
    case "signup.php":
        ?>
        <!-- recatpcha -->
        <script src="http://www.google.com/recaptcha/api/js/recaptcha_ajax.js"></script>  
        <!-- signup -->
        <script type="text/javascript" src="resources/javascripts/customs/signup.js"></script>
        <?php
        break;
    case "login.php":
        ?>

        <?php
        break;
    case "profile.php":
        ?>
        <script type="text/javascript" src="resources/javascripts/customs/profile.js"></script>
        <script type="text/javascript" src="resources/javascripts/customs/profileCallBox.js"></script>
        <script type="text/javascript" src="resources/javascripts/customs/post.js"></script>
        <script type="text/javascript" src="resources/javascripts/customs/profileComment.js"></script>
        <script type="text/javascript" src="resources/javascripts/customs/love.js"></script>
        <?php
        break;
    case "mediaEvent.php":
        ?>
        <script type="text/javascript" src="resources/javascripts/customs/profile.js"></script>
        <script type="text/javascript" src="resources/javascripts/customs/mediaCallBox.js"></script>
		<script type="text/javascript" src="resources/javascripts/customs/mediaComment.js"></script>
		<script type="text/javascript" src="resources/javascripts/customs/love.js"></script>
        <?php
        break;
    case "mediaRecord.php":
        ?>
        <script type="text/javascript" src="resources/javascripts/customs/profile.js"></script>
        <script type="text/javascript" src="resources/javascripts/customs/mediaCallBox.js"></script>
        <?php
        break;
    case "uploadRecord.php":
        ?>
        <script type="text/javascript" src="resources/javascripts/customs/uploadRecord.js"></script>
        <?php
        break;
    case "uploadReview.php":
        ?>
        <script type="text/javascript" src="resources/javascripts/customs/uploadReview.js"></script>
        <?php
        break;
}
?>
