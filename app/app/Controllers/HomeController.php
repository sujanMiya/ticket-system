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

        return View::render('layouts/master', ['user' => $user]);
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
        return View::render('layouts/user/ticket', ['user' => $user, 'getDepartments' => $getDepartments]);
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
        return View::render('layouts/user/ticketList', ['user' => currentUser(), 'getTickets' => $getTickets]);
    }
    
}
