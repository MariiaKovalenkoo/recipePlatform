<?php use App\Models\Enums\CuisineType;
use App\Models\Enums\DietaryPreference;
use App\Models\Enums\EnumMapper;
use App\Models\Enums\MealType;

include __DIR__ . '/../header.php';

$encodedRecipe = json_encode($recipe);
//var_dump($encodedRecipe);
?>

<div class="container">
    <div class="row justify-content-center">
        <h3 class="text-center"> Edit a recipe </h3>
        <div class="col-md-6">
            <form id="recipe-form" class="p-4 border rounded shadow-sm" method="POST">
                <div class="mb-3">
                    <label for="recipeName" class="form-label">Recipe Name*:</label>
                    <input type="text" class="form-control" id="recipeName" name="recipeName">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description:</label>
                    <textarea class="form-control" id="description" name="description"></textarea>
                </div>
                <div class="mb-3">
                    <label for="ingredients" class="form-label">Ingredients*:</label>
                    <textarea class="form-control" id="ingredients" name="ingredients"></textarea>
                </div>
                <div class="mb-3">
                    <label for="instructions" class="form-label">Instructions*:</label>
                    <textarea class="form-control" id="instructions" name="instructions"></textarea>
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
                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        const recipe = <?= $encodedRecipe ?>;
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
                    });
                </script>
                <button type="submit" class="btn btn-primary" style="margin-bottom: 10px;">Save</button>
                <div class="alert alert-danger" id="error-container" style="display: none;"></div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('recipe-form');
        const errorContainer = document.getElementById('error-container');
        const recipeId = <?php echo json_encode($recipe->getRecipeId()); ?>;

        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const formData = new FormData(form);
            const payload = {
                recipeId: recipeId,
                recipeName: formData.get('recipeName'),
                description: formData.get('description'),
                ingredients: formData.get('ingredients'),
                instructions: formData.get('instructions'),
                cuisineType: formData.get('cuisineType'),
                dietaryPreference: formData.get('dietaryPreference'),
                mealType: formData.get('mealType'),
                isPublic: formData.get('isPublic') === 'true'
            };
            //console.log('Payload:', payload);
            try {
                const response = await fetch('/api/recipe/update', {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(payload),
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
                    errorContainer.textContent = errorData.error;
                    errorContainer.style.display = 'block';
                }
            } catch (error) {
                errorContainer.textContent = error;
                errorContainer.style.display = 'block';
            }
        });
    });
</script>

<?php include __DIR__ . '/../footer.php'; ?>
