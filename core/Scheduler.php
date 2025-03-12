<?php

namespace Core;

class Scheduler {
    protected static $tasks = [];

    public static function call($callback) {
        self::$tasks[] = [
            'callback' => $callback,
            'interval' => null,
            'last_run' => 0
        ];
        return new static;
    }

    public function everyMinute() {
        self::$tasks[array_key_last(self::$tasks)]['interval'] = 60;
        return $this;
    }

    public function everyFiveMinutes() {
        self::$tasks[array_key_last(self::$tasks)]['interval'] = 300;
        return $this;
    }

    public function hourly() {
        self::$tasks[array_key_last(self::$tasks)]['interval'] = 3600;
        return $this;
    }

    public function daily() {
        self::$tasks[array_key_last(self::$tasks)]['interval'] = 86400;
        return $this;
    }

    public static function run() {
        foreach (self::$tasks as &$task) {
            $currentTime = time();
            if ($currentTime - $task['last_run'] >= $task['interval']) {
                if (is_callable($task['callback'])) {
                    call_user_func($task['callback']);
                } elseif (is_string($task['callback']) && strpos($task['callback'], '@') !== false) {
                    list($class, $method) = explode('@', $task['callback']);
                    if (class_exists($class)) {
                        $instance = new $class();
                        if (method_exists($instance, $method)) {
                            call_user_func([$instance, $method]);
                        }
                    }
                }
                $task['last_run'] = $currentTime;
            }
        }
    }
}
