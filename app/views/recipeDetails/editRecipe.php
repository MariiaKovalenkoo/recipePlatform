<?php use App\Models\Enums\CuisineType;
use App\Models\Enums\DietaryPreference;
use App\Models\Enums\EnumMapper;
use App\Models\Enums\MealType;

include __DIR__ . '/../header.php';

//$encodedRecipe = json_encode($recipe);
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form id="recipe-form" class="p-4 border rounded shadow bg-light" method="POST" enctype="multipart/form-data">
                <h3 class="text-center mb-4">Edit a Recipe</h3>
                <input type="hidden" name="recipeId" id="recipeId" value="<?= $recipe->getRecipeId() ?>">
                <div class="mb-3">
                    <label for="recipeName" class="form-label">Recipe Name*:</label>
                    <input type="text" class="form-control" id="recipeName" name="recipeName" required>
                </div>

                <div class="mb-3">
                    <label for="imageUpload" class="form-label">Recipe Image:</label>
                    <input class="form-control" type="file" id="imageUpload" name="imageUpload" accept="image/png, image/jpeg">
                    <img class="imagePreview" src="<?= $recipe->getImgPath() ?>" alt="Image preview" style="max-width:50%; height:auto; margin:10px"/>
                    <div class="form-text">Accepted formats: .jpg, .png (Max size: 10MB)</div>
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
                        <?php endforeach; ?>                    </select>
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
                    <a href="/recipeDetails?id=<?= $recipe->getRecipeId() ?>" class="btn btn-primary">View recipe</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const recipe = <?php echo json_encode($recipe); ?>;

        //console.log(recipe);
        if (Object.keys(recipe).length !== 0) {
            document.getElementById('recipeName').value = recipe.recipeName;
            document.getElementById('description').value = recipe.description;
            document.getElementById('ingredients').value = recipe.ingredients;
            document.getElementById('instructions').value = recipe.instructions;
            document.getElementById('cuisineType').value = recipe.cuisineType;
            document.getElementById('dietaryPreference').value = recipe.dietaryPreference;
            document.getElementById('mealType').value = recipe.mealType;
            document.getElementById('isPublic').value = recipe.isPublic;
        }

        const form = document.getElementById('recipe-form');

        form.addEventListener('blur', async (e) => {
            if (e.target.matches('input:not([type="file"]), textarea, select')) {
                const fieldName = e.target.name;
                const value = e.target.value;
                const recipeId = document.getElementById('recipeId').value;

                const trimmedValue = e.target.value.trim();

                if (recipe[fieldName] === trimmedValue) {
                    console.log(`${fieldName} is unchanged.`);
                    return;
                }

                const data = { fieldName, value, recipeId };
                try {
                    const response = await fetch('/api/recipe/updateField', {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(data),
                    });

                    if (response.ok) {
                        const responseData = await response.json();
                        console.log(responseData);
                        showSuccessMessage(responseData.data.message);
                        recipe[fieldName] = value;
                    } else {
                        const errorData = await response.json();
                        console.log(errorData.error);
                        showErrorMessage(errorData.error);
                        e.target.value = recipe[fieldName] || '';
                    }
                } catch (error) {
                    console.error(error);
                    showErrorMessage('Error updating field.');
                    e.target.value = recipe[fieldName] || '';
                }
            }
        }, true);

        form.addEventListener('change', async (e) => {
            if (e.target.matches('input[type="file"]')) {
                const fileInput = e.target;
                const fieldName = fileInput.name;
                const files = fileInput.files;
                if (files.length > 0) {
                    const formData = new FormData();
                    formData.append(fieldName, files[0]);
                    formData.append('recipeId', document.getElementById('recipeId').value);

                    try {
                        const response = await fetch('/api/recipe/updateImage', {
                            method: 'POST',
                            body: formData,
                        });

                        if (response.ok) {
                            const responseData = await response.json();
                            console.log(responseData.data);
                            showSuccessMessage(responseData.data.message);
                        } else {
                            const errorData = await response.json();
                            showErrorMessage(errorData.error);
                        }
                    } catch (error) {
                        console.error(error);
                        showErrorMessage('Error updating image.');
                    }
                }
            }
        });
    });
</script>

<?php include __DIR__ . '/../footer.php'; ?>
