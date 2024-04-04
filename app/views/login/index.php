<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header('Location: /home');
    exit();
}
?>
<?php include __DIR__ . '/loginheader.php'; ?>

<div class="container m-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body bg-warning-subtle">
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
        </div>
    </div>
</div>
</body>
</html>

