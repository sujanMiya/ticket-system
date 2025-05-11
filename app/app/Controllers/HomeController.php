<?php 
declare(strict_types=1);
namespace App\Controllers;

use Core\View;
use Core\Validator;
use App\Models\User;
use App\Models\Department;
use App\Models\Ticket;

class HomeController {
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
    public function index() { 
        $users = $this->userModel->show();

        include __DIR__ . '/../Views/landing.php';
    }
    public function showRegisterForm() {         
         include __DIR__ . '/../Views/register.php';
    }
    public function showLoginForm() {         
     include __DIR__ . '/../Views/login.php';
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
    public function ticketStore() {
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
                'subject' => $dataPost['subject'] ?? '',
                'description' => $dataPost['description'] ?? '',
                'status' => 'open',
                'priority' => $dataPost['priority'] ?? '',
                'department_id' => $dataPost['department'] ?? null,
                'customer_id' => $user['id'] ?? '',
                'assigned_agent_id'=>null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
    
            $rules = [
                'subject' => 'required',
                'description' => 'required',
                'status' => 'open',
                'priority' => 'required',
                'department_id' => 'required',
                'customer_id' => 'required',
                'created_at' => 'required',
                'updated_at' => 'required'
            ];
            if (!$this->validator->validate($data, $rules)) {
                throw new \Exception(implode(' ', array_merge(...array_values($this->validator->errors()))));
            }
    
            $this->ticketModel->create($data);
    
            echo json_encode(['status' => 'success', 'message' => 'Ticket created successfully']);
        } catch (\Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
    public function showTicketList() {
        requireAuth();
        $getTickets = $this->ticketModel->show();
        if (!$getTickets) {
            $getTickets = [];
        }
        $getUser = $this->userModel->findById();
        return View::render('layouts/user/ticketList', ['user' => currentUser(), 'getTickets' => $getTickets,'getUser' => $getUser]);
    }
    public function allTicketLists() {
        requireAuth();

        $page = (int) ($_GET['page'] ?? 1);
        $perPage = 15;
        $getTickets = $this->ticketModel->allTickets($page, $perPage);
        if (!$getTickets) {
            $getTickets = [];
        }
        $user = currentUser();
        $getUser = $this->userModel->findById();
        return View::render('layouts/admin/ticketList', ['user'=>$user,'getTickets' => $getTickets['data'],'getUser' => $getUser]);
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
    public function ticketAssign() {
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
                'assigned_agent_id' => $dataPost['assignment'] ?? null,
                'status' => 'open',
                'updated_at' => date('Y-m-d H:i:s')
            ];
    
            $rules = [
                'assigned_agent_id' => 'required',
                'status' => 'open',
                'updated_at' => 'required'
            ];
            if (!$this->validator->validate($data, $rules)) {
                throw new \Exception(implode(' ', array_merge(...array_values($this->validator->errors()))));
            }
    
            $this->ticketModel->update((int)$dataPost['ticket_id'], $data);
    
            echo json_encode(['status' => 'success', 'message' => 'Ticket assigned successfully']);
        } catch (\Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }   
    
}
