<?php
session_start();
include 'dbConnect.php';
include 'Services/MovieService.php';
include 'Services/LikeService.php';
include 'Services/CommentService.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}else{
	$user_id = 1;
}

$movie_id = $_GET['movie_id'];
$movie = getMovie($movie_id);
$likes = getLikes($movie_id);
$comments = getAllComments($movie_id);
$commentCount = getCommentCount($movie_id);

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
</head>

<body>
	<!-- Navbar -->
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<a class="navbar-brand" href="#">Movie Site</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
			aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNav">
			<ul class="navbar-nav">
				<li class="nav-item active">
					<a class="nav-link" href="#">Main Menu<span class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">Categories</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">Contact Us</a>
				</li>
			</ul>
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
				<h1 class="mb-4">
					<?php echo $movie['title']; ?>
				</h1>
				<p class="text-muted">
					<span class="badge badge-info mr-2">
						<?php echo $movie['genre']; ?>
					</span>
				</p>
				<hr>
				<p class="lead">Movie Description</p>
				<p>
					<?php echo $movie['description']; ?>
				</p>
				<hr>
				<div class="row">
					<div class="col-md-3">
						<h5 class="mb-3">Release Year</h5>
						<p>
							<?php echo $movie['release_year']; ?>
						</p>
					</div>
					<div class="col-md-3">
						<h5 class="mb-3">IMDb Point</h5>
						<p><?php echo $movie['imdb']; ?></p>
					</div>
					<div class="col-md-3">
						<h5 class="mb-3">Duration</h5>
						<p><?php echo $movie['duration']; ?> minutes</p>
					</div>
					<div class="col-md-3">
						<h5 class="mb-3">Favourites</h5>
						<p>
							<?php echo $likes; ?>
						</p>
					</div>
				</div>
				<button onclick="<?php addFavoriteMovie($user_id, $movie_id); ?>" type="button" class="btn btn-outline-warning">Favorilere Ekle
					<span class="ml-3 text-warning">
						<img class="img-icon-detail" src="assets/icons/empty-star.png">
					</span>
				</button>
				<hr>
				<h4 class="mb-4">Comments</h4>
				<!-- Yorum Ekleme -->
				<form>
					<div class="form-group">
						<label for="exampleFormControlTextarea1">Share your comment</label>
						<textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
					</div>
					<button type="submit" class="btn btn-primary">Send</button>
				</form>
				<hr>
				<!-- Yorum Listeleme -->
				<div class="card">
					<div class="card-header">
						Comments (<?php echo $commentCount; ?>)
					</div>
					<ul class="list-group list-group-flush">
						<?php
						if($commentCount > 0){
							foreach ($comments as $comment) {
						?>
							<li class="list-group-item">
								<p>
									<?php echo $comment['comment'] ?>
								</p>
								<small class="text-muted"> <?php echo $comment['username'] ?> - <?php echo $comment['created_at'] ?></small>
							</li>
							<?php
						}} 
						?>	
				</div>
			</div>

		</div>
	</div>
	<!-- JavaScript -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
		integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi4jq7Y"
		crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
		integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNS3U6N"></script>
</body>

</html>