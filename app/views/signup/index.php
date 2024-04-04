<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header('Location: /home');
    exit();
} ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        .signup-form {
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
            <li class="nav-item"><a href="/login" class="nav-link">Login</a></li>
        </ul>
    </header>
</div>
<div class="container">

    <div class="signup-form">
        <h2 class="text-center mb-4">Sign Up</h2>
        <?php if (isset($_SESSION['error'])) : ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error']; ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form action="/signup/signup" method="POST">
            <div class="mb-3">
                <label for="firstName" class="form-label">First Name:</label>
                <?php $firstNameValue = $_SESSION['userInput']['firstName'] ?? ''; ?>
                <input type="text" class="form-control" id="firstName" name="firstName" value="<?= $firstNameValue; ?>">
                <?php unset($_SESSION['userInput']['firstName']); ?>
            </div>
            <div class="mb-3">
                <label for="lastName" class="form-label">Last Name:</label>
                <?php $lastNameValue = $_SESSION['userInput']['lastName'] ?? ''; ?>
                <input type="text" class="form-control" id="lastName" name="lastName" value="<?= $lastNameValue; ?>">
                <?php unset($_SESSION['userInput']['lastName']); ?>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <?php $emailValue = $_SESSION['userInput']['email'] ?? ''; ?>
                <input type="text" class="form-control" id="email" name="email" value="<?= $emailValue; ?>">
                <?php unset($_SESSION['userInput']['email']); ?>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <?php $usernameValue = $_SESSION['userInput']['username'] ?? ''; ?>
                <input type="text" class="form-control" id="username" name="username" value="<?= $usernameValue; ?>">
                <?php unset($_SESSION['userInput']['username']); ?>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <p class="text-center mb-3">Already have an account? <a href="/login">Log in</a></p>
            <button type="submit" class="btn btn-primary d-block mx-auto">Sign Up</button>
        </form>
    </div>
</div>
</body>
</html>
