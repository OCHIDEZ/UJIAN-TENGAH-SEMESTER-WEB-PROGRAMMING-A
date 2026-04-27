<?php
require 'koneksi.php';

$sql = "SELECT 
            artikel.id, 
            artikel.judul, 
            artikel.hari_tanggal, 
            artikel.gambar, 
            kategori_artikel.nama_kategori, 
            penulis.nama_depan 
        FROM artikel 
        LEFT JOIN kategori_artikel ON artikel.id_kategori = kategori_artikel.id 
        LEFT JOIN penulis ON artikel.id_penulis = penulis.id 
        ORDER BY artikel.id DESC";

$result = $conn->query($sql);
$data = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $row['gambar_url'] = 'uploads_artikel/' . $row['gambar'];
        $data[] = $row;
    }
}

echo json_encode($data);
