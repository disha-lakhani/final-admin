<?php 

    $server="localhost";
    $username= "root";
    $password= "";
    $db="admin";


    $conn=mysqli_connect("$server","$username","$password","$db");

    if(!$conn){
        die("connection failed :" .mysqli_connect_error());
    }
    // else{
    //     echo "connection successfully";
    // }

?>