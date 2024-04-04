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
        <div class="container mt-4">
            <div class="btn-group"><a href="/createRecipe" class="btn btn-primary">Create New Recipe</a></div>
            <div class="row">
                <h2 class="text-center">Your recipes</h2>
                <?php foreach ($recipes as $recipe) { ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="recipe-image-container">
                            <img src="<?= $recipe->getImgPath() ?>" class="card-img-top img-fluid" alt="Recipe Image" style="height: 200px; object-fit: cover;">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold text-center"><?= $recipe->getRecipeName() ?></h5>
                            <p class="card-text"><strong>Description: </strong><?= $recipe->getDescription() ?></p>
                            <p class="card-text"><strong>Ingredients: </strong><?= $recipe->getIngredients() ?></p>
                            <?php if ($recipe->getMealType()) { ?>
                                <p class="card-text"><strong>Meal Type: </strong><?= ucfirst(strtolower($recipe->getMealType())) ?></p>
                            <?php } ?>
                            <?php if ($recipe->getCuisineType() && $recipe->getCuisineType() !== 'NOT SPECIFIED') { ?>
                                <p class="card-text"><strong>Cuisine Type: </strong><?= ucfirst(strtolower($recipe->getCuisineType())) ?></p>
                            <?php } ?>
                            <?php if ($recipe->getDietaryPreference() && $recipe->getDietaryPreference() !== 'NOT SPECIFIED') { ?>
                                <p class="card-text"><strong>Dietary Preference: </strong><?= ucfirst(strtolower($recipe->getDietaryPreference())) ?></p>
                            <?php } ?>
                        </div>
                        <div class="card-footer text-center">
                            <a href="/recipeDetails?id=<?= $recipe->getRecipeId() ?>" class="btn btn-primary">View recipe</a>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>

        <?php if (count($favRecipes) > 0) { ?>
        <div class="container mt-4">
            <div class="row">
                <h2 class="text-center">Your favorite recipes</h2>
                <?php foreach ($favRecipes as $favRecipe) { ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="recipe-image-container">
                                <img src="<?= $favRecipe->getRecipe()->getImgPath() ?>" class="card-img-top img-fluid" alt="Recipe Image" style="height: 200px; object-fit: cover;">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title fw-bold text-center"><?= $favRecipe->getRecipe()->getRecipeName() ?></h5>
                                <p class="card-text"><strong>Description: </strong><?= $favRecipe->getRecipe()->getDescription() ?></p>
                                <p class="card-text"><strong>Ingredients: </strong><?= $favRecipe->getRecipe()->getIngredients() ?></p>
                                <?php if ($favRecipe->getRecipe()->getMealType()) { ?>
                                    <p class="card-text"><strong>Meal Type: </strong><?= ucfirst(strtolower($favRecipe->getRecipe()->getMealType())) ?></p>
                                <?php } ?>
                                <?php if ($favRecipe->getRecipe()->getCuisineType() && $favRecipe->getRecipe()->getCuisineType() !== 'NOT SPECIFIED') { ?>
                                    <p class="card-text"><strong>Cuisine Type: </strong><?= ucfirst(strtolower($favRecipe->getRecipe()->getCuisineType())) ?></p>
                                <?php } ?>
                                <?php if ($favRecipe->getRecipe()->getDietaryPreference() && $favRecipe->getRecipe()->getDietaryPreference() !== 'NOT SPECIFIED') { ?>
                                    <p class="card-text"><strong>Dietary Preference: </strong><?= ucfirst(strtolower($favRecipe->getRecipe()->getDietaryPreference())) ?></p>
                                <?php } ?>
                            </div>
                            <div class="card-footer text-center">
                                <a href="/recipeDetails?id=<?= $favRecipe->getRecipe()->getRecipeId() ?>" class="btn btn-primary">View recipe</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } else { ?>
        <div class="container mt-4">
            <div class="row">
                <h2 class="text-center">Your favorite recipes</h2>
                <p class="text-center">You have not added any recipes to your favorites yet.</p>
            </div>
            <div class="text-center">
                <a href="/home" class="btn btn-success mb-4">Explore!</a>
            </div>
        </div>
    <?php } ?>
    </div>

<?php include __DIR__ . '/../footer.php';?>