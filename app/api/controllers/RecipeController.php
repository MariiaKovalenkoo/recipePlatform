<?php

namespace App\Api\Controllers;
use App\Models\Recipe;
use App\Services\RecipeService;

class RecipeController
{
    private RecipeService $recipeService;

    function __construct()
    {
        session_start();
        $this->recipeService = new RecipeService();
    }

    public function create()
    {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(["error" => "Method Not Allowed"]);
            exit();
        }

        $data = json_decode(file_get_contents('php://input'), true);
        if ($data === null) {
            http_response_code(400);
            echo json_encode(["error" => "Invalid JSON format"]);
            exit();
        }

        $recipe = new Recipe();
        $this->checkRequiredFields($data);

        $this->setRecipeProperties($recipe, $data);
        $userId = $_SESSION['user']->getUserId();
        $recipe->setUserId($userId);

        $createdRecipe = $this->recipeService->createRecipe($recipe);
        if ($createdRecipe) {
            http_response_code(201);
            echo json_encode(["success" => true, "data" => ["recipeId" => $createdRecipe->getRecipeId(), "message" => "Recipe created successfully"]]);
        } else {
            http_response_code(500);
            echo json_encode(["success" => false, "error" => "An error occurred while creating a recipe."]);
        }
    }
    public function delete()
    {
        if (isset($_GET['id'])) {
            $recipeId = $_GET['id'];

            if ($this->recipeService->deleteRecipe($recipeId)) {
                http_response_code(201);
                echo json_encode(["success" => true, "data" => ["recipeId" => $recipeId, "message" => "Recipe updated successfully"]]);
            } else {
                http_response_code(500);
                echo json_encode(["success" => false, "error" => "An error occurred while updating the recipe visibility."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["success" => false, "error" => "Recipe ID is missing"]);
        }
    }

    public function changeVisibility()
    {
        if (isset($_GET['id'])) {
            $recipeId = $_GET['id'];

            if ($this->recipeService->toggleVisibility($recipeId)) {
                http_response_code(201);
                $isPublic = $this->recipeService->getVisibility($recipeId);
                header('Content-Type: application/json');
                echo json_encode(["success" => true, "isPublic" => $isPublic, "data" => ["recipeId" => $recipeId, "message" => "Recipe updated successfully"]]);
            } else {
                http_response_code(500);
                echo json_encode(["success" => false, "error" => "An error occurred while updating the recipe visibility."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["success" => false, "error" => "Recipe ID is missing"]);
        }
    }

    public function getVisibility()
    {
        $recipeId = $_GET['id'] ?? null;

        if ($recipeId) {
            $isPublic = $this->recipeService->getVisibility($recipeId);
            header('Content-Type: application/json');
            echo json_encode(['isPublic' => $isPublic]);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid request']);
        }
    }
    
    public function update(){
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
            http_response_code(405);
            echo json_encode(["error" => "Method Not Allowed"]);
            exit();
        }

        $data = json_decode(file_get_contents('php://input'), true);
        if ($data === null) {
            http_response_code(400);
            echo json_encode(["error" => "Invalid JSON format"]);
            exit();
        }

        $recipeId = $data['recipeId'] ?? null;
        if ($recipeId === null) {
            http_response_code(400);
            echo json_encode(["error" => "Recipe ID is required"]);
            exit();
        }

        $existingRecipe = $this->recipeService->getRecipeById($recipeId);
        if ($existingRecipe === null) {
            http_response_code(404);
            echo json_encode(["error" => "Recipe not found"]);
            exit();
        }

        $this->checkRequiredFields($data);

        $this->setRecipeProperties($existingRecipe, $data);
        $updatedRecipe = $this->recipeService->updateRecipe($existingRecipe);
        if ($updatedRecipe) {
            http_response_code(200); // OK
            echo json_encode(["success" => true, "data" => ["recipeId" => $updatedRecipe->getRecipeId(), "message" => "Recipe updated successfully"]]);
        } else {
            http_response_code(500); // Internal Server Error
            echo json_encode(["success" => false, "error" => "An error occurred while updating the recipe."]);
        }
    }

    private function checkRequiredFields(array $data): void
    {
        $requiredFields = ['recipeName', 'ingredients', 'instructions'];
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                http_response_code(400);
                $label = ucwords(preg_replace('/(?<=\\w)(?=[A-Z])/', ' ', $field));
                echo json_encode(["error" => "Field '$label' is required"]);
                exit();
            }
        }
    }

    private function setRecipeProperties(Recipe $existingRecipe, array $data): void
    {
        $existingRecipe->setRecipeName(filter_var($data['recipeName'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $existingRecipe->setDescription(filter_var($data['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $existingRecipe->setIngredients(filter_var($data['ingredients'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $existingRecipe->setInstructions(filter_var($data['instructions'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $existingRecipe->setCuisineType(filter_var($data['cuisineType'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $existingRecipe->setMealType(filter_var($data['mealType'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $existingRecipe->setDietaryPreference(filter_var($data['dietaryPreference'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $existingRecipe->setIsPublic(filter_var($data['isPublic'], FILTER_VALIDATE_BOOLEAN));
    }
}
