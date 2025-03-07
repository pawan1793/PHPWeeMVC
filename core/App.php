<?php

namespace Core;

class App {
    public function run() {
        require_once __DIR__ . '/../routes/web.php';
        Router::dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
    }
}