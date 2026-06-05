<?php
include 'koneksi.php';

$id = $_POST['id'] ?? '';
$hari = $_POST['hari'] ?? '';
$waktu = $_POST['waktu'] ?? '';
$aktivitas = $_POST['aktivitas'] ?? '';
$keterangan = $_POST['keterangan'] ?? '';
$is_done = $_POST['is_done'] ?? '';

if (!empty($id)) {
    
    if (!empty($hari) && !empty($waktu) && !empty($aktivitas)) {
        $query = "UPDATE jadwal SET hari='$hari', waktu='$waktu', aktivitas='$aktivitas', keterangan='$keterangan' WHERE id='$id'";
    } 
   
    else if ($is_done !== '') {
        $query = "UPDATE jadwal SET is_done='$is_done' WHERE id='$id'";
    } else {
        echo json_encode(["status" => "error", "message" => "Data tidak lengkap."]);
        exit();
    }

    $ubah = mysqli_query($koneksi, $query);

    if ($ubah) {
        echo json_encode(["status" => "success", "message" => "Jadwal berhasil diperbarui!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Gagal memperbarui jadwal."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "ID tidak ditemukan!"]);
}