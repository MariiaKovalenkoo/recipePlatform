<style>
    .footer {
        background-color: #ececec;
        padding: 10px 0;
    }

    .footer ul {
        margin: 0;
        padding: 0;
    }

    .footer .nav-item {
        list-style: none;
        display: inline-block;
        margin-right: 10px;
    }

    .footer .nav-link {
        color: #000000;
        text-decoration: none;
    }

    .footer .nav-link:hover {
        color: #177dfa;
    }
</style>


<footer class="footer">
    <div class="container">
        <ul class="nav justify-content-center">
            <li class="nav-item"><a href="/" class="nav-link">Explore</a></li>
            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) { ?>
                <li class="nav-item"><a href="/userPage" class="nav-link">User Page</a></li>
                <li class="nav-item"><a href="/login/logout" class="nav-link">Log Out</a></li>
            <?php } else { ?>
                <li class="nav-item"><a href="/signup" class="nav-link">Sign Up</a></li>
                <li class="nav-item"><a href="/login" class="nav-link">Login</a></li>
            <?php } ?>
        </ul>
    </div>
</footer>
        </main>
    </body>
</html>

