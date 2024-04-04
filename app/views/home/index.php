<?php include __DIR__ . '/../header.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="header-image">
                <img src="/img/header.jpg" class="img-fluid mx-auto d-block mb-4" alt="Recipe Platform Image">
                <div class="header-title">Welcome to the Recipe Platform!</div>
            </div>
        </div>
    </div>
    <div class="row">
        <!--<p><?php echo $loginStatus; ?></p> -->
        <?php foreach ($recipes as $recipe) { ?>
            <div class="col-md-6">
                <section class="recipe-section">
                    <a href="/recipeDetails?id=<?= $recipe->getRecipeId() ?>" class="recipe-link">
                        <h2 class="recipe-title"><?= $recipe->getRecipeName() ?></h2>
                        <p class="recipe-info">Description: <?= $recipe->getDescription() ?></p>
                        <p class="recipe-info">Ingredients: <?= $recipe->getIngredients() ?></p>
                        <?php if ($recipe->getMealType()) { ?>
                            <p class="recipe-info">Meal Type: <?= ucfirst(strtolower($recipe->getMealType())) ?></p>
                        <?php } ?>
                        <?php if ($recipe->getCuisineType() && $recipe->getCuisineType() !== 'NOT SPECIFIED') { ?>
                            <p class="recipe-info">Cuisine Type: <?= ucfirst(strtolower($recipe->getCuisineType())) ?></p>
                        <?php } ?>
                        <?php if ($recipe->getDietaryPreference() && $recipe->getDietaryPreference() !== 'NOT SPECIFIED') { ?>
                            <p class="recipe-info">Dietary Preference: <?= ucfirst(strtolower($recipe->getDietaryPreference())) ?></p>
                        <?php } ?>
                    </a>
                </section>
            </div>
        <?php } ?>
    </div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
