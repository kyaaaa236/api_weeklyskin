<?php

$koneksi = mysqli_connect("localhost", "root", "", "db_weeklyskin");

if (mysqli_connect_errno()) {
    echo "Koneksi database gagal: " . mysqli_connect_error();
    exit();
}

$daftar_hari = [
    'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 
    'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
];
$hari_ini = $daftar_hari[date('l')];

$jam_sekarang = date('H:i');

$query = "SELECT * FROM jadwal WHERE LOWER(hari) = LOWER('$hari_ini') AND waktu LIKE '20:00%' AND is_done = 0";
$result = mysqli_query($koneksi, $query);

if (!$result) {
    echo "Gagal menjalankan query! Eror MySQL: " . mysqli_error($koneksi) . "<br>";
    echo "Periksa kembali apakah nama tabel 'jadwal' atau kolom 'isDone' sudah sesuai dengan phpMyAdmin kamu.";
    exit();
}

$jumlah_jadwal = mysqli_num_rows($result);
if ($jumlah_jadwal == 0) {
    echo "Sukses dieksekusi pada jam $jam_sekarang, tapi tidak ada jadwal skincare yang cocok atau belum selesai untuk menit ini.";
    exit();
}

while ($row = mysqli_fetch_assoc($result)) {
    $aktivitas = $row['aktivitas'];
    $keterangan = $row['keterangan'];

    $server_key = 'PASTE_SERVER_KEY_FIREBASE_KAMU'; 

    $pesan_notifikasi = [
        'to' => '/topics/all',
        'notification' => [
            'title' => 'WeeklySkin Reminder! ✨',
            'body' => 'Jam ' . $jam_sekarang . ' nih! Waktunya melakukan aktivitas: ' . $aktivitas . ' (' . $keterangan . ')',
            'sound' => 'default',
            'android_channel_id' => 'high_importance_channel'
        ]
    ];

    $headers = [
        'Authorization: key=' . $server_key,
        'Content-Type: application/json'
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($pesan_notifikasi));
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    echo "Notifikasi otomatis berhasil dikirim untuk aktivitas: $aktivitas <br>";
}
?>