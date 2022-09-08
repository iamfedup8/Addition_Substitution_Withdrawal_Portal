<?php
include "db_conn.php";
session_start();
echo "<br>";

if (isset($_SESSION['student_id']) ) {
    
    
   
    $ADD= 0;  $SUB1=0;  $SUB2=0; $WITH=0;
    
    if( strcmp($_POST["ADD"],"none")!=0)
{
    $ADD = (int)$_POST["ADD"];
    
}
   
   

    
    
    if( strcmp($_POST["SUB1"],"none")!=0)
{
    $SUB1 =(int) $_POST["SUB1"];
    
}
    
   

    
    if( strcmp($_POST["SUB2"],"none")!=0)
{
    $SUB2 = (int)$_POST["SUB2"];
    
}
    
    

    if(strcmp($_POST["WITH"],"none")!=0)
{
    $WITH = (int)$_POST["WITH"];
    
}
   
 
    
    
    $sql = "INSERT INTO storage (student_id, addition_id,sub1_id,sub2_id,with_id)
    VALUES ( '{$_SESSION['student_id']}' , {$ADD}, {$SUB1}, {$SUB2}, {$WITH})";
    
  


    if ($conn->query($sql)) {
       

      echo "New record created successfully"."<br>";
        
        
    echo "Please login after a while to check your status"."<br>";
        
    } else {
        

      echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    
    
    


    $conn->close();
  }
    ?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<a href = "logout.php" class="logout"> LOGOUT </a>
