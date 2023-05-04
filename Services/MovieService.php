<?php

/*
Movies
*/

function getMovie($movie_id)
{
  include 'dbConnect.php';
  $sql = "SELECT * FROM movies WHERE id = $movie_id ";
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

function getAllMovies()
{
  include 'dbConnect.php';

  $sql = "SELECT * FROM movies";
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

function addMovie($user_id, $movie_id)
{
  include 'dbConnect.php';

  $sql = "INSERT INTO favorites ('user_id', 'movie_id') VALUES ($user_id, $movie_id)";
  $result = mysqli_query($conn, $sql);

  if ($result) {
    return "Success";
  } else {
    return "Error: " . mysqli_error($conn);
  }
}


function deleteMovie($movie_id)
{
  include 'dbConnect.php';

  $sql = "DELETE movies WHERE id = $movie_id";
  $result = mysqli_query($conn, $sql);

  if ($result) {
    return "Success";
  } else {
    return "Error: " . mysqli_error($conn);
  }
}

function updateMovie($user_id, $movie_id)
{
  include 'dbConnect.php';

  $sql = "";
  $result = mysqli_query($conn, $sql);

  if ($result) {
    return "Success";
  } else {
    return "Error: " . mysqli_error($conn);
  }
}

?>