<?php
require 'koneksi.php';

$query = "SELECT * FROM kategori_artikel ORDER BY id DESC";
$result = $conn->query($query);
$data = [];

while ($row = $result->fetch_assoc()) {
    $row['nama_kategori'] = htmlspecialchars($row['nama_kategori']);
    $row['keterangan'] = htmlspecialchars($row['keterangan']);
    $data[] = $row;
}

echo json_encode($data);
?>