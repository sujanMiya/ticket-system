<?php
declare(strict_types=1);
namespace App\Models;


use Core\App;
use Core\Database;

class User {
    protected Database $db;

    public function __construct() {
        $this->db = App::db();
    }

    public function findByEmail(string $email): ?array {
        return $this->db->table('users')
                      ->where('email', '=', $email)
                      ->first();
    }
    public function show(): ?array {
        return $this->db->table('users')
                      ->get();
    }
}