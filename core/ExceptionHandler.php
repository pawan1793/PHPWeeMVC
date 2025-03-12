<?php

namespace Core;

use Throwable;

class ExceptionHandler {
    public static function handle(Throwable $e) {
        Log::error($e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());

        http_response_code(500);
        echo "Something went wrong! Check logs.";
    }
}
