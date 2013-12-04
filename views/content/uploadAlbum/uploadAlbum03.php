<div class="row">
	<div  class="large-12 columns formBlack-title">
		<h2>Add photo to Photo Set Title</h2>										
	</div>	
</div>
<div class="row formBlack-body">
	<div  class="small-6 small-centered columns">
		
		<!--------------------------- UPLOAD IMAGE -------------------------------->
        <div class="row upload-box">
            <div  class="small-3 columns" id="tumbnail-pane" >
                    <div class="signup-image" style="height: 105px !important;">
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
		    <tr>
		      <td class="photo"><img class="boxphoto"  src="../media/images/image/<?php echo $value['filePath']; ?>" onerror="this.src='../media/<?php echo DEFIMAGE; ?>'"/></td>
		      <td class="info">
		      	<div class="row">
					<div  class="small-12 columns">
						<input type="text" name="descriptionPhoto" id="descriptionPhoto" pattern=""/>
        				<label for="descriptionPhoto">Describe this photo</label>										
					</div>	
				</div>
				<div class="row">
					<div  class="small-12 columns">
						<input type="text" name="featuringPhoto" id="featuringPhoto" pattern=""/>
        				<label for="featuringPhoto">Who is in this photo?</label>										
					</div>	
				</div>				
		      </td>		      
		      <td class="option">
		      	<div class="iscover">
		      		<span data-tooltip class="tip-top" title="Set as Cover">		      		
		      		<input type="radio" name="cover" id="idCover1" value="idCover1" class="no-display">
		      		<label for="idCover1"><div class="buttonIsCover"></div></label></span>
		      	</div>
		      	<div class="delete _delete-button"></div>
		      	
		      </td>
		    </tr>
             <tr>
		      <td class="photo"><img class="boxphoto"  src="../media/images/image/<?php echo $value['filePath']; ?>" onerror="this.src='../media/<?php echo DEFIMAGE; ?>'"/></td>
		      <td class="info">
		      	<div class="row">
					<div  class="small-12 columns">
						<input type="text" name="descriptionPhoto" id="descriptionPhoto" pattern=""/>
        				<label for="descriptionPhoto">Describe this photo</label>										
					</div>	
				</div>
				<div class="row">
					<div  class="small-12 columns">
						<input type="text" name="featuringPhoto" id="featuringPhoto" pattern=""/>
        				<label for="featuringPhoto">Who is in this photo?</label>										
					</div>	
				</div>				
		      </td>		      
		       <td class="option">
		      	<div class="iscover">
		      		<span data-tooltip class="tip-top" title="Set as Cover" style="top:-10px">		      		
		      		<input type="radio" name="cover" id="idCover2" value="idCover2" class="no-display">
		      		<label for="idCover2"><div class="buttonIsCover"></div></label></span>
		      	</div>
		      	<div class="delete _delete-button"></div>
		      	
		      </td>
		    </tr>
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