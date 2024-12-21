<?php
$servername="localhost";
$usernme="root";
$password="1234";
$dbname="blog1";

$conn=mysqli_connect($servername,$usernme,$password,$dbname);

if(!$conn){
    die("echec de la connection:".mysqli_connect_error());
} 
?>
