<?php

error_reporting(E_ERROR | E_PARSE);

//"session_start()" will start new or resume existing session

     session_start();

   

    $link = mysqli_connect("localhost", "root", "", "twitter"); 

//The mysqli_connect_errno() function returns the error code from the last connection error, if any.
//If there is a error in "mysqli_conncet" so print the "mysqli_connect_error"(so print the error) and the exit the script

    if (mysqli_connect_errno()) {
        
        print_r(mysqli_connect_error());
        exit();
        
    }

//if the GET variable funtion is equal to logout then unset all out session variables (Free all session variables)

    if ($_GET['function'] == "logout") {
        
        session_unset();
        
    }

// this function will show the time the tweet was posted(in our case), like 4seconds ago or 5 mins ago or something like tihs

    function time_since($since) {
    $chunks = array(
        array(60 * 60 * 24 * 365 , 'year'),
        array(60 * 60 * 24 * 30 , 'month'),
        array(60 * 60 * 24 * 7, 'week'),
        array(60 * 60 * 24 , 'day'), 
        array(60 * 60 , 'hour'),
        array(60 , 'min'),
        array(1 , 'sec ')
    );

    for ($i = 0, $j = count($chunks); $i < $j; $i++) {
        $seconds = $chunks[$i][0];
        $name = $chunks[$i][1];
        if (($count = floor($since / $seconds)) != 0) {
            break;
        }
    }

    $print = ($count == 1) ? '1 '.$name : "$count {$name}s";
    return $print;
}


//we created the "displayTweets" function and we gave the value of "type"
// so if type is equal to public than we created a variable called "whereClause" and we left it empty


    function displayTweets($type) {
        
//we need to be able to acces the link var inside this function
        
        global $link; 
        
       if ($type == 'public') {
           
           $whereClause = "";
           
       } else if ($type == 'isFollowing') {
           
    ///////////////////////////////////////////////////////////////////////// same as "actions.php - line 139"
            
           $query = "SELECT * FROM isFollowing WHERE follower = ". mysqli_real_escape_string($link, $_SESSION['id']);
           $result = mysqli_query($link, $query); 
           
           $whereClause = "";
           
           while ($row = mysqli_fetch_assoc($result)) {
               
               if ($whereClause == "") $whereClause = "WHERE";
               else $whereClause.= " OR";
               $whereClause.= " userid = ".$row['isFollowing'];
               
           }
           
// this will check if type is equal to 'youtweets' page, if that's so then take all the tweets that have the same id with the user we're logged in and show them to 'yourtweets' page
           
       } else if ($type == 'yourtweets') {
           
            $whereClause = "WHERE userid = ". mysqli_real_escape_string($link, $_SESSION['id']);
           
// this will check if type is equal to 'search' page,
//if that's so we gotta show all the components showed in the 'q' (functions.php - line 197)
//The LIKE operator is used in a WHERE clause to search for a specified pattern in a column.           

           
       } else if ($type == 'search') {
           
            echo '<p>Showing search results for "'. mysqli_real_escape_string($link, $_GET['q']).'":</p>';
           
            $whereClause = "WHERE tweet LIKE '%". mysqli_real_escape_string($link, $_GET['q'])."%'";
           
       } else if (is_numeric($type)) {
           
//we create a var called "userQuery" so in this query we'll select  all from users table where id is equal to "$type"
           
           $userQuery = "SELECT * FROM users WHERE id = ".mysqli_real_escape_string($link, $type)." LIMIT 1";
            $userQueryResult = mysqli_query($link, $userQuery);
            $user = mysqli_fetch_assoc($userQueryResult);
           
// here we echo the email           
           
           echo "<h4>".mysqli_real_escape_string($link, $user['email'])."'s Tweets</h4>";
           
// and here we set the where clause where userid is equal to "$type"
           
           $whereClause = "WHERE userid = ". mysqli_real_escape_string($link, $type);
           
       }
        
//so in this case we select all from tweets table and than there we have our whereClause variable in other cases it will pickup only tweets from a particular user but now we want all the tweets so we dont need a whereclause at all but we'll keep it just in case
//"ORDER BY" set the ordering applied to the table by something, in this case we have 'datetime'
        
        $query = "SELECT * FROM tweets ".$whereClause." ORDER BY `datetime` DESC LIMIT 10";
        
//we set the result variable to "mysqli_query($link, $query)"
        
        $result = mysqli_query($link, $query); 
        
//The mysqli_num_rows() function returns the number of rows in a result set.
//and if "mysqli_num_rows($result)" is equal to 0(so there's no tweets) then we echo "There are no tweets to display"
        
        if (mysqli_num_rows($result) == 0) {
            
            echo "There are no tweets to display";
            
        } else {
            
// The while loop executes a block of code as long as the specified condition is true.
//so while row variable is equal to "mysqli_fetch_assoc($result)" then we insert query(s)
            
            while ($row = mysqli_fetch_assoc($result)) {
                
// we create a var called "userQuery" so in this query we'll select  all from users table where id is equal to userid
// we create another variable called "userQueryResult" and we set the value mysqli_query($link, $userQuery), mysqli_query function performs a query against the database so in that we put the link variable which is connection and the query we created earlier (userQuery), so that means the var called userQueryResult have the "userQuery" inside 
// and after all this we create another variable called "user" and we gave it a value of "userQueryResult" which hase the  userQuery inside and we fetch it in associative array
     
            $userQuery = "SELECT * FROM users WHERE id = ".mysqli_real_escape_string($link, $row['userid'])." LIMIT 1";
            $userQueryResult = mysqli_query($link, $userQuery);
            $user = mysqli_fetch_assoc($userQueryResult);
                
                
// this will show the time that the tweet was posted
                
                echo "<div class='tweet'><p><a href='?page=publicprofiles&userid=".$user['id']."'>".$user['email']." </a><span class='time'>".time_since(time() - strtotime($row['datetime']))." ago</span>:</p>";
                
                echo "<p>".$row['tweet']."</p>";
                
                echo "<p><a class='toggleFollow' data-userId='".$row['userid']."'>";
                
///////////////////////////////////////////////////////////////////////// 
                 
                $isFollowingQuery = "SELECT * FROM isFollowing WHERE follower = ". mysqli_real_escape_string($link, $_SESSION['id'])." AND isFollowing = ". mysqli_real_escape_string($link, $row['userid'])." LIMIT 1";
        
                $isFollowingQueryResult = mysqli_query($link, $isFollowingQuery);

                if (mysqli_num_rows($isFollowingQueryResult) > 0) {

                    echo "Unfollow";
                
                } else { 
                 
                    echo "Follow";
                    
                }
                 
                echo "</a></p></div>";
                
            }
        
        }
    
    }
    
    function  displaySearch() {
        
        echo '
        
        <div class="form-inline">
        
            <div class="form-group mb-2">
            
                <input type="hidden" name="page" value="search">
                
                <input type="text" name="q" class="form-control" id="search" placeholder="Search">
                
            </div>
            
            <button type="submit" class="btn btn-primary">Search Tweets</button>
             
        </div>';
        
        
    }

    function displayTweetBox() {
        
        if ($_SESSION['id'] > 0) {
            
            echo '
            
            <div id="tweetSuccess" class="alert alert-success">Your tweet was posted successfully.</div>
        
            <div id="tweetFail" class="alert alert-danger"></div>
        
        <div class="form">
        
            <div class="form-group mb-2">
         
                <textarea class="form-control" id="tweetContent" placeholder="Post a tweet"></textarea>
                
            </div>
  
            <button id="postTweetButton" class="btn btn-primary mb-2">Post Tweet</button>
            
        </div>';
            
            
        }
        
        
    }

    function displayUsers() {
        
        global $link;
        
        $query = "SELECT * FROM users LIMIT 10";
         
        $result = mysqli_query($link, $query); 
            
        while ($row = mysqli_fetch_assoc($result)) { 
            
            echo "<p><a href='?page=publicprofiles&userid=".$row['id']."'>".$row['email']."</a></p>";
            
        }
    
        
    }

















?>