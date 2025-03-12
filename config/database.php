<?php 

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => env('DB_CONNECTION', 'mysql'),
    'host'      => env('DB_HOST', '127.0.0.1'),
    'database'  => env('DB_DATABASE', 'your_database'),
    'username'  => env('DB_USERNAME', 'your_username'),
    'password'  => env('DB_PASSWORD', 'your_password'),
    'charset'   => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix'    => '',
]);

$capsule->setAsGlobal();  // Makes it accessible globally
$capsule->bootEloquent(); // Boots Eloquent ORM
