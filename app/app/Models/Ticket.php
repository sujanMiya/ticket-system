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
    }
    public function assignTicketList(): ?array {
        return $this->db->table('tickets')
                      ->select(['id', 'subject', 'created_at', 'status','customer_id','assigned_agent_id','description'])
                      ->where('assigned_agent_id', '=', currentUser()['id'])
                      ->orderBy('created_at', 'desc')
                      ->limit(10)
                      ->get();
    }
    public function allTickets(int $page = 1, int $perPage = 15): ?array {
        return $this->db->table('tickets')
                      ->select(['id', 'subject', 'created_at', 'status','customer_id'])
                      ->orderBy('created_at', 'desc')
                      ->paginate($page, $perPage);
    }
    public function create(array $data) {
        return $this->db->table('tickets')
                       ->insert($data);
    }
    public function findById(int $id): ?object  {
        return $this->db->table('tickets')
                      ->where('id', '=', $id)
                      ->first();
    }
    public function update(int $id, array $data): int {
        return $this->db->table('tickets')
                       ->where('id', '=', $id)
                       ->update($data);
    }
    public function replyCreate(array $data) {
        return $this->db->table('ticket_responses')
                       ->insert($data);
    }
    public function replyShowById(int $id) {
        return $this->db->table('ticket_responses')
                        ->select(['id', 'ticket_id', 'message', 'created_at','user_id'])
                        ->where('ticket_id', '=', $id)
                        ->get(10);
    }
}