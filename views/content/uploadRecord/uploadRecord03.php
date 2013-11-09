<div class="row">
	<div  class="large-12 columns formBlack-title">
		<h2>Add song</h2>										
	</div>	
</div>
<div class="row formBlack-body">
	<div  class="small-6 columns">
		
		<input type="text" name="trackTitle" id="trackTitle" pattern="" required/>
		<label for="trackTitle">Song title <span class="orange">*</span><small class="error"> Please enter a valid Title</small></label>
		
		<div class="row upload-box">
			<div  class="small-3 columns">
				<img class="thumbnail" src="resources/images/uploadRecord/note.jpg" id="tumbnail" name="tumbnail"/>
			</div>
			<div  class="small-9 columns">							        						
				<a  class="text orange" id ="uploader_mp3_button">Upload an mp3 file *</a>										
			</div>	
		</div>
		<select name="trackFeaturing" id="trackFeaturing" pattern=""></select>
		<label for="trackFeaturing">Featuring<small class="error"> Please enter a valid Featuring</small></label>
	</div>
	<div  class="small-6 columns">
		<label style="padding-bottom: 0px !important;">Select genre <span class="orange">*</span><small class="error"> Please enter a Genre</small></label>		
		<div id="tag-musicTrack"></div>
	</div>	
</div>
<div class="row">
	<div  class="small-5 columns">
		<div class="note grey-light" style="padding-top: 50px;"><span class="orange">* </span> Mandatory fields</div>
	</div>	
	<div  class="small-7 columns" >
		<a type="button" name="uploadRecord03-next" id="uploadRecord03-next" class="buttonOrange _check-button sottotitle" style="padding-right: 50px;"/>Ok</a>
	</div>	
</div>
<div id="uploadRecord-listSong">
	<div class="row" style="margin-top: 40px">
		<div  class="large-12 columns"><div class="line"></div></div>
	</div>
	<div class="row">
		<div  class="large-12 columns formBlack-title">
			<h2>Uploaded song</h2>										
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
		<div class="note grey-light" style="padding-top: 50px;"><span class="orange">* </span> Mandatory fields</div>
	</div>	
	<div  class="small-6 columns" >
		<input type="button" name="uploadRecord03-publish" id="uploadRecord03-publish" class="buttonNext" value="Publish" style="float: right;"/>
	</div>	
</div>