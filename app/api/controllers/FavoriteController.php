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

    public function check()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(405);
            echo json_encode(['error' => 'Method ' . $_SERVER['REQUEST_METHOD'] . ' Not Allowed']);
            exit();
        }

        $recipeId = $_GET['id'] ?? null;
        if (!$recipeId) {
            echo json_encode(['error' => 'Recipe ID is required']);
            exit();
        }

        $isFavorite = $this->favoriteService->isFavorite($this->userId, $recipeId);
        echo json_encode([ 'success' => true, 'isFavorite' => $isFavorite]);
    }


    public function add() {

        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Method ' . $_SERVER['REQUEST_METHOD'] . ' Not Allowed']);
            exit();
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $recipeId = $data['id'] ?? null;
        if (!$recipeId) {
            echo json_encode(['error' => 'Recipe ID is required']);
            exit();
        }

        $isFav = $this->favoriteService->isFavorite($this->userId, $recipeId);
        if (!$isFav) {
            $this->favoriteService->addToFavorite($this->userId, $recipeId);
            http_response_code(200);
            echo json_encode(['success' => true, 'message' => 'Added to favorites']);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Already in favorites']);
        }
    }

    public function remove() {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
            http_response_code(405);
            echo json_encode(['error' => 'Method ' . $_SERVER['REQUEST_METHOD'] . ' Not Allowed']);
            exit();
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $recipeId = $data['id'] ?? null;

        if ($recipeId === null) {
            echo json_encode(['error' => 'Recipe ID is required']);
            exit();
        }

        $isFav = $this->favoriteService->isFavorite($this->userId, $recipeId);
        if ($isFav) {
            $this->favoriteService->removeFromFavorite($this->userId, $recipeId);
            http_response_code(200);
            echo json_encode(['success' => true, 'message' => 'Removed from favorites']);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Not in favorites']);
        }
    }
}