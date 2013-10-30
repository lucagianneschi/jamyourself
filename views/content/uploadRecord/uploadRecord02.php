<div class="row">
	<div  class="large-12 columns formBlack-title">
		<h2>Create a new album</h2>												
	</div>	
</div>
<div class="row formBlack-body">
	<div  class="small-6 columns">
		<input type="text" name="albumTitle" id="albumTitle" pattern="" required/>
		<label for="albumTitle">Album title <span class="orange">*</span><small class="error"> Please enter a valid Title</small></label>
		

                
		<div class="row upload-box">
			<div  class="small-3 columns">
				<img class="thumbnail" src="" id="tumbnail" name="tumbnail"/>
			</div>
			<div  class="small-9 columns">							        						
				<a  class="text orange" data-reveal-id="upload">Upload Image</a>
				
				<div id="upload" class="reveal-modal upload-reveal">
					
					<div class="row">
						<div  class="large-12 columns formBlack-title">
							<h2>Upload Image</h2>		
						</div>	
					</div>
					<div class="row">							
						<div  class="large-12 columns formBlack-title">                                                                                                           	
                                                    <a class="buttonOrange _add sottotitle" id="uploader_img_button">Select a file from your computer</a>			
                                                </div>
                                           
					</div>
					<div class="row">							
						<div  class="small-10 small-centered columns align-center">							
								<img src="" id="uploadImage_preview" name="uploadImage_preview"/>
						    	<input type="hidden" id="jammer_x" name="jammer_x" value="0"/>
								<input type="hidden" id="jammer_y" name="jammer_y" value="0"/>
								<input type="hidden" id="jammer_w" name="jammer_w" value="100"/>
								<input type="hidden" id="jammer_h" name="jammer_h" value="100"/>																	   		
						</div>
						
					</div>
					
					<div class="row">							
						<div  class="small-3 small-offset-9 columns">
							<input type="button" id="uploadImage_save" name="uploadImage_save" class="buttonNext no-display" value="Save"/>
						</div>
					</div>
					
				</div>							
			</div>	
		</div>
				
		<input type="text" name="label" id="label" pattern=""/>
		<label for="label">Label<small class="error"> Please enter a valid Label</small></label>
		
		<input type="text" name="urlBuy" id="urlBuy" pattern="" placeholder="http://"/>
		<label for="urlBuy">Buy album at<small class="error"> Please enter a valid Url</small></label>
		
		<input type="text" name="albumFeaturing" id="albumFeaturing" pattern=""/>
		<label for="albumFeaturing">Featuring<small class="error"> Please enter a valid Featuring</small></label>
		
		<input type="text" name="year" id="year" pattern=""/>
		<label for="year">Year<small class="error"> Please enter a valid Year</small></label>
		
		<input type="text" name="city" id="city" pattern=""/>
		<label for="city">City<small class="error"> Please enter a valid City</small></label>
		
	</div>
	
	<div  class="small-6 columns">
		
		<label for="description">Description <span class="orange">*</span><small class="error"> Please enter a valid Description</small></label>			
		<textarea name="description" id="description" pattern="description" maxlength="200" rows="100" required style="height: 155px; margin-bottom: 30px !important;"></textarea>	
		
		<label style="padding-bottom: 0px !important;">Select genre <span class="orange">*</span><small class="error"> Please enter a Genre</small></label>		
		<div id="tag-music"></div>
																
	</div>

</div>
<div class="row">
	<div  class="small-6 columns">
		<div class="note grey-light" style="padding-top: 50px;"><span class="orange">* </span> Mandatory fields</div>
	</div>	
	<div  class="small-6 columns" >
		<input type="button" name="uploadRecord02-next" id="uploadRecord02-next" class="buttonNext" value="Next" style="float: right;"/>
	</div>	
</div>