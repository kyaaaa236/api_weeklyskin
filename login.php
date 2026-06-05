<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

if (empty($username) || empty($password)) {
    echo json_encode(["status" => "error", "message" => "Username dan password tidak boleh kosong."]);
    exit();
}

if (strlen($password) >= 4) {
    echo json_encode([
        "status" => "success",
        "message" => "Login berhasil!",
        "token" => "token_weeklyskin_" . bin2hex(random_bytes(4)) 
    ]);
} else {
    echo json_encode(["status" => "error", "message" => "Password terlalu pendek (Minimal 4 karakter)."]);
}
?>