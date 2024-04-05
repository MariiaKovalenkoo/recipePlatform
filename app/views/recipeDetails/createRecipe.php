<?php use App\Models\Enums\CuisineType;
use App\Models\Enums\DietaryPreference;
use App\Models\Enums\EnumMapper;
use App\Models\Enums\MealType;

include __DIR__ . '/../header.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <form id="recipe-form" class="p-4 border rounded shadow bg-light" method="POST" enctype="multipart/form-data">
                <h3 class="text-center mb-4">Create a Recipe</h3>
                <div class="mb-3">
                    <label for="recipeName" class="form-label">Recipe Name*:</label>
                    <input type="text" class="form-control" id="recipeName" name="recipeName" required>
                </div>

                <div class="mb-3">
                    <label for="imageUpload" class="form-label">Recipe Image*:</label>
                    <input class="form-control bg-info-subtle" type="file" id="imageUpload" name="imageUpload" required accept="image/png, image/jpeg">
                    <img class="imagePreview" src="" alt="Image preview" style="display:none; max-width:50%; height:auto; margin:10px"/>
                    <div class="form-text">Accepted formats: .jpg, .png (Max size: 5MB)</div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description:</label>
                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                </div>

                <div class="mb-3">
                    <label for="ingredients" class="form-label">Ingredients*:</label>
                    <textarea class="form-control" id="ingredients" name="ingredients" required rows="4"></textarea>
                </div>

                <div class="mb-3">
                    <label for="instructions" class="form-label">Instructions*:</label>
                    <textarea class="form-control" id="instructions" name="instructions" required rows="4"></textarea>
                </div>
                <div class="mb-3">
                    <label for="cuisineType" class="form-label">Cuisine Type:</label>
                    <select class="form-select" id="cuisineType" name="cuisineType" required>
                        <?php foreach (EnumMapper::toArray(CuisineType::class) as $value => $label): ?>
                            <option value="<?= $value ?>"><?= ucfirst(strtolower($label)) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="dietaryPreference" class="form-label">Dietary Preference:</label>
                    <select class="form-select" id="dietaryPreference" name="dietaryPreference" required>
                        <?php foreach (EnumMapper::toArray(DietaryPreference::class) as $value => $label): ?>
                            <option value="<?= $value ?>"><?= ucfirst(strtolower($label)) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="mealType" class="form-label">Meal Type* (this field is mandatory):</label>
                    <select class="form-select" id="mealType" name="mealType" required>
                        <?php foreach (EnumMapper::toArray(MealType::class) as $value => $label): ?>
                            <option value="<?= $value ?>"><?= ucfirst(strtolower($label)) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="isPublic" class="form-label">Visibility:</label>
                    <select class="form-select" id="isPublic" name="isPublic" required>
                        <option value="false">Private</option>
                        <option value="true">Public</option>
                    </select>
                </div>

                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary">Create Recipe</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('recipe-form');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(form);
        formData.set('isPublic', formData.get('isPublic') === 'true' ? 'true' : 'false');

        try {
            const response = await fetch('/api/recipe/create', {
                method: 'POST',
                body: formData,
            });

            if (response.ok) {
                const responseData = await response.json();
                console.log(responseData.data);
                const recipeId = responseData.data.recipeId;

                if (recipeId !== undefined) {
                    window.location.href = `/recipeDetails?id=${recipeId}`;
                } else {
                    console.log('Recipe ID not found, redirecting to userPage');
                    window.location.href = '/userPage';
                }
            } else {
                const errorData = await response.json();
                showErrorMessage(errorData.error);
            }
        } catch (error) {
            console.log(error)
            showErrorMessage("Error while creating the recipe. Please try again.")
        }
    });
});
</script>

<?php include __DIR__ . '/../footer.php'; ?>

