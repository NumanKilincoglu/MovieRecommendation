<?php
$host = "localhost"; // Host name
$username = "root"; // Database username
$password = ""; // Database password
$dbname = "MovieProject"; // Database name

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>