<div class="row" id="uploadEvent01">
    <div  class="large-12 columns formBlack-title">
        <h2>Create a event</h2>												
    </div>	
</div>
<div class="row formBlack-body">
    <div  class="small-6 columns">
        <label for="eventTitle"><input type="text" name="eventTitle" id="eventTitle" pattern="" required/>
        Event title <span class="orange">*</span><small class="error"> Please enter a valid Title</small></label>


		<!--------------------------- UPLOAD IMAGE -------------------------------->
        <div class="row upload-box">
            <div  class="small-3 columns" id="tumbnail-pane">
                    <div class="thumbnail-box">
                        <div id="uploadImage_tumbnail-pane" class="uploadImage_tumbnail-pane">
                            <img id="uploadImage_tumbnail" name="uploadImage_tumbnail"/>
                        </div>
                    </div>
            </div>
            <div  class="small-9 columns">							        						
                <a  class="text orange" data-reveal-id="upload">Upload Image *</a>

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
                                    <div id="uploadImage_preview_box">
                                        <img src="" id="spotter_uploadImage_preview"/>
                                        <input type="hidden" id="spotter_x" name="crop_x" value="0"/>
                                        <input type="hidden" id="spotter_y" name="crop_y" value="0"/>
                                        <input type="hidden" id="spotter_w" name="crop_w" value="100"/>
                                        <input type="hidden" id="spotter_h" name="crop_h" value="100"/>
                                    </div>
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
		<!--------------------------- FINE UPLOAD IMAGE -------------------------------->
		<div class="row">
			 <div  class="small-8 columns">
			 	<input type="text" name="date" id="date" required pattern=""/>
        		<label for="date">Date <span class="orange">*</span><small class="error"> Please enter a valid Date</small></label>
			 	
			 </div>			
			 <div  class="small-4 columns">
        		<select name="hours" id="hours">
					
				</select>
        		<label for="hours">Hours </label>
			 </div>
		</div>
        
        <label for="url"><input type="text" name="url" id="url" required pattern="" placeholder="http://"/>
        Who is going to play? <span class="orange">*</span><small class="error"> Please enter a valid Url</small></label>
		
		<label for="venueName"><input type="text" name="venueName" id="venueName" required pattern="" />
        Venue Name <span class="orange">*</span><small class="error"> Please enter a valid Venue Name</small></label>

<!--		<label for="adress"><input type="text" name="adress" id="adress" required pattern=""/>
        Adress <span class="orange">*</span><small class="error"> Please enter a valid Adress</small></label>-->

        <label for="city"><input type="text" name="city" id="city" required pattern=""/>
        City <span class="orange">*</span><small class="error"> Please enter a valid City</small></label>

    </div>

    <div  class="small-6 columns">

        <label for="description">Description <span class="orange">*</span><small class="error"> Please enter a valid Description</small>		
        <textarea name="description" id="description"  maxlength="200" rows="100" required style="height: 155px; margin-bottom: 30px !important;"></textarea></label>		

        <label style="padding-bottom: 0px !important;">Select genre <span class="orange">*</span><small class="error"> Please enter a Genre</small></label>		
        <div id="tag-music"></div>
		
    </div>

</div>
<div class="row">
    <div  class="small-6 columns">
        <div class="note grey-light" style="padding-top: 50px;"><span class="orange">* </span> Mandatory fields</div>
    </div>	
    <div  class="small-6 columns" >
        <input type="submit" name="uploadEvent01-next" id="uploadEvent01-next" class="buttonNext" value="Create" style="float: right;"/>
    </div>	
</div>