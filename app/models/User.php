<?php

namespace App\Models;

use JsonSerializable;

class User implements JsonSerializable {
    private int $userId = 0;
    private string $username;
    private string $password;
    private string $firstName;
    private string $lastName;
    private string $email;

    public function getUserId(): int {
        return $this->userId;
    }

    public function getFullName(): string {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function setUserId(int $userId): void {
        $this->userId = $userId;
    }

    public function getUsername(): string {
        return $this->username;
    }

    public function setUsername(string $username): void {
        $this->username = $username;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function setPassword(string $password): void {
        $this->password = $password;
    }

    public function getFirstName(): string {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void {
        $this->firstName = $firstName;
    }

    public function getLastName(): string {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void {
        $this->lastName = $lastName;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}