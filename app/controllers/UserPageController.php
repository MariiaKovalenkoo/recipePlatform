<?php

namespace App\Controllers;

use App\Services\RecipeService;

class UserPageController
{
    private RecipeService $recipeService;

    function __construct()
    {
        $this-> recipeService = new RecipeService();
    }

   public function index(): void
    {
        session_start();
        $loggedInUser = $_SESSION['user'];
        $recipes = $this->recipeService->getAllRecipesByUser($loggedInUser->getUserId());
        require __DIR__ . '/../views/userPage/index.php';
    }
}