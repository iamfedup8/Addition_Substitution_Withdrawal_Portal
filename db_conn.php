<?php
//echo "Hello";
$sname= "localhost";

$unmae= "root";

$password = "";

$db_name = "test";

$conn = mysqli_connect($sname, $unmae, $password, $db_name);

if (!$conn) {

    echo "Connection failed!"."<br>";

}
else{
     echo "Successful connection"."<br>";
}


