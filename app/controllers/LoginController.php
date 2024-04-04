<?php

namespace App\Controllers;

use App\Services\UserService;

class LoginController
{
    private UserService $userService;

    function __construct()
    {
        $this->userService = new UserService();
    }

    public function index(): void
    {
        require __DIR__ . '/../views/login/index.php';
    }

    public function authenticate()
    {
        session_start();

        $this->checkRequiredFields();

        $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = $_POST['password'];

        if ($this->userService->checkUsernameExists($username)) {
            $hashedPassword = $this->userService->getHashedPasswordByUsername($username);
            $enteredPassword = hash('sha256', $password);

            if ($enteredPassword === $hashedPassword) {
                $user = $this->userService->getUserByUsername($username);
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
                $_SESSION['user'] = $user;

                header('Location: /userpage');
            } else {
                $_SESSION['error'] = "Incorrect password. Please try again.";
                header('Location: /login');
            }
        } else {
            $_SESSION['error'] = "Username does not exist. Please check your username or sign up.";
            header('Location: /login');
        }
        exit();
    }

    private function checkRequiredFields(): void
    {
        if (empty($_POST['username']) || empty($_POST['password'])) {
            $_SESSION['error'] = "Both username and password are required.";
            header('Location: /login');
            exit();
        }
    }

    public function logout(): void
    {
        session_start();
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
            $_SESSION = array();
            session_destroy();
            header('Location: /home');
            exit();
        }
    }
}
