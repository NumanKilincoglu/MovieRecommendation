<?php

function getUserDetails($user_id)
{
  include 'dbConnect.php';
  $sql = "SELECT * FROM users WHERE id = $user_id ";
  $result = mysqli_query($conn, $sql);

  if ($result) {
    $row = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    mysqli_close($conn);
    return $row;
  } else {
    return "Error: " . mysqli_error($conn);
  }
}

function getFavoriteMovies($user_id)
{
  include 'dbConnect.php';
  $sql = "SELECT * FROM favorites WHERE user_id = $user_id ";
  $result = mysqli_query($conn, $sql);

  if ($result) {
    $row = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    mysqli_close($conn);
    return $row;
  } else {
    return "Error: " . mysqli_error($conn);
  }
}

function addFavoriteMovie($user_id, $movie_id)
{
  include 'dbConnect.php';

  $sql = "INSERT INTO favorites (user_id, movie_id) VALUES ($user_id, $movie_id)";
  $result = mysqli_query($conn, $sql);

  if ($result) {
    return "Success";
  } else {
    return "Error: " . mysqli_error($conn);
  }
}


function addComment($user_id, $movie_id, $text)
{
  include 'dbConnect.php';
  $db = new PDO("mysql:host=localhost;dbname=MovieProject", "root", "");
  $movie_id = intval($movie_id);
  $datetime = date_create()->format('Y-m-d H:i:s');
  $stmt = $db->prepare("INSERT INTO comments (user_id, movie_id, comment, created_at) VALUES (?, ?, ?, ?)");

  $stmt->bindParam(1, $user_id);
  $stmt->bindParam(2, $movie_id);
  $stmt->bindParam(3, $text);
  $stmt->bindParam(4, $datetime);

  if ($stmt->execute()) {
    return true;
  } else {
    return false;
  }
}

?>