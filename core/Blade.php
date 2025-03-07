<?php

namespace Core;

class Blade {
    public static function render($view, $data = []) {
        extract($data);
        ob_start();
        require __DIR__ . "/../app/Views/$view.blade.php";
        return ob_get_clean();
    }
}