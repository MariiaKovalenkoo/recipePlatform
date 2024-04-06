<?php

namespace App\Api\Controllers;

use App\Services\FavoriteService;

class FavoriteController
{
    private FavoriteService $favoriteService;

    private $userId;

    function __construct()
    {
        session_start();
        $user = $_SESSION['user'];
        $this->userId = $user->getUserId();
        $this->favoriteService = new FavoriteService();
    }

    public function check() {
        $recipeId = $_GET['id'] ?? null;
        if (!$recipeId) {
            echo json_encode(['error' => 'Recipe ID is required']);
            return;
        }

        $isFavorite = $this->favoriteService->isFavorite($this->userId, $recipeId);
        echo json_encode(['isFavorite' => $isFavorite]);
    }

    public function add() {
        $data = json_decode(file_get_contents('php://input'), true);
        $recipeId = $data['id'] ?? null;
        if (!$recipeId) {
            echo json_encode(['error' => 'Recipe ID is required']);
            return;
        }

        if ($this->favoriteService->isFavorite($this->userId, $recipeId)) {
            echo json_encode(['success' => false, 'message' => 'Already in favorites']);
            return;
        }


        $success = $this->favoriteService->addToFavorite($this->userId, $recipeId);
        echo json_encode(['success' => $success]);
    }

    public function remove() {
        $data = json_decode(file_get_contents('php://input'), true);
        $recipeId = $data['id'] ?? null;
        if (!$recipeId) {
            echo json_encode(['error' => 'Recipe ID is required']);
            return;
        }

        if (!$this->favoriteService->isFavorite($this->userId, $recipeId)) {
            echo json_encode(['success' => false, 'message' => 'Not in favorites']);
            return;
        }

        $success = $this->favoriteService->removeFromFavorite($this->userId, $recipeId);
        echo json_encode(['success' => $success]);
    }
}