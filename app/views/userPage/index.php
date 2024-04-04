<?php include __DIR__ . '/../header.php'; ?>

    <div class="container-fluid px-0">
        <div class="row">
            <div class="col-md-12 p-0">
                <div style="position: relative; overflow: hidden;">
                    <img src="/img/headers/userpage.jpg" class="img-fluid w-100" alt="Recipe Platform User Page Image">
                    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: black; text-align: center; font-size: 40px; font-weight: bold; padding: 10px;">Hello, <?php echo $loggedInUser->getFullName(); ?>!</div>
                </div>
            </div>
        </div>
        <?php include __DIR__ . '/userRecipes.php';?>
        <?php include __DIR__ . '/favRecipes.php';?>
    </div>

<?php include __DIR__ . '/../footer.php';?>