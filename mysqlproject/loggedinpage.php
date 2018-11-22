<?php 
    
    session_start();

    

// if the user has a cookie than we update the session to equal it 

    if (array_key_exists("id", $_COOKIE)) {
         
        $_SESSION['id'] = $_COOKIE['id']; 
        
    }

//this will check if they are logged in, if they are logged in than we echo "Logged In!" but we also put a link to logout


    if (array_key_exists("id", $_SESSION)) {
             
        require("connection.php");
        
        $query = "SELECT diary FROM `users` WHERE id = '".mysqli_real_escape_string($link, $_SESSION['id'])."' LIMIT 1";
        
        
        if (isset($query)) {
            
            $result = mysqli_query($link, $query);
        
            $row = mysqli_fetch_array($result);
            
            $diaryContent = $row['diary'];
            
        } else {
            
            echo "erro";
            
        }
        
        
        
            
//this will connect the index.php with loggedinpage.php
        
    } else {
        
        header("Location: index.php");
        
    }

    include("header.php");

?>

<!-- bootstrap -->

<nav class="navbar navbar-light bg-light navbar-fixed-top">
    
    <a class="navbar-brand" href="#">Secret Diary</a>
    
    <div class="my-2 my-lg-0">>
        
        <a href='index.php?logout=1'><button class="btn btn-outline-success my-2 my-sm-0" type="submit">Logout</button></a>
        
    </div>
    
</nav>

    <div class="container-fluid" id="containerLoggedInPage"> 
        
        <textarea id="diary" class="form-control"><?php echo $diaryContent; ?></textarea>

    </div>

<?php   
        
    include("footer.php");

?>


