<?php include __DIR__ . '/../header.php';?>

<div class="container mt-4 mb-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <img src="<?= $recipe->getImgPath() ?>" class="card-img-top img-fluid" alt="<?= $recipe->getRecipeName() ?>" style="object-fit: cover; height: 400px;">
                <div class="card-body">
                    <h2 class="card-title text-center"><?= $recipe->getRecipeName() ?></h2>
                    <p class="card-text"><strong>Description:</strong><br><?= $recipe->getDescription() ?></p>
                    <p class="card-text"><strong>Ingredients:</strong><br><?= nl2br($recipe->getIngredients()) ?></p>
                    <p class="card-text"><strong>Instructions:</strong><br><?= nl2br($recipe->getInstructions()) ?></p>
                    <?php if ($recipe->getMealType()) { ?>
                        <p class="card-text"><strong>Meal Type:</strong><br><?= ucfirst(strtolower($recipe->getMealType())) ?></p>
                    <?php } ?>
                    <?php if ($recipe->getCuisineType() && $recipe->getCuisineType() !== 'NOT SPECIFIED') { ?>
                        <p class="card-text"><strong>Cuisine Type:</strong><br><?= ucfirst(strtolower($recipe->getCuisineType())) ?></p>
                    <?php } ?>
                    <?php if ($recipe->getDietaryPreference() && $recipe->getDietaryPreference() !== 'NOT SPECIFIED') { ?>
                        <p class="card-text"><strong>Dietary Preference:</strong><br><?= ucfirst(strtolower($recipe->getDietaryPreference())) ?></p>
                    <?php }
                    ?>
                </div>
                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) { ?>
                    <?php include __DIR__ . '/favBtn.php';?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) { ?>
<script>
    document.addEventListener('DOMContentLoaded', async () => {
        const recipeId = <?= json_encode($recipe->getRecipeId()) ?>;
        const toggleFavoriteBtn = document.getElementById('toggleFavoriteBtn');

        const checkFavoriteStatus = async () => {

            try {
                const response = await fetch(`/api/favorite/check?id=${recipeId}`);
                if (response.ok) {
                    const data = await response.json();
                    console.log(data);

                    toggleFavoriteBtn.dataset.favorite = data.isFavorite ? 'true' : 'false';
                    toggleFavoriteBtn.textContent = data.isFavorite ? 'Remove from Favorites' : 'Add to Favorites';
                } else {
                    const errorData = await response.json();
                    console.log(errorData.error);
                    showErrorMessage('Failed to check favorite status')
                }
            } catch (error) {
                console.error('Failed to check favorite status', error);
                showErrorMessage('Failed to check favorite status');
            }
        };

        toggleFavoriteBtn.addEventListener('click', async () => {
            const isFavorite = toggleFavoriteBtn.dataset.favorite === 'true';
            let endpoint = isFavorite ? '/api/favorite/remove' : '/api/favorite/add';
            let method = isFavorite ? 'DELETE' : 'POST';

            try {
                const response = await fetch(endpoint, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({id: recipeId}),
                });

                if (response.ok) {
                    const responseData = await response.json();
                    console.log(responseData);

                    showSuccessMessage(responseData.message);
                    toggleFavoriteBtn.dataset.favorite = isFavorite ? 'false' : 'true';
                    toggleFavoriteBtn.textContent = isFavorite ? 'Add to Favorites' : 'Remove from Favorites';
                } else {
                    const errorData = await response.json();
                    console.log(errorData.error);

                    showErrorMessage(errorData.error);
                }
            }
            catch (error) {
                console.error('Failed to update favorite status', error);
                showErrorMessage('Failed to update favorite status');
            }
        });

        await checkFavoriteStatus();
    });
</script>
<?php } ?>

<?php include __DIR__ . '/../footer.php'; ?>

