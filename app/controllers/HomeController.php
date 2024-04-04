<?php

namespace App\Controllers;
use App\Services\RecipeService;

class HomeController
{
    private RecipeService $recipeService;

    function __construct()
    {
        $this->recipeService = new RecipeService();
    }

    public function index(): void
    {
        session_start();

        $loggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
        $loginStatus = $loggedIn ? 'Logged in' : 'Not logged in';

        $recipes = $this->recipeService->getAllPublicRecipes();
        require __DIR__ . '/../views/home/index.php';
    }
}