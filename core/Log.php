<?php

namespace Core;

class Logger {
    protected static $logFile = __DIR__ . '/../storage/logs/app.log';


    public static function write($level, $message) {
        $date = date('Y-m-d H:i:s');
        $logMessage = "[$date] $level: $message" . PHP_EOL;
        $a = file_put_contents(self::$logFile, $logMessage, FILE_APPEND);
    }

    public static function info($message) {
       
        self::write('INFO', $message);
    }

    public static function error($message) {
        self::write('ERROR', $message);
    }

    public static function debug($message) {
        self::write('DEBUG', $message);
    }
}

class Log {
    public static function __callStatic($method, $arguments) {
        if (method_exists(Logger::class, $method)) {
            call_user_func_array([Logger::class, $method], $arguments);
        } else {
            throw new \Exception("Method $method not found in Logger");
        }
    }
}
