<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Untitled</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="styles/login.css">
</head>

<body>
    <div class="login-dark">
        <form method="post">
            <h2 class="sr-only">Login Form</h2>
            <div class="illustration">
                <i class="icon ion-ios-play-outline"></i>
            </div>
            <div class="form-group">
                <input class="form-control" type="text" name="username" placeholder="Username">
            </div>
            <div class="form-group">
                <input class="form-control" type="password" name="password" placeholder="Password">
            </div>
            <div class="form-group"><button class="btn btn-primary btn-block" type="submit">Log In</button>
            </div>
            <a href="register.php" class="forgot">Register</a>
            <?php if (!empty($error)) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error; ?>
                </div>
            <?php } ?>
            <div class="mt-3 text-center">
                <span class="sp">Numan KILINCOGLU © 2023</span>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>

<?php
include 'Services/AuthService.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $pass = $_POST['password'];
        $user = login($username, $pass);
        if ($user != null) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $username;
            $_SESSION['avatar'] = $user['avatar'];
            header("location: main.php");
        } else {
            $error = "Error";
        }
    }
}
?>