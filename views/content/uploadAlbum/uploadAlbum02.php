<div class="row">
    <div  class="large-12 columns formBlack-title">
        <h2>Create a new Photo Set</h2>												
    </div>	
</div>
<div class="row formBlack-body">
    <div  class="small-6 columns">
        <input type="text" name="albumTitle" id="albumTitle" pattern="" required/>
        <label for="albumTitle">Photo set title <span class="orange">*</span><small class="error"> Please enter a valid Title</small></label>
	
        <input type="text" name="featuring" id="featuring" pattern=""/>
        <label for="featuring">Who is in this Photo Set?</label>

        <input type="text" name="city" id="city" pattern=""/>
        <label for="city">City</label>

    </div>

    <div  class="small-6 columns">
        <label for="description">Description <span class="orange">*</span><small class="error"> Please enter a valid Description</small>		
        <textarea name="description" id="description" pattern="description" maxlength="200" rows="100" required style="height: 155px; margin-bottom: 30px !important;"></textarea></label>		 
    </div>

</div>
<div class="row">
    <div  class="small-6 columns">
        <div class="note grey-light" style="padding-top: 50px;"><span class="orange">* </span> Mandatory fields</div>
    </div>	
    <div  class="small-6 columns" >
        <input type="button" name="uploadAlbum02-next" id="uploadAlbum02-next" class="buttonNext" value="Next" style="float: right;"/>
    </div>	
</div>