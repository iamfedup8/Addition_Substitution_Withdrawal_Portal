<?php

session_start();

include "db_conn.php";

if (isset($_POST['uname']) && isset($_POST['password'])) {
 //echo "testing";
    function validate($data){

       $data = trim($data);

       $data = stripslashes($data);

       $data = htmlspecialchars($data);

       return $data;

    }

    $uname = validate($_POST['uname']);

    $pass = validate($_POST['password']);

    if (empty($uname)) {

        header("Location: index.php?error=User Name is required");

        exit();

    }else if(empty($pass)){

        header("Location: index.php?error=Password is required");

        exit();

    }else{

        $sql = "SELECT * FROM students WHERE student_id ='$uname' AND password='$pass'";
        
        $sql1 = "SELECT * FROM admin_credentials WHERE admin_id ='$uname' AND password='$pass'";
        

        $result = mysqli_query($conn, $sql);
        $result1=mysqli_query($conn,$sql1);
        
        if(mysqli_num_rows($result1) === 1){
            //go to a new page that allows the admin to run the script
             echo "Hello Admin";
            ?>
           <h4>   <a href= "run.php"> Click here to close enrolment window and process requests</a> </h4>
            
            <h4>   <a href= "open.php"> Click here to open enrolment window and accept requests</a> </h4>
            <h4>   <a href= "close.php"> Click here to close the website</a> </h4>
            
            <h4>   <a href= "clear.php"> Click here to clear responses of current semester</a> </h4>
            
            
            <?php
            
        }
        

           else if (mysqli_num_rows($result) === 1) {
               
              
               
               
               
               

            $row = mysqli_fetch_assoc($result);

            if ($row['student_id'] === $uname && $row['password'] === $pass) {

                echo "Logged in!";

                $_SESSION['student_id'] = $row['student_id'];

                $_SESSION['student_name'] = $row['student_name'];

               // $_SESSION['id'] = $row['id'];

                header("Location: home.php");

                exit();

            }else{

                header("Location: index.php?error=Incorrect User name or password");

                exit();

            }

        }else{

            header("Location: index.php?error=Incorrect User name or password");

            exit();

        }

    }

}else{

    header("Location: index.php");

    exit();

}
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<a href = "logout.php" class="logout"> LOGOUT </a>
