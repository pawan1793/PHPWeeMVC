<?php 
use Core\App;
use Core\ExceptionHandler;
use Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php';

// Load .env before initializing the app
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Define the env function
function env($key, $default = null) {
    return $_ENV[$key] ?? getenv($key) ?? $default;
}

// Set the exception handler
set_exception_handler([ExceptionHandler::class, 'handle']);


//other helper functions 
if (!function_exists('dd')) {
    function dd(...$vars) {
        echo "<pre>";
        foreach ($vars as $var) {
            print_r($var);
            echo "\n\n";
        }
        echo "</pre>";
        exit;
    }
}

// initialize and run the app
$app = new App();
$app->run();
