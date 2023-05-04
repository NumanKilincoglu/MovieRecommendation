<?php
include 'dbConnect.php';

$sql = "SELECT comments.comment, comments.created_at, users.username
        FROM comments
        JOIN users ON comments.user_id = users.id
        WHERE comments.movie_id = $movie_id
        ORDER BY comments.created_at DESC";

$result = mysqli_query($conn, $sql);

echo '<div class="container my-5">';
echo '<h3>Kullanıcı Yorumları</h3>';

if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    echo '<div class="card my-3">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">' . $row['username'] . '</h5>';
    echo '<p class="card-text">' . $row['comment'] . '</p>';
    echo '<p class="card-text"><small class="text-muted">' . $row['created_at'] . '</small></p>';
    echo '</div>';
    echo '</div>';
  }
} else {
  echo '<p>There is no comment for this movie.</p>';
}

echo '</div>';

mysqli_close($conn);
?>
