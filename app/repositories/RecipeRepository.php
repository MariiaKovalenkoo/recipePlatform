<?php

namespace App\Repositories;

use App\Models\Recipe;
use PDO;
use PDOException;

class RecipeRepository extends Repository
{
    public function getRecipeById($recipeId): ?Recipe
    {
        $stmt = $this->connection->prepare("SELECT recipeId, recipeName, description, ingredients, 
                                                instructions, mealType, dietaryPreference, 
                                                cuisineType, isPublic, userId , imgPath FROM Recipe WHERE recipeId = ?");
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'App\Models\Recipe');
        $stmt->execute([$recipeId]);
        $recipe = $stmt->fetch();
        return $recipe ?: null;
    }

    public function getAllRecipesByUser($userId): array
    {
        $stmt = $this->connection->prepare("SELECT recipeId, recipeName, description, ingredients, 
                                                instructions, mealType, dietaryPreference, 
                                                cuisineType, isPublic, userId, imgPath FROM Recipe WHERE userId = ?");
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'App\Models\Recipe');
        $stmt->execute([$userId]);
        $recipes = $stmt->fetchAll();
        return $recipes ?: [];
    }


    public function getAllPublicRecipes(): array
    {
        $stmt = $this->connection->prepare("SELECT recipeId, recipeName, description, ingredients, 
                                        instructions, mealType, dietaryPreference, 
                                        cuisineType, isPublic, userId, imgPath FROM Recipe WHERE isPublic = TRUE");
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'App\Models\Recipe');
        $stmt->execute();
        $recipes = $stmt->fetchAll();
        return $recipes ?: [];
    }

    public function createRecipe(Recipe $newRecipe): ?Recipe
    {
        $stmt = $this->connection->prepare("INSERT INTO Recipe (userId, recipeName, description, ingredients, instructions, mealType, cuisineType, dietaryPreference, isPublic, imgPath) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $userId = $newRecipe->getUserId();
        $recipeName = $newRecipe->getRecipeName();
        $description = $newRecipe->getDescription();
        $ingredients = $newRecipe->getIngredients();
        $instructions = $newRecipe->getInstructions();
        $mealType = $newRecipe->getMealType();
        $cuisineType = $newRecipe->getCuisineType();
        $dietaryPreference = $newRecipe->getDietaryPreference();
        $isPublic = ($newRecipe->getIsPublic()) ? 1 : 0;
        $imgPath = $newRecipe->getImgPath();

        $stmt->execute([$userId, $recipeName, $description, $ingredients, $instructions, $mealType, $cuisineType, $dietaryPreference, $isPublic, $imgPath]);
        if ($stmt->rowCount() > 0) {
            $lastInsertId = $this->connection->lastInsertId();
            return $this->getRecipeById($lastInsertId);
        }
        return null;
    }

    public function getVisibility($recipeId): ?bool
    {
        $stmt = $this->connection->prepare("SELECT isPublic FROM Recipe WHERE recipeId = ?");
        $stmt->execute([$recipeId]);
        return $stmt->fetchColumn();
    }

    public function toggleVisibility($recipeId): bool
    {
        try {
            $stmt = $this->connection->prepare("UPDATE Recipe SET isPublic = NOT isPublic WHERE recipeId = ?");
            $stmt->execute([$recipeId]);
            return true;
        } catch (PDOException) {
            return false;
        }
    }

    public function deleteRecipe($recipeId): bool
    {
        $stmt = $this->connection->prepare("DELETE FROM Recipe WHERE recipeId = ?");
        return $stmt->execute([$recipeId]);
    }

    public function updateRecipe($recipe): ?Recipe
    {
        $recipeId = $recipe->getRecipeId();
        $userId = $recipe->getUserId();
        $recipeName = $recipe->getRecipeName();
        $description = $recipe->getDescription();
        $ingredients = $recipe->getIngredients();
        $instructions = $recipe->getInstructions();
        $mealType = $recipe->getMealType();
        $cuisineType = $recipe->getCuisineType();
        $dietaryPreference = $recipe->getDietaryPreference();
        $isPublic = ($recipe->getIsPublic()) ? 1 : 0;
        $imgPath = $recipe->getImgPath();

        $stmt = $this->connection->prepare("UPDATE Recipe SET userId = ?, recipeName = ?, description = ?, ingredients = ?, instructions = ?, 
                                                mealType = ?, cuisineType = ?, dietaryPreference = ?, isPublic = ?, imgPath = ? WHERE recipeId = ?");
        $stmt->execute([$userId, $recipeName, $description, $ingredients, $instructions, $mealType, $cuisineType, $dietaryPreference, $isPublic, $recipeId, $imgPath    ]);
        if ($stmt->rowCount() > 0) {
            return $this->getRecipeById($recipeId);
        }
        return null;
    }
}