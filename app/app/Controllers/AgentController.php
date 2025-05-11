<?php 
declare(strict_types=1);
namespace App\Controllers;

use Core\View;
use Core\Validator;
use App\Models\User;
use App\Models\Department;
use App\Models\Ticket;

class AgentController {
    protected User $userModel;
    protected Validator $validator;
    protected Department $departmentModel;
    protected Ticket $ticketModel;
    public function __construct() {
        $this->userModel = new User();
        $this->validator = new Validator();
        $this->departmentModel = new Department();
        $this->ticketModel = new Ticket();
    }
    public function dashboard(){
        requireAuth();
        $user = currentUser();
       $getUser = $this->userModel->findById();

        return View::render('layouts/master', ['user' => $user, 'getUser' => $getUser]);
    }

public function agentTicketLists() {
        requireAuth();
        $user = currentUser();
        $getUser = $this->userModel->findById();
        $agentUsers = $this->userModel->agentUser();
        if (!$agentUsers) {
            $agentUsers = [];
        }
        $getTickets = $this->ticketModel->assignTicketList();
        if (!$getTickets) {
            $getTickets = [];
        }

        return View::render('layouts/agent/ticketLists', [
            'user' => $user,
            'getTickets' => $getTickets,
            'getUser' => $getUser,
            'agentUsers' => $agentUsers['data']
        ]);
    }
    public function showTicketDetailsAgent($id) {
        requireAuth();
        $user = currentUser();
        $getUser = $this->userModel->findById();
        $agentUsers = $this->userModel->agentUser();
        if (!$agentUsers) {
            $agentUsers = [];
        }
        $getTicket = $this->ticketModel->findById((int)$id['id']);
        $getReply = $this->ticketModel->replyShowById((int)$id['id']);
        if (!$getTicket) {
            $getTicket = [];
        }
        if (!$getReply) {
            $getReply = [];
        }
        return View::render('layouts/agent/ticketDetails', [
            'user' => $user,
            'getTicket' => $getTicket,
            'getUser' => $getUser,
            'getReply' => $getReply,
            'agentUsers' => $agentUsers['data']
        ]);
    }
    public function ticketForm() {
        requireAuth();
        $user = currentUser();
    
        $getDepartments = $this->departmentModel->getDepartment();
        if (!$getDepartments) {
            $getDepartments = [];
        }
        $getUser = $this->userModel->findById();
        return View::render('layouts/user/ticket', ['user' => $user, 'getDepartments' => $getDepartments, 'getUser' => $getUser]);
    }
    public function showTicketDetailsAdmin($id) {
        requireAuth();
        $user = currentUser();
        $getUser = $this->userModel->findById();
        $agentUsers = $this->userModel->agentUser();
        if (!$agentUsers) {
            $agentUsers = [];
        }
        $getTicket = $this->ticketModel->findById((int)$id['id']);
        if (!$getTicket) {
            $getTicket = [];
        }
        return View::render('layouts/admin/ticketDetails', [
            'user' => $user,
            'getTicket' => $getTicket,
            'getUser' => $getUser,
            'agentUsers' => $agentUsers['data']
        ]);
    }
    public function ticketReply() {
        requireAuth();
        $user = currentUser();
    
        header('Content-Type: application/json');
        
        try {
            $json = file_get_contents('php://input');
            $dataPost = json_decode($json, true);
            
            if (empty($dataPost['csrf_token']) || !validateCsrfToken($dataPost['csrf_token'])) {
                throw new \Exception('Invalid CSRF token');
            }
            $data = [
                'user_id' => $dataPost['user_id'] ?? null,
                'message' => $dataPost['message'] ?? null,
                'ticket_id' => $dataPost['ticket_id'] ?? null,
                'is_internal_note' => 0,
                'created_at' => date('Y-m-d H:i:s'),
            ];
    
            $rules = [
                'user_id' => 'required',
                'ticket_id' => 'required',
                'message' => 'required',
                'created_at' => 'required',
            ];
            if (!$this->validator->validate($data, $rules)) {
                throw new \Exception(implode(' ', array_merge(...array_values($this->validator->errors()))));
            }
            $this->ticketModel->replyCreate($data);
            $this->ticketModel->update((int)$dataPost['ticket_id'], [
                'status' => 'open',
                'updated_at' => date('Y-m-d H:i:s')
            ]);
    
            echo json_encode(['status' => 'success', 'message' => 'Ticket assigned successfully']);
        } catch (\Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
    
}
