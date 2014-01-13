<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
?>
<div class="row">
    <div  class="large-12 columns formBlack-title">
	<h2><?php echo $views['uploadRecord']['add_song']; ?></h2>										
    </div>	
</div>
<div class="row formBlack-body">
    <div  class="small-6 columns">

	<input type="text" name="trackTitle" id="trackTitle" pattern="" required/>
	<label for="trackTitle"><?php echo $views['uploadRecord']['song_title']; ?><span class="orange">*</span><small class="error"><?php echo $views['uploadRecord']['valid_title']; ?></small></label>

	<div class="row upload-box">
	    <div  class="small-3 columns">
		<img class="thumbnail" src="resources/images/uploadRecord/note.jpg" id="tumbnail" name="tumbnail"/>
	    </div>
	    <div  class="small-9 columns">							        						
		<a  class="text orange" id ="uploader_mp3_button"><?php echo $views['uploadRecord']['mp3_upload']; ?></a>										
	    </div>	
	</div>
	<input type="text" name="trackFeaturing" id="trackFeaturing" pattern="">
	<label for="trackFeaturing"><?php echo $views['uploadRecord']['feat']; ?><small class="error"><?php echo $views['uploadRecord']['valid_feat']; ?></small></label>
    </div>
    <div  class="small-6 columns">
	<label style="padding-bottom: 0px !important;"><?php echo $views['uploadRecord']['select_genre']; ?><span class="orange">*</span><small class="error"><?php echo $views['uploadRecord']['enter_genre']; ?></small></label>		
	<div id="tag-musicTrack"></div>
    </div>	
</div>
<div class="row">
    <div  class="small-5 columns">
	<div class="note grey-light" style="padding-top: 50px;"><span class="orange">* </span><?php echo $views['mandatory_fields']; ?></div>
    </div>	
    <div  class="small-7 columns" >
	<a type="button" name="uploadRecord03-next" id="uploadRecord03-next" class="buttonOrange _check-button sottotitle" style="padding-right: 50px;"/>Ok</a>
    </div>	
</div>
<div id="uploadRecord-detail" class="no-display">
    <div id="uploadRecord-listSong">
	<div class="row" style="margin-top: 40px">
	    <div  class="large-12 columns"><div class="line"></div></div>
	</div>
	<div class="row">
	    <div  class="large-12 columns formBlack-title">
		<h2><?php echo $views['uploadRecord']['uploaded_song']; ?></h2>										
	    </div>	
	</div>
	<div class="row formBlack-body">		
	    <table class="singleSong"> 
		<tbody id="songlist">
<!--		    <tr>
		    <td class="title _note-button">Titolo Brano, ft Nome Jammer</td>
		    <td class="time">2:43</td>
		    <td class="genre">Genre: Ska, Rock</td>
		    <td class="delete _delete-button"></td>
		  </tr>
		  <tr>
		    <td class="title _note-button">Titolo Brano</td>
		    <td class="time">3:43</td>
		    <td class="genre">Genre: Rock</td>
		    <td class="delete _delete-button"></td>
		  </tr>-->
		</tbody>
	    </table>
	</div>	
    </div>
    <div class="row">
	<div  class="small-6 columns">
	    <div class="note grey-light" style="padding-top: 50px;"><span class="orange">* </span><?php echo $views['mandatory_fields']; ?></div>
	</div>	
	<div  class="small-6 columns" >
	    <input type="button" name="uploadRecord03-publish" id="uploadRecord03-publish" class="buttonNext" value="Publish" style="float: right;"/>
	</div>	
    </div>
</div>