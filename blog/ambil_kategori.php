<?php
require 'koneksi.php';

$query = "SELECT * FROM kategori_artikel ORDER BY id DESC";
$result = $conn->query($query);
$data = [];

while ($row = $result->fetch_assoc()) {
    // Sanitasi output untuk mencegah serangan XSS
    $row['nama_kategori'] = htmlspecialchars($row['nama_kategori']);
    $row['keterangan'] = htmlspecialchars($row['keterangan']);
    $data[] = $row;
}

// Mengirimkan data dalam format JSON agar mudah dibaca oleh Javascript (Fetch API)
echo json_encode($data);
?>