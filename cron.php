<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/database.php';

use Core\Scheduler;

//  Schedule a function
Scheduler::call(function() {
    file_put_contents(__DIR__ . '/storage/logs/cron.log', "Task executed at " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
})->everyMinute();


// Scheduler::call(function () {
//     $controller = new \App\Controllers\HomeController();
//     $controller->index(); // Call the index method
// })->everyMinute(); // Runs every minute




// Run the scheduler
Scheduler::run();
