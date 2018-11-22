<?php 

//session_start() creates a session or resumes the current one based on a session identifier passed via a GET or POST request, or passed via a cookie.

    session_start();

error_reporting(E_ERROR | E_PARSE);

// this will make sure that the error will be empty for the beginning
        
        $error = "";

//array_key_exists checks if there is "logout" value in $_GET array. We can set the value "logout" in $_GET array when we click the Logout button in page

    if (array_key_exists("logout", $_GET)) {
        
//The unset() function destroys a given variable.
        
        unset($_SESSION);
        setcookie("id", "", time() - 60*60);

//An associative array of variables passed to the current script via HTTP Cookies.
// $HTTP_COOKIE_VARS contains the same initial information, but is not a superglobal. (Note that $HTTP_COOKIE_VARS and $_COOKIE are different variables and that PHP handles them as such)

        $_COOKIE["id"] = "";  
        
//nqofse n'session ka id edhe qajo id osht e njejt me id e sessionit aktual ose nese ka id n cookie edhe id e cookie osht e njejt me id e cookie-s aktuale ather session osht i vlefshem edhe direkt e fut perdoruesin brenda applikacionit 
        
    } else if ((array_key_exists("id", $_SESSION) AND $_SESSION['id']) OR (array_key_exists("id", $_COOKIE) AND $_COOKIE['id'])) {
        
//header() is used to send a raw HTTP header. See the » HTTP/1.1 specification for more information on HTTP headers.
//Remember that header() must be called before any actual output is sent, either by normal HTML tags, blank lines in a file, or from PHP. It is a very common error to read code with include, or require, functions, or another file access function, and have spaces or empty lines that are output before header() is called. The same problem exists when using a single PHP/HTML file.
        
        header("Location: loggedinpage.php");
        
    }

// The "if" statement executes some code if one condition is true.
//The "array_key_exists()" function checks an array for a specified key, and returns true if the key exists and false if the key does not exist. So if the key exists than will display whatever it is, in this case we looking for "submit" within the "$_POST" array.


    if (array_key_exists("submit", $_POST)) {
        
        include("connection.php");
     
// if the user haven't put any email address then the error will be displayed, in this case we gave "$error" a value
        
        if (!$_POST['email']) {
            
// "(.=)" will append a string with another string.
            
          $error .= "An email address is required<br>";
            
            
        }
        
// if the user haven't put any password then the error will be displayed, in this case we gave "$error" a value
        
        
        if (!$_POST['password']) {
            
          $error .= "A password is required<br>";
            
        }
        
// if there is an error and the error string is not empty than we give "$error" a value. The ".$error" at the end will show the specific error messages mentioned above
            
            
        if ($error != "") {
            
            $error = "<p>There were error(s) in your form:</p>".$error;
            
        } else {
            
// this command will define the whole signup code, nqofse osht signup baras me 1 dmth osht e aktivizume akutalisht ather e vlen qiky kodi nqofse jo lidhet atje posht me "else" per login

            
            if ($_POST['signUp'] == '1') {
            
// The "mysqli_real_escape_string()" function escapes special characters in a string for use in an SQL statement.
//The SELECT statement is used to select data from one or more tables, so it will Select Data From a MySQL Database
//The WHERE clause is used to filter records.
//The WHERE clause is used to extract only those records that fulfill a specified condition.
//MySQL provides a LIMIT clause that is used to specify the number of records to return.
//The LIMIT clause makes it easy to code multi page results or pagination with SQL, and is very useful on large tables. Returning a large number of records can impact on performance.

               $query = "SELECT id FROM `users` WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."' LIMIT 1";

// The "mysqli_query()" function performs a query against the database

                $result = mysqli_query($link, $query);

// The "mysqli_num_rows()" function returns the number of rows in a result set.

                if (mysqli_num_rows($result) > 0) {

                    $error = "That email address is taken";

                } else {
                    
//The INSERT INTO statement is used to insert new records in a table

                    $query = "INSERT INTO `users` (`email`, `password`) VALUES ('".mysqli_real_escape_string($link, $_POST['email'])."' , '".mysqli_real_escape_string($link, $_POST['password'])."')";

                   if (!mysqli_query($link, $query)) {

                        $error = "<p>Could not sign you up - please try again later.</p>";

                    } else {

//The UPDATE statement is used to modify the existing records in a table.
//The mysqli_insert_id() function returns the id (generated with AUTO_INCREMENT) used in the last query.
//The MD5 hashing algorithm is a one-way cryptographic function that accepts a message of any length as input and returns as output a fixed-length digest value to be used for authenticating the original message.
//qikjo query osht per me bo update/enkriptu passwordin e userit te sapo krijuar duke ekriptu id e linkut aktual qe dmth id e userit pastaj duke kombinu id e enkriptume me password dhe pastaj i enkripton dyjat bashk

                        $query = "UPDATE `users` SET password = '".md5(md5(mysqli_insert_id($link)).$_POST['password'])."' WHERE id = ".mysqli_insert_id($link)." LIMIT 1";

                        mysqli_query($link, $query);  

                        $_SESSION['id'] = mysqli_insert_id($link); 

                        if ($_POST['stayLoggedIn'] == '1') {

//The setcookie() function defines a cookie to be sent along with the rest of the HTTP headers.
//A cookie is often used to identify a user. A cookie is a small file that the server embeds on the user's computer. Each time the same computer requests a page with a browser, it will send the cookie too. With PHP, you can both create and retrieve cookie values.

                            setcookie("id", mysqli_insert_id($link), time() + 60*60*24*365);

                        }

// this will connect the loggedinpage.php with the ndex.php

                        header("Location: loggedinpage.php");

                    }

                }
                
            } else {
                
//we can use the * character to select ALL columns from a table
                
                $query = "SELECT * FROM `users` WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."'";
                
                $result = mysqli_query($link, $query);
                
//The mysqli_fetch_array() function fetches a result row as an associative array, a numeric array, or both.
                
                $row = mysqli_fetch_array($result);
                
//The isset () function is used to check whether a variable is set or not. If a variable is already unset with unset() function, it will no longer be set. The isset() function return false if testing variable contains a NULL value.
                
                if (isset($row)) {
                    
//kur useri e shkrun passwordin per me hi login ather krijohet ni hash per id tani i shtohet qati hashi vlera e passwordit tani krijohet hashi i vleres se fituar, edhe kqyret nese qikjo vler e hashit osht e njejt me vleren e hashit kur useri u bo sign up.
                        
                        $hashedPassword = md5(md5($row['id']).$_POST['password']);
                        
                        if ($hashedPassword == $row['password']) {
                            
                            $_SESSION['id'] = $row['id'];
                            
                            if ($_POST['stayLoggedIn'] == '1') {

                                setcookie("id", $row['id'], time() + 60*60*24*365);

                            } 

                            header("Location: loggedinpage.php");
                                
                        } else {
                            
                            $error = "That email/password combination could not be found.";
                            
                        }
                        
                    } else {
                        
                        $error = "That email/password combination could not be found.";
                    
                    }
                 
            } 
          
        }
        
    }



?>

<?php include("header.php"); ?>
    
    <div class="container" id="homePageContainer">
      
    <h1>Secret Diary</h1>
        
    <p><strong>Store your thoughts permanently and securely!</strong></p>
                
        <!-- The "echo" is used to output data to the screen.
// The "echo" statement can be used with or without parentheses: echo or echo() -->
 
<div id="error"><?php if ($error!=""); {
    
   echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
    
 }?></div>

<!-- The HTML "<form>" element defines a form that is used to collect user input.
An HTML form contains form elements.
Form elements are different types of input elements, like text fields, checkboxes, radio buttons, submit buttons, and more.
 -->

<!-- The "method" attribute specifies how to send form-data (the form-data is sent to the page specified in the action attribute).

The form-data can be sent as URL variables (with method="get") or as HTTP post transaction (with method="post").

THE METHOD "POST" : appends form-data inside the body of the HTTP request (data is not shown is in URL)
Has no size limitations
Form submissions with POST cannot be bookmarked
-->

        <form method="post" id="signUpForm">
            
    <p>Interested? Sign up now.</p>
  
<!-- The <input>" element can be displayed in several ways, depending on the type attribute. -->

            <div class="form-group">

                <input class="form-control" type="email" name="email" placeholder="Your Email">
                
            </div>

            <div class="form-group">

                <input class="form-control" type="password" name="password" placeholder="Password">

            </div>

            <label class="form-check-label">

                <input type="checkbox"checkbox name="stayLoggedIn" value="1">
                
                Stay logged in
                
            </label>

            <div class="form-group">

                <input type="hidden" name="signUp" value="1">

                <input class="btn btn-success" type="submit" name="submit" value="Sign Up!">

            </div>
            
            <p><a type="button" class="toggleForms btn btn-primary btn-sm" >Log in</a></p>

        </form>

        <form method="post" id="logInForm">
            
            <p>Log in using your email and password.</p>

            <div class="form-group">

                <input class="form-control" type="email" name="email" placeholder="Your Email">

            </div>

            <div class="form-group">

                <input class="form-control" type="password" name="password" placeholder="Password">

            </div>

            <label class="form-check-label">

                <input type="checkbox"checkbox name="stayLoggedIn" value="1">
                
                Stay logged in
                 
            </label>

                <input type="hidden" name="signUp" value="0">
            
            <div class="form-group">

                <input class="btn btn-success" type="submit" name="submit" value="Log In!">

            </div>
            
            <p><a type="button" class="toggleForms btn btn-primary btn-sm">Sign up</a></p>

        </form>
            
    </div>
            
<?php include("footer.php"); ?>  

    



