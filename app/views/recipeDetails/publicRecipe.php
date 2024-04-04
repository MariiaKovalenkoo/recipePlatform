<?php include __DIR__ . '/../header.php';
$recipeId = $recipe->getRecipeId();
?>

<div class="container mt-4 mb-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <img src="<?= $recipe->getImgPath() ?>" class="card-img-top img-fluid" alt="<?= $recipe->getRecipeName() ?>" style="object-fit: cover; height: 400px;">
                <div class="card-body">
                    <h2 class="card-title text-center"><?= $recipe->getRecipeName() ?></h2>
                    <p class="card-text"><strong>Description:</strong> <?= $recipe->getDescription() ?></p>
                    <p class="card-text"><strong>Ingredients:</strong> <?= nl2br($recipe->getIngredients()) ?></p>
                    <p class="card-text"><strong>Instructions:</strong> <?= nl2br($recipe->getInstructions()) ?></p>
                    <?php if ($recipe->getMealType()) { ?>
                        <p class="card-text"><strong>Meal Type:</strong> <?= ucfirst(strtolower($recipe->getMealType())) ?></p>
                    <?php } ?>
                    <?php if ($recipe->getCuisineType() && $recipe->getCuisineType() !== 'NOT SPECIFIED') { ?>
                        <p class="card-text"><strong>Cuisine Type:</strong> <?= ucfirst(strtolower($recipe->getCuisineType())) ?></p>
                    <?php } ?>
                    <?php if ($recipe->getDietaryPreference() && $recipe->getDietaryPreference() !== 'NOT SPECIFIED') { ?>
                        <p class="card-text"><strong>Dietary Preference:</strong> <?= ucfirst(strtolower($recipe->getDietaryPreference())) ?></p>
                    <?php }
                    ?>
                </div>
                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) { ?>
                    <div class="card-footer text-center">
                        <div class="btn-group">
                            <button id="toggleFavoriteBtn" class="btn btn-info" data-favorite="unknown"> hello</button>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/../footer.php'; ?>

