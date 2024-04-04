<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;

class UserService
{
    function checkUsernameExists($enteredUsername): bool {
        $repository = new UserRepository();
        return $repository->checkUsernameExists($enteredUsername);
    }

    public function getHashedPasswordByUsername($username): string
    {
        $repository = new UserRepository();
        return $repository->getHashedPasswordByUsername($username);
    }

    public function getUserById($userId): User
    {
        $repository = new UserRepository();
        return $repository->getUserById($userId);
    }

    public function getUserByUsername($username): User
    {
        $repository = new UserRepository();
        return $repository->getUserByUsername($username);
    }

    public function checkEmailExists($email) : bool
    {
        $repository = new UserRepository();
        return $repository->checkEmailExists($email);
    }

    public function createNewUser(User $user) : ?User
    {
        $repository = new UserRepository();
        return $repository->createNewUser($user);
    }
}