<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$conn = new mysqli("localhost", "root", "", "db_weeklyskin");

if ($conn->connect_error) {
    die(json_encode(array("status" => "error", "message" => "Koneksi gagal")));
}

$id = isset($_POST['id']) ? $_POST['id'] : '';
$hari = isset($_POST['hari']) ? $_POST['hari'] : '';
$waktu = isset($_POST['waktu']) ? $_POST['waktu'] : '';
$aktivitas = isset($_POST['aktivitas']) ? $_POST['aktivitas'] : '';
$keterangan = isset($_POST['keterangan']) ? $_POST['keterangan'] : '';

if (!empty($id) && !empty($aktivitas)) {
    // Jalankan Edit Teks Jadwal
    $sql = "UPDATE jadwal SET hari='$hari', waktu='$waktu', aktivitas='$aktivitas', keterangan='$keterangan' WHERE id='$id'";
} else if (!empty($id)) {
    
    $sql = "UPDATE jadwal SET is_done=1 WHERE id='$id'";
} else {
    echo json_encode(array("status" => "error", "message" => "Data tidak lengkap"));
    exit();
}

if ($conn->query($sql) === TRUE) {
    echo json_encode(array("status" => "success"));
} else {
    echo json_encode(array("status" => "error", "message" => $conn->error));
}

$conn->close();
?>