<?php 
declare(strict_types=1);
namespace App\Controllers;

use Core\View;
use Core\Database;
use Core\Validator;
class RegisterController {
    protected Database $db;
    public function __construct() {
        $this->db = new Database(require __DIR__ .'/../config/database.php');
    }
    public function index() {
        $users = $this->db->table('users')
            ->get();
        return View::render('layouts/main', ['users' => $users]);
    }
    public function indexw() {
        $users = $this->db->table('users')
            ->get();
        return View::render('layouts/main', ['users' => $users]);
    } 
}
