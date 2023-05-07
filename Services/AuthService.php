<?php


function login($user_name, $pass)
{
    include 'dbConnect.php';
    $sql = "SELECT * FROM users WHERE username = '$user_name' ";

    $result = mysqli_query($conn, $sql);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        mysqli_close($conn);
        if (password_verify($pass, $row['pass'])) {
            return $row;
        }
    } else {
        return "Error: " . mysqli_error($conn);
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

function register($username, $passw, $email)
{
    $pdo = new PDO("mysql:host=localhost;dbname=MovieProject", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, email, pass) VALUES (:username, :email, :passw)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':passw', $passw);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        echo "Record Error: " . $e->getMessage();
        return false;
    }

}
?>