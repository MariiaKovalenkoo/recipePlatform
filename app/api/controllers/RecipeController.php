<?php

namespace App\Api\Controllers;
use App\Models\Recipe;
use App\Services\ImageService;
use App\Services\RecipeService;
use Exception;

class RecipeController
{
    private RecipeService $recipeService;
    private ImageService $imageService;


    function __construct()
    {
        session_start();
        $this->recipeService = new RecipeService();
        $this->imageService = new ImageService();

    }

    public function create()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Method ' . $_SERVER['REQUEST_METHOD'] . ' Not Allowed']);
            exit();
        }

        // Textual data will be accessible via $_POST
        $data = $_POST; // This replaces json_decode(file_get_contents('php://input'), true);

        if ($data === null) {
            http_response_code(400);
            echo json_encode(["error" => "Invalid JSON format"]);
            exit();
        }

        if (isset($_FILES['imageUpload']) && $_FILES['imageUpload']['error'] === UPLOAD_ERR_OK) {
            try {
                $imgPath = $this->imageService->uploadImage($_FILES['imageUpload']);
            } catch (Exception $e) {
                http_response_code(400);
                echo json_encode(["error" => $e->getMessage()]);
                exit();
            }
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Please upload the image."]);
            exit();
        }

        $recipe = new Recipe();
        $this->checkRequiredFields($data);

        $this->setRecipeProperties($recipe, $data);
        $recipe->setImgPath($imgPath);
        $userId = $_SESSION['user']->getUserId();
        $recipe->setUserId($userId);

        $createdRecipe = $this->recipeService->createRecipe($recipe);
        if ($createdRecipe) {
            http_response_code(201);
            echo json_encode([
                "success" => true,
                "data" => [
                    "recipe" => $createdRecipe,
                    "message" => "Recipe created successfully"
                ]
            ]);
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

    public function updateImage()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Method ' . $_SERVER['REQUEST_METHOD'] . ' Not Allowed']);
            exit();
        }

        $recipeId = $_POST['recipeId'] ?? null;
        if ($recipeId === null) {
            http_response_code(400);
            echo json_encode(["error" => "Recipe ID is missing"]);
            exit();
        }

        if (isset($_FILES['imageUpload']) && $_FILES['imageUpload']['error'] === UPLOAD_ERR_OK) {
            try {
                $imgPath = $this->imageService->uploadImage($_FILES['imageUpload']);
                $success = $this->recipeService->updateImage($recipeId, $imgPath);
            } catch (Exception $e) {
                http_response_code(400);
                echo json_encode(["error" => $e->getMessage()]);
                exit();
            }
        } else {
            http_response_code(400);
            echo json_encode(["error" => "No image provided."]);
            exit();
        }

        if ($success) {
            echo json_encode([
                'success' => true,
                'data' => [
                    'recipeId' => $recipeId,
                    'imgPath' => $imgPath,
                    'message' => 'Image was uploaded successfully.'
                ]
            ]);
        } else {
            echo json_encode(['error' => 'Image update failed.']);
        }
    }

    public function updateField() {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
            http_response_code(405);
            echo json_encode(['error' => 'Method ' . $_SERVER['REQUEST_METHOD'] . ' Not Allowed']);
            exit();
        }

        $data = json_decode(file_get_contents('php://input'), true);

        $recipeId = $data['recipeId'] ?? null;
        if ($recipeId === null) {
            http_response_code(400);
            echo json_encode(["error" => "Recipe ID is required"]);
            exit();
        }

        if(!isset($data['fieldName']) || (empty(trim($data['value'])))) {
            http_response_code(400);
            echo json_encode(['error' => 'Field name or value is missing']);
            exit();
        }

        $fieldName = filter_var($data['fieldName'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $value = filter_var($data['value'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $allowedFields = ['recipeName', 'description', 'ingredients', 'instructions', 'cuisineType', 'mealType', 'dietaryPreference', 'isPublic'];

        if (!in_array($fieldName, $allowedFields)) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid field name']);
            return;
        }

        if ($fieldName = 'isPublic') {
            $value = filter_var($value, FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
        }

        $success = $this->recipeService->updateRecipeField($recipeId, $fieldName, $value);
        if ($success) {
            http_response_code(200); // OK
            echo json_encode(["success" => true, "data" => ["recipeId" => $recipeId, "message" => "Recipe updated successfully"]]);
        } else {
            http_response_code(500); // Internal Server Error
            echo json_encode(["success" => false, "error" => "An error occurred while updating the recipe."]);
        }
        /*try{
            $success = $this->recipeService->updateRecipeField($recipeId, $fieldName, $value);
            if ($success) {
                http_response_code(200);
                echo json_encode(["success" => true,]);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
            exit();
        }*/
    }

    private function checkRequiredFields(array $data): void
    {
        $requiredFields = ['recipeName', 'ingredients', 'instructions'];
        foreach ($requiredFields as $field) {
            if (empty(trim($data[$field]))) {
                http_response_code(400);
                $label = ucwords(preg_replace('/(?<=\\w)(?=[A-Z])/', ' ', $field));
                echo json_encode(["error" => "Field '$label' is required"]);
                exit();
            }
        }
    }

    private function setRecipeProperties(Recipe $recipe, array $data): void
    {
        $recipe->setRecipeName(filter_var($data['recipeName'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $recipe->setDescription(filter_var($data['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $recipe->setIngredients(filter_var($data['ingredients'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $recipe->setInstructions(filter_var($data['instructions'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $recipe->setCuisineType(filter_var($data['cuisineType'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $recipe->setMealType(filter_var($data['mealType'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $recipe->setDietaryPreference(filter_var($data['dietaryPreference'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $recipe->setIsPublic(filter_var($data['isPublic'], FILTER_VALIDATE_BOOLEAN));
    }
}
