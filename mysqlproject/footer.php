<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
      
      <script type="text/javascript">
          
// We want this to be called when the "log in" button is clicked, we get it by it's ID, so when it's clicked we want a function tu run.
      
        $(".toggleForms").click(function() {
            
// The toggle() method toggles between hide() and show() for the selected elements.
// This method checks the selected elements for visibility. show() is run if an element is hidden. hide() is run if an element is visible - This creates a toggle effect, this method can also be used to toggle between custom functions.
            
            $("#signUpForm").toggle();
            $("#logInForm").toggle();
            
            
        });
          

          
          
      
      
      </script>

    <script type="text/javascript">
        
// this will update the diary field in database with content of text area 

        $('#diary').bind('input propertychange', function() {
                
                 $.ajax({
                  method: "POST",
                  url: "updatedatabase.php",
                  data: { content: $("#diary").val() }
                     
                    });
            
                });

    </script>
    
  </body>
</html>