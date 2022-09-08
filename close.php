
<?php

session_start();

include "db_conn.php";


$sql1="SELECT * FROM status";
$result = mysqli_query($conn,$sql1);
$row=mysqli_fetch_array($result);
if($row['enrolment_done']==1 && $row['window_open']==0)
     {
         echo "Already closed"."<br>";
        
     }
else{
    
 $stm="DELETE FROM status";
    $conn->query($stm);
    
$sql1="INSERT INTO status (window_open, enrolment_done) VALUES (0,1)";
$conn->query($sql1);
    
    echo "Forms are closed and not accepting requests"."<br>";
}

?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<a href = "logout.php" class="logout"> LOGOUT </a>
