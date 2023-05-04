<?php

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
  print($user_id+$movie_id);
  $sql = "INSERT INTO favorites ('user_id', 'movie_id') VALUES ($user_id, $movie_id)";
  $result = mysqli_query($conn, $sql);

  if ($result) {
    return "Success";
  } else {
    return "Error: " . mysqli_error($conn);
  }
}
?>