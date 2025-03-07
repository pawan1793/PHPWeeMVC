<?php

namespace Core;

use PDO;

class Model {
    protected static $table;
    protected $attributes = [];
    protected $fillable = [];
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected static function getDB() {
        $config = require __DIR__ . '/../config/database.php';
        return new PDO("mysql:host={$config['host']};dbname={$config['database']}", $config['username'], $config['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        ]);
    }

    public function __construct($attributes = []) {
        foreach ($attributes as $key => $value) {
            if (in_array($key, $this->fillable)) {
                $this->attributes[$key] = $value;
            }
        }
    }

    public static function all() {
        $pdo = self::getDB();
        $stmt = $pdo->query("SELECT * FROM " . static::$table);
        return $stmt->fetchAll(PDO::FETCH_CLASS, static::class);
    }

    public static function count() {
        $pdo = self::getDB();
        $stmt = $pdo->query("SELECT COUNT(*) AS total FROM " . static::$table);
        return $stmt->fetch()->total;
    }

    public static function orderBy($column, $direction = 'ASC') {
        $pdo = self::getDB();
        $stmt = $pdo->query("SELECT * FROM " . static::$table . " ORDER BY $column $direction");
        return $stmt->fetchAll(PDO::FETCH_CLASS, static::class);
    }

    public static function where(array $conditions) {
        $pdo = self::getDB();
        $query = "SELECT * FROM " . static::$table . " WHERE ";
        $values = [];
        foreach ($conditions as $column => $value) {
            $query .= "$column = :$column AND ";
            $values[":$column"] = $value;
        }
        $query = rtrim($query, " AND ");
        
        $stmt = $pdo->prepare($query);
        $stmt->execute($values);
        return new static($stmt);
    }

    protected $stmt;
    
    public function __constructStmt($stmt) {
        $this->stmt = $stmt;
    }

    public function first() {
        $data = $this->stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new static($data) : null;
    }

    public function get() {
        return $this->stmt->fetchAll(PDO::FETCH_CLASS, static::class);
    }

    public static function create(array $data) {
        $pdo = self::getDB();
        $instance = new static();
        $data = array_intersect_key($data, array_flip($instance->fillable));
        
        if ($instance->timestamps) {
            $data['created_at'] = $data['updated_at'] = date('Y-m-d H:i:s');
        }
        
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));
        $query = "INSERT INTO " . static::$table . " ($columns) VALUES ($placeholders)";

        $stmt = $pdo->prepare($query);
        $stmt->execute(array_combine(
            array_map(fn($k) => ":$k", array_keys($data)),
            array_values($data)
        ));

        return static::find($pdo->lastInsertId());
    }

    public function update(array $data) {
        $pdo = self::getDB();
        if (!isset($this->attributes[$this->primaryKey])) {
            throw new \Exception("Cannot update record without primary key.");
        }

        $data = array_intersect_key($data, array_flip($this->fillable));
        
        if ($this->timestamps) {
            $data['updated_at'] = date('Y-m-d H:i:s');
        }

        $query = "UPDATE " . static::$table . " SET ";
        $values = [];
        foreach ($data as $column => $value) {
            $query .= "$column = :$column, ";
            $values[":$column"] = $value;
        }
        $query = rtrim($query, ", ") . " WHERE " . $this->primaryKey . " = :primaryKey";
        $values[":primaryKey"] = $this->attributes[$this->primaryKey];

        $stmt = $pdo->prepare($query);
        $stmt->execute($values);
    }

    public function increment($column, $amount = 1) {
        $pdo = self::getDB();
        if (!isset($this->attributes[$this->primaryKey])) {
            throw new \Exception("Cannot increment without a primary key.");
        }

        $query = "UPDATE " . static::$table . " SET $column = $column + :amount WHERE " . $this->primaryKey . " = :primaryKey";
        $stmt = $pdo->prepare($query);
        $stmt->execute([':amount' => $amount, ':primaryKey' => $this->attributes[$this->primaryKey]]);
    }

    public static function selectRaw($query) {
        $pdo = self::getDB();
        $stmt = $pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_CLASS, static::class);
    }

    public static function paginate($perPage = 10, $page = 1) {
        $pdo = self::getDB();
        $offset = ($page - 1) * $perPage;
        $stmt = $pdo->prepare("SELECT * FROM " . static::$table . " LIMIT :perPage OFFSET :offset");
        $stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, static::class);
    }
}
