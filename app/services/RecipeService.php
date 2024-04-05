<?php

namespace App\Services;

use App\Models\Recipe;
use App\Repositories\RecipeRepository;

class RecipeService
{
    public function getAllPublicRecipes(): array
    {
        $repository = new RecipeRepository();
        return $repository->getAllPublicRecipes();
    }

    public function getAllRecipesByUser($userId): array
    {
        $repository = new RecipeRepository();
        return $repository->getAllRecipesByUser($userId);
    }

    public function getRecipeById($recipeId): ?Recipe{
        $repository = new RecipeRepository();
        return $repository->getRecipeById($recipeId);
    }

    public function createRecipe(Recipe $newRecipe) : ?Recipe
    {
        $repository = new RecipeRepository();
        return $repository->createRecipe($newRecipe);
    }

    public function getVisibility($recipeId): ?bool
    {
        $repository = new RecipeRepository();
        return $repository->getVisibility($recipeId);
    }

    public function toggleVisibility($recipeId): bool{
        $repository = new RecipeRepository();
        return $repository->toggleVisibility($recipeId);
    }

    public function deleteRecipe($recipeId): bool
    {
        $repository = new RecipeRepository();
        return $repository->deleteRecipe($recipeId);
    }

    public function updateRecipe($recipeId): ?Recipe
    {
        $repository = new RecipeRepository();
        return $repository->updateRecipe($recipeId);
    }

    public function updateImage($recipeId, $imgPath): bool
    {
        $repository = new RecipeRepository();
        return $repository->updateImage($recipeId, $imgPath);
    }
}