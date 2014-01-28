<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
?>
<div class="bg-white">
    <div class="row">
        <div class="large-12 columns">
            <div class="box-upload-review-event">
                <h3><?php echo $views['uploadReview']['review']; ?></h3>
                <div class="row">
                    <div class="large-12 columns">
                        <div class="box">

                            <div class="row box-upload-title">
                                <div class="large-12 columns">
                                    <h2><?php echo $views['uploadReview']['create']; ?></h2>
                                </div>
                            </div>

                            <div class="row">
                                <div class="large-4 columns">
                                    <div class="sidebar">

                                        <div class="oggetto-review">

                                            <div class="row">
                                                <div class="small-3 columns ">
                                                	<a href="record.php?record=<?php echo $_GET["rewiewId"] ?>"><div class="coverThumb" style="cursor: pointer">
                                                		<img src="<?php echo $thumbnail ?>" onerror="this.src='<?php echo DEFEVENTTHUMB ?>'">
                                                	</div></a>
                                                </div>						
												<div class="small-9 columns ">
						    						<div class="row ">							
                                                        <div class="small-12 columns ">
                                                            <a href="record.php?record=<?php echo $_GET["rewiewId"] ?>"><div class="sottotitle grey-dark"><?php echo $title ?></div></a>
                                                            <a class="ico-label _tag inline text grey"><?php echo $tagGenere ?></a>
                                                        </div>	
						    						</div>	
												</div>
					    					</div>
                                            <div class="row">
                                                <div class="large-12 columns"><div class="line"></div></div>
                                            </div>
                                            <!--div class="row">						
                                                <div class="small-3 columns ">
						    						<div class="note grey"><?php echo $views['uploadReview']['rating']; ?></div>
                                                </div>
                                                <div class="small-9 columns ">
												    <?php /*
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
												    } */
												    ?>
                                                </div>
                                            </div-->
										</div>

										<div class="row ">
										    <div class="large-12 columns ">
												<div class="text orange"><?php echo $views['uploadReview']['performed']; ?></div>
												<div class="row">
												    <div class="small-12 columns">
												    	<a href="profile.php?user=<?php echo $authorObjectId ?>">
														<div class="box-membre">
														    <div class="row">
																<div class="small-2 columns ">
																    <div class="icon-header">
																		<img src="<?php echo $authorThumbnail ?>" onerror="this.src='<?php echo DEFAVATARSPOTTER; ?>'">
																    </div>
																</div>
																<div class="small-10 columns ">
																    <div class="text grey-dark breakOffTest"><?php echo $author; ?></div>
																</div>		
													    	</div>	
														</div>
														</a>
											    	</div>
												</div>	
										    </div>								
										</div>
										<br> <br>
										<div class="row ">
										    <div class="large-12 columns ">
												<div class="text orange"><?php echo $views['uploadReview']['featuring']; ?></div>
												<div class="row">
												    <div class="small-12 columns">
														<?php
															if (is_array($uploadReviewController->reviewedFeaturing) && count($uploadReviewController->reviewedFeaturing) > 0) {
															    foreach ($uploadReviewController->reviewedFeaturing as $featuringUser) {
																switch ($featuringUser->getType()) {
																    case 'JAMMER':
																	$defaultThum = DEFTHUMBJAMMER;
																	break;
																    case 'VENUE':
																	$defaultThum = DEFTHUMBVENUE;
																	break;
																    case 'SPOTTER':
																	$defaultThum = DEFTHUMBSPOTTER;
																	break;
																}
																$featuringThumbnail = $featuringUser->getProfileThumbnail();
																$featuringUsername = $featuringUser->getUsername();
																$featuringUserId = $featuringUser->getObjectId();
															?>
															<a href="profile.php?user=<?php echo $authorObjectId ?>">
															<div class="box-membre" id="<?php echo $featuringUserId ?>">
															    <div class="row">
																	<div class="small-2 columns ">
																	    <div class="icon-header">
																			<img src="<?php echo $featuringThumbnail ?>" onerror="this.src='<?php echo $defaultThum ?>'">
																	    </div>
																	</div>
																	<div class="small-10 columns ">
																	    <div class="text grey-dark breakOffTest"><?php echo $featuringUsername ?></div>
																	</div>		
															    </div>	
															</div>
															</a>
															<?php
														    }
														}
														else{
														?>
														<div class="row">
															<div class="small-12 columns">
																<div class="text gray"><?php echo $views['uploadReview']['notfeaturing']; ?></div>
															</div>
														</div>
														<?php } ?>
												    </div>
												</div>	
										    </div>								
										</div>
					
									    </div>
									</div>

				<div class="large-6 large-offset-1 end columns">
				    <div class="row">
						<div class="large-12 columns ">
						    <h5><?php echo $views['uploadReview']['write']; ?></h5>
						    <textarea></textarea>
						</div>
					</div>
				    <div class="row rating">
						<div class="large-3 columns ">
						    <h5><?php echo $views['uploadReview']['your_rating']; ?></h5>
						</div>
						<div class="large-9 columns big-star">
						    <select id="example-f" name="rating">
				                <option value="1">1</option>
				                <option value="2">2</option>
				                <option value="3">3</option>
				                <option value="4">4</option>
				                <option value="5">5</option>
				            </select>
						</div>
			    	</div>
				</div>

			    </div>

			    <br><br>
			    <div class="row">
					<div class="large-12">
					    <input type="button" class="buttonNext" id="button_publish" value="<?php echo $views['publish']; ?>">
					    <input type="hidden" id="record_id" value="<?php echo $uploadReviewController->reviewedId; ?>">
					    <input type="hidden" id="type" value="<?php echo $uploadReviewController->reviewedClassType; ?>">
					</div>
			    </div>

			</div>
		    </div>
		</div>
	    </div>
	</div>
    </div>