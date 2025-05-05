<?php
namespace Core;

use PDO;
use PDOException;

class Database {
    public $connection;

    public function __construct(array $config) {
        $dsn = "{$config['driver']}:host={$config['host']};dbname={$config['database']};port={$config['port']}";
        
        try {
            $this->connection = new PDO($dsn, $config['username'], $config['password'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
            ]);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function query($sql, $params = []) {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function table($table) {
        return new QueryBuilder($this, $table);
    }
    public function lastInsertId() {
        return $this->connection->lastInsertId();
    }
}

class QueryBuilder {
    private $db;
    private $table;
    public $conditions = [];
    private $params = [];

    public function __construct(Database $db, $table) {
        $this->db = $db;
        $this->table = $table;
    }

    public function where($column, $operator, $value) {
        $this->conditions[] = "{$column} {$operator} ?";
        $this->params[] = $value;
        return $this;
    }

    public function get() {
        $sql = "SELECT * FROM {$this->table}";
        if ($this->conditions) {
            $sql .= " WHERE " . implode(' AND ', $this->conditions);
        }
        return $this->db->query($sql, $this->params)->fetchAll();
    }

    public function first() {
        $result = $this->get();
        return $result[0] ?? null;
    }

    public function insert($data) {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
        $this->db->query($sql, array_values($data));
        return $this->db->connection->lastInsertId();
    }
}