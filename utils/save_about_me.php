<?php
session_start();
header("Access-Control-Allow-Origin: *");
include '../dbConnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $_POST["text"];
    $user_id = $_SESSION['user_id'];
    $aboutMe = mres($_POST["text"]);

    $sql = "UPDATE users SET about='$aboutMe' WHERE id=$user_id";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
}
function mres($value)
{
    $search = array("\\", "\x00", "\n", "\r", "'", '"', "\x1a");
    $replace = array("\\\\", "\\0", "\\n", "\\r", "\'", '\"', "\\Z");

    return str_replace($search, $replace, $value);
}

?>