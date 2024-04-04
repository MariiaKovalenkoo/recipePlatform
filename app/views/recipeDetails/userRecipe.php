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
                        <button id="changeVisibilityBtn" class="btn change-visibility-button rounded me-4"></button>
                        <button id="editRecipeBtn" class="btn edit-button rounded me-4">Edit Recipe</button>
                        <button id="deleteRecipeBtn" class="btn delete-button rounded">Delete Recipe</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const updateButtonVisibility = (isPublic) => {
        const changeVisibilityBtn = document.getElementById('changeVisibilityBtn');
        const visibilityInfo = document.getElementById('visibilityInfo');

        if (isPublic !== null) {
            visibilityInfo.textContent = `Visibility: ${isPublic ? 'Public' : 'Private'}`;
            changeVisibilityBtn.textContent = `Make ${isPublic ? 'private' : 'public'}`;
        }
    };

    document.addEventListener('DOMContentLoaded', async () => {
        const recipeId = <?= json_encode($recipeId) ?>;

        const fetchRecipeVisibility = async () => {
            try {
                const response = await fetch(`api/recipe/getVisibility?id=${recipeId}`, {
                    method: 'GET',
                });
                if (response.ok) {
                    const responseData = await response.json();
                    const isRecipePublic = responseData.isPublic;
                    updateButtonVisibility(isRecipePublic);
                } else {
                    console.error('Failed to fetch visibility');
                }
            } catch (error) {
                console.error('Error fetching visibility', error);
            }
        };

        const changeVisibility = async () => {
            try {
                const response = await fetch(`/api/recipe/changeVisibility?id=${recipeId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                });
                if (response.ok) {
                    const responseData = await response.json();
                    console.log('Response Data:', responseData);
                    updateButtonVisibility(responseData.isPublic);
                } else {
                    console.error('Failed to change visibility');
                }
            } catch (error) {
                console.error('Error changing visibility', error);
            }
        };


        const deleteRecipe = async () => {
            const confirmed = confirm('Are you sure you want to delete this recipe?');
            if (confirmed) {
                try {
                    const response = await fetch(`/api/recipe/delete?id=${recipeId}`, {
                        method: 'DELETE',
                    });

                    if (response.ok) {
                        window.location.href = `/userPage`;
                    } else {
                        console.error('Failed to delete recipe');
                    }
                } catch (error) {
                    console.error('Error deleting recipe', error);
                }
            }
        };

        const changeVisibilityBtn = document.getElementById('changeVisibilityBtn');
        const editRecipeBtn = document.getElementById('editRecipeBtn');
        const deleteRecipeBtn = document.getElementById('deleteRecipeBtn');

        await fetchRecipeVisibility();

        editRecipeBtn.addEventListener('click', () => {
            window.location.href = `/editRecipe?id=${recipeId}`;
        });

        changeVisibilityBtn.addEventListener('click', changeVisibility);
        deleteRecipeBtn.addEventListener('click', deleteRecipe);
    });
</script>

<?php include __DIR__ . '/../footer.php'; ?>



