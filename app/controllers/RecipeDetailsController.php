<?php
namespace App\Controllers;

use App\Services\RecipeService;

class RecipeDetailsController
{
    private RecipeService $recipeService;

    function __construct()
    {
        $this-> recipeService = new RecipeService();
    }

    public function index(): void
    {
        session_start();
        $recipeId = $_GET['id'];
        $recipe = $this->recipeService->getRecipeById($recipeId);

        if ($recipe === null) {
            header('Location: /home');
            exit();
        }
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
            if ($recipe->getUserId() === $_SESSION['user']->getUserId()) {
                require __DIR__ . '/../views/recipeDetails/userRecipe.php';
            }
            else {
                require __DIR__ . '/../views/recipeDetails/publicRecipe.php';
            }
        }
        else
            require __DIR__ . '/../views/recipeDetails/publicRecipe.php';
    }
}