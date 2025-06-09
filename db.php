<?php
    $host = "localhost";
    $user = "aislyn_organic";
    $pass = "aislyn_organic";
    $db = "organic";

     $conn = new mysqli($host, $user, $pass, $db);

           if ($conn->connect_error) {
               die("Connection failed: " . $conn->connect_error);
            }

?>
