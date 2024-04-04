<?php
declare(strict_types=1);
error_reporting(E_ALL);
ini_set('display_errors', 1);

require '../vendor/autoload.php';

$uri = trim($_SERVER['REQUEST_URI'], '/');

$router = new App\PatternRouter();
$router->route($uri);