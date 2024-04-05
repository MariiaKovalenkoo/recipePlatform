<?php

namespace App\Controllers;

use App\Services\FavoriteService;
use App\Services\RecipeService;

class UserPageController
{
    private RecipeService $recipeService;
    private FavoriteService $favoriteService;

    function __construct()
    {
        $this-> recipeService = new RecipeService();
        $this->favoriteService = new FavoriteService();
    }

    public function index(): void
    {
        session_start();
        $loggedInUser = $_SESSION['user'];
        $recipes = $this->recipeService->getAllRecipesByUser($loggedInUser->getUserId());
        $favRecipes = $this->favoriteService->getFavoritesByUser($loggedInUser->getUserId());
        require __DIR__ . '/../views/userPage/index.php';
    }

}