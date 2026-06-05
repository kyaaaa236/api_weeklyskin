<?php
error_reporting(0);
ini_set('display_errors', 0);

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_weeklyskin"; 

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Koneksi database gagal"]);
    exit();
}

$hari       = isset($_POST['hari']) ? $_POST['hari'] : '';
$waktu      = isset($_POST['waktu']) ? $_POST['waktu'] : '';
$aktivitas  = isset($_POST['aktivitas']) ? $_POST['aktivitas'] : '';
$keterangan = isset($_POST['keterangan']) ? $_POST['keterangan'] : '';

if (empty($hari) || empty($waktu) || empty($aktivitas)) {
    echo json_encode(["status" => "error", "message" => "Data utama tidak boleh kosong"]);
    exit();
}

$sql = "INSERT INTO jadwal (hari, waktu, aktivitas, keterangan, is_done) VALUES ('$hari', '$waktu', '$aktivitas', '$keterangan', 0)";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["status" => "success", "message" => "Jadwal berhasil ditambahkan"]);
} else {
    echo json_encode(["status" => "error", "message" => "Gagal eksekusi query: " . $conn->error]);
}

$conn->close();
?>