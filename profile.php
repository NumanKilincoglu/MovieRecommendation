<?php
session_start();
include 'dbConnect.php';
include 'Services/MovieService.php';
include 'Services/CommentService.php';
include 'Services/UserService.php';
require_once('Services/LikeService.php');

if (isset($_SESSION['username']) && $_SESSION['avatar'] && $_SESSION['user_id']) {
    $user_name = $_SESSION['username'];
    $user_id = $_SESSION['user_id'];
    $avatar = $_SESSION['avatar'];
    $user = getUserDetails($user_id);
    $movies = getFavoriteMovies($user_id);
    $commentCount = getCommentCountUser($user['id']);
    $maxComment = getMaxComment($user_id);
    $likeCount = getLikeCountUser($user['id']);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Profile</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles/footer.css">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/profile.css">
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

    <!-- Profile Info -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="profile-info">
                    <div class="profile-title">
                        <h2>Personel Details</h2>
                    </div>

                    <hr>
                    <ul class="list-group">
                        <li class="list-group-item"><strong>Name:</strong>
                            <?php echo $user['name'] ?>
                        </li>
                        <li class="list-group-item"><strong>Username:</strong>
                            <?php echo $user['username'] ?>
                        </li>
                        <li class="list-group-item"><strong>Email:</strong>
                            <?php echo $user['email'] ?>
                        </li>
                    </ul>
                    <a href="favorites.php">
                        <h3 class="movie-title-upper">
                            <h2>Favorite Movies</h2>
                        </h3>
                    </a>
                    <hr>
                    <ul class="list-group">
                        <?php foreach ($movies as $movie): ?>
                            <li class="list-group-item">
                                <a href="movieDetails.php?movie_id=<?php echo $movie['id']; ?>">
                                    <h3 class="movie-title">
                                        <?php echo $movie['title']; ?>
                                    </h3>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <hr>
                    <div class="profile-title">
                        <h2>About Me</h2>
                    </div>

                    <p>
                        <?php echo $user['about'] ?>
                    </p>
                    <hr>
                    <div class="stat-box">
                        <h5>Comment Statistics</h5>
                        <div class="row">
                            <div class="col-md-6 mt-4 mb-4">
                                <div class="stat-label">Total Comments</div>
                                <div class="stat-value">
                                    <?php echo $commentCount; ?>
                                </div>
                            </div>
                            <div class="col-md-6 mt-4 mb-4">
                                <div class="stat-label">Most Commented Movie</div>
                                <div class="stat-value">
                                    <?php echo $maxComment; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="stat-box">
                        <h5>Like Statistics</h5>
                        <div class="row">
                            <div class="col-md-6 mt-4 mb-4">
                                <div class="stat-label">Total Favorites</div>
                                <div class="stat-value">
                                    <?php echo $likeCount; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>