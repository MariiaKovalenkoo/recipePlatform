<?php

namespace App\Models;

use JsonSerializable;

class FavRecipe implements JSONSerializable
{
    private int $userFavoriteId; // = 0
    private int $userId;
    private Recipe $recipe;
    private string $addedAt;

    public function getUserFavoriteId(): int
    {
        return $this->userFavoriteId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getRecipe(): Recipe
    {
        return $this->recipe;
    }

    public function getAddedAt(): string
    {
        return $this->addedAt;
    }

    public function setUserFavoriteId(int $userFavoriteId): void
    {
        $this->userFavoriteId = $userFavoriteId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function setRecipe(Recipe $recipe): void
    {
        $this->recipe = $recipe;
    }

    public function setAddedAt(string $addedAt): void
    {
        $this->addedAt = $addedAt;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}