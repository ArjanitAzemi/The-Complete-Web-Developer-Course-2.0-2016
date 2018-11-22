 <div class="container mainContainer">
    
    <div class="row">
        
      <div class="col-sm-8">
        
          <h2>Tweets for You</h2>
          
<!-- this will display only the twwets from the users that you are follwing -->
          
          <?php displayTweets('isFollowing'); ?>
        
        </div>
      <div class="col-sm-4">
        
        <?php displaySearch(); ?>
          
          <hr>
          
          <?php displayTweetBox(); ?>
        
        
        </div>
        
    </div>
    
</div>
