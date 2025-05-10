<?php 
declare(strict_types=1);
namespace App\Controllers;

use Core\View;
use Core\Validator;
use App\Models\User;

class AuthController {
    protected User $userModel;
    protected Validator $validator;
    public function __construct() {
        $this->userModel = new User();
        $this->validator = new Validator();
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
    public function register() {
        header('Content-Type: application/json');
        
        try {
            $json = file_get_contents('php://input');
            $dataPost = json_decode($json, true);
            if (empty($dataPost['csrf_token']) || !validateCsrfToken($dataPost['csrf_token'])) {
                throw new \Exception('Invalid CSRF token');
            }
            $data = [
                'name' => $dataPost['name'] ?? '',
                'email' => $dataPost['email'] ?? '',
                'password' => $dataPost['password'] ?? '',
                'confirm_password' => $dataPost['confirm_password'] ?? ''
            ];

            $rules = [
                'name' => 'required|min:3|max:20',
                'email' => 'required|email',
                'password' => 'required|min:8',
                'confirm_password' => 'required'
            ];
            if (!$this->validator->validate($data, $rules)) {
                throw new \Exception(implode(' ', array_merge(...array_values($this->validator->errors()))));
            }

            if ($data['password'] !== $data['confirm_password']) {
                throw new \Exception('Passwords do not match');
            }
            if ($this->userModel->findByEmail($data['email'])) {
                throw new \Exception('Email already registered');
            }
            $this->userModel->create($data);

            // Return success response
            echo json_encode([
                'success' => true,
                'message' => 'Registration successful! Redirecting to login...'
            ]);

        } catch (\Exception $e) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    public function login() {
        header('Content-Type: application/json');
        
        try {
            $json = file_get_contents('php://input');
            $dataPost = json_decode($json, true);
            if (empty($dataPost['csrf_token']) || !validateCsrfToken($dataPost['csrf_token'])) {
                throw new \Exception('Invalid CSRF token');
            }
            $data = [
                'email' => $dataPost['email'] ?? '',
                'password' => $dataPost['password'] ?? ''
            ];

            $rules = [
                'email' => 'required|email',
                'password' => 'required|min:8'
            ];
            if (!$this->validator->validate($data, $rules)) {
                throw new \Exception(implode(' ', array_merge(...array_values($this->validator->errors()))));
            }

            $user = $this->userModel->findByEmail($data['email']);
            if (!$user || !password_verify($data['password'], $user['password'])) {
                throw new \Exception('Invalid email or password');
            }

            $_SESSION['user'] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email']
            ];

            // Return success response
            echo json_encode([
                'success' => true,
                'message' => 'Login successful! Redirecting to dashboard...'
            ]);

        } catch (\Exception $e) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    public function logout() {
        $_SESSION = [];
    
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(), 
                '', 
                time() - 42000,
                $params["path"], 
                $params["domain"],
                $params["secure"], 
                $params["httponly"]
            );
        }
        session_destroy();
        
        header('Location: /login');
        exit;
    }
    public function indexw() {
        $users = $this->db->table('users')
            ->get();
        return View::render('layouts/main', ['users' => $users]);
    } 
}
