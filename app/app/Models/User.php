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
    public function findById(){
        return $this->db->table('users')
                      ->where('id', '=', currentUser()['id'])
                      ->first();
         
    }
    public function agentUser(int $page = 1, int $perPage = 10): ?array {
        return  $this->db->table('users')
                      ->select(['id', 'name', 'email', 'role']) 
                      ->where('role', '=', 'agent')
                      ->orderBy('created_at', 'desc')
                      ->paginate($page, $perPage);
    }
    public function update(int $id, array $data): bool {
        $updateData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        if (!empty($data['password'])) {
            $updateData['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        
        return $this->db->table('users')
                       ->where('id', '=', $id)
                       ->update($updateData);
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