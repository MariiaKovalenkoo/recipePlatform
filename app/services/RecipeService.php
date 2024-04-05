<?php

namespace App\Services;

use App\Models\Recipe;
use App\Repositories\RecipeRepository;

class RecipeService
{
    private RecipeRepository $repository;
    private ImageService $imageService;

    public function __construct()
    {
        $this->repository = new RecipeRepository();
        $this->imageService = new ImageService();
    }

    public function getAllPublicRecipes(): array
    {
        return $this->repository->getAllPublicRecipes();
    }

    public function getAllRecipesByUser($userId): array
    {
        return $this->repository->getAllRecipesByUser($userId);
    }

    public function getRecipeById($recipeId): ?Recipe{
        return $this->repository->getRecipeById($recipeId);
    }

    public function createRecipe(Recipe $newRecipe) : ?Recipe
    {
        return $this->repository->createRecipe($newRecipe);
    }

    public function getVisibility($recipeId): ?bool
    {
        return $this->repository->getVisibility($recipeId);
    }

    public function toggleVisibility($recipeId): bool{
        return $this->repository->toggleVisibility($recipeId);
    }

    public function deleteRecipe($recipeId): bool
    {
        $currentImg = $this->repository->getImgPathByRecipeId($recipeId);
        if ($currentImg !== null) {
            $this->imageService->deleteImage($currentImg);
        }

        return $this->repository->deleteRecipe($recipeId);
    }

    public function updateRecipe($recipeId): ?Recipe
    {
        return $this->repository->updateRecipe($recipeId);
    }

    public function updateImage($recipeId, $imgPath): bool
    {
        $currentImg = $this->repository->getImgPathByRecipeId($recipeId);
        if ($currentImg !== null) {
            $this->imageService->deleteImage($currentImg);
        }

        return $this->repository->updateImage($recipeId, $imgPath);
    }

    public function updateRecipeField( $recipeId, $fieldName, $value): bool
    {
        return $this->repository->updateRecipeField($recipeId, $fieldName, $value);
    }
}