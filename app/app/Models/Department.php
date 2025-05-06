<?php
declare(strict_types=1);
namespace App\Models;


use Core\App;
use Core\Database;

class Department {
    protected Database $db;

    public function __construct() {
        $this->db = App::db();
    }
    
    public function getDepartment(): ?array {
        return $this->db->table('departments')
                        ->select(['id', 'name'])
                        ->get();
    }
}