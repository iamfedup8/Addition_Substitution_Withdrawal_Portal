<?php

session_start();

include "db_conn.php";



    
 $stm="DELETE FROM storage";
    $conn->query($stm);
    
$stm1= "DELETE FROM status";
   $conn->query($stm1);
   
$sql1="INSERT INTO status (window_open, enrolment_done) VALUES (0,1)";
$conn->query($sql1);
    
    echo "Old responses cleared and form has been closed";


?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<a href = "logout.php" class="logout"> LOGOUT </a>
