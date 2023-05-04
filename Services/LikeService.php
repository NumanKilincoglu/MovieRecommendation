<?php

function getLikes($movie_id)
{
    include 'dbConnect.php';
    $sql = "SELECT COUNT(id) FROM favorites WHERE movie_id = $movie_id GROUP BY movie_id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        mysqli_close($conn);
        if(isset($row['COUNT(id)'])) return $row['COUNT(id)'];
        return 0;
    } else {
        return "Error: " . mysqli_error($conn);
    }
}

?>