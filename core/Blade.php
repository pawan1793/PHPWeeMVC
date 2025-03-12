<?php

namespace Core;

use eftec\bladeone\BladeOne;

class Blade extends BladeOne {
    public function __construct() {
        parent::__construct(__DIR__ . '/../app/Views', __DIR__ . '/../storage/cache', BladeOne::MODE_AUTO);
    }

    public static function render($view, $data = []) {
        $blade = new self();
        return $blade->run($view, $data);
    }
}
