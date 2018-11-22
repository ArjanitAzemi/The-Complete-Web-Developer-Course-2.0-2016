<?php

//The "link()" function creates a hard link from the existing target with the specified name link. This function returns TRUE on success, or FALSE on failure. 
//The 'mysqli_connect()' function opens a new connection to the MySQL server.
        
         $link = mysqli_connect("localhost", "root", "", "secretdi");

        
//The "mysqli_connect_error()" function returns the error description from the last connection error, if any.
        
        if (mysqli_connect_error()) {
            
//The "die()" function prints a message and exits the current script.
            
           die ("Database Connection Error");
            
        }

?>