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

  $db = new PDO("mysql:host=localhost;dbname=MovieProject", "root", "");

  $stmt = $db->prepare("SELECT * FROM movies");
  $stmt->execute();
  $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $movies;
}

function getMovieByParam($query)
{
  $db = new PDO("mysql:host=localhost;dbname=MovieProject", "root", "");
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "SELECT * FROM movies WHERE title LIKE :query OR genre LIKE :query";
  $stmt = $db->prepare($sql);

  $stmt->bindValue(':query', '%' . $query . '%');
  $stmt->execute();

  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $results;
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

function getMovieByFilter($query)
{
  $db = new PDO("mysql:host=localhost;dbname=MovieProject", "root", "");
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $stmt = $db->prepare($query);
  $stmt->execute();
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $results;
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