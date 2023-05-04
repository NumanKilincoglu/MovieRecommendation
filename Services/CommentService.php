<?php

function getCommentCount($movie_id)
{
    include 'dbConnect.php';
    $sql = "SELECT COUNT(id) FROM comments WHERE movie_id = $movie_id GROUP BY movie_id";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        mysqli_close($conn);
        if(isset($row['COUNT(id)'])) return $row['COUNT(id)'];
        return 0;
    } else {
        return 0;
    }
}

function getAllComments($movie_id)
{
    $db = new PDO("mysql:host=localhost;dbname=MovieProject", "root", "");

    $stmt = $db->prepare("SELECT comments.*, users.username FROM comments 
                          INNER JOIN users ON comments.user_id = users.id 
                          WHERE comments.movie_id = ?");
    $stmt->execute([$movie_id]);
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $comments;
}
?>