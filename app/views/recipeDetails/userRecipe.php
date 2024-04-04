<?php include __DIR__ . '/../header.php';
if ($recipe) {
    $recipeId = $recipe->getRecipeId();
    $isPublic = $recipe->getIsPublic();
    ?>

<div class="container">
    <section id="recipeDetailsSection" class="recipe-section-details">
        <h2 class="recipe-title"><?= $recipe->getRecipeName() ?></h2>
        <h4>Description:</h4><p><?= $recipe->getDescription() ?></p>
        <h4>Instructions:</h4>
        <p><?php echo $recipe->getIngredients(); ?></p>
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
        <?php if ($isPublic !== null) { ?>
            <p class="recipe-info" id="visibilityInfo">Visibility: <?= $isPublic ? 'Public' : 'Private'; ?></p>
        <?php } ?>
        <div class="row">
            <div class="col">
                <button id="changeVisibilityBtn" class="btn btn-primary change-visibility-button">
                    Make <?= $isPublic ? 'private' : 'public'; ?>
                </button>
            </div>
            <div class="col">
                <button id="editRecipeBtn" class="btn btn-secondary edit-button">Edit Recipe</button>
            </div>
            <div class="col">
                <button id="deleteRecipeBtn" class="btn btn-danger delete-button">Delete Recipe</button>
            </div>
        </div>
    </section>
</div>

    <?php
} else {
    echo "Recipe not found";
}
?>


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



