<?php

namespace Core;

class Controller {
    protected function view($view, $data = []) {
        echo Blade::render($view, $data);
    }
}
