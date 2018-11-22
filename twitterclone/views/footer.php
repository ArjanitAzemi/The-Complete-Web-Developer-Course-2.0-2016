<!--
The <footer> tag defines a footer for a document or section.
A <footer> element should contain information about its containing element.
A <footer> element typically contains:
-authorship information
-copyright information
-contact information
-sitemap
-back to top links
-related documents
You can have several <footer> elements in one document.
-->

        <footer class="footer">

            <div class="container">

                <p>&copy; Twitter Clone by Arjanit Azemi 2018</p>

            </div>

        </footer>

        <!-- Optional JavaScript -->
            <!-- jQuery first, then Popper.js, then Bootstrap JS -->
            <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

        <!-- Modal -->

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="loginModalTitle">Login </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                  <div class="alert alert-danger" id="loginAlert"></div>
                <form>
                        <input type="hidden" id="loginActive" name="loginActive" value="1">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" placeholder="Email address">
                  </div>
                  <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Password">
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <a class="btn btn-outline-primary my-2 my-sm-0" id="toggleLogin" >Sign up</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> 
                <button type="button" class="btn btn-primary" id="loginSignupButton">Login</button>
              </div>
            </div>
          </div>
        </div>

        <script>
            
//here we take the "toggleLogin" id and when we click it we gave it a founction to run
                
            $("#toggleLogin").click(function() {
                
// if the "loginActive" input has a value of 1 than that means we are in login mode, and so if that's the case we want to switch up into signup mode
                
               if ($("#loginActive").val() == "1") {
                   
// this will take the "loginActive" to 0, so we're not in loginActive mode anymore.
                   
                   $("#loginActive").val("0");
                   
// this will take the "loginModalTitle" by its id and will change that text to "SIGN UP".    

                   $("#loginModalTitle").html("Sign Up");
                   
// this will take the "loginSignupButton" and will change the html of that from "LOGIN" to "SIGNUP"                   

                   $("#loginSignupButton").html("Sign Up");
                   
//this will change the html of the button, so in the button it's a part of text "Sign up" so when we click that the html of that button will be changet to "Login".
                   
                   $("#toggleLogin").html("Login");
                   
               } else {
                   
                   $("#loginActive").val("1");
                   $("#loginModalTitle").html("Login");
                   $("#loginSignupButton").html("Login");
                   $("#toggleLogin").html("Sign up");
                   
               }
                
            });
            
// so when the button "loginSignupButton" is clicked we gave it a function to run
            
            $("#loginSignupButton").click(function() {
                
//AJAX is the art of exchanging data with a server, and update parts of a web page - without reloading the whole page.
//The jQuery get() and post() methods are used to request data from the server with an HTTP GET or POST request
//GET - Requests data from a specified resource
//POST - Submits data to be processed to a specified resource
//POST can also be used to get some data from the server. However, the POST method NEVER caches data, and is often used to send data along with the request.
//The url parameter is a string containing the URL you want to reach with the Ajax call.
//The "data" option provides the ability to add additional data to the request, or to modify the data object being submitted if required.
// dmth te data e bon email osht baras me (shkon e mer emailin n'databas,) njejt edhe per password, njejt dmth edhe te login active dmth e ka qit loginActive osht baras me(ktu dmth e kqyr se a osht loginActive a jo).
//"success" this function runs when the request succeeds

  $.ajax({

                    type: "POST",
                    url: "actions.php?action=loginSignup",
                    data: "email=" + $("#email").val() + "&password=" + $("#password").val() + "&loginActive=" + $("#loginActive").val(),
                    success: function(result) {
                        
// if the "result has the value of 1 then run the function
// The "location.assign()" method causes the window to load and display the document at the URL specified.


                        if (result == 1) {
                            
                                window.location.assign("http://twitterclone.com");
        
// if that does not work than find the #loginAlert than show the html of "result" 
            
                        } else {
                            
                           $("#loginAlert").html(result).show();
                            
                        }
                        
                    }
                    
             })
                            
          })
            
            
            
//  tihs will take the toggleFollow class and give it a click function so when we click it alert the attribute of userId
            
 $(".toggleFollow").click(function() {
     
//the attr() will get the value of an attribute for the first element in the set of matched elements or set one or more attributes for every matched element
    
     var id = $(this).attr("data-userId");
     
                $.ajax({

                    type: "POST",
                    url: "actions.php?action=toggleFollow",
                    data: "userId=" + id,
                    success: function(result) {
                        
//this is connected to "actions.php - line 149", so if the result is 1 than take all the "a" elements(links) by id's and than change the text(html) of that link to "Follow". So if we are following someone the texk on that "a" is "Unfollow" so that means if we click unfollow we are no loger following him and the "Unfollow" text will change to "Follow"
                        
                        if (result == 1) {
                            
                            $("a[data-userId='" + id + "']").html("Follow");
                            
//this is connected to "actions.php - line 157", so if the result is 2 than take all the "a" elements(links) by id's and than change the text (html) of that link to "Unollow". So if we are not following someone the text on that "a" is "Follow" so that means if we click follow we start following him and the "Follow" text will change to "Unfollow"
                            
                        } else if (result == 2) {
                            
                            $("a[data-userId='" + id + "']").html("Unfollow");
                          
                        }
                        
                    }
                    
                })
                    
            })
            
            
        $("#postTweetButton").click(function() {
            
            $.ajax({

                    type: "POST",
                    url: "actions.php?action=postTweet",
                    data: "tweetContent=" + $("#tweetContent").val(),
                    success: function(result) {
                        
//if the result is equal to 1 (which means that the tweet was send succesfully) then we take the "tweetSuccess" (it has the success message in it) and we show it. (functions.php - line 185) and we hide the "tweetFail" (it has the message that tweet failed) (functions-php - line 187)
                        
                        if (result == 1) {
                            
                            $("#tweetSuccess").show();
                            $("#tweetFail").hide();
                            
                        } else if (result != "" && result != 1) {
                            
// if the tweet is not empty but has something else except the "success tweet" message that show the "tweetFail" and hide the "tweetSuccess"                            
                            $("#tweetFail").html(result).show();
                            $("#tweetSuccess").hide();
                            
                        }
                        
                    }
                    
                })
            
        })
            
            
        </script>

    </body>

</html>