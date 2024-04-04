<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header('Location: /home');
    exit();
} ?>

<?php include __DIR__ . '/signupheader.php'; ?>
<div class="container m-4">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body bg-warning-subtle">
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
        </div>
    </div>
</div>
</body>
</html>
