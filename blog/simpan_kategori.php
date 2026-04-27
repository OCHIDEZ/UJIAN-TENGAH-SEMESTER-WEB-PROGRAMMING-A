<?php
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama_kategori'];
    $ket = $_POST['keterangan'];

    // Menggunakan Prepared Statement untuk keamanan database
    $stmt = $conn->prepare("INSERT INTO kategori_artikel (nama_kategori, keterangan) VALUES (?, ?)");
    $stmt->bind_param("ss", $nama, $ket);
    
    if ($stmt->execute()) {
        echo "sukses";
    } else {
        echo "gagal";
    }
    $stmt->close();
}
?>