<?php

function login($user_name, $password)
{
    include 'dbConnect.php';

    $sql = "SELECT * FROM users WHERE username = $user_name AND password = $password";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        mysqli_close($conn);
        return true;
    } else {
        return false;
    }
}

function userNameExist($user_name)
{
    include 'dbConnect.php';

    $sql = "SELECT * FROM users WHERE username = $user_name";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        mysqli_close($conn);
        return true;
    } else {
        return false;
    }
}

function register($user_name, $password, $email)
{
    include 'dbConnect.php';

    $userExist = login($user_name, $pass);
    $userNameExist = userNameExist($user_name);

    if ($userExist)
        return "User Already Exists";
    if ($userNameExist)
        return "Username Already Taken";

    $sql = "INSERT INTO users ('username', 'password', 'email') VALUES ($user_name, $password, $email)";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        return "User Has Been Registered";
    } else {
        return "Error: " . mysqli_error($conn);
    }
}
?>