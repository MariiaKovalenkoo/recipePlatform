<footer class="footer pt-3 pb-3 bg-secondary-subtle">
    <div>
        <ul class="nav justify-content-center">
            <li><a href="/" class="btn btn-link">Explore</a></li>
            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) { ?>
                <li><a href="/userPage" class="btn btn-link">User Page</a></li>
                <li><a href="/createRecipe" class="btn btn-link">Create New Recipe</a></li>
                <li><a href="/login/logout" class="btn btn-link">Log Out</a></li>
            <?php } else { ?>
                <li><a href="/signup" class="btn btn-link">Sign Up</a></li>
                <li><a href="/login" class="btn btn-link">Login</a></li>
            <?php } ?>
        </ul>
    </div>
</footer>
        </main>
    </body>
</html>

