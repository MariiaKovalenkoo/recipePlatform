<?php include __DIR__ . '/../header.php';

if ($recipe) {
    ?>
    <section class="recipe-section-details">
        <h2 class="recipe-title"><?= $recipe->getRecipeName() ?></h2>
        <h4>Description:</h4><p><?= $recipe->getDescription() ?></p>
        <h4>Ingredients:</h4>
        <ul>
            <?php
            $ingredients = explode(',', $recipe->getIngredients()); // Assuming comma-separated ingredients
            foreach ($ingredients as $ingredient) {
                echo "<li>$ingredient</li>";
            }
            ?>
        </ul>
        <h4>Instructions:</h4>
           <p><?php echo $recipe->getInstructions(); ?></p>

        <?php if ($recipe->getMealType()) { ?>
            <p class="recipe-info">Meal Type: <?= ucfirst(strtolower($recipe->getMealType())) ?></p>
        <?php } ?>
        <?php if ($recipe->getCuisineType() && $recipe->getCuisineType() !== 'NOT SPECIFIED') { ?>
            <p class="recipe-info">Cuisine Type: <?= ucfirst(strtolower($recipe->getCuisineType())) ?></p>
        <?php } ?>
        <?php if ($recipe->getDietaryPreference() && $recipe->getDietaryPreference() !== 'NOT SPECIFIED') { ?>
            <p class="recipe-info">Dietary Preference: <?= ucfirst(strtolower($recipe->getDietaryPreference())) ?></p>
        <?php } ?>
    </section>
    <?php
} else {
    echo "Recipe not found";
}
?>

<?php include __DIR__ . '/../footer.php'; ?>

