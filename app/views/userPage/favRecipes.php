<div class="container mt-4">
    <?php if (count($favRecipes) > 0) { ?>
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
    <?php } else { ?>
        <div class="row">
            <h2 class="text-center">Your favorite recipes</h2>
            <p class="text-center">You have not added any recipes to your favorites yet.</p>
        </div>
        <div class="text-center">
            <a href="/home" class="btn btn-success mb-4">Explore!</a>
        </div>
    <?php } ?>
</div>
