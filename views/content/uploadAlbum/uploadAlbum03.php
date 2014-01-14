<div class="row">
	<div  class="large-12 columns formBlack-title">
		<h2>Add photo to Photo Set Title</h2>										
	</div>	
</div>
<div class="row formBlack-body">
	<div  class="small-6 small-centered columns">
		
		<!--------------------------- UPLOAD IMAGE -------------------------------->
        <div class="row upload-box" id="upload-album">
            <div  class="small-3 columns" id="tumbnail-pane" >
                    <div class="signup-image">
                        <div id="uploadImage_tumbnail-pane" class="uploadImage_tumbnail-pane">
                            <img id="uploadImage_tumbnail" name="uploadImage_tumbnail"/>
                        </div>
                    </div>
            </div>
            <!-------------------------- Cliccando su questo div dovrebbe aprirsi la finestra per l'upload (oppure solo il nella scritta Add images) --------------------------------->
            <div  class="small-9 columns" style="padding: 5% !important;">							        						
                <a  class="sottotitle orange">Add images*</a></br>
				<a class="text grey">Select one or more images </br>and drag it here (Or click for upload)</a>         				
            </div>	
        </div>
		
	</div>
	
</div>

<div id="preview">
<!--  <p>No files selected!</p>-->
</div>
<div class="row">
	<div  class="small-5 columns">
		<div class="note grey-light" style="padding-top: 50px;"><span class="orange">* </span> Mandatory fields</div>
	</div>	
	<div  class="small-7 columns" >
		<a type="button" name="uploadAlbum03-next" id="uploadAlbum03-next" class="buttonOrange _check-button sottotitle" style="padding-right: 50px;"/>Ok</a>
	</div>	
</div>
<div id="uploadAlbum-listPhoto">
	<div class="row" style="margin-top: 40px">
		<div  class="large-12 columns"><div class="line"></div></div>
	</div>
	<div class="row">
		<div  class="large-12 columns formBlack-title">
			<h2>Uploaded photos</h2>										
		</div>	
	</div>
	<div class="row formBlack-body">		
		<table class="singlePhoto"> 
		  <tbody id="photolist">
		  </tbody>
		</table>
	</div>	
</div>
<div class="row">
	<div  class="small-6 columns">
		<div class="note grey-light" style="padding-top: 50px;"><span class="orange">* </span> Mandatory fields</div>
	</div>	
	<div  class="small-6 columns" >
		<input type="button" name="uploadAlbum03-publish" id="uploadAlbum03-publish" class="buttonNext" value="Publish" style="float: right;"/>
	</div>	
</div>