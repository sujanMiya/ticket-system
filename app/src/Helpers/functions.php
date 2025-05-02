<?php 
declare(strict_types=1);

function json_response($data = null, $status = 200) {
    header('Content-Type: application/json');
    http_response_code($status);
    echo json_encode($data);
    exit;
}