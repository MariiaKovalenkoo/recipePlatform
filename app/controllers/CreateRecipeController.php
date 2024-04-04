<?php

namespace App\Controllers;

class CreateRecipeController
{
    public function index(): void
    {
        session_start();
        require __DIR__ . '/../views/recipeDetails/createRecipe.php';
    }
}