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
    private $columns  = ['*'];
    private $limit = null;
    private $offset = null;
    private $orderBy = [];

    public function __construct(Database $db, $table) {
        $this->db = $db;
        $this->table = $table;
    }
        /**
     * Set the limit for the query
     * @param int $limit
     * @return $this
     */
    public function limit(int $limit) {
        $this->limit = $limit;
        return $this;
    }

    /**
     * Set the offset for the query
     * @param int $offset
     * @return $this
     */
    public function offset(int $offset) {
        $this->offset = $offset;
        return $this;
    }
    public function orderBy(string $column, string $direction = 'ASC') {
        // Validate column name (simple example)
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $column)) {
            throw new \InvalidArgumentException('Invalid column name');
        }
        
        $direction = strtoupper($direction) === 'DESC' ? 'DESC' : 'ASC';
        $this->orderBy[] = "{$column} {$direction}";
        return $this;
    }
      /**
     * Paginate results
     * @param int $page Current page (1-based)
     * @param int $perPage Items per page
     * @return array Contains 'data' and 'pagination' info
     */
    public function paginate(int $page = 1, int $perPage = 15) {
        // Calculate offset
        $offset = ($page - 1) * $perPage;
        
        // Get total count of items (without limit/offset)
        $total = $this->getCount();
        
        // Get paginated data
        $data = $this->limit($perPage)
                     ->offset($offset)
                     ->get();
        
        return [
            'data' => $data,
            'pagination' => [
                'total' => $total,
                'per_page' => $perPage,
                'current_page' => $page,
                'last_page' => ceil($total / $perPage),
                'from' => $offset + 1,
                'to' => min($offset + $perPage, $total)
            ]
        ];
    }

    /**
     * Get total count of records
     * @return int
     */
    private function getCount() {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        
        if ($this->conditions) {
            $sql .= " WHERE " . implode(' AND ', $this->conditions);
        }
        
        return (int)$this->db->query($sql, $this->params)->fetch()->total;
    }

    // Modify the get() method to include limit/offset
    public function get() {
        $selectedColumns = implode(', ', $this->columns);
        $sql = "SELECT {$selectedColumns} FROM {$this->table}";
        
        if ($this->conditions) {
            $sql .= " WHERE " . implode(' AND ', $this->conditions);
        }
        if (!empty($this->orderBy)) {
            $sql .= " ORDER BY " . implode(', ', $this->orderBy);
        }
        
        if ($this->limit !== null) {
            $sql .= " LIMIT " . $this->limit;
            
            if ($this->offset !== null) {
                $sql .= " OFFSET " . $this->offset;
            }
        }
        
        return $this->db->query($sql, $this->params)->fetchAll();
    }

    public function select(array $columns = ['*']) {
        $this->columns = $columns;
        return $this;
    }
    public function where($column, $operator, $value) {
        $this->conditions[] = "{$column} {$operator} ?";
        $this->params[] = $value;
        return $this;
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
     /**
     * Update records in the database
     * @param array $data Associative array of column => value pairs to update
     * @return int Number of affected rows
     */
    public function update(array $data) {
        if (empty($data)) {
            throw new \InvalidArgumentException('No data provided for update');
        }

        $setParts = [];
        $params = [];
        
        foreach ($data as $column => $value) {
            $setParts[] = "{$column} = ?";
            $params[] = $value;
        }
        
        $sql = "UPDATE {$this->table} SET " . implode(', ', $setParts);
        
        if ($this->conditions) {
            $sql .= " WHERE " . implode(' AND ', $this->conditions);
            $params = array_merge($params, $this->params);
        }
        
        $stmt = $this->db->query($sql, $params);
        return $stmt->rowCount();
    }
}