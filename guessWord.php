<?php
  session_start();

  include 'dbConnect.php';

  if (isset($_POST["guess"])) {
    $guess = $_POST["guess"];
    $word = $_SESSION["word"];

    if (strtolower($guess) == strtolower($word)) {
      echo '<div class="container mt-5">
              <div class="alert alert-success text-center" role="alert">
                Congratulations! You guessed the word \'' . $word . '\' correctly.
              </div>
              <div class="text-center">
                <a href="index.php" class="btn btn-primary btn-block">Play again</a>
              </div>
            </div>';

      $_SESSION["wins"]++;
    } else {
      echo '<div class="container mt-5">
              <div class="alert alert-danger text-center" role="alert">
                Sorry, your guess of "' . $guess . '" is incorrect. Please try again.
              </div>
              <div class="text-center">
                <a href="index.php" class="btn btn-primary btn-block">Try again</a>
              </div>
            </div>';
    }

    $_SESSION["plays"]++;
  } else {
    header("Location: index.php");
    exit();
  }
?>
