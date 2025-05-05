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
        $result = $this->db->table('users')
                      ->where('email', '=', $email)
                      ->first();
         return $result ? (array) $result : null;
    }
    public function show(): ?array {
        return $this->db->table('users')
                      ->get();
    }
    public function create(array $data) {
        $insertData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'role' => 'customer',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        return $this->db->table('users')
                       ->insert($insertData);
    }
}