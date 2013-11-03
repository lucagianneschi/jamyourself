<div id="spotter-signup02" class="no-display">
    <div class="row">
        <div  class="large-12 columns signup-title">
            <h2>Tell us something about you:</h2>		
        </div>	
    </div>
    <div class="row signup-body">
        <div  class="small-6 columns">

            <div class="row signup-box-image">
                <div  class="small-3 columns signup-box-avatar">									
                    <div class="signup-image">
                        <div id="spotter_uploadImage_tumbnail-pane" class="uploadImage_tumbnail-pane">
                            <img src="resources/images/avatar-signup/spotter.png" id="spotter_uploadImage_tumbnail" name="spotter_uploadImage_tumbnail"/>
                        </div>
                    </div>
                </div>
                <div  class="small-9 columns signup-box-avatar-text">							        						
                    <a data-reveal-id="spotter-uploadImage" class="text orange">Upload Image</a>
                    <div id="spotter-uploadImage" class="reveal-modal uploadImage-reveal">
                        <div class="uploadImage" >
                            <div class="row">
                                <div  class="large-12 columns signup-title">
                                    <h2>Upload Image</h2>		
                                </div>	
                            </div>
                            <div class="row">
                                <div id="spotter_container" class="small-5 small-centered columns align-center">
                                    <div id="filelist">Upload not supported.</div>
                                    <br />
                                    <label class="uploadImage_file_label" for="spotter_uploadImage_file" id="spotter_uploadImage_file_label" style="width: 300px;">Select a file from your computer</label>
                                </div>
                            </div>
                            <div class="row">							
                                <div  class="small-10 small-centered columns align-center spotter_uploadImage_box-preview">
                                    <div id="spotter_uploadImage_preview_box">
                                        <img src="" id="spotter_uploadImage_preview"/>
                                        <input type="hidden" id="spotter_x" name="spotter_x" value="0"/>
                                        <input type="hidden" id="spotter_y" name="spotter_y" value="0"/>
                                        <input type="hidden" id="spotter_w" name="spotter_w" value="100"/>
                                        <input type="hidden" id="spotter_h" name="spotter_h" value="100"/>
                                    </div>											   		
                                </div>

                            </div>

                            <div class="row">							
                                <div  class="small-3 small-offset-9 columns">
                                    <input type="button" id="spotter_uploadImage_save" name="spotter_uploadImage_save" class="signup-button no-display uploadImage_save" value="Save" />
                                </div>
                            </div>
                        </div>
                    </div>							
                </div>	
            </div>
            <div class="row spotter-firstname-singup02">
                <div  class="small-12 columns">									
                    <input type="text" name="spotter-firstname" id="spotter-firstname" pattern="username" maxlength="50" />								
                    <label for="spotter-firstname" >First Name<small class="error"> Please enter a valid First Name</small></label>
                </div>							
            </div>
            <div class="row spotter-lastname-singup02">
                <div  class="small-12 columns">									
                    <input type="text" name="spotter-lastname" id="spotter-lastname" pattern="username" maxlength="50" />								
                    <label for="spotter-lastname" >Last Name<small class="error"> Please enter a valid Last Name</small></label>
                </div>							
            </div>
            <div class="row spotter-country-singup02">
                <div  class="small-12 columns">									
                    <input type="text" name="spotter-country" id="spotter-country" pattern="username" maxlength="50" required/>								
                    <label for="spotter-country" >Country <span class="orange">*</span><small class="error"> Please enter a valid Country</small></label>
                </div>							
            </div>
            <div class="row spotter-city-singup02">
                <div  class="small-12 columns">									
                    <input type="text" name="spotter-location" id="spotter-city" pattern="username" maxlength="50" required />					
                    <label for="spotter-city " class="inline">City <span class="orange">*</span><small class="error"> Please enter a valid City</small></label>

                    <a href="#" data-reveal-id="spotter-myModal" class="location-reveal text grey">Why do you ask me?</a>
                    <div id="spotter-myModal" class="reveal-modal">
                        <h3>Why do you ask me?</h3>					 
                        <p class="grey">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                        <a class="close-reveal-modal">&#215;</a>
                    </div>
                </div>							
            </div>

        </div>
        <div  class="small-6 columns">
            <h3>What kind of music do you like?</h3>
            <div class="row" style="padding-top: 30px">
                <div  class="small-12 columns">
                    <div class="label-signup-genre text grey-light">Select at least one genre (max 10)<span class="orange">*</span><small class="error"> Please select a genre</small></div>
                </div>	
            </div>
            <div class="row" >
                <div  class="small-12 columns">
                    <div class="signup-genre">

                    </div>
                </div>	
            </div>
        </div>
    </div>
    <div class="row">
        <div  class="small-3 small-offset-1 columns">
            <div class="note grey-light signup-note"><span class="orange">* </span> Mandatory fields</div>
        </div>	
        <div  class="small-8 columns">
            <input type="button" name="spotter-signup02-back" id="spotter-signup02-back" class="signup-button-back" value="Go Back"/>
            <input type="button" name="spotter-signup02-next" id="spotter-signup02-next" class="signup-button" value="Next"/>
        </div>	
    </div>	

</div>