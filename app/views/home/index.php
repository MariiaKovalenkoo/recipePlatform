<?php include __DIR__ . '/../header.php'; ?>

<div class="container-fluid px-0">
    <div class="row">
        <div class="col-md-12 p-0">
            <div style="position: relative; overflow: hidden;">
                <img src="/img/headers/home.jpg" class="img-fluid w-100" alt="Recipe Platform Image">
                <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: black; text-align: center; font-size: 40px; font-weight: bold; padding: 10px;">Welcome to the Recipe Platform!</div>
            </div>
        </div>
    </div>
    <div class="container mt-4">
        <div class="row">
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
</div>

<?php include __DIR__ . '/../footer.php'; ?>
