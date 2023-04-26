<?php
$servername = "servername";
$username = "username";
$password = "password";
$dbname = "dbname";


$Token = "token";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
  // echo 'Connected Successfully!';
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}