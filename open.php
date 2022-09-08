<?php

session_start();

include "db_conn.php";


$sql1="SELECT * FROM status";
$result = mysqli_query($conn,$sql1);
$row=mysqli_fetch_array($result);
if($row['enrolment_done']==0 && $row['window_open']==1)
     {
         echo "Already open and accepting queries";
        
     }
else{
    
 $stm="DELETE FROM status";
    $conn->query($stm);
    
$sql="INSERT INTO status (`window_open`, `enrolment_done`) VALUES ('1','0')";
$conn->query($sql);
    
    echo "Forms are open and accepting requests";
}

?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<a href = "logout.php" class="logout"> LOGOUT </a>
