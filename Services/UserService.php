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
    if (isset($row['username'])){
      return $row;
    }
    return "--";
  } else {
    return "Error: " . mysqli_error($conn);
  }
}

function getFavoriteMovies($user_id)
{
  include 'dbConnect.php';
  $sql = "SELECT * FROM favorites f, movies m WHERE user_id = $user_id AND m.id = f.movie_id";

  $db = new PDO("mysql:host=localhost;dbname=MovieProject", "root", "");

  $stmt = $db->prepare("SELECT * FROM favorites f, movies m WHERE user_id = ? AND m.id = f.movie_id");
  $stmt->execute([$user_id]);
  $favs = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $favs;
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

function deleteFavoriteMovies($user_id, $movie_id)
{
  include 'dbConnect.php';
  $sql = "DELETE FROM favorites WHERE user_id = $user_id AND movie_id = $movie_id;";

  if ($conn->query($sql)) {
    $conn->close();
    return true;
  } else {
    $conn->close();
    return false;
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