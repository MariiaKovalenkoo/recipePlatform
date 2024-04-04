<!DOCTYPE html>
<html lang="en">
<head>
    <title>Recipe Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/css/styles.css">
    <style>

    </style>
</head>
<body>
<main>
    <div class="container">
        <header class="d-flex justify-content-center py-3">
            <ul class="nav nav-pills">
                <li class="nav-item"><a href="/" class="nav-link">Explore</a></li>
                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) { ?>
                    <li class="nav-item"><a href="/userPage" class="nav-link">User Page</a></li>
                    <li class="nav-item"><a href="/login/logout" class="nav-link">Log Out</a></li>
                <?php } else { ?>
                    <li class="nav-item"><a href="/signup" class="nav-link">Sign Up</a></li>
                    <li class="nav-item"><a href="/login" class="nav-link">Login</a></li>
                <?php } ?>
            </ul>
        </header>
    </div>

