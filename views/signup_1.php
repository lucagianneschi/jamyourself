<html>
    <head>
        <title>Home</title>

        <style type="text/css">
            .error {
                color: red;
            }

            .message {
                color: green;
            }

            #formlogin label.error {
                margin-left: 10px;
                width: auto;
                display: inline;
                color: red;
            }
        </style>

    </head>
    <body>
        <!-- div di avviso  -->
        <div id="error" class='error'></div>
        <div id="message" class='message'></div>

        <!-- STEP 1 -->
        <div id="container" style="width:50%; padding-left: 100px">
            <div id="step1" style="padding-left:35% ">
                <h3>Step 1</h3>

                <h2>Sign up as: </h2>

                <div id="spotter_profile" style="float:left; margin: 5px 5px 5px 5px;">
                    <img  alt="Immagine Spotter" height="100" width="100" src="./img/spotter.jpg"></img>     
                </div>    
                <div id="jammer_profile" style="float:left; margin: 5px 5px 5px 5px;">
                    <img alt="Immagine Jammer" height="100" width="100" src="./img/jammer.jpg"></img>     
                </div>    
                <div id="venue_profile" style="float:left; margin: 5px 5px 5px 5px;">
                    <img alt="Immagine Venue" height="100" width="100" src="./img/venue.jpg"></img>     
                </div>

                <div style="width:100px; padding-left: 145px">
                    <button class="next_step">Next</button>
                </div>

            </div>
            <!-- fine step 1 -->

            <!-- STEP 2 -->
            <div id="step2" style="padding-left:35% ; display:none ">
                <h3>Step 2</h3>

                <h2>Fill the form: </h2>

                <div id="div_username" style="width:100px; padding-left: 90px">
                    <input type="text" id="username" placeholder="username">
                </div>

                <div id="div_password" style="width:100px; padding-left: 90px">
                    <input type="password" id="password" placeholder="password">
                </div>

                <div id="div_verify" style="width:100px; padding-left: 90px">
                    <input type="password" id="verify" placeholder="verify password">            
                </div>

                <div id="div_email" style="width:100px; padding-left: 90px">
                    <input type="email" id="email" placeholder="email">          
                </div>

                <div id="div_captcha" style="width:100px; padding-left: 90px">
                    captcha         
                </div>

                <div style=" padding-left: 120px">
                    <button class="prev_step">Prev</button>
                    <button class="next_step">Next</button>
                </div>

            </div>      


            <!-- fine step 2 -->

            <!-- STEP 3 -->
            <div id="step3" style="padding-left:35% ; display:none ">
                <h3>Step 3</h3>

                <h2>Tell us something about you: </h2>
                <div id="img_profile" style="float:right;">

                    <img  alt="Immagine Profilo" height="100" width="100" src="./img/profile.jpg" ></img>  
                    <br/><br/>
                    <input type="file">
                </div>  

                <div id="div_firstname" style=" padding-left: 90px; float:left;">
                    <input type="text" id="firstname" placeholder="first name">
                </div>

                <div id="div_lastname" style="padding-left: 90px; float:left;">
                    <input type="text" id="lastname" placeholder="last name">
                </div>

                <div id="div_address" style=" padding-left: 90px; float:left;">
                    <input type="text" id="address" placeholder="where do you live?">
                </div>     



                <div style="float:left; width:100%">
                    <i>What kind of music do you like?</i>
                    <br/>
                    <br/>
                    <div id="music" >
                        <img  alt="music" src="./img/music.jpg"></img>     
                    </div>            

                </div>

                <div style="float:left; padding-left: 120px">
                    <button class="prev_step">Prev</button>
                    <button class="next_step">Next</button>
                </div>

            </div>    

            <!-- STEP 4 -->
            <div id="step4" style="padding-left:35% ; display:none ">
                <h3>Step 4</h3>

                <h2>Want to Tell us more about you? </h2>

                <div>
                    <textarea rows="5" cols="40" placeholder="Let everybody know about you and the music you like"></textarea>
                </div>
                <div>
                    <fieldset style="border:none">
                        <input type="radio" name="sex" value="M"/>M 
                        <input type="radio" name="sex" value="F" style="margin-left: 20px;"/> F  
                        <input type="radio" name="sex" checked value="ND" style="margin-left: 20px;"/>Don't want to declare 
                    </fieldset>
                </div>

                <div>
                    <label for="birthday">Date of birth<input type="date"> </label>
                </div>

                <div>
                    <label for="social">
                    <fieldset style="border:none">
                        <div style="float: left">I'm also on: </div>
                        <img src="https://fbstatic-a.akamaihd.net/rsrc.php/yl/r/H3nktOa7ZMg.ico" alt="logo_facebook" style='width:30px; height:30px; float: left'/>
                        <img src="https://abs.twimg.com/favicons/favicon.ico" alt="logo_twitter" style="margin-left: 10px;width:30px; height:30px; float: left"/>  
                        <img src="http://s.ytimg.com/yts/img/favicon-vfldLzJxy.ico" alt="logo_youtube" style="margin-left: 10px;width:30px; height:30px; float: left"/>
                        <img src="./img/web.png" alt="logo_webpage" style="margin-left: 10px;width:30px; height:30px; float: left"/>
                    </fieldset>             
                    
                    
                    </label>
                </div>
                
                <div>
                    <input type="url" name="url" autocomplete="on" placeholder="URL of your Facebook profile/" size="60">
                </div>

                <div style=" padding-left: 120px">
                    <button class="prev_step">Prev</button>
                    <button class="complete">Complete</button>
                </div>

            </div>   
        </div>

        <!-- 	Inclusione javascript -->
        <script type="text/javascript" src="./scripts/jquery-min.js"></script>
        <script type="text/javascript" src="./scripts/jquery.validate.js"></script>
        <script type="text/javascript" src="./scripts/signup.js"></script>

    </body>
</html>