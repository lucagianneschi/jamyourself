<div class="bg-white">
    <div class="row">
        <div class="large-12 columns">
            <div class="box-upload-review-event">
                <h3>Review</h3>
                <div class="row">
                    <div class="large-12 columns">
                        <div class="box">
                            <div class="row box-upload-title">
                                <div class="large-12 columns">
                                    <h2>Create a new review about...</h2>
                                </div>
                            </div>
                            <div class="row">
                                <div class="large-4 columns">
                                    <div class="sidebar">

                                        <div class="oggetto-review">

                                            <div class="row">
                                                <div class="small-3 columns ">
                                                    <div class="coverThumb"><img src="<?php echo $thumbnail?>" onerror="this.src='http://socialmusicdiscovering.com/media/images/default/defaultEventThumb.jpg'"></div>						
                                                </div>
                                                <div class="small-9 columns ">
                                                    <div class="row ">							
                                                        <div class="small-12 columns ">
                                                            <div class="sottotitle grey-dark"><?php echo $title ?></div>
                                                            <a class="ico-label _tag inline text grey"><?php echo $tagGenere ?></a>
                                                        </div>	
                                                    </div>	
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="large-12 columns"><div class="line"></div></div>
                                            </div>
                                            <div class="row">						
                                                <div class="small-3 columns ">
                                                    <div class="note grey">Rating</div>
                                                </div>
                                                <div class="small-9 columns ">
                                                    <?php
                                                    switch ($rating) {
                                                        case 0 :
                                                            ?>
                                                            <a class="icon-propriety _star-grey"></a>
                                                            <a class="icon-propriety _star-grey"></a>
                                                            <a class="icon-propriety _star-grey"></a>
                                                            <a class="icon-propriety _star-grey"></a>
                                                            <a class="icon-propriety _star-grey"></a>                                                    
                                                            <?php
                                                            break;
                                                        case 1 :
                                                            ?>
                                                            <a class="icon-propriety _star-orange"></a>
                                                            <a class="icon-propriety _star-grey"></a>
                                                            <a class="icon-propriety _star-grey"></a>
                                                            <a class="icon-propriety _star-grey"></a>
                                                            <a class="icon-propriety _star-grey"></a>                                                    
                                                            <?php
                                                            break;
                                                        case 2 :
                                                            ?>
                                                            <a class="icon-propriety _star-orange"></a>
                                                            <a class="icon-propriety _star-orange"></a>
                                                            <a class="icon-propriety _star-grey"></a>
                                                            <a class="icon-propriety _star-grey"></a>
                                                            <a class="icon-propriety _star-grey"></a>                                                                                                        
                                                            <?php
                                                            break;
                                                        case 3 :
                                                            ?>
                                                            <a class="icon-propriety _star-orange"></a>
                                                            <a class="icon-propriety _star-orange"></a>
                                                            <a class="icon-propriety _star-orange"></a>
                                                            <a class="icon-propriety _star-grey"></a>
                                                            <a class="icon-propriety _star-grey"></a>                                                                                                        
                                                            <?php
                                                            break;
                                                        case 4 :
                                                            ?>
                                                            <a class="icon-propriety _star-orange"></a>
                                                            <a class="icon-propriety _star-orange"></a>
                                                            <a class="icon-propriety _star-orange"></a>
                                                            <a class="icon-propriety _star-orange"></a>
                                                            <a class="icon-propriety _star-grey"></a>                                                       
                                                            <?php
                                                            break;
                                                        case 5 :
                                                            ?>
                                                            <a class="icon-propriety _star-orange"></a>
                                                            <a class="icon-propriety _star-orange"></a>
                                                            <a class="icon-propriety _star-orange"></a>
                                                            <a class="icon-propriety _star-orange"></a>
                                                            <a class="icon-propriety _star-orange"></a>                                                       
                                                            <?php
                                                            break;
                                                    }
                                                    ?>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row ">
                                            <div class="large-12 columns ">
                                                <div class="text orange">Performed by</div>
                                                <div class="row">
                                                    <div class="small-12 columns">
                                                        <div class="box-membre" id="">
                                                            <div class="row">
                                                                <div class="small-2 columns ">
                                                                    <div class="icon-header">
                                                                        <!--<img src="http://socialmusicdiscovering.com/media/images/default/defaultAvatarThumb.jpg" onerror="this.src='http://socialmusicdiscovering.com/media/images/default/defaultAvatarThumb.jpg'">-->
                                                                        <img src="<?php echo $authorThumbnail?>" onerror="this.src='http://socialmusicdiscovering.com/media/images/default/defaultAvatarThumb.jpg'">
                                                                    </div>
                                                                </div>
                                                                <div class="small-10 columns ">
                                                                    <div class="text grey-dark breakOffTest"><?php echo $author; ?></div>
                                                                </div>		
                                                            </div>	
                                                        </div>
                                                    </div>
                                                </div>	
                                            </div>								
                                        </div>
                                        <br> <br>
                                            <div class="row ">
                                                <div class="large-12 columns ">
                                                    <div class="text orange">Feauturing</div>
                                                    <div class="row">
                                                        <div class="small-12 columns">
                                                            <?php
                                                            if (is_array($featuringInfoArray) && count($featuringInfoArray) > 0) {
                                                            foreach ($featuringInfoArray as $featuringInfo) {
                                                                $featuringThumbnail = $featuringInfo->thumbnail;
                                                                $featuringUsername = $featuringInfo->username;
                                                                $featuringUserId = $featuringInfo->objectId;
                                                                ?>
                                                                <div class="box-membre" id="<?php echo $featuringUserId?>">
                                                                    <div class="row">
                                                                        <div class="small-2 columns ">
                                                                            <div class="icon-header">
                                                                                <img src="<?php echo $featuringThumbnail ?>" onerror="this.src='http://socialmusicdiscovering.com/media/images/default/defaultAvatarThumb.jpg'">
                                                                            </div>
                                                                        </div>
                                                                        <div class="small-10 columns ">
                                                                            <div class="text grey-dark breakOffTest"><?php echo $featuringUsername ?></div>
                                                                        </div>		
                                                                    </div>	
                                                                </div>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>	
                                            </div>								
                                        </div>

                                    </div>
                                </div>

                                <div class="large-6 large-offset-1 end columns">
                                    <div class="row">
                                        <div class="large-12 columns ">
                                            <h5>Write here your review</h5>
                                            <textarea></textarea>
                                        </div>
                                    </div>
                                    <div class="row rating">
                                        <div class="large-3 columns ">
                                            <h5>Your Rating</h5>
                                        </div>
                                        <div class="large-9 columns big-star">
                                            <a class="icon-propriety _star-orange-big" id="star_rating_1"></a>
                                            <a class="icon-propriety _star-orange-big" id="star_rating_2"></a>
                                            <a class="icon-propriety _star-orange-big" id="star_rating_3"></a>
                                            <a class="icon-propriety _star-grey-big" id="star_rating_4"></a>
                                            <a class="icon-propriety _star-grey-big" id="star_rating_5"></a>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <br><br>
                            <div class="row">
                                <div class="large-12">
                                    <input type="button" class="buttonNext" id="button_publish" value="Publish">
                                    <input type="hidden" id="record_id" value="<?php echo $uploadReviewController->recordId; ?>">

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-grey">