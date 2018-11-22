<?php 



  include("functions.php");

//The GET method sends the encoded user information appended to the page request. The page and the encoded information are separated by the ? character.
// we'll check to see if "$_GET variable ['action']" is equal to "loginSignup", that means we want a login or a signup but for now we wanna display all "POST" variables, which should then feedback to footer.php ("result").


    if ($_GET['action'] == "loginSignup") {
        
        $error = "";
        
// if there's no email then error "An email address is required".
        
        if (!$_POST['email']) {
            
          $error = "An email address is required.";  
            
// and if there's no passowrd then error "A password is required".
            
        } else if (!$_POST['password']) {
            
          $error = "A password is required.";
            
// this will check if the email address is valid, so if email validation is false then display a error
            
        } else if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
            
            $error = "Please enter a valid email address.";
            
        }
        
                    
// if error is not an empty string than echo error
                                         
        if ($error != "") {
            
         echo $error;
         exit();
            
        }

        
//The POST method transfers information via HTTP headers. The information is encoded as described in case of GET method and put into a header called QUERY_STRING.
//this will chck if the "loginActive" is 0 and if it is then run the query                            
                                         
        if ($_POST['loginActive'] == "0") {
            
// The "mysqli_real_escape_string()" function escapes special characters in a string for use in an SQL statement.
//The SELECT statement is used to select data from one or more tables, so it will Select Data From a MySQL Database
//The WHERE clause is used to filter records.
//The WHERE clause is used to extract only those records that fulfill a specified condition.
//MySQL provides a LIMIT clause that is used to specify the number of records to return.
//The LIMIT clause makes it easy to code multi page results or pagination with SQL, and is very useful on large tables. Returning a large number of records can impact on performance.
            
            $query = "SELECT * FROM users WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."' LIMIT 1";
            $result = mysqli_query($link, $query);
            
//This will check if there any "results" for this particular query
//The mysqli_num_rows() function returns the number of rows in a result set.
// And if that result is greater than 0 then error "That email address is already taken".
            
            if (mysqli_num_rows($result) > 0) { $error = "That email address is already taken."; 
                                              
            } else {
                
//The INSERT INTO statement is used to insert new records in a table.
// this query will insert the users info (email and password) into "users" table
                
                $query = "INSERT INTO users (`email`, `password`) VALUES ('".mysqli_real_escape_string($link, $_POST['email'])."','".mysqli_real_escape_string($link, $_POST['password'])."')";
                
                if (mysqli_query($link, $query)) {
                    
//$_SESSION is like a library that has a bunch of functions
//so the $_SESSION['id'] we gave the value of "mysqli_insert_id($link)"
                    
                    $_SESSION['id'] = mysqli_insert_id($link);
                    
// this query will hash the password in database
//The UPDATE statement is used to update existing records in a table
                    
                    $query = "UPDATE users SET password = '". md5(md5($_SESSION['id']).$_POST['password']) ."' WHERE id = ".$_SESSION['id']." LIMIT 1";
                    
                    mysqli_query($link, $query);
                    
                    echo 1;
                    
                } else {
                    
                    $error = "Couldn't create user - please try again later.";
                    
                }
                
            }
            
        } else {
            
            $query = "SELECT * FROM users WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."' LIMIT 1";
            $result = mysqli_query($link, $query);
            
//The mysqli_fetch_assoc() function fetches a result row as an associative array.
// we gave the "row" variable the value "mysqli_fetch_assoc($result)"
            
            $row = mysqli_fetch_assoc($result);
            
//so when the user try to login we gotta check "row" var which we created and the "password" from result to see if the password the user is typing is equal to the hashed password in database if that's so than echo 1
                
                if ($row['password'] == md5(md5($row['id']).$_POST['password'])) {
                    
                   echo 1;
                    
                    $_SESSION['id'] = $row['id'];
                    
                } else {
                    
                    $error = "Could not find that username/password combination. Please try again.";
                    
                } 
                
            }

                   
        if ($error != "") {
            
         echo $error;
         exit();
            
        }


    }

//we'll check to see if "$_GET variable ['action']" is equal to "toggleFolow",

    if ($_GET['action'] == 'toggleFollow') {
        
//this qyery will select all from 'isFollowing' table where the follower is our current user
        
        $query = "SELECT * FROM isFollowing WHERE follower = ". mysqli_real_escape_string($link, $_SESSION['id'])." AND isFollowing = ". mysqli_real_escape_string($link, $_POST['userId'])." LIMIT 1";
        
        $result = mysqli_query($link, $query);
        
        if (mysqli_num_rows($result) > 0) {
            
            $row = mysqli_fetch_assoc($result);
            
// this query will delete the specific user from the database or 'isFollowing' table, if we already are following some one and if we unfollow him/her, him/her will be deleted from 'isFollowing' table and if that so echo 1
            
            mysqli_query($link, "DELETE FROM isFollowing WHERE id = ". mysqli_real_escape_string($link, $row['id'])." LIMIT 1");
            
            echo "1";
              
        } else {
            
// this query will insert users in 'isFollowing' table, "(follower, isFollowing)" so if we follow a new user or a new user follows us, he will be inserted in 'isFollowing' tabble, and if that so echo 2
            
            mysqli_query($link, "INSERT INTO isFollowing (follower, isFollowing) VALUES (". mysqli_real_escape_string($link, $_SESSION['id']).", ". mysqli_real_escape_string($link, $_POST['userId']).")");
            
            echo "2";
            
        }
              
    }

    if ($_GET['action'] == 'postTweet') {
        
        if (!$_POST['tweetContent']) {
                            
            echo "Your tweet is empty!";
                            
        } else if (strlen($_POST['tweetContent']) > 250) {
            
            echo "Your tweet is too long";
            
        } else {
            
             mysqli_query($link, "INSERT INTO tweets (`tweet`, `userid`, `datetime`) VALUES ('". mysqli_real_escape_string($link, $_POST['tweetContent'])."', ". mysqli_real_escape_string($link, $_SESSION['id']).", NOW())");
            
            echo "1";
            
        }   
        
    }





























?> 
