<?php
error_reporting(0);
ini_set('display_errors', 0);

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");

$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_weeklyskin"; 

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Koneksi database gagal"]);
    exit();
}


$sql = "SELECT * FROM jadwal";
$result = $conn->query($sql);

$list_jadwal = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $item = array(
            "id" => (int)$row['id'],
            "hari" => $row['hari'],
            "waktu" => $row['waktu'],
            "aktivitas" => $row['aktivitas'],
            "keterangan" => $row['keterangan'],
            "isDone" => (int)$row['is_done'] 
        );
        array_push($list_jadwal, $item);
    }
}

echo json_encode($list_jadwal);

$conn->close();
?>