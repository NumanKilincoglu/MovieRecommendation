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
	$movie_id = $_GET['movie_id'];
	$movie = getMovie($movie_id);
	$likes = getLikes($movie_id);
	$comments = getAllComments($movie_id);
	$commentCount = getCommentCount($movie_id);
	$star_path = getMovieLikeByUser($movie_id, $user_id) ? "star" : "empty-star";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Film Detay Sayfası</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
		integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" href="styles/style.css">
	<link rel="stylesheet" href="styles/footer.css">
</head>

<body>
	<!-- Navbar -->
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
	<!-- Film Detay -->
	<div class="container my-4">
		<div class="row">
			<div class="col-md-4">
				<img style="height: 450px; width: 280px;"
					src="<?php echo "assets/movies/" . $movie['image_path'] . ".jpg"; ?>" alt="...">
			</div>
			<div class="col-md-8">
				<h1 class="mb-4 text-white">
					<?php echo $movie['title']; ?>
				</h1>
				<p class="text-muted text-white">
					<span class="badge badge-info mr-2">
						<?php echo $movie['genre']; ?>
					</span>
				</p>
				<hr class="hr-line">
				<p class="lead text-white">Movie Description</p>
				<p class="text-white">
					<?php echo $movie['description']; ?>
				</p>
				<hr class="hr-line">
				<div class="row text-white">
					<div class="col-md-3">
						<h5 class="mb-3">Release Year</h5>
						<p>
							<?php echo $movie['release_year']; ?>
						</p>
					</div>
					<div class="col-md-3">
						<h5 class="mb-3">IMDb</h5>
						<p>
							<?php echo $movie['imdb']; ?>
						</p>
					</div>
					<div class="col-md-3">
						<h5 class="mb-3">Duration</h5>
						<p>
							<?php echo $movie['duration']; ?> minutes
						</p>
					</div>
					<div class="col-md-3">
						<h5 class="mb-3">Favourites</h5>
						<p>
							<?php echo $likes; ?>
						</p>
					</div>
				</div>
				<?php
				if (array_key_exists('addFav', $_POST)) {
					addFavoriteMovie($user_id, $movie_id);
					$star_path = "star";
				}
				if (array_key_exists('sendComment', $_POST)) {
					$commentText = $_POST['commentText'];
					addComment($user_id, $movie_id, $commentText);
				}
				?>
				<form method="post">
					<input class="btn btn-outline-warning" type="submit" name="addFav" class="button"
						value="Add Favorite">
					<span class="ml-3 text-warning">
						<img class="img-icon-detail" src="assets/icons/<?php echo $star_path?>.png">
					</span>
					</input>
				</form>
				<hr class="hr-line">
				<h4 class="mb-4 text-white">Comments</h4>
				<!-- Yorum Ekleme -->
				<form method="post">
					<div class="form-group text-white">
						<label for="text">Share your comment</label>
						<textarea class="form-control" id="exampleFormControlTextarea1" name="commentText"
							rows="3"></textarea>
					</div>
					<input class="btn btn-primary" type="submit" name="sendComment" class="button"
						value="Share Comment">
				</form>
				<hr>
				<!-- Comment List -->
				<div class="card">
					<div class="card-header">
						Comments (
						<?php echo $commentCount; ?>)
					</div>
					<ul class="list-group list-group-flush">
						<?php
						if ($commentCount > 0) {
							foreach ($comments as $comment) {
								?>
								<li class="list-group-item">
									<p>
										<?php echo $comment['comment'] ?>
									</p>
									<small class="text-muted">
										<?php echo $comment['username'] ?> -
										<?php echo $comment['created_at'] ?>
									</small>
								</li>
								<?php
							}
						}
						?>
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
	<!-- JavaScript -->
	<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
	<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
		integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi4jq7Y"
		crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
		integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNS3U6N"></script>
</body>

</html>