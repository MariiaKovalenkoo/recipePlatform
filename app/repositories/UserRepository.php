<?php

namespace App\Repositories;

use PDO;
use App\Models\User;

class UserRepository extends Repository
{
    function checkUsernameExists($enteredUsername): bool {
        $stmt = $this->connection->prepare("SELECT COUNT(*) as user_count FROM User WHERE username = ?");
        $stmt->execute([$enteredUsername]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return ($result['user_count'] > 0);
    }

    public function getHashedPasswordByUsername($username): ?string
    {
        $stmt = $this->connection->prepare("SELECT password FROM User WHERE username = ?");
        $stmt->execute([$username]);
        $hashedPassword = $stmt->fetchColumn();
        return ($hashedPassword !== false) ? $hashedPassword : null;
    }

    public function getUserById($userId): ?User
    {
        $stmt = $this->connection->prepare("SELECT * FROM User WHERE userId = ?");
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'App\Models\User');
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_CLASS);
        return ($user !== false) ? $user : null;
    }

    public function getUserByUsername($username): ?User
    {
        $stmt = $this->connection->prepare("SELECT * FROM User WHERE username = ?");
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'App\Models\User');
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_CLASS);
        return ($user !== false) ? $user : null;
    }

    public function checkEmailExists($enteredEmail) : bool
    {
        $stmt = $this->connection->prepare("SELECT COUNT(*) as user_count FROM User WHERE email = ?");
        $stmt->execute([$enteredEmail]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return ($result['user_count'] > 0);
    }

    public function createNewUser(User $user): ?User
    {
        $stmt = $this->connection->prepare("INSERT INTO User (username, password, firstName, lastName, email) VALUES (?, ?, ?, ?, ?)");

        $username = $user->getUsername();
        $password = $user->getPassword();
        $firstName = $user->getFirstName();
        $lastName = $user->getLastName();
        $email = $user->getEmail();
        $stmt->execute([$username, $password, $firstName, $lastName, $email]);

        if ($stmt->rowCount() > 0) {
            $lastInsertId = $this->connection->lastInsertId();
            return $this->getUserById($lastInsertId);
        }
        return null;
    }
}