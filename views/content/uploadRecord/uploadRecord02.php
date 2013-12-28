<div class="row">
    <div  class="large-12 columns formBlack-title">
        <h2>Create a new album</h2>												
    </div>	
</div>
<div class="row formBlack-body">
    <div  class="small-6 columns">
        <input type="text" name="recordTitle" id="recordTitle" pattern="" required/>
        <label for="recordTitle">Album title <span class="orange">*</span><small class="error"> Please enter a valid Title</small></label>


		<!--------------------------- UPLOAD IMAGE -------------------------------->
        <div class="row upload-box">
            <div  class="small-3 columns" id="tumbnail-pane">
                    <div class="signup-image">
                        <div id="uploadImage_tumbnail-pane" class="uploadImage_tumbnail-pane">
                            <img id="uploadImage_tumbnail" name="uploadImage_tumbnail"/>
                        </div>
                    </div>
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
		
        <input type="text" name="label" id="label" pattern=""/>
        <label for="label">Label</label>

        <input type="text" name="urlBuy" id="urlBuy" pattern="" placeholder="http://"/>
        <label for="urlBuy">Buy album at</label>

        <input type="text" name="albumFeaturing" id="albumFeaturing" pattern="">
        <label for="albumFeaturing">Featuring</label>

        <input type="text" name="year" id="year" pattern=""/>
        <label for="year">Year</label>

        <input type="text" name="city" id="city" pattern=""/>
        <label for="city">City</label>

    </div>

    <div  class="small-6 columns">

        <label for="description">Description <span class="orange">*</span><small class="error"> Please enter a valid Description</small>		
        <textarea name="description" id="description" pattern="description" maxlength="200" rows="100" required style="height: 155px; margin-bottom: 30px !important;"></textarea></label>		

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