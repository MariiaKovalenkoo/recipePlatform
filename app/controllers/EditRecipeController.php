<?php

namespace App\Controllers;

use App\Services\RecipeService;

class EditRecipeController
{
    private RecipeService $recipeService;

    function __construct()
    {
        $this-> recipeService = new RecipeService();
    }

    public function index(): void
    {
        session_start();
        if (isset($_GET['id'])) {
            $recipeId = $_GET['id'];
            $recipe = $this->recipeService->getRecipeById($recipeId);
        }
        require __DIR__ . '/../views/recipeDetails/editRecipe.php';
    }
}