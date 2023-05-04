<?php
session_start();
include 'dbConnect.php';
include 'Services/MovieService.php';
include 'Services/CommentService.php';
include 'Services/UserService.php';
require_once('Services/LikeService.php');

if (isset($_SESSION['username']) && isset($_SESSION['avatar']) && isset($_SESSION['user_id'])) {
    $username = $_SESSION['username'];
    $user_id = $_SESSION['user_id'];
    $avatar = $_SESSION['avatar'];
} else {
    $username = "Numan";
}

$user = getUserDetails(1);
$movie_id = "";
$_SESSION['movie_id'] = $movie_id;
?>
<!DOCTYPE html>
<html>

<head>
    <title>Movie Recommend</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
        integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/card.css">

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Movie App</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="nav-right">
            <div class="left">
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="#">Main Page</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Categories</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">My Favourites</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="right">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="assets/avatar/<?php echo $user['avatar']; ?>.png" alt="avatar" id="avatar-icon">
                            <?php echo $username; ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="#">My Profile</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1 class="my-5 text-center">Movie App</h1>
        <div class="row">
            <div class="col-md-6 mx-auto">
                <form action="search.php" method="get">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Movie Name or Category" name="q">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="filter-bar">
            <div class="filter-section">
                <label class="filter-label" for="release-date">Çıkış Tarihi:</label>
                <input type="date" id="release-date" name="release-date">
            </div>
            <div class="filter-section">
                <label class="filter-label" for="imdb-rating">IMDb:</label>
                <select id="imdb-rating" name="imdb-rating">
                    <option value="0">Tümü</option>
                    <option value="7">7.0 ve üzeri</option>
                    <option value="8">8.0 ve üzeri</option>
                    <option value="9">9.0 ve üzeri</option>
                </select>
            </div>
            <div class="filter-section">
                <label class="filter-label" for="comment-count">Yorum Sayısı:</label>
                <select id="comment-count" name="comment-count">
                    <option value="0">Tümü</option>
                    <option value="50">50 ve üzeri</option>
                    <option value="100">100 ve üzeri</option>
                    <option value="200">200 ve üzeri</option>
                </select>
            </div>
            <div class="filter-section">
                <label class="filter-label" for="favorite-count">Favori Sayısı:</label>
                <select id="favorite-count" name="favorite-count">
                    <option value="0">Tümü</option>
                    <option value="500">500 ve üzeri</option>
                    <option value="1000">1000 ve üzeri</option>
                    <option value="5000">5000 ve üzeri</option>
                </select>
            </div>
            <div class="filter-section">
                <button type="button" class="btn btn-outline-primary">Primary</button>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <h3 class="my-4">Latest Movies</h3>
            </div>
        </div>
        <div class="row">
            <?php
            // Veritabanından filmleri getir
            $query = "SELECT * FROM movies";
            $result = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <div class="col-md-4 col-sm-6 mb-3">
                    <form action="post">
                        <div class="movie-card">
                            <div class="movie-header"
                                style="background-image: url(<?php echo "assets/movies/" . $row['image_path'] . ".jpg"; ?>)">
                                <div class="header-icon-container">
                                </div>
                            </div><!--movie-header-->
                            <div class="movie-content">
                                <div class="movie-content-header">
                                    <a href="#">
                                        <h3 class="movie-title">
                                            <?php echo $row['title']; ?>
                                        </h3>
                                    </a>
                                    <h5>
                                        <?php echo $row['genre']; ?>
                                    </h5>
                                    <img class="imax-logo" src="<?php echo "assets/icons/imax.jpg"; ?>" alt="">
                                </div>
                                <div class="movie-info">
                                    <div class="info-section">
                                        <img class="img-icon" src="assets/icons/clock.png">
                                        <span>
                                            <?php echo $row['duration']; ?> Minutes
                                        </span>
                                    </div><!--screen-->
                                    <div class="info-section">
                                        <img class="img-icon" src="assets/icons/empty-star.png">
                                        <span>
                                            <?php echo getLikes($row['id']); ?>
                                        </span>
                                    </div><!--row-->
                                    <div class="info-section">
                                        <img class="img-icon" src="assets/icons/comment.png">
                                        <span>
                                            <?php echo getCommentCount($row['id']); ?>
                                        </span>
                                    </div><!--seat-->
                                </div>
                                <div class="movie-description">
                                    <?php echo $row['description']; ?>
                                </div>
                                <a href="movieDetails.php?movie_id=<?php echo $row['id']; ?>"
                                    class="btn btn-success mt-5">Movie Details</a>
                            </div><!--movie-content-->
                        </div><!--movie-card-->
                    </form>
                </div>
                <?php
            }
            ?>
        </div>
        <footer>
            <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
                
                <span class="text-white">Numan KILINCOGLU © 2023 Copyright:</span>
            </div>
        </footer>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
        </script>
    <script src="script.js"></script>
</body>

</html>