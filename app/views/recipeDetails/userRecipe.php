<?php include __DIR__ . '/../header.php';
$recipeId = $recipe->getRecipeId();
$isPublic = $recipe->getIsPublic();
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
                    <?php } ?>
                    <?php if ($isPublic !== null) { ?>
                        <p class="card-text fw-bold" id="visibilityInfo"><strong>Visibility:</strong> <?= $isPublic ? 'Public' : 'Private'; ?></p>
                    <?php } ?>
                </div>
                <div class="card-footer d-flex justify-content-center">
                    <div class="btn-group d-flex justify-content-center">
                        <button id="toggleVisibilityBtn" class="btn change-visibility-button rounded me-4" data-favorite="unknown">Loading...</button>
                        <a href="/recipeDetails/download?id=<?= $recipe->getRecipeId() ?>" class="btn save-button rounded me-4">Download Recipe PDF</a>
                        <a href="/editRecipe?id=<?= $recipe->getRecipeId() ?>" class="btn edit-button rounded me-4">Edit Recipe</a>
                        <button id="deleteRecipeBtn" class="btn delete-button rounded">Delete Recipe</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const updateButtonVisibility = (isPublic) => {
        const toggleVisibilityBtn = document.getElementById('toggleVisibilityBtn');
        const visibilityInfo = document.getElementById('visibilityInfo');

        toggleVisibilityBtn.dataset.visibility = isPublic ? 'true' : 'false';
        toggleVisibilityBtn.textContent = isPublic ? 'Make Private' : 'Make Public';
        visibilityInfo.textContent = `Visibility: ${isPublic ? 'Public' : 'Private'}`;
    };

    document.addEventListener('DOMContentLoaded', async () => {
        const recipeId = <?= json_encode($recipe->getRecipeId()) ?>;

        const deleteRecipeBtn = document.getElementById('deleteRecipeBtn');
        const toggleVisibilityBtn = document.getElementById('toggleVisibilityBtn');

        const checkVisibilityStatus = async () => {
            const response = await fetch(`/api/recipe/getVisibility?id=${recipeId}`);
            if (response.ok) {
                const data = await response.json();
                updateButtonVisibility(data.isPublic);
            } else {
                const errorData = await response.json();
                console.log(errorData.error);
                showErrorMessage('Failed to check visibility status');
            }
        };

        toggleVisibilityBtn.addEventListener('click', async () => {
            let method = 'POST';

            const response = await fetch('/api/recipe/changeVisibility', {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({id: recipeId}),
            });

            if (response.ok) {
                const responseData = await response.json();
                showSuccessMessage(responseData.data.message);
                updateButtonVisibility(responseData.isPublic);
            } else {
                const errorData = await response.json();
                console.log(errorData.error);
                showErrorMessage(errorData.error);
            }
        });

        const deleteRecipe = async () => {
            const confirmed = confirm('Are you sure you want to delete this recipe?');
            if (confirmed) {
                try {
                    const response = await fetch('/api/recipe/delete', {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ id: recipeId }),
                    });
                    if (response.ok) {
                        window.location.href = `/userPage`;
                    } else {
                        const errorData = await response.json();
                        showErrorMessage(errorData.error);
                    }
                } catch (error) {
                    showErrorMessage('Failed to delete recipe');
                    console.error('Error deleting recipe', error);
                }
            }
        };
        deleteRecipeBtn.addEventListener('click', deleteRecipe);

        await checkVisibilityStatus();
    });
</script>

<?php include __DIR__ . '/../footer.php'; ?>



