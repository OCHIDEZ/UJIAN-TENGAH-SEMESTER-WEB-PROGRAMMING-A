<?php
require 'koneksi.php';
$query = "SELECT * FROM penulis ORDER BY id DESC";
$result = $conn->query($query);
$data = [];
while ($row = $result->fetch_assoc()) {
    $row['nama_depan'] = htmlspecialchars($row['nama_depan']);
    $row['nama_belakang'] = htmlspecialchars($row['nama_belakang']);
    $row['user_name'] = htmlspecialchars($row['user_name']);
    // Logika gambar default
    $row['foto_url'] = empty($row['foto']) ? 'uploads_penulis/default.png' : 'uploads_penulis/' . $row['foto'];
    $data[] = $row;
}
echo json_encode($data);