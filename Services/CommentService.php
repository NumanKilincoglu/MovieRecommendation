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
    include 'dbConnect.php';
    $sql = "SELECT c.*, u.username FROM comments c, users u WHERE movie_id = $movie_id AND u.id = c.user_id";
    $result = mysqli_query($conn, $sql);

    $reviews = array();

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $reviews[] = $row;
        }
    }
    return $reviews;
}

?>