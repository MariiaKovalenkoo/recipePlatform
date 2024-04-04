<?php

namespace App\Controllers;

use App\Models\User;
use App\Services\UserService;

class SignupController
{
    private UserService $userService;

    function __construct()
    {
        $this->userService = new UserService();
    }

    public function index(): void
    {
        require __DIR__ . '/../views/signup/index.php';
    }

    public function signup()
    {
        session_start();

        $this->checkRequiredFields();

        $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = $_POST['password'];
        $firstName = filter_var($_POST['firstName'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $lastName = filter_var($_POST['lastName'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

        if ($this->userService->checkUsernameExists($username) || $this->userService->checkEmailExists($email)) {
            if ($this->userService->checkUsernameExists($username)) {
                $_SESSION['error'] = "Username already exists. Please choose a different username.";
            } elseif ($this->userService->checkEmailExists($email)) {
                $_SESSION['error'] = "Email already exists. Please use a different email address.";
            }
            header('Location: /signup');
        } else {
            $user = new User();
            $user->setUsername($username);
            $hashedPassword = hash('sha256', $password);
            $user->setPassword($hashedPassword);
            $user->setFirstName($firstName);
            $user->setLastName($lastName);
            $user->setEmail($email);

            if ($loggedInUser = $this->userService->createNewUser($user)) {
                $_SESSION['loggedin'] = true;
                $_SESSION['user'] = $loggedInUser;
                unset($_SESSION['userInput']);

                header('Location: /userpage');
            } else {
                $_SESSION['error'] = "Error occurred while signing up.";
                header('Location: /signup');
            }
        }
        exit();
    }

    private function checkRequiredFields(): void
    {
        $requiredFields = array('firstName', 'lastName', 'email', 'username', 'password');

        foreach ($requiredFields as $field) {
            if (!empty($_POST[$field])) {
                $_SESSION['userInput'][$field] = $_POST[$field];
            }
        }

        foreach ($requiredFields as $field) {
            if (empty($_POST[$field])) {
                $label = ucwords(preg_replace('/(?<=\\w)(?=[A-Z])/', ' ', $field));
                $_SESSION['error'] = "Field '$label' is required.";
                header('Location: /signup');
                exit();
            }
        }

        if (!$this->validateEmail($_POST['email'])) {
            $_SESSION['error'] = "Invalid email format.";
            header('Location: /signup');
            exit();
        }

        if (!$this->validatePassword($_POST['password'])) {
            $_SESSION['error'] = "Password must be at least 8 characters long.";
            header('Location: /signup');
            exit();
        }
    }

    private function validateEmail($email): bool {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    private function validatePassword($password): bool {
        return strlen($password) >= 8;
    }
}