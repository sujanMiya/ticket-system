<?php 
declare(strict_types=1);
namespace App\Controllers;

use Core\View;
use Core\Validator;
use App\Models\User;

class AuthController {
    protected User $userModel;

    public function __construct() {
        $this->userModel = new User();
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
            // Validate input
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            // Simple validation
            if (empty($name) || empty($email) || empty($password) || empty($confirmPassword)) {
                throw new \Exception('All fields are required');
            }

            if ($password !== $confirmPassword) {
                throw new \Exception('Passwords do not match');
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new \Exception('Invalid email format');
            }

            // Check if user exists
            if (User::emailExists($email)) {
                throw new \Exception('Email already registered');
            }

            // Create user
            $userId = User::create([
                'name' => $name,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT)
            ]);

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
    public function indexw() {
        $users = $this->db->table('users')
            ->get();
        return View::render('layouts/main', ['users' => $users]);
    } 
}
