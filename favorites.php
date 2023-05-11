<?php
require_once 'dbConnect.php';
require_once 'Services/UserService.php';
include 'Services/MovieService.php';
include 'Services/CommentService.php';
require_once('Services/LikeService.php');

session_start();

if (isset($_SESSION['username']) && $_SESSION['avatar'] && $_SESSION['user_id']) {
    $user_name = $_SESSION['username'];
    $user_id = $_SESSION['user_id'];
    $avatar = $_SESSION['avatar'];
}

if (isset($_GET['movie_id'])) {
    deleteFavoriteMovies($user_id, $_GET['movie_id']);
}

$favorite_movies = getFavoriteMovies($user_id);
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
    <link rel="stylesheet" href="styles/favorites.css">
    <link rel="stylesheet" href="styles/footer.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="main.php">Movie App</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="nav-right">
            <div class="left">
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="main.php">Main Page</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="favorites.php">My Favourites</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="right">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="assets/avatar/<?php echo $avatar; ?>.png" alt="avatar" id="avatar-icon">
                            <?php echo $user_name; ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="profile.php">My Profile</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="utils/logout.php">Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center text-white mb-5 mt-3">My Favorite Movies</h2>
            </div>
        </div>
        <div class="row">
            <?php foreach ($favorite_movies as $movie): ?>
                <div class="col-md-4 mb-4">
                    <div class="movie-card" style="">
                        <div class="movie-header"
                            style="background-image: url(<?php echo "assets/movies/" . $movie['image_path'] . ".jpg"; ?>)">
                            <div class="header-icon-container">
                            </div>
                        </div>
                        <div class="movie-content">
                            <div class="movie-content-header">
                                <a href="#">
                                    <h3 class="movie-title">
                                        <?php echo $movie['title']; ?>
                                    </h3>
                                </a>
                                <h5>
                                    <?php echo $movie['genre']; ?>
                                </h5>
                                <img class="imax-logo" src="<?php echo "assets/icons/imax.jpg"; ?>" alt="">
                            </div>
                            <div class="movie-info">
                                <div class="info-section">
                                    <img class="img-icon" src="assets/icons/clock.png">
                                    <span>
                                        <?php echo $movie['duration']; ?> Minutes
                                    </span>
                                </div><!--screen-->
                                <div class="info-section">
                                    <img class="img-icon" src="assets/icons/empty-star.png">
                                    <span>
                                        <?php echo getLikes($movie['id']); ?>
                                    </span>
                                </div><!--row-->
                                <div class="info-section">
                                    <img class="img-icon" src="assets/icons/comment.png">
                                    <span>
                                        <?php echo getCommentCount($movie['id']); ?>
                                    </span>
                                </div><!--seat-->
                            </div>
                            <div class="movie-description">
                                <?php echo $movie['description']; ?>
                            </div>

                            <a href="movieDetails.php?movie_id=<?php echo $movie['id']; ?>"
                                class="btn btn-success mt-5">Movie
                                Details</a>
                            <form method="post">
                                <div class="movie-actions mt-3">
                                    <a class="remove-favorite btn btn-danger"
                                        href="favorites.php?movie_id=<?php echo $movie['id']; ?>">Remove From
                                        Favorites</a>
                                </div>
                            </form>
                        </div><!--movie-content-->
                    </div><!--movie-card-->
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <footer class="footer">
        <div class="waves">
            <div class="wave" id="wave1"></div>
            <div class="wave" id="wave2"></div>
            <div class="wave" id="wave3"></div>
            <div class="wave" id="wave4"></div>
        </div>
        <ul class="social-icon">
            <li class="social-icon__item"><a class="social-icon__link" href="https://github.com/NumanKilincoglu">
                    <ion-icon name="logo-github"></ion-icon>
                </a></li>
            <li class="social-icon__item"><a class="social-icon__link"
                    href="https://www.linkedin.com/in/numankilincoglu/">
                    <ion-icon name="logo-linkedin"></ion-icon>
                </a></li>
        </ul>
        <ul class="menu">
            <li class="menu__item"><a class="menu__link" href="#">Home</a></li>
            <li class="menu__item"><a class="menu__link" href="#">About</a></li>
            <li class="menu__item"><a class="menu__link" href="#">Contact</a></li>

        </ul>
        <h5 class="text-white">2023 Numan KILINCOGLU | All Rights Reserved</h5>
    </footer>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
</body>

</html>