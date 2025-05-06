<?php
declare(strict_types=1);
namespace App\Models;


use Core\App;
use Core\Database;

class Ticket {
    protected Database $db;

    public function __construct() {
        $this->db = App::db();
    }

    public function show(): ?array {
        return $this->db->table('tickets')
                      ->select(['id', 'subject', 'created_at', 'status','customer_id'])
                      ->where('customer_id', '=', currentUser()['id'])
                      ->orderBy('created_at', 'desc')
                      ->limit(10)
                      ->get();
                    //   return $result ? (array) $result : null;
    }
    public function create(array $data) {
        return $this->db->table('tickets')
                       ->insert($data);
    }
}