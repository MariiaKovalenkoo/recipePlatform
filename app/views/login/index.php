<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header('Location: /home'); // Redirect to the home page or user dashboard
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        .login-form {
            max-width: 400px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
<div class="container">
    <header class="d-flex justify-content-center py-3">
        <ul class="nav nav-pills">
            <li class="nav-item"><a href="/" class="nav-link">Explore</a></li>
            <li class="nav-item"><a href="/signup" class="nav-link">Sign up</a></li>
        </ul>
    </header>
</div>
<div class="container">
    <div class="login-form">
        <h2 class="text-center mb-4">Log in</h2>
        <p class="text-center mb-3">Please enter username and password.</p>
            <?php if (isset($_SESSION['error'])) : ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error']; ?></div>
            <?php unset($_SESSION['error']); ?>
            <?php endif; ?>
        <form class="mb-4" action="/login/authenticate" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" class="form-control" id="username" name="username">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <p class="text-center mb-3">Don't have an account yet? <a href="/signup">Sign up</a></p>
            <button type="submit" class="btn btn-primary d-block mx-auto">Login</button>
        </form>
    </div>
</div>
</body>
</html>

